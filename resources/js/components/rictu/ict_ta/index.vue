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
                    <BreadCrumbs />
                    <div class="row">
                        <StatBoard />

                        <div class="col-lg-12">
                            <div class="card" v-if="isCardVisible">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h4><font-awesome-icon :icon="['fas', 'search']" />&nbsp;ADVANCED FILTER</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Office</label>
                                                <multiselect v-model="selected_office"
                                                    deselect-label="Can't remove this value" track-by="value"
                                                    label="value" placeholder="Select one" :options="options"
                                                    :searchable="false" :allow-empty="false">
                                                </multiselect>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <TextInput label="Control Number" iconValue="user-gear"
                                                v-model="abstract_no" />
                                        </div>
                                        <div class="col-lg-3">
                                            <TextInput label="Requested By" iconValue="user" v-model="abstract_no" />
                                        </div>

                                        <div class="col-lg-3">
                                            <TextInput label="Request Type" iconValue="gear" v-model="abstract_no" />
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Region</label>
                                                <multiselect v-model="selected_region"
                                                    deselect-label="Can't remove this value" track-by="value"
                                                    label="value" placeholder="Select one" :options="region"
                                                    :searchable="false" :allow-empty="false">
                                                </multiselect>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <TextInput style="height:40px" label="Requested Date" iconValue="calendar"
                                                type="datetime-local" v-model="abstract_no" />
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Quarter</label>
                                                <multiselect v-model="selected_quarter"
                                                    deselect-label="Can't remove this value" track-by="value"
                                                    label="value" placeholder="Select one" :options="quarter"
                                                    :searchable="false" :allow-empty="false">
                                                </multiselect>
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <multiselect v-model="selected_status"
                                                    deselect-label="Can't remove this value" track-by="label"
                                                    label="label" placeholder="Select one" :options="status"
                                                    :searchable="false" :allow-empty="false">
                                                </multiselect>
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Province/HUC</label>
                                                <multiselect v-model="selected_province"
                                                    deselect-label="Can't remove this value" track-by="value"
                                                    label="value" placeholder="Select one" :options="province"
                                                    :searchable="false" :allow-empty="false">
                                                </multiselect>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <TextInput label="Email" iconValue="envelope" v-model="abstract_no" />
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-outline-primary btn-fw btn-icon-text"
                                        style="float:right;" @click="filter()">Filter</button>
                                    <button type="button" class="btn btn-outline-primary btn-fw btn-icon-text mr-3"
                                        style="float:right;">Clear</button>

                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;ICT
                                            Technical Assistance Monitoring
                                        </h5>
                                        <div class="d-flex">
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                                @click="openModal()">
                                                Generate Report
                                            </button>
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                                <router-link class="router-class" style="color:#059886;"
                                                    :to="{ name: 'Create ICT Technical Assistance' }">
                                                    Create Request
                                                </router-link>
                                            </button>
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                                @click="toggleCard()">
                                                Advanced Search
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
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

export default {
    name: 'ICT Technical Assistance',
    data() {
        return {

            abstract_no: null,
            selected: null,
            value: null,
            selected_quarter: null,
            selected_office: null,
            selected_region: null,
            selected_status: null,
            selected_province: null,
            options: [{ label: "ORD", value: "ORD" }, { label: "LGMED", value: "LGMED" }, { label: "LGCDD", value: "LGCDD" }, { label: "FAD", value: "FAD" }],
            region: [{ label: 'REGION IV-A (CALABARZON)', value: 'REGION IV-A (CALABARZON)' }],
            province: [{ label: "Cavite", value: "Cavite" }, { label: "Laguna", value: "Laguna" }, { label: "Batangas", value: "Batangas" }, { label: "Rizal", value: "Rizal" }, { label: "Quezon", value: "Quezon" }, { label: "Lucena City", value: "Lucena City" }],
            quarter: [{ label: '1st Quarter', value: '1st Quarter' }, { label: '2nd Quarter', value: '2nd Quarter' }, { label: '3rd Quarter', value: '3rd Quarter' }, { label: '4th Quarter', value: '4th Quarter' }],
            status: [{ label: 'All', value: 6 }, { label: 'Draft', value: 1 }, { label: 'Received', value: 2 }, { label: 'Completed', value: 3 }, { label: 'Rated', value: 4 }],
            isCardVisible: false,
            modalVisible: false,


        }
    },

    mounted() {
        this.fetchData(); // fetch data initially
        this.timer = setInterval(this.fetchData, 60000); // fetch data every 30 seconds
    },


    methods: {
        async fetchData() {
            // code to fetch data from API or database
            axios.get('../../api/fetch_ict_request')
                .then(response => {
                    this.ict_data = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        
        cancelAutoUpdate() {
            clearInterval(this.timer);
        },

        beforeDestroy() {
            this.cancelAutoUpdate();
        },
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
            const status = this.selected_status.value;
            this.$refs.ICTTable.load_ict_request(status);

            // axios.get(`../../api/fetch_ict_request/${status}`)
            //     .then(response => {
            //         this.ict_data = response.data.data;
            //     })
            //     .catch(error => {
            //         console.error('Error fetching data:', error);
            //     });
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