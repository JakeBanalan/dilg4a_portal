<style>
.btn-align-right {
    margin-left: 70px;
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

                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div v-if="isCardVisible">
                                <AbstractInfo />
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Supplier's Quotation
                                        Details
                                    </h5>
                                    <div class="btn-group" style="float:right;margin-top:-50px;">
                                        <button type="button" class="btn btn-outline-primary btn-fw btn-icon-text">Actions</button>
                                        <button type="button"
                                        class="btn btn-outline-primary btn-fw btn-icon-text dropdown-toggle dropdown-toggle-split"
                                            id="dropdownMenuSplitButton3" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu"
                                            aria-labelledby="dropdownMenuSplitButton3" style="">
                                            <h6 class="dropdown-header">Generate</h6>
                                            <div class="dropdown-divider"></div>

                                            <a class="dropdown-item" href="#">Export PR</a>
                                            <a class="dropdown-item" href="#">Export RFQ</a>
                                            <a class="dropdown-item" href="#">Export Abstract</a>
                                            <a class="dropdown-item" href="#">Export PO</a>
                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Abstract #" iconValue="question"
                                                        v-model="abstract_no" :value="abstract_no" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Abstract Date" iconValue="question"
                                                        v-model="abstract_date" :value="abstract_date"
                                                        :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Tota ABC" iconValue="question" v-model="total_abc"
                                                        :value="total_abc" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Office" iconValue="question" v-model="pmo"
                                                        :value="pmo" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Request for Quotation #" iconValue="question"
                                                        v-model="rfq_no" :value="rfq_no" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="RFQ Date" iconValue="question" v-model="rfq_date"
                                                        :value="rfq_date" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Purchase Request #" iconValue="question"
                                                        v-model="pr_no" :value="pr_no" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="PR Date" iconValue="question" v-model="pr_date"
                                                        :value="pr_date" :readonly="true" />
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <TextAreaInput label="Particulars" :value="particulars" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp; Purchase Order Details
                                    </h5>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Purchase Order #" iconValue="question"
                                                        v-model="po_no" :value="po_no" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Purchase Order Date" iconValue="question"
                                                        v-model="po_date" :value="po_date"
                                                        :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Purchase Order Amount" iconValue="peso-sign"
                                                        v-model="po_amount" :value="po_amount" :readonly="true" />
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
                                        Details
                                    </h5>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Serial No</th>
                                                <th>Item Title</th>
                                                <th>Unit</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>App Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="pr_data in displayedItems" :key="pr_data.id">
                                                <td>{{ pr_data.serial_no }}</td>
                                                <td>{{ pr_data.item_title }}</td>
                                                <td>{{ pr_data.item_unit_title }}</td>

                                                <td>{{ pr_data.description }}</td>
                                                <td>{{ pr_data.qty }}</td>
                                                <td>{{ formatAppPrice(pr_data.abc) }}</td>
                                                <td>{{ formatAppPrice(pr_data.app_price) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Supplier's Quotation </h5>
                                    <div v-if="this.current_status >= 6">
                                        <button @click="openModal()"
                                            class="btn btn-outline-primary btn-fw btn-icon-text mr-2 pull-right">Add
                                            More</button>
                                    </div>



                                    <table class="table table-striped table-bordered table-responsive mt-4">
                                        <thead>
                                            <tr>
                                                <!-- Loop through each unique id and set it as table headers -->
                                                <th  style="max-width:150%;"  v-for="(id, index) in Object.keys(appItems)" :key="index">{{ id }}
                                                    <button
                                                        class="btn btn-xs btn-outline-primary btn-fw btn-icon-text btn-align-right">view
                                                        records</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!-- Loop through each quotation array and display the quotations -->
                                                <td v-for="(quotations, id) in appItems" :key="id" :style="{ backgroundColor: isWinner(quotations) ? '#059886' : '' }">
                                                    <ul>
                                                        <li v-for="(quotation, index) in quotations" :key="index">{{ quotation }}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="this.current_status >= 6">
                                        <button class="btn btn-primary btn-fw btn-icon-text col-lg-12 mt-4"
                                            @click="award()">Award</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <SelectSupplierModal :rfqNo="rfq_no" :visible="modalVisible" @close="closeModal" />

    </div>

</template>
<script>
import Navbar from '../../../layout/Navbar.vue';
import Sidebar from '../../../layout/Sidebar.vue';
import FooterVue from '../../../layout/Footer.vue';
import BreadCrumbs from '../../../dashboard_tiles/BreadCrumbs.vue';
import StatBox from '../../stat_board.vue';
import SelectSupplierModal from "../modal/modal_select_supplier.vue";

import { formatTotalAmount } from '../../../../globalMethods';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faCircleCheck, faCircleInfo, faDownload, faEye, faLayerGroup, faList, faPesoSign } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";


library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign,faDownload);
export default {
    name: 'Quotation',
    data() {
        return {
            appItems: [],
            pr_data: [],
            currentPage: 1,
            itemsPerPage: 5,
            modalVisible: false,
            abstract_no: null,
            abstract_id: null,
            abstract_date: null,
            pr_no: null,
            pr_id: null,
            particulars: null,
            pr_date: null,
            pmo: null,
            rfq_id: null,
            rfq_no: null,
            rfq_date: null,
            total_abc: null,
            po_no:null,
            po_date:null,
            po_amount:null,
            current_status: null,
            supplier_rfq_no: null
        }
    },
    computed: {

        totalPages() {
            return Math.ceil(this.pr_data.length / this.itemsPerPage);
        },
        displayedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.pr_data.slice(start, end);
        },
    },
    mounted() {
        this.fetch_app_item_details();


    },
    methods: {

        openModal() {
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        fetch_app_item_details() {

            const requestData = {
                id: this.$route.query.id
            };

            axios.post(`../../api/fetch_app_item_details`, requestData)
                .then(response => {
                    this.supplier_rfq_no = response.data[0].rfq_no;
                    this.rfq_id = response.data[0].rfq_id;
                    this.fetch_supplier_quotation(this.supplier_rfq_no);
                    this.fetch_pr_items(this.supplier_rfq_no);


                    response.data.forEach(item => {
                        this.pr_id = item.id;
                        this.pr_no = item.pr_no;
                        this.abstract_no = item.abstract_no;
                        this.abstract_date = item.abstract_date;
                        this.particulars = item.particulars;
                        this.pr_date = item.pr_date;
                        this.rfq_date = item.rfq_date;
                        this.rfq_no = item.rfq_no;
                        this.pmo = item.pmo_title;
                        this.po_no = item.po_no;
                        this.po_amount = item.po_amount;
                        this.po_date = item.po_date;
                        this.total_abc = item.total_abc;
                        this.current_status = item.current_status;
                    });
                })
                .catch(error => {
                });
        },
        formatAppPrice(price) {
            return formatTotalAmount(price);
        },
        fetch_supplier_quotation(rfq_no) {
            const requestData = {
                // id: this.$route.query.id
                id: this.supplier_rfq_no
            };

            axios.post(`../../api/fetch_supplier_quotation`, requestData)
                .then(response => {
                    const quotes = response.data;

                    // Initialize an empty object to store quotations grouped by supplier title
                    const appItems = {};

                    // Loop through the fetched data and group quotations by supplier title
                    quotes.forEach(quote => {
                        if (!appItems[quote.supplier_title]) {
                            appItems[quote.supplier_title] = [];
                        }
                        if (quote.winner) {
                            appItems[quote.supplier_title].push("winner-"+quote.item_title + "-(Php " + quote.quotation + ")" + "- winner");
                        } else {
                            appItems[quote.supplier_title].push(quote.item_title + "-(Php " + quote.quotation + ")");

                        }
                    });

                    // Assign the transformed data to appItems
                    this.appItems = appItems;

                    // Extract supplier titles from the response data
                    this.suppliers = Object.keys(appItems);
                })
                .catch(error => {
                    console.error('Error fetching supplier quotations:', error);
                });
        },
        isWinner(quotations) {
      return quotations.some(quotation => quotation.includes('- winner'));
    },
        fetch_pr_items(rfq_no) {
            axios.get(`../../api/viewRFQItems/${rfq_no}`,).then((res) => {
                this.pr_data = res.data;
            })
        },
        award() {
            const userId = localStorage.getItem('userId');

            axios.post('../../api/getSmallestQuotationsForItems', {
                rfq_id: this.rfq_id,
                status: 7,
                pr_id: this.pr_id

            }).then(() => {
                toast.success('Success! This request has been received!', {
                    autoClose: 2000
                });
                setTimeout(() => {
                    location.reload();
                }, 2000); // Adjust the delay as needed

            }).catch((error) => {

            })

        },
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        FontAwesomeIcon,
        StatBox,
        SelectSupplierModal
    },
}
</script>