<template>
    <div>
        <!-- Loading State -->
        <div v-if="loading" class="text-center p-4">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Loading employees...</p>
        </div>

        <!-- Employee Table -->
        <div v-else>
            <table id="example" class="table table-striped table-borderless display expandable-table dataTable no-footer" role="grid">
                <thead>
                    <tr role="row">
                        <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 40px;">
                            #
                        </th>
                        <th class="sorting" tabindex="0" style="width: 120px;" @click="sortBy('employee_no')">
                            Employee Code
                            <i v-if="sortField === 'employee_no'" :class="sortDirection === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down'"></i>
                        </th>
                        <th class="sorting" tabindex="0" style="width: 200px;" @click="sortBy('name')">
                            Name
                            <i v-if="sortField === 'name'" :class="sortDirection === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down'"></i>
                        </th>
                        <th class="sorting" tabindex="0" style="width: 150px;" @click="sortBy('office')">
                            Office
                            <i v-if="sortField === 'office'" :class="sortDirection === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down'"></i>
                        </th>
                        <th class="sorting" tabindex="0" style="width: 180px;" @click="sortBy('position')">
                            Position
                            <i v-if="sortField === 'position'" :class="sortDirection === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down'"></i>
                        </th>
                        <th class="sorting" tabindex="0" style="width: 200px;" @click="sortBy('email')">
                            Email Address
                            <i v-if="sortField === 'email'" :class="sortDirection === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down'"></i>
                        </th>
                        <th class="sorting" tabindex="0" style="width: 100px;" @click="sortBy('employment_status')">
                            Status
                            <i v-if="sortField === 'employment_status'" :class="sortDirection === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down'"></i>
                        </th>
                        <th class="sorting" tabindex="0" style="width: 80px;">
                            Active
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(employee, index) in paginatedEmployees" :key="employee.id"
                        :class="{ 'table-warning': !employee.is_activated }">
                        <td>{{ startIndex + index + 1 }}</td>
                        <td>
                            <span class="badge badge-outline-info">{{ employee.employee_no || 'N/A' }}</span>
                        </td>
                        <td>
                            <strong>{{ formatName(employee) }}</strong>
                            <br>
                            <small class="text-muted">{{ employee.gender || 'N/A' }}</small>
                        </td>
                        <td>
                            <span class="badge badge-outline-secondary">{{ employee.office || 'N/A' }}</span>
                        </td>
                        <td>{{ getPositionName(employee.position_id) || 'N/A' }}</td>
                        <td>
                            <a :href="'mailto:' + employee.email" v-if="employee.email">
                                {{ employee.email }}
                            </a>
                            <span v-else class="text-muted">No email</span>
                        </td>
                        <td>
                            <span class="badge" :class="getEmploymentStatusClass(employee.employment_status)">
                                {{ employee.employment_status || 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge" :class="employee.is_activated ? 'badge-success' : 'badge-danger'">
                                {{ employee.is_activated ? 'Yes' : 'No' }}
                            </span>
                        </td>
                    </tr>

                    <!-- No Data Row -->
                    <tr v-if="employees.length === 0">
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No employees found</p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div v-if="employees.length > 0" class="row mt-3">
                <div class="col-sm-6">
                    <div class="dataTables_info">
                        Showing {{ startIndex + 1 }} to {{ Math.min(startIndex + itemsPerPage, employees.length) }}
                        of {{ employees.length }} entries
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dataTables_paginate paging_simple_numbers float-right">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous" :class="{ disabled: currentPage === 1 }">
                                <a href="#" class="page-link" @click.prevent="changePage(currentPage - 1)">Previous</a>
                            </li>

                            <li v-for="page in visiblePages" :key="page"
                                class="paginate_button page-item" :class="{ active: page === currentPage }">
                                <a href="#" class="page-link" @click.prevent="changePage(page)">{{ page }}</a>
                            </li>

                            <li class="paginate_button page-item next" :class="{ disabled: currentPage === totalPages }">
                                <a href="#" class="page-link" @click.prevent="changePage(currentPage + 1)">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'app_table',
    props: {
        employees: {
            type: Array,
            default: () => []
        },
        loading: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            currentPage: 1,
            itemsPerPage: 10,
            sortField: '',
            sortDirection: 'asc',
            positions: []
        }
    },
    computed: {
        sortedEmployees() {
            if (!this.sortField) return this.employees;

            return [...this.employees].sort((a, b) => {
                let aVal = a[this.sortField];
                let bVal = b[this.sortField];

                // Handle name sorting specially
                if (this.sortField === 'name') {
                    aVal = this.formatName(a);
                    bVal = this.formatName(b);
                }

                // Handle null/undefined values
                if (!aVal) aVal = '';
                if (!bVal) bVal = '';

                if (typeof aVal === 'string') {
                    aVal = aVal.toLowerCase();
                    bVal = bVal.toLowerCase();
                }

                if (this.sortDirection === 'asc') {
                    return aVal < bVal ? -1 : aVal > bVal ? 1 : 0;
                } else {
                    return aVal > bVal ? -1 : aVal < bVal ? 1 : 0;
                }
            });
        },
        totalPages() {
            return Math.ceil(this.employees.length / this.itemsPerPage);
        },
        startIndex() {
            return (this.currentPage - 1) * this.itemsPerPage;
        },
        paginatedEmployees() {
            const start = this.startIndex;
            const end = start + this.itemsPerPage;
            return this.sortedEmployees.slice(start, end);
        },
        visiblePages() {
            const pages = [];
            const maxVisible = 5;
            let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
            let end = Math.min(this.totalPages, start + maxVisible - 1);

            // Adjust start if we're near the end
            if (end - start + 1 < maxVisible) {
                start = Math.max(1, end - maxVisible + 1);
            }

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        }
    },
    mounted() {
        this.fetchPositions();
    },
    methods: {
        async fetchPositions() {
            try {
                const response = await axios.get('/api/getPosition');
                this.positions = response.data;
            } catch (error) {
                console.error('Error fetching positions:', error);
                this.positions = [];
            }
        },
        formatName(employee) {
            if (!employee) return 'N/A';
            const parts = [employee.last_name, employee.first_name, employee.middle_name].filter(Boolean);
            return parts.join(', ') || 'N/A';
        },
        getPositionName(positionId) {
            if (!positionId || !this.positions.length) return 'N/A';
            const position = this.positions.find(p => p.id === positionId);
            return position ? position.position_name : 'N/A';
        },
        getEmploymentStatusClass(status) {
            switch (status) {
                case 'Regular':
                    return 'badge-success';
                case 'Contractual':
                    return 'badge-warning';
                case 'Casual':
                    return 'badge-info';
                default:
                    return 'badge-secondary';
            }
        },
        sortBy(field) {
            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }
            this.currentPage = 1; // Reset to first page when sorting
        },
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                this.$emit('page-change', page);
            }
        },
        resetPagination() {
            this.currentPage = 1;
        }
    },
    watch: {
        employees() {
            this.resetPagination();
        }
    }
}
</script>

<style scoped>
.table th {
    cursor: pointer;
    user-select: none;
}

.table th:hover {
    background-color: #f8f9fa;
}

.table th i {
    margin-left: 5px;
    font-size: 0.8em;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1);
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

.pagination {
    margin-bottom: 0;
}

.page-item.disabled .page-link {
    pointer-events: none;
    cursor: not-allowed;
}

.badge {
    font-size: 0.75em;
}

.dataTables_info {
    padding-top: 0.75rem;
}

.fas {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}
</style>
