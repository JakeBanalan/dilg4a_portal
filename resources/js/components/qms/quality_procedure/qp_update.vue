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
                            <form class="formQP" @submit.prevent="postQualityProcedure">

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
                                        <button type="submit" class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Frequency Monitoring:</label>
                                            <multiselect :options="FMOptions" v-model="form.frequency_monitoring"
                                                :multiple="false" :searchable="false" id="frequency_monitoring">
                                            </multiselect>
                                        </div>
                                        <div class="col-md-3" style="padding:0%;">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label>Revision No.:</label>
                                                    <input type="text" class="form-control" id="rev_no"
                                                        v-model="form.rev_no" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Eff Date:</label>
                                                    <input type="text" class="form-control" id="EffDate"
                                                        v-model="form.EffDate" />
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
                                            <input type="text" class="form-control" id="created_by"
                                                v-model="form.created_by" disabled />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Coverage:</label>
                                            <multiselect :options="COptions" v-model="form.coverage" track-by="value"
                                                label="label" :multiple="false" :searchable="false" id="coverage">
                                            </multiselect>
                                            <label>Office:</label>
                                            <multiselect :options="OOptions" v-model="form.office" :multiple="false"
                                                :searchable="false" id="office">
                                            </multiselect>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <label>Process Owner:</label>
                                                <multiselect :options="ProcessOwner" v-model="form.process_owner"
                                                    :multiple="true" :searchable="false" id="process_owner">
                                                </multiselect>
                                                <label>QP Code:</label>
                                                <input type="text" class="form-control" id="qp_code"
                                                    v-model="form.qp_code" />
                                            </div>

                                        </div>
                                        <div class="col-md-6">

                                            <label>Procedure Title</label>
                                            <textarea rows="3" col="100" style="height:110px !important;"
                                                id="procedure_title" class="form-control"
                                                v-model="form.procedure_title"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card" style="margin-top:1%;">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    Quality Objectives
                                </h5>
                                <div class="d-flex">
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2" @click="AddQOE">
                                        Add Quality Objectives
                                    </button>
                                </div>
                            </div>
                            <!--table start quality objectives-->
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <!-- <thead>
                                        <tr>
                                            <th style="width:95% !important;">CODE</th>
                                            <th style="width:5% !important;">PURPOSE</th>
                                        </tr>
                                    </thead> -->
                                    <tbody>
                                        <tr v-for="qop in QObjectives">
                                            <td style="width:95% !important; text-align: left;">{{ qop.objective }}</td>
                                            <td style="width:5% !important;">
                                                <button class="btn btn-sm mr-1" @click="updateQualityObjective(qop.id)"
                                                    style="background-color:#059886;color:#fff;">
                                                    <font-awesome-icon
                                                        :icon="['fas', 'pen-to-square']"></font-awesome-icon>
                                                </button>
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;"
                                                    @click="deleteQualityObjective(qop.id)">
                                                    <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-top:1%;" v-if="form.coverage.value == 1 || 2">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <!-- <h5 class="card-title">
                                    Signatories
                                </h5> -->
                            </div>
                            <!--table start quality objectives-->
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:20% !important">REGIONAL DEPUTY QMR</th>
                                            <th style="width:20% !important">REGIONAL QMR</th>
                                            <th style="width:5% !important">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ppo in PO_ProcessOwner" :key="ppo.id">
                                            <td>{{ ppo.pmo_title }}</td>
                                            <td>{{ ppo.ppo_name }}</td>
                                            <td style="width:5% !important;">
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;"
                                                    @click="updatePPO(ppo)">
                                                    <font-awesome-icon
                                                        :icon="['fas', 'pen-to-square']"></font-awesome-icon>
                                                </button>
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;"
                                                    @click="deletePPO(ppo.id)">
                                                    <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-top:1%;" v-if="form.coverage.value == 2">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    Provincial Process Owners
                                </h5>
                            </div>
                            <!--table start quality objectives-->
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:20% !important">PROVINCE/HUC</th>
                                            <th style="width:20% !important">PROCESS OWNER</th>
                                            <th style="width:20% !important">PROGRAM MANAGER</th>
                                            <th style="width:20% !important">PROVINCIAL QMR</th>
                                            <th style="width:5% !important">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ppo in PO_ProcessOwner" :key="ppo.id">
                                            <td>{{ ppo.pmo_title }}</td>
                                            <td>{{ ppo.ppo_name }}</td>
                                            <td>{{ ppo.pm_name }}</td>
                                            <td>{{ ppo.qmr_name }}</td>
                                            <td style="width:5% !important;">
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;"
                                                    @click="updatePPO(ppo)">
                                                    <font-awesome-icon
                                                        :icon="['fas', 'pen-to-square']"></font-awesome-icon>
                                                </button>
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;"
                                                    @click="deletePPO(ppo.id)">
                                                    <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- <Pagination :total="ict_data.length" @pageChange="onPageChange" /> -->
                    <PPOModal :visible="modalVisible" :selectedPOid="selectedPOid" :PO_ProcessOwner="PO_ProcessOwner"
                        :selectedPPOId="selectedPPOId" @addpprocessowner="AddPProcessOwner" @close="CloseModal" />

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
import PPOModal from '../quality_procedure/PPOModal.vue';



import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare } from '@fortawesome/free-solid-svg-icons';
import axios, { Axios } from 'axios';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare);


export default {
    name: "Update QP",
    components: {
        PPOModal,
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
            // is_new: null,
            form: {
                RevNo: '',
                EffDate: '',
                DateCreated: '',
                CreatedBy: '',
                QPCode: '',
                ProcedureTitle: '',
                frequency_monitoring: '',
                coverage: '',
                // coverage_name: '',
                office: '',
            },
            QObjectives: {
                id: '',
                qop_id: '',
                objective: '',
                target_percentage: '',
                formula: '',
                indicator_a: '',
                indicator_b: '',
                indicator_c: '',
                indicator_d: '',
                indicator_e: ''
            },
            process_owner: [],
            FMOptions: ['Monthly', 'Quarterly'],
            COptions: [
                { label: 'Region', value: 1 },
                { label: 'Region & Province', value: 2 },
                { label: 'Region, Province & Field', value: 3 },
                { label: 'Central Office, Region, Province & Field', value: 4 }
            ],
            OOptions: ['ORD', 'ORD-RICTU', 'ORD-LEGAL', 'ORD-PLANNING', 'FAD', 'FAD-HRS', 'FAD-ACCOUNTING', 'FAD-RECORDS', 'FAD-GSS', 'LGMED', 'LGCDD'],
            POOptions: null,
            ProcessOwner: [],
            PO_ProcessOwner: {
                id: '',
                qop_id: '',
                parent_p_owner: '',
                pmo_id: '',
                po_process_owner: '',
                pmo_title: '',
                ppo_name: '',
                qmr_name: '',
                pm_name: '',
                program_manager: '',
                provincial_qmr: ''
            },
            modalVisible: false,
            selectedPOid: null,
            selectedPPOId: null,
        }
    },
    props: {
        // form: Object
        // is_new: String
    },
    created() {
        this.fetchProcessOwner();
        this.fetchEntryData();
        this.fetchQualityObjective();
        this.fetchPOProcessOwner();
        // console.log(this.form);
    },
    methods: {
        Return() {
            this.$router.push({ path: `/qms/quality_procedure/index` });
        },
        AddQOE() {
            let id = this.$route.params.id;
            this.$router.push({ path: `/qms/quality_procedure/qp_objectives_entry/${id}` });
        },
        fetchEntryData() {
            let id = this.$route.params.id;
            axios.get(`/api/fetchEntryData/${id}`)
                .then(response => {
                    if (Array.isArray(response.data) && response.data.length > 0) {
                        this.form = response.data[0];

                        const coverageValue = this.form.coverage;
                        this.form.coverage = this.COptions.find(option => option.value === coverageValue);
                    } else {
                        console.error("Unexpected response format:", response.data);
                    }
                })
                .catch(error => {
                    console.error("There was an error fetching the data:", error);
                });
        },
        fetchQualityObjective() {
            let id = this.$route.params.id;
            axios.get(`/api/fetchQualityObjectives/${id}`)
                .then(response => {
                    this.QObjectives = response.data;
                    // console.log(this.QObjectives)
                })
                .catch(error => {
                    console.error("There was an error fetching the data:", error);
                });
        },
        fetchPOProcessOwner() {
            let id = this.$route.params.id;
            axios.get(`/api/fetchPOProcessOwner/${id}`)
                .then(response => {
                    this.PO_ProcessOwner = response.data;
                    // console.log(this.PO_ProcessOwner)
                })
                .catch(error => {
                    console.error("There was an error fetching the data:", error);
                });
        },
        updatePPO(ppo) {
            this.selectedPPOId = ppo.id;
            this.selectedPOid = ppo.pmo_id;
            // console.log("Selected PPO ID:", this.selectedPPOId);
            // console.log("Selected PO ID:", this.selectedPOid);
            this.modalVisible = true;
        },
        CloseModal() {
            this.modalVisible = false;
        },
        deletePPO(id) {
            console.log("Delete PPO ID:", id)
            axios.post('/api/DeletePOProcessOwner', {
                id: id
            })
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Process Owner Successfully Deleted!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    setTimeout(() => {
                        this.fetchPOProcessOwner();
                    }, 200);
                })
                .catch(error => {
                    console.error('error saving data', error);
                })
        },
        AddPProcessOwner({ ppoid, po, ppo, pm, qmr }) {

            axios.post('/api/AddPOProcessOwner', {
                ppoid: ppoid,
                po: po,
                ppo: ppo,
                pm: pm,
                qmr: qmr,
            })
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Process Owner Successfully Added!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    setTimeout(() => {
                        this.fetchPOProcessOwner();
                        this.modalVisible = false;
                    }, 200);
                })
                .catch(error => {
                    console.error('error saving data', error);
                })

        },
        fetchProcessOwner() {
            axios.get('/api/fetchProcessOwner')
                .then(response => {
                    this.ProcessOwner = response.data.map(ProcessOwner => ProcessOwner.fname);
                    // console.log(response.data)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error);
                });
        },
        postQualityProcedure() {
            // console.log("Form Data:", this.form);
            axios.post('/api/UpdateQualityProcedure',
                {
                    id: this.$route.params.id,
                    // created_by: this.form.created_by,
                    date_created: this.form.date_created,
                    EffDate: this.form.EffDate,
                    procedure_title: this.form.procedure_title,
                    qp_code: this.form.qp_code,
                    rev_no: this.form.rev_no,
                    coverage: this.form.coverage.value,
                    frequency_monitoring: this.form.frequency_monitoring,
                    office: this.form.office,
                    process_owner: this.form.process_owner.join(', ')
                }
            )
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Quality Procedure Successfully Updated!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    setTimeout(() => {
                        this.fetchEntryData();
                        this.fetchQualityObjective();
                    }, 200);

                    // console.log(response.data);
                })
                .catch(error => {
                    console.error('error saving data', error);
                })
        },
        updateQualityObjective(qoeID) {
            let qoe_id = qoeID;
            let id = this.$route.params.id;
            this.$router.push({ path: `/qms/quality_procedure/qp_objectives_update/${id}/${qoe_id}` });
        },
        deleteQualityObjective(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let qop_id = this.$route.params.id;
                    axios.post('/api/DeleteQualityObjective', {
                        id: id,
                        qop_id: qop_id
                    })
                        .then(() => {

                            Swal.fire({
                                icon: 'success',
                                title: 'Quality Objective Successfully Deleted!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                this.fetchEntryData();
                                this.fetchQualityObjective();
                            }, 200);
                        })
                        .catch(error => {
                            console.error('error saving data', error);
                        })
                }
            });

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
</style>