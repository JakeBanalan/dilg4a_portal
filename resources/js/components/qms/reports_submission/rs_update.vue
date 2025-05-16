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
                                    <div v-if="this.role !== 'admin'" class="d-flex">
                                        <button @click="Return()"
                                            class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                            Close
                                        </button>
                                        <button @click="generateReport()"
                                            class="btn btn-outline-warning btn-fw btn-icon-text mx-2">
                                            Export
                                        </button>
                                        <button @click="ModalSubmit()"
                                            :disabled="!(form.status === 0 || form.status === 3)"
                                            class="btn btn-outline-success btn-fw btn-icon-text mx-2">
                                            Submit
                                        </button>
                                    </div>
                                    <div v-if="this.role === 'admin'" class="d-flex">
                                        <button @click="Return()"
                                            class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                            Close
                                        </button>
                                        <button @click="generateReport()"
                                            class="btn btn-outline-warning btn-fw btn-icon-text mx-2">
                                            Export
                                        </button>
                                        <button @click="ModalReceive()" v-if="form.status === 1"
                                            class="btn btn-outline-success btn-fw btn-icon-text mx-2">
                                            Receive
                                        </button>
                                        <button @click="openModal()" v-if="form.status === 2"
                                            class="btn btn-outline-danger btn-fw btn-icon-text mx-2">
                                            Return
                                        </button>
                                        <button @click="ModalComplete()" v-if="form.status === 2"
                                            class="btn btn-outline-success btn-fw btn-icon-text mx-2">
                                            Complete
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Quality Procedure Code:</label>
                                            <input type="text" class="form-control" id="date_created"
                                                v-model="form.qp_code" disabled />
                                        </div>
                                        <div class="col-md-3" style="padding:0%;">
                                            <label>Period Covered:</label>
                                            <input type="text" class="form-control" id="date_created"
                                                v-model="form.qp_covered" disabled />
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
                                                v-model="form.coverage" disabled />
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

                    <div class="card" style="margin-top:1%;">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    Quality Objective Entry
                                </h5>
                            </div>
                            <!--table start quality objectives-->
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <!-- <thead>
                                        <tr>
                                            <th style="width:95% !important;">CODE</th>
                                            <th style="width:5% !important;">PURPOSE</th>
                                        </tr>
                                    </thead> -->
                                    <tbody>
                                        <tr v-for="list in list" id="hover">
                                            <td style="width:95% !important; text-align: left;"> {{ list.objective }}
                                            </td>
                                            <td style="width:5% !important;">
                                                <button class="btn btn-sm mr-1"
                                                    @click="viewReportSubmission(list.qoe_id)"
                                                    style="background-color:#059886;color:#fff;">
                                                    <font-awesome-icon
                                                        :icon="['fas', 'folder-open']"></font-awesome-icon>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- HISTORY  -->
                    <div class="card" style="margin-top:1%;">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    Submission History
                                </h5>
                            </div>
                            <!--table start quality objectives-->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left; width:20% !important;">SENDER</th>
                                            <th style="text-align: left; width:20% !important;">STATUS</th>
                                            <th style="text-align: left; width:60% !important;">REMARKS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="hover" v-for="history in history"
                                            :style="statusMap[history.status] === 'Returned' ? { backgroundColor: '#f28383' } : {}">

                                            <td style="text-align: left;">
                                                <b>{{ history.fname }}</b>
                                                <br>
                                                <small>
                                                    {{ history.pmo_title }}
                                                    <br>
                                                    {{ history.formatted_date }}
                                                </small>
                                            </td>
                                            <td style="text-align: left;"><b>{{ statusMap[history.status] }}</b></td>
                                            <td style="text-align: left; white-space: normal; word-wrap: break-word;">{{ history.remarks }}</td>
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
        <ModalReturn :visible="modalVisible" :formData="formData" @close="closeModal" @return="handleReturn" />
        <ModalSubmit :visible="SubmitVisible" :formData="formData" @close="closeModal" @post="PostReport" />
        <ModalReceive :visible="ReceiveVisible" :formData="formData" @close="closeModal" @receive="receiveReport" />
        <ModalComplete :visible="CompleteVisible" :formData="formData" @close="closeModal" @complete="CompleteReport" />


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
import ModalReturn from './modal/modal_rs_return.vue';
import ModalSubmit from './modal/modal_rs_submit.vue';
import ModalReceive from './modal/modal_rs_receive.vue';
import ModalComplete from './modal/modal_rs_complete.vue';



import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare, faFolderOpen } from '@fortawesome/free-solid-svg-icons';
import axios, { Axios } from 'axios';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare, faFolderOpen);


export default {
    components: {
        Multiselect,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
        ModalReturn,
        ModalSubmit,
        ModalReceive,
        ModalComplete,
        FontAwesomeIcon
    },
    data() {
        return {
            statusMap: {
                0: 'Draft',
                1: 'Submitted',
                2: 'Received',
                3: 'Returned',
                4: 'Completed'
            },
            form: {
                rev_no: '',
                EffDate: '',
                date_created: '',
                created_by: '',
                procedure_title: '',
                frequency_monitoring: '',
                coverage: '',
                office: '',
                qp_covered: '',
                status: '',
                qp_code: '',
                qop_id: '',
                process_owner: '',
            },
            list: {
                id: '',
                qop_id: '',
                qp_covered: '',
                target_percentage: '',
                formula: '',
                objective: '',
                indicator_a: '',
                indicator_b: '',
                indicator_c: '',
                indicator_d: '',
                indicator_e: '',
            },
            history: [],
            modalVisible: false,
            SubmitVisible: false,
            ReceiveVisible: false,
            CompleteVisible: false,

            // qp_code: [],
            // period_covered: [],
            // year:['2022', '2023', '2024', '2025']
        }
    },
    props: {
        // form: Object
        // is_new: String
    },
    created() {
        this.userId = localStorage.getItem('userId');
        this.role = localStorage.getItem('user_role');
        this.fetchQoprData();
        this.fetchQoprEntryData();
        this.fetchQopHistoryData();
        this.formData = { ...this.form };

    },
    methods: {
        ModalComplete() {
            this.formData = { ...this.form };
            this.CompleteVisible = true;
        },
        ModalReceive() {
            this.formData = { ...this.form };
            this.ReceiveVisible = true;
        },
        ModalSubmit() {
            this.formData = { ...this.form };
            this.SubmitVisible = true;
        },
        openModal() {
            this.formData = { ...this.form };
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
            this.SubmitVisible = false;
            this.ReceiveVisible = false;
            this.CompleteVisible = false;

        },
        CompleteReport() {
            let id = this.$route.params.id;
            const userId = localStorage.getItem('userId');
            axios.post(`/api/completeReport`, {
                id: id,
                status: '4',
                userId: userId,
                remarks: this.formData.remarks
            })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Report Successfully Completed!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    setTimeout(() => {
                        this.CompleteVisible = false;
                        this.fetchQoprData();
                        this.fetchQopHistoryData();
                    }, 200);
                })
                .catch(error => {
                    console.error('Error Submitting report:', error)
                })
        },
        handleReturn() {
            let id = this.$route.params.id;
            const userId = localStorage.getItem('userId');
            axios.post(`/api/returnReport`, {
                id: id,
                status: '3',
                userId: userId,
                remarks: this.formData.remarks
            })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Report Successfully Returned!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    setTimeout(() => {
                        this.modalVisible = false;
                        this.fetchQoprData();
                        this.fetchQopHistoryData();
                    }, 200);
                })
                .catch(error => {
                    console.error('Error Submitting report:', error)
                })
        },
        Return() {
            this.$router.push({ path: `/qms/reports_submission/index` });
        },
        receiveReport(arg) {
            Swal.fire({
                title: 'Receive this Report?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {

                    let id = this.$route.params.id;
                    const userId = localStorage.getItem('userId');
                    axios.post(`/api/receiveReport`, {
                        id: id,
                        status: '2',
                        userId: userId,
                        remarks: this.formData.remarks
                    })
                        .then(response => {

                            Swal.fire({
                                icon: 'success',
                                title: 'Report Successfully Received!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                this.ReceiveVisible = false;
                                this.fetchQopHistoryData();
                                this.fetchQoprData();
                            }, 200);
                        })
                        .catch(error => {
                            console.error('Error Submitting report:', error)
                        })

                }
            });
        },
        PostReport() {
            Swal.fire({
                title: 'Submit Report?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {

                    let id = this.$route.params.id;
                    const userId = localStorage.getItem('userId');
                    axios.post(`/api/submitReport`, {
                        id: id,
                        status: '1',
                        userId: userId,
                        remarks: this.formData.remarks

                    })
                        .then(response => {

                            Swal.fire({
                                icon: 'success',
                                title: 'Report Successfully Submitted!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                this.SubmitVisible = false;
                                this.fetchQopHistoryData();
                                this.fetchQoprData();
                            }, 200);
                        })
                        .catch(error => {
                            console.error('Error Submitting report:', error)
                        })

                }
            });


        },
        viewReportSubmission(qoe_id) {
            // console.log(qoe_id)
            let qoe_id1 = qoe_id;
            let id = this.$route.params.id;
            let fq = this.form.frequency_monitoring
            let pq = this.form.qp_covered
            let status = this.form.status
            if (fq === "Quarterly") {
                this.$router.push({
                    path: `/qms/reports_submission/rs_obj_entries/${id}/${qoe_id1}`,
                    query: {
                        pq: pq,
                        stat: status
                    }
                });
            } else if (fq === "Monthly") {
                this.$router.push({
                    path: `/qms/reports_submission/rs_monthly_entries/${id}/${qoe_id1}`,
                    query: {
                        pq: pq,
                        stat: status
                    }
                });
            } else if (fq === "Quarterly (Learning and Development)") {
                this.$router.push({
                    path: `/qms/reports_submission/rs_quarterly_lnd_entries/${id}/${qoe_id1}`,
                    query: {
                        pq: pq,
                        stat: status
                    }
                });
            }
        },
        fetchQopHistoryData() {
            let id = this.$route.params.id;
            // console.log(id)
            axios.get(`/api/fetchQopHistoryData/${id}`)
                .then(response => {
                    this.history = response.data
                    console.log("HISTORY", this.history)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        fetchQoprData() {
            let id = this.$route.params.id;
            // console.log("tbl_qop_report ID:", id)
            axios.get(`/api/fetchQoprData/${id}`)
                .then(response => {
                    if (Array.isArray(response.data) && response.data.length > 0) {
                        this.form = response.data[0];
                    } else {
                        console.error("Unexpected response format:", response.data);
                    }
                    // console.log(response.data)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        fetchQoprEntryData() {
            let id = this.$route.params.id;
            // console.log(id)
            axios.get(`/api/fetchQoprEntryData/${id}`)
                .then(response => {
                    this.list = response.data
                    // console.log("LIST",this.list)

                    // if (Array.isArray(response.data) && response.data.length > 0) {
                    //         this.form = response.data[0];
                    //     } else {
                    //         console.error("Unexpected response format:", response.data);
                    //     }
                    // console.log(list.objective)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        generateReport() {
            let id = this.$route.params.id;
            let fm = this.form.frequency_monitoring;
            if (fm === 'Monthly') {
                window.location.href = `/../api/generateReportM/${id}?export=true`;
                // this.showToastSuccess('Successfully downloaded!');
                // setTimeout(() => {
                //     location.reload();
                // }, 1000); // Adjust the delay as needed
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully downloaded!',
                    showConfirmButton: false,
                    timer: 1000
                });
            } else if (fm === 'Quarterly') {
                window.location.href = `/../api/generateReportQ/${id}?export=true`;
                // this.showToastSuccess('Successfully downloaded!');
                // setTimeout(() => {
                //     location.reload();
                // }, 1000); // Adjust the delay as needed
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully downloaded!',
                    showConfirmButton: false,
                    timer: 1000
                });
            } else if (fm === 'Quarterly (Learning and Development)') {
                window.location.href = `/../api/generateReportQLND/${id}?export=true`;
                // this.showToastSuccess('Successfully downloaded!');
                // setTimeout(() => {
                //     location.reload();
                // }, 1000); // Adjust the delay as needed
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully downloaded!',
                    showConfirmButton: false,
                    timer: 1000
                });
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

#hover:hover {
    background-color: rgba(5, 152, 135, 0.258);
    cursor: pointer;
}
</style>