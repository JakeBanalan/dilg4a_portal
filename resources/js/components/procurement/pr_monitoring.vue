<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="card" style="margin-bottom: 1%;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                            <p class="mb-4">Pending Purchase Requests</p>
                                            <p class="fs-30 mb-2">{{ stats.total_pr }}</p>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-light-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Total RFQs</p>
                                            <p class="fs-30 mb-2">{{ stats.total_rfq }}</p>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-light-danger">
                                        <div class="card-body">
                                            <p class="mb-4">Total AOQs</p>
                                            <p class="fs-30 mb-2">{{ stats.total_aoq }}</p>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Completed Purchase Requests</p>
                                            <p class="fs-30 mb-2">{{ stats.completed_pr }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin mb-4 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;
                                        Purchase Request Monitoring
                                    </p>
                                    <div class="box-tools">
                                        <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                            @click="toggleCard()">
                                            Advanced Search
                                        </button>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <div id="example_wrapper"
                                                    class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6"></div>
                                                        <div class="col-sm-12 col-md-6"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="card" v-if="isCardVisible">
                                                                <div class="card-body">
                                                                    <div class="card-title">
                                                                        <h4><font-awesome-icon
                                                                                :icon="['fas', 'search']" />&nbsp;ADVANCED
                                                                            FILTER</h4>
                                                                    </div>
                                                                    <div class="row">

                                                                        <div class="col-lg-3">
                                                                            <label style="font-size: 0.875rem;">PURCHASE
                                                                                REQUEST
                                                                                No</label>
                                                                            <input type="text"
                                                                                placeholder="Purchase Request No." />
                                                                        </div>

                                                                        <div class="col-lg-3">
                                                                            <label style="font-size: 0.875rem;">RFQ
                                                                                #</label>
                                                                            <input type="text" class="form-control" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <label style="font-size: 0.875rem;">AOQ
                                                                                #</label>
                                                                            <input type="text" class="form-control" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <label style="font-size: 0.875rem;">PO
                                                                                #</label>
                                                                            <input type="text" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            <label style="font-size: 0.875rem;">OFFICE/
                                                                                DIVISION</label>
                                                                            <multiselect v-model="selected_division"
                                                                                :options="division" label="name"
                                                                                :multiple="false" :searchable="false"
                                                                                :allow-empty="false"></multiselect>
                                                                        </div>
                                                                        <!-- <div class="col-lg-3">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        style="font-size: 0.875rem;">Status</label>
                                                                                    <multiselect
                                                                                        v-model="selected_status"
                                                                                        deselect-label="Can't remove this value"
                                                                                        track-by="value" label="label"
                                                                                        :options="stat"
                                                                                        :searchable="false"
                                                                                        :allow-empty="false">
                                                                                    </multiselect>
                                                                                </div>
                                                                            </div> -->
                                                                    </div>

                                                                    <button type="button"
                                                                        class="btn btn-outline-primary btn-fw btn-icon-text"
                                                                        style="float:right;"
                                                                        @click="filter()">Filter</button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary btn-fw btn-icon-text mr-3"
                                                                        style="float:right;"
                                                                        @click="resetFilter()">Clear</button>
                                                                </div>
                                                            </div>
                                                            <table id="prmtable" class="table table-bordered mb-3">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th class="select-checkbox sorting_disabled"
                                                                            style="width: 5%;">PURCHASE REQUEST
                                                                            #</th>
                                                                        <th class="select-checkbox sorting_disabled"
                                                                            style="width: 5%;">RFQ #</th>
                                                                        <th class="select-checkbox sorting_disabled"
                                                                            style="width: 5%;">AOQ #</th>
                                                                        <th class="select-checkbox sorting_disabled">
                                                                            RESO</th>
                                                                        <th class="select-checkbox sorting_disabled">PO
                                                                        </th>
                                                                        <th class="select-checkbox sorting_disabled">NOA
                                                                        </th>
                                                                        <th class="select-checkbox sorting_disabled">NTP
                                                                        </th>
                                                                        <th style="min-width:300px; width:70%;">
                                                                            PURPOSE</th>
                                                                        <th style="min-width: 50px; width:5%;">CREATED
                                                                            BY</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="pr in purchaseRequests" :key="pr.id">
                                                                        <td class="prm-cell">
                                                                            <b @click.prevent="viewPR(pr.pr_id)">{{
                                                                                pr.pr_no }}</b>
                                                                            <br> ~PR Date:{{ pr.pr_date }}~
                                                                        </td>
                                                                        <td class="prm-cell">
                                                                            <template v-if="pr.rfq_id">
                                                                                <b @click.prevent="viewRFQ(pr.rfq_id)">{{
                                                                                    pr.rfq_no }}</b>
                                                                                <br> ~RFQ Date:{{ pr.rfq_date }}~
                                                                            </template>
                                                                            <template v-else>
                                                                                <div class="prm-hover-area">
                                                                                    <div
                                                                                        class="badge badge-success hover-badge">
                                                                                        Create RFQ</div>
                                                                                </div>
                                                                            </template>
                                                                        </td>
                                                                        <td class="prm-cell">
                                                                            <template v-if="pr.abstract_no">
                                                                                <b
                                                                                    @click.prevent="viewAOQ(pr.rfq_id, pr.aoq_id)">{{
                                                                                        pr.abstract_no }}</b>
                                                                                <br> ~AOQ Date: {{ pr.abstract_date }}~
                                                                            </template>
                                                                            <template v-else-if="pr.rfq_id">
                                                                                <div class="prm-hover-area">
                                                                                    <div
                                                                                        class="badge badge-success hover-badge">
                                                                                        Create AOQ</div>
                                                                                </div>
                                                                            </template>
                                                                        </td>
                                                                        <td class="prm-cell"></td>
                                                                        <td class="prm-cell"></td>
                                                                        <td class="prm-cell"></td>
                                                                        <td class="prm-cell"></td>
                                                                        <td class="prm-cell"
                                                                            style="text-align:left; white-space: normal; word-break: break-word;">
                                                                            {{ pr.purpose }}</td>
                                                                        <td class="prm-cell">{{ pr.ferson }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

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
                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import Navbar from '../layout/Navbar.vue';
import Pagination from './Pagination.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import DetailedReport from '../dashboard_tiles/DetailedReport.vue';
import UserInfo from '../procurement/user_info.vue';
import axios from 'axios';
import Multiselect from 'vue-multiselect';
import { Transition } from 'vue';
import { formatDate } from '../../globalMethods';


export default {
    name: 'Procurement Request',
    props: {
        msg: String,
        visible: Boolean,
    },
    components: {
        Multiselect,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        DetailedReport,
        UserInfo,
        Transition,
        Pagination,
    },
    data() {
        return {
            isCardVisible: false,
            purchaseRequests: [],
            stats: [],
            division: [
                { id: 'FAD', name: 'Finance and Administrative Division' },
                { id: 'ORD', name: 'Office of the Regional Director' },
                { id: 'LGMED', name: 'Local Government Monitoring and Evaluation Division' },
                { id: 'LGCDD', name: 'Local Government Capacity Development Division' },
            ]
        }
    },
    mounted() {
        this.loadData();
        this.statbox();
    },
    watch: {
    },
    computed: {
    },
    methods: {
        statbox() {
            axios.get(`../api/pr_monitoring_stats`)
                .then((response) => {
                    this.stats = response.data;
                    // console.log(this.stats);
                })
                .catch((error) => {
                    console.error('Error fetching data:', error);
                });
        },
        viewPR(pr_id) {
            // console.log(pr_id)
            this.$router.push({ path: '/procurement/update_pr', query: { id: pr_id } });

        },
        viewRFQ(rfq_id) {
            this.$router.push({ path: '/procurement/rfq', query: { id: rfq_id } });
        },
        viewAOQ(rfq_id, aoq_id) {
            this.$router.push({ path: '/procurement/abstract', query: { id: rfq_id, abstract: aoq_id } });
        },
        dateFormat(date) {
            return formatDate(date);
        },
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
        },
        loadData() {
            axios
                .post(`../api/fetchPRMonitor`)
                .then((response) => {
                    this.purchaseRequests = response.data;
                    this.initializeDataTable();
                    // console.log(this.purchaseRequests);
                })
                .catch((error) => {
                    console.error('Error fetching data:', error);
                });
        },
        initializeDataTable() {

            $('#prmtable').DataTable().destroy(); // clean up
            this.$nextTick(() => {
                $('#prmtable').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                    searching: true,
                    lengthChange: false,
                });
                this.dataTableInitialized = true;

            });
        },
    },

}
</script>
<style>
/* #hover:hover {
    background-color: rgba(5, 152, 135, 0.258);
    cursor: pointer;
} */

.prm-cell {
    transition: background-color 0.3s ease;
}

.prm-cell:hover {
    background-color: rgba(5, 152, 135, 0.258);
}

.prm-hover-area {
    position: relative;
    height: 100%;
}

.hover-badge {
    display: none;
    cursor: pointer;
}

.prm-cell:hover .hover-badge {
    display: inline-block;
}
</style>