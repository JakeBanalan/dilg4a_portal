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
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;QMS Provincial
                                    Report Submission
                                </h5>
                                <div class="d-flex">
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                        @click="addsubmission()">
                                        Submit New Report
                                    </button>
                                    <button type="button" class="btn btn-primary btn-fw btn-icon-text mx-2"
                                        @click="toggleSearch">
                                        <font-awesome-icon :icon="['fas', 'magnifying-glass']"></font-awesome-icon>
                                        Advanced Search
                                    </button>
                                </div>
                            </div>

                            <!-- Advanced Search Form -->
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <!-- <div> -->
                                <div v-if="searchVisible">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label style="font-size: 0.875rem;">QP Code:</label>
                                            <input type="text" v-model="filteredParams.qp_code" class="form-control"
                                                placeholder="QP Code" style="margin-bottom: 2%;">
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size: 0.875rem;">Procedure Title:</label>
                                            <input type="text" v-model="filteredParams.procedure_title"
                                                class="form-control" placeholder="Procedure Title"
                                                style="margin-bottom: 2%;">

                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size: 0.875rem;">Process Owner:</label>
                                            <input type="text" v-model="filteredParams.process_owner"
                                                class="form-control" placeholder="Process Owner"
                                                style="margin-bottom: 2%;">

                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size: 0.875rem;">Frequency:</label>
                                            <Multiselect @update:modelValue="periodOptions" :options="FrequencyOption"
                                                v-model="filteredParams.frequency_monitoring" track-by="value"
                                                :multiple="false" label="label" :searchable="false"
                                                id="frequency_monitoring" placeholder="Frequency"
                                                style="margin-bottom: 2%;">
                                            </Multiselect>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label style="font-size: 0.875rem;">Office:</label>
                                            <input type="text" v-model="filteredParams.office" class="form-control"
                                                placeholder="Office">
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size: 0.875rem;">Status:</label>
                                            <Multiselect :options="statusOptions" v-model="filteredParams.status"
                                                track-by="value" :multiple="false" label="label" :searchable="false"
                                                id="status" placeholder="Status" style="margin-bottom: 2%;">
                                            </Multiselect>

                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size: 0.875rem;">Year:</label>
                                            <input type="text" v-model="filteredParams.year" class="form-control"
                                                placeholder="Year">
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size: 0.875rem;">Period Covered:</label>
                                            <Multiselect :options="period_covered"
                                                v-model="filteredParams.period_covered" track-by="value"
                                                :multiple="false" label="label" :searchable="false" id="period_covered"
                                                placeholder="Period" style="margin-bottom: 2%;">
                                            </Multiselect>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12" style="text-align: right;">
                                            <button type="button" class="btn btn-primary btn-icon-text"
                                                @click="applySearch">
                                                <font-awesome-icon
                                                    :icon="['fas', 'magnifying-glass']"></font-awesome-icon>
                                                Search</button>
                                            <button type="button" class="btn btn-secondary btn-icon-text mx-2"
                                                @click="resetSearch">
                                                <font-awesome-icon :icon="['fas', 'rotate']"></font-awesome-icon>
                                                Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="table1">
                                <table id="rs_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr role="row">
                                            <th>QP CODE</th>
                                            <th>FREQUENCY</th>
                                            <th>PROCEDURE TITLE</th>
                                            <th>PROCESS OWNER</th>
                                            <th>OFFICE</th>
                                            <th>PERIOD COVERED</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="list in filteredQOPRList" :key="list.id">
                                            <td style="width: 5%;">{{ list.qp_code }}</td>
                                            <td style="width: 5%;" class="ellipsis"> {{ list.frequency_monitoring }}
                                            </td>
                                            <td
                                                style=" word-break: break-word; overflow-wrap: break-word; white-space: normal;">
                                                {{ list.procedure_title }}</td>
                                            <td style="width: 5%;" class="ellipsis">{{ list.process_owner }}</td>
                                            <td style="width: 5%;">{{ list.office }}</td>
                                            <td style="width: 5%;"><b>{{ list.qp_covered }}</b><br><i>~{{ list.year
                                                    }}~</i></td>
                                            <td style="width: 5%;">
                                                <b>{{ statusMap[list.status] }}</b>
                                                <br><i>~{{ list.uname }}~</i>
                                            </td>

                                            <td v-if="this.isUserProcessOwner === true" style="width:5%;">
                                                <div style="  display: flex;gap: 0.1em; justify-content: center;">
                                                    <button
                                                        @click="viewReport(list.id, list.pmo_id, this.isUserProcessOwner)"
                                                        class="btn btn-icon mr-1"
                                                        style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                        <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                                    </button>
                                                    <button @click="deleteReport(list.id)" class="btn btn-icon mr-1"
                                                        :disabled="list.status !== 0"
                                                        style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                        <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                                    </button>
                                                </div>
                                            </td>

                                            <td v-if="this.isUserProcessOwner === false" style="width:5%;">
                                                <div style="  display: flex;gap: 0.1em; justify-content: center;">
                                                    <button @click="submitReport(list.id)" class="btn btn-icon mr-1"
                                                        :disabled="!(list.status === 0 || list.status === 3)"
                                                        style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                        <font-awesome-icon
                                                            :icon="['fas', 'share-square']"></font-awesome-icon>
                                                    </button>
                                                    <button @click="viewReport(list.id, list.pmo_id)"
                                                        class="btn btn-icon mr-1"
                                                        style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                        <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                                    </button>
                                                    <button @click="deleteReport(list.id)" class="btn btn-icon mr-1"
                                                        :disabled="list.status !== 0"
                                                        style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                        <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <!-- <Pagination :total="ict_data.length" @pageChange="onPageChange" /> -->


                </div>
                <FooterVue />
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Pagination from '../../procurement/Pagination.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { toast } from "vue3-toastify";

import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faCheck } from '@fortawesome/free-solid-svg-icons';
import { list } from 'postcss';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faCheck);


export default {
    components: {
        Multiselect,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
        FontAwesomeIcon
    },
    data() {
        return {
            statusMap: {
                0: 'Draft',
                1: 'Submitted',
                2: 'Received',
                3: 'Returned',
                4: 'Completed'
            },
            QOPRList: [],
            isUserProcessOwner: false,
            fetchParentProcessOwner: [],
            dataTableInitialized: false,
            filteredParams: {
                qp_code: '',
                procedure_title: '',
                process_owner: '',
                frequency_monitoring: null,
                office: '',
                status: null,
                year: '',
                period_covered: null
            },
            searchVisible: false,
            period_covered: [],
            filteredQOPRList: [],
            FrequencyOption: [
                { label: 'Monthly', value: 'Monthly' },
                { label: 'Quarterly', value: 'Quarterly' },
            ],
            MonthlyOptions: [
                { label: 'January', value: 'January' },
                { label: 'February', value: 'February' },
                { label: 'March', value: 'March' },
                { label: 'April', value: 'April' },
                { label: 'May', value: 'May' },
                { label: 'June', value: 'June' },
                { label: 'July', value: 'July' },
                { label: 'August', value: 'August' },
                { label: 'September', value: 'September' },
                { label: 'October', value: 'October' },
                { label: 'November', value: 'November' },
                { label: 'December', value: 'December' },
            ],
            QuarterOptions: [
                { label: '1st Quarter', value: '1st Quarter' },
                { label: '2nd Quarter', value: '2nd Quarter' },
                { label: '3rd Quarter', value: '3rd Quarter' },
                { label: '4th Quarter', value: '4th Quarter' },
            ],
            statusOptions: [
                { label: 'Draft', value: 0 },
                { label: 'Submitted', value: 1 },
                { label: 'Received', value: 2 },
                { label: 'Returned', value: 3 },
                { label: 'Completed', value: 4 }
            ],

        }

    },
    created() {
        this.userId = parseInt(localStorage.getItem('userId'));
        this.role = localStorage.getItem('user_role');
        // this.fetchQOPR();
    },
    mounted() {
        this.refreshQOPRTable();
    },
    methods: {
        refreshQOPRTable() {
            if (this.role === 'admin') {
                this.fetchQOPR(); // Admin sees all requests
            } else {
                this.fetchQOPRperDivision(); // Non-admin sees only their own requests
            }
        },
        toggleSearch() {
            this.searchVisible = !this.searchVisible;
        },
        applySearch() {
            if ($.fn.DataTable.isDataTable('#rs_table')) {
                $('#rs_table').DataTable().destroy(); // Destroy before filtering
            }

            this.filteredQOPRList = this.QOPRList.filter(item => {
                return (
                    (!this.filteredParams.qp_code || item.qp_code?.toLowerCase().includes(this.filteredParams.qp_code.toLowerCase())) &&
                    (!this.filteredParams.procedure_title || item.procedure_title?.toLowerCase().includes(this.filteredParams.procedure_title.toLowerCase())) &&
                    (!this.filteredParams.process_owner || item.process_owner?.toLowerCase().includes(this.filteredParams.process_owner.toLowerCase())) &&
                    (!this.filteredParams.frequency_monitoring ||
                        (this.filteredParams.frequency_monitoring.value === 'Quarterly'
                            ? item.frequency_monitoring.includes('Quarterly')
                            : item.frequency_monitoring === this.filteredParams.frequency_monitoring.value)
                    ) &&
                    (!this.filteredParams.office || item.office?.toLowerCase().includes(this.filteredParams.office.toLowerCase())) &&
                    (!this.filteredParams.status?.value || item.status === this.filteredParams.status.value) &&
                    (!this.filteredParams.year || item.year?.toString().includes(this.filteredParams.year)) &&
                    (!this.filteredParams.period_covered?.value || item.qp_covered === this.filteredParams.period_covered?.value)
                );
            });

            this.$nextTick(() => {
                $('#rs_table').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                    searching: false, // keep this false if you are not using built-in search
                    lengthChange: false
                });
            });

        },
        resetSearch() {
            if ($.fn.DataTable.isDataTable('#rs_table')) {
                $('#rs_table').DataTable().destroy(); // Destroy before filtering
            }

            this.filteredParams = {
                qp_code: '',
                procedure_title: '',
                process_owner: '',
                frequency_monitoring: null,
                office: '',
                status: null,
                year: '',
                period_covered: null
            };

            this.periodOptions(null);  // make sure this clears period_covered options correctly

            this.filteredQOPRList = [...this.QOPRList];  // assign a new array copy

            this.$nextTick(() => {
                $('#rs_table').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                    searching: false,
                    lengthChange: false
                });
            });
        },
        periodOptions(f) {
            this.filteredParams.period_covered = '';
            if (!f || !f.value) {
                this.period_covered = [];
                return;
            }

            if (f.value === 'Monthly') {
                this.period_covered = this.MonthlyOptions;
            } else if (f.value === 'Quarterly') {
                this.period_covered = this.QuarterOptions;
            } else {
                this.period_covered = [];
            }
        },
        viewReport(id, pmo_id, isUserProcessOwner = false) {
            this.$router.push({ path: `/qms/reports_submission/rs_update/${id}`,
                query: {
                    Auth: isUserProcessOwner 
                }
             });

        },
        submitReport(arg) {
            Swal.fire({
                title: 'Submit Report?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {

                    let id = arg;
                    const userId = localStorage.getItem('userId');
                    axios.post(`/api/submitReport`, {
                        id: id,
                        status: '1',
                        userId: userId,
                    })
                        .then(response => {

                            Swal.fire({
                                icon: 'success',
                                title: 'Report Successfully Submitted!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                // this.fetchQOPR();
                                // this.fetchQOPRperDivision();
                                this.refreshQOPRTable();

                            }, 200);
                        })
                        .catch(error => {
                            console.error('Error Submitting report:', error)
                        })

                }
            });


        },
        addsubmission() {
            this.$router.push({ path: '/qms/reports_submission/rs_entry' });
        },
        deleteReport(arg) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/deleteRS', {
                        id: arg,
                    })
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Report Successfully Deleted!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                this.refreshQOPRTable();
                                // this.fetchQOPR();
                                // this.fetchQOPRperDivision();
                            }, 200);
                        })
                        .catch(error => {
                            console.error('error saving data', error);
                        })

                }
            });


        },
        fetchQOPRperDivision() {
            axios.get(`/api/fetchQOPRperProvince/${this.userId}`)
                .then(response => {
                    // console.log(response.data)
                    this.QOPRList = response.data.qop_reports
                    this.filteredQOPRList = this.QOPRList;
                    this.fetchParentProcessOwner = response.data.matched_users || [];
                    // console.log('Filtered QOPR List:', this.filteredQOPRList);


                    // this.fetchProcessOwner();
                    const userId = localStorage.getItem('userId');
                    const ownerIds = this.fetchParentProcessOwner.map(owner => owner.id);
                    const isProcessOwner = ownerIds.includes(parseInt(userId));
                    if (!isProcessOwner) {
                        this.isUserProcessOwner = false;
                    } else {
                        this.isUserProcessOwner = true;
                    }

                    this.initializeDataTable();

                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        fetchQOPR() {
            axios.get('/api/fetchQOPR')
                .then(response => {
                    this.QOPRList = response.data
                    this.filteredQOPRList = this.QOPRList;

                    this.initializeDataTable();

                    // console.log(this.QOPRList)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        initializeDataTable() {

            $('#rs_table').DataTable().destroy(); // clean up
            this.$nextTick(() => {
                $('#rs_table').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                    searching: false,
                    lengthChange: false,
                });
                this.dataTableInitialized = true;

            });
        },
    }

};
</script>

<style>
td {
    text-align: center;
}

th {
    text-align: center;
}

.ellipsis {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 80px;
    /* Adjust the width as needed */
}

.table1 {
    width: 100%;
    overflow-x: auto;
}
</style>