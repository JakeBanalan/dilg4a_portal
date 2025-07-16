<style>
th,
td {
    padding: 8px;
    /* Optional: Add padding for better spacing */
    white-space: nowrap;
    /* Prevent text from wrapping */
    overflow: hidden;
    /* Hide overflow content */
    text-overflow: ellipsis;
    /* Display ellipsis (...) for overflowed text */
    max-width: 300px;
    /* Maximum width of cells */
}

#ufstable,
#ufstable tr,
#ufstable td {
    overflow: visible !important;
    position: relative !important;
}

#ufstable {
    overflow-x: auto !important;
    overflow-y: visible !important;
    /* prevent vertical clipping */
}

.details-icon {
    cursor: pointer;
    color: #059988;
    /* Bootstrap primary */
    font-size: 1rem;
    padding: 0.25rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s, color 0.2s;
}

.details-icon:hover {
    background-color: rgba(5, 153, 136, 0.1);
    /* subtle hover effect */
    color: #04756c;
    /* darker primary on hover */
}

.profile_img {
    width: 100px;
    height: 100px;
    padding: 1px;
    margin-bottom: 15%;
    border-radius: 100%;
    border: 1px solid rgb(18, 15, 76);
}

.user_info {
    display: flex;
    justify-content: space-between;
    margin: 0px;
    vertical-align: middle;
    width: 100%;
}

.rank_banner {
    background-color: rgb(104, 34, 142);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner2 {
    background-color: rgb(128, 22, 22);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner3 {
    background-color: rgb(45, 2, 85);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_wrapper {
    -webkit-clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    height: 4.5rem;
    padding-right: 4px;
    padding-top: 2px;
    position: absolute;
    right: 0px;
    text-align: right;
    top: 0px;
    width: 4.5rem;
}

.card_shadow {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    /* Change box shadow on hover for an interactive effect */

}
</style>
<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;
                                        Fund Source
                                    </h5>
                                    <div class="d-flex">
                                        <button class="btn btn-primary btn-md mx-2" @click="returnToObligation">
                                            <font-awesome-icon :icon="['fas', 'arrow-left']"></font-awesome-icon>
                                            Return
                                        </button>
                                        <button class="btn btn-success btn-md mx-2" @click="">
                                            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                            Save
                                        </button>
                                        <button type="button" class="btn btn-warning btn-md mx-2" @click="">
                                            <font-awesome-icon :icon="['fas', 'lock']"></font-awesome-icon>
                                            Lock
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Allotmet/Sub Allotment No:</label>
                                            <input type="text" v-model="fundSourcesData.code" class="form-control"
                                                placeholder="">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label>MFO/ P/A/P:</label>
                                                <input type="text" v-model="fundSourcesData.ppa" class="form-control"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Date</label>
                                            <input type="text" v-model="fundSourcesData.date_created"
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row" style="padding-top:1%;">
                                        <div class="col-md-4">
                                            <label>Name:</label>
                                            <textarea rows="3" col="100" style="height:110px !important;"
                                                id="procedure_title" v-model="fundSourcesData.fund_name"
                                                class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label>Particulars:</label>
                                                <textarea rows="3" col="100" style="height:110px !important;"
                                                    id="procedure_title" v-model="fundSourcesData.particulars"
                                                    class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Legal Basis</label>
                                            <input type="text" class="form-control"
                                                v-model="fundSourcesData.legal_basis" placeholder="">

                                            <!-- <label>Created By:</label>
                                            <input type="text" class="form-control" placeholder=""> -->

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12" style="padding-top: 1%;">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;
                                        Entries
                                    </h5>
                                    <div class="d-flex">
                                        <button class="btn btn-primary btn-md" @click="addEntry">
                                            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                            Add Entry
                                        </button>
                                        <!--<button class="btn btn-success btn-fw btn-icon-text mx-2" @click="ToObjectCode">
                                            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                            Add UACS
                                        </button>-->
                                    </div>

                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="ufstable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="width: 25%;">EXPENSE CLASS</th>
                                                <th style="width: 35%;">UACS</th>
                                                <th style="width: 10%;">ALLOTMENT AMOUNT</th>
                                                <th style="width: 10%;">OBLIGATED AMOUNT</th>
                                                <th style="width: 10%;">BALANCE</th>
                                                <th style="width: 10%;">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(fsed, index) in fundSourceEntryData" :key="index">
                                                <tr>
                                                    <td>
                                                        <span @click="toggleDetails(index)" class="details-icon">
                                                            <font-awesome-icon
                                                                :icon="['fas', fsed.showDetails ? 'minus' : 'plus']" />
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <multiselect :options="ExpenseClass"
                                                            v-model="fsed.expense_class" :multiple="false"
                                                            :searchable="false" :custom-label="formatExpenseClass"
                                                            id="expense_class">
                                                        </multiselect>
                                                    </td>
                                                    <td>
                                                        <multiselect @update:modelValue="testUpdate" :options="uacsData"
                                                            v-model="fsed.uacs" track-by="id" label="code"
                                                            :multiple="false" :searchable="false" id="uacs" />

                                                    </td>
                                                    <!-- <td>{{ fsed.uacs }}</td> -->
                                                    <!-- <td>{{ fsed.allotment_amount }}</td> -->
                                                    <td>
                                                        <input type="text" v-model="fsed.allotment_amount"
                                                            class="form-control" placeholder="0.00">
                                                    </td>
                                                    <td>{{ fsed.obligated_amount }}</td>
                                                    <td>{{ fsed.balance }}</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-md"
                                                            @click="removeEntry(index)">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'eye']"></font-awesome-icon>
                                                            REMOVE
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr v-if="fsed.showDetails">
                                                    <td colspan="3"
                                                        style="background-color: #f5f5f5; text-align:right;"> PO NUMBER:
                                                    </td>
                                                    <td> 0 </td>
                                                    <td> 0 </td>
                                                    <td> 0 </td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                            <tr>
                                                <td colspan="2">TOTAL</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                    </div>

                </div>
                <FooterVue />
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import Multiselect from 'vue-multiselect';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';

import axios from 'axios';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faEye, faPaperPlane, faRotate, faMagnifyingGlass, faPlus, faLock, faArrowLeft, faMinus } from '@fortawesome/free-solid-svg-icons';
library.add(faEye, faPaperPlane, faRotate, faMagnifyingGlass, faPlus, faLock, faArrowLeft, faMinus); // Add icons to the library
export default {
    name: 'Fund Source',
    props: {
    },
    data() {
        return {
            fundSourcesData: {
                code: '',
                ppa: '',
                date_created: '',
                fund_name: '',
                particulars: '',
                legal_basis: '',
            },
            fundSourceEntryData: [],
            uacsData: [],
            ExpenseClass: [
                'ps',
                'mooe',
                'co',
                'fe'
            ],
        };
    },
    components: {
        Multiselect,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        FontAwesomeIcon,
    },
    computed: {
    },
    created() {
    },
    mounted() {
        this.fetchFundSourcesData();
        this.fetchFundSourceEntryData();
        this.fetchUACS().then(() => {
            this.fetchFundSourceEntryData();
        });
    },
    methods: {
        testUpdate(arg) {
            console.log('Update method called', arg);
            // Add your update logic here
        },
        formatExpenseClass(value) {
            const labels = {
                ps: 'Personnel Services',
                mooe: 'Maintenance and Other Operating Expenses',
                co: 'Capital Outlay',
                fe: 'Financial Expenses'
            };
            return labels[value] || value;
        },

        getExpenseClassName(value) {
            const match = this.ExpenseClass.find(item => item.value === value);
            return match ? match.name : value;
        },
        fetchFundSourcesData() {
            let id = this.$route.params.id;
            axios.get(`/api/fetchFundSourcesData/${id}`)
                .then(response => {
                    this.fundSourcesData = response.data[0];
                })
                .catch(error => {
                    console.error('Error fetching fund sources:', error);
                });
        },
        fetchFundSourceEntryData() {
            let id = this.$route.params.id;
            axios.get(`/api/fetchFundSourceEntryData/${id}`)
                .then(response => {
                    this.fundSourceEntryData = response.data.map(entry => {
                        const matchingUacs = this.uacsData.find(uacs => uacs.id === entry.uacs?.id || uacs.id === entry.uacs);
                        return {
                            ...entry,
                            uacs: matchingUacs || null,
                            showDetails: false,

                        };
                    });
                })
                .catch(error => {
                    console.error('Error fetching fund source entries:', error);
                });
        },
        fetchUACS() {
            return axios.get('/api/fetchUACS') // <-- return the Promise
                .then(response => {
                    this.uacsData = response.data;
                    console.log('UACS Data:', this.uacsData);
                })
                .catch(error => {
                    console.error('Error fetching UACS data:', error);
                });
        },
        addEntry() {
            this.fundSourceEntryData.push({
                id: Date.now(), // Temporary unique ID
                expense_class: '',
                uacs: null,
                allotment_amount: 0,
                obligated_amount: 0,
                balance: 0,
                showDetails: false,

            });
        },
        removeEntry(index) {
            this.fundSourceEntryData.splice(index, 1);
        },
        toggleDetails(index) {
            this.fundSourceEntryData[index].showDetails = !this.fundSourceEntryData[index].showDetails;
        },
        returnToObligation() {
            this.$router.push({ path: `/finance/budget/index` });

        },
        ToObjectCode() {
            this.$router.push({ path: `/finance/budget/object_code` });
        },
    },

}
</script>
