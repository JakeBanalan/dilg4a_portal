<style>
.img-header {
    width: 150px !important;
    height: 150px !important;
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
                        <div class="col-lg-9">
                            <img :src="dilg_logo" class="img-header" align="left">
                            <h1 style="font-family:'Times New Roman', Times, serif;font-size:24px;"> Republic of the
                                Philippines</h1>
                            <h2 style="font-family:'Times New Roman', Times, serif;font-size:30px;font-weight:bold">
                                Department of the Interior and Local Government</h2>
                            <h2 style="font-family:'Times New Roman', Times, serif; font-weight:bolder;"><u> ICT
                                    TECHNICAL ASSISTANCE REQUEST FORM</u></h2><br><br>
                            <h3 style="font-family:'Times New Roman', Times, serif;font-size:20px;">NOTE: FILL-UP
                                THIS FORM AND PLEASE WRITE LEGIBLY. (* - REQUIRED)</h3>
                        </div>
                        <div class="col-lg-3">
                            <div class="box box-primary box-solid dropbox" style="border:1px solid black;">
                                <div class="box-header with-border"
                                    style="background-color: #000;padding:2px;color:#fff;">
                                    <h6 class="box-title">Document Code</h6>
                                </div>
                                <div class="box-header with-border" style="color:black;padding:2px;text-align:center;">
                                    <h6 class="box-title">FM-QP-DILG-ISTMS-RO-17-01</h6>
                                </div>
                                <div class="box-header with-border"
                                    style="display: flex; align-items: center; height: 30px; background-color: #000;padding:2px;color:#fff;">
                                    <div style="margin: 0 10px;">Rev No</div>
                                    <div style="width: 2px; height: 30px; background-color: black; margin: 0 30px;">
                                    </div>
                                    <div style="margin: 0 10px;">Eff. Date</div>
                                    <div style="width: 2px;  height: 30px; background-color: black; margin: 0 30px;">
                                    </div>
                                    <div style="margin: 0 10px;">Page</div>
                                </div>
                                <div class="box" style="display: flex; align-items: center; height: 50px;">
                                    <div style="margin: 0 30px;">01</div>
                                    <div style="width: 2px; height: 50px; background-color: black; margin: 0 30px;">
                                    </div>
                                    <div style="margin: 0 5px;">03.01.23</div>
                                    <div style="width: 2px; height: 50px; background-color: black; margin: 0 25px;">
                                    </div>
                                    <div style="margin: 0 20px;">1 of 1</div>
                                </div>

                            </div>
                            <div class="box box-primary box-solid dropbox" style="border:1px solid black;">
                                <div class="box-header with-border" style="background-color: #000;color:#fff;">
                                    <h4 class="box-title">ICT Technical Assistance Reference Number</h4>
                                </div>
                                <center><span style="text-align:center;color:red;font-weight:bold;font-size:24px;">
                                        {{ data.control_no }}
                                    </span></center>
                            </div>
                        </div>


                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h4><font-awesome-icon :icon="['fas', 'circle-info']"
                                                class="mr-2"></font-awesome-icon>TECHNICAL ASSISTANCE FORM</h4>
                                    </div>
                                    <div class="row">
                                        <!-- <div class="col-lg-6">
                                            <TextInput label="Control Number" iconValue="gear" v-model="data.control_no"
                                                :value="data.control_no" :readonly="true" />
                                        </div> -->
                                        <div class="col-lg-6">
                                            <TextInput label="Date" iconValue="calendar" type="text"
                                                style="height: 40px !important;" v-model="data.requested_date"
                                                :value="formatDate(data.requested_date)" disabled />
                                        </div>
                                        <div class="col-lg-6">
                                            <TextInput label="Time" iconValue="calendar" type="text"
                                                style="height: 40px !important;" v-model="data.started_time"
                                                :value="data.started_time" disabled />
                                        </div>

                                        <div class="col-lg-12 mt-4">
                                            <TextInput label="Requested By" iconValue="user" v-model="data.requested_by"
                                                :value="data.requested_by" :readonly="true" />
                                        </div>
                                        <div class="col-lg-12">
                                            <TextInput label="Office/Service/Bureau/Section/Division/Unit:"
                                                iconValue="building" :value="data.office" :readonly="true" />
                                        </div>

                                        <div class="col-lg-12">
                                            <TextInput label="Contact Number/E-mail" iconValue="envelope-open-text"
                                                :value="data.email" :readonly="true" />
                                        </div>

                                        <div class="col-lg-12">
                                            <TextInput label="Agreed Timeline if any:" iconValue="check-circle"
                                                :readonly="false" />
                                        </div>

                                    </div>
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h4><font-awesome-icon :icon="['fas', 'circle-info']"
                                                class="mr-2"></font-awesome-icon>HARDWARE INFORMATION (if needed)</h4>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <TextInput disabled label="Equipment Type:" iconValue="server"
                                                v-model="data.equipment_type" :value="data.equipment_type" />
                                        </div>
                                        <div class="col-lg-12">
                                            <TextInput disabled label="Brand/Model:" iconValue="copyright"
                                                v-model="data.brand" :value="data.brand" />
                                        </div>
                                        <div class="col-lg-12">
                                            <TextInput disabled label="Property No:" iconValue="bars"
                                                v-model="data.property_no" :value="data.property_no" />
                                        </div>
                                        <div class="col-lg-12">
                                            <TextInput disabled label="Equipment SN:" iconValue="hashtag"
                                                v-model="data.serial_no" :value="data.serial_no" />
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card mt-4">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <TextInput label="Type of Request" iconValue="hashtag"
                                                v-model="data.request_type" :value="data.request_type" disabled />
                                        </div>
                                        <div class="col-lg-6 mb-4" v-if="data.req_id == 9">
                                            <TextInput label="Request Category" iconValue="hashtag"
                                                v-model="data.others" :value="data.others" disabled />
                                        </div>
                                        <div class="col-lg-6 mb-4" v-else-if="data.req_id = 7">

                                            <TextInput label="Request Category" iconValue="hashtag"
                                                v-model="data.sub_request_type" :value="data.sub_request_type"
                                                disabled />
                                            <TextInput label="Web Apps/Website Access" iconValue="hashtag"
                                                v-model="data.website_access" :value="data.website_access" disabled />
                                        </div>
                                        <div class="col-lg-6 mb-4" v-else-if="data.req_id = 4">

                                            <TextInput label="Request Category" iconValue="hashtag"
                                                v-model="data.sub_request_type" :value="data.sub_request_type"
                                                disabled />
                                            <TextInput label="Others (please specify):" iconValue="hashtag"
                                                v-model="data.others" :value="data.others_software" disabled />
                                        </div>


                                        <div class="col-lg-6">
                                            <TextAreaInput label="ADDITIONAL INFORMATION/REMARKS (if any): "
                                                v-model="remarks" :value="data.remarks" />
                                        </div>

                                        <div class="col-lg-6">
                                            <TextAreaInput label="RECOMMENDATION" v-model="remarks"
                                                :value="data.ict_officer_remarks" />
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mt-4">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <TextInput disabled label="Acceptance of Service Rendered" iconValue="user"
                                                v-model="acceptance" :value="data.requested_by" :readonly="true" />


                                        </div>
                                        <div class="col-lg-3">
                                            <TextInput disabled label="ICT Technical Personnel " iconValue="user"
                                                v-model="data.ict_personnel" :value="data.ict_personnel" />
                                        </div>
                                        <div class="col-lg-3">
                                            <TextInput disabled label="Date/Time" iconValue="calendar"
                                                v-model="data.requested_date"
                                                :value="formatDateTime(data.requested_date)" />
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
<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCircleInfo } from '@fortawesome/free-solid-svg-icons';
import Multiselect from 'vue-multiselect'

library.add(faCircleInfo);
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import { toast } from "vue3-toastify";
import logo from "../../../../assets/logo.png";
export default {
    name: 'View ICT Form',
    data() {
        return {
            dilg_logo: logo,
            accessToken: null,
            remarks: null,
            acceptance: null,
            ict_personnel: null,
            abstract_no: null,
            selected: null,
            ict_no: null,
            selectedType: null,
            selectedSubRequest: null,
            hardwareInfo: {
                etype: null,
                brand: null,
                pNumber: null,
                eSerial: null,
            },
            data: {
                control_no: null,
                requested_by: null,
                office: null,
                email: null,
                requested_date: null,
                equipment_type: null,
                brand: null,
                property_no: null,
                serial_no: null,
                request_type: null,
                request_category: null,
                issue_concern: null,
                remarks: null,
                ict_personnel: null,
                ict_officer_remarks: null,
                remarks: null
            },

        }
    },
    mounted() {
        this.getICTData();
    },
    methods: {
        getICTData() {
            let id = this.$route.query.id;
            axios.get(`../../../api/getICTData/${id}`)
                .then((response) => {
                    this.data = response.data
                }).catch(error => {
                    return null;
                });
        },
        formatDate(date) {
            if (!date || date === '0000-00-00') {
                return null; // Return null if the date is null or '0000-00-00'
            } else {
                const formattedDate = new Date(date).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',

                });
                return formattedDate;
            }
        },
        formatDateTime(date) {
            if (!date || date === '0000-00-00') {
                return null; // Return null if the date is null or '0000-00-00'
            } else {
                const formattedDate = new Date(date).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true // Change to false for 24-hour format
                });
                return formattedDate;
            }
        },
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        FontAwesomeIcon,
        Multiselect

    },
}

</script>