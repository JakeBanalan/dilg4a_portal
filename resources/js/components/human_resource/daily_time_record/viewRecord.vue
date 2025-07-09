<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">View and Update Records</h5>
                            <div class="col-mb-3" style="display: flex; float: right; justify-content: flex-end;">
                                <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                    :disabled="!records.length || !selectedMonth" @click="generateUserDTR">
                                    Generate DTR
                                </button>

                            </div>
                            <div v-if="user">
                                <h6>User: <span style="font-weight: 600; font-size: 12pt;">{{ user.name }}</span></h6>
                                <h6>Employee No: <span style="font-weight: 600; font-size: 12pt;">{{ user.employee_no
                                        }}</span></h6>
                            </div>
                            &nbsp;

                            <div class="form-group mb-3">
                                <label>Select Month</label>
                                <input type="month" v-model="selectedMonth" @change="onMonthChange"
                                    class="form-control" />
                            </div>

                            <div class="table-responsive" v-if="records.length">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time In (AM)</th>
                                            <th>Time Out (AM)</th>
                                            <th>Time In (PM)</th>
                                            <th>Time Out (PM)</th>
                                            <th>Undertime</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(record, index) in records" :key="index">
                                            <td>{{ record.display_date }}</td>
                                            <td>
                                                <input type="time" step="1" v-model="record.time_in_am"
                                                    class="form-control" @change="calculateUndertime(record)" />

                                            </td>
                                            <td>
                                                <input type="time" step="1" v-model="record.time_out_am"
                                                    class="form-control" @change="calculateUndertime(record)" />
                                            </td>
                                            <td>
                                                <input type="time" step="1" v-model="record.time_in_pm"
                                                    class="form-control" @change="calculateUndertime(record)" />
                                            </td>
                                            <td>
                                                <input type="time" step="1" v-model="record.time_out_pm"
                                                    class="form-control" @change="calculateUndertime(record)" />
                                            </td>
                                            <td>
                                                <input type="text" v-model="record.undertime" class="form-control"
                                                    readonly />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button class="btn btn-primary mt-3" @click="updateRecords" :disabled="!records.length">
                                Update Records
                            </button>

                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import axios from "axios";

export default {
    name: 'ViewMonthlyRecords',
    components: { Navbar, Sidebar, FooterVue, BreadCrumbs },
    data() {
        return {
            user: null,
            records: [],
            selectedMonth: '',
        };
    },
    methods: {
        fetchUserRecords() {
            const userId = this.$route.params.userId;

            if (!userId || !this.selectedMonth) {
                return;
            }

            axios
                .get(`/api/daily-time-records/user/${userId}?month=${this.selectedMonth}`)
                .then((response) => {
                    this.user = response.data.user;
                    this.records = response.data.records.map((record) => {
                        const [year, month, day] = record.date.split('-');
                        const date = new Date(year, month - 1, day); // month is 0-based
                        const displayDate = date.toLocaleDateString(undefined, {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            weekday: 'long',
                        });
                        return {
                            ...record,
                            display_date: displayDate,
                        };
                    });

                })
                .catch((error) => {
                    console.error("Error fetching user records:", error.response || error);
                });
        },

        calculateUndertime(record) {
            function timeToSeconds(timeStr) {
                if (!timeStr) return null;
                const [h, m, s] = timeStr.split(':').map(Number);
                return (h * 3600) + (m * 60) + (s || 0);
            }

            // Standard: 8:00 AM to 5:00 PM (9 hrs * 3600) = 32,400 sec
            const schedInAM = 8 * 3600;   // 8:00 AM
            const schedOutPM = 17 * 3600; // 5:00 PM

            const inAM = timeToSeconds(record.time_in_am);
            const outPM = timeToSeconds(record.time_out_pm);

            if (inAM === null || outPM === null) {
                record.undertime = '480m'; // fallback max
                return;
            }

            const flexOffset = schedInAM - inAM;
            const expectedOutPM = schedOutPM - flexOffset;

            let undertimeSec = 0;
            if (outPM < expectedOutPM) {
                undertimeSec = expectedOutPM - outPM;
            }

            const hrs = Math.floor(undertimeSec / 3600);
            const mins = Math.floor((undertimeSec % 3600) / 60);
            record.undertime = undertimeSec <= 0 ? ' ' : `${hrs ? hrs + 'h ' : ''}${mins}m`;
        },

        updateRecords() {
            const userId = this.$route.params.userId;

            const payload = this.records
                .filter(record => record.id)
                .map(({ id, time_in_am, time_out_am, time_in_pm, time_out_pm, remarks, undertime }) => {
                    const obj = { id };

                    obj.time_in_am = this.sanitizeTime(time_in_am);
                    obj.time_out_am = this.sanitizeTime(time_out_am);
                    obj.time_in_pm = this.sanitizeTime(time_in_pm);
                    obj.time_out_pm = this.sanitizeTime(time_out_pm);
                    obj.remarks = remarks ? remarks : null;
                    obj.undertime = undertime || null;


                    return obj;
                });


            axios.put(`/api/daily-time-records/user/${userId}`, { records: payload })
                .then(() => {
                    alert("Records updated successfully!");
                })
                .catch((error) => {
                    console.error("Failed to update records:", error.response?.data || error);
                    alert("Failed to update records.");
                });
        },
        generateUserDTR() {
            const userId = this.$route.params.userId;

            if (!userId || !this.selectedMonth) {
                alert("Please select a month first.");
                return;
            }

            const [yearStr, monthStr] = this.selectedMonth.split("-");
            const month = parseInt(monthStr, 10);
            const year = parseInt(yearStr, 10);

            axios
                .get(`/api/daily-time-records/export-user/${userId}`, {
                    params: { month, year },
                    responseType: "blob",
                })
                .then((response) => {
                    const disposition = response.headers['content-disposition'];
                    let filename = `DTR_${this.user.name.replace(/\s+/g, '_')}_${year}_${month}.xlsx`;
                    if (disposition && disposition.indexOf('filename=') !== -1) {
                        filename = disposition.split('filename=')[1].replace(/["']/g, '');
                    }
                    const blob = new Blob([response.data], {
                        type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    });
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", filename);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((error) => {
                    console.error("Failed to generate DTR:", error.response || error);
                    alert("Failed to generate DTR.");
                });
        },
        sanitizeTime(time) {
            if (!time || !/^\d{2}:\d{2}(:\d{2})?$/.test(time)) {
                return null;
            }
            return time;
        },
        onMonthChange() {
            if (!this.selectedMonth) {
                // If cleared, reset table data
                this.records = [];
                this.user = null;
                return;
            }

            this.fetchUserRecords();
        },

    }
};
</script>
