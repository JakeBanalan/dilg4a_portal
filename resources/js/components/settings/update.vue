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
                                            Update User Info: {{ data.name }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-outline-primary col-lg-12 active">Account Details</button>

                                    <div class="d-flex align-items-center pb-3 pt-3 border-top" style="margin-top:2em;">
                                        <button class="btn btn-outline-danger col-lg-12 mt-2">Block</button>
                                    </div>
                                    <button class="btn btn-outline-primary col-lg-12 mt-2"
                                        @click="viewUserMan">Back</button>
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
                                            <div class="form-group">
                                                <label for="Employee ID No.">Employee ID No.</label>
                                                <input type="text" class="form-control" id="coverage"
                                                    v-model="data.employee_no" />
                                            </div>
                                            <div class="form-group">
                                                <label for="Office">Office</label>
                                                <Multiselect @update:modelValue="OfficeSelect" :options="OptsOffice"
                                                    v-model="data.office" :multiple="false" track-by='id' label="office"
                                                    :searchable="false" placeholder="Office">
                                                </Multiselect>
                                            </div>
                                            <div class="form-group">
                                                <label for="Province">Province</label>
                                                <Multiselect @update:modelValue="provinceSelect" :options="Optsprovince"
                                                    track-by="value" v-model="data.province" :multiple="false"
                                                    label="label" :searchable="false" placeholder="Province"
                                                    :disabled="isOfficeDisabled">
                                                </Multiselect>
                                            </div>

                                            <div class="form-group">
                                                <label for="City/Municipality">City/Municipality</label>
                                                <Multiselect :options="Optscitymun" track-by="value"
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
                                                <Multiselect :options="Optsposition" track-by="value"
                                                    v-model="data.position_id" :multiple="false" label="label"
                                                    :searchable="false" placeholder="Position">
                                                </Multiselect>
                                            </div>

                                            <div class="form-group">
                                                <label for="Position">Division</label>
                                                <Multiselect :options="Optsdivision" track-by="value"
                                                    v-model="data.division" :multiple="false" label="label"
                                                    :searchable="false" placeholder="Division">
                                                </Multiselect>
                                            </div>

                                            <div class="form-group">
                                                <label for="Position">Section</label>
                                                <Multiselect :options="Optssection" track-by="value"
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
                                                    :searchable="false" placeholder="Position">
                                                </Multiselect>
                                            </div>

                                            <div class="form-group">
                                                <label for="Mobilephone">Mobilephone</label>
                                                <input type="text" class="form-control" id="Mobilephone"
                                                    v-model="data.contact_details" />
                                            </div>

                                            <div class="form-group">
                                                <label for="EmailAddress">Email Address</label>
                                                <input type="text" class="form-control" id="EmailAddress"
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
                                            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Account
                                            Details
                                        </h5>
                                    </div>
                                    <div class="col-lg-12">
                                        <TextInput label="Username" iconValue="user" v-model="data.username"
                                            :value="data.username" :readonly="false" />
                                        <TextInput label="Password" iconValue="key" type="password"
                                            v-model="data.password" value="" :readonly="false" style="height:40px;" />
                                        <br>
                                        <button class="btn btn-outline-primary"
                                            @click="updateUserDetails();">Update</button>
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
import Multiselect from 'vue-multiselect';






import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faCircleCheck, faCircleInfo, faDownload, faEye, faLayerGroup, faList, faPesoSign, faSearch, faUndo } from '@fortawesome/free-solid-svg-icons';

import { toast } from "vue3-toastify";

library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign, faDownload, faSearch, faUndo);
export default {
    name: 'Settings',
    data() {
        return {
            user_id: null,
            isOfficeDisabled: true,
            isProvinceDisabled: true,
            data: {
                id: this.user_id,
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
                office: '',
                password: ''
            },
            Optsposition: [],
            Optscitymun: [],
            Optsdivision: [
                { value: 1, label: 'Local Government Monitoring and Evaluation Division' },
                { value: 2, label: 'Local Government Capacity Development Division' },
                { value: 3, label: 'Finance and Administrative Division' },
                { value: 4, label: 'Office of the Regional Director' },
            ],
            Optssection: [
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
            Optsprovince: [
                { value: 1, label: 'Cavite' },
                { value: 2, label: 'Laguna' },
                { value: 3, label: 'Batangas' },
                { value: 4, label: 'Rizal' },
                { value: 5, label: 'Quezon' },
                { value: 6, label: 'Lucena City (HUC)' },
            ],
            OptsOffice: [
                { value: 1, office: "Regional Office" },
                { value: 2, office: "Provincial Office" },
                { value: 3, office: "Municipal Office" },
                { value: 4, office: "City Office" }
            ],
            post: {
                POSITION_C: '',
            },
            gender_opts: [
                { value: 'M', label: 'Male' },
                { value: 'F', label: 'Female' },
            ],
            emp_status: [
                { value: 1, label: 'Permanent' },
                { value: 2, label: 'Contract of Service' },
                { value: 3, label: 'Job Order' },
                { value: 4, label: 'Consultant' }
            ]
        }
    },
    created() {
        this.user_id = this.$route.params.id;
    },
    mounted() {
        this.getUserDetails();
        this.getPosition();
        this.getOffice();
        // this.ValidatedOP();
        this.getCityMun();
    },
    methods: {
        getCityMun() {
            //initialize city/municipality kasi tamad ako
            axios.get(`../../api/getAllCityMun`)
                .then((response) => {
                    this.Optscitymun = response.data.map(item => ({
                        value: item.id,
                        label: item.citymun
                    }));
                }).catch(error => {
                    return error;
                })
        },
        // ValidatedOP() {
        //     const OfficeVal = this.data.office;
        //     console.log(OfficeVal)
        //     if (OfficeVal === 1) {
        //         this.isOfficeDisabled = true;
        //         this.isProvinceDisabled = true;
        //     } else if (OfficeVal === 2) {
        //         this.isOfficeDisabled = false;
        //         this.isProvinceDisabled = true;
        //     } else {
        //         this.isOfficeDisabled = false;
        //         this.isProvinceDisabled = false;
        //     }
        // },
        OfficeSelect(arg) {
            console.log(arg)
            if (arg.value === 1) {
                this.isOfficeDisabled = true;
                this.isProvinceDisabled = true;
                this.data.province = '';
                this.data.citymun = '';
            } else if (arg.value === 2) {
                this.isOfficeDisabled = false;
                this.isProvinceDisabled = true;
                this.data.citymun = '';
            } else {
                this.isOfficeDisabled = false;
                this.isProvinceDisabled = false;
            }
        },
        provinceSelect(arg) {
            console.log(arg);
            let provID = arg.value;
            axios.get(`../../api/getCityMun/${provID}`)
                .then((response) => {
                    // console.log(response.data)
                    this.Optscitymun = response.data.map(item => ({
                        value: item.id,
                        label: item.citymun
                    }));
                }).catch(error => {
                    return null;
                })
        },
        getProvinces() {
            axios.get(`../../api/getProvinces`)
                .then((response) => {
                    this.Optsprovince = response.data.map(item => ({
                        value: item.id,
                        label: item.province
                    }));
                    console.log(this.Optsprovince)
                }).catch(error => {
                    return null;
                })
        },
        getOffice() {
            axios.get(`../../api/getOffice`)
                .then((response) => {
                    this.OptsOffice = response.data
                    // this.OptsOffice = response.data.map(item => ({
                    //     value: item.id,
                    //     label: item.office
                    // }));
                    // console.log(this.OptsOffice)

                }).catch(error => {
                    return null;
                })
        },
        viewUserMan() {
            this.$router.push({ path: `/settings/user-management` });
        },
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
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
            console.log(this.data)
            let data = this.data;
            let province = data.province.value;
            let citymun = data.citymun.value;
            let office = data.office.value;
            let section = data.section.value;
            let division = data.division.value;
            let employment_status = data.employment_status.value;
            axios.post(`../../api/updateUserDetails`,
                {
                    id: data.id,
                    employee_no: data.employee_no,
                    position_id: data.position_id.value,
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
                    gender: data.gender.value,
                    contact_details: data.contact_details,
                    email: data.email,
                    username: data.username,
                    password: data.password,
                }
            )
                .then((response) => {
                    toast.success('User details updated successfully!', {
                        autoClose: 100
                    });
                }).catch(error => {
                    toast.error('Error updating user details', {
                        autoClose: 100
                    });
                });
        },
        getUserDetails() {
            axios.get(`../../api/getUserDetails/${this.user_id}`)
                .then((response) => {
                    this.data = response.data;
                    const userOfficeId = response.data.office;
                    const provID = response.data.province;
                    const CityMunID = response.data.citymun;
                    const EmploymentID = response.data.employment_status;
                    const PositionID = response.data.position_id;
                    const DivisionID = response.data.division;
                    const SectionID = response.data.section;
                    const GenderID = response.data.gender;

                    // Set office and province
                    // this.data.office = this.OptsOffice.find(office => office.value === userOfficeId);
                    // this.data.province = this.Optsprovince.find(province => province.value === provID);
                    // this.data.employment_status = this.emp_status.find(emp_status => emp_status.value === EmploymentID);
                    // this.data.division = this.Optsdivision.find(Optsdivision => Optsdivision.value === DivisionID);
                    // this.data.section = this.Optssection.find(Optssection => Optssection.value === SectionID);
                    // this.data.gender = this.gender_opts.find(gender_opts => gender_opts.value === GenderID);


                    // Set office and province with null checks
                    this.data.office = userOfficeId ? this.OptsOffice.find(office => office.value === userOfficeId) : '';
                    this.data.province = provID ? this.Optsprovince.find(province => province.value === provID) : '';
                    this.data.employment_status = EmploymentID ? this.emp_status.find(emp_status => emp_status.value === EmploymentID) : '';
                    this.data.division = DivisionID ? this.Optsdivision.find(Optsdivision => Optsdivision.value === DivisionID) : '';
                    this.data.section = SectionID ? this.Optssection.find(Optssection => Optssection.value === SectionID) : '';
                    this.data.gender = GenderID ? this.gender_opts.find(gender_opts => gender_opts.value === GenderID) : '';


                    // Fetch city/municipality options based on the selected province
                    axios.get(`../../api/getCityMun/${provID}`)
                        .then((citymunResponse) => {
                            this.Optscitymun = citymunResponse.data.map(item => ({
                                value: item.id,
                                label: item.citymun
                            }));
                            this.data.citymun = CityMunID ? this.Optscitymun.find(citymun => citymun.value === CityMunID): '';

                        })

                        .catch(error => {
                            console.error('Error fetching city/municipality:', error);
                        });

                    axios.get(`../../api/getPosition`)
                        .then((response) => {
                            this.Optsposition = response.data.map(item => ({
                                value: item.POSITION_C,
                                label: item.POSITION_TITLE
                            }));

                            this.data.position_id = this.Optsposition.find(position => position.value === PositionID);

                        }).catch(error => {
                            console.error('Error fetching positions:', error);
                        });

                    console.log(this.data)

                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
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