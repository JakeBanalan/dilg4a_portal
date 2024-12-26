<style>
.btn-custom {
    padding: 15% !important;
}

.badge-cancelled {
    color: #fff;
    background-color: #3c3b41
}

.badge-with-rfq {
    color: #fff;
    background-color: #923909
}

.badge-received_gss {
    color: #fff;
    background-color: #0f087a
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
                <th style="width: 4px;">
                    ACTION</th>
                <th class="details-control sorting_disabled" rowspan="1" colspan="1" aria-label=""
                    style="width: 100px;">
                    STATUS</th>
                <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#"
                    style="width: 61px;"> PURCHASE REQUEST #</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Policy holder: activate to sort column ascending" style="width: 107px;">TOTAL AMOUNT
                </th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Premium: activate to sort column ascending" style="width: 126px;">PURPOSE</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Status: activate to sort column ascending" style="width: 126px;">PR DATE</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Updated at: activate to sort column ascending" style="width: 93px;">TARGET DATE</th>

                <th class="details-control sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 4px;">
                    CREATED BY</th>

            </tr>
        </thead>

        <tbody>
            <tr v-for="purchaseRequest in displayedItems" :key="purchaseRequest.id">
                <td v-if="this.role == 'admin'">
                    <div v-if="purchaseRequest.status_id == 1">
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)"> <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toBudget(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" /> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toGSS(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" /> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="exportPurchaseRequest(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'download']" style="margin-left: -3px;" /> </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 2">
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)"> <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon> </button>
                        <button type="button" disabled class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toBudget(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" /> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toGSS(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" /> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="exportPurchaseRequest(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'download']" style="margin-left: -3px;" /> </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 3">
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)"> <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon> </button>
                        <button type="button" disabled class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toBudget(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" /> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toGSS(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" /> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="exportPurchaseRequest(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'download']" style="margin-left: -3px;" /> </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 4">
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)"> <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon> </button>
                        <button type="button" disabled class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toBudget(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" /> </button>
                        <button type="button" disabled class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toGSS(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" /> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="exportPurchaseRequest(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'download']" style="margin-left: -3px;" /> </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 5">
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)"> <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon> </button>
                        <button type="button" disabled class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toBudget(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'share-square']" style="margin-left: -3px;" /> </button>
                        <button type="button" disabled class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="toGSS(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'paper-plane']" style="margin-left: -3px;" /> </button>
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="exportPurchaseRequest(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'download']" style="margin-left: -3px;" /> </button>
                    </div>
                    <div v-else-if="purchaseRequest.status_id == 9">
                        <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)"> <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon> </button>

                    </div>
               </td>
               <td v-else>
                <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="viewPr(purchaseRequest.id, purchaseRequest.status_id, purchaseRequest.step)"> <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon> </button>
                <button type="button" class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="exportPurchaseRequest(purchaseRequest.id)"> <font-awesome-icon :icon="['fas', 'download']" style="margin-left: -3px;" /> </button>
               </td>

                <td>
                    <div v-if="purchaseRequest.status_id == 1" class="badge badge-success">{{ purchaseRequest.status }}
                    </div>
                    <div v-if="purchaseRequest.status_id == 2" class="badge badge-success">{{ purchaseRequest.status }}
                    </div>
                    <div v-if="purchaseRequest.status_id == 3" class="badge badge-success">{{ purchaseRequest.status }}
                    </div>
                    <div v-if="purchaseRequest.status_id == 4" class="badge badge-success">{{ purchaseRequest.status
                        }}</div>
                    <div v-if="purchaseRequest.status_id == 5" class="badge badge-success">{{ purchaseRequest.status }}
                    </div>
                    <div v-if="purchaseRequest.status_id == 6" class="badge badge-success">{{ purchaseRequest.status }}
                    </div>
                    <div v-if="purchaseRequest.status_id == 7" class="badge badge-success">{{ purchaseRequest.status }}
                    </div>
                    <div v-if="purchaseRequest.status_id == 8" class="badge badge-success">{{ purchaseRequest.status }}
                    </div>
                    <div v-if="purchaseRequest.status_id == 9" class="badge badge-danger">{{ purchaseRequest.status }}
                    </div>


                </td>
                <td>
                    <div class="badge badge-default">
                        <b>{{ purchaseRequest.pr_no }}</b><br><i>~{{ purchaseRequest.office }}~</i>
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
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faDownload, faEye, faPaperPlane, faShareSquare, faTrash } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";
import { formatDate } from '../../globalMethods';
library.add(faEye, faPaperPlane, faDownload, faTrash, faShareSquare);
export default {
    data() {
        return {
            userId:null,
            roll:null,
            purchaseRequests: [],
            totalRecords: 0,
            admins: [3174,2563],
            currentPage: 1,
            itemsPerPage: 10,
        };
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
    }
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
        viewPr(pr_id, status, step_no) {
            // Check if the status is DRAFT

            // If DRAFT, use 'procurement/update_pr/' route
            this.$router.push({ path: '/procurement/update_pr', query: { id: pr_id, step: step_no } });

        },
        exportPurchaseRequest(pr_id) {
            window.location.href = `../api/export-purchase-request/${pr_id}?export=true`;
        },
        toBudget(id) {
            this.$updatePurchaseRequestStatus(id, 2);
            toast.success('Successfully submitted to the Budget!', {
                autoClose: 2000
            });
            setTimeout(() => {
               this.loadData();
            }, 2000);
        },
        toGSS(id) {
            this.$updatePurchaseRequestStatus(id, 4);
            toast.success('Successfully submitted to the GSS!', {
                autoClose: 2000
            });
            setTimeout(() => {
                this.loadData();

            }, 2000);


        }
    },
};
</script>
