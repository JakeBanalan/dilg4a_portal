<style>
th,
td {
    padding: 8px;
    /* Optional: Add padding for better spacing */
    white-space: nowrap;
    /* Prevent text from wrapping */
    overflow: hidden;
    /* Hide overflow content */
    text-overflow: ellipsis;
    /* Display ellipsis (...) for overflowed text */
    max-width: 300px;
    /* Maximum width of cells */
}

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
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Create
                                            RFQ
                                        </h5>
                                        <div class="d-flex">
                                            <button class="btn btn-primary btn-fw btn-icon-text mx-2"
                                                @click="openModal()">
                                                <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                                Create RFQ
                                            </button>
                                            <button type="button" class="btn btn-primary btn-fw btn-icon-text mx-2"
                                                @click="toggleSearch">
                                                <font-awesome-icon :icon="['fas', 'magnifying-glass']"></font-awesome-icon>
                                                Advanced Search
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Advanced Search Form -->
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <div v-if="searchVisible">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="text" v-model="searchQuery.rfqNo" class="form-control"
                                                        placeholder="RFQ #">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" v-model="searchQuery.rfqDate"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" v-model="searchQuery.rfqDeadline"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" v-model="searchQuery.createdBy"
                                                        class="form-control" placeholder="Created By">
                                                </div>
                                            </div>

                                            <div class="d-flex" style="float:right;">
                                                <button type="button" class="btn btn-primary btn-icon-text"
                                                    @click="applySearch">
                                                    <font-awesome-icon :icon="['fas', 'magnifying-glass']"></font-awesome-icon>
                                                    Search</button>
                                                <button type="button" class="btn btn-secondary btn-icon-text mx-2"
                                                    @click="resetSearch">
                                                    <font-awesome-icon :icon="['fas', 'rotate']"></font-awesome-icon>
                                                    Reset</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive" v-if="displayedItems.length" style="padding-top:10px;">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">ACTION</th>
                                                    <th style="width: 10%;">REQUEST FOR QUOTATION #</th>
                                                    <th style="width: 10%;">RFQ DATE</th>
                                                    <th style="width: 10%;">RFQ DEADLINE</th>
                                                    <th>PARTICULARS</th>
                                                    <th style="width: 10%;">CREATED BY</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="RFQ in displayedItems" :key="RFQ.id">
                                                    <td v-if="isAdmin">
                                                        <button type="button" class="btn btn-primary btn-icon-text mx-1"
                                                            @click="viewRFQ(RFQ.id, RFQ.pr_id, RFQ.rfq_no)"
                                                            style="background-color:#059886; color:#fff;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'eye']"></font-awesome-icon> View
                                                        </button>
                                                        <!-- <button type="button" class="btn btn-danger btn-icon-text mx-1"
                                                            @click="cancelRFQ(RFQ.id)">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'trash']"></font-awesome-icon> Cancel
                                                        </button> -->
                                                    </td>
                                                    <td><b>{{ RFQ.rfq_no }}</b></td>
                                                    <td>{{ dateFormat(RFQ.rfq_date) }}</td>
                                                    <td>{{ dateFormat(RFQ.rfq_deadline) }}</td>
                                                    <td>{{ RFQ.particulars }}</td>
                                                    <td>{{ RFQ.created_by }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <Pagination :total="displayedItems.length" :currentPage="currentPage"
                                            :itemsPerPage="itemsPerPage" @pageChange="onPageChange" />
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
        <ModalRFQ :visible="modalVisible" @close="closeModal" @post="HandlePost" />
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import UserInfo from '../../procurement/user_info.vue';
import Pagination from '../Pagination.vue';
import ModalRFQ from './modal/modal_create_rfq.vue';
import StatBox from '../stat_board.vue';

import axios from 'axios';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faEye, faPaperPlane, faRotate, faMagnifyingGlass, faPlus } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";
import { formatTotalAmount } from '../../../globalMethods';
import { formatDate } from '../../../globalMethods';
library.add(faEye, faPaperPlane, faRotate, faMagnifyingGlass, faPlus);
export default {
    name: 'Request for Quotation',
    props: {

    },
    data() {
        return {
            userId: null,
            selected: null,
            options: [],
            admins: [3310, 2563],
            // totalPages: 0,
            // purchaseRequests: [],
            RFQs: [],
            selectedRows: [],
            currentPage: 1,
            itemsPerPage: 10,
            modalVisible: false,
            searchVisible: false,
            searchQuery: {
                rfqNo: '',
                rfqDate: '',
                rfqDeadline: '',
                createdBy: ''
            }

        };
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        UserInfo,
        Pagination,
        FontAwesomeIcon,
        ModalRFQ,
        StatBox
    },
    computed: {
        totalPages() {
            return Math.ceil(this.RFQs.length / this.itemsPerPage);
        },
        // Apply pagination to filtered RFQs
        displayedItems() {
            const filtered = this.filteredRFQs();
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return filtered.slice(start, end);
        },
        showingEntriesMessage() {
            const filtered = this.filteredRFQs();
            const start = (this.currentPage - 1) * this.itemsPerPage + 1;
            const end = Math.min(start + this.itemsPerPage - 1, filtered.length);
            return `Showing ${start} to ${end} of ${filtered.length} entries`;
        }
    },
    created() {
        this.userId = parseInt(localStorage.getItem('userId'));
    },
    mounted() {
        this.fetchRFQ();
        // this.loadData();
        // this.fetchSubmittedPurchaseRequest();
        this.userId = localStorage.getItem('userId');


    },
    methods: {
        // Toggle the visibility of the advanced search form
        toggleSearch() {
            this.searchVisible = !this.searchVisible;
        },
        // Apply the search filter based on the query
        applySearch() {
            this.currentPage = 1; // Reset to first page on new search
            this.fetchRFQ();
        },
        // Reset the search query and fetch the data again
        resetSearch() {
            this.searchQuery = {
                rfqNo: '',
                rfqDate: '',
                rfqDeadline: '',
                createdBy: ''
            };
            this.fetchRFQ();
        },
        // Filter the RFQs based on the search query
        filteredRFQs() {
            return this.RFQs.filter(rfq => {
                const matchesRFQNo = rfq.rfq_no.includes(this.searchQuery.rfqNo);
                const matchesRFQDate = this.searchQuery.rfqDate ? rfq.rfq_date === this.searchQuery.rfqDate : true;
                const matchesRFQDeadline = this.searchQuery.rfqDeadline ? rfq.rfq_deadline === this.searchQuery.rfqDeadline : true;
                const matchesCreatedBy = rfq.created_by.toLowerCase().includes(this.searchQuery.createdBy.toLowerCase());

                return matchesRFQNo && matchesRFQDate && matchesRFQDeadline && matchesCreatedBy;
            });
        },
        HandlePost() {
            this.fetchRFQ();
            this.closeModal();
        },
        isAdmin() {
            return this.admins.includes(this.userId);
        },
        dateFormat(date) {
            return formatDate(date);
        },
        openModal() {
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        formatAmount(price) {
            return formatTotalAmount(price);
        },
        selectAllRows(event) {
            if (event.target.checked) {
                this.selectedRows = this.displayedItems.map(item => item.id);
            } else {
                this.selectedRows = [];
            }
        },
        selectRow(id) {
            if (this.selectedRows.includes(id)) {
                this.selectedRows = this.selectedRows.filter(rowId => rowId !== id);
            } else {
                this.selectedRows.push(id);
            }
            // console.log("Selected PurchaseRequest IDs:", this.selectedRows);

        },
        // loadData() {
        //     axios.post(`../../api/fetchSubmittedtoGSS`)
        //         .then(response => {
        //             // console.log(response.data.data)
        //             this.purchaseRequests = response.data.data;
        //         })
        //         .catch(error => {
        //             console.error('Error fetching data:', error);
        //         });
        // },
        onPageChange(page) {
            // console.log("Page Change Triggered:", page);
            this.currentPage = page;
        },

        viewRFQ(rfq_id) {
            this.$router.push({ path: '/procurement/rfq', query: { id: rfq_id } });
        },


        fetchRFQ() {
            axios.get('../../api/fetch_rfq')
                .then(response => {
                    this.RFQs = response.data.data;
                    // console.log(this.RFQs);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },

        exportRFQ(rfq_id) {
            // console.log(rfq_id);
            window.location.href = `../../api/export-rfq/${rfq_id}?export=true`;
        },
        // toGSS(id) {
        //     const STATUS_RECEIVED_BY_GSS = 5;
        //     axios.post(`../../api/post_update_status`, {
        //         pr_id: id,
        //         status: STATUS_RECEIVED_BY_GSS,
        //     }
        //     ).then(() => {
        //         toast.success('Successfully submitted to the GSS!', {
        //             autoClose: 2000
        //         });
        //         this.loadData();
        //     }).catch((error) => {

        //     })

        // }
    },

}
</script>
