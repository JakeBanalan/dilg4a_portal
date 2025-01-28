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
                        <span style="font-size: 10pt; font-weight: bold;">{{ purchaseRequest.pr_no }}</span>
                        <br>
                        <span style="font-style: italic; user-select: none;">~{{ purchaseRequest.office }}~</span>
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
    <div class="mb-2" style="font-weight: 500;">{{ showingEntriesMessage }}</div>
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
        filterParams: {
            type: Object,
            default: () => ({})
        }
    },
    watch: {
        filterParams: {
            handler() {
                this.currentPage = 1; // Reset currentPage to 1
                if (this.role === 'admin') {
                    this.loadData(this.filterParams);
                } else {
                    this.loadDataPerUser(this.filterParams);
                }
            },
            deep: true
        }
    },
    components: {
        Pagination,
        FontAwesomeIcon,
    },
    computed: {
        totalRecords() {
            return this.purchaseRequests.length;
        },
        displayedItems() {
            const filterParams = this.filterParams;
            const filteredRequests = this.purchaseRequests.filter(item => {
                return (
                    (!filterParams.pr_no || item.pr_no.includes(filterParams.pr_no)) &&
                    (!filterParams.pr_date || item.pr_date === filterParams.pr_date) &&
                    (!filterParams.pmo || item.office === filterParams.pmo) &&
                    (!filterParams.status || item.status === filterParams.status)
                );
            });
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return filteredRequests.slice(start, end);
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
        // Load data for specific user or all users based on role
        if (this.role === 'admin') {
            this.loadData(); // Admin sees all requests
        } else {
            this.loadDataPerUser(); // Non-admin sees only their own requests
        }
    },
    methods: {
        dateFormat(date) {
            return formatDate(date);
        },
        loadData() {
            axios
                .post(`../api/fetchPurchaseReqData`)
                .then((response) => {
                    this.purchaseRequests = response.data.data.map((pr) => ({
                        ...pr,
                        isBudgetSubmitted: false,
                        isGSSSubmitted: false,
                    }));
                })
                .catch((error) => {
                    console.error('Error fetching data:', error);
                });
        },
        loadDataPerUser() {
            axios
                .post(`../api/perUserPurchaseReqData`, { user_id: this.userId }) // Send userId in the payload
                .then((response) => {
                    this.purchaseRequests = response.data.data.map((pr) => ({
                        ...pr,
                        isBudgetSubmitted: false,
                        isGSSSubmitted: false,
                    }));
                })
                .catch((error) => {
                    console.error('Error fetching user-specific data:', error);
                });
        },
        onPageChange(page) {
            this.currentPage = page;
            // Reload user-specific or general data based on role
            if (this.role === 'admin') {
                this.loadData();
            } else {
                this.loadDataPerUser();
            }
        },
        viewPr(pr_id, step_no) {
            this.$router.push({ path: '/procurement/update_pr', query: { id: pr_id, step: step_no } });
        },
        toBudget(id) {
            axios
                .post(`../api/updatePurchaseRequestStatus`, {
                    id: id,
                    status: 2,
                    is_budget_submitted: true,
                })
                .then(() => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.isBudgetSubmitted = true;
                    }
                    toast.success('Successfully submitted to the Budget!', { autoClose: 2000 });
                    setTimeout(() => {
                        this.loadDataPerUser();
                    }, 2000);
                })
                .catch((error) => {
                    console.error('Error updating status:', error);
                    toast.error('Failed to submit to the Budget. Please try again.', { autoClose: 2000 });
                });
        },
        toGSS(id) {
            axios
                .post(`../api/updatePurchaseRequestStatus`, {
                    id: id,
                    status: 4,
                    is_gss_submitted: true,
                })
                .then(() => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.isGSSSubmitted = true;
                    }
                    toast.success('Successfully submitted to the GSS!', { autoClose: 2000 });
                    setTimeout(() => {
                        this.loadDataPerUser();
                    }, 2000);
                })
                .catch((error) => {
                    console.error('Error updating status:', error);
                    toast.error('Failed to submit to the GSS. Please try again.', { autoClose: 2000 });
                });
        },
        cancelTransaction(id) {
            this.updatePurchaseRequestStatus(id, 9);
            const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
            if (updatedRequest) {
                updatedRequest.status_id = 9;
            }
            toast.success('Successfully Cancelled!', { autoClose: 2000 });
            setTimeout(() => {
                this.loadDataPerUser();
            }, 2000);
        },
        updatePurchaseRequestStatus(id, status) {
            axios.post(`../api/updatePurchaseRequestStatus`, { id, status }).catch((error) => {
                console.error('Error updating status:', error);
            });
        },
    },
};

</script>
