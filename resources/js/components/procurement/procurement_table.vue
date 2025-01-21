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
    <table id="pr_id" class="table table-striped table-bordered mb-3">
        <thead>
            <tr role="row">
                <th style="width: 4px;">ACTION</th>
                <th class="details-control sorting_disabled" style="width: 100px;">STATUS</th>
                <th class="select-checkbox sorting_disabled" style="width: 61px;">PURCHASE REQUEST #</th>
                <th class="sorting" style="width: 107px;">TOTAL AMOUNT</th>
                <th class="sorting" style="width: 126px;">PURPOSE</th>
                <th class="sorting" style="width: 126px;">PR DATE</th>
                <th class="sorting" style="width: 93px;">TARGET DATE</th>
                <th class="details-control sorting_disabled" style="width: 4px;">CREATED BY</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="purchaseRequest in displayedItems" :key="purchaseRequest.id">
                <td v-if="role == 'admin'">
                    <div v-if="purchaseRequest.status_id == 1">
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;"
                            @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button title="Send to Budget" v-if="!purchaseRequest.isBudgetSubmitted" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="toBudget(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" />
                        </button>
                        <button title="Send to GSS" v-if="!purchaseRequest.isGSSSubmitted" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="toGSS(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" />
                        </button>
                        <button title="Cancel" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="cancelTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'trash']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div
                        v-else-if="purchaseRequest.status_id == 2 || purchaseRequest.status_id == 3 || purchaseRequest.status_id == 4 || purchaseRequest.status_id == 5">
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;"
                            @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button title="Send to GSS"
                            v-if="purchaseRequest.status_id == 2 && !purchaseRequest.isGSSSubmitted" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="toGSS(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 6">
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;"
                            @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 9">
                        <button disabled title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;"
                            @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                    </div>

                </td>
                <td v-else>
                    <button title="View" type="button" class="btn btn-icon mr-1"
                        style="background-color:#059886;color:#fff;"
                        @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)">
                        <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                    </button>
                    <!-- <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                        @click="exportPurchaseRequest(purchaseRequest.id)">
                        <font-awesome-icon :icon="['fas', 'download']" style="margin-left: -3px;" />
                    </button> -->
                </td>
                <td>
                    <div :class="['badge', purchaseRequest.status_id == 9 ? 'badge-danger' : 'badge-success']">
                        {{ purchaseRequest.status }}
                    </div>
                </td>
                <td>
                    <div class="badge badge-default">
                        <b>{{ purchaseRequest.pr_no }}</b><br><i>~{{ purchaseRequest.office }}~</i>
                        <br>
                        <div v-show="purchaseRequest.is_urgent == 1" class="badge badge-danger">
                            URGENT
                        </div>
                    </div>
                </td>
                <td>Php. {{ this.$formatTotalAmount(purchaseRequest.app_price) }}</td>
                <td>{{ purchaseRequest.particulars }}</td>
                <td>{{ dateFormat(purchaseRequest.pr_date) }}</td>
                <td>{{ dateFormat(purchaseRequest.target_date) }}</td>
                <td>{{ purchaseRequest.created_by }}</td>
            </tr>
        </tbody>

    </table>
    <Pagination :total="totalRecords" :currentPage="currentPage" :itemsPerPage="itemsPerPage"
        @pageChange="onPageChange" />
</template>

<script>
import axios from 'axios';
import Pagination from './Pagination.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faDownload, faEye, faPaperPlane, faShareSquare, faTrash } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";
import { formatDate } from '../../globalMethods';

library.add(faEye, faPaperPlane, faDownload, faTrash, faShareSquare);

export default {
    data() {
        return {
            userId: null,
            role: null,
            purchaseRequests: [],
            currentPage: 1,
            itemsPerPage: 10,
        };
    },
    props: {
        purchaseRequest: {
            type: Object,
            required: false,
            default: () => ({}),
        },
    },
    components: {
        Pagination,
        FontAwesomeIcon
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
        },

    },
    created() {
        this.userId = parseInt(localStorage.getItem('userId'));
        this.role = localStorage.getItem('user_role');
    },
    mounted() {
        this.loadData();
    },
    methods: {
        isAdmin() {
            return this.admins.includes(this.userId);
        },
        dateFormat(date) {
            return formatDate(date);
        },
        loadData() {
            axios.post(`../api/fetchPurchaseReqData`)
                .then(response => {
                    this.purchaseRequests = response.data.data.map(pr => ({
                        ...pr,
                        isBudgetSubmitted: false,
                        isGSSSubmitted: false,
                    }));
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        onPageChange(page) {
            this.currentPage = page;
            this.loadData();
        },
        viewPr(pr_id, step_no) {
            this.$router.push({ path: '/procurement/update_pr', query: { id: pr_id, step: step_no } });
        },
        exportPurchaseRequest(pr_id) {
            window.location.href = `../api/export-purchase-request/${pr_id}?export=true`;
        },
        toBudget(id) {
            axios.post(`../api/updatePurchaseRequestStatus`, {
                id: id,
                status: 2, // Update status to "Budget"
                is_budget_submitted: true, // Mark as submitted to Budget
                submitted_date: null, // Set submitted date
            })
                .then(response => {
                    const updatedRequest = this.purchaseRequests.find(pr => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.isBudgetSubmitted = true; // Update frontend state for Budget
                        // Do not update isGSSSubmitted here
                    }
                    toast.success('Successfully submitted to the Budget!', { autoClose: 2000 });

                    // Reload data after 2 seconds
                    setTimeout(() => {
                        this.loadData();
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                    toast.error('Failed to submit to the Budget. Please try again.', { autoClose: 2000 });
                });
        },
        toGSS(id) {
            axios.post(`../api/updatePurchaseRequestStatus`, {
                id: id,
                status: 4, // Update status to "GSS"
                is_gss_submitted: true, // Mark as submitted to GSS
                submitted_date_gss: null, // Set submitted date
            })
                .then(response => {
                    const updatedRequest = this.purchaseRequests.find(pr => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.isGSSSubmitted = true; // Update frontend state for GSS
                        // Do not update isBudgetSubmitted here
                    }
                    toast.success('Successfully submitted to the GSS!', { autoClose: 2000 });

                    // Reload data after 2 seconds
                    setTimeout(() => {
                        this.loadData();
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                    toast.error('Failed to submit to the GSS. Please try again.', { autoClose: 2000 });
                });
        },
        cancelTransaction(id) {
            this.updatePurchaseRequestStatus(id, 9);
            const updatedRequest = this.purchaseRequests.find(pr => pr.id === id);
            if (updatedRequest) {
                updatedRequest.status_id = 9; // Cancelled Transaction
            }
            toast.success('Successfully Cancelled!', { autoClose: 2000 });
            setTimeout(() => {
                this.loadData();
            }, 2000);
        },
        updatePurchaseRequestStatus(id, status) {
            axios.post(`../api/updatePurchaseRequestStatus`, { id, status })
                .then(response => {
                    // console.log('Status updated:', response.data);
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                });
        },
    },
};
</script>
