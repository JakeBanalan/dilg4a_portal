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

                                        <!-- <button type="button" class="btn btn-warning btn-icon-text mx-2"
                                            @click="openModal()">
                                            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                            Add Quotation</button>-->

                                        <button type="button" class="btn btn-success btn-icon-text mx-2"
                                            @click="saveSelectedSuppliers">
                                            <font-awesome-icon :icon="['fas', 'file-export']"></font-awesome-icon>
                                            Save</button>
                                        <button type="button" class="btn btn-success btn-icon-text mx-2"
                                            @click="compileSelectedSuppliers">
                                            <font-awesome-icon :icon="['fas', 'file-export']"></font-awesome-icon>
                                            Compile Selected</button>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row" style="padding-bottom:20px;">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>Purchase Order Number</label>
                                                    <input label="PO No." class="form-control typeahead" type="text"
                                                        id="po_number" v-model="po_no" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>AOQ Number</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_number" v-model="abstract_no" :readonly="true" />
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>Total ABC</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="tota_abc" v-model="rfqData.app_price" :readonly="true" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>AOQ Date</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_date" v-model="abstract_date" :readonly="true" />

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>AOQ Time</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_deadline" v-model="abstract_time" :readonly="true" />

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>Mode</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="mode" v-model="rfqData.mode" :readonly="true" />

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>RFQ Number</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_number" v-model="rfqData.rfq_no" :readonly="true" />

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
                                                    <th v-for="(supplier, index) in uniqueSuppliers"
                                                        :key="supplier + '_group'" scope="col" class="sorting"
                                                        :colspan="2">
                                                        {{ supplier }}
                                                    </th>
                                                </tr>
                                                <tr role="row">
                                                    <th v-for="(supplier, index) in uniqueSuppliers" :key="supplier"
                                                        colspan="2">
                                                        <span v-for="quote in total_quotation">
                                                            <span v-if="quote.supplier_title === supplier">
                                                                ₱ {{ (quote.total_quote !== '' &&
                                                                    !isNaN(quote.total_quote) && quote.total_quote !== 0) ?
                                                                    formatNumber(quote.total_quote) : '0' }}
                                                            </span>
                                                        </span>
                                                    </th>
                                                </tr>
                                                <tr role="row">
                                                    <template v-for="(supplier, index) in uniqueSuppliers"
                                                        :key="supplier + '_offer'">
                                                        <th scope="col" class="sorting">
                                                            OFFER PER ITEM</th>
                                                        <th scope="col" class="sorting">
                                                            TOTAL OFFER</th>
                                                    </template>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in AbsData" :key="item.id">
                                                    <td>{{ item.description }}</td>
                                                    <td>{{ item.qty }}</td>
                                                    <td>{{ item.unit }}</td>
                                                    <td>{{ formatNumber(item.abc) }}</td>
                                                    <td>{{ item.total_abc }}</td>
                                                    <template v-for="(supplier, index) in uniqueSuppliers"
                                                        :key="supplier + '_' + item.item_id">
                                                        <td @click="toggleCellHighlight(item.item_id, supplier)"
                                                            :class="{ 'highlight-column': isCellHighlighted(item.item_id, supplier) }">
                                                            {{ getOffer(item, supplier, 'offer') }}
                                                        </td>
                                                        <td @click="toggleCellHighlight(item.item_id, supplier)"
                                                            :class="{ 'highlight-column': isCellHighlighted(item.item_id, supplier) }">
                                                            {{ getOffer(item, supplier, 'total_offer') }}
                                                        </td>
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

import axios from "axios";
import { toast } from "vue3-toastify";
import { readonly } from 'vue';
import Swal from 'sweetalert2';

library.add(faSpinner, faCartShopping, faListCheck, faPesoSign, faSave, faDownload, faPen, faCalendar, faFileExport, faShare);

export default {
    name: 'View RFQ Details',
    data() {
        return {
            po_no: this.$route.query.po_no,
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
            // highlightedSupplierIndex: null,
            highlightedCells: {}
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
        toggleCellHighlight(rowId, supplier, field) {
            // Toggle highlight: if same supplier is already selected, remove it
            if (this.highlightedCells[rowId] === supplier) {
                this.highlightedCells[rowId] = null;
            } else {
                this.highlightedCells[rowId] = supplier;
            }
        },
        isCellHighlighted(rowId, supplier, field) {
            return this.highlightedCells[rowId] === supplier;
        },
        compileSelectedSuppliers() {
            const compiled = [];

            for (const rowId in this.highlightedCells) {
                const supplier = this.highlightedCells[rowId];
                if (supplier) {
                    compiled.push({
                        po_no: this.po_no,
                        rfq_id: this.rfqData.rfq_id,
                        abstract_id: this.$route.query.abstract,
                        item_id: rowId,
                        supplier_title: supplier,
                        supplier_id: this.quoteData.find(q => q.supplier_title === supplier)?.supplier_id || null,

                    });
                }
            }

            // console.log("Compiled Selected Suppliers:", compiled);
            // You can also send `compiled` to an API or emit it
            return compiled;
        },
        saveSelectedSuppliers() {
            const compiled = this.compileSelectedSuppliers();

            if (compiled.length === 0) {
                // this.$toast.warning("No suppliers selected!");
                console.log("No suppliers selected!");
                return;
            }
            // console.log("Saving Selected Suppliers:", compiled);
            axios.post('/api/postPOdata', {
                // abstract_id: this.abstract_id, // pass abstract ID if needed
                selections: compiled
            })
                .then(response => {
                    // this.$toast.success("Selected suppliers saved successfully!");
                    console.log("Saved");
                })
                .catch(error => {
                    // console.error("Error saving suppliers:", error);
                    // this.$toast.error("Failed to save selected suppliers.");
                });
        },
        // toggleSupplierHighlight(index, supplier) {
        //             this.highlightedSupplierIndex = this.highlightedSupplierIndex === index ? null : index;
        //     // Swal.fire({
        //     //     title: 'Award Supplier?',
        //     //     text: `Are you sure you want to Award the supplier: ${supplier}?`,
        //     //     icon: 'question',
        //     //     showCancelButton: true,
        //     //     confirmButtonText: 'Yes, proceed!',
        //     //     cancelButtonText: 'No, cancel!'
        //     // }).then((result) => {
        //     //     if (result.isConfirmed) {
        //     //         this.highlightedSupplierIndex = this.highlightedSupplierIndex === index ? null : index;
        //     //         console.log("Highlighted Supplier Index:", this.highlightedSupplierIndex);
        //     //         console.log("Highlighted Supplier:", supplier);
        //     //         Swal.fire({
        //     //             icon: 'success',
        //     //             title: 'Supplier Awarded',
        //     //             showConfirmButton: false,
        //     //             timer: 1000
        //     //         });

        //     //     }
        //     // });
        // },
        fetchAOQData() {
            axios.get(`../../api/viewAOQ/2`)
                .then(res => {
                    // console.log(res.data)
                    this.abstract_no = res.data[0].abstract_no;
                    this.abstract_date = res.data[0].abstract_date;
                    this.abstract_time = res.data[0].abstract_time;
                })
        },
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
                // axios.get(`../../api/viewRFQItems/1`)
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
                // const quoteRes = await axios.get(`../../api/fetch_supplier_quote/2`);
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
                // const rfqID = this.$route.query.id;
                // if (!rfqID) {
                //     console.error("RFQ ID is missing.");
                //     return;
                // }
                // const rfqRes = await axios.get(`../../api/fetchRFQItems/1`);
                const rfqRes = await axios.get(`../../api/fetchRFQItems/${this.$route.query.id}`);
                // console.log("RFQ Items Data:", rfqRes.data);
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

.highlight-column {
    background-color: rgba(5, 152, 135, 0.258) !important;
    /* border: 2px solid rgba(5, 152, 135, 0.8) !important; */
    /* box-shadow: inset 0 0 4px rgba(5, 152, 135, 0.5); */
}
</style>