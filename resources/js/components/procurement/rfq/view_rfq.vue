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
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Request for Quotation
                                        Information
                                    </h5>
                                    <div class="d-flex" style="float:right;margin-top:-50px;">
                                        <!-- <button type="button" class="btn btn-primary btn-icon-text mx-2"
                                            @click="RouteAbstract()">
                                            <font-awesome-icon :icon="['fas', 'share']"></font-awesome-icon>
                                            Create Abstract</button> -->

                                        <button type="button" class="btn btn-warning btn-icon-text mx-2"
                                            @click="openModal()">
                                            <font-awesome-icon :icon="['fas', 'pen']"></font-awesome-icon>
                                            Update</button>

                                        <button type="button" class="btn btn-success btn-icon-text mx-2"
                                            @click="ExportRFQ()">
                                            <font-awesome-icon :icon="['fas', 'file-export']"></font-awesome-icon>
                                            Export</button>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row" style="padding-bottom:20px;">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>RFQ Number</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_number" v-model="rfqData.rfq_no" :readonly="true" />

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
                                                    <label>RFQ Date</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_date" v-model="rfqData.rfq_date" :readonly="true" />

                                                    <!-- <TextInput label="RFQ Date" iconValue="question"
                                                        v-model="rfqData.rfq_date" :value="rfqData.rfq_date" /> -->

                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label>RFQ Deadline</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="rfq_deadline" v-model="rfqData.rfq_deadline"
                                                        :readonly="true" />

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
                                                    <label>Office</label>
                                                    <input label="RFQ No." class="form-control typeahead" type="text"
                                                        id="office" v-model="rfqData.office" :readonly="true" />

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
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>DESCRIPTION</th>
                                                    <th>QUANTITY</th>
                                                    <th>UNIT</th>
                                                    <th>ABC</th>
                                                    <th>TOTAL ABC</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in rfq_opts" :key="item.id" id="hover">
                                                    <td>{{ item.description }}</td>
                                                    <td>{{ item.qty }}</td>
                                                    <td>{{ item.unit }}</td>
                                                    <td>{{ formatNumber(item.abc) }}</td>
                                                    <td>{{ item.total_abc }}</td>
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
        <ModalRFQ :visible="modalVisible" :rfqData="rfqData" @close="closeModal" @update="handleUpdate" />
        <ModalAOQ :visible="modalVisible1" :rfq_no="rfq_no" :id="id" @close="closeModal" />

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
import ModalRFQ from './modal/modal_update_rfq.vue';
import ModalAOQ from '../../procurement/abstract/modal/modal_confirm_abstract.vue';

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
            userId: null,
            rfq_no: null,
            id: null,
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
            modalVisible1: false,
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
        ModalRFQ,
        ModalAOQ
    },
    // created() {
    //     this.userId = this.$store.state.user.id;
    // },
    mounted() {
        this.fetchData();
        this.fetchItems();
        this.userId = localStorage.getItem('userId');
    },
    methods: {
        RouteAbstract() {
            this.rfq_no = this.rfqData.rfq_no;
            this.id = this.$route.query.id;
            // const rfq_no = this.rfqData.rfq_no;
            // const id = this.$route.query.id;
            this.modalVisible1 = true;

            // this.$router.push({ path: '/procurement/abstract',query:{id:id, rfq_no:rfq_no} });
            // console.log(rfq_no)
        },
        formatNumber(value) {
            if (!value) return '0';
            return Number(value).toLocaleString();
        },
        openModal() {
            this.rfqData = { ...this.rfqData },   // Clone the data to edit within the modal
                // console.log(this.rfqData)
                this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible1 = false;
            this.modalVisible = false;

        },
        handleUpdate(updatedData) {
            // console.log("modal Data:",updatedData)
            // this.rfqData = { ...updatedData }; // Update the parent data with changes from the modal

            const rfqq = {
                id: this.$route.query.id,
                particulars: updatedData.particulars,
                mode_id: updatedData.mode_id,
                rfq_date: updatedData.rfq_dateTime,
                rfq_deadline: updatedData.rfq_deadlineTime,
                updated_by: this.userId
            }

            // console.log(rfqq)

            axios.post('/api/PostUpdateRFQ',
                {
                    id: this.$route.query.id,
                    particulars: updatedData.particulars,
                    mode_id: updatedData.mode_id,
                    rfq_date: updatedData.rfq_dateTime,
                    rfq_deadline: updatedData.rfq_deadlineTime,
                    updated_by: this.userId,

                }
            )
                .then(() => {
                    toast.success('RFQ Updated!', {
                        autoClose: 1000
                    });
                    this.fetchData();
                    this.fetchItems();
                    this.closeModal()
                })
                .catch(error => {
                    console.error('error saving data', error)
                })


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
        fetchItems() {
            const rfqID = this.$route.query.id;

            if (!rfqID) {
                console.error("RFQ ID is missing.");
                return;
            }

            axios.get(`../api/fetchRFQItems/${rfqID}`)
                .then((res) => {
                    // Process the fetched data
                    this.rfq_opts = res.data.map(item => {
                        // Add a numeric total_abc for calculations
                        item.numeric_total_abc = item.total_abc || 0;

                        // Format total_abc with commas for display
                        item.total_abc = item.numeric_total_abc.toLocaleString();

                        return item;
                    });

                    // Calculate the total sum of the numeric total_abc
                    const totalSum = this.rfq_opts.reduce((sum, item) => {
                        return sum + item.numeric_total_abc; // Use the numeric value
                    }, 0);

                    // Format the total sum for display
                    this.rfqData.app_price = totalSum.toLocaleString();
                    // console.log(totalSum)


                })
                .catch((error) => {
                    console.error("Error fetching RFQ items:", error);
                });
        },

        ExportRFQ() {
            const rfqID = this.$route.query.id;

            if (!rfqID) {
                console.error("RFQ ID is missing.");
                return;
            }

            window.location.href = `/../api/ExportRFQ/${rfqID}?export=true`;

            toast.success('Successfully downloaded!');
            setTimeout(() => {
                // location.reload();
            }, 500); // Adjust the delay as needed
        }
    },
}
</script>

<style>
.textarea-container label {
    padding-top: 10px;
    font-size: 18px !important;
    font-weight: bold !important;
}

#hover:hover {
    background-color: rgba(5, 152, 135, 0.258);
    cursor: pointer;
}

</style>