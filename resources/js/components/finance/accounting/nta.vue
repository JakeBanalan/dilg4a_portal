<style>
.btn-custom {
    padding: 15% !important;
}

.badge-cancelled {
    color: #fff;
    background-color: #3c3b41;
}

.badge-with-rfq {
    color: #fff;
    background-color: #923909;
}

.badge-received_gss {
    color: #fff;
    background-color: #0f087a;
}

.badge-submitted_gss {
    color: #fff;
    background-color: #890564;
}
</style>
<template>
    <Navbar />
    <div class="container-fluid page-body-wrapper">
        <Sidebar />

        <div class="main-panel">
            <div class="content-wrapper">
                <BreadCrumbs />
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">{{ formatCurrency(totalAmount) }}</h5>
                                <p class="card-text">Total NTA/NCA Amount</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">{{ formatCurrency(totalDisbursed) }}</h5>
                                <p class="card-text">Disbursed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title">{{ formatCurrency(totalRemainingBalance) }}</h5>
                                <p class="card-text">Total Remaining Balance</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mt-12">
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;NTA/NCA
                                    </h5>
                                    <div class="d-flex">
                                        <button v-if="role === 'admin'"
                                            class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                            @click="toggleCard()">
                                            Advanced Search
                                        </button>
                                        <button v-if="role === 'admin'"
                                            class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                            @click="navigateToCreate">
                                            Create NTA / NCA
                                            <font-awesome-icon :icon="['fas', 'plus']" class="ml-2"></font-awesome-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered mb-3" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th style="width: 100px;">NTA NO</th>
                                                <th style="width: 61px;">DATE RECEIVED</th>
                                                <th style="width: 107px;">ACCOUNT NO</th>
                                                <th style="width: 126px;">SARO</th>
                                                <th style="width: 126px;">PARTICULAR</th>
                                                <th style="width: 93px;">AMOUNT</th>
                                                <th style="width: 4px;">DISBURSEMENT</th>
                                                <th style="width: 4px;">BALANCE</th>
                                                <th style="width: 4px;">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="loading">
                                            <tr>
                                                <td colspan="9" class="text-center">
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span>
                                                    Loading...
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else-if="ntas.length">
                                            <tr v-for="nta in ntas" :key="nta.id">
                                                <td>{{ nta.nta_number }}</td>
                                                <td>{{ nta.received_date }}</td>
                                                <td>{{ nta.account_number }}</td>
                                                <td>{{ nta.saro_number }}</td>
                                                <td>{{ nta.particular }}</td>
                                                <td>{{ formatCurrency(nta.amount) }}</td>
                                                <td>{{ formatCurrency(nta.obligated) }}</td>
                                                <td>{{ formatCurrency(nta.balance) }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"
                                                        @click="viewNTA(nta.id)">View</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="9" class="text-center">No records found.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
    </div>
</template>

<script>
import axios from 'axios';
import Pagination from '../../procurement/Pagination.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faDownload, faEye, faPaperPlane, faShareSquare, faTrash, faList, faPlus, faFile } from '@fortawesome/free-solid-svg-icons';
import Swal from 'sweetalert2';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';

library.add(faEye, faPaperPlane, faDownload, faTrash, faShareSquare, faList, faPlus, faFile);

export default {
    name: 'NTA / NCA',
    components: {
        Pagination,
        FontAwesomeIcon,
        axios,
        Swal,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs
    },
    data() {
        return {
            userId: null,
            role: null,
            ntas: [],
            currentPage: 1,
            itemsPerPage: 10,
            totalRecords: 0,
            showingEntriesMessage: '',
            loading: false,
            totalAmount: 0,
            totalDisbursed: 0,
            totalRemainingBalance: 0,
        };
    },
    created() {
        this.userId = parseInt(localStorage.getItem('userId'));
        this.role = localStorage.getItem('user_role');
    },
    mounted() {
        this.loadNTAData();
    },
    methods: {
        async loadNTAData() {
            this.loading = true;
            try {
                const response = await axios.get(
                    `/api/fetch-nta?page=${this.currentPage}&per_page=${this.itemsPerPage}`
                );

                const { data, from, to, total } = response.data;

                this.ntas = data || [];
                this.totalRecords = total || 0;
                this.showingEntriesMessage = `Showing ${from} to ${to} of ${total} entries`;

                // Calculate totals
                this.calculateTotals();
            } catch (error) {
                console.error('Error fetching NTA data:', error);
            } finally {
                this.loading = false;
            }
        },
        calculateTotals() {
            this.totalAmount = this.ntas.reduce((sum, nta) => sum + nta.amount, 0);
            this.totalDisbursed = this.ntas.reduce((sum, nta) => sum + nta.obligated, 0);
            this.totalRemainingBalance = this.totalAmount - this.totalDisbursed;
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(value);
        },
        onPageChange(page) {
            this.currentPage = page;
            this.loadNTAData();
        },
        viewNTA(id) {
            this.$router.push(`/finance/accounting/nta/${id}`);
        },
        navigateToCreate() {
            this.$router.push('/finance/accounting/nta/create'); // Correct navigation to the create page
        },
    },
};
</script>
