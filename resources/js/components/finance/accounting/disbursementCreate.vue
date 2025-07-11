<template>
    <Navbar />
    <div class="container-fluid page-body-wrapper">
        <Sidebar />
        <div class="main-panel">
            <div class="content-wrapper">
                <BreadCrumbs />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mt-12">
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>&nbsp;Create
                                        Disbursement
                                    </h5>
                                    <button class="btn btn-outline-secondary btn-fw btn-icon-text mx-2" @click="goBack">
                                        <font-awesome-icon :icon="['fas', 'arrow-left']"
                                            class="mr-2"></font-awesome-icon>Back
                                    </button>
                                </div>
                                <form @submit.prevent="createDisbursement">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card border-info">
                                                <div class="card-header bg-info text-white">Information</div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="payee">Payee</label>
                                                        <input type="text" id="payee" v-model="form.payee"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="particular">Particular</label>
                                                        <textarea id="particular" v-model="form.particular"
                                                            class="form-control"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="obligated_amount">Obligated Amount</label>
                                                        <input type="number" id="obligated_amount"
                                                            v-model="form.obligated_amount" class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="total_deductions">Total Deductions</label>
                                                        <input type="number" id="total_deductions"
                                                            v-model="form.total_deductions" class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="net_amount">Net Amount</label>
                                                        <input type="number" id="net_amount" v-model="form.net_amount"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-success">
                                                <div class="card-header bg-success text-white">DV and Deductions</div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="dv_number">DV Number</label>
                                                        <input type="text" id="dv_number" v-model="form.dv_number"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="dv_date">DV Date</label>
                                                        <input type="date" id="dv_date" v-model="form.dv_date"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tax">Tax</label>
                                                        <input type="number" id="tax" v-model="form.tax"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="gsis">GSIS</label>
                                                        <input type="number" id="gsis" v-model="form.gsis"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pagibig">PAGIBIG</label>
                                                        <input type="number" id="pagibig" v-model="form.pagibig"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="philhealth">PhilHealth</label>
                                                        <input type="number" id="philhealth" v-model="form.philhealth"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="other_payables">Other Payables</label>
                                                        <input type="number" id="other_payables"
                                                            v-model="form.other_payables" class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="remarks">Remarks</label>
                                                        <textarea id="remarks" v-model="form.remarks"
                                                            class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-12">
                                            <div class="card border-success">
                                                <div class="card-header bg-success text-white">LDDAP Entries</div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-fw btn-icon-text mt-2"
                                                            @click="addLDDAPEntry">
                                                            <font-awesome-icon :icon="['fas', 'plus']"
                                                                class="mr-2"></font-awesome-icon>Add LDDAP
                                                        </button>
                                                    </div>
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>LDDAP Number</th>
                                                                <th>LDDAP Date</th>
                                                                <th>LDDAP Balance</th>
                                                                <th>Disburse Amount</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(entry, index) in lddapEntries" :key="index">
                                                                <td><input type="text" v-model="entry.lddap_number"
                                                                        class="form-control" /></td>
                                                                <td><input type="date" v-model="entry.lddap_date"
                                                                        class="form-control" /></td>
                                                                <td><input type="number" v-model="entry.lddap_balance"
                                                                        class="form-control" /></td>
                                                                <td><input type="number" v-model="entry.disburse_amount"
                                                                        class="form-control" /></td>
                                                                <td>
                                                                    <button class="btn btn-danger btn-sm"
                                                                        @click="removeLDDAPEntry(index)">Remove</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">
                                        <font-awesome-icon :icon="['fas', 'save']" class="mr-2"></font-awesome-icon>Save
                                    </button>
                                    &nbsp;
                                    <button type="button" class="btn btn-success mt-3" @click="markAsPaid">
                                        <font-awesome-icon :icon="['fas', 'check']"
                                            class="mr-2"></font-awesome-icon>Paid
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <FooterVue />
        </div>
    </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faPlus, faArrowLeft, faSave, faCheck } from '@fortawesome/free-solid-svg-icons';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';

library.add(faPlus, faArrowLeft, faSave, faCheck);

export default {
    name: 'disbursementCreate',
    components: {
        FontAwesomeIcon,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs
    },
    data() {
        return {
            form: {
                payee: '',
                particular: '',
                obligated_amount: 0,
                total_deductions: 0,
                net_amount: 0,
                dv_number: '',
                remarks: '',
                tax: 0,
                gsis: 0,
                pagibig: 0,
                philhealth: 0,
                other_payables: 0,
            },


            lddapEntries: [],
        };
    },
    watch: {
        // Auto-update net amount if obligated or deductions change
        'form.obligated_amount': 'updateNetAmount',
        'form.total_deductions': 'updateNetAmount',
    },
    methods: {
        async createDisbursement() {
            // Validate required fields for the main form
            if (!this.form.dv_number || !this.form.dv_date || !this.form.payee || !this.form.particular || !this.form.net_amount) {
                alert('Please fill in all required fields in the main form.');
                return;
            }

            // Validate LDDAP entries
            for (const entry of this.lddapEntries) {
                if (!entry.lddap_number || !entry.lddap_date || entry.lddap_balance <= 0 || entry.disburse_amount <= 0) {
                    alert('Please ensure all LDDAP entries have valid data.');
                    return;
                }
            }

            try {
                const response = await axios.post('/api/finance/accounting/disbursement', {
                    ...this.form,
                    lddap_entries: this.lddapEntries,
                });
                alert(response.data.message);
                this.$router.push('/finance/accounting/disbursement');
            } catch (error) {
                console.error('Error creating disbursement:', error);
                if (error.response && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    alert(`Validation errors:\n${Object.values(errors).map(e => e.join(', ')).join('\n')}`);
                } else {
                    alert('Failed to create disbursement. Please check the form and try again.');
                }
            }
        },

        addLDDAPEntry() {
            this.lddapEntries.push({
                lddap_number: '',
                lddap_date: '',
                lddap_balance: 0,
                disburse_amount: 0,
            });
        },

        removeLDDAPEntry(index) {
            this.lddapEntries.splice(index, 1);
        },

        markAsPaid() {
            console.log('Marked as Paid');
        },

        goBack() {
            this.$router.push('/finance/accounting/disbursement');
        },

    },
};
</script>
