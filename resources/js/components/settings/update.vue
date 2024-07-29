<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <StatBox />
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'circle-info']"></font-awesome-icon> Update User Info: {{ data.name }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-outline-primary col-lg-12 active">Account Details</button>
                                    <button class="btn btn-outline-primary col-lg-12 mt-2">Profile Details</button>
                                    <button class="btn btn-outline-primary col-lg-12 mt-2">Information</button>
                                    <button class="btn btn-outline-primary col-lg-12 mt-2">Office/Position</button>

                                    <div class="d-flex align-items-center pb-3 pt-3 border-top" style="margin-top:2em;">
                                    <button class="btn btn-outline-danger col-lg-12 mt-2">Block</button>
                                    </div>
                                    <button class="btn btn-outline-primary col-lg-12 mt-2" @click="viewUserMan">Back</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-6 col-sm-6 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;User
                                            Details
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <TextInput label="Employee ID No." iconValue="circle-info"
                                                v-model="data.employee_no" :value="data.employee_no" :readonly="false">
                                            </TextInput>
                                            <div class="form-group">
                                                <label for="Office">Office</label>
                                                <select class="form-control" v-model="data.pmo_id">
                                                    <option v-for="option in office" :key="option.value"
                                                        :value="option.value">
                                                        {{ option.label }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Position">Position</label>
                                                <select class="form-control" v-model="data.position_id">
                                                    <option v-for="option in position" :key="option.value"
                                                        :value="option.value">
                                                        {{ option.label }}
                                                    </option>
                                                </select>
                                            </div>

                                            <TextInput label="Province" iconValue="circle-info" 
                                                value="Province" :readonly="true" />
                                            <TextInput label="City/Municipality" iconValue="circle-info"
                                                 value="City/Municipality" :readonly="true" />
                                            <TextInput label="Barangay" iconValue="circle-info" 
                                                value="Barangay" :readonly="true" />
                                                <div class="form-group mt-2">
                                                    <label for="Employment Status">Employment Status</label>
                                                    <select class="form-control" v-model="data.employment_status">
                                                        <option v-for="option in emp_status" :key="option.value"
                                                            :value="option.value">
                                                            {{ option.label }}
                                                        </option>
                                                    </select>
                                                </div>

                                        </div>
                                        <div class="col-lg-6">
                                            <TextInput label="First Name" iconValue="circle-info"
                                                v-model="data.first_name" :value="data.first_name" :readonly="false" />
                                            <TextInput label="Middle Name" iconValue="circle-info"
                                                v-model="data.middle_name" :value="data.middle_name"
                                                :readonly="false" />
                                            <TextInput label="Last Name" iconValue="circle-info"
                                                v-model="data.last_name" :value="data.last_name" :readonly="false" />
                                            <TextInput label="Extension Name" iconValue="circle-info" v-model="data.ext_name"
                                                :value="data.ext_name" :readonly="false" />
                                            <TextInput label="Birth Date" type="date" iconValue="circle-info" style="height: 40px;"
                                                v-model="data.birthdate" :value="data.birthdate" :readonly="false" /><br>
                        
                                                <div class="form-group mt-2">
                                                    <label for="Gender">Gender</label>
                                                    <select class="form-control" v-model="data.gender">
                                                        <option v-for="option in gender_opts" :key="option.value"
                                                            :value="option.value">
                                                            {{ option.label }}
                                                        </option>
                                                    </select>
                                                </div>
                                            <TextInput label="Mobilephone" iconValue="circle-info"
                                                v-model="data.contact_details" :value="data.contact_details"
                                                :readonly="false" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Account
                                            Details
                                        </h5>
                                    </div>
                                    <div class="col-lg-12">
                                        <TextInput label="Email" iconValue="circle-info" v-model="data.email"
                                            :value="data.email" :readonly="false" />
                                        <TextInput label="Username" iconValue="circle-info" v-model="data.username"
                                            :value="data.username" :readonly="false" />
                                        <TextInput label="Password" iconValue="circle-info" type="password" v-model="data.password" value=""
                                            :readonly="false" style="height:40px;" /><br>
                                        <button class="btn btn-outline-primary" @click="updateUserDetails();" >Update</button>
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
import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import SelectInput from "../micro/SelectInput.vue";





import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faCircleCheck, faCircleInfo, faDownload, faEye, faLayerGroup, faList, faPesoSign, faSearch, faUndo } from '@fortawesome/free-solid-svg-icons';

import { toast } from "vue3-toastify";

library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign, faDownload, faSearch, faUndo);
export default {
    name: 'Settings',
    data() {
        return {
            user_id: null,
            data: {
                id:this.user_id,
                employee_no: '',
                pmo_id: '',
                position_id: '',
                province: '',
                city: '',
                barangay: '',
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
            position:[],
            post:{
                POSITION_C: '',
            },
            office: [
                { value: '15', label: 'ORD' },
                { value: '1', label: 'ORD-Legal' },
                { value: '2', label: 'ORD-Planning' },
                { value: '3', label: 'LGMED-MBRTG' },
                { value: '4', label: 'LGCDD-PDMU' },
                { value: '5', label: 'FAD' },
                { value: '6', label: 'ORD-RICTU' },
                { value: '7', label: 'LGCDD' },
                { value: '8', label: 'LGMED' },
                { value: '10', label: 'CAVITE'},
                { value: '11', label: 'LAGUNA'},
                { value: '9', label: 'BATANGAS'},
                { value: '13', label: 'RIZAL'},
                { value: '12', label: 'QUEZON'},
                { value: '14', label: 'LUCENA CITY'},
            ],
            gender_opts:[
                {value: 'M', label: 'Male'},
                {value: 'F', label: 'Female'},
            ],
            emp_status:[
                {value:'1',label: 'Permanent'},
                {value:'2',label: 'Contract of Service'},
                {value:'3',label: 'Job Order'},
                {value:'4',label: 'Consultant'}
            ]
        }
    },
    created() {
        this.user_id = this.$route.params.id;
    },
    mounted() {
        this.getUserDetails();
        this.getPosition();
    },
    methods: {
        viewUserMan(){
            this.$router.push({ path: `/settings/user-management` });
        },
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
        },
        getUserDetails() {
            axios.get(`../../api/getUserDetails/${this.user_id}`)
                .then((response) => {
                    this.data = response.data
                }).catch(error => {
                    return null;
                });
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
    },
    updateUserDetails() {
            axios.post(`../../api/updateUserDetails`, this.data)
                .then((response) => {
                    toast.success('User details updated successfully!', {
                    autoClose: 100
                });
                }).catch(error => {
                    toast.error('Error updating user details', {
                    autoClose: 100
                });
                });
        }
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        SelectInput
    }
}
</script>