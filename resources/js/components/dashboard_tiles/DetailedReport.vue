<style scoped>
.card-title {
    color: #059886;
}
</style>
<template>
    <div class="card">
        <div class="card-body">

            <div class="card">
                <div class="card-body">
                    <p class="card-title">
                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp; Purchase Request List
                    </p>
                    <div class="box-tools">
                        <button @click="toCreatePR()" type="button"
                            class="btn btn-outline-primary btn-fw btn-icon-text">
                            Create PR
                        </button>

                        <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2" @click="toggleCard()">
                            Advanced Search
                        </button>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6"></div>
                                        <div class="col-sm-12 col-md-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <div class="card" v-if="isCardVisible">
                                                    <div class="card-body">
                                                        <div class="card-title">
                                                            <h4><font-awesome-icon
                                                                    :icon="['fas', 'search']" />&nbsp;ADVANCED
                                                                FILTER</h4>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-lg-3">
                                                                <label style="font-size: 0.875rem;">PURCHASE REQUEST
                                                                    No</label>
                                                                <input type="text" v-model="pr_no"
                                                                    placeholder="Purchase Request No."
                                                                    @keyup.enter="filter" />
                                                            </div>

                                                            <div class="col-lg-3">
                                                                <label style="font-size: 0.875rem;">Start Date</label>
                                                                <input type="date" class="form-control"
                                                                    v-model="pr_date" />
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label style="font-size: 0.875rem;">OFFICE/
                                                                    DIVISION</label>
                                                                <multiselect v-model="selected_pmo" :options="pmo"
                                                                    label="label" :multiple="false" :searchable="false"
                                                                    :allow-empty="false"></multiselect>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label style="font-size: 0.875rem;">Status</label>
                                                                    <multiselect v-model="selected_status"
                                                                        deselect-label="Can't remove this value"
                                                                        track-by="value" label="label" :options="stat"
                                                                        :searchable="false" :allow-empty="false">
                                                                    </multiselect>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-fw btn-icon-text"
                                                            style="float:right;" @click="filter()">Filter</button>
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-fw btn-icon-text mr-3"
                                                            style="float:right;" @click="resetFilter()">Clear</button>
                                                    </div>
                                                </div>
                                                <procurement_table :filter-params.sync="filterParams" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5"></div>
                                        <div class="col-sm-12 col-md-7"></div>
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
import procurement_table from '../../components/procurement/procurement_table.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faList } from '@fortawesome/free-solid-svg-icons';
import Multiselect from 'vue-multiselect'

library.add(faList);
export default {
    name: 'DetailedReport',
    components: {
        procurement_table,
        FontAwesomeIcon,
        Multiselect
    },
    data() {
        return {
            role: null,
            pr_no: '',
            pr_date: '',
            value: null,
            selected_pmo: null,
            selected_quarter: [],
            filterParams: {
                pr_no: '',
                pr_date: '',
                pmo: null,
                stat: null,
            },
            pmo: [
                { label: "ORD-Legal", value: "ORD-Legal" },
                { label: "ORD-Planning", value: "ORD-Planning" },
                { label: "LGMED-MBRTG", value: "LGMED-MBRTG" },
                { label: "LGCDD-PDMU", value: "LGCDD-PDMU" },
                { label: "FAD", value: "FAD" },
                { label: "ORD-RICTU", value: "ORD-RICTU" },
                { label: "LGCDD", value: "LGCDD" },
                { label: "LGMED", value: "LGMED" }
            ],
            stat: [
                { label: 'Draft', value: "Draft" },
                { label: 'Submitted to GSS', value: "Submitted to GSS" },
                { label: 'Submitted to Budget', value: "Submitted to Budget" },
                { label: 'Received by Budget', value: "Received by Budget" },
                { label: 'Received by GSS', value: "Received by GSS" },
                { label: 'With RFQ', value: "With RFQ" },
                { label: 'With Purchase Order', value: "With Purchase Order" },
                { label: 'Awarded', value: "Awarded" },
                { label: 'Cancelled', value: "Cancelled" }
            ],
            selected_status: null,
            isCardVisible: false,
        }
    },
    mounted() {
    },
    created() {
        // Set the role from localStorage
        this.role = localStorage.getItem('user_role');
    },
    methods: {
        filter() {
            this.filterParams = {
                pr_no: this.pr_no,
                pr_date: this.pr_date,
                pmo: this.selected_pmo && this.selected_pmo.value,
                status: this.selected_status && this.selected_status.value,
            };
        },
        resetFilter() {
            this.filterParams = {
                pr_no: '',
                pr_date: '',
                pmo: null,
                status: null,
            };
            this.pr_no = '';
            this.pr_date = '';
            this.selected_pmo = null;
            this.selected_status = null;
        },
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
        },
        toCreatePR() {
            this.$router.push("/procurement/create_pr");
        },

    }
}
</script>
