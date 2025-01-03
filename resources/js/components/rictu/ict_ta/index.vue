<style>
.card-animation {
    transition: height 0.5s ease-in-out;
    /* Adjust the duration and timing function as needed */
}

h5 {
    color: #059886 !important;
    --bs-text-opacity: 1;
}

.router-class:hover {
    color: #059886 !important;
}
</style>

<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- <BreadCrumbs /> -->
                    <div class="row">
                        <StatBoard />
                        <div class="col-lg-12">
                            <div class="card mt-12">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;ICT
                                            Technical Assistance Monitoring
                                        </h5>
                                        <div class="d-flex">

                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                                @click="openModal()" v-if="this.role == 'admin'">
                                                Generate Report
                                            </button>
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                                @click="toggleCard()" v-if="this.role == 'admin'">
                                                Advanced Search
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <div class="card" v-if="isCardVisible">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h4><font-awesome-icon :icon="['fas', 'search']" />&nbsp;ADVANCED
                                                        FILTER</h4>
                                                </div>
                                                <div class="row">

                                                    <div class="col-lg-3">
                                                        <label style="font-size: 0.875rem;">Control No</label>
                                                        <input type="text" v-model="control_no"
                                                            placeholder="Control Number" @keyup.enter="filter" />
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label style="font-size: 0.875rem;">Request By</label>
                                                        <input type="text" v-model="requested_by"
                                                            placeholder="Requested By" @keyup.enter="filter" />
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <label style="font-size: 0.875rem;">Technical Personnel</label>
                                                        <input type="text" v-model="ict_personnel"
                                                            placeholder="Technical Personnel" @keyup.enter="filter" />
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label style="font-size: 0.875rem;">Start Date</label>
                                                        <input type="date" class="form-control" v-model="start_date" />
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label style="font-size: 0.875rem;">End Date</label>
                                                        <input type="date" class="form-control" v-model="end_date" />
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label style="font-size: 0.875rem;">OFFICE/SERVICE/BUREAU
                                                            DIVISION/SECTION/UNIT</label>
                                                        <multiselect v-model="selected_pmo" :options="pmo" label="label"
                                                            :multiple="false"></multiselect>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label style="font-size: 0.875rem;">Status</label>
                                                            <multiselect v-model="selected_status"
                                                                deselect-label="Can't remove this value"
                                                                track-by="value" label="label" :options="status"
                                                                :searchable="false" :allow-empty="false">
                                                            </multiselect>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button"
                                                    class="btn btn-outline-primary btn-fw btn-icon-text"
                                                    style="float:right;" @click="filter()">Filter</button>
                                                <button type="button"
                                                    class="btn btn-outline-primary btn-fw btn-icon-text mr-3"
                                                    style="float:right;" @click="resetFilter()">Clear</button>
                                            </div>
                                        </div>
                                        <ICTTable ref="ICTTable" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal_export :visible="modalVisible" @close="closeModal" />

    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faList, faSearch, faSquarePollVertical, faUserGear } from '@fortawesome/free-solid-svg-icons';

library.add(faSearch, faList, faSquarePollVertical, faUserGear);


import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import TextInput from '../../micro/TextInput.vue';
import ICTTable from './table.vue';
import Multiselect from 'vue-multiselect'
import StatBoard from './stat_board';
import modal_export from '../modal/modal_generate_report.vue';
import axios from 'axios';
import Pusher from 'pusher-js';
import Swal from 'sweetalert2';

export default {
    name: 'ICT Technical Assistance',
    data() {
        return {
            role: null,
            control_no: '',
            requested_by: '',
            start_date: '',
            end_date: '',
            value: null,
            ict_personnel: null,
            modalVisible: false,
            selected_pmo: [],
            pmo: [
                { label: "ORD", value: "ORD" },
                { label: "LGMED", value: "LGMED" },
                { label: "LGCDD", value: "LGCDD" },
                { label: "FAD", value: "FAD" },
                { label: "BATANGAS", value: "BATANGAS" },
                { label: "CAVITE", value: "CAVITE" },
                { label: "LAGUNA", value: "LAGUNA" },
                { label: "QUEZON", value: "QUEZON" },
                { label: "RIZAL", value: "RIZAL" },
                { label: "LUCENA CITY", value: "LUCENA CITY" }
            ],
            status: [
                { label: 'All', value: 6 },
                { label: 'Draft', value: 1 },
                { label: 'Received', value: 2 },
                { label: 'Completed', value: 3 },
                { label: 'Rated', value: 4 }
            ],
            selected_status: { label: 'All', value: 6 },
            isCardVisible: false,
        }
    },
    created() {
        // Set the role from localStorage
        this.role = localStorage.getItem('user_role');
    },
    methods: {
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
        },
        openModal() {
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        filter() {
            const status = this.selected_status ? this.selected_status.value : null;
            const controlNo = this.control_no;
            const requestedBy = this.requested_by;
            const ictPersonnel = this.ict_personnel;
            const startDate = this.start_date;
            const endDate = this.end_date;
            const pmo = this.selected_pmo ? this.selected_pmo.value : null;

            // Extract the year from the start_date or end_date
            let year = null;
            if (startDate) {
                year = new Date(startDate).getFullYear();
            } else if (endDate) {
                year = new Date(endDate).getFullYear();
            }

            this.$refs.ICTTable.load_ict_request(status, controlNo, requestedBy, startDate, endDate, pmo, ictPersonnel, year);
        },
        resetFilter() {
            this.control_no = '';
            this.requested_by = '';
            this.ict_personnel = '';
            this.start_date = '';
            this.end_date = '';
            this.selected_pmo = '';
            this.selected_status = { label: 'All', value: 6 };
            //LOAD ALL DATA AFTER RESET
            const status = this.selected_status ? this.selected_status.value : 6;
            this.$refs.ICTTable.load_ict_request(status);
        },
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        FontAwesomeIcon,
        TextInput,
        ICTTable,
        Multiselect,
        StatBoard,
        modal_export

    },
}


</script>
