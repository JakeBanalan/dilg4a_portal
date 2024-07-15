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
                            <form class="formQObjectives" @submit.prevent="postQualityObjectives">

                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;QMS Objectives
                                    </h5>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                            Save
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <label>Quality Objective</label>
                                            <textarea rows="3" col="100" style="height:135px !important;"
                                                v-model="form.quality_objective" id="quality_objective" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="col-md-12">
                                                <label>Target (%)</label>
                                                <input type="text" class="form-control" id="target" v-model="form.target"/>
                                            </div>
                                            <br>
                                            <div class="col-md-12">
                                                <label>Formula</label>
                                                <multiselect :options="FormulaOpts" v-model="form.formula"
                                                :multiple="false" :searchable="false">
                                            </multiselect>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Indicator A</label>
                                            <textarea rows="3" col="100" style="height:100px !important;"
                                            v-model="form.indicator_a" id="indicator_a" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Indicator B</label>
                                            <textarea rows="3" col="100" style="height:75px !important;"
                                            v-model="form.indicator_b" id="indicator_b" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Indicator C</label>
                                            <textarea rows="3" col="100" style="height:75px !important;"
                                            v-model="form.indicator_c" id="indicator_c" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Indicator D</label>
                                            <textarea rows="3" col="100" style="height:75px !important;"
                                            v-model="form.indicator_d" id="indicator_d" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Indicator E</label>
                                            <textarea rows="3" col="100" style="height:75px !important;"
                                            v-model="form.indicator_e" id="indicator_e" class="form-control"></textarea>
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
            FormulaOpts: ['','A/Bx100', 'No. of Days Elapse B-A', 'Notice of Suspension/Disallowance', 'A/(B+C)-Dx100'],
            form:{
                quality_objective: '',
                target: '',
                formula: '',
                indicator_a: '',
                indicator_b: '',
                indicator_c: '',
                indicator_d: '',
                indicator_e: '',
            }
        }
    },
    props: {
    },
    created() {
    },
    methods: {
        postQualityObjectives(){
            let id = this.$route.params.id;

            // const formData = {
            //          qop_id: id,
            //         quality_objective:this.form.quality_objective,
            //        target:this.form.target,
            //        formula:this.form.formula,
            //        indicator_a:this.form.indicator_a,
            //        indicator_b:this.form.indicator_b,
            //        indicator_c:this.form.indicator_c,
            //        indicator_d:this.form.indicator_d,
            //        indicator_e:this.form.indicator_e,
            //     }
            //     console.log(formData)
                
                axios.post('/api/postQualityObjectives',
                {
                    qop_id: id,
                    quality_objective:this.form.quality_objective,
                   target:this.form.target,
                   formula:this.form.formula,
                   indicator_a:this.form.indicator_a,
                   indicator_b:this.form.indicator_b,
                   indicator_c:this.form.indicator_c,
                   indicator_d:this.form.indicator_d,
                   indicator_e:this.form.indicator_e,

                }
            )
                .then(response => {
                    toast.success('Process Owner Successfully Deleted!', {
                        autoClose: 1000
                    });
                    const id = this.$route.params.id
                    this.$router.push({ path: `/qms/quality_procedure/qp_update/${id}`});
                })
                .catch(error => {
                    console.error('error saving data', error);
                })

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