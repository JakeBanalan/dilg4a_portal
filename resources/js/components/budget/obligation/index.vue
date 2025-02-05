<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <StatBox />
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon
                                                :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Purchase Request
                                        </h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>CODE</th>
                                                    <th style="max-width:250px;">PURPOSE</th>
                                                    <th>DATE SUBMITTED</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="ob in ob_data" :key="ob.id">
                                                    <td>{{ ob.pr_no }}</td>
                                                    <td style="max-width:250px;">{{ ob.purpose }}</td>
                                                    <td>{{ ob.submitted_date_budget }}</td>
                                                    <td>
                                                        <button @click="openModal(ob.pr_no, ob.id)"
                                                            class="btn btn-icon mr-1"
                                                            style="background-color:#059886;color:#fff;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'search']"></font-awesome-icon>
                                                        </button>
                                                        <button class="btn btn-icon mr-1"
                                                            style="background-color:#059886;color:#fff;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'undo']"></font-awesome-icon>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="mb-2" style="font-weight: 500;">{{ showingEntriesMessage }}</div>
                                <Pagination :total="totalOb" :currentPage="currentView" :itemsPerView="itemsPerView"
                                    @pageChange="onViewChange" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon
                                                :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Purchase Order
                                        </h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>CODE</th>
                                                    <th>SUPPLIER</th>
                                                    <th>AMOUNT</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="po in po_data" :key="po.id">
                                                    <td>{{ po.po_no }}</td>
                                                    <td>{{ po.supplier_title }}</td>
                                                    <td>{{ formatAmount(po.total_quotation) }}</td>
                                                    <td>
                                                        <button class="btn btn-icon mr-1"
                                                            style="background-color:#059886;color:#fff;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'search']"></font-awesome-icon>
                                                        </button>
                                                        <button class="btn btn-icon mr-1"
                                                            style="background-color:#059886;color:#fff;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'undo']"></font-awesome-icon>
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
                </div>
            </div>
        </div>
        <ModalCode :visible="modalVisible" @close="closeModal" :prNo="pr_no" :prId="pr_id" />
    </div>
</template>

<script>
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import StatBox from '../stat_board.vue';
import ModalCode from './modal.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCircleCheck, faCircleInfo, faDownload, faEye, faLayerGroup, faList, faPesoSign, faSearch, faUndo } from '@fortawesome/free-solid-svg-icons';
import { formatTotalAmount } from '../../../globalMethods';
import Pagination from '../../procurement/Pagination.vue';

library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign, faDownload, faSearch, faUndo);

export default {
    name: 'Obligation',
    data() {
        return {
            currentView: 1,
            itemsPerView: 10,
            ob_data: [],
            po_data: [],
            supplier: [],
            modalVisible: false,
            pr_id: null,
            pr_no: null,
            totalOb: 0, // Store total count from API
        };
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        StatBox,
        ModalCode,
        Pagination
    },
    mounted() {
        this.fetch_pr_submitted();
        this.fetch_po_created();
    },
    computed: {
        showingEntriesMessage() {
            if (this.totalOb === 0) return "No entries available.";
            const start = (this.currentView - 1) * this.itemsPerView + 1;
            const end = Math.min(start + this.itemsPerView - 1, this.totalOb);
            return `Showing ${start} to ${end} of ${this.totalOb} entries`;
        }
    },
    methods: {
        onViewChange(page) {
            this.currentView = page;
            this.fetch_pr_submitted();
        },
        formatAmount(amount) {
            return formatTotalAmount(amount);
        },
        openModal(pr_no, pr_id) {
            this.pr_no = pr_no;
            this.pr_id = pr_id;
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        fetch_pr_submitted() {
            this.isLoading = true; // Set loading state
            axios.get(`../../api/getPurchaseRequest?page=${this.currentView}&itemsPerPage=${this.itemsPerView}`)
                .then(response => {
                    this.ob_data = response.data.data;
                    this.totalOb = response.data.total;
                    this.currentView = response.data.current_page;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                })
                .finally(() => {
                    this.isLoading = false; // Reset loading state
                });
        },
        fetch_po_created() {
            axios.get(`../../api/getPurchaseOrder`)
                .then(response => {
                    this.po_data = response.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
    },
};
</script>
