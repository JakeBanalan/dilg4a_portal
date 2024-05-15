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
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Create
                                        Purchase Order
                                    </h5>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <TextInput label="Purchase Order #" v-model="po_no" :value="po_no"
                                                        iconValue="gear" :readonly="true" />
                                                </div>
                                                <div class="col-lg-4">
                                                </div>
                                                <div class="col-lg-4">
                                                    <TextInput label="Request for Quotation #" v-model="rfq_no"
                                                        :value="rfq_no" iconValue="gear" :readonly="true" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <TextInput label="Supplier" v-model="supplier" :value="supplier"
                                                        iconValue="user" :readonly="true" />
                                                </div>
                                                <div class="col-lg-4">
                                                    <TextInput label="Purchase Order Amount" v-model="purchase_amount"
                                                        :value="purchase_amount" iconValue="peso-sign"
                                                        :readonly="true" />

                                                </div>
                                                <div class="col-lg-4">
                                                    <TextInput label="Office" iconValue="building" v-model="office"
                                                        :value="office" :readonly="true" />

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <TextInput label="NTP Date" iconValue="calendar" v-model="ntp_date"
                                                        type="datetime-local" style="height:40px;" />
                                                </div>
                                                <div class="col-lg-4">
                                                    <TextInput label="NOA Date" iconValue="calendar" v-model="noa_date"
                                                        type="datetime-local" style="height:40px;" />

                                                </div>
                                                <div class="col-lg-4">
                                                    <TextInput label="Purchase Order Date" iconValue="calendar"
                                                        v-model="po_date" type="datetime-local" style="height:40px;" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button @click="saveRecord()"
                                                class="btn btn-outline-primary btn-fw btn-icon-text mt-4"
                                                style="float:right">Save Record</button>

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
</template>

<script>

import Navbar from "../../../layout/Navbar.vue";
import Sidebar from "../../../layout/Sidebar.vue";
import FooterVue from "../../../layout/Footer.vue";
import BreadCrumbs from "../../../dashboard_tiles/BreadCrumbs.vue";
import StatBox from "../../stat_board.vue";

import { formatTotalAmount } from "../../../../globalMethods";

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core"; // Import the library object
import { faCircleCheck, faCircleInfo, faEye, faLayerGroup, faList, faPesoSign } from "@fortawesome/free-solid-svg-icons";
import { toast } from "vue3-toastify";
library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign);

export default {
    name: "Create Purchase Order",
    data() {
        return {
            pr_id: null,
            rfq_id: null,
            supplier_id: null,
            po_no: null,
            supplier: [],
            rfq_no: null,
            purchase_amount: null,
            office: null,
            ntp_date: null,
            noa_date: null,
            po_date: null
        }
    },
    mounted() {
        this.generatePurchaseOrderNo();
        this.fetchPurchaseRequestData();
        this.fetch_winner_supplier();
    },
    methods: {
        
        generatePurchaseOrderNo: async function () {
            try {
                const id = this.$route.query.id;
                const response = await axios.get('../../api/generatePurchaseOrderNo');
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Adding 1 because months are zero-indexed
                const yearFormat = `${year}`;
                const poSequence = String(response.data[0].po_number).padStart(4, '0'); // Pad with leading zeros
                const purchase_order_no = `${yearFormat}-${poSequence}`;

                this.po_no = purchase_order_no;
                console.log(this.po_no);
            } catch (error) {
                console.error('Error generating abstract number:', error);
            }

        },
        fetchPurchaseRequestData() {
            const requestData = {
                id: this.$route.query.id
            };

            axios.post(`../../api/fetchPurchaseRequestData`, requestData)
                .then(response => {
                    let totalPurchaseAmount = 0; // Initialize total purchase amount

                    response.data.forEach(item => {
                        this.rfq_no = item.rfq_no;
                        this.rfq_id = item.rfq_id;
                        this.supplier_id = item.supplier_id;
                        this.pr_id = item.pr_id;
                        this.office = item.pmo_title;
                        totalPurchaseAmount += parseFloat(item.total_quotation);


                    });
                    this.purchase_amount = totalPurchaseAmount.toString();

                })
                .catch(error => {
                });
        },
        fetch_winner_supplier() {
            const requestData = {
                id: this.$route.query.id
            };

            axios.post(`../../api/fetch_winner_supplier`, requestData)
                .then(response => {

                    const supplierTitles = response.data.map(item => item.supplier_title);
                    this.supplier = this.joinSupplierTitles(supplierTitles);
                    console.log(this.supplier)


                })
        },
        joinSupplierTitles(supplierTitles) {
            const numberOfSuppliers = supplierTitles.length;

            if (numberOfSuppliers === 0) {
                return '';
            } else if (numberOfSuppliers === 1) {
                return supplierTitles[0];
            } else if (numberOfSuppliers <= 5) {
                const lastSupplier = supplierTitles.pop();
                return `${supplierTitles.join(', ')} and ${lastSupplier}`
            }
        },
        saveRecord() {
            // Prepare the data to be saved
            const dataToSave = {
                po_no: this.po_no,
                supplier_id: this.supplier_id,
                rfq_no: this.rfq_no,
                rfq_id: this.$route.query.id,
                pr_id: this.pr_id,
                purchase_amount: this.purchase_amount,
                office: this.office,
                ntp_date: this.ntp_date,
                noa_date: this.noa_date,
                po_date: this.po_date
                // Add other properties as needed
            };

            // Make an HTTP POST request to your server-side endpoint
            axios.post('../../api/post_create_po', dataToSave)
                .then(response => {
                    toast.success('Record successfully saved!', {
                        autoClose: 2000
                    });
                    setTimeout(() => {
                        this.$router.push({ path: '/procurement/abstract/index' });
                    }, 2000); // Adjust the delay as needed
                })
                .catch(error => {
                    // Handle errors if the request fails
                    console.error('Error saving record:', error);
                    // Show an error message to the user
                    // For example, using a toast notification
                    this.$toast.error('Error saving record');
                })
        }
    },

    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        FontAwesomeIcon,
        StatBox,
    },

}
</script>