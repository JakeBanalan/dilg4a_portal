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
                                    <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;QMS Quality
                                    Procedures
                                </h5>
                                <div class="d-flex">
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                        @click="addsubmission()">
                                        Submit New Report
                                    </button>
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
                                        <tr v-for="list in QOPRList" :key="list.id">
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
                                            <td style="width: 5%;"><b v-if="list.status == 0">Draft</b> <b
                                                    v-if="list.status == 1">Submitted</b>
                                                <br><i>~{{ list.username }}~</i>
                                            </td>


                                            <td style="width:5%;">
                                                <div style="  display: flex;gap: 0.1em; justify-content: center;">
                                                    <button @click="submitReport(list.id)" class="btn btn-icon mr-1"
                                                        :disabled="list.status !== 0"
                                                        style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                        <font-awesome-icon
                                                            :icon="['fas', 'share-square']"></font-awesome-icon>
                                                    </button>
                                                    <button @click="viewReport(list.id)" class="btn btn-icon mr-1"
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

import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Pagination from '../../procurement/Pagination.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { toast } from "vue3-toastify";

import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash } from '@fortawesome/free-solid-svg-icons';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash);


export default {
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
        FontAwesomeIcon
    },
    data() {
        return {

            QOPRList: [],
            dataTableInitialized: false

        }

    },
    created() {
        this.userId = parseInt(localStorage.getItem('userId'));
        this.role = localStorage.getItem('user_role');
        // this.fetchQOPR();
    },
    mounted() {
        // Load data for specific user or all users based on role
        if (this.role === 'admin') {
            this.fetchQOPR(); // Admin sees all requests
        } else {
            this.fetchQOPRperUser(); // Non-admin sees only their own requests
        }
    },
    methods: {
        viewReport(arg) {
            let id = arg;
            console.log(arg)
            this.$router.push({ path: `/qms/reports_submission/rs_update/${id}` });

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
                    axios.post(`/api/submitReport`, {
                        id: id,
                        status: '1'
                    })
                        .then(response => {

                            Swal.fire({
                                icon: 'success',
                                title: 'Report Successfully Submitted!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                this.fetchQOPR();
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
                                this.fetchQOPR();
                            }, 200);
                        })
                        .catch(error => {
                            console.error('error saving data', error);
                        })

                }
            });


        },
        fetchQOPRperUser() {
            axios.get(`/api/fetchQOPRperUser/${this.userId}`)
                .then(response => {

                    this.QOPRList = response.data
                    // console.log(this.QOPRList)
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