<style>
.table-wrapper {
    overflow-x: auto;
}

.stretch-card0>.card {
    height: 60%;
}

.stretch-card2>.card {
    width: 100%;
    min-width: 100%;
    height: 60%;
    font-family: 'century gothic';
}

.stretch-card3>.card {
    width: 100%;
    min-width: 100%;
    height: 60%;
    font-family: 'century gothic';
}

.card-body2 {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem;
    font-family: 'century gothic';
}

.card-title2 {
    background-color: #059886;
}

.grid-margin2 {
    margin-bottom: -10.5rem;
}

.search-select {
    position: relative;
}

.search-select input[type="text"] {
    width: 100%;
    box-sizing: border-box;
    padding: 8px;
}

.search-select select {
    width: 100%;
    box-sizing: border-box;
    padding: 8px;
    position: absolute;
    top: 100%;
    left: 0;

}

.table-responsive-custom {
    display: block;
    -webkit-overflow-scrolling: touch;
}

.box-tools {
    position: absolute;
    right: 20px;
    top: 10px;
}

.cb {
    font-family: 'century gothic';
}
</style>
<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-4 grid-margin2 stretch-card0">
                            <div class="card">
                                <div class="card-body2 ">
                                    <h4 class="card-title">User Accounts Statistics</h4>
                                </div>
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr class="card-title2">
                                                <th> </th>
                                                <th> </th>
                                                <th class="cb">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table-wrapper">
                                    <table class="table">
                                        <thead>
                                            <tr class="card-title2">
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="cb">Region</td>
                                                <td><label class="badge badge-outline-primary">113</label></td>
                                            </tr>
                                            <tr>
                                                <td class="cb">Cavite</td>
                                                <td><label class="badge badge-outline-primary">71</label></td>
                                            </tr>
                                            <tr>
                                                <td class="cb">Laguna</td>
                                                <td><label class="badge badge-outline-primary">67</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="cb">Batangas</td>
                                                <td><label class="badge badge-outline-primary">77</label></td>
                                            </tr>
                                            <tr>
                                                <td class="cb">Rizal</td>
                                                <td><label class="badge badge-outline-primary">38</label></td>
                                            </tr>
                                            <tr>
                                                <td class="cb">Quezon</td>
                                                <td><label class="badge badge-outline-primary">90</label></td>
                                            </tr>
                                            <tr>
                                                <td class="cb">Lucena City</td>
                                                <td><label class="badge badge-outline-primary">8</label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- Card -->
                        </div><!-- stretch-card0 -->

                        <div class="col-lg-4 grid-margin2 stretch-card2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">For Action</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="card-title2">
                                                    <th> </th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Primary Accounts with same Employee ID</td>
                                                    <td><label class="badge badge-outline-primary">8</label></td>
                                                </tr>
                                                <tr>
                                                    <td>Accounts with missing Office</td>
                                                    <td><label class="badge badge-outline-primary">5</label></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 grid-margin2 stretch-card3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">For Information</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="card-title2">
                                                    <th> </th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Block Accounts</td>
                                                    <td><label class="badge badge-outline-primary">75</label></td>
                                                </tr>
                                                <tr>
                                                    <td>Total No. of Female Employee</td>
                                                    <td><label class="badge badge-outline-primary">267</label></td>
                                                </tr>
                                                <tr>
                                                    <td>Total No. of Male Employee</td>
                                                    <td><label class="badge badge-outline-primary">5</label></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- content row 1 -->

                    <!--Search Filter-->
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card cb">
                            <div class="card-body">
                                <h4 class="card-title">Search Filter</h4>
                                <form class="form-sample">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Office:</label>
                                                    <v-select id="office" :options="options2" searchable
                                                        placeholder="Search or select Office" />
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
                                                    <v-select id="age_category" :options="options3"
                                                        placeholder="-- Please Select Age Category --" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Civil Status:</label>
                                                    <v-select id="civil_status" :options="options4"
                                                        placeholder="-- Please Select Civil Status --" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>With Health Issues:</label>
                                                    <v-select id="health_issues" :options="options5"
                                                        placeholder="-- Please Select With Health Issues --" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Gender:</label>
                                                    <v-select id="gender" :options="options6"
                                                        placeholder="-- Please Select Gender --" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>PWD:</label>
                                                    <v-select id="pwd" :options="options7"
                                                        placeholder="-- Please Select PWD --" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Are you a Solo Parent:</label>
                                                    <v-select id="solo_parent" :options="options8"
                                                        placeholder="-- Please Select Are you a Solo Parent --" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-primary btn-icon-text btn-sm"><i
                                            class="ti-filter"></i>
                                        Filter </button>&nbsp
                                    <button class="btn btn-outline-dark btn-icon-text btn-sm"><i class="ti-reload"></i>
                                        Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card cb">
                            <div class="card-body">
                                <h4 class="card-title">Employee's Directory Completion Status</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <app_table />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- content-wrapper -->
                <FooterVue />
            </div>
        </div>
    </div>

    <div class="col-lg-4 grid-margin2 stretch-card2">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">For Action</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="card-title2">
                                <th> </th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Primary Accounts with same Employee ID</td>
                                <td><label class="badge badge-info">8</label></td>
                            </tr>
                            <tr>
                                <td>Accounts with missing Office</td>
                                <td><label class="badge badge-info">5</label></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 grid-margin2 stretch-card3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">For Information</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="card-title2">
                                <th> </th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Block Accounts</td>
                                <td><label class="badge badge-info">75</label></td>
                            </tr>
                            <tr>
                                <td>Total No. of Female Employee</td>
                                <td><label class="badge badge-info">267</label></td>
                            </tr>
                            <tr>
                                <td>Total No. of Male Employee</td>
                                <td><label class="badge badge-info">5</label></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Search Filter-->
    <div class="card cb">
        <div class="card-body">
            <h4 class="card-title">Search Filter</h4>
            <form class="form-sample">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label>Office:</label>
                                <v-select ref="singleSelect" v-model="selectedSingle" :options="options2" searchable
                                    placeholder="Search or select Office" />
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
                                <div id="the-basics">
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
                                <v-select ref="singleSelect" v-model="selectedSingle" :options="options3"
                                    placeholder="-- Please Select Age Category --" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label>Civil Status:</label>
                                <v-select ref="singleSelect" v-model="selectedSingle" :options="options4"
                                    placeholder="-- Please Select Civil Status --" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label>With Health Issues:</label>
                                <v-select ref="singleSelect" v-model="selectedSingle" :options="options5"
                                    placeholder="-- Please Select With Health Issues --" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label>Gender:</label>
                                <v-select ref="singleSelect" v-model="selectedSingle" :options="options6"
                                    placeholder="-- Please Select Gender --" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label>PWD:</label>
                                <v-select ref="singleSelect" v-model="selectedSingle" :options="options7"
                                    placeholder="-- Please Select PWD --" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <label>Are you a Solo Parent:</label>
                                <v-select ref="singleSelect" v-model="selectedSingle" :options="options8"
                                    placeholder="-- Please Select Are you a Solo Parent --" />
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary mr-2"><i class="ti-filter"></i> Filter </button>
                <button class="btn btn-light"><i class="ti-reload"></i> Clear</button>

            </form>
        </div>
    </div>
    <div class="card cb">
        <div class="card-body">

            <div class="row">
                <div class="col-9">
                    <p class="card-title">Employee's Directory Completion Status</p>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Recipient's username"
                                aria-label="Recipient's username">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="button">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-6"></div>
                                <div class="col-sm-12 col-md-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <app_table />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5"></div>
                                <div class="col-sm-12 col-md-7"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <FooterVue />
   
</template>


<script>
import vSelect from 'vue-multiselect';

import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import app_table from './app_table.vue';

export default {
    name: 'Employees_Directory',
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        vSelect, // Register the Multiselect component
        app_table, //Table
    },
    data() {
        return {
            selected: null,
            options: [
                { label: 'All', value: 'All' },
                { label: 'Batangas', value: 'Batangas' },
                { label: 'Cavite', value: 'Cavite' },
                { label: 'Laguna', value: 'Laguna' },
                { label: 'Rizal', value: 'Rizal' },
                { label: 'Quezon', value: 'Quezon' },
                { label: 'Lucena City', value: 'Lucena City' }
            ],
            selectedOption: null,
            options2: [
                { label: 'All', value: 'option1' },
                { label: 'Batangas', value: 'option2' },
                { label: 'Cavite', value: 'option3' },
                { label: 'Laguna', value: 'option4' },
                { label: 'Lucena City', value: 'option5' },
                { label: 'Quezon', value: 'option6' },
                { label: 'Rizal', value: 'option7' }, // Options For Office
            ],

            selectedOption: null,
            options3: [
                { label: 'All', value: 'option1' },
                { label: '18-24', value: 'option2' },
                { label: '25-34', value: 'option3' },
                { label: '35-44', value: 'option4' },
                { label: '45-54', value: 'option5' },
                { label: '65 and Over', value: 'option6' }, // Options For Age Category
            ],

            selectedOption: null,
            options4: [
                { label: 'All', value: 'option1' },
                { label: 'Married', value: 'option2' },
                { label: 'Single', value: 'option3' },
                { label: 'Widow', value: 'option4' },
                { label: 'Seperated', value: 'option5' },// Options For Civil Status
            ],

            selectedOption: null,
            options5: [
                { label: 'Yes', value: 'option1' },
                { label: 'None', value: 'option2' },// Options For Health Issues
            ],

            selectedOption: null,
            options6: [
                { label: 'Male', value: 'option1' },
                { label: 'Female', value: 'option2' },// Options For Gender
            ],

            selectedOption: null,
            options7: [
                { label: 'Yes', value: 'option1' },
                { label: 'No', value: 'option2' },// Options For PWD
            ],

            selectedOption: null,
            options8: [
                { label: 'Yes', value: 'option1' },
                { label: 'No', value: 'option2' },// Options For Solo Parent
            ],

            searchText: ''
        }
    },
    computed: {
        filteredItems() {
            let filtered = this.items;
            if (this.selected && this.selected !== 'All') {
                filtered = filtered.filter(item => item.location === this.selected);
            }
            if (this.selectedAgeCategory && this.selectedAgeCategory !== 'All') {
                const [min, max] = this.selectedAgeCategory.split('-').map(Number);
                filtered = filtered.filter(item => {
                    const age = new Date().getFullYear() - new Date(item.birthDate).getFullYear();
                    return age >= min && age <= max;
                });
            }
            if (this.searchText.trim() !== '') {
                filtered = filtered.filter(item =>
                    item.name.toLowerCase().includes(this.searchText.toLowerCase())
                );
            }
            return filtered;
        },
        filteredOptions() {
            return this.options.filter(option =>
                option.label.toLowerCase().includes(this.searchText.toLowerCase())
            );
        }
    },
    methods: {
        filterItems() {
            // No need for anything here, since we're using computed property
        },
        customLabel(option) {
            return option.label;
        },
        filterOptions() {
            // No need for anything here, since we're using computed property
        }
    }

}


</script>

<!-- <style scoped>
@import "~vue-select/dist/vue-select.css";
</style> -->
