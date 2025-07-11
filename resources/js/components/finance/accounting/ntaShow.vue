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
                                        <font-awesome-icon :icon="['fas', 'info-circle']"></font-awesome-icon>&nbsp;NTA
                                        Details
                                    </h5>
                                    <div>
                                        <button class="btn btn-outline-secondary btn-fw btn-icon-text mx-2"
                                            @click="goBack">
                                            <font-awesome-icon :icon="['fas', 'arrow-left']"
                                                class="mr-2"></font-awesome-icon>Back
                                        </button>
                                    </div>
                                </div>
                                <div v-if="loading" class="text-center">
                                    <font-awesome-icon :icon="['fas', 'spinner']" spin size="2x" />
                                </div>
                                <div v-else>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="bg-light p-3">
                                                <h6>NTA NUMBER:</h6>
                                                <p>{{ nta.nta_number }}</p>
                                                <h6>PARTICULAR:</h6>
                                                <p>{{ nta.particular }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-light p-3">
                                                <h6>TOTAL AMOUNT:</h6>
                                                <p class="text-primary">{{ formatCurrency(nta.amount) }}</p>
                                                <h6>DISBURSED AMOUNT:</h6>
                                                <p class="text-danger">{{ formatCurrency(nta.obligated) }}</p>
                                                <h6>BALANCE:</h6>
                                                <p class="text-success">{{ formatCurrency(nta.balance) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                            @click="openCreateModal">
                                            <font-awesome-icon :icon="['fas', 'plus']" class="mr-2"></font-awesome-icon>
                                            Add row
                                        </button>

                                    </div>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>DV No.</th>
                                                <th>ORS/BURS No.</th>
                                                <th>ORS Date</th>
                                                <th>Date Disbursed</th>
                                                <th>Payee</th>
                                                <th>Gross Amount</th>
                                                <th>Total Deductions</th>
                                                <th>Net Amount</th>
                                                <th>Disbursed Amount</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="newRows.length > 0">
                                            <tr v-for="(row, index) in newRows" :key="'new-' + index">
                                                <td><input v-model="row.dv_no" class="form-control" /></td>
                                                <td><input v-model="row.ors_burs_no" class="form-control" /></td>
                                                <td><input type="date" v-model="row.ors_date" class="form-control" />
                                                </td>
                                                <td><input type="date" v-model="row.date_disbursed"
                                                        class="form-control" /></td>
                                                <td><input v-model="row.payee" class="form-control" /></td>
                                                <td><input type="number" v-model="row.gross_amount"
                                                        class="form-control" /></td>
                                                <td><input type="number" v-model="row.total_deductions"
                                                        class="form-control" /></td>
                                                <td><input type="number" v-model="row.net_amount"
                                                        class="form-control" /></td>
                                                <td><input type="number" v-model="row.disbursed_amount"
                                                        class="form-control" /></td>
                                                <td><input v-model="row.remarks" class="form-control" /></td>
                                                <td><input v-model="row.status" class="form-control" /></td>
                                                <td>
                                                    <button @click="deleteRow(index)"
                                                        class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tbody v-else>
                                            <tr>
                                                <td colspan="12" class="text-center">No rows added yet.</td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <FooterVue />
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faInfoCircle, faArrowLeft, faSpinner, faPlus } from '@fortawesome/free-solid-svg-icons';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';

library.add(faInfoCircle, faArrowLeft, faSpinner, faPlus);

export default {
    name: 'ntaShow',
    components: {
        FontAwesomeIcon,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs
    },
    data() {
        return {
            nta: {},
            disbursements: [],
            newRows: [],         // your added rows
            loading: true,
        };
    },
    created() {
        const id = this.$route.params.id; // Get ID from route params
        this.fetchNTA(id);
        this.fetchDisbursements(id);
    },
    methods: {
        async fetchNTA(id) {
            try {
                const response = await axios.get(`/api/finance/accounting/nta/${id}`);
                this.nta = response.data;
            } catch (error) {
                console.error('Error fetching NTA details:', error);
                this.$router.push('/finance/accounting/nta'); // Redirect to NTA list on error
            } finally {
                this.loading = false;
            }
        },
        async fetchDisbursements(id) {
            try {
                const response = await axios.get(`/api/nta/${id}/disbursements`);
                this.disbursements = response.data;
            } catch (error) {
                console.error('Error fetching disbursements:', error);
            }
        },
        goBack() {
            this.$router.push('/finance/accounting/nta');
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(value);
        },
        openCreateModal() {
            this.newRows.push({
                dv_no: '',
                ors_burs_no: '',
                ors_date: '',
                date_disbursed: '',
                payee: '',
                gross_amount: 0,
                total_deductions: 0,
                net_amount: 0,
                disbursed_amount: 0,
                remarks: '',
            });
        },

        deleteRow(index) {
            this.newRows.splice(index, 1);
        },
    },
};

</script>
