<style>
.card {
    border-radius: 7px !important;
}
</style>
<template>
      <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-5 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <input type="checkbox" value="Urgent">
                                    <label style="font-size: 12pt; color: red;">&nbsp; &nbsp;Urgent</label>
                                    <div class="ribbon-top-right">

                                    </div>
                                    <p class="card-description" style="color:red; font-size: 12pt;">*
                                        Required *
                                    </p>
                                    <div class="forms-sample">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase
                                                Request Number:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="exampleInputUsername2"
                                                    placeholder="Purchase Request Number" v-model="purchase_no"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Office</label>
                                            <div class="col-sm-9">
                                                <select>
                                                    <option v-for="office in pmo" :key="office.value"
                                                        :value="office.value">
                                                        {{ office.label }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase
                                                Type</label>
                                            <div class="col-sm-9">
                                                <select>
                                                    <option v-for="PurchaseType in pr_type" :key="PurchaseType.value"
                                                        :value="PurchaseType.value">
                                                        {{ PurchaseType.label }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Date:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" v-model="pr_date" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Target Date:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" v-model="target_date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Particulars:</label>
                                            <div class="col-sm-9">
                                                <textarea id="tinyMceExample" rows="1" v-model="particulars"
                                                    placeholder="Enter Particulars"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-7 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h3 style="float: right; font-size: 30px; font-weight: 900;">&nbsp;
                                        &nbsp;GRAND TOTAL: Php
                                        <span style="font-weight: bold;">₱0.00</span>
                                    </h3>
                                    <br>
                                    <br>
                                    <div class="forms-sample">

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
import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import dtable from "../procurement/table.vue";
export default {
    name: "ViewPurchaseRequestItem",
    data() {
        return {
            pr_data: [],
            current_step: null,
            pr_no: null,
            total_amount: null,
            disabled: false, // Add this if needed
            tableColumns: ['serial_no', 'procurement', 'unit', 'description', 'app_price', 'action'],
            purchaseRequestData: { pmo: null, pr_type: null, pr_date: null, target_date: null, particulars: null },
            procurementType: [{ value: '1', label: 'Catering Services' }, { value: '2', label: 'Meals, Venue and Accomodation' }, { value: '3', label: 'Repair and Maintenance' }, { value: '4', label: 'Supplies, Materials and Devices' }, { value: '5', label: 'Other Services' }, { value: '6', label: 'Reimbursement and Petty Cash' }],
            pmo: [{ value: '1', label: 'ORD' }, { value: '2', label: 'FAD' }, { value: '3', label: 'LGMED' }, { value: '4', label: 'LGCDD' },]
        };
    },
    mounted() {
        this.fetchPurchaseRequestDetails();
        axios.get(`../../api/viewPurchaseRequest/${this.$route.params.id}`).then((res) => {
            this.pr_data = res.data;
            this.current_step = res.data[0].step;
            this.pr_no = res.data[0].pr_no;
        }).catch((error) => { console.error("Error fetching data:", error); });
        // T O T A L A M O U N T
        const pr_id = this.$route.params.id
        axios.post('../../api/total_amount', {
            id: pr_id,
        }).then((res) => {
            this.total_amount = parseFloat(res.data[0].total_amount).toFixed(2);
        });

    },
    methods: {
        navigateToStep(step) {
            this.current_step = step;
        },
        fetchPurchaseRequestDetails() {
            const pr_id = this.$route.params.id;

            // Make an API call to get purchase request details based on pr_no
            axios.get(`/api/get_purchase_request_details`, { params: { id: pr_id } })
                .then((response) => {
                    // Update purchaseRequestData with the fetched values
                    this.purchaseRequestData.pmo = response.data.pmo;
                    this.purchaseRequestData.pr_type = response.data.type;
                    this.purchaseRequestData.pr_date = response.data.pr_date;
                    this.purchaseRequestData.target_date = response.data.target_date;
                    this.purchaseRequestData.particulars = response.data.purpose;
                })
                .catch((error) => {
                    console.log('Error fetching purchase request details:', error);
                });
        },

        fetch_pr_no: () => {

        },
        fetch_total_amount: () => {

        }
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        dtable
    }
};
</script>

<style>
/* Add your component styles here */
</style>
