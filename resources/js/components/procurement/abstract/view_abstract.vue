<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Abstract of Quotation
                                        Information
                                    </h5>
                                    <div class="d-flex" style="float:right;margin-top:-50px;">
                                        <!-- <button type="button" class="btn btn-primary btn-icon-text mx-2"
                                            @click="RouteAbstract()">
                                            <font-awesome-icon :icon="['fas', 'share']"></font-awesome-icon>
                                            Create Abstract</button> -->

                                        <button type="button" class="btn btn-warning btn-icon-text mx-2"
                                            @click="openModal()">
                                            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                            Add Quotation</button>

                                        <button type="button" class="btn btn-success btn-icon-text mx-2"
                                            @click="exportAbstract()">
                                            <font-awesome-icon :icon="['fas', 'file-export']"></font-awesome-icon>
                                            Export</button>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row" style="padding-bottom:20px;">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>AOQ Number</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_number" v-model="abstract_no" :readonly="true" />
                                                    <!-- <TextInput iconValue="question" v-model="rfqData.rfq_no"
                                                        :value="rfqData.rfq_no" /> -->
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>Total ABC</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="tota_abc" v-model="rfqData.app_price" :readonly="true" />

                                                    <!-- <TextInput label="Total ABC" iconValue="question"
                                                        v-model="rfqData.app_price" :value="rfqData.app_price" /> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>AOQ Date</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_date" v-model="abstract_date" :readonly="true" />

                                                    <!-- <TextInput label="RFQ Date" iconValue="question"
                                                        v-model="rfqData.rfq_date" :value="rfqData.rfq_date" /> -->

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>AOQ Time</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_deadline" v-model="abstract_time" :readonly="true" />

                                                    <!-- <TextInput label="RFQ Deadline" iconValue="question"
                                                        v-model="rfqData.rfq_deadline" :value="rfqData.rfq_deadline" /> -->

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>Mode</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="mode" v-model="rfqData.mode" :readonly="true" />

                                                    <!-- <TextInput label="Mode" iconValue="question" v-model="rfqData.mode"
                                                        :value="rfqData.mode" /> -->

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>RFQ Number</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_number" v-model="rfqData.rfq_no" :readonly="true" />

                                                    <!-- <TextInput label="Office" iconValue="question"
                                                        v-model="rfqData.office" :value="rfqData.office" /> -->

                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="textarea-container">
                                                        <TextAreaInput label="Particulars" v-model="rfqData.particulars"
                                                            :value="rfqData.particulars" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">

                                    <!-- <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Request for
                                        Quotation Item Info
                                    </h5> -->
                                    <!-- <dtable :data="rfq_opts" :columns="tableColumns" /> -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr role="row">
                                                    <th rowspan="3"
                                                        style="text-align:center !important; vertical-align: middle !important; width:10%!important;"
                                                        class="sorting" tabindex="0" colspan="1">DESCRIPTION</th>
                                                    <th rowspan="3"
                                                        style="width:5%!important; vertical-align: middle !important;"
                                                        class="sorting" tabindex="0" colspan="1">QUANTITY</th>
                                                    <th rowspan="3"
                                                        style="width: 5%; vertical-align: middle !important;"
                                                        class="sorting" tabindex="0" colspan="1">UNIT</th>
                                                    <th rowspan="3"
                                                        style="width: 5%; vertical-align: middle !important;"
                                                        class="sorting" tabindex="0" colspan="1">ABC</th>
                                                    <th rowspan="3"
                                                        style="width:5%!important; vertical-align: middle !important;"
                                                        class="sorting" tabindex="0" colspan="1">TOTAL ABC</th>
                                                    <th v-for="supplier in uniqueSuppliers" :key="supplier + '_group'"
                                                        scope="col" class="sorting" :colspan="2">
                                                        {{ supplier }}
                                                    </th>
                                                </tr>
                                                <tr role="row">
                                                    <th v-for="supplier in uniqueSuppliers"
                                                        :key="supplier" colspan="2">
                                                        <span v-for="quote in total_quotation">
                                                         <span v-if="quote.supplier_title === supplier">
                                                            ₱ {{ (quote.total_quote !== '' && !isNaN(quote.total_quote) && quote.total_quote !== 0) ? formatNumber(quote.total_quote) : '0' }}
                                                        </span>
                                                    </span>
                                                    </th>
                                                </tr>
                                                <tr role="row">
                                                    <template v-for="supplier in uniqueSuppliers"
                                                        :key="supplier + '_offer'">
                                                        <th scope="col" class="sorting">OFFER PER ITEM</th>
                                                        <th scope="col" class="sorting">TOTAL OFFER</th>
                                                    </template>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in AbsData" :key="item.id">
                                                    <td>{{ item.description }}</td>
                                                    <td>{{ item.qty }}</td>
                                                    <td>{{ item.unit }}</td>
                                                    <td>{{ formatNumber(item.unit_cost) }}</td>
                                                    <td>{{ item.total_abc }}</td>
                                                    <template v-for="supplier in uniqueSuppliers"
                                                        :key="supplier + '_' + item.supplier_title">
                                                        <td>{{ getOffer(item, supplier, 'offer') }}</td>
                                                        <td>{{ getOffer(item, supplier, 'total_offer') }}</td>
                                                    </template>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ModalAbstract :visible="modalVisible" :rfq_opts="rfq_opts" :rfqData="rfqData" :abstract_id="abstract_id"
            :abstract_no="abstract_no" @close="closeModal" @submit_quotation="submit_quotation" />

    </div>
</template>
<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { formatTotalAmount } from "../../../globalMethods.js";
import { faSpinner, faCartShopping, faListCheck, faPesoSign, faSave, faDownload, faPen, faCalendar, faFileExport, faShare } from '@fortawesome/free-solid-svg-icons';

import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import StatBox from "../../procurement/stat_board.vue";
import dtable from "../../procurement/table.vue";
import ModalAbstract from './modal/modal_add_quotation.vue';


import axios from "axios";
import { toast } from "vue3-toastify";
import { readonly } from 'vue';

library.add(faSpinner, faCartShopping, faListCheck, faPesoSign, faSave, faDownload, faPen, faCalendar, faFileExport, faShare);

export default {
    name: 'View RFQ Details',
    data() {
        return {
            // tableColumns: ['description', 'qty', 'unit', 'abc', 'total_abc'],
            rfq_opts: [],
            quoteData: [],
            AbsData: [],
            userId: null,
            abstract_id: null,
            abstract_no: null,
            abstract_date: null,
            abstract_time: null,
            quotationData: [],
            rfqData: {
                rfq_id: this.$route.query.id,
                rfq_no: null,
                rfq_dateTime: null,
                rfq_deadlineTime: null,
                rfq_date: null,
                rfq_deadline: null,
                received_date: null,
                office: null,
                mode: null,
                mode_id: null,
                particulars: null,
                app_price: null
            },
            modalVisible: false,
        }
    },
    components: {
        FontAwesomeIcon,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        StatBox,
        dtable,
        ModalAbstract
    },
    // created() {
    //     this.userId = this.$store.state.user.id;
    // },
    computed: {
        uniqueSuppliers() {
            const suppliers = new Set(this.quoteData.map(quote => quote.supplier_title));
            return [...suppliers];
        }
    },
    mounted() {
        this.fetchData();
        this.fetchAOQData();
        this.fetchSupplierQuotationAndItems();
        this.userId = localStorage.getItem('userId');
    },
    methods: {
        fetchAOQData() {
            // console.log(this.$route.query.abstract)
            axios.get(`../../api/viewAOQ/${this.$route.query.abstract}`)
                .then(res => {
                    // console.log(res.data)
                    this.abstract_no = res.data[0].abstract_no;
                    this.abstract_date = res.data[0].abstract_date;
                    this.abstract_time = res.data[0].abstract_time;
                })
        },
        // RouteAbstract() {
        //     const rfq_no = this.rfqData.rfq_no;
        //     const id = this.$route.query.id;
        //     this.$router.push({ path: '/procurement/abstract', query: { id: id, rfq_no: rfq_no } });
        //     // console.log(rfq_no)
        // },
        formatNumber(value) {
            if (!value) return '0';
            return Number(value).toLocaleString();
        },
        openModal() {
            this.abstract_no = this.abstract_no,
                this.abstract_id = this.$route.query.abstract,
                this.rfqData = { ...this.rfqData },
                this.rfq_opts = { ...this.rfq_opts };   // Clone the data to edit within the modal
            // console.log(this.rfqData)
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        submit_quotation(quotationData) {
            // console.log("Quotation Data:", quotationData);
            quotationData.forEach(data => {
                axios.post('/api/PostSupplierQuotation', data)
                    .then((res) => {
                        this.quotationData = res.data;
                        // console.log("Quotation submitted successfully:", quotationData);
                        // toast.success('Quotation submitted successfully!');
                        this.AbsData = [];
                        this.fetchData();
                        this.fetchAOQData();
                        this.fetchSupplierQuotationAndItems();
                    })
                    .catch((error) => {
                        console.error("Error submitting quotation:", error);
                        toast.error('Error submitting quotation!');
                    });
            });
        },
        fetchData() {
            axios.get(`../../api/viewRFQItems/${this.$route.query.id}`)
                .then(res => {
                    const rfq = res.data[0];
                    this.rfqData.rfq_no = rfq.rfq_no;
                    this.rfqData.office = rfq.offices;
                    this.rfqData.mode = rfq.mode;
                    this.rfqData.rfq_date = rfq.rfq_date;  // Ensure this is in correct format
                    this.rfqData.rfq_deadline = rfq.rfq_deadline;  // Ensure this is in correct format
                    this.rfqData.received_date = rfq.received_date;
                    this.rfqData.app_price = rfq.app_price;
                    this.rfqData.particulars = rfq.particulars;
                    this.rfqData.mode_id = rfq.mode_id;
                    // Optional: If you need these, make sure to convert them to proper format
                    this.rfqData.rfq_dateTime = rfq.rfq_dateTime;
                    this.rfqData.rfq_deadlineTime = rfq.rfq_deadlineTime;
                    // Ensure the data is being correctly logged
                    // console.log(this.rfqData);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        async fetchSupplierQuotationAndItems() {
            try {
                // Fetch supplier quotations
                const quoteRes = await axios.get(`../../api/fetch_supplier_quote/${this.$route.query.abstract}`);
                this.quoteData = quoteRes.data || [];
                // console.log("Quotation Data:", this.quoteRes);
                // Group by id and sum offers
                const groupedOffers = this.quoteData.reduce((acc, quote) => {
                    const offerValue = parseFloat(quote.total_offer);
                    if (!isNaN(offerValue)) {
                        // If id exists, add to the sum, otherwise initialize it
                        if (acc[quote.supplier_title]) {
                            acc[quote.supplier_title] += offerValue;
                        } else {
                            acc[quote.supplier_title] = offerValue;
                        }
                    }
                    return acc;
                }, {});

                // console.log("Grouped Offers by ID:", groupedOffers);
                // console.log("Quotation Data:", this.quoteData);

                // Create a new array with summed offers per supplier_id
                this.total_quotation = Object.keys(groupedOffers).map(supplier_title => ({
                    supplier_title: supplier_title,  // Add the supplier_id
                    total_quote: groupedOffers[supplier_title]  // Add the total sum of the offers for that supplier
                }));

                // console.log("Updated Quote Data with Grouped Offers:", this.total_quotation);

                // Fetch RFQ items
                const rfqID = this.$route.query.id;
                if (!rfqID) {
                    console.error("RFQ ID is missing.");
                    return;
                }
                const rfqRes = await axios.get(`../../api/fetchRFQItems/${rfqID}`);
                // console.log(rfqRes)
                this.rfq_opts = rfqRes.data.map(item => {
                    // Ensure numeric calculation safety
                    item.numeric_total_abc = Number(item.total_abc) || 0;
                    item.total_abc = item.numeric_total_abc.toLocaleString();
                    return item;
                });

                // Calculate the total sum of numeric total_abc
                const totalSum = this.rfq_opts.reduce((sum, item) => sum + item.numeric_total_abc, 0);
                this.rfqData.app_price = totalSum.toLocaleString();

                // Merge data by item_id
                const mergedData = this.rfq_opts.map(item => {
                    const matchingQuotes = this.quoteData.filter(quote => quote.item_id === item.item_id);
                    return {
                        ...item,
                        ...matchingQuotes[0]
                    };
                });
                this.AbsData = mergedData;
                // console.log("Merged Data:", this.AbsData);

            } catch (error) {
                console.error("Error fetching supplier quotations or RFQ items:", error);
            }
        },
        getOffer(item, supplier, field) {
            const quote = this.quoteData.find(q => q.item_id === item.item_id && q.supplier_title === supplier);
            return quote ? quote[field] : 'N/A';
        },


        exportAbstract() {
            const rfqID = this.$route.query.id;
            const AbsID = this.$route.query.abstract;
            // console.log('RFQ ID = ',rfqID);
            // console.log('ABSTRACT ID =',AbsID);
            window.location.href = `../../api/export-abstract/${AbsID}?export=true`;
            
        },

        // ExportRFQ() {
        //     const rfqID = this.$route.query.id;

        //     if (!rfqID) {
        //         console.error("RFQ ID is missing.");
        //         return;
        //     }

        //     window.location.href = `/../api/ExportRFQ/${rfqID}?export=true`;

        //     toast.success('Successfully downloaded!');
        //     setTimeout(() => {
        //         // location.reload();
        //     }, 500); // Adjust the delay as needed
        // }
    },
}
</script>

<style>
.textarea-container label {
    padding-top: 10px;
    font-size: 18px !important;
    font-weight: bold !important;
}
</style>