<style></style>
<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-md-12 grid-margin mb-4 stretch-card">

                            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                                <div class="card card-dark-blue">
                                    <div class="card-body">
                                        <p class="mb-4">APP Item Encoded</p>
                                        <p class="fs-30 mb-2">197</p>
                                        <p>10.00% (as of today)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                                <div class="card card-dark-blue">
                                    <div class="card-body">
                                        <p class="mb-4">APP Item with same Stock No</p>
                                        <p class="fs-30 mb-2">61344</p>
                                        <p>22.00% (30 days)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                                <div class="card card-dark-blue">
                                    <div class="card-body">
                                        <p class="mb-4">Newly Encoded App Item</p>
                                        <p class="fs-30 mb-2">34040</p>
                                        <p>2.00% (30 days)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 card-dark-bluecol-sm-12 col-xs-12 mb-6 stretch-card transparent">
                                <div class="card card-dark-blue">
                                    <div class="card-body">
                                        <p class="mb-4">App Item without Office</p>
                                        <p class="fs-30 mb-2">47033</p>
                                        <p>0.22% (30 days)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">


                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h4><font-awesome-icon :icon="['fas', 'search']" />&nbsp;ADVANCED FILTER</h4>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-3">
                                            <TextInput label="Control Number" iconValue="calendar" v-model="abstract_no"
                                                :value="abstract_no" />
                                        </div>
                                        <div class="col-lg-3">
                                            <TextInput label="Requested By" iconValue="user" v-model="abstract_no"
                                                :value="abstract_no" />
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Office</label>
                                                <multiselect v-model="selected" :options="options"> </multiselect>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <TextInput label="Request Type" v-model="abstract_no" :value="abstract_no" />
                                        </div>
                                        <div class="col-lg-4">
                                            <TextInput label="Requested Date" iconValue="calendar" v-model="abstract_no"
                                                :value="abstract_no" />
                                        </div>
                                        <div class="col-lg-4">
                                            <TextInput label="Quarter" v-model="abstract_no" :value="abstract_no" />
                                        </div>
                                        <div class="col-lg-4">
                                            <TextInput label="Status" iconValue="bars-progress" v-model="abstract_no"
                                                :value="abstract_no" />
                                        </div>
                                    </div>
                                    <button class="btn btn-success" style="background-color:#059886">
                                        <router-link style="color:#fff;" :to="{ name: 'Create ICT Technical Assistance' }">
                                            Create Request </router-link>
                                    </button>
                                    <button type="button" class="btn btn-success" style="float:right;background-color:#059886">Filter</button>
                                    <button type="button" class="btn btn-primary mr-3" style="float:right;">Clear</button>

                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="card-title"><font-awesome-icon
                                                :icon="['fas', 'list']"></font-awesome-icon>&nbsp;ICT Technical Assistance
                                            Monitoring
                                        </h5>
                                    </div>
                                    <div class="table-responsive">
                                        <ICTTable />
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
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faList, faSearch } from '@fortawesome/free-solid-svg-icons';

library.add(faSearch, faList);


import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import TextInput from '../../micro/TextInput.vue';
import ICTTable from './table.vue';
import Multiselect from 'vue-multiselect'

import axios from 'axios';

export default {
    name: 'ICT Technical Assistance',
    data() {
        return {
            abstract_no: null,
            selected: null,
            options: ["A", "b", "c"],
        }
    },
    methods: {
        
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        FontAwesomeIcon,
        TextInput,
        ICTTable,
        Multiselect

    },
}


</script>