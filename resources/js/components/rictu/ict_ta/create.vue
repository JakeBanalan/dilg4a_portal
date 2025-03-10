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
                                        <span class="box-title" style="font-size: 13pt;">Document Code</span>
                                    </div>
                                    <div class="box-header with-border"
                                        style="color:black;padding:2px;text-align:center;">
                                        <h6 class="box-title">FM-QP-DILG-ISTMS-RO-17-01</h6>
                                    </div>
                                    <div class="box-header with-border"
                                        style="display: flex; align-items: center; height: 30px; background-color: #000;padding:2px;color:#fff;">
                                        <div style="margin: 0 10px;">Rev No</div>
                                        <div style="width: 2px; height: 30px; background-color: black; margin: 0 30px;">
                                        </div>
                                        <div style="margin: 0 10px;">Eff. Date</div>
                                        <div
                                            style="width: 2px;  height: 30px; background-color: black; margin: 0 30px;">
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
                                    <div style="text-align:center; color:red; font-weight:bold; font-size:24px;">
                                        {{ ict_no }}
                                    </div>
                                </div>
                            </div>


                        </div>
                        <br>
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
                                                <TextInput label="Date:" iconValue="calendar" type="date"
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
                                                <TextAreaInput label="ADDITIONAL INFORMATION/REMARKS (if any): "
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
                                            <div class="col-lg-6 ">
                                                <label style="font-weight: bold;"> Acceptance of Service
                                                    Rendered</label> &nbsp;
                                                <a href="#" class="text-decoration-none"
                                                    :class="{ 'text-primary': !isEditMode, 'text-danger': isEditMode }"
                                                    @click.prevent="toggleEditMode" v-if="this.role == 'admin'">
                                                    {{ isEditMode ? 'Cancel' : 'Edit' }}
                                                </a>
                                                <multiselect v-model="acceptance" :options="acceptanceOptions"
                                                    label="name" track-by="id" :readonly="!isEditMode" :multiple="false"
                                                    :close-on-select="true" :clear-on-select="false"
                                                    :preserve-search="true" placeholder="Select Acceptance"
                                                    :disabled="!isEditMode" @input="updateAcceptance" />
                                            </div>

                                            <div class="col-lg-6">
                                                <label style="font-weight: bold;"> Assign ICT Personnel</label>
                                                <multiselect v-model="selected_ict_personnel"
                                                    :options="ictPersonnelOptions" label="ict_personnel"
                                                    track-by="emp_id" placeholder="Select ICT Officer" />
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
            role: null,
            isSaving: false,
            dilg_logo: logo,
            folderId: '1AmuHQn3YkNEEVdR3RbpijsaX9NKT1oub', // Replace 'YOUR_FOLDER_ID' with the ID of your target folder
            accessToken: null,
            remarks: null,
            acceptance: null,
            allUsers: [],
            isEditMode: false,
            selected_ict_personnel: null, // Ensure it's defined
            ict_personnel: [],
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
        },
        ictPersonnelOptions() {
            return this.ict_personnel ?? []; // ✅ Ensures it's always an array
        },
        acceptanceOptions() {
            return this.allUsers.map(user => ({ id: user.id, name: user.name }));
        }

    },
    mounted() {
        this.generateICTControlNo();
        this.fetchEndUserInfo();
        this.getICTpersonnel();
        this.fetchAllUsers();
    },
    created() {
        this.role = localStorage.getItem('user_role');
    },
    methods: {
        updateAcceptance(value) {
            this.acceptance = value;
        },
        fetchAllUsers() {
            axios.get('/api/fetchAllUsers')
                .then(response => {
                    this.allUsers = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        toggleEditMode() {
            this.isEditMode = !this.isEditMode;
        },
        async getICTpersonnel() {
            try {
                const response = await axios.get('/api/get-ict-personnel');

                // ✅ Ensure the response is valid
                if (!response.data || !Array.isArray(response.data)) {
                    throw new Error('Invalid response from the server');
                }

                // ✅ Always set `ict_personnel` as an array
                this.ict_personnel = response.data;
            } catch (error) {
                console.error('Error getting ICT personnel:', error.message);

                // ✅ Instead of setting a string, set an empty array to prevent errors in VueMultiselect
                this.ict_personnel = [];
            }
        },
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
            if (this.isSaving) return;
            this.isSaving = true;

            await this.fetchEndUserInfo();

            const selectedRequest = (this.selectedType.value == 9) ? this.selectedSubRequest : this.selectedSubRequest.value;
            const portal_system = (this.selectedType.value == 4) ? this.portal_system : null;
            const web_access = (this.selectedType.value == 7) ? this.website_access : null;

            axios.post('/api/post_create_ict_request', {
                control_no: this.ict_no,
                requested_by: this.acceptance.id,
                requested_date: `${this.requested_date} ${this.formatTime(this.requested_time)}`,
                pmo: this.userData.id,
                email: this.userData.email,
                equipment_type: this.hardwareInfo.etype,
                brand: this.hardwareInfo.brand,
                property_no: this.hardwareInfo.pNumber,
                equipment_sn: this.hardwareInfo.eSerial,
                type_of_request: this.selectedType.value,
                subRequest: selectedRequest,
                remarks: this.remarks,
                portal_sys: portal_system,
                web_access: web_access,
                status: this.selected_ict_personnel ? 2 : 1,
                assign_ict_officer: this.selected_ict_personnel ? this.selected_ict_personnel.emp_id : null
            })
                .then(() => {

                    Swal.fire({
                        icon: 'success',
                        title: 'TA Created!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        this.$router.replace({ path: '/rictu/ict_ta/index' })
                    });
                })
                .catch(error => {
                    console.error('Error creating ICT request:', error);
                    toast.error("Failed to create ICT request. Please try again.", {
                        autoClose: 2500,
                    });
                })
                .finally(() => {
                    this.isSaving = false;
                });
        },
        fetchEndUserInfo() {
            const userId = localStorage.getItem('userId');
            axios.get(`../../../api/fetchUser/${userId}`)
                .then((response) => {
                    this.userData = response.data;
                    if (!this.acceptance) {
                        this.acceptance = { id: this.userData.user_id, name: this.userData.name };
                    }
                }).catch(error => {
                    return null;
                });
        },
        async generateICTControlNo() {
            try {
                const response = await axios.get('../../../api/generateICTControlNo');
                if (!response.data || response.data.length === 0 || !response.data[0].ict_no_count) {
                    throw new Error('Invalid response from the server');
                }

                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                const ict_no_count = response.data[0].ict_no_count;

                if (isNaN(ict_no_count) || ict_no_count < 0) {
                    throw new Error('Invalid ICT number count');
                }

                const formattedSequence = String(ict_no_count).padStart(4, '0');
                this.ict_no = `R4A-${year}-${month}-${formattedSequence}`;
            } catch (error) {
                console.error('Error generating ICT Control Number:', error.message);
                this.ict_no = 'Error generating ICT Control Number';
            }
        }
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
