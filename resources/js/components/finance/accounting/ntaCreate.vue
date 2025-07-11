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
                                        NTA/NCA
                                    </h5>
                                    <button class="btn btn-outline-secondary btn-fw btn-icon-text mx-2" @click="goBack">
                                        <font-awesome-icon :icon="['fas', 'arrow-left']"
                                            class="mr-2"></font-awesome-icon>Back
                                    </button>
                                </div>
                                <form @submit.prevent="createNTA">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nta_number">NTA Number</label>
                                                <input type="text" id="nta_number" v-model="form.nta_number"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="saro_number">SARO Number</label>
                                                <input type="text" id="saro_number" v-model="form.saro_number"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="account_number">Account Number</label>
                                                <input type="text" id="account_number" v-model="form.account_number"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="quarter">Quarter</label>
                                                <select id="quarter" v-model="form.quarter" class="form-control"
                                                    required>
                                                    <option value="" disabled>Select option</option>
                                                    <option value="1Q">1Q</option>
                                                    <option value="2Q">2Q</option>
                                                    <option value="3Q">3Q</option>
                                                    <option value="4Q">4Q</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input type="number" id="amount" v-model="form.amount"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="particular">Particular</label>
                                                <textarea id="particular" v-model="form.particular" class="form-control"
                                                    required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <font-awesome-icon :icon="['fas', 'save']" class="mr-2"></font-awesome-icon>Save
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
import { faPlus, faArrowLeft, faSave } from '@fortawesome/free-solid-svg-icons';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';

library.add(faPlus, faArrowLeft, faSave);

export default {
    name: 'ntaCreate',
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
                nta_number: '',
                saro_number: '',
                account_number: '',
                particular: '',
                quarter: '',
                amount: 0,
            },
            rows: [], // Array to store dynamically added rows
        };
    },
    methods: {
        createNTA() {
            this.rows.push({ ...this.form }); // Add the current form data as a new row
            this.resetForm(); // Reset the form fields
        },
        resetForm() {
            this.form = {
                nta_number: '',
                saro_number: '',
                account_number: '',
                particular: '',
                quarter: '',
                amount: 0,
            };
        },
        goBack() {
            this.$router.push('/finance/accounting/nta'); // Navigate back to the NTA list
        },
    },
};
</script>
