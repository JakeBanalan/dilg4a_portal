<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'circle-info']"></font-awesome-icon>
                                            CREATE USER ACCOUNT
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-outline-primary col-lg-12 active">Account Details</button>
                                    <!-- <button class="btn btn-outline-primary col-lg-12 mt-2">Profile Details</button>
                                    <button class="btn btn-outline-primary col-lg-12 mt-2">Information</button>
                                    <button class="btn btn-outline-primary col-lg-12 mt-2">Office/Position</button>

                                    <div class="d-flex align-items-center pb-3 pt-3 border-top" style="margin-top:2em;">
                                    <button class="btn btn-outline-danger col-lg-12 mt-2">Block</button>
                                    </div> -->
                                    <button class="btn btn-outline-primary col-lg-12 mt-2"
                                        @click="viewUserMan">Back</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-6 col-sm-6 mt-4">
                            <form class="UserForm" @submit.prevent="PostUser">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">
                                                <font-awesome-icon
                                                    :icon="['fas', 'list']"></font-awesome-icon>&nbsp;User
                                                Details
                                            </h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label for="Employee ID No.">Employee ID No.</label>
                                                    <input type="text" class="form-control" id="coverage"
                                                        v-model="data.employee_no" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="Office">Office</label>
                                                    <Multiselect @update:modelValue="OfficeSelect" :options="office"
                                                        track-by="value" v-model="data.office" :multiple="false"
                                                        label="label" :searchable="false" placeholder="Office">
                                                    </Multiselect>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Province">Province</label>
                                                    <Multiselect @update:modelValue="provinceSelect" :options="province"
                                                        track-by="value" v-model="data.province" :multiple="false"
                                                        label="label" :searchable="false" placeholder="Province"
                                                        :disabled="isOfficeDisabled">
                                                    </Multiselect>
                                                </div>

                                                <div class="form-group">
                                                    <label for="City/Municipality">City/Municipality</label>
                                                    <Multiselect :options="citymun" track-by="value"
                                                        v-model="data.citymun" :multiple="false" label="label"
                                                        :searchable="false" placeholder="City/Municipality"
                                                        :disabled="isProvinceDisabled">
                                                    </Multiselect>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Employment Status">Employment Status</label>
                                                    <Multiselect :options="emp_status" track-by="value"
                                                        v-model="data.employment_status" :multiple="false" label="label"
                                                        :searchable="false" placeholder="Employment Status">
                                                    </Multiselect>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Position">Position</label>
                                                    <Multiselect :options="position" track-by="value"
                                                        v-model="data.position_id" :multiple="false" label="label"
                                                        :searchable="false" placeholder="Position">
                                                    </Multiselect>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Position">Division</label>
                                                    <Multiselect :options="division" track-by="value"
                                                        v-model="data.division" :multiple="false" label="label"
                                                        :searchable="false" placeholder="Division">
                                                    </Multiselect>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Position">Section</label>
                                                    <Multiselect :options="section" track-by="value"
                                                        v-model="data.section" :multiple="false" label="label"
                                                        :searchable="false" placeholder="Section">
                                                    </Multiselect>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label for="First Name">First Name</label>
                                                    <input type="text" class="form-control" id="FirstName"
                                                        v-model="data.first_name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="Middle Name">Middle Name</label>
                                                    <input type="text" class="form-control" id="MiddleName"
                                                        v-model="data.middle_name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="Last Name">Last Name</label>
                                                    <input type="text" class="form-control" id="LastName"
                                                        v-model="data.last_name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="Extension Name">Extension Name</label>
                                                    <input type="text" class="form-control" id="ExtensionName"
                                                        v-model="data.ext_name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="Birth Date">Birth Date</label>
                                                    <input type="date" class="form-control" id="BirthDate"
                                                        v-model="data.birthdate" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="Gender">Gender</label>
                                                    <Multiselect :options="gender_opts" track-by="value"
                                                        v-model="data.gender" :multiple="false" label="label"
                                                        :searchable="false" placeholder="Gender">
                                                    </Multiselect>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Mobilephone">Mobilephone</label>
                                                    <input type="text" class="form-control" id="Mobilephone"
                                                        v-model="data.contact_details" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="Email">Email Address</label>
                                                    <input type="text" class="form-control" id="Email"
                                                        v-model="data.email" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="card-title d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">
                                                <font-awesome-icon
                                                    :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Account
                                                Details
                                            </h5>
                                        </div>
                                        <div class="col-lg-12">
                                            <TextInput label="Username" iconValue="user" v-model="data.username"
                                                :value="data.username" :readonly="false" />
                                            <TextInput label="Password" iconValue="key" type="password"
                                                v-model="data.password" value="" :readonly="false"
                                                style="height:40px;" />
                                            <br>
                                            <button type="submit" class="btn btn-outline-primary">Save</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import Multiselect from 'vue-multiselect';
import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import SelectInput from "../micro/SelectInput.vue";





import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faCircleCheck, faCircleInfo, faDownload, faEye, faLayerGroup, faList, faPesoSign, faSearch, faUndo, faAt, faUser, faKey } from '@fortawesome/free-solid-svg-icons';

import { toast } from "vue3-toastify";

library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign, faDownload, faSearch, faUndo, faAt, faUser, faKey);
export default {
    name: 'Settings',
    data() {
        return {
            isOfficeDisabled: true,
            isProvinceDisabled: true,
            user_id: null,
            data: {
                employee_no: '',
                // pmo_id: '',
                position_id: '',
                province: '',
                citymun: '',
                office: '',
                section: '',
                division: '',
                employment_status: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                ext_name: '',
                birthdate: '',
                gender: '',
                contact_details: '',
                email: '',
                username: '',
                password: '',
            },
            position: [],
            province: [],
            citymun: [],
            office: [],
            division: [
                { value: 1, label: 'Local Government Monitoring and Evaluation Division' },
                { value: 2, label: 'Local Government Capacity Development Division' },
                { value: 3, label: 'Finance and Administrative Division' },
                { value: 4, label: 'Office of the Regional Director' },
            ],
            section: [
                { value: 1, label: 'Manila Bay Rehabilitation Task Group' },
                { value: 2, label: 'Project Development Management Unit' },
                { value: 3, label: 'Accounting Section' },
                { value: 4, label: 'Budget Section' },
                { value: 5, label: 'Cash Section' },
                { value: 6, label: 'Human Resources Section' },
                { value: 7, label: 'General Supplies Section' },
                { value: 8, label: 'Records Section' },
                { value: 9, label: 'Planning Unit' },
                { value: 10, label: 'Regional Information and Communication Technology Unit' },
                { value: 11, label: 'Local Government Monitoring and Evaluation Section' },
                { value: 12, label: 'Local Government Capacity Development Section' },
                { value: 13, label: 'Finance and Administrative Section' },
                { value: 14, label: 'Office of the Provincial Director' },
            ],
            gender_opts: [
                { value: 'M', label: 'Male' },
                { value: 'F', label: 'Female' },
            ],
            emp_status: [
                { value: '1', label: 'Permanent' },
                { value: '2', label: 'Contract of Service' },
                { value: '3', label: 'Job Order' },
                { value: '4', label: 'Consultant' }
            ]
        }
    },
    created() {
        this.user_id = this.$route.params.id;
    },
    mounted() {
        this.getPosition();
        this.getProvinces();
        this.getOffice();
    },
    computed: {

    },
    methods: {
        PostUser() {
            // console.log(this.data);
            let data = this.data;
            let province = data.province.value;
            let citymun = data.citymun.value;
            let office = data.office.value;
            let section = data.section.value;
            let division = data.division.value;
            let employment_status = data.employment_status.value;
            let gender = data.gender.value;
            let position_id = data.position_id.value;
            axios.post(`../../api/PostUser`,
                {
                    employee_no: data.employee_no,
                    position_id: position_id,
                    province: province,
                    citymun: citymun,
                    office: office,
                    section: section,
                    division: division,
                    employment_status: employment_status,
                    first_name: data.first_name,
                    middle_name: data.middle_name,
                    last_name: data.last_name,
                    ext_name: data.ext_name,
                    birthdate: data.birthdate,
                    gender: gender,
                    contact_details: data.contact_details,
                    email: data.email,
                    username: data.username,
                    password: data.password,
                }
            )
                .then((response) => {
                    toast.success('User Added successfully!', {
                        autoClose: 100
                    });
                }).catch(error => {
                    toast.error('Error Adding user', {
                        autoClose: 100
                    });
                });
        },
        OfficeSelect(arg) {
            if (arg.value === 1) {
                this.isOfficeDisabled = true;
                this.isProvinceDisabled = true;
            } else if (arg.value === 2) {
                this.isOfficeDisabled = false;
                this.isProvinceDisabled = true;
            } else {
                this.isOfficeDisabled = false;
                this.isProvinceDisabled = false;
            }
        },
        provinceSelect(arg) {
            let provID = arg.value;
            axios.get(`../../api/getCityMun/${provID}`)
                .then((response) => {
                    console.log(response.data)
                    this.citymun = response.data.map(item => ({
                        value: item.id,
                        label: item.citymun
                    }));
                }).catch(error => {
                    return null;
                })
        },
        viewUserMan() {
            this.$router.push({ path: `/settings/user-management` });
        },
        getOffice() {
            axios.get(`../../api/getOffice`)
                .then((response) => {
                    console.log(response.data)
                    this.office = response.data.map(item => ({
                        value: item.id,
                        label: item.office
                    }));
                }).catch(error => {
                    return null;
                })
        },
        getProvinces() {
            axios.get(`../../api/getProvinces`)
                .then((response) => {
                    this.province = response.data.map(item => ({
                        value: item.id,
                        label: item.province
                    }));
                }).catch(error => {
                    return null;
                })
        },
        getPosition() {
            axios.get(`../../api/getPosition`)
                .then((response) => {
                    this.position = response.data.map(item => ({
                        value: item.POSITION_C,
                        label: item.POSITION_TITLE
                    }));
                }).catch(error => {
                    console.error('Error fetching positions:', error);
                });
        }
    },
    components: {
        Multiselect,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        SelectInput
    }
}
</script>
<style>
.multiselect--disabled {
    background-color: #f5f5f5;
    /* Light gray background */
    border-color: #ccc;
    /* Lighter border */
    color: #999;
    /* Disabled text color */
    cursor: not-allowed;
    /* Change cursor to indicate disabled state */
}

.multiselect--disabled .multiselect__single,
.multiselect--disabled .multiselect__placeholder {
    color: #999;
    /* Disabled text color */
}

.multiselect--disabled .multiselect__tag {
    background-color: #e0e0e0;
    /* Light gray tag background */
    color: #999;
    /* Disabled tag text color */
}

.multiselect--disabled .multiselect__tag-icon {
    display: none;
    /* Hide remove icon for tags in disabled state */
}

.multiselect--disabled .multiselect__tags {
    border: none;
    /* Remove border from tags container */
    background-color: #F4F4F4;
    border-radius: 5px;
}

.multiselect--disabled .multiselect__select {
    border: none;
    /* Remove border from tags container */
    opacity: 0;
}

.multiselect--disabled .multiselect__input {
    display: none;
    /* Hide input field when disabled */
}
</style>