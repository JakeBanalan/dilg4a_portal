<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />

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
                                        <thead style="text-align:center; background-color: #059886;">
                                            <tr>
                                                <th></th>
                                                <th>TOTAL</th>
                                            </tr>
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
                                            <tr>
                                                <th></th>
                                                <th>TOTAL</th>
                                            </tr>
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
                    </div>

                    Search Filter-->

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
                                                        <label> Employee ID No.:</label>
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
                                                class="ti-reload"></i> Clear</button>
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
                                        <table id="employee_table"
                                            class="table table-striped table-borderless display expandable-table dataTable no-footer"
                                            role="grid">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_disabled" style="min-width: 90px;">Employee ID
                                                    </th>
                                                    <th class="sorting_disabled" style="min-width: 110px;">Province/HUC
                                                    </th>
                                                    <th class="sorting_disabled" style="min-width: 120px;">Username</th>
                                                    <th class="sorting_disabled" style="min-width: 150px;">Full Name
                                                    </th>
                                                    <th class="sorting_disabled d-none d-md-table-cell"
                                                        style="min-width: 120px;">Username</th>
                                                    <th class="sorting_disabled d-none d-md-table-cell"
                                                        style="min-width: 180px;">Email</th>
                                                    <th class="sorting_disabled d-none d-lg-table-cell"
                                                        style="min-width: 130px;">Contact Number</th>
                                                    <th class="sorting_disabled" style="min-width: 100px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="ed in EmpTableData" :key="ed.id">
                                                    <td>{{ ed.employee_no }}</td>
                                                    <td>{{ ed.province }}</td>
                                                    <td>{{ ed.username }}</td>
                                                    <td>{{ ed.name }}</td>
                                                    <td class="d-none d-md-table-cell">{{ ed.username }}</td>
                                                    <td class="d-none d-md-table-cell">{{ ed.email }}</td>
                                                    <td class="d-none d-lg-table-cell">{{ ed.contact_details }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button @click="UpdateUser(ed.id)"
                                                                class="btn btn-sm btn-info me-1" title="View User">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button @click="addRole(ed.id)"
                                                                class="btn btn-sm btn-primary" title="Add Role">
                                                                <i class="fas fa-user-tag"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Empty state if no data -->
                                                <tr v-if="!EmpTableData || EmpTableData.length === 0">
                                                    <td colspan="8" class="text-center py-4">No employee data available
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

    <!-- Modal -->
    <div class="modal fade" id="assignSidebarModal" tabindex="-1" role="dialog"
        aria-labelledby="assignSidebarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="assignSidebarModalLabel">Assign Sidebar Items</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"
                        style="font-size: 1.5rem; background: none; border: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body" style="background-color: #f9f9f9; padding: 1.5rem;">
                    <form>
                        <!-- Select All Option -->
                        <div class="mb-4 pb-2 border-bottom">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll"
                                    v-model="selectAllChecked" @change="toggleSelectAll" />
                                <label class="form-check-label fw-bold" for="selectAll"
                                    style="font-size: 1.2rem; color: #059886;">
                                    Select All Menu Items
                                </label>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="row">
                            <div v-for="menu in menuOptions" :key="menu.value" class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-light">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="menu.value"
                                                :value="menu.value" v-model="selectedSidebarItems"
                                                @change="toggleChildren(menu)" />
                                            <label class="form-check-label fw-bold" :for="menu.value"
                                                style="font-size: 1.1rem;">
                                                {{ menu.label }}
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Child checkboxes -->
                                    <div v-if="menu.children" class="card-body pt-2">
                                        <div v-for="child in menu.children" :key="child.value" class="mb-2">
                                            <!-- Handle nested children (2 levels deep) -->
                                            <div v-if="child.children" class="border-start border-2 ps-3 mb-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" style="margin-left: 0.75rem;"
                                                        type="checkbox" :id="child.value" :value="child.value"
                                                        v-model="selectedSidebarItems"
                                                        :disabled="!selectedSidebarItems.includes(menu.value)"
                                                        @change="toggleGrandChildren(child)" />
                                                    <label class="form-check-label fw-semibold" :for="child.value"
                                                        style="font-size: 1rem;">
                                                        {{ child.label }}
                                                    </label>
                                                </div>
                                                <!-- Grandchild -->
                                                <div class="ps-5">
                                                    <div v-for="grandchild in child.children" :key="grandchild.value"
                                                        class="form-check mb-1 ps-5">
                                                        <input class="form-check-input" style="margin-left: 1.75rem;"
                                                            type="checkbox" :id="grandchild.value"
                                                            :value="grandchild.value" v-model="selectedSidebarItems"
                                                            :disabled="!selectedSidebarItems.includes(child.value)" />
                                                        <label class="form-check-label text-muted"
                                                            :for="grandchild.value"
                                                            style="font-size: 0.9rem; margin-left: 2.75rem;">
                                                            {{ grandchild.label }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Regular child -->
                                            <div v-else class="form-check mb-2 ps-4">
                                                <input class="form-check-input" style="margin-left: 0.5rem;"
                                                    type="checkbox" :id="child.value" :value="child.value"
                                                    v-model="selectedSidebarItems"
                                                    :disabled="!selectedSidebarItems.includes(menu.value)" />
                                                <label class="form-check-label" :for="child.value"
                                                    style="font-size: 1rem;">
                                                    {{ child.label }}
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer" style="background-color: #f1f1f1;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        style="font-size: 1rem; font-weight: 500;">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveSidebarItems"
                        style="font-size: 1rem; font-weight: 500;">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import Multiselect from 'vue-multiselect';
import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import user_table from './user_table.vue';
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    name: 'User Management',
    components: {
        user_table,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Multiselect,
    },
    data() {
        return {
            isCardVisible: false,
            EmpTableData: [],
            dataTableInitialized: false,
            selectAllChecked: false,
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
                { label: 'Rizal', value: 'option7' },
            ],
            options3: [
                { label: 'All', value: 'option1' },
                { label: '18-24', value: 'option2' },
                { label: '25-34', value: 'option3' },
                { label: '35-44', value: 'option4' },
                { label: '45-54', value: 'option5' },
                { label: '65 and Over', value: 'option6' },
            ],
            options4: [
                { label: 'All', value: 'option1' },
                { label: 'Married', value: 'option2' },
                { label: 'Single', value: 'option3' },
                { label: 'Widow', value: 'option4' },
                { label: 'Seperated', value: 'option5' },
            ],
            options5: [
                { label: 'Yes', value: 'option1' },
                { label: 'None', value: 'option2' },
            ],
            options6: [
                { label: 'Male', value: 'option1' },
                { label: 'Female', value: 'option2' },
            ],
            options7: [
                { label: 'Yes', value: 'option1' },
                { label: 'No', value: 'option2' },
            ],
            options8: [
                { label: 'Yes', value: 'option1' },
                { label: 'No', value: 'option2' },
            ],
            menuOptions: [
                { label: 'Dashboard', value: '/dashboard' },
                { label: 'Calendar', value: '/calendar/index' },
                {
                    label: 'Procurement',
                    value: 'procurement',
                    children: [
                        { label: 'PPMP', value: '/procurement/PPMP' },
                        { label: 'Purchase Request', value: '/procurement/index' },
                        { label: 'R.F.Q', value: '/procurement/rfq/index' },
                        { label: 'Abstract of Quotation', value: '/procurement/abstract/index' },
                        // { label: 'Philgeps Awarding', value: '/procurement/abstract/index' },
                        { label: 'Monitoring', value: '/procurement/pr_monitoring' },
                    ],
                },
                {
                    label: 'Budget Section',
                    value: 'budget',
                    children: [
                        { label: 'Obligation', value: '/budget/obligation' },
                    ],
                },
                {
                    label: 'RICTU',
                    value: 'rictu',
                    children: [
                        { label: 'ICT TA', value: '/rictu/ict_ta/index' },
                    ],
                },
                {
                    label: 'Human Resource',
                    value: 'human_resource',
                    children: [
                        { label: 'Daily Time Record', value: '/human_resource/daily_time_record/index' },
                        { label: 'Employee Directory', value: '/human_resource/employees_directory/index' },
                    ],
                },
                {
                    label: 'Finance',
                    value: 'finance',
                    children: [
                        {
                            label: 'Budget',
                            value: 'Budget',
                            children: [
                                { label: 'Fund Source', value: '/finance/budget/index' },
                                { label: 'UACS', value: '/finance/budget/object_code' },
                                { label: 'Obligation', value: '/finance/budget/obligation' },
                                { label: 'Budget PR Monitoring', value: '/finance/budget/pr_monitoring' },
                            ]
                        },
                        {
                            label: 'Accounting',
                            value: 'accounting',
                            children: [
                                { label: 'NTA / NCA', value: '/finance/accounting/nta' },
                                { label: 'Disbursement', value: '/finance/accounting/disbursement' },
                                // Add more if needed
                            ],
                        },
                    ],
                },
                {
                    label: 'QMS',
                    value: 'qms',
                    children: [
                        { label: 'Quality Procedures', value: '/qms/quality_procedure/index' },
                        { label: 'Process Owners', value: '/qms/process_owner/index' },
                        { label: 'Regional QME', value: '/qms/reports_submission/index' },
                        { label: 'Provincial QME', value: '/qms/reports_submission/provincial_report' },
                    ],
                },
                { label: 'User Management', value: '/settings/user-management/' },
            ],
            selectedMenus: [],
            searchText: '',
            users: [],
            selectedUserId: null,
            selectedSidebarItems: [],
            // Keep track of all available menu items including children for select all functionality
            allMenuItems: []
        };
    },
    computed: {
        // Computed property to check if all items are selected
        isAllSelected() {
            return this.allMenuItems.length > 0 && this.selectedSidebarItems.length === this.allMenuItems.length;
        }
    },
    watch: {
        // Watch the selectedSidebarItems array to update selectAllChecked
        selectedSidebarItems: {
            handler() {
                this.selectAllChecked = this.isAllSelected;
            },
            deep: true
        }
    },
    mounted() {
        this.fetchEmployeeData();
        this.generateAllMenuItems();
    },
    methods: {
        // Generate a flat list of all menu items (including children) for select all functionality
        generateAllMenuItems() {
            const items = [];
            this.menuOptions.forEach(menu => {
                items.push(menu.value);
                if (menu.children) {
                    menu.children.forEach(child => {
                        items.push(child.value);
                    });
                }
            });
            this.allMenuItems = items;
        },
        // Toggle select all functionality
        toggleSelectAll() {
            if (this.selectAllChecked) {
                // Select all items
                this.selectedSidebarItems = [...this.allMenuItems];
            } else {
                // Deselect all items
                this.selectedSidebarItems = [];
            }
        },
        toggleGrandChildren(child) {
            if (child.children) {
                if (this.selectedSidebarItems.includes(child.value)) {
                    // If the child is selected, add all grandchildren to the selection
                    child.children.forEach(grandchild => {
                        if (!this.selectedSidebarItems.includes(grandchild.value)) {
                            this.selectedSidebarItems.push(grandchild.value);
                        }
                    });
                } else {
                    // If the child is deselected, remove all grandchildren from the selection
                    child.children.forEach(grandchild => {
                        const index = this.selectedSidebarItems.indexOf(grandchild.value);
                        if (index > -1) {
                            this.selectedSidebarItems.splice(index, 1);
                        }
                    });
                }
            }
        },
        createUser() {
            const userData = {
                module_access: JSON.stringify(this.selectedMenus.map(menu => menu.value)),
            };
            axios.post('../../api/PostUser', userData)
                .then(response => {
                    console.log('User created successfully:', response.data);
                })
                .catch(error => {
                    console.error('Error creating user:', error);
                });
        },
        UpdateUser(id) {
            this.$router.push({ path: `/settings/update/${id}` });
        },
        addRole(id) {
            this.selectedUserId = id;
            this.selectedSidebarItems = [];
            axios.get(`../../api/getUserDetails/${id}`)
                .then(response => {
                    const user = response.data;
                    if (user.module_access) {
                        try {
                            this.selectedSidebarItems = JSON.parse(user.module_access);
                            // Update the selectAllChecked status based on current selection
                            this.selectAllChecked = this.isAllSelected;
                        } catch (e) {
                            console.error('Error parsing module_access JSON:', e);
                            this.selectedSidebarItems = [];
                        }
                    }
                    $('#assignSidebarModal').modal('show');
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch user details.',
                    });
                });
        },
        saveSidebarItems() {
            if (!this.selectedUserId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No user selected.',
                });
                return;
            }

            const payload = {
                userId: this.selectedUserId,
                module_access: JSON.stringify(this.selectedSidebarItems),
            };

            axios.post('../../api/updateUserSidebar', payload)
                .then(response => {
                    // Update localStorage if current user is being updated
                    if (this.selectedUserId === parseInt(localStorage.getItem('userId'))) {
                        localStorage.setItem('module_access', JSON.stringify(this.selectedSidebarItems));
                    }

                    $('#assignSidebarModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Sidebar items updated successfully!',
                    });

                    // Refresh the employee data to show updated permissions
                    this.fetchEmployeeData();
                })
                .catch(error => {
                    console.error('Error updating sidebar items:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update sidebar items.',
                    });
                });
        },
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
        },
        fetchEmployeeData() {
            const vm = this;
            axios.get('../../api/fetchEmployeeData')
                .then((response) => {
                    $('#employee_table').DataTable({
                        destroy: true,
                        data: response.data,
                        pageLength: 20,
                        bLengthChange: false,
                        bInfo: false,
                        filter: true,
                        columns: [
                            { data: 'employee_no' },
                            { data: 'pmo_title' },
                            { data: 'username' },
                            { data: 'name' },
                            { data: 'username' },
                            { data: 'email' },
                            { data: 'contact_details' },
                            {
                                data: null, orderable: false, render: function (data) {
                                    return `
                    <button type="button" class="btn btn-info btn-update" data-id="${data.id}">View</button>
                    <button type="button" class="btn btn-primary btn-role" data-id="${data.id}">Add Role</button>
                  `;
                                },
                            }
                        ]
                    });
                    $('#employee_table tbody').on('click', 'button.btn-role', function () {
                        const id = $(this).data('id');
                        vm.addRole(id);
                    });
                    $('#employee_table tbody').on('click', 'button.btn-update', function () {
                        const id = $(this).data('id');
                        vm.UpdateUser(id);
                    });
                })
                .catch((error) => {
                    console.error('Error fetching employee data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch employee data.',
                    });
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
        toggleChildren(menu) {
            if (menu.children) {
                // If the parent menu is checked, enable all child checkboxes
                if (this.selectedSidebarItems.includes(menu.value)) {
                    // Do nothing to children, they're now enabled for selection
                } else {
                    // If parent is unchecked, remove all children from selection
                    menu.children.forEach(child => {
                        const index = this.selectedSidebarItems.indexOf(child.value);
                        if (index !== -1) {
                            this.selectedSidebarItems.splice(index, 1);
                        }
                    });
                }
            }
        }
    },
}
</script>

<style scoped>
@import "~vue-select/dist/vue-select.css";

/* Responsive table styles */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Ensure all cells have padding and vertical alignment */
.table td,
.table th {
    vertical-align: middle;
    padding: 0.75rem;
}

/* Make sure the action buttons are properly displayed */
.btn-group {
    display: flex;
    flex-wrap: nowrap;
}

/* Hide scrollbar for cleaner look on some browsers */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

/* Special styles for mobile view */
@media (max-width: 767.98px) {

    .table th,
    .table td {
        font-size: 0.9rem;
        padding: 0.5rem;
    }

    /* Make sure action buttons are visible */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}

.sbnone::-webkit-scrollbar {
    display: none;
}
</style>
