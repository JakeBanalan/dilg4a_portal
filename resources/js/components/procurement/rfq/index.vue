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
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                                @click="openModal()">
                                                Create RFQ
                                            </button>
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                                Advanced Search
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">

                                            <thead>
                                                <tr>
                                                    <th>ACTION</th>
                                                    <th>STATUS</th>
                                                    <th>PURCHASE REQUEST #</th>
                                                    <th>REQUEST FOR QUOTATION #</th>
                                                    <th>TOTAL AMOUNT</th>
                                                    <th style="width: 10px !important;">PARTICULARS</th>
                                                    <th>PR DATE</th>
                                                    <th>TARGET DATE</th>
                                                    <th>Created By</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="purchaseRequest in displayedItems" :key="purchaseRequest.id">
                                                    <td v-if="isAdmin">
                                                        <div v-if="purchaseRequest.status_id == 4">
                                                            
                                                            <button class="btn btn-icon mr-1"
                                                                @click="toGSS(purchaseRequest.id)"
                                                                style="background-color:#059886;color:#fff;">
                                                                <font-awesome-icon
                                                                    :icon="['fas', 'circle-check']"></font-awesome-icon>
                                                            </button>
                                                            <button class="btn btn-icon mr-1"
                                                                style="background-color:#059886;color:#fff;"
                                                                @click="exportRFQ(purchaseRequest.rfq_id)"> <i
                                                                    class="ti-download" style="margin-left: -3px;"></i>
                                                            </button>
                                                        </div>
                                                        <div v-if="purchaseRequest.status_id == 5">
                                                            
                                                            <button disabled class="btn btn-icon mr-1"
                                                                @click="toGSS(purchaseRequest.id)"
                                                                style="background-color:#059886;color:#fff;">
                                                                <font-awesome-icon
                                                                    :icon="['fas', 'circle-check']"></font-awesome-icon>
                                                            </button>
                                                            <button class="btn btn-icon mr-1"
                                                                style="background-color:#059886;color:#fff;"
                                                                @click="exportRFQ(purchaseRequest.rfq_id)"> <i
                                                                    class="ti-download" style="margin-left: -3px;"></i>
                                                            </button>
                                                        </div>
                                                        <div v-if="purchaseRequest.status_id == 6">
                                                            <button class="btn btn-icon mr-1"
                                                                @click="viewRFQ(purchaseRequest.id, purchaseRequest.rfq_id)"
                                                                style="background-color:#059886;color:#fff;">
                                                                <font-awesome-icon
                                                                    :icon="['fas', 'eye']"></font-awesome-icon>
                                                            </button>
                                                            <button disabled class="btn btn-icon mr-1"
                                                                @click="toGSS(purchaseRequest.id)"
                                                                style="background-color:#059886;color:#fff;">
                                                                <font-awesome-icon
                                                                    :icon="['fas', 'circle-check']"></font-awesome-icon>
                                                            </button>
                                                            <button class="btn btn-icon mr-1"
                                                                style="background-color:#059886;color:#fff;"
                                                                @click="exportRFQ(purchaseRequest.rfq_id)"> <i
                                                                    class="ti-download" style="margin-left: -3px;"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div v-if="purchaseRequest.status_id == 1"
                                                            class="badge badge-success">{{ purchaseRequest.status }}
                                                        </div>
                                                        <div v-if="purchaseRequest.status_id == 2"
                                                            class="badge badge-success">{{ purchaseRequest.status }}
                                                        </div>
                                                        <div v-if="purchaseRequest.status_id == 3"
                                                            class="badge badge-success">{{ purchaseRequest.status }}
                                                        </div>
                                                        <div v-if="purchaseRequest.status_id == 4"
                                                            class="badge badge-success">{{ purchaseRequest.status
                                                            }}</div>
                                                        <div v-if="purchaseRequest.status_id == 5"
                                                            class="badge badge-success">{{ purchaseRequest.status }}
                                                        </div>
                                                        <div v-if="purchaseRequest.status_id == 6"
                                                            class="badge badge-success">{{ purchaseRequest.status }}
                                                        </div>
                                                        <div v-if="purchaseRequest.status_id == 7"
                                                            class="badge badge-success">{{ purchaseRequest.status }}
                                                        </div>
                                                        <div v-if="purchaseRequest.status_id == 8"
                                                            class="badge badge-success">{{ purchaseRequest.status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-default"> <b>{{ purchaseRequest.pr_no
                                                                }}</b><br><i>~{{ purchaseRequest.office }}~</i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-default">
                                                            <b>{{ purchaseRequest.rfq_no }}</b><br><i>~RFQ Date: {{
                                                dateFormat(purchaseRequest.rfq_date) }}~</i>
                                                        </div>

                                                    </td>


                                                    <td>Php. {{ formatAmount(purchaseRequest.app_price) }}</td>
                                                    <td style="width: 10px !important;">{{ purchaseRequest.particulars
                                                        }}</td>
                                                    <td>{{ dateFormat(purchaseRequest.pr_date) }}</td>
                                                    <td>{{ dateFormat(purchaseRequest.target_date) }}</td>
                                                    <td>{{ purchaseRequest.created_by }}</td>



                                                </tr>
                                            </tbody>
                                        </table>
                                        <Pagination :total="purchaseRequests.length" @pageChange="onPageChange" />
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
        <ModalRFQ :visible="modalVisible" @close="closeModal" />
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
import { faEye, faPaperPlane } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";
import { formatTotalAmount } from '../../../globalMethods';
import { formatDate } from '../../../globalMethods';
library.add(faEye, faPaperPlane);
export default {
    name: 'Request for Quotation',
    props: {

    },
    data() {
        return {
            userId: null,
            selected: null,
            options: [],
            admins: [3174, 2563],
            purchaseRequests: [],
            selectedRows: [],
            currentPage: 1,
            itemsPerPage: 5,
            modalVisible: false,

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
            return Math.ceil(this.purchaseRequests.length / this.itemsPerPage);
        },
        displayedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.purchaseRequests.slice(start, end);
        },
    },
    created() {
        this.userId = parseInt(localStorage.getItem('userId'));
    },
    mounted() {
        this.loadData();
        this.fetchSubmittedPurchaseRequest();
        this.userId = localStorage.getItem('userId');


    },
    methods: {
        isAdmin() {
            return this.admins.includes(this.userId);
        },
        async fetchSubmittedPurchaseRequest() {
            try {
                const response = await axios.get('../../api/fetchSubmittedPurchaseRequest');
                // Assuming response.data is an array of objects with 'label' and 'value' properties
                this.options = response.data.map(item => item.pr_no);
            } catch (error) {
                console.error('Error fetching submitted purchase requests:', error);
            }
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
            console.log("Selected PurchaseRequest IDs:", this.selectedRows);

        },
        loadData() {
            axios.post(`../../api/fetchSubmittedtoGSS`)
                .then(response => {
                    this.purchaseRequests = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        onPageChange(page) {
            this.currentPage = page;
            // Fetch data for the new page
            this.loadData();
        },

        viewRFQ(pr_id, rfq_id) {
            this.$router.push({ path: '/procurement/rfq', query: { id: rfq_id, pr: pr_id } });
        },

        exportRFQ(rfq_id) {
            console.log(rfq_id);
            window.location.href = `../../api/export-rfq/${rfq_id}?export=true`;
        },
        toGSS(id) {
            const STATUS_RECEIVED_BY_GSS = 5;
            axios.post(`../../api/post_update_status`, {
                pr_id: id,
                status: STATUS_RECEIVED_BY_GSS,
            }
            ).then(() => {
                toast.success('Successfully submitted to the GSS!', {
                    autoClose: 2000
                });
                this.loadData();
            }).catch((error) => {

            })

        }
    },

}
</script>
