<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <form class="formQOR" @submit.prevent="updateMonthlyRating">

                    <div class="content-wrapper">
                        <BreadCrumbs />
                        <div class="card">
                            <div class="card-body">

                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;QMS Quality
                                        Procedures
                                    </h5>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Target (%):</label>
                                            <input type="text" class="form-control" v-model="form.target_percentage"
                                                id="target_percentage" disabled />
                                        </div>
                                        <div class="col-md-6">
                                            <label>Objectives Met?:</label>
                                            <br>
                                            <label class="switch">
                                                <input type="checkbox" v-model="form.is_gap_analysis" checked
                                                    @change="toggleGapAnalysis">
                                                <span class="slider round">
                                                    <span class="slider-text off">No</span>
                                                    <span class="slider-text on">Yes</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Quality Objective:</label>

                                            <textarea rows="3" col="100" style="height:110px !important;" id="objective"
                                                class="form-control" v-model="form.objective" disabled></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Gap Analysis:</label>

                                            <textarea rows="3" col="100" style="height:110px !important;"
                                                id="gap_analysis" class="form-control" v-model="form.gap_analysis"
                                                :disabled="form.is_gap_analysis"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INDICATOR 1 -->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_a !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator A: {{ form.indicator_a }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['01']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['02']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['03']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['04']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['05']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['06']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['07']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['08']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['09']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['10']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['11']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[0]['12']" />
                                            </td>
                                            <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INDICATOR 2-->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_b !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator B: {{ form.indicator_b }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['01']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['02']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['03']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['04']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['05']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['06']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['07']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['08']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['09']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['10']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['11']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[1]['12']" />
                                            </td>
                                            <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--INDICATOR 3-->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_c !== null">

                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator C: {{ form.indicator_c }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['01']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['02']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['03']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['04']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['05']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['06']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['07']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['08']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['09']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['10']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['11']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[2]['12']" />
                                            </td>
                                            <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INDICATOR 4 -->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_d !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator D: {{ form.indicator_d }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['01']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['02']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['03']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['04']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['05']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['06']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['07']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['08']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['09']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['10']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['11']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[3]['12']" />
                                            </td>
                                            <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INDICATOR 5: FORMULA -->
                        <div class="card" style="margin-top:1%;" v-if="form.formula !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Formula: {{ form.formula }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['01']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['02']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['03']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['04']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['05']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['06']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['07']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['08']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['09']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['10']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['11']" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control"
                                                    v-model="monthlyData[4]['12']" />
                                            </td>
                                            <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>
                </form>

                <FooterVue />
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect';
import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Pagination from '../../procurement/Pagination.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { toast } from "vue3-toastify";





import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare, faFolderOpen } from '@fortawesome/free-solid-svg-icons';
import axios, { Axios } from 'axios';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare, faFolderOpen);

export default {
    components: {
        Multiselect,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
        FontAwesomeIcon
    },
    data() {
        return {

            monthlyData: [
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' }
            ],
            form: {
                target_percentage: '',
                objective: '',
                gap_analysis: '',
                indicator_b: '',
                indicator_c: '',
                indicator_d: '',
                indicator_e: '',
                formula: ''
            },
        }
    },
    created() {
        this.fetchQOPRUserData();
        this.fetchData();
        // console.log(this.quarterData)
    },
    methods: {
        toggleGapAnalysis() {
            if (this.form.is_gap_analysis) {
                this.form.gap_analysis = '';
            }
        },
        fetchQOPRUserData() {
            let qoe_id = this.$route.params.qoe_id1;
            let id = this.$route.params.id;
            console.log("tbl_qoe ID:", qoe_id)
            console.log("tbl_qop_report ID:", id)
            axios.get(`/api/fetchQOPRUserData/${id}/${qoe_id}`)
                .then(response => {
                    // console.log(response.data)
                    if (Array.isArray(response.data) && response.data.length > 0) {
                        this.form = response.data[0];
                    } else {
                        console.error("Unexpected response format:", response.data);
                    }
                    // this.form = response.data
                    // console.log(this.form[0])
                    // console.log(response.data)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        updateMonthlyRating() {
            if (this.form.is_gap_analysis === true) {
                this.form.is_gap_analysis = '1';
            } else {
                this.form.is_gap_analysis = '0';
            }
            // console.log(this.monthlyData);
            // Assuming you have Axios installed and imported
                axios.post(`/api/saveMonthlyData`, {
                    formData: this.form,
                    monthlyData: this.monthlyData
                })
                    .then(response => {
                        console.log('Updated successfully:', response);
                        // Optionally, handle success response
                        toast.success('Report Successfully Submitted!', {
                        autoClose: 1000
                    });
                    this.fetchQOPRUserData();
                    this.fetchData();
                    })
                    .catch(error => {
                        console.error('Error updating:', error);
                        // Optionally, handle error response
                    });
        },
        fetchData() {
        let qoe_id = this.$route.params.qoe_id1;
        let id = this.$route.params.id;

        axios.get(`/api/fetchMonthlyData/${id}/${qoe_id}`)
            .then(response => {
                console.log('API Response:', response.data);
                this.monthlyData = response.data.monthly; // Assign quarters array to monthlyData
                this.sqlQuery = response.data.sql_query;   // Assign SQL query to sqlQuery for debugging
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
    }
}
</script>



























<!-- 
<template>
    <div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator A:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
					<th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
				</tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" width="7.5%">
                     <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator B:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
					<th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
				</tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" width="7.5%">
                     <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator C:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
					<th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
				</tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" width="7.5%">
                     <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator D:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
					<th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
				</tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" width="7.5%">
                     <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator E:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
					<th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
				</tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" width="7.5%">
                     <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td class="text-center" width="7.5%">
                    <input type="text" class="form-control" id="rev_no" />
                    </td>
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template> -->