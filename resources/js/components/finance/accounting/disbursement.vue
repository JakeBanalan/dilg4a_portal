<template>
    <Navbar />
    <div class="container-fluid page-body-wrapper">
        <Sidebar />
        <div class="main-panel">
            <div class="content-wrapper">
                <BreadCrumbs />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mt-12">
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Disbursements
                                    </h5>
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                        @click="openCreateModal">
                                        <font-awesome-icon :icon="['fas', 'plus']" class="mr-2"></font-awesome-icon>
                                        Create
                                    </button>
                                </div>

                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DV</th>
                                            <th>ORS</th>
                                            <th>Payee</th>
                                            <th>Particular</th>
                                            <th>Amount</th>
                                            <th>Net</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="loading">
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr v-if="disbursements.length === 0">
                                            <td colspan="8" class="text-center">No records found.</td>
                                        </tr>
                                        <tr v-else v-for="disbursement in disbursements"
                                            :key="disbursement.id || disbursement.ID">
                                            <td>{{ disbursement.dv }}</td>
                                            <td>{{ disbursement.ors }}</td>
                                            <td>{{ disbursement.payee }}</td>
                                            <td>{{ disbursement.particular }}</td>
                                            <td>{{ formatCurrency(disbursement.amount) }}</td>
                                            <td>{{ formatCurrency(disbursement.net) }}</td>
                                            <td>{{ disbursement.status }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    @click="openEditModal(disbursement)">
                                                    Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    @click="deleteDisbursement(disbursement.ID)">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="mb-2" style="font-weight: 500;">{{ showingEntriesMessage }}</div>
                                <Pagination :total="totalRecords" :currentPage="currentPage"
                                    :itemsPerPage="itemsPerPage" @pageChange="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <FooterVue />
        </div>

        <!-- Edit Modal -->
        <div v-if="showEditModal" class="modal fade show" tabindex="-1"
            style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Disbursement</h5>
                        <button type="button" class="btn-close" @click="closeEditModal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateDisbursement">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="editPayee">Payee</label>
                                        <input type="text" id="editPayee" v-model="editForm.payee" class="form-control"
                                            required />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="editParticular">Particular</label>
                                        <textarea id="editParticular" v-model="editForm.particular" class="form-control"
                                            required></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="editAmount">Amount</label>
                                        <input type="number" id="editAmount" v-model="editForm.amount"
                                            class="form-control" required />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="editNet">Net Amount</label>
                                        <input type="number" id="editNet" v-model="editForm.net" class="form-control"
                                            required />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="editDV">DV Number</label>
                                        <input type="text" id="editDV" v-model="editForm.dv" class="form-control"
                                            required />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="editORS">ORS Number</label>
                                        <input type="text" id="editORS" v-model="editForm.ors" class="form-control"
                                            required />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="editStatus">Status</label>
                                        <select id="editStatus" v-model="editForm.status" class="form-control" required>
                                            <option value="">Select status</option>
                                            <option value="Unpaid">Unpaid</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Paid">Paid</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="editRemarks">Remarks</label>
                                        <textarea id="editRemarks" v-model="editForm.remarks"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="closeEditModal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import Pagination from '../../procurement/Pagination.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faList, faPlus, faSpinner } from '@fortawesome/free-solid-svg-icons';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import Swal from 'sweetalert2';

library.add(faList, faPlus, faSpinner);

export default {
    name: 'Disbursement',
    components: {
        FontAwesomeIcon,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
    },
    data() {
        return {
            disbursements: [],
            currentPage: 1,
            itemsPerPage: 10,
            totalRecords: 0,
            showingEntriesMessage: '',
            loading: false,
            showEditModal: false,
            editForm: {
                id: null,
                dv: '',
                ors: '',
                payee: '',
                particular: '',
                amount: 0,
                tax: 0,
                gsis: 0,
                pagibig: 0,
                philhealth: 0,
                other: 0,
                total: 0,
                net: 0,
                datereleased: '',
                timereleased: '',
                remarks: '',
                status: '',
                lddap_entries: [],
            },
        };
    },
    mounted() {
        this.fetchDisbursements();
    },
    methods: {
        async fetchDisbursements() {
            this.loading = true;
            try {
                const response = await axios.get(`/api/finance/accounting/disbursements`, {
                    params: { page: this.currentPage || 1, per_page: this.perPage || 10 }
                });
                const { data, from, to, total } = response.data;
                this.disbursements = data || [];
                this.totalRecords = total || 0;
                this.showingEntriesMessage = `Showing ${from || 0} to ${to || 0} of ${total || 0} entries`;
            } catch (error) {
                console.error('Error fetching disbursements:', error.response);
            } finally {
                this.loading = false;
            }
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP',
            }).format(value);
        },

        openEditModal(disbursement) {
            this.editForm = {
                ...disbursement,
                id: disbursement.id || disbursement.ID || null
            };
            this.showEditModal = true;
        },

        closeEditModal() {
            this.showEditModal = false;
        },

        async updateDisbursement() {
            try {
                const payload = { ...this.editForm };
                delete payload.id;

                const response = await axios.put(
                    `/api/finance/accounting/disbursement/${this.editForm.id}`,
                    payload
                );

                // Reflect changes instantly in the local state
                const index = this.disbursements.findIndex(
                    d => d.id === this.editForm.id || d.ID === this.editForm.id
                );
                if (index !== -1) {
                    this.disbursements[index] = {
                        ...this.disbursements[index],
                        ...payload,
                    };
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message || 'Disbursement updated successfully!',
                });

                this.closeEditModal();

            } catch (error) {
                console.error('Error updating disbursement:', error);

                let message = 'Failed to update disbursement.';
                if (error.response?.data?.errors) {
                    message = Object.values(error.response.data.errors).flat().join('\n');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: message,
                });
            }
        },
        async deleteDisbursement(id) {
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the disbursement.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            });

            if (result.isConfirmed) {
                try {
                    const response = await axios.delete(
                        `/api/finance/accounting/disbursement/${id}`
                    );

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.data.message || 'The disbursement has been deleted.',
                    });

                    this.fetchDisbursements();
                } catch (error) {
                    console.error('Error deleting disbursement:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete disbursement. Please try again.',
                    });
                }
            }
        },

        openCreateModal() {
            this.$router.push('/finance/accounting/disbursement/create');
        },

        onPageChange(page) {
            this.currentPage = page;
            this.fetchDisbursements();
        },
    },
};
</script>
