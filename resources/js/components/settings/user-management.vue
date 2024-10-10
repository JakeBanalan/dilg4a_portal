<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />

                    <!-- <div class="row">

                        <div class="col-md-6">
                            <div class="card" style="max-height: 350px;">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h4><font-awesome-icon :icon="['fas', 'circle-info']"
                                                class="mr-2"></font-awesome-icon>User Account Statistics</h4>
                                    </div>
                                    <table class="table">
                                        <thead
                                            style="text-align:center; background-color: #059886; display: table; width: 100%; table-layout: fixed;">
                                            <th></th>
                                            <th>TOTAL</th>
                                        </thead>
                                        <tbody class="sbnone" style="display: block; height: 200px; overflow: auto;">
                                            <tr style="display: table; width: 100%; table-layout: fixed;">
                                                <td>Regional Office</td>
                                                <td>2</td>
                                            </tr>
                                            <tr style="display: table; width: 100%; table-layout: fixed;">

                                                <td>Cavite</td>
                                                <td>2</td>
                                            </tr>
                                            <tr style="display: table; width: 100%; table-layout: fixed;">

                                                <td>Laguna</td>
                                                <td>2</td>
                                            </tr>
                                            <tr style="display: table; width: 100%; table-layout: fixed;">

                                                <td>Batangas</td>
                                                <td>2</td>
                                            </tr>
                                            <tr style="display: table; width: 100%; table-layout: fixed;">

                                                <td>Rizal</td>
                                                <td>2</td>
                                            </tr>
                                            <tr style="display: table; width: 100%; table-layout: fixed;">

                                                <td>Quezon</td>
                                                <td>2</td>
                                            </tr>
                                            <tr style="display: table; width: 100%; table-layout: fixed;">

                                                <td>Lucena City</td>
                                                <td>2</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card" style="max-height: 350px;">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h4><font-awesome-icon :icon="['fas', 'circle-info']"
                                                class="mr-2"></font-awesome-icon>Information</h4>
                                    </div>
                                    <table class="table">
                                        <thead style="background-color: #059886;">
                                            <th></th>
                                            <th>TOTAL</th>
                                        </thead>
                                        <tbody class="sbnone">
                                            <tr>
                                                <td>Total No. of Female Employees</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <td>Total No. of Male Employees</td>
                                                <td>1</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div> -->

                    <!--Search Filter-->
                    <div class="row">
                        <div class="col-md-12 pt-4">
                            <div class="card" v-if="isCardVisible">
                                <div class="card-body">
                                    <h4 class="card-title">Search Filter</h4>
                                    <form class="form-sample">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>Office:</label>
                                                        <multiselect :options="options2" label="label" :multiple="false"
                                                            :searchable="false"> </multiselect>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>Employee ID No.:</label>
                                                        <div id="the-basics">
                                                            <input class="typeahead" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>Name:</label>
                                                        <div id="the-basics1">
                                                            <input class="typeahead" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>Age Category:</label>
                                                        <multiselect :options="options3" label="label" :multiple="false"
                                                            :searchable="false"> </multiselect>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>Civil Status:</label>

                                                        <multiselect :options="options4" label="label" :multiple="false"
                                                            :searchable="false"> </multiselect>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>With Health Issues:</label>

                                                        <multiselect :options="options5" label="label" :multiple="false"
                                                            :searchable="false"> </multiselect>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>Gender:</label>

                                                        <multiselect :options="options6" label="label" :multiple="false"
                                                            :searchable="false"> </multiselect>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>PWD:</label>

                                                        <multiselect :options="options7" label="label" :multiple="false"
                                                            :searchable="false"> </multiselect>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <label>Are you a Solo Parent:</label>

                                                        <multiselect :options="options8" label="label" :multiple="false"
                                                            :searchable="false"> </multiselect>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-outline-primary btn-icon-text btn-sm"><i
                                                class="ti-filter"></i> Filter </button>&nbsp
                                        <button class="btn btn-outline-dark btn-icon-text btn-sm"><i
                                                class="ti-reload"></i>
                                            Clear</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 pt-4">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                        @click="toggleCard()" style="float:right;">
                                        Advanced Search
                                    </button> -->
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                        @click="createUser()" style="float:right; margin-bottom:10px;">
                                        Create User
                                    </button>
                                    <div class="table-responsive">
                                        <!-- <user_table /> -->
                                        <table id="employee_table"
                                            class="table table-striped table-borderless display expandable-table dataTable no-footer"
                                            role="grid">
                                            <thead>
                                                <tr role="row">
                                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1"
                                                        aria-label="Quote#" style="width: 10px; text-align: center;">
                                                        Employee ID</th>
                                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1"
                                                        aria-label="Quote#" style="width: 10px; text-align: center;">
                                                        Province/HUC</th>
                                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1"
                                                        aria-label="Quote#" style="width: 10px; text-align: center;">
                                                        City/Municipality</th>
                                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1"
                                                        aria-label="Quote#" style="width: 10px; text-align: center;">
                                                        Full Name</th>
                                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1"
                                                        aria-label="Quote#" style="width: 10px; text-align: center;">
                                                        Username</th>
                                                    <!-- <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#"
                style="width: 10px; text-align: center;">Email</th> -->
                                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1"
                                                        aria-label="Quote#" style="width: 10px; text-align: center;">
                                                        Contact Number</th>
                                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1"
                                                        aria-label="Quote#" style="width: 10px; text-align: center;">
                                                        action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="ed in EmpTableData" :key="ed.id">
                                                    <td>{{ ed.employee_no }}</td>
                                                    <td>{{ ed.province }}</td>
                                                    <td>{{ ed.citymun }}</td>
                                                    <td>{{ ed.name }}</td>
                                                    <td>{{ ed.username }}</td>
                                                    <td>{{ ed.contact_details }}</td>
                                                    <td> 
                                                        <button @click="UpdateUser(ed.id)" class="btn btn-icon mr-1"
                                                            style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div> <!-- content-wrapper -->
                <FooterVue />
            </div>
            <!-- partial-->
        </div>
    </div>
</template>
<style>
@import "~vue-select/dist/vue-select.css";

/* tbody {
    display: block;
    height: 200px;
    overflow: auto;
}

thead,
tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
} */

.sbnone::-webkit-scrollbar {
    display: none;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<script>
import Multiselect from 'vue-multiselect';
import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import user_table from './user_table.vue';


import axios from 'axios'; // Import axios library to make HTTP requests
// import employee_table from './app_table.vue';

export default {
    name: 'User Management',
    components: {
        user_table,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Multiselect,
        // employee_table, //Table
    },

    data() {
        return {
            isCardVisible: false,
            EmpTableData: [],
            dataTableInitialized: false,
            options: [
                { label: 'All', value: 'All' },
                { label: 'Batangas', value: 'Batangas' },
                { label: 'Cavite', value: 'Cavite' },
                { label: 'Laguna', value: 'Laguna' },
                { label: 'Rizal', value: 'Rizal' },
                { label: 'Quezon', value: 'Quezon' },
                { label: 'Lucena City', value: 'Lucena City' }
            ],

            options2: [
                { label: 'All', value: 'option1' },
                { label: 'Batangas', value: 'option2' },
                { label: 'Cavite', value: 'option3' },
                { label: 'Laguna', value: 'option4' },
                { label: 'Lucena City', value: 'option5' },
                { label: 'Quezon', value: 'option6' },
                { label: 'Rizal', value: 'option7' }, // Options For Office
            ],

            options3: [
                { label: 'All', value: 'option1' },
                { label: '18-24', value: 'option2' },
                { label: '25-34', value: 'option3' },
                { label: '35-44', value: 'option4' },
                { label: '45-54', value: 'option5' },
                { label: '65 and Over', value: 'option6' }, // Options For Age Category
            ],

            options4: [
                { label: 'All', value: 'option1' },
                { label: 'Married', value: 'option2' },
                { label: 'Single', value: 'option3' },
                { label: 'Widow', value: 'option4' },
                { label: 'Seperated', value: 'option5' },// Options For Civil Status
            ],

            options5: [
                { label: 'Yes', value: 'option1' },
                { label: 'None', value: 'option2' },// Options For Health Issues
            ],

            options6: [
                { label: 'Male', value: 'option1' },
                { label: 'Female', value: 'option2' },// Options For Gender
            ],

            options7: [
                { label: 'Yes', value: 'option1' },
                { label: 'No', value: 'option2' },// Options For PWD
            ],

            options8: [
                { label: 'Yes', value: 'option1' },
                { label: 'No', value: 'option2' },// Options For Solo Parent
            ],

            searchText: '',
            users: [], // Initialize an empty array to store user data
        };
    },
    mounted() {
        this.fetchEmployeeData();
        // this.fetchUserOfficeCount();
    },
    methods: {
        fetchUserOfficeCount() {
            axios.get('../../api/fetchUserOfficeCount')
                .then(response => {
                    console.log(response.data)
                })
                .catch((error) => {
                    console.error('Error fetching employee data:', error);
                });
        },
        createUser() {
            this.$router.push({ path: `/settings/create` });
        },
        UpdateUser(id) {
            this.$router.push({ path: `/settings/update/${id}` });
        },
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
        },
        fetchEmployeeData() {
            const vm = this; // Save Vue instance context
            axios.get('../../api/fetchEmployeeData')
                .then((response) => {
                    this.EmpTableData = response.data;
                    this.initializeDataTable();
                    console.log(response.data)

                })
                .catch((error) => {
                    console.error('Error fetching employee data:', error);
                });
        },
        initializeDataTable() {
            this.$nextTick(() => {
                if (!this.dataTableInitialized) {
                    $('#employee_table').DataTable({
                        retrieve: true,
                        ordering: true,
                        paging: true,
                        pageLength: 20,
                        bLengthChange: false,
                        bInfo: false,
                    });
                    this.dataTableInitialized = true;
                } else {
                    $('#employee_table').DataTable().clear().rows.add(this.EmpTableData).draw();
                }
            });
        },
    },

}
</script>