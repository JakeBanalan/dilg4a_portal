<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-md-12 grid-margin transparent">
                            <div class="row">
                                <StatBox />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Request for Quotation
                                        Information
                                    </h5>
                                    <div class="btn-group" style="float:right;margin-top:-50px;">
                                        <button type="button"
                                            class="btn btn-outline-primary btn-fw btn-icon-text">Actions</button>
                                        <button type="button"
                                            class="btn btn-outline-primary btn-fw btn-icon-text dropdown-toggle dropdown-toggle-split"
                                            id="dropdownMenuSplitButton3" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton3" style="">
                                            <h6 class="dropdown-header">Generate</h6>
                                            <div class="dropdown-divider"></div>

                                            <a class="dropdown-item" href="#">Export RFQ</a>


                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="RFQ No." iconValue="question" v-model="rfqData.rfq_no" :value="rfqData.rfq_no"/>
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Total ABC" iconValue="question" v-model="rfqData.app_price" :value="rfqData.app_price"/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="RFQ Date" iconValue="question" v-model="rfqData.rfq_date" :value="rfqData.rfq_date"/>

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Received Date" iconValue="question" v-model="rfqData.received_date" :value="rfqData.received_date"/>

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Office" iconValue="question" v-model="rfqData.office" :value="rfqData.office"/>

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <TextInput label="Mode" iconValue="question" v-model="rfqData.mode" :value="rfqData.mode"/>

                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <TextAreaInput label="Particulars" v-model="rfqData.particulars" :value="rfqData.particulars" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Request for
                                        Quotation Item Info
                                    </h5>
                                    <dtable :data="rfq_opts" :columns="tableColumns" />


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
import { faSpinner, faCartShopping, faListCheck, faPesoSign, faSave } from '@fortawesome/free-solid-svg-icons';

import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import StatBox from "../../procurement/stat_board.vue";
import dtable from "../../procurement/table.vue";

import axios from "axios";
import { toast } from "vue3-toastify";

library.add(faSpinner, faCartShopping, faListCheck, faPesoSign, faSave);

export default {
    name: 'View RFQ Details',
    data() {
        return {
            tableColumns: ['serial_no', 'procurement', 'unit', 'description', 'quantity', 'app_price', 'total'],
            rfq_opts:[],
            rfqData:{
                rfq_no:null,
                rfq_date:null,
                received_date:null,
                office:null,
                mode:null,
                particulars:null,
                app_price:null
            }
        }
    },
    components: {
        FontAwesomeIcon,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        StatBox,
        dtable
    },
    mounted() {
        this.fetchData();
        this.fetchItems();
    },
    methods: {
        fetchData() {
            axios.get(`../../api/viewRFQItems/${this.$route.query.id}`).then(res => {
                    this.rfqData.rfq_no = res.data[0].rfq_no
                    this.rfqData.office = res.data[0].office
                    this.rfqData.mode = res.data[0].mode
                    this.rfqData.rfq_date = res.data[0].rfq_date
                    this.rfqData.received_date = res.data[0].received_date
                    this.rfqData.app_price = res.data[0].app_price
                    this.rfqData.particulars = res.data[0].particulars

                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        fetchItems(){
            axios.get(`../api/viewPurchaseRequest/${this.$route.query.pr}`).then((res) => {
                this.rfq_opts = res.data;
            });
        }
    },
}
</script>