<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <form class="formQOR" @submit.prevent="updateQuarterRating">

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
                                        <button type="button" @click="Return()"
                                            class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                            Return
                                        </button>
                                        <button type="submit" class="btn btn-outline-success btn-fw btn-icon-text mx-2"
                                            :disabled="status != 0">
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
                                                <input type="checkbox" v-model="form.is_gap_analysis" :checked="form.is_gap_analysis==1"
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
                                            <th class="text-center" width="7.5%">1ST QUARTER</th>
                                            <th class="text-center" width="7.5%">2ND QUARTER</th>
                                            <th class="text-center" width="7.5%">3RD QUARTER</th>
                                            <th class="text-center" width="7.5%">4TH QUARTER</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="hidden" class="form-control"
                                                    v-model="quarterData[0].indicator">
                                                <input type="text" class="form-control" v-model="quarterData[0].Q1"
                                                    :disabled="qp_covered !== '1st Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[0].Q2"
                                                    :disabled="qp_covered !== '2nd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[0].Q3"
                                                    :disabled="qp_covered !== '3rd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[0].Q4"
                                                    :disabled="qp_covered !== '4th Quarter'">
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">0.00</td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INDICATOR 2 -->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_b !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator B: {{ form.indicator_b }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">1ST QUARTER</th>
                                            <th class="text-center" width="7.5%">2ND QUARTER</th>
                                            <th class="text-center" width="7.5%">3RD QUARTER</th>
                                            <th class="text-center" width="7.5%">4TH QUARTER</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="hidden" class="form-control"
                                                    v-model="quarterData[1].indicator">
                                                <input type="text" class="form-control" v-model="quarterData[1].Q1"
                                                    :disabled="qp_covered !== '1st Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[1].Q2"
                                                    :disabled="qp_covered !== '2nd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[1].Q3"
                                                    :disabled="qp_covered !== '3rd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[1].Q4"
                                                    :disabled="qp_covered !== '4th Quarter'">
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">0.00</td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INDICATOR 3 -->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_c !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator C: {{ form.indicator_c }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">1ST QUARTER</th>
                                            <th class="text-center" width="7.5%">2ND QUARTER</th>
                                            <th class="text-center" width="7.5%">3RD QUARTER</th>
                                            <th class="text-center" width="7.5%">4TH QUARTER</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="hidden" class="form-control"
                                                    v-model="quarterData[2].indicator">
                                                <input type="text" class="form-control" v-model="quarterData[2].Q1"
                                                    :disabled="qp_covered !== '1st Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[2].Q2"
                                                    :disabled="qp_covered !== '2nd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[2].Q3"
                                                    :disabled="qp_covered !== '3rd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[2].Q4"
                                                    :disabled="qp_covered !== '4th Quarter'">
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">0.00</td> -->
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
                                            <th class="text-center" width="7.5%">1ST QUARTER</th>
                                            <th class="text-center" width="7.5%">2ND QUARTER</th>
                                            <th class="text-center" width="7.5%">3RD QUARTER</th>
                                            <th class="text-center" width="7.5%">4TH QUARTER</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="hidden" class="form-control"
                                                    v-model="quarterData[3].indicator">
                                                <input type="text" class="form-control" v-model="quarterData[3].Q1"
                                                    :disabled="qp_covered !== '1st Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[3].Q2"
                                                    :disabled="qp_covered !== '2nd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[3].Q3"
                                                    :disabled="qp_covered !== '3rd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[3].Q4"
                                                    :disabled="qp_covered !== '4th Quarter'">
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">0.00</td> -->
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
                                            <th class="text-center" width="7.5%">1ST QUARTER</th>
                                            <th class="text-center" width="7.5%">2ND QUARTER</th>
                                            <th class="text-center" width="7.5%">3RD QUARTER</th>
                                            <th class="text-center" width="7.5%">4TH QUARTER</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="hidden" class="form-control"
                                                    v-model="quarterData[4].indicator">
                                                <input type="text" class="form-control" v-model="quarterData[4].Q1"
                                                    :disabled="qp_covered !== '1st Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[4].Q2"
                                                    :disabled="qp_covered !== '2nd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[4].Q3"
                                                    :disabled="qp_covered !== '3rd Quarter'">
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="quarterData[4].Q4"
                                                    :disabled="qp_covered !== '4th Quarter'">
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">0.00</td> -->
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

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
import rs_quarterly_lnd_entries from './rs_quarterly_lnd_entries.vue';
import rs_quarterly_entries from './rs_quarterly_entries.vue';
import rs_monthly_entries from './rs_monthly_entries.vue';




import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare, faFolderOpen } from '@fortawesome/free-solid-svg-icons';
import axios, { Axios } from 'axios';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare, faFolderOpen);


export default {
    components: {
        rs_quarterly_lnd_entries,
        rs_monthly_entries,
        rs_quarterly_entries,
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
            qp_covered: this.$route.query.pq,
            status: Number(this.$route.query.stat),
            quarterData: [
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, Q1: '', Q2: '', Q3: '', Q4: '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, Q1: '', Q2: '', Q3: '', Q4: '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, Q1: '', Q2: '', Q3: '', Q4: '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, Q1: '', Q2: '', Q3: '', Q4: '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, Q1: '', Q2: '', Q3: '', Q4: '' }
            ],

            form: {
                // qp_covered: '',
                target_percentage: '',
                objective: '',
                is_gap_analysis: '',
                gap_analysis: '',
                indicator_b: '',
                indicator_c: '',
                indicator_d: '',
                indicator_e: '',
                formula: ''
            }
        }
    },

    props: {
        // form: Object
        // is_new: String
    },
    created() {
        this.fetchQOPRUserData();
        this.fetchData();
    },

    methods: {
        Return() {

            Swal.fire({
                title: 'Are you sure you want to return?',
                text: 'Make sure to submit the form to avoid losing data.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, return',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = this.$route.params.id;
                    this.$router.push({ path: `/qms/reports_submission/rs_update/${id}` });
                }
            });


        },
        toggleGapAnalysis() {
            if (this.form.is_gap_analysis) {
                this.form.gap_analysis = '';
            }
        },
        fetchQOPRUserData() {
            // console.log(qp_covered)
            let qoe_id = this.$route.params.qoe_id1;
            let id = this.$route.params.id;
            // console.log("tbl_qoe ID:", qoe_id)
            // console.log("tbl_qop_report ID:", id)
            axios.get(`/api/fetchQOPRUserData/${id}/${qoe_id}`)
                .then(response => {
                    // console.log(response.data)
                    if (Array.isArray(response.data) && response.data.length > 0) {
                        this.form = response.data[0];
                        console.log("fetchQOPRUserData:",this.form)
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
        updateQuarterRating() {
            Swal.fire({
                title: 'Do you want to Continue?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    if (this.form.is_gap_analysis === true) {
                        this.form.is_gap_analysis = '1';
                    } else {
                        this.form.is_gap_analysis = '0';
                    }
                    // console.log(this.form);
                    // console.log(this.quarterData);
                    // Assuming you have Axios installed and imported
                    axios.post(`/api/saveQuarterData`, {
                        quarterData: this.quarterData,
                        formData: this.form
                    })
                        .then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Report Successfully Submitted!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                this.fetchQOPRUserData();
                                this.fetchData();
                            }, 200);
                        })
                        .catch(error => {
                            console.error('Error updating:', error);
                            // Optionally, handle error response
                        });

                }
            });
        },
        fetchData() {
            // Assuming you fetch data and update quarterData
            let qoe_id = this.$route.params.qoe_id1;
            let id = this.$route.params.id;
            axios.get(`/api/fetchQuarterData/${id}/${qoe_id}`)
                .then(response => {
                    console.log("fetchQuarterData:",response.data.quarters)
                    this.quarterData = response.data.quarters; // Update quarterData with fetched values
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        // fetchQOPRqpcovered(){
        //     axios.get(`/api/fetchQOPRqpcovered/`)
        // }


    }


};
</script>

<style>
td {
    text-align: center;
}

th {
    text-align: center;
}

/* Custom styles for text overflow with ellipsis */
.multiselect__tags {
    display: flex;
    flex-wrap: wrap;
}

.multiselect__tag {
    display: inline-flex;
    align-items: center;
    max-width: 150px;
    /* Adjust the width as needed */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin: 2px;
    /* Adjust margin as needed */
}

.multiselect__tag span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.multiselect__tag-icon {
    margin-left: 4px;
    flex-shrink: 0;
}

.switch {
    position: relative;
    display: inline-block;
    width: 70px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(36px);
    -ms-transform: translateX(36px);
    transform: translateX(36px);
}

.slider .slider-text {
    position: absolute;
    width: 100%;
    text-align: center;
    line-height: 34px;
    color: white;
    font-size: 14px;
    pointer-events: none;
}

.slider .slider-text.on {
    left: 38%;
    transform: translateX(-50%);
    display: none;
}

.slider .slider-text.off {
    right: 40%;
    transform: translateX(50%);
}

input:checked+.slider .slider-text.on {
    display: block;
}

input:checked+.slider .slider-text.off {
    display: none;
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>