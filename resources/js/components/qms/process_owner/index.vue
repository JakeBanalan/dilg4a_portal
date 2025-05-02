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
                                    <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;QMS Process
                                    Owners
                                </h5>
                                <div class="d-flex">
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                        @click="OpenModal()">
                                        Add Process Owner
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="po_table" class="table table-striped table-bordered" style="width:100%;">
                                    <thead>
                                        <tr role="row">
                                            <th>Full Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th style="width: 7%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="owner in ProcessOwner" :key="owner.id">
                                            <td>{{ owner.fname }}</td>
                                            <td>{{ owner.position_title }}</td>
                                            <td>{{ owner.pmo_title }}</td>
                                            <td>{{ owner.email }}</td>
                                            <td>{{ owner.contact_details }}</td>
                                            <td>
                                                <button @click="DeleteProcessOwner(owner.emp_id)"
                                                    class="btn btn-icon mr-1"
                                                    style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                    <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                                </button>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
        <POModal :visible="modalVisible" @addprocessowner="AddProcessOwner" @close="CloseModal" />
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import POModal from './POModal.vue';
import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Pagination from '../../procurement/Pagination.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { toast } from "vue3-toastify";


import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPlus } from '@fortawesome/free-solid-svg-icons';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPlus);


export default {
    components: {
        POModal,
        axios,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
        FontAwesomeIcon
    },
    data() {
        return {
            modalVisible: false,
            ProcessOwner: [],
            UserList: [],
            data: null,
            emp_id: null
        }
    },
    created() {
        this.fetchProcessOwner()
        // this.fetchUser()
    },

    methods: {

        fetchProcessOwner() {
            axios.get('/api/fetchProcessOwner')
                .then(response => {
                    this.ProcessOwner = response.data;
                    this.initializeDataTable();
                })
                .catch(error => {
                    console.error("Error fetching process owner data:", error);
                });
        },

        initializeDataTable() {
            $('#po_table').DataTable().destroy(); // clean up
            this.$nextTick(() => {
                $('#po_table').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                });
                this.dataTableInitialized = true;

            });
        },
        OpenModal() {
            this.modalVisible = true;

        },
        CloseModal() {
            this.modalVisible = false;
        },
        DeleteProcessOwner(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/DeleteProcessOwner', {
                        id: id,
                    })
                        .then(() => {
                            Swal.fire({
                            icon: 'success',
                            title: 'Process Owner Successfully Deleted!',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        setTimeout(() => {
                            this.fetchProcessOwner()
                        }, 200);
                        })
                        .catch(error => {
                            console.error('error deleting data', error);
                        })
                }
            });

        },
        AddProcessOwner(id) {
            
            axios.post('/api/addProcessOwner', {
                id: id,
            })
                .then(() => {
                    Swal.fire({
                            icon: 'success',
                            title: 'Process Owner Successfully Added!',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        setTimeout(() => {
                            this.fetchProcessOwner()
                        }, 200);
                })
                .catch(error => {
                    console.error('error saving data', error);
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
</style>