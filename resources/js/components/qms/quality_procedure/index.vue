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
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2" @click="addQP()">
                                        Add Quality Procedure
                                    </button>
                                </div>
                            </div>
                            <div class="table">
                                <table id="qp_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr role="row">
                                            <th>FREQUENCY</th>
                                            <th>QP CODE</th>
                                            <th>PROCEDURE TITLE</th>
                                            <th>PROCESS OWNER</th>
                                            <th>OFFICE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="qp in QualityProcedure" :key="qp.id">
                                            <td style=" width:5%; overflow-wrap: initial; white-space: normal;">
                                                {{ qp.frequency_monitoring }}</td>
                                            <td style="width: 10%;">{{ qp.qp_code }}</td>
                                            <td
                                                style=" word-break: break-word; overflow-wrap: break-word; white-space: normal;">
                                                {{ qp.procedure_title }}</td>
                                            <td
                                                style=" width:10%; word-break: break-word; overflow-wrap: break-word; white-space: normal;">

                                                {{ qp.process_owner }}</td>
                                            <td style="width:7.5%;">{{ qp.office }}</td>
                                            <td style="width:5%;">
                                                <div style="  display: flex;gap: 0.1em; justify-content: center;">
                                                    <button @click="viewQP(qp.id)" class="btn btn-icon mr-1"
                                                        style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                        <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                                    </button>
                                                    <button @click="deleteQualityProcedure(qp.id)"
                                                        class="btn btn-icon mr-1"
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
import qp_entry from './qp_entry.vue';
import { toast } from "vue3-toastify";

import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash } from '@fortawesome/free-solid-svg-icons';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash);


export default {
    components: {
        qp_entry,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
        FontAwesomeIcon
    },
    data() {
        return {
            is_new: null,
            ProcessOwner: [],
            QualityProcedure: [],
            form: {
                RevNo: '',
                EffDate: '',
                DateCreated: '',
                CreatedBy: '',
                QPCode: '',
                ProcedureTitle: ''
            },
        }
    },
    created() {
        this.fetchProcessOwner();
        this.fetchQualityProcedure();

    },
    methods: {
        addQP() {
            this.$router.push({ path: '/qms/quality_procedure/qp_entry' });
        },
        fetchProcessOwner() {
            axios.get('/api/fetchProcessOwner')
                .then(response => {
                    this.ProcessOwner = response.data
                    // console.log(this.ProcessOwner)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error);
                });
        },
        fetchQualityProcedure() {
            axios.get('/api/fetchQualityProcedure1')
                .then(response => {
                    this.QualityProcedure = response.data;
                    this.initializeDataTable();
                })
                .catch(error => {
                    console.error('Error Fetching items:', error);
                });
        },
        initializeDataTable() {
            $('#qp_table').DataTable().destroy(); // clean up
            this.$nextTick(() => {
                $('#qp_table').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                });
            });
        },
        viewQP(id) {
            this.$router.push({ path: `/qms/quality_procedure/qp_update/${id}` });
        },
        deleteQualityProcedure(id) {
            // console.log(id)
            // let qop_id = this.$route.params.id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/deleteQualityProcedure', {
                        id: id
                    })
                    .then(() => {
                            Swal.fire({
                            icon: 'success',
                            title: 'Quality Procedure Successfully Deleted!',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        setTimeout(() => {
                            this.fetchQualityProcedure();
                        }, 200);
                        })
                        .catch(error => {
                            console.error('error saving data', error);
                        })
                }
            });




        }
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
</style>