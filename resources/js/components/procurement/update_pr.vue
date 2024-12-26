<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- <BreadCrumbs /> -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Purchase Request
                                        Information
                                    </h5>
                                    <div class="btn-group" style="float: right; margin-top: -50px;">
                                        <button type="button" class="btn btn-outline-primary btn-fw btn-icon-text" disabled>
                                            Actions
                                        </button>
                                        <button type="button"
                                            class="btn btn-outline-primary btn-fw btn-icon-text dropdown-toggle dropdown-toggle-split"
                                            id="dropdownMenuSplitButton3" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton3">
                                            <h6 class="dropdown-header">Generate</h6>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Export PR</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Purchase Request #" iconValue="question"
                                                        v-model="pr_no" :value="pr_no" :readonly="true" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="PurchaseRequestDate">Purchase Request
                                                            Date</label>
                                                        <input type="date" v-model="purchaseRequestData.pr_date"
                                                            class="form-control" :readonly="true" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="TargetDate">Target Date</label>
                                                        <input type="date" v-model="purchaseRequestData.target_date"
                                                            class="form-control" :readonly="true" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="Office">Office</label>
                                                        <select class="form-control" v-model="purchaseRequestData.pmo"
                                                            :readonly="true">
                                                            <option v-for="option in pmoList" :key="option.value"
                                                                :value="option.value">
                                                                {{ option.label }}
                                                            </option>
                                                        </select>


                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="ProcurementType">Procurement Type</label>
                                                        <select class="form-control"
                                                            v-model="purchaseRequestData.pr_type" :readonly="true">
                                                            <option v-for="option in procurementType"
                                                                :key="option.value" :value="option.value">
                                                                {{ option.label }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <TextAreaInput label="Particulars"
                                                        :value="purchaseRequestData.particulars"
                                                        v-model="purchaseRequestData.particulars" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Purchase Request Item
                                    </h5>
                                    <dtable :data="pr_data" :columns="tableColumns" />

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
        <!-- modal component  -->
        <showAddItemModal :visible="modalVisible" @close="closeModal" />

    </div>
</template>
<script>
import showAddItemModal from "./modal_addItem.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { formatTotalAmount } from "../../globalMethods.js";
import { faSpinner, faCartShopping, faListCheck, faPesoSign, faSave } from '@fortawesome/free-solid-svg-icons';

import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import dtable from "../procurement/table.vue";
import UserInfo from "../procurement/user_info.vue";
import StatBox from "../procurement/stat_board.vue";

import axios from "axios";
import { toast } from "vue3-toastify";

library.add(faSpinner, faCartShopping, faListCheck, faPesoSign, faSave);

export default {
    name: "update_pr",
    data() {
        return {
            modalVisible: false,
            isLoading: false,
            cancelled_pr: null,
            total_pr: null,
            userData: {
                name: null,
                office: null,
            },
            appItem: {
                app_total: null
            },
            total_amount: null,
            pr_no: null,
            status: null,
            pr_data: [],
            tableColumns: ['serial_no', 'procurement', 'unit', 'description', 'quantity', 'app_price', 'total', 'action'],
            tabs: [
                { name: 'Purchase Request Data', icon: ['fas', 'list-check'] },
                { name: 'Purchase Request Item', icon: ['fas', 'cart-shopping'] }, // Example with different icon
            ], contents: ['a', 'b', 'c'],
            activeTab: 0,
            purchaseRequestData: {
                pmo: null,
                pr_type: null,
                pr_date: null,
                target_date: null,
                particulars: null
            },
            procurementType: [
                { value: '1', label: 'Catering Services' },
                { value: '2', label: 'Meals, Venue and Accomodation' },
                { value: '3', label: 'Repair and Maintenance' },
                { value: '4', label: 'Supplies, Materials and Devices' },
                { value: '5', label: 'Other Services' },
                { value: '6', label: 'Reimbursement and Petty Cash' }
            ],
            pmoList: [
                { value: '15', label: 'ORD' },
                { value: '1', label: 'ORD-Legal' },
                { value: '2', label: 'ORD-Planning' },
                { value: '3', label: 'LGMED-MBRTG' },
                { value: '4', label: 'LGCDD-PDMU' },
                { value: '5', label: 'FAD' },
                { value: '6', label: 'ORD-RICTU' },
                { value: '7', label: 'LGCDD' },
                { value: '8', label: 'LGMED' },

            ],

        };
    },
    mounted() {
        // Set loading state to true before fetching data
        this.isLoading = true;
        setTimeout(() => {
            axios.get(`../api/viewPurchaseRequest/${this.$route.query.id}`).then((res) => {
                this.pr_data = res.data;
                this.current_step = res.data[0].step;
                this.pr_no = res.data[0].pr_no;
                this.status = res.data[0].status;
                localStorage.setItem('pr_no', res.data[0].pr_no);


                this.purchaseRequestData.pmo = res.data[0].office_id;
                this.purchaseRequestData.pr_type = res.data[0].type;
                this.purchaseRequestData.pr_date = res.data[0].pr_date;
                this.purchaseRequestData.target_date = res.data[0].target_date;
                this.purchaseRequestData.particulars = res.data[0].particulars;
            }).catch((error) => { console.error("Error fetching data:", error); });


            // Set loading state back to false after data is fetched
            this.isLoading = false;
        }, 100); // Simulate a delay of 1 second (adjust as needed)


        // T O T A L A M O U N T
        const pr_id = this.$route.query.id
        axios.post('../api/total_amount', {
            id: pr_id,
        }).then((res) => {
            this.total_amount = formatTotalAmount(res.data[0].total_amount)



        });
    },
    methods: {

        show_addItem_modal() {
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        changeTab(index) {
            this.activeTab = index;
        },
        exportPurchaseRequest() {
            window.location.href = `../api/export-purchase-request/${this.$route.query.id}?export=true`;
        },
        updatePurchaseRequestDetails() {
            axios.post(`../api/post_update_purchaseRequestDetailsForm`, {
                pr_id: this.$route.query.id,
                pmo: this.purchaseRequestData.pmo,
                type: this.purchaseRequestData.pr_type,
                pr_date: this.purchaseRequestData.pr_date,
                target_date: this.purchaseRequestData.target_date,
                purpose: this.purchaseRequestData.particulars,
                step: 2
            }
            ).then(() => {

                toast.success('Successfully added!', {
                    autoClose: 100
                });
            }).catch((error) => {

            })
        },
        toGSS() {
            const STATUS_SUBMITTED_TO_GSS = 4;
            axios.post(`../api/post_update_status`, {
                pr_id: this.$route.query.id,
                status: STATUS_SUBMITTED_TO_GSS,
            }
            ).then(() => {
                toast.success('Successfully added!', {
                    autoClose: 2000
                });
                setTimeout(() => {
                    this.$router.push({ name: 'Procurement' });

                }, 2000);

            }).catch((error) => {
            })

        }


    },
    components: {
        FontAwesomeIcon,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        dtable,
        UserInfo,
        showAddItemModal,
        StatBox
    }
};
</script>

<style>
/* Add your component styles here */
</style>
