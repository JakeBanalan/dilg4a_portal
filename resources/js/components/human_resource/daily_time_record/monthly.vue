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
                            <h5 class="card-title">Add Monthly Records</h5>
                            <form @submit.prevent="addMonthlyRecords">
                                <div class="form-group">
                                    <label for="user">Select User</label>
                                    <v-select id="user" :options="users" v-model="selectedUserId" label="name"
                                        :reduce="user => user.id" placeholder="Select a user" />
                                </div>

                                <div class="form-group">
                                    <label for="month">Select Month</label>
                                    <input type="month" v-model="selectedMonth" id="month" class="form-control" />
                                </div>
                                <div class="table-responsive"  v-if="monthlyRecords.length">
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
                                            <tr v-for="(record, index) in monthlyRecords" :key="index">
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
                                <button type="submit" class="btn btn-primary mt-3">Save Records</button>
                            </form>
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
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
    name: 'AddMonthlyRecords',
    components: { Navbar, Sidebar, FooterVue, BreadCrumbs, vSelect },
    data() {
        return {
            users: [],
            selectedUserId: null,
            selectedMonth: '',
            monthlyRecords: [],
        };
    },
    methods: {
        fetchUsers() {
            axios.get('/api/fetchAllUsers').then((response) => {
                this.users = response.data;
            });
        },
        generateMonthlyRecords() {
            if (!this.selectedMonth) return;

            const [year, month] = this.selectedMonth.split('-');
            const monthIndex = Number(month);

            const daysInMonth = new Date(year, monthIndex, 0).getDate();

            this.monthlyRecords = Array.from({ length: daysInMonth }, (_, day) => {
                const date = new Date(year, monthIndex - 1, day + 1);

                // ✅ This avoids timezone shift!
                const yyyy = date.getFullYear();
                const mm = String(date.getMonth() + 1).padStart(2, '0');
                const dd = String(date.getDate()).padStart(2, '0');
                const isoDate = `${yyyy}-${mm}-${dd}`;

                const displayDate = date.toLocaleDateString(undefined, {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    weekday: 'long',
                });

                return {
                    date: isoDate,
                    display_date: displayDate,
                    time_in_am: '',
                    time_out_am: '',
                    time_in_pm: '',
                    time_out_pm: '',
                    undertime: '',
                };
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

        addMonthlyRecords() {
            if (!this.selectedUserId || !this.monthlyRecords.length) return;
            const selectedUser = this.users.find(user => user.id === this.selectedUserId);
            const payload = {
                user_id: this.selectedUserId,
                employee_no: selectedUser.employee_no,
                records: this.monthlyRecords.map(({ display_date, ...record }) => record), // remove display_date
            };

            axios.post('/api/daily-time-records/bulk', payload).then(() => {
                alert('Records saved successfully!');
            });
        },

        sanitizeTime(time) {
            if (!time || !/^\d{2}:\d{2}(:\d{2})?$/.test(time)) {
                return null;
            }
            return time;
        },

    },
    watch: {
        selectedMonth: 'generateMonthlyRecords',
        selectedUserId(newVal) {
            if (!newVal) {
                this.selectedMonth = '';
                this.monthlyRecords = [];
            }
        },
    },
    mounted() {
        this.fetchUsers();
    },
};
</script>
