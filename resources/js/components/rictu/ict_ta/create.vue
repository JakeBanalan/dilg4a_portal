<style scoped>
.file-upload {
    width: 100%;
    border: 2px dotted #ccc;
    padding: 50px;
    text-align: center;
}

#file-input {
    display: none;
}

.upload-text {
    margin-top: 10px;
    font-size: 16px;
}

img {
    width: 50px;
    height: 50px;
}

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
                    <form @submit.prevent="create_ict_ta()">
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
                                    <div class="box-header with-border"
                                        style="color:black;padding:2px;text-align:center;">
                                        <h6 class="box-title">FM-QP-DILG-ISTMS-RO-17-01</h6>
                                    </div>
                                    <div class="box-header with-border"
                                        style="background-color: #000;padding:2px;color:#fff;">
                                        <h6 class="box-title" style="text-align: center;">Rev No. Eff. Date Page</h6>
                                    </div>
                                    <div class="box-header with-border" style="background-color:#fff;padding:2px;">
                                        <h6 class="box-title">00 06.15.21 1 of 1</h6>
                                    </div>

                                </div>
                                <div class="box box-primary box-solid dropbox" style="border:1px solid black;">
                                    <div class="box-header with-border" style="background-color: #000;color:#fff;">
                                        <h4 class="box-title">ICT Technical Assistance Reference Number</h4>
                                    </div>
                                    <center><span style="text-align:center;color:red;font-weight:bold;font-size:24px;">
                                            {{ ict_no }}
                                        </span></center>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h4><font-awesome-icon :icon="['fas', 'circle-info']"
                                                    class="mr-2"></font-awesome-icon>TECHNICAL ASSISTANCE FORM</h4>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <input type="hidden" v-model="ict_no" />
                                                <TextInput label="Requested Date:" iconValue="calendar" type="date"
                                                    style="height: 40px !important;" v-model="requested_date"
                                                    :readonly="true" :value="requested_date" />
                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="Time:" iconValue="calendar" type="text"
                                                    style="height: 40px !important;" v-model="requested_time"
                                                    :readonly="true" :value="formatTime(requested_time)" />
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <TextInput label="Requested By:" iconValue="user"
                                                    v-model="userData.name" :value="userData.name" :readonly="true" />
                                                <!-- <Multiselect @update:modelValue="PostUserRequestID" :options="request_by"
                                                    track-by="value" v-model="form.request_by" :multiple="false"
                                                    label="label" :searchable="false" id="request_by"
                                                    placeholder="Select Name">
                                                </Multiselect> -->
                                            </div>
                                            <div class="col-lg-12">
                                                <TextInput label="Office/Service/Bureau/Section/Division/Unit:"
                                                    iconValue="building" :value="userData.pmo_title" :readonly="true" />
                                            </div>
                                            <div class="col-lg-12">
                                                <TextInput label="Contact Number/E-mail:" iconValue="envelope-open-text"
                                                    :value="userData.email" :readonly="true" />
                                            </div>
                                            <div class="col-lg-12">
                                                <TextInput label="Agreed Timeline if any:" iconValue="check-circle"
                                                    :readonly="false" />
                                            </div>




                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h4><font-awesome-icon :icon="['fas', 'circle-info']"
                                                    class="mr-2"></font-awesome-icon>HARDWARE INFORMATION (if needed)
                                            </h4>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <TextInput label="Equipment Type:" iconValue="server"
                                                    v-model="hardwareInfo.etype" />
                                            </div>
                                            <div class="col-lg-12">
                                                <TextInput label="Brand/Model:" iconValue="copyright"
                                                    v-model="hardwareInfo.brand" />
                                            </div>
                                            <div class="col-lg-12">
                                                <TextInput label="Property No:" iconValue="bars"
                                                    v-model="hardwareInfo.pNumber" />
                                            </div>
                                            <div class="col-lg-12">
                                                <TextInput label="Equipment SN:" iconValue="hashtag"
                                                    v-model="hardwareInfo.eSerial" />
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group" style="height: 70px;">


                                                </div>
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
                                                <div class="form-group">
                                                    <label>TYPE OF REQUEST (CHOOSE THAT ALL APPLY)</label>
                                                    <multiselect v-model="selectedType" :options="options" label="label"
                                                        :multiple="false"></multiselect>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-4">
                                                <div class="form-group">
                                                    <label v-if="!isOthersType">NAME OF SUB REQUEST</label>
                                                    <multiselect v-if="!isOthersType" v-model="selectedSubRequest"
                                                        :options="filteredSubRequests" label="label" :multiple="false">
                                                    </multiselect>

                                                    <label v-else>PLEASE SPECIFY</label>
                                                    <TextInput v-else label="Please Specify" iconValue="hashtag"
                                                        v-model="selectedSubRequest" />
                                                    <div v-if="isPortalSystem">
                                                        <TextInput label="Please specify what portal:"
                                                            iconValue="hashtag" v-model="portal_system" />
                                                    </div>
                                                    <div v-else>

                                                    </div>
                                                    <div v-if="internetConnect">
                                                        <TextInput label="Please specify what website:"
                                                            iconValue="hashtag" v-model="website_access" />
                                                    </div>
                                                    <div v-else>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <TextAreaInput label="ADDITIONAL INFORMATION/REMARKS *(REQUIRED): "
                                                    v-model="remarks" />
                                            </div>

                                            <!-- Conditionally Render the Desktop Component -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-12">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="file-upload">
                                                <label for="file-input">
                                                    <img src="upload-icon.png" alt="Upload Icon">
                                                    <div class="upload-text">Drag & Drop files here or click to select files
                                                    </div>
                                                </label>
                                                <input id="file-input" type="file" multiple>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-lg-12">
                                <div class="card mt-4">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <TextInput label="Acceptance of Service Rendered" iconValue="user"
                                                    v-model="acceptance" :value="userData.name" :readonly="true" />


                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="ICT Technical Personnel " iconValue="user"
                                                    v-model="ict_personnel" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success mt-4" style="width: 100%;"
                                    @click="create_ict_ta" :disabled="isSaving" variant="primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style src="../../../../../public/vendors/select2/select2.min.css"></style>
<script>
import Swal from 'sweetalert2';
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
    name: 'Create ICT Technical Assistance',
    components: { Multiselect },
    data() {
        return {
            isSaving: false,
            dilg_logo: logo,
            folderId: '1AmuHQn3YkNEEVdR3RbpijsaX9NKT1oub', // Replace 'YOUR_FOLDER_ID' with the ID of your target folder
            accessToken: null,
            remarks: null,
            acceptance: null,
            ict_personnel: null,
            abstract_no: null,
            selected: null,
            ict_no: null,
            selectedType: null,
            selectedSubRequest: null,
            toastShown: false,
            hardwareInfo: {
                etype: null,
                brand: null,
                pNumber: null,
                eSerial: null,
            },
            requested_date: new Date().toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            }).split('/').reverse().join('-'),
            requested_time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }), // Set current time        
            userData: {
                name: null,
                pmo_title: null,
                email: null,
                // Set current date in dd/mm/yyyy format

            },
            options: [
                { label: 'DESKTOP/LAPTOP REPAIR', value: 1 },
                { label: 'HARDWARE INSTALLATION', value: 2 },
                { label: 'PRINTER/SCANNER/COPIER', value: 3 },
                { label: 'APPLICATION/SOFTWARE/SYSTEM ASSISTANCE', value: 4 },
                { label: 'GOVMAIL ASSISTANCE', value: 5 },
                { label: 'IP TELEPHONY', value: 6 },
                { label: 'INTERNET CONNECTIVITY', value: 7 },
                { label: 'POSTING/UPDATING OF INFORMATION IN THE DILG WEBSITE', value: 8 },
                { label: 'OTHERS (please specify)', value: 9 },
            ],

            sub_request: [
                { label: 'Hardware Related', value: '1', type: 1 },
                { label: 'Software Related', value: '2', type: 1 },
                { label: 'PC Reformat/Reimage', value: '3', type: 1 },
                { label: 'PC Tuneup/Windows Update', value: '4', type: 1 },
                { label: 'Virus Scanning', value: '5', type: 1 },

                { label: 'Desktop Assembly/PC Setup', value: '6', type: 2 },
                { label: 'Computer Parts Installation', value: '7', type: 2 },
                { label: 'Router/Access Point Installation', value: '8', type: 2 },
                { label: 'Network Switch Deployment', value: '9', type: 2 },

                { label: 'Installation/Setup', value: '10', type: 3 },
                { label: 'Networking/Sharing', value: '11', type: 3 },
                { label: 'Troubleshooting', value: '12', type: 3 },

                { label: 'DILG Portal/System', value: '13', type: 4 },
                { label: 'Google Drive', value: '14', type: 4 },
                { label: 'Software Installation', value: '15', type: 4 },
                { label: 'Video Conferencing', value: '16', type: 4 },
                { label: 'Others (please specify)', value: '17', type: 4 },

                { label: 'Create/Update/Delete Account', value: '18', type: 5 },
                { label: 'Password Reset/Unlock Account', value: '19', type: 5 },

                { label: 'Installation', value: '20', type: 6 },
                { label: 'Troubleshooting', value: '21', type: 6 },

                { label: 'Installation/Relocation (Wired)', value: '22', type: 7 },
                { label: 'Installation/Relocation (Wireless)', value: '23', type: 7 },
                { label: 'Troubleshooting (Wired)', value: '24', type: 7 },
                { label: 'Troubleshooting (Wireless)', value: '25', type: 7 },
                { label: 'Web Apps/Website Access', value: '26', type: 7 },
                { label: 'POSTING/UPDATING OF INFORMATION IN THE DILG WEBSITE', value: '27', type: 8 },
            ]
        }
    },
    computed: {
        filteredSubRequests() {
            if (!this.selectedType || this.selectedType.value === 9) {
                return [];
            }
            return this.sub_request.filter(item => item.type === this.selectedType.value);
        },
        isOthersType() {
            return this.selectedType && this.selectedType.value === 9;
        },
        isPortalSystem() {
            return this.selectedSubRequest &&
                (this.selectedSubRequest.value == 13 || this.selectedSubRequest.value == 17);
        },
        internetConnect() {
            return this.selectedSubRequest && this.selectedSubRequest.value == 26;
        }
    },
    mounted() {
        this.generateICTControlNo();
        this.fetchEndUserInfo();
    },
    created(){
        // this.PostUserRequestID()
    },
    methods: {
        // PostUserRequestID() {
        //     axios.get('/api/PostUserRequestID')
        //         .then(response => {
        //             // console.log(response.data)
        //             this.qp_code = response.data.map(qp_code => ({
        //                 label: qp_code.qp_code,
        //                 value: qp_code.id
        //             }))
        //             // this.QualityProcedure = response.data
        //             // console.log(this.QualityProcedure)
        //         })
        //         .catch(error => {
        //             console.error('Error Fetching items:', error)
        //         })
        // },
        formatTime(time) {
            if (!time) return '';
            const [hours, minutes] = time.split(':');
            let hour = parseInt(hours);
            if (hour >= 12) {
                if (hour > 12) {
                    hour -= 12;
                }
            }
            return `${hour}:${minutes}:${new Date().getSeconds()}`;
        },
        showToatSuccess(message) {
            toast.success(message, {
                autoClose: 1500,
            });
        },
        async create_ict_ta() {
            if (this.isSaving) return; // prevent multiple clicks

            // Validation: Check if remarks is not empty
            if (!this.remarks || this.remarks.trim() === '') {
                if (!this.toastShown) {
                    this.toastShown = true;
                    toast.error("Please fill out the 'REMARKS.'", {
                        autoClose: 2500,
                    });
                }
                return;
            }

            this.isSaving = true; // Set saving flag

            const selectedRequest = (this.selectedType.value == 9) ? this.selectedSubRequest : this.selectedSubRequest.value;
            const portal_system = (this.selectedType.value == 4) ? this.portal_system : null;
            const web_access = (this.selectedType.value == 7) ? this.website_access : null;
            const userId = localStorage.getItem('userId');

            this.$fetchUserData(userId, '../../../../api/fetchUser')
                .then(emp_data => {
                    axios.post('/api/post_create_ict_request', {
                        control_no: this.ict_no,
                        requested_by: userId,
                        requested_date: `${this.requested_date} ${this.formatTime(this.requested_time)}`,
                        pmo: emp_data.id,
                        email: emp_data.email,
                        equipment_type: this.hardwareInfo.etype,
                        brand: this.hardwareInfo.brand,
                        property_no: this.hardwareInfo.pNumber,
                        equipment_sn: this.hardwareInfo.eSerial,
                        type_of_request: this.selectedType.value,
                        subRequest: selectedRequest,
                        remarks: this.remarks,
                        portal_sys: portal_system,
                        web_access: web_access,
                        status: 1
                    }).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'TA Created!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            this.$router.push({ path: '/rictu/ict_ta/index' }).then(() => {
                                window.location.reload(); // Forces the page to reload
                            });
                        });
                    }).catch((error) => {
                        console.error('Error creating ICT request:', error);
                        toast.error("Failed to create ICT request. Please try again.", {
                            autoClose: 2500,
                        });
                    }).finally(() => {
                        this.isSaving = false; // Reset the flag whether success or error
                    });
                })
        },
        fetchEndUserInfo() {
            const userId = localStorage.getItem('userId');
            axios.get(`../../../api/fetchUser/${userId}`)
                .then((response) => {
                    this.userData = response.data
                }).catch(error => {
                    return null;
                });
        },
        generateICTControlNo: async function () {
            try {
                const response = await axios.get('../../../api/generateICTControlNo');
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Adding 1 because months are zero-indexed
                const ict_no_format = `${year}`;
                const ict_no = response.data[0].ict_no_count;
                const formattedSequence = ict_no.toString().padStart(4, '0');

                // set the draft pr no of the user
                this.ict_no = `R4A-${ict_no_format}-${month}-${formattedSequence}`;

                // localStorage.setItem('prId', response.data.userId);

                //this.fetchCartDetails();
                // this.fetchPurchaseRequestDetails();
            } catch (error) {
                console.error('Error fetching data', error);
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