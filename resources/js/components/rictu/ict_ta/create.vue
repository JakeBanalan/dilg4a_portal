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
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h4><font-awesome-icon :icon="['fas', 'circle-info']"
                                                    class="mr-2"></font-awesome-icon>TECHNICAL ASSISTANCE FORM</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <TextInput label="Control Number" iconValue="gear" v-model="ict_no" :value="ict_no"
                                                    :readonly="true" />
                                            </div>


                                            <div class="col-lg-6">
                                                <TextInput label="Requested By" iconValue="user" v-model="userData.name"
                                                    :value="userData.name" :readonly="true" />
                                            </div>

                                        </div>
                                        <div class="row">

                                            
                                            <div class="col-lg-6">
                                                <TextInput label="Office" iconValue="building" :value="userData.pmo_title" :readonly="true" />
                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="Contact Number/E-mail" iconValue="envelope-open-text" :value="userData.email"
                                                    :readonly="true" />
                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="Requested Date" iconValue="calendar" type="date" style="height: 40px !important;"
                                                    v-model="userData.requested_date" :value="userData.requested_date" />
                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="Agreed Timeline if any:" iconValue="check-circle" :readonly="false" />
                                            </div>
                                        </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h4><font-awesome-icon :icon="['fas', 'circle-info']"
                                                    class="mr-2"></font-awesome-icon>HARDWARE INFORMATION</h4>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <TextInput label="Equipment Type" iconValue="server" v-model="hardwareInfo.etype" />
                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="Brand/Model" iconValue="copyright" v-model="hardwareInfo.brand" />
                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="Property Number" iconValue="bars" v-model="hardwareInfo.pNumber" />
                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="Equipment Serial Number" iconValue="hashtag" v-model="hardwareInfo.eSerial" />
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
                                                    <label>NAME OF SUB REQUEST</label>
                                                    <multiselect v-model="selectedSubRequest"
                                                        :options="filteredSubRequests" label="label"
                                                        :multiple="false"></multiselect>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <TextAreaInput label="ADDITIONAL INFORMATION/REMARKS (if any): "
                                                    v-model="remarks" />

                                            </div>
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
                                                <TextInput label="Acceptance of Service Rendered" iconValue="user" v-model="acceptance"
                                                    :value="userData.name" :readonly="true" />


                                            </div>
                                            <div class="col-lg-6">
                                                <TextInput label="ICT Technical Personnel " iconValue="user" v-model="ict_personnel" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success mt-4" style="width: 100%;"
                                    @click="uploadFile">Save</button>
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

export default {
    name: 'Create ICT Technical Assistance',
    data() {
        return {
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
            hardwareInfo: {
                etype: null,
                brand: null,
                pNumber: null,
                eSerial: null,
            },
            userData: {
                name: null,
                pmo_title: null,
                email: null,
                requested_date: null
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
            if (!this.selectedType) {
                return [];
            }
            return this.sub_request.filter(item => item.type === this.selectedType.value);
        }
    },

    mounted() {
        this.generateICTControlNo();
        this.fetchEndUserInfo();

    },
    methods: {
        showToatSuccess(message) {
            toast.success(message, {
                autoClose: 1000,
            });
        },
        create_ict_ta() {
            const userId = localStorage.getItem('userId');
            this.$fetchUserData(userId, '../../../../api/fetchUser')
                .then(emp_data => {
                    axios.post('/api/post_create_ict_request', {
                        control_no:     this.ict_no,
                        requested_by:   userId,
                        requested_date: this.userData.requested_date,
                        pmo:             emp_data.id,
                        email:           emp_data.email,
                        equipment_type:  this.hardwareInfo.etype,
                        brand:           this.hardwareInfo.brand,
                        property_no:     this.hardwareInfo.pNumber,
                        equipment_sn:    this.hardwareInfo.eSerial,
                        type_of_request: this.selectedType.value,
                        subRequest:      this.selectedSubRequest.value,
                        remarks:         this.remarks,
                        status:          1

                    }).then(() => {
                        this.showToatSuccess('Successfully added!');
                        setTimeout(() => {
                            this.$router.push({ name: 'ICT Technical Assistance' });
                        }, 2000); // Adjust the delay as needed

                    }).catch((error) => {

                    })
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                });



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
                this.ict_no = `${ict_no_format}-${month}-${formattedSequence}`;

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