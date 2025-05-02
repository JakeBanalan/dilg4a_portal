<style>
.profile_img {
    width: 100px;
    height: 100px;
    padding: 1px;
    margin-bottom: 15%;
    border-radius: 100%;
    border: 1px solid rgb(18, 15, 76);
}

.user_info {
    display: flex;
    justify-content: space-between;
    margin: 0px;
    vertical-align: middle;
    width: 100%;
}

.rank_banner {
    background-color: rgb(104, 34, 142);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner2 {
    background-color: rgb(128, 22, 22);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner3 {
    background-color: rgb(45, 2, 85);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_wrapper {
    -webkit-clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    height: 4.5rem;
    padding-right: 4px;
    padding-top: 2px;
    position: absolute;
    right: 0px;
    text-align: right;
    top: 0px;
    width: 4.5rem;
}

.card_shadow {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    /* Change box shadow on hover for an interactive effect */

}
</style>
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
                        <!-- <div class="col-lg-3">
                            <UserInfo/>
                        </div> -->
                        <div class="col-md-12 grid-margin mb-4 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp; Purchase
                                        Request List
                                    </p>
                                    <div class="box-tools">
                                        <button @click="toCreatePR()" type="button"
                                            class="btn btn-outline-primary btn-fw btn-icon-text">
                                            Create PR
                                        </button>

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
                                                            <div class="table-responsive">
                                                                <div class="card" v-if="isCardVisible">
                                                                    <div class="card-body">
                                                                        <div class="card-title">
                                                                            <h4><font-awesome-icon
                                                                                    :icon="['fas', 'search']" />&nbsp;ADVANCED
                                                                                FILTER</h4>
                                                                        </div>
                                                                        <div class="row">

                                                                            <div class="col-lg-3">
                                                                                <label
                                                                                    style="font-size: 0.875rem;">PURCHASE
                                                                                    REQUEST
                                                                                    No</label>
                                                                                <input type="text" v-model="pr_no"
                                                                                    placeholder="Purchase Request No."
                                                                                    @keyup.enter="filter" />
                                                                            </div>

                                                                            <div class="col-lg-3">
                                                                                <label
                                                                                    style="font-size: 0.875rem;">Start
                                                                                    Date</label>
                                                                                <input type="date" class="form-control"
                                                                                    v-model="pr_date" />
                                                                            </div>
                                                                            <div class="col-lg-3">
                                                                                <label
                                                                                    style="font-size: 0.875rem;">OFFICE/
                                                                                    DIVISION</label>
                                                                                <multiselect v-model="selected_pmo"
                                                                                    :options="pmo" label="label"
                                                                                    :multiple="false"
                                                                                    :searchable="false"
                                                                                    :allow-empty="false"></multiselect>
                                                                            </div>
                                                                            <div class="col-lg-3">
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
                                                                            </div>
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
                                                            </div>
                                                            <table id="pr_id"
                                                                class="table table-bordered mb-3">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <!-- <th style="width: 4px;">ACTION</th>
                                                                        <th class="details-control sorting_disabled"
                                                                            style="width: 100px;">STATUS</th> -->
                                                                        <th class="select-checkbox sorting_disabled"
                                                                            style="width: 61px;">PURCHASE REQUEST #</th>
                                                                        <th class="select-checkbox sorting_disabled"
                                                                            style="width: 61px;">RFQ #</th>
                                                                        <th class="select-checkbox sorting_disabled"
                                                                            style="width: 61px;">AOQ #</th>
                                                                        <th class="sorting" style="width: 107px;">TOTAL
                                                                            AMOUNT</th>
                                                                        <th class="sorting" style="width: 126px;">
                                                                            PURPOSE</th>
                                                                        <th class="sorting" style="width: 126px;">PR
                                                                            DATE</th>
                                                                        <th class="sorting" style="width: 93px;">TARGET
                                                                            DATE</th>
                                                                        <th class="details-control sorting_disabled"
                                                                            style="width: 4px;">CREATED BY</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr id="hover" v-for="pr in displayedItems"
                                                                        :key="pr.id">
                                                                        <td>
                                                                            <b @click.prevent="viewPR(pr.pr_id)">{{
                                                                                pr.pr_no }}</b>
                                                                        </td>
                                                                        <td>
                                                                            <b @click.prevent="viewRFQ(pr.rfq_id)">{{
                                                                                pr.rfq_no }}</b>
                                                                        </td>
                                                                        <td>{{ pr.abstract_no }}</td>
                                                                        <td>{{ this.$formatTotalAmount(pr.total_qty) }}
                                                                        </td>
                                                                        <td>{{ pr.particulars }}</td>
                                                                        <td>{{ dateFormat(pr.pr_date) }}</td>
                                                                        <td>{{ dateFormat(pr.target_date) }}</td>
                                                                        <td>{{ pr.submitted_by }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="mb-2" style="font-weight: 500;">{{
                                                                showingEntriesMessage }}</div>
                                                            <Pagination :total="totalRecords" :currentPage="currentPage"
                                                                :itemsPerPage="itemsPerPage"
                                                                @pageChange="onPageChange" />
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

<script>
import Navbar from '../layout/Navbar.vue';
import Pagination from './Pagination.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import DetailedReport from '../dashboard_tiles/DetailedReport.vue';
import UserInfo from '../procurement/user_info.vue';
import StatBox from './stat_board.vue';
import axios from 'axios';
import { Transition } from 'vue';
import { formatDate } from '../../globalMethods';


export default {
    name: 'Procurement Request',
    props: {
        msg: String,
        visible: Boolean,
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        DetailedReport,
        UserInfo,
        Transition,
        Pagination,
        StatBox,
    },
    data() {
        return {
            isCardVisible: false,
            purchaseRequests: [],
            currentPage: 1,
            itemsPerPage: 10,
        }
    },
    mounted() {
        this.loadData();
    },
    watch: {
        filterParams: {
            handler() {
                this.currentPage = 1; // Reset currentPage to 1
                this.loadData(this.filterParams);
            },
            deep: true
        }
    },
    computed: {
        totalRecords() {
            return this.purchaseRequests.length;
        },

        displayedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.purchaseRequests.slice(start, end);
        },

        showingEntriesMessage() {
            const start = (this.currentPage - 1) * this.itemsPerPage + 1;
            const end = Math.min(start + this.itemsPerPage - 1, this.totalRecords);
            return `Showing ${start} to ${end} of ${this.totalRecords} entries`;
        }
    },
    methods: {
        viewPR(pr_id) {
            // console.log(pr_id)
            this.$router.push({ path: '/procurement/update_pr', query: { id: pr_id } });
        },
        viewRFQ(rfq_id) {
            this.$router.push({ path: '/procurement/rfq', query: { id: rfq_id } });
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
                    console.log(response.data);
                    this.purchaseRequests = response.data;
                    // this.purchaseRequests = response.data.data.map((pr) => ({
                    //     ...pr,
                    //     isBudgetSubmitted: false,
                    //     isGSSSubmitted: false,
                    // }));
                    // console.log(this.purchaseRequests);
                })
                .catch((error) => {
                    console.error('Error fetching data:', error);
                });
        },
        onPageChange(page) {
            this.currentPage = page;
            // Reload user-specific or general data based on role
            this.loadData();
        },
    },

}
</script>
<style>
#hover:hover {
    background-color: rgba(5, 152, 135, 0.258);
    cursor: pointer;
}
</style>