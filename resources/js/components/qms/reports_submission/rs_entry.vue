<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="card">
                        <div class="card-body">
                            <form class="formQP" @submit.prevent="validateForm">

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
                                        <button type="submit" class="btn btn-outline-success btn-fw btn-icon-text mx-2">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Quality Procedure Code: <small class="err-msg"
                                                    v-if="errors.qp_code">{{ errors.qp_code }}</small></label>
                                            <Multiselect @update:modelValue="fetchQPdata" :options="qp_code"
                                                track-by="value" v-model="form.qp_code" :multiple="false" label="label"
                                                :searchable="false" id="qp_code" placeholder="Select QP Code"
                                                :class="{ 'is-invalid': errors.qp_code }">
                                            </Multiselect>
                                        </div>
                                        <div class="col-md-3" style="padding:0%;">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label>Period Covered: <small class="err-msg"
                                                            v-if="errors.period_covered">{{ errors.period_covered
                                                            }}</small></label>
                                                    <Multiselect :options="period_covered" v-model="form.period_covered"
                                                        :multiple="false" :searchable="false" id="period_covered"
                                                        placeholder="Period Cover"
                                                        :class="{ 'is-invalid': errors.period_covered }">
                                                    </Multiselect>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Year: <small class="err-msg" v-if="errors.year">{{
                                                        errors.year }}</small></label>
                                                    <Multiselect :options="year" v-model="form.year" :multiple="false"
                                                        :searchable="false" id="year" placeholder="Year"
                                                        :class="{ 'is-invalid': errors.year }">
                                                    </Multiselect>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <label>Date Created</label>
                                            <input type="text" class="form-control" id="date_created"
                                                v-model="form.date_created" disabled />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Created By</label>
                                            <input type="text" class="form-control" id="created_by" v-model="form.fname"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Coverage:</label>
                                            <input type="text" class="form-control" id="coverage"
                                                v-model="form.coverage_name" disabled />
                                            <label>Office:</label>
                                            <input type="text" class="form-control" id="office" v-model="form.office"
                                                disabled />
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <label>Process Owner:</label>
                                                <input type="text" class="form-control" id="process_owner"
                                                    v-model="form.process_owner" disabled />
                                                <label>Frequency Monitoring:</label>
                                                <input type="text" class="form-control" id="frequency_monitoring"
                                                    v-model="form.frequency_monitoring" disabled />
                                            </div>

                                        </div>
                                        <div class="col-md-6">

                                            <label>Procedure Title</label>
                                            <textarea rows="3" col="100" style="height:110px !important;"
                                                id="procedure_title" class="form-control" v-model="form.procedure_title"
                                                disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- <Pagination :total="ict_data.length" @pageChange="onPageChange" /> -->

                </div>
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



import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare } from '@fortawesome/free-solid-svg-icons';
import axios, { Axios } from 'axios';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare);


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
            form: {
                qoe_id: '',
                rev_no: '',
                EffDate: '',
                date_created: '',
                created_by: '',
                procedure_title: '',
                frequency_monitoring: '',
                coverage: '',
                coverage_name: '',
                office: '',
            },
            errors: {},
            qp_code: [],
            period_covered: [],
            year: ['2024', '2025', '2026']
        }
    },
    props: {
        // form: Object
        // is_new: String
    },
    created() {
        this.userId = localStorage.getItem('userId');
        this.role = localStorage.getItem('user_role');
        // this.fetchProcessOwner();
        // this.fetchQualityProcedure()
        // this.fetchEntryData();
        // console.log(this.OOptions);
        // console.log(this.role);
    },
    mounted() {
        // Load data for specific user or all users based on role
        if (this.role === 'admin') {
            this.fetchQualityProcedureAll(); // Admin sees all requests
        } else {
            this.fetchQualityProcedure(); // Non-admin sees only their own requests
        }
    },
    methods: {
        async validateForm() {
            this.errors = {};
            if (!this.form.qp_code) {
                this.errors.qp_code = 'Required.';
            }
            if (!this.form.period_covered) {
                this.errors.period_covered = 'Required.';
            }
            if (!this.form.year) {
                this.errors.year = 'Required.';
            }
            if (Object.keys(this.errors).length === 0) {
                try {
                    await this.postRS()
                    // this.$emit('save', this.eventDetails);
                } catch (error) {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                }
            }
        },
        Return() {
            this.$router.push({ path: `/qms/reports_submission/index` });
        },
        fetchQPdata(arg) {
            let qp_code_id = arg.value
            axios.get(`/api/fetchQPdata/${qp_code_id}`)
                .then(response => {
                    // console.log(response.data)
                    // console.log(response.data[0].frequency_monitoring)
                    if (response.data[0].frequency_monitoring === 'Monthly') {
                        this.period_covered = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    } else if (response.data[0].frequency_monitoring === 'Quarterly' || response.data[0].frequency_monitoring === 'Quarterly (Learning and Development)') {
                        this.period_covered = ['1st Quarter', '2nd Quarter', '3rd Quarter', '4th Quarter'];
                    }

                    this.form = {
                        ...response.data[0],
                        qp_code: this.form.qp_code,

                    }
                    this.qoe_id = response.data.map(item => item.qoe_id);
                    // console.log(this.form)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        fetchQualityProcedureAll() {
            axios.get('/api/fetchQualityProcedureAll')
                .then(response => {
                    // console.log(response.data)
                    this.qp_code = response.data.map(qp_code => ({
                        label: qp_code.qp_code,
                        value: qp_code.id
                    }))
                })
                .catch(error => {
                    console.error('Error Fetching items:', error);
                });
        },
        fetchQualityProcedure() {
            let userId = localStorage.getItem('userId');
            axios.get(`/api/fetchQualityProcedure/${userId}`)
                .then(response => {
                    // console.log(response.data)
                    this.qp_code = response.data.map(qp_code => ({
                        label: qp_code.qp_code,
                        value: qp_code.id
                    }))
                    // this.QualityProcedure = response.data
                    // console.log(this.QualityProcedure)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        async postRS() {
            const result = await Swal.fire({
                title: 'Do you want to continue?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Continue',
            });

            if (result.isConfirmed) {
                try {
                    const response = await axios.post('/api/postReportEntry', {
                        qop_id: this.form.id,
                        qoe_id: this.qoe_id,
                        created_by: this.userId,
                        qp_covered: this.form.period_covered,
                        frequency_monitoring: this.form.frequency_monitoring,
                        year: this.form.year
                    });

                    await Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        showConfirmButton: false,
                        timer: 1000
                    });

                    setTimeout(() => {
                        const id = response.data.id;
                        const office = response.data.submitted_office;
                        this.$router.push({ path: `/qms/reports_submission/rs_update/${id}` });
                    }, 200);

                } catch (error) {
                    console.error('error saving data', error);
                    // Optionally, handle error.display or set this.errors if it's a 422
                }
            }
        }

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

/* Scoped or global */
.is-invalid .multiselect__control,
.is-invalid .multiselect__tags {
    border: 1px solid red !important;
    background-color: #fff !important;
    border-radius: 4px;
}
</style>