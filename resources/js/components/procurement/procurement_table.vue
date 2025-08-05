<style scoped>
/* Existing styles remain unchanged */
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

.badge-warning {
    color: #fff;
    background-color: #ffc107;
}

.badge-ord {
    color: #fff;
    background-color: #1133f1;
}

.badge-budget {
    color: #fff;
    background-color: #27c7f8;
}

/* Modal Styles */
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
    transition: opacity 0.3s ease-in-out;
}

.modal-backdrop.fade {
    opacity: 0;
}

.modal-backdrop.show {
    opacity: 1;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: auto;
}

.modal-dialog {
    max-width: 500px;
    margin: 1.75rem auto;
    transition: transform 0.3s ease-out;
    transform: translateY(-50px);
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 3.5rem);
}

.modal-content {
    background-color: #fff;
    border-radius: 0.3rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: none;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 500;
}

.close {
    background: none;
    border: none;
    font-size: 1.5rem;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: 0.5;
    cursor: pointer;
}

.close:hover {
    opacity: 0.75;
}

.modal-body {
    padding: 1rem;
    font-size: 1rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    padding: 1rem;
    border-top: 1px solid #dee2e6;
}

.modal-footer .btn {
    margin-left: 0.5rem;
}

/* Ensure modal is visible when shown */
.modal.show .modal-dialog {
    transform: translateY(0);
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .modal-dialog {
        max-width: 90%;
        margin: 1rem auto;
    }
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
                <td
                    v-if="role == 'admin' || role == 'user' || role == 'gss_admin' || role == 'budget_admin' || role == 'ord_admin'">
                    <div v-if="purchaseRequest.status_id == 1 && (role == 'user' || role == 'admin')"> <!-- DRAFT -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button title="Submit to GSS" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="toGSS(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" />
                        </button>
                        <button title="Cancel" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="cancelTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'trash']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 14 && (role == 'user' || role == 'admin')">
                        <!-- RETURNED_BY_GSS -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button title="Resubmit to GSS" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="toGSS(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" />
                        </button>
                        <button title="Cancel" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="cancelTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'trash']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 15 && (role == 'user' || role == 'admin')">
                        <!-- RETURNED_BY_BUDGET -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button title="Resubmit to Budget" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="toBudget(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" />
                        </button>
                        <button title="Cancel" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="cancelTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'trash']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 16 && (role == 'user' || role == 'admin')">
                        <!-- RETURNED_BY_ORD -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button title="Resubmit to ORD" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="toORD(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" />
                        </button>
                        <button title="Cancel" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="cancelTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'trash']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 2 && role == 'gss_admin'"> <!-- SUBMITTED_TO_GSS -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button v-if="!purchaseRequest.isGSSSubmitted" title="Mark as Received" type="button"
                            class="btn btn-icon mr-1" style="background-color:#ffc107;color:#000;"
                            @click="receiveGSS(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'check']" style="margin-left: -3px;" />
                        </button>
                        <button v-if="!purchaseRequest.isGSSSubmitted" title="Return" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="returnTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'undo']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 3 && role == 'gss_admin'"> <!-- RECEIVED_BY_GSS -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button v-if="!purchaseRequest.isGSSSubmitted" title="Mark GSS Approval" type="button"
                            class="btn btn-icon mr-1" style="background-color:#ffc107;color:#000;"
                            @click="approveGSS(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'thumbs-up']" style="margin-left: -3px;" />
                        </button>
                        <button v-if="!purchaseRequest.isGSSSubmitted" title="Return" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="returnTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'undo']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 4 && (role == 'user' || role == 'admin')">
                        <!-- APPROVED_BY_GSS -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button title="Submit to Budget" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="toBudget(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 5 && role == 'budget_admin'">
                        <!-- SUBMITTED_TO_BUDGET -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button v-if="!purchaseRequest.isBudgetSubmitted" title="Mark as Received" type="button"
                            class="btn btn-icon mr-1" style="background-color:#ffc107;color:#000;"
                            @click="receiveBudget(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'check']" style="margin-left: -3px;" />
                        </button>
                        <button v-if="!purchaseRequest.isBudgetSubmitted" title="Return" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="returnTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'undo']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 6 && role == 'budget_admin'">
                        <!-- RECEIVED_BY_BUDGET -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button v-if="!purchaseRequest.isBudgetSubmitted" title="Mark Budget Approval" type="button"
                            class="btn btn-icon mr-1" style="background-color:#ffc107;color:#000;"
                            @click="approveBudget(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'thumbs-up']" style="margin-left: -3px;" />
                        </button>
                        <button v-if="!purchaseRequest.isBudgetSubmitted" title="Return" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="returnTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'undo']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 7 && (role == 'user' || role == 'admin')">
                        <!-- APPROVED_BY_BUDGET -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button title="Submit to ORD" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="toORD(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 8 && role == 'ord_admin'"> <!-- SUBMITTED_TO_ORD -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button v-if="!purchaseRequest.isORDSubmitted" title="Mark as Received" type="button"
                            class="btn btn-icon mr-1" style="background-color:#ffc107;color:#000;"
                            @click="receiveORD(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'check']" style="margin-left: -3px;" />
                        </button>
                        <button v-if="!purchaseRequest.isORDSubmitted" title="Return" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="returnTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'undo']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 9 && role == 'ord_admin'"> <!-- RECEIVED_BY_ORD -->
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                        <button v-if="!purchaseRequest.isORDSubmitted" title="Mark ORD Approval" type="button"
                            class="btn btn-icon mr-1" style="background-color:#ffc107;color:#000;"
                            @click="approveORD(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'thumbs-up']" style="margin-left: -3px;" />
                        </button>
                        <button v-if="!purchaseRequest.isORDSubmitted" title="Return" type="button"
                            class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="returnTransaction(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'undo']" style="margin-left: -3px;" />
                        </button>
                    </div>
                    <div
                        v-if="[5, 6, 8, 9, 10, 11, 12, 17].includes(purchaseRequest.status_id) && (role == 'user' || role == 'admin')">
                        <button title="View" type="button" class="btn btn-icon mr-1"
                            style="background-color:#059886;color:#fff;" :disabled="purchaseRequest.status_id === 17"
                            @click="viewPr(purchaseRequest.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                    </div>
                </td>
                <td v-else>
                    <button title="View" type="button" class="btn btn-icon mr-1"
                        style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id)">
                        <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                    </button>
                </td>
                <td>
                    <div :class="getBadgeClass(purchaseRequest.status_id)">
                        {{ purchaseRequest.status || 'DRAFT' }}
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
    <!-- Approval Modal -->
    <div v-if="showApprovalModal" class="modal-backdrop fade" :class="{ 'show': showApprovalModal }">
        <div class="modal" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvalModalLabel">
                            {{ approvalType === 'gss' ? 'Approve GSS' :
                                approvalType === 'budget' ? 'Approve Budget' :
                                    approvalType === 'ord' ? 'Approve ORD' :
                                        approvalType === 'gss_receive' ? 'Mark as Received by GSS' :
                                            approvalType === 'budget_receive' ? 'Mark as Received by Budget' :
                                                'Mark as Received by ORD' }}
                        </h5>
                        <button type="button" class="close" @click="showApprovalModal = false" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to
                            {{ approvalType.includes('receive') ? 'mark this purchase request as received'
                                : 'approve this purchase request' }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" @click="showApprovalModal = false">Cancel</button>
                        <button class="btn btn-warning" @click="submitApproval">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-2" style="font-weight: 500;">{{ showingEntriesMessage }}</div>
    <Pagination :total="totalRecords" :currentPage="currentPage" :itemsPerPage="itemsPerPage"
        @pageChange="onPageChange" />
</template>

<script>
import axios from 'axios';
import Pagination from './Pagination.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faPaperPlane, faShareSquare, faTrash, faThumbsUp, faUndo, faCheck } from '@fortawesome/free-solid-svg-icons';
import { toast } from 'vue3-toastify';
import { formatDate } from '../../globalMethods';
import { eventBus } from '../eventBus.js';

library.add(faEye, faPaperPlane, faShareSquare, faTrash, faThumbsUp, faUndo, faCheck);

export default {
    data() {
        return {
            userId: null,
            role: null,
            purchaseRequests: [],
            currentPage: 1,
            itemsPerPage: 10,
            selectedPrId: null,
            showApprovalModal: false,
            approvalType: null,
        };
    },
    props: {
        filterParams: {
            type: Object,
            default: () => ({})
        }
    },
    watch: {
        filterParams: {
            handler(newVal) {
                this.currentPage = 1;
                this.refreshData();
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
            const filteredRequests = this.purchaseRequests.filter(item => {
                return (
                    (!this.filterParams.pr_no || item.pr_no.includes(this.filterParams.pr_no)) &&
                    (!this.filterParams.pr_date || item.pr_date === this.filterParams.pr_date) &&
                    (!this.filterParams.pmo || item.office === this.filterParams.pmo) &&
                    (!this.filterParams.status || item.status === this.filterParams.status)
                );
            });
            return filteredRequests.length;
        },
        displayedItems() {
            const filteredRequests = this.purchaseRequests.filter(item => {
                const matches = (
                    (!this.filterParams.pr_no || item.pr_no.includes(this.filterParams.pr_no)) &&
                    (!this.filterParams.pr_date || item.pr_date === this.filterParams.pr_date) &&
                    (!this.filterParams.pmo || item.office === this.filterParams.pmo) &&
                    (!this.filterParams.status || item.status === this.filterParams.status)
                );
                return matches;
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
        const userId = localStorage.getItem('userId');
        this.userId = userId ? parseInt(userId) : null;
        this.role = localStorage.getItem('user_role');
        if (!this.userId || !this.role) {
            toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
            this.$router.push('/login');
        }
    },
    mounted() {
        if (this.userId && this.role) {
            this.setupWebSocket();
            this.refreshData();
        }
    },
    beforeUnmount() {
        window.Echo.leave(`notifications.${this.userId}`);
        if (this.role === 'gss_admin') {
            window.Echo.leave('notifications.gss_admin');
        } else if (this.role === 'budget_admin') {
            window.Echo.leave('notifications.budget_admin');
        } else if (this.role === 'ord_admin') {
            window.Echo.leave('notifications.ord_admin');
        }
    },
    methods: {
        dateFormat(date) {
            return formatDate(date);
        },
        getBadgeClass(statusId) {
            const badgeClasses = {
                1: 'badge-success', // DRAFT
                2: 'badge-submitted_gss', // SUBMITTED_TO_GSS
                3: 'badge-received_gss', // RECEIVED_BY_GSS
                4: 'badge-budget', // APPROVED_BY_GSS
                5: 'badge-budget', // SUBMITTED_TO_BUDGET
                6: 'badge-budget', // RECEIVED_BY_BUDGET
                7: 'badge-budget', // APPROVED_BY_BUDGET
                8: 'badge-ord', // SUBMITTED_TO_ORD
                9: 'badge-ord', // RECEIVED_BY_ORD
                10: 'badge-ord', // APPROVED_BY_ORD
                11: 'badge-success', // WITH RFQ
                12: 'badge-success', // AWARDED
                14: 'badge-warning', // RETURNED_BY_GSS
                15: 'badge-warning', // RETURNED_BY_BUDGET
                16: 'badge-warning', // RETURNED_BY_ORD
                17: 'badge-cancelled', // CANCELLED
            };
            return ['badge', badgeClasses[statusId] || 'badge-default'];
        },
        // Map statusId to status name, similar to PHP event
        getStatusName(statusId) {
            const statusMessages = {
                2: 'SUBMITTED TO GSS',
                3: 'RECEIVED BY GSS',
                4: 'APPROVED BY GSS',
                5: 'SUBMITTED TO BUDGET',
                6: 'RECEIVED BY BUDGET',
                7: 'APPROVED BY BUDGET',
                8: 'SUBMITTED TO ORD',
                9: 'RECEIVED BY ORD',
                10: 'APPROVED BY ORD',
                11: 'WITH RFQ',
                12: 'AWARDED',
                14: 'RETURNED BY GSS',
                15: 'RETURNED BY BUDGET',
                16: 'RETURNED BY ORD',
                17: 'CANCELLED',
            };
            return statusMessages[statusId] || 'DRAFT';
        },
        setupWebSocket() {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }

            if (!window.Echo) {
                toast.error('Real-time updates are unavailable. Please refresh the page.', { autoClose: 2000 });
                return;
            }

            const showNotification = (title, body) => {
                const iconPath = '/images/logo.png';

                if (!("Notification" in window)) {
                    window.alert(`${title}: ${body}`);
                    return;
                }

                const displayNotification = () => {
                    const notification = new Notification(title, {
                        body,
                        icon: iconPath,
                    });
                    notification.onclick = () => {
                        window.open(`/procurement/index`, '_blank');
                    };
                };

                if (Notification.permission === "granted") {
                    displayNotification();
                } else if (Notification.permission !== "denied") {
                    Notification.requestPermission().then(permission => {
                        if (permission === "granted") {
                            displayNotification();
                        } else {
                            window.alert(`${title}: ${body}`);
                        }
                    }).catch(() => {
                        window.alert(`${title}: ${body}`);
                    });
                } else {
                    window.alert(`${title}: ${body}`);
                }
            };

            const handlePRUpdate = (e) => {
                const { title, body, prId, statusId } = e;

                const prIndex = this.purchaseRequests.findIndex(pr => pr.id === prId);
                if (prIndex !== -1) {
                    Vue.set(this.purchaseRequests, prIndex, {
                        ...this.purchaseRequests[prIndex],
                        status_id: statusId,
                        status: this.getStatusName(statusId),
                    });
                } else {
                    this.refreshData();
                }

                // ✅ Show browser notification for any event
                showNotification(title, body);
            };

            // 👤 User-specific channel
            window.Echo.channel(`notifications.${this.userId}`)
                .listen('PurchaseRequestUpdated', handlePRUpdate)
                .error(() => {
                    toast.error('Failed to connect to real-time updates.', { autoClose: 2000 });
                });

            // 👥 Role-based channel subscriptions
            const roleChannels = {
                gss_admin: 'notifications.gss_admin',
                budget_admin: 'notifications.budget_admin',
                ord_admin: 'notifications.ord_admin',
            };

            const channel = roleChannels[this.role];
            if (channel) {
                window.Echo.channel(channel)
                    .listen('PurchaseRequestUpdated', handlePRUpdate);
            }
        },

        loadData(filterParams = {}) {
            return axios.post('/api/fetchPurchaseReqData', {
                user_id: this.userId,
                page: this.currentPage,
                itemsPerPage: this.itemsPerPage,
                ...filterParams
            })
                .then((response) => {
                    this.purchaseRequests = response.data.data.map((pr) => ({
                        ...pr,
                        isBudgetSubmitted: pr.is_budget_submitted || false,
                        isGSSSubmitted: pr.is_gss_submitted || false,
                        isORDSubmitted: pr.is_ord_submitted || false,
                        status: this.getStatusName(pr.status_id), // Ensure status is set
                    }));
                })
                .catch((error) => {
                    toast.error('Failed to load data.', { autoClose: 2000 });
                    throw error;
                });
        },
        loadDataPerUser(filterParams = {}) {
            return axios.post('/api/perUserPurchaseReqData', {
                user_id: this.userId,
                page: this.currentPage,
                itemsPerPage: this.itemsPerPage,
                ...filterParams
            })
                .then((response) => {
                    this.purchaseRequests = response.data.data.map((pr) => ({
                        ...pr,
                        isBudgetSubmitted: pr.is_budget_submitted || false,
                        isGSSSubmitted: pr.is_gss_submitted || false,
                        isORDSubmitted: pr.is_ord_submitted || false,
                        status: this.getStatusName(pr.status_id), // Ensure status is set
                    }));
                })
                .catch((error) => {
                    toast.error('Failed to load user data.', { autoClose: 2000 });
                    throw error;
                });
        },
        refreshData() {
            if (!this.userId || !this.role) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            const loadMethod = ['admin', 'gss_admin', 'budget_admin', 'ord_admin'].includes(this.role)
                ? this.loadData
                : this.loadDataPerUser;
            loadMethod(this.filterParams).then(() => {
                eventBus.emit('updateStats');
            }).catch((error) => {
                console.error('Error refreshing data:', error);
            });
        },
        onPageChange(page) {
            this.currentPage = page;
            this.refreshData();
        },
        viewPr(pr_id) {
            this.$router.push({ path: '/procurement/update_pr', query: { id: pr_id } });
        },
        receiveGSS(id) {
            this.selectedPrId = id;
            this.approvalType = 'gss_receive';
            this.showApprovalModal = true;
        },
        receiveBudget(id) {
            this.selectedPrId = id;
            this.approvalType = 'budget_receive';
            this.showApprovalModal = true;
        },
        receiveORD(id) {
            this.selectedPrId = id;
            this.approvalType = 'ord_receive';
            this.showApprovalModal = true;
        },
        approveGSS(id) {
            this.selectedPrId = id;
            this.approvalType = 'gss';
            this.showApprovalModal = true;
        },
        approveBudget(id) {
            this.selectedPrId = id;
            this.approvalType = 'budget';
            this.showApprovalModal = true;
        },
        approveORD(id) {
            this.selectedPrId = id;
            this.approvalType = 'ord';
            this.showApprovalModal = true;
        },
        submitApproval() {
            if (this.approvalType === 'gss') {
                this.submitGSSApproval();
            } else if (this.approvalType === 'budget') {
                this.submitBudgetApproval();
            } else if (this.approvalType === 'ord') {
                this.submitORDApproval();
            } else if (this.approvalType === 'gss_receive') {
                this.submitGSSReceive();
            } else if (this.approvalType === 'budget_receive') {
                this.submitBudgetReceive();
            } else if (this.approvalType === 'ord_receive') {
                this.submitORDReceive();
            }
        },
        submitGSSReceive() {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: this.selectedPrId,
                status: 3,
                submitted_by_gss: this.userId,
                is_gss_submitted: false,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === this.selectedPrId);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isGSSSubmitted = response.data.data.is_gss_submitted || false;
                    }
                    toast.success('Successfully marked as received by GSS!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error marking GSS received:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to mark as received by GSS.', { autoClose: 2000 });
                })
                .finally(() => {
                    this.showApprovalModal = false;
                    this.selectedPrId = null;
                    this.approvalType = null;
                });
        },
        submitBudgetReceive() {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: this.selectedPrId,
                status: 6,
                submitted_by: this.userId,
                is_budget_submitted: false,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === this.selectedPrId);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isBudgetSubmitted = response.data.data.is_budget_submitted || false;
                    }
                    toast.success('Successfully marked as received by Budget!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error marking Budget received:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to mark as received by Budget.', { autoClose: 2000 });
                })
                .finally(() => {
                    this.showApprovalModal = false;
                    this.selectedPrId = null;
                    this.approvalType = null;
                });
        },
        submitORDReceive() {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: this.selectedPrId,
                status: 9,
                submitted_by_ord: this.userId,
                is_ord_submitted: false,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === this.selectedPrId);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isORDSubmitted = response.data.data.is_ord_submitted || false;
                    }
                    toast.success('Successfully marked as received by ORD!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error marking ORD received:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to mark as received by ORD.', { autoClose: 2000 });
                })
                .finally(() => {
                    this.showApprovalModal = false;
                    this.selectedPrId = null;
                    this.approvalType = null;
                });
        },
        submitGSSApproval() {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: this.selectedPrId,
                status: 4,
                submitted_by_gss: this.userId,
                is_gss_submitted: true,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === this.selectedPrId);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isGSSSubmitted = response.data.data.is_gss_submitted || false;
                    }
                    toast.success('Successfully approved by GSS!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error approving GSS:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to approve by GSS.', { autoClose: 2000 });
                })
                .finally(() => {
                    this.showApprovalModal = false;
                    this.selectedPrId = null;
                    this.approvalType = null;
                });
        },
        submitBudgetApproval() {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: this.selectedPrId,
                status: 7,
                submitted_by: this.userId,
                is_budget_submitted: true,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === this.selectedPrId);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isBudgetSubmitted = response.data.data.is_budget_submitted || false;
                    }
                    toast.success('Successfully approved by Budget!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error approving Budget:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to approve by Budget.', { autoClose: 2000 });
                })
                .finally(() => {
                    this.showApprovalModal = false;
                    this.selectedPrId = null;
                    this.approvalType = null;
                });
        },
        submitORDApproval() {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: this.selectedPrId,
                status: 10,
                submitted_by_ord: this.userId,
                is_ord_submitted: true,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === this.selectedPrId);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isORDSubmitted = response.data.data.is_ord_submitted || false;
                    }
                    toast.success('Successfully approved by ORD!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error approving ORD:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to approve by ORD.', { autoClose: 2000 });
                })
                .finally(() => {
                    this.showApprovalModal = false;
                    this.selectedPrId = null;
                    this.approvalType = null;
                });
        },
        toGSS(id) {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: id,
                status: 2,
                submitted_by_gss: this.userId,
                is_gss_submitted: false,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isGSSSubmitted = response.data.data.is_gss_submitted || false;
                    }
                    toast.success('Successfully submitted to GSS!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error submitting to GSS:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to submit to GSS.', { autoClose: 2000 });
                    this.refreshData();
                });
        },
        toBudget(id) {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: id,
                status: 5,
                submitted_by: this.userId,
                is_budget_submitted: false,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isBudgetSubmitted = response.data.data.is_budget_submitted || false;
                    }
                    toast.success('Successfully submitted to Budget!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error submitting to Budget:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to submit to Budget.', { autoClose: 2000 });
                    this.refreshData();
                });
        },
        toORD(id) {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: id,
                status: 8,
                submitted_by_ord: this.userId,
                is_ord_submitted: false,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                        updatedRequest.isORDSubmitted = response.data.data.is_ord_submitted || false;
                    }
                    toast.success('Successfully submitted to ORD!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    toast.error(error.response?.data?.message || 'Failed to submit to ORD.', { autoClose: 2000 });
                    this.refreshData();
                });
        },
        cancelTransaction(id) {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: id,
                status: 17,
                submitted_by: this.userId,
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                    }
                    toast.success('Successfully cancelled!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error cancelling transaction:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to cancel.', { autoClose: 2000 });
                    this.refreshData();
                });
        },
        returnTransaction(id) {
            if (!this.userId) {
                toast.error('User not authenticated. Please log in.', { autoClose: 2000 });
                return;
            }
            axios.post('/api/updatePurchaseRequestStatus', {
                id: id,
                status: 'return',
                submitted_by: this.userId
            })
                .then((response) => {
                    const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
                    if (updatedRequest) {
                        updatedRequest.status_id = response.data.data.stat;
                        updatedRequest.status = response.data.data.status;
                    }
                    toast.success('Successfully returned!', { autoClose: 2000 });
                    this.refreshData();
                })
                .catch((error) => {
                    console.error('Error returning transaction:', error.response?.data || error);
                    toast.error(error.response?.data?.message || 'Failed to return.', { autoClose: 2000 });
                    this.refreshData();
                });
        },
    },
};
</script>