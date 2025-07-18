<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <!-- <StatBox /> -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon
                                                :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Obligation
                                            Requests & Status
                                        </h5>
                                        <div class="d-flex">
                                            <button class="btn btn-primary btn-fw btn-icon-text mx-2"
                                                @click="returntoObli()">
                                                <font-awesome-icon :icon="['fas', 'undo']"></font-awesome-icon>
                                                Return
                                            </button>
                                            <button class="btn btn-success btn-fw btn-icon-text mx-2" @click="">
                                                <font-awesome-icon :icon="['fas', 'download']"></font-awesome-icon>
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <!-- Left Side (Inputs stacked vertically in col-md-6) -->
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Obligation Type:</label>
                                                        <!-- <input type="text" v-model="ObligationData.type"
                                                            class="form-control" id="obligationtype" /> -->
                                                        <multiselect :options="selectObligation"
                                                            v-model="ObligationData.type" track-by="id" label="name"
                                                            :multiple="false" :searchable="false" id="obligationtype">
                                                        </multiselect>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Serial Number:</label>
                                                        <input type="text" v-model="ObligationData.serial_no"
                                                            class="form-control" id="serialnumber" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Purchase Order:</label>
                                                        <!-- <input type="text" v-model="ObligationData.po_code"
                                                            class="form-control" id="purchaseorder" /> -->
                                                        <multiselect :options="selectPO"
                                                            v-model="ObligationData.po_code" track-by="id" label="name"
                                                            :multiple="false" :searchable="false" id="obligationtype">
                                                        </multiselect>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Amount:</label>
                                                        <input type="text" v-model="ObligationData.amount"
                                                            class="form-control" id="amount" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Payee:</label>
                                                        <!-- <input type="text" v-model="ObligationData.supplier_title"
                                                            class="form-control" id="payee" /> -->
                                                        <multiselect :options="selectSupplier"
                                                            v-model="ObligationData.supplier_title" track-by="id"
                                                            label="supplier_title" :multiple="false" :searchable="true"
                                                            id="payee">
                                                        </multiselect>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Address:</label>
                                                        <input type="text"
                                                            :value="ObligationData.supplier_title?.supplier_address || ''"
                                                            class="form-control" id="address" readonly />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Side (Particulars spans entire right half) -->
                                            <div class="col-md-6">
                                                <label>Particulars</label>
                                                <textarea id="procedure_title" v-model="ObligationData.purpose"
                                                    class="form-control" style="max-height: 115px;"></textarea>
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
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import Multiselect from 'vue-multiselect';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
// import StatBox from '../stat_board.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCircleCheck, faCircleInfo, faDownload, faEye, faLayerGroup, faList, faPesoSign, faSearch, faUndo } from '@fortawesome/free-solid-svg-icons';
import { formatTotalAmount } from '../../../globalMethods';
import Pagination from '../../procurement/Pagination.vue';

library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign, faDownload, faSearch, faUndo);

export default {
    name: 'Obligation',
    data() {
        return {
            ObligationData: {
                type: '',
                serial_no: '',
                po_code: '',
                amount: '',
                supplier_title: '',
                address: '',
                purpose: ''
            },
            selectObligation: [
                { id: 'ors', name: 'Obligation Request and Status (ORS)' },
                { id: 'burs', name: 'Budget Utilization Request (BURS)' },
            ],
            selectPO: [
                { id: 1, name: 'PO-2025-06-0001' },
                { id: 2, name: 'PO-2025-06-0002' },
                { id: 3, name: 'PO-2025-06-0003' },
                { id: 4, name: 'PO-2025-06-0004' },
            ],
            selectSupplier: [],
        };
    },
    components: {
        Multiselect,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        // StatBox,
        Pagination
    },
    mounted() {
        this.fetchSupplier();
    },
    computed: {
    },
    watch: {
        'ObligationData.supplier_title': function (newVal) {
            if (newVal && newVal.address) {
                this.ObligationData.address = newVal.address;
            } else {
                this.ObligationData.address = '';
            }
        }
    },
    methods: {
        fetchSupplier() {
            axios.get(`/api/fetchSupplier`)
                .then(response => {
                    this.selectSupplier = response.data;

                })
                .catch(error => {
                    console.error('Error fetching suppliers:', error);
                });
        },
        postObligation() {
            axios.post(`/api/postObligation`, this.ObligationData)
                .then(response => {
                    console.log(response.data);
                    toast.success("Obligation successfully created!");
                })
                .catch(error => {
                    console.error('Error posting data:', error);
                    toast.error("Failed to create obligation.");
                });
        },

        returntoObli() {
            this.$router.push({ path: `/finance/budget/obligation` });
        }
    },
};
</script>
