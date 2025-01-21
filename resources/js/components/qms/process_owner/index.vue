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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr v-for="owner in ProcessOwner" :key="owner.id">
                                            <td>{{ owner.fname }}</td>
                                            <td>{{ owner.position_title }}</td>
                                            <td>{{ owner.pmo_title }}</td>
                                            <td>{{ owner.email }}</td>
                                            <td>{{ owner.contact_details }}</td>
                                            <td>
                                                <button class="btn btn-icon mr-1"
                                                    style="background-color:#059886;color:#fff;"
                                                    @click="DeleteProcessOwner(owner.emp_id)">
                                                    <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                                </button>
                                            </td>

                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
        <POModal 
        :visible="modalVisible" 
        @addprocessowner="AddProcessOwner" 
        @close="CloseModal" />
    </div>
</template>

<script>
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
                // console.log(response.data);
                const vm = this; // Save Vue instance context
                let table = $('#po_table').DataTable({
                    retrieve: true,
                    data: response.data,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                    columns: [
                        { data: 'fname' },
                        { data: 'position_title' },
                        { data: 'pmo_title' },
                        { data: 'email' },
                        { data: 'contact_details' },
                        {
                            data: null, orderable: false, render: function (data) {
                                return '<button class="btn btn-danger btn-fw btn-icon-text mx-2" data-id="' + data.emp_id + '">Delete</button>';
                            },
                        },
                    ],
                });

                // Clear and destroy the DataTable before reinitializing it
                table.clear().destroy();

                // Reinitialize DataTable with new data
                table = $('#po_table').DataTable({
                    data: response.data,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                    columns: [
                        { data: 'fname' },
                        { data: 'position_title' },
                        { data: 'pmo_title' },
                        { data: 'email' },
                        { data: 'contact_details' },
                        {
                            data: null, orderable: false, render: function (data) {
                                return '<button class="btn btn-danger btn-fw btn-icon-text mx-2" data-id="' + data.emp_id + '">Delete</button>';
                            },
                        },
                    ],
                });

                // Attach event listener to dynamically created buttons
                $('#po_table tbody').on('click', 'button', function () {
                    const empId = $(this).data('id');
                    vm.DeleteProcessOwner(empId);
                });
            })
            .catch(error => {
                console.error("There was an error fetching the process owner data:", error);
            });
    },
        // fetchUser() {

        //     axios.get('/api/fetchAllUser').then((response) => {
        //         console.log(response)
        //         this.UserList = response.data
        //         // $('#user_table').DataTable({
        //         //     retrieve: true,
        //         //     data: response.data,
        //         //     ordering: false,
        //         //     paging: true,
        //         //     pageLength: 10,

        //         //     columns: [
        //         //         { data: 'pmo_title' },
        //         //         { data: 'fname' },
        //         //         { data: 'position_title' },
        //         //         { data: 'pmo_title' },
        //         //     ],

        //         // });
        //     }).catch((error) => console.log(error));
        // },
        OpenModal() {
            this.modalVisible = true;

        },
        CloseModal() {
            this.modalVisible = false;
        },
        DeleteProcessOwner(id) {
            axios.post('/api/DeleteProcessOwner', {
                id: id,
            })
                .then(() => {
                    toast.success('Process Owner Successfully Deleted!', {
                        autoClose: 1000
                    });
                    setTimeout(() => {
                        this.fetchProcessOwner()
                        this.fetchUser()
                    }, 200);
              
                })
                .catch(error => {
                    console.error('error saving data', error);
                })
        },
        AddProcessOwner(id) {
            axios.post('/api/addProcessOwner', {
                id: id,
            })
                .then(() => {
                    toast.success('Process Owner Successfully Added!', {
                        autoClose: 300
                    });
                    this.fetchProcessOwner();
                    // this.fetchUser();
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