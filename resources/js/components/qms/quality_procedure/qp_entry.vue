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
                                                v-model="form.created_by_name" disabled />
                                            <input type="hidden" v-model="form.created_by" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Coverage:</label>
                                            <multiselect :options="COptions" v-model="form.coverage" :multiple="false"
                                                :searchable="false" id="coverage">
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

                    <div v-if="is_new" class="card" style="margin-top:1%;">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    Quality Objectives
                                </h5>
                                <div class="d-flex">
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
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
                                        <tr>
                                            <td style="width:95% !important; text-align: left;">1. qowuyehakjsdkajshdaks
                                                jdkajsaksh kajlshd lkash dljas</td>
                                            <td style="width:5% !important;">
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;" @click="">
                                                    <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                                </button>
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;" @click="">
                                                    <font-awesome-icon
                                                        :icon="['fas', 'pen-to-square']"></font-awesome-icon>
                                                </button>
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;" @click="">
                                                    <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:95% !important; text-align: left;">1. qowuyehakjsdkajshdaks
                                                jdkajsaksh kajlshd lkash dljas</td>
                                            <td style="width:5% !important;">
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;" @click="">
                                                    <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                                </button>
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;" @click="">
                                                    <font-awesome-icon
                                                        :icon="['fas', 'pen-to-square']"></font-awesome-icon>
                                                </button>
                                                <button class="btn btn-sm mr-1"
                                                    style="background-color:#059886;color:#fff;" @click="">
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
            is_new: null,
            created_by: null,
            form: {
                RevNo: '',
                EffDate: '',
                date_created: '',
                created_by: '',
                QPCode: '',
                ProcedureTitle: '',
                frequency_monitoring: null,
                coverage: null,
                office: null,
            },
            CurrUser: null,
            process_owner: [],
            FMOptions: ['Monthly', 'Quarterly', 'Quarterly (Learning and Development)'],
            COptions: ['Region', 'Region & Province', 'Region, Province & Field', 'Central Office, Region, Province & Field'],
            OOptions: ['ORD','ORD-RICTU','ORD-LEGAL','ORD-PLANNING','FAD','FAD-HRS','FAD-ACCOUNTING','FAD-RECORDS','FAD-GSS', 'LGMED', 'LGCDD'],
            POOptions: null,
            ProcessOwner: [],
        }
    },
    props: {
        // form: Object
        // is_new: String
    },
    created() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        this.form.date_created = `${yyyy}-${mm}-${dd}`;

        this.userId = localStorage.getItem('userId');
        this.fetchProcessOwner();
        this.fetchAuthor();
        // this.fetchEntryData();
        // console.log(this.OOptions);
    },
    methods: {
        fetchAuthor() {
            const userId = localStorage.getItem('userId');
            this.$fetchUserData(userId, '../../../../api/fetchUser')
                .then(emp_data => {
                    this.form.created_by_name = emp_data.name
                    this.form.created_by = userId
                    console.log(userId)
                });
        },
        fetchProcessOwner() {
            axios.get('/api/fetchProcessOwner')
                .then(response => {
                    this.ProcessOwner = response.data.map(ProcessOwner => ProcessOwner.fname);
                    // console.log(response.data.map(ProcessOwner=>ProcessOwner.fname))
                })
                .catch(error => {
                    console.error('Error Fetching items:', error);
                });
        },
        postQualityProcedure() {
            // const formData = {
            //         created_by:this.form.CreatedBy,
            //        date_created:this.form.DateCreated,
            //        EffDate:this.form.EffDate,
            //        procedure_title:this.form.ProcedureTitle,
            //        qp_code:this.form.QPCode,
            //        rev_no:this.form.RevNo,

            //        coverage:this.selected_C,
            //        frequency_monitoring:this.selected_FM,
            //        office:this.selected_O,
            //        process_owner:this.selected_PO.join(', ')
            //     }
            //     console.log(formData)
            axios.post('/api/postQualityProcedure',
                {
                    created_by: this.form.created_by,
                    date_created: this.form.date_created,
                    EffDate: this.form.EffDate,
                    procedure_title: this.form.procedure_title,
                    qp_code: this.form.qp_code,
                    rev_no: this.form.rev_no,

                    coverage: this.form.coverage,
                    frequency_monitoring: this.form.frequency_monitoring,
                    office: this.form.office,
                    process_owner: this.form.process_owner.join(', ')

                }
            )
                .then(response => {
                    toast.success('Process Owner Successfully Deleted!', {
                        autoClose: 1000
                    });
                    const id = response.data.id
                    this.$router.push({ path: `/qms/quality_procedure/qp_update/${id}` });
                })
                .catch(error => {
                    console.error('error saving data', error);
                })


            //         const formData = {
            //     ...this.form,
            //     selected_FM: this.selected_FM,
            //     selected_C: this.selected_C,
            //     selected_O: this.selected_O,
            //     selected_PO: this.selected_PO.join(', ')
            //   };
            //   console.log(formData);
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