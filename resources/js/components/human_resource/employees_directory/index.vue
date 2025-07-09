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
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />

                    <!-- Statistics Row -->
                    <div class="row">
                        <div class="col-lg-4 grid-margin2 stretch-card0">
                            <div class="card">
                                <div class="card-body2">
                                    <h4 class="card-title">User Accounts Statistics</h4>
                                </div>
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr class="card-title2">
                                                <th></th>
                                                <th class="cb">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table-wrapper">
                                    <table class="table">
                                        <tbody>
                                            <tr v-for="stat in statistics.officeStats" :key="stat.office">
                                                <td class="cb">{{ stat.office }}</td>
                                                <td><label class="badge badge-outline-primary">{{ stat.count }}</label></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                                    <th></th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Duplicate Employee IDs</td>
                                                    <td><label class="badge badge-outline-primary">{{ statistics.duplicateEmployeeIds }}</label></td>
                                                </tr>
                                                <tr>
                                                    <td>Accounts with missing Office</td>
                                                    <td><label class="badge badge-outline-primary">{{ statistics.missingOffice }}</label></td>
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
                                                    <th></th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Inactive Accounts</td>
                                                    <td><label class="badge badge-outline-primary">{{ statistics.inactiveAccounts }}</label></td>
                                                </tr>
                                                <tr>
                                                    <td>Total No. of Female Employee</td>
                                                    <td><label class="badge badge-outline-primary">{{ statistics.femaleCount }}</label></td>
                                                </tr>
                                                <tr>
                                                    <td>Total No. of Male Employee</td>
                                                    <td><label class="badge badge-outline-primary">{{ statistics.maleCount }}</label></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Filter -->
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card cb">
                            <div class="card-body">
                                <h4 class="card-title">Search Filter</h4>
                                <form class="form-sample" @submit.prevent="applyFilters">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Office:</label>
                                                    <v-select v-model="filters.office" :options="officeOptions" searchable
                                                        placeholder="Search or select Office" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Employee ID No.:</label>
                                                    <input v-model="filters.employeeId" class="form-control" type="text"
                                                        placeholder="Enter Employee ID">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Name:</label>
                                                    <input v-model="filters.name" class="form-control" type="text"
                                                        placeholder="Enter Employee Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Gender:</label>
                                                    <v-select v-model="filters.gender" :options="genderOptions"
                                                        placeholder="-- Please Select Gender --" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Employment Status:</label>
                                                    <v-select v-model="filters.employmentStatus" :options="employmentStatusOptions"
                                                        placeholder="-- Please Select Employment Status --" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label>Status:</label>
                                                    <v-select v-model="filters.isActivated" :options="statusOptions"
                                                        placeholder="-- Please Select Status --" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-primary btn-icon-text btn-sm">
                                        <i class="ti-filter"></i> Filter
                                    </button>&nbsp;
                                    <button type="button" class="btn btn-outline-dark btn-icon-text btn-sm" @click="clearFilters">
                                        <i class="ti-reload"></i> Clear
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Table -->
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card cb">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h4 class="card-title">Employee's Directory</h4>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input v-model="searchQuery" type="text" class="form-control"
                                                    placeholder="Search employees..." @input="handleSearch">
                                                <div class="input-group-append">
                                                    <button class="btn btn-sm btn-primary" type="button" @click="handleSearch">
                                                        Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <app_table
                                                :employees="filteredEmployees"
                                                :loading="loading"
                                                @page-change="handlePageChange"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <FooterVue />
            </div>
        </div>
    </div>
</template>

<script>
import vSelect from 'vue-multiselect';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import app_table from './app_table.vue';
import axios from 'axios';

export default {
    name: 'Employees_Directory',
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        vSelect,
        app_table,
    },
    data() {
        return {
            employees: [],
            filteredEmployees: [],
            loading: false,
            searchQuery: '',
            statistics: {
                officeStats: [],
                duplicateEmployeeIds: 0,
                missingOffice: 0,
                inactiveAccounts: 0,
                femaleCount: 0,
                maleCount: 0,
            },
            filters: {
                office: null,
                employeeId: '',
                name: '',
                gender: null,
                employmentStatus: null,
                isActivated: null,
            },
            officeOptions: [
                { label: 'All', value: null },
                { label: 'Regional Office', value: 'Region' },
                { label: 'Batangas', value: 'Batangas' },
                { label: 'Cavite', value: 'Cavite' },
                { label: 'Laguna', value: 'Laguna' },
                { label: 'Lucena City', value: 'Lucena City' },
                { label: 'Quezon', value: 'Quezon' },
                { label: 'Rizal', value: 'Rizal' },
            ],
            genderOptions: [
                { label: 'All', value: null },
                { label: 'Male', value: 'Male' },
                { label: 'Female', value: 'Female' },
            ],
            employmentStatusOptions: [
                { label: 'All', value: null },
                { label: 'Regular', value: 'Regular' },
                { label: 'Contractual', value: 'Contractual' },
                { label: 'Casual', value: 'Casual' },
            ],
            statusOptions: [
                { label: 'All', value: null },
                { label: 'Active', value: 1 },
                { label: 'Inactive', value: 0 },
            ],
        };
    },
    mounted() {
        this.fetchEmployees();
        this.fetchStatistics();
    },
    methods: {
        async fetchEmployees() {
            this.loading = true;
            try {
                const response = await axios.get('/api/fetchEmployeeData');
                this.employees = response.data.data || response.data;
                this.filteredEmployees = [...this.employees];
            } catch (error) {
                console.error('Error fetching employees:', error);
                this.employees = [];
                this.filteredEmployees = [];
            } finally {
                this.loading = false;
            }
        },
        async fetchStatistics() {
            try {
                // Fetch office statistics
                const officeResponse = await axios.get('/api/fetchUserOfficeCount');
                this.statistics.officeStats = officeResponse.data;

                // Fetch gender statistics
                const genderResponse = await axios.get('/api/getGenderEmpStat');
                this.statistics.femaleCount = genderResponse.data.female || 0;
                this.statistics.maleCount = genderResponse.data.male || 0;

                // Calculate other statistics from employee data
                if (this.employees.length > 0) {
                    this.calculateDerivedStats();
                }
            } catch (error) {
                console.error('Error fetching statistics:', error);
            }
        },
        calculateDerivedStats() {
            // Count inactive accounts
            this.statistics.inactiveAccounts = this.employees.filter(emp => !emp.is_activated).length;

            // Count missing office
            this.statistics.missingOffice = this.employees.filter(emp => !emp.office).length;

            // Count duplicate employee IDs (simplified check)
            const employeeIds = this.employees.map(emp => emp.employee_no).filter(id => id);
            const uniqueIds = [...new Set(employeeIds)];
            this.statistics.duplicateEmployeeIds = employeeIds.length - uniqueIds.length;
        },
        applyFilters() {
            let filtered = [...this.employees];

            // Apply office filter
            if (this.filters.office && this.filters.office.value) {
                filtered = filtered.filter(emp => emp.office === this.filters.office.value);
            }

            // Apply employee ID filter
            if (this.filters.employeeId.trim()) {
                filtered = filtered.filter(emp =>
                    emp.employee_no && emp.employee_no.toLowerCase().includes(this.filters.employeeId.toLowerCase())
                );
            }

            // Apply name filter
            if (this.filters.name.trim()) {
                filtered = filtered.filter(emp => {
                    const fullName = `${emp.first_name} ${emp.last_name}`.toLowerCase();
                    return fullName.includes(this.filters.name.toLowerCase());
                });
            }

            // Apply gender filter
            if (this.filters.gender && this.filters.gender.value) {
                filtered = filtered.filter(emp => emp.gender === this.filters.gender.value);
            }

            // Apply employment status filter
            if (this.filters.employmentStatus && this.filters.employmentStatus.value) {
                filtered = filtered.filter(emp => emp.employment_status === this.filters.employmentStatus.value);
            }

            // Apply activation status filter
            if (this.filters.isActivated && this.filters.isActivated.value !== null) {
                filtered = filtered.filter(emp => emp.is_activated == this.filters.isActivated.value);
            }

            this.filteredEmployees = filtered;
        },
        clearFilters() {
            this.filters = {
                office: null,
                employeeId: '',
                name: '',
                gender: null,
                employmentStatus: null,
                isActivated: null,
            };
            this.searchQuery = '';
            this.filteredEmployees = [...this.employees];
        },
        handleSearch() {
            let filtered = [...this.employees];

            if (this.searchQuery.trim()) {
                filtered = filtered.filter(emp => {
                    const fullName = `${emp.first_name} ${emp.last_name}`.toLowerCase();
                    const employeeNo = emp.employee_no ? emp.employee_no.toLowerCase() : '';
                    const searchTerm = this.searchQuery.toLowerCase();

                    return fullName.includes(searchTerm) || employeeNo.includes(searchTerm);
                });
            }

            this.filteredEmployees = filtered;
        },
        handlePageChange(page) {
            // Handle pagination if needed
            console.log('Page changed to:', page);
        },
    },
    watch: {
        employees() {
            this.calculateDerivedStats();
        }
    }
};
</script>
