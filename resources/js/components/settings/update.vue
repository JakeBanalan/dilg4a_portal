<template>
    <div class="container-scroller">
        <Navbar />
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
                                            <font-awesome-icon :icon="['fas', 'circle-info']" />
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
                                            <font-awesome-icon :icon="['fas', 'list']" />
                                            &nbsp;User Details
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="EmployeeID">Employee ID No.</label>
                                                <input type="text" class="form-control" id="EmployeeID"
                                                    v-model="data.employee_no" />
                                                <span class="text-danger" v-if="errors.employee_no">{{
                                                    errors.employee_no }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="Office">Office</label>
                                                <Multiselect @update:modelValue="OfficeSelect" :options="OptsOffice"
                                                    v-model="data.office" :multiple="false" track-by="id" label="office"
                                                    :searchable="false" placeholder="Office" />
                                                <span class="text-danger" v-if="errors.office">{{ errors.office
                                                    }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="Province">Province</label>
                                                <Multiselect @update:modelValue="provinceSelect" :options="Optsprovince"
                                                    track-by="value" v-model="data.province" :multiple="false"
                                                    label="label" :searchable="false" placeholder="Province"
                                                    :disabled="isOfficeDisabled" />
                                                <span class="text-danger" v-if="errors.province">{{ errors.province
                                                    }}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="CityMunicipality">City/Municipality</label>
                                                <Multiselect :options="Optscitymun" track-by="value"
                                                    v-model="data.citymun" :multiple="false" label="label"
                                                    :searchable="false" placeholder="City/Municipality"
                                                    :disabled="isProvinceDisabled" />
                                                <span class="text-danger" v-if="errors.citymun">{{ errors.citymun
                                                    }}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="EmploymentStatus">Employment Status</label>
                                                <Multiselect :options="emp_status" track-by="value"
                                                    v-model="data.employment_status" :multiple="false" label="label"
                                                    :searchable="false" placeholder="Employment Status" />
                                                <span class="text-danger" v-if="errors.employment_status">{{
                                                    errors.employment_status }}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="Position">Position</label>
                                                <Multiselect :options="Optsposition" track-by="value"
                                                    v-model="data.position_id" :multiple="false" label="label"
                                                    :searchable="false" placeholder="Position" />
                                                <span class="text-danger" v-if="errors.position_id">{{
                                                    errors.position_id }}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="OfficeDivision">Office/Division</label>
                                                <Multiselect :options="pmo" track-by="value" v-model="data.pmo"
                                                    :multiple="false" label="label" :searchable="false"
                                                    placeholder="Division" />
                                                <span class="text-danger" v-if="errors.pmo">{{ errors.pmo }}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="FirstName">First Name</label>
                                                <input type="text" class="form-control" id="FirstName"
                                                    v-model="data.first_name" />
                                                <span class="text-danger" v-if="errors.first_name">{{ errors.first_name
                                                    }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="MiddleName">Middle Name</label>
                                                <input type="text" class="form-control" id="MiddleName"
                                                    v-model="data.middle_name" />
                                            </div>

                                            <div class="form-group">
                                                <label for="LastName">Last Name</label>
                                                <input type="text" class="form-control" id="LastName"
                                                    v-model="data.last_name" />
                                                <span class="text-danger" v-if="errors.last_name">{{ errors.last_name
                                                    }}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="ExtensionName">Extension Name</label>
                                                <input type="text" class="form-control" id="ExtensionName"
                                                    v-model="data.ext_name" />
                                            </div>

                                            <div class="form-group">
                                                <label for="BirthDate">Birth Date</label>
                                                <input type="date" class="form-control" id="BirthDate"
                                                    v-model="data.birthdate" />
                                                <span class="text-danger" v-if="errors.birthdate">{{ errors.birthdate
                                                    }}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="Gender">Gender</label>
                                                <Multiselect :options="gender_opts" track-by="value"
                                                    v-model="data.gender" :multiple="false" label="label"
                                                    :searchable="false" placeholder="Gender" />
                                                <span class="text-danger" v-if="errors.gender">{{ errors.gender
                                                    }}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="Mobilephone">Mobilephone</label>
                                                <input type="text" class="form-control" id="Mobilephone"
                                                    v-model="data.contact_details" />
                                                <span class="text-danger" v-if="errors.contact_details">{{
                                                    errors.contact_details }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'list']" />
                                            &nbsp;Account Details
                                        </h5>
                                    </div>
                                    <div class="col-lg-12">
                                        <TextInput label="Email" iconValue="user" v-model="data.email"
                                            :value="data.email" :readonly="false" />
                                        <span class="text-danger d-block mb-3" v-if="errors.email">{{ errors.email
                                            }}</span>

                                        <TextInput label="Username" iconValue="user" v-model="data.username"
                                            :value="data.username" :readonly="false" />
                                        <span class="text-danger d-block mb-3" v-if="errors.username">{{ errors.username
                                            }}</span>

                                        <TextInput label="Password" iconValue="key" type="password"
                                            v-model="data.password" value="" :readonly="false" style="height:40px;" />
                                        <br />
                                        <button class="btn btn-outline-primary" @click="submitForm">
                                            Update
                                        </button>
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
                pmo: '',
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
            errors: {},
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
            ],
            pmo: [
                { value: '1', label: 'ORD-Legal' },
                { value: '2', label: 'ORD-Planning' },
                { value: '3', label: 'LGMED-MBRTG' },
                { value: '4', label: 'LGCDD-PDMU' },
                { value: '5', label: 'FAD' },
                { value: '6', label: 'ORD-RICTU' },
                { value: '7', label: 'LGCDD' },
                { value: '8', label: 'LGMED' },
                { value: '9', label: 'BATANGAS' },
                { value: '10', label: 'CAVITE' },
                { value: '11', label: 'LAGUNA' },
                { value: '12', label: 'QUEZON' },
                { value: '13', label: 'RIZAL' },
                { value: '14', label: 'LUCENA CITY' },
                { value: '15', label: 'ORD' },
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
        OfficeSelect(arg) {
            console.log(arg)
            if (arg.id === 1) {
                this.isOfficeDisabled = true;
                this.isProvinceDisabled = true;
                this.data.province = '';
                this.data.citymun = '';
            } else if (arg.id === 2) {
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
            let office = data.office.id;
            // let section = data.section.value;
            // let division = data.division.value;
            let pmo = data.pmo.value
            let employment_status = data.employment_status.value;
            axios.post(`../../api/updateUserDetails`,
                {
                    id: data.id,
                    employee_no: data.employee_no,
                    position_id: data.position_id.value,
                    province: province,
                    citymun: citymun,
                    office: office,
                    // section: section,
                    // division: division,
                    pmo_id:pmo,
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
                    // const DivisionID = response.data.division;
                    // const SectionID = response.data.section;
                    const GenderID = response.data.gender;
                    const pmoID = response.data.pmo_id;

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
                    // this.data.division = DivisionID ? this.Optsdivision.find(Optsdivision => Optsdivision.value === DivisionID) : '';
                    // this.data.section = SectionID ? this.Optssection.find(Optssection => Optssection.value === SectionID) : '';
                    this.data.pmo = pmoID ? this.pmo.find(pmo => Number(pmo.value) === Number(pmoID)) : '';
                    this.data.gender = GenderID ? this.gender_opts.find(gender_opts => gender_opts.value === GenderID) : '';

                    // Fetch city/municipality options based on the selected province
                    axios.get(`../../api/getCityMun/${provID}`)
                        .then((citymunResponse) => {
                            this.Optscitymun = citymunResponse.data.map(item => ({
                                value: item.id,
                                label: item.citymun
                            }));
                            this.data.citymun = CityMunID ? this.Optscitymun.find(citymun => citymun.value === CityMunID) : '';

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

                    // console.log(this.data)
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                });
        },
        // Form validation method
        validateForm() {
            this.errors = {};

            // Check required fields (add more rules as needed)
            if (!this.data.employee_no) {
                this.errors.employee_no = 'Employee ID is required.';
            }
            if (!this.data.office) {
                this.errors.office = 'Office is required.';
            }
            if (!this.data.first_name) {
                this.errors.first_name = 'First Name is required.';
            }
            if (!this.data.last_name) {
                this.errors.last_name = 'Last Name is required.';
            }
            if (!this.data.birthdate) {
                this.errors.birthdate = 'Birth Date is required.';
            }
            if (!this.data.gender) {
                this.errors.gender = 'Gender is required.';
            }
            if (!this.data.email) {
                this.errors.email = 'Email is required.';
            } else if (!this.validEmail(this.data.email)) {
                this.errors.email = 'Please enter a valid email.';
            }
            if (!this.data.username) {
                this.errors.username = 'Username is required.';
            }
            if (!this.data.employment_status) {
                this.errors.employment_status = 'Employment Status is required.';
            }
            if (!this.data.position_id) {
                this.errors.position_id = 'Position is required.';
            }
            if (!this.data.pmo) {
                this.errors.pmo = 'Office/Division is required.';
            }
            // Add additional validations as necessary...

            // Return true if no errors
            return Object.keys(this.errors).length === 0;
        },
        // Simple email validation (you could use a more robust regex)
        validEmail(email) {
            const re = /\S+@\S+\.\S+/;
            return re.test(email);
        },
        // Submit handler for the form
        submitForm() {
            if (this.validateForm()) {
                // Proceed with updating user details
                this.updateUserDetails();
            } else {
                // Optionally scroll to the first error or display a notification
                console.log('Validation errors:', this.errors);
            }
        },
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