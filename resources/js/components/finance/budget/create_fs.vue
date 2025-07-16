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

#fstable,
#fstable tr,
#fstable td {
    overflow: visible !important;
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
                                        <button class="btn btn-primary btn-fw btn-icon-text mx-2"
                                            @click="returnToObligation">
                                            <font-awesome-icon :icon="['fas', 'arrow-left']"></font-awesome-icon>
                                            Return
                                        </button>
                                        <button class="btn btn-success btn-fw btn-icon-text mx-2" @click="postFS()">
                                            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                            Save
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Allotmet/Sub Allotment No:</label>
                                            <input type="text" class="form-control" v-model="form.source"
                                                placeholder="Allotment/Sub Allotment No" />
                                            <!-- <multiselect :options="sub_allotment" v-model="selectedsub_allotment" :multiple="false" :searchable="false"
                                                track-by="value" label="name" placeholder="Select Sub Allotment"
                                                id="sub_allotment">
                                            </multiselect> -->
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label>MFO/ P/A/P:</label>
                                                <input type="text" class="form-control" v-model="form.ppa"
                                                    placeholder="MFO/ P/A/P" />
                                                <!-- <multiselect :options="mfo_pap" v-model="selectedmfo_pap" :multiple="false" :searchable="false"
                                                    track-by="value" label="name" placeholder="Select MFO/PAP"
                                                    id="mfo_pap">
                                                </multiselect> -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Date</label>
                                            <input type="date" v-model="form.date_created" class="form-control"
                                                placeholder="">
                                        </div>
                                    </div>

                                    <div class="row" style="padding-top:1%;">
                                        <div class="col-md-4">
                                            <label>Name:</label>
                                            <textarea rows="3" col="100" style="height:110px !important;"
                                                id="procedure_title" v-model="form.name"
                                                class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label>Particulars:</label>
                                                <textarea rows="3" col="100" style="height:110px !important;"
                                                    id="procedure_title" v-model="form.particulars"
                                                    class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Legal Basis</label>
                                            <input type="text" class="form-control" v-model="form.legal_basis"
                                                placeholder="Legal Basis" />
                                            <!-- <multiselect :options="legal_basis" v-model="selectedLegalBasis" :multiple="false" :searchable="false"
                                                track-by="value" label="name" placeholder="Select Legal Basis" id="mfo_pap">
                                            </multiselect> -->

                                        </div>
                                    </div>

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

import axios, { formToJSON } from 'axios';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faEye, faPaperPlane, faRotate, faMagnifyingGlass, faPlus, faLock, faArrowLeft } from '@fortawesome/free-solid-svg-icons';
library.add(faEye, faPaperPlane, faRotate, faMagnifyingGlass, faPlus, faLock, faArrowLeft); // Add icons to the library
export default {
    name: 'Fund Source',
    props: {
    },
    data() {
        return {
            form: {
                source: '',
                ppa: '',
                date_created: '',
                name: '',
                particulars: '',
                legal_basis: ''
            },
            selectedLegalBasis: null,
            selectedsub_allotment: null,
            selectedmfo_pap: null,
            sub_allotment: [
                { value: 'SR2024-01-0076', name: 'SR2024-01-0076' },
                { value: 'SR2024-07-1231', name: 'SR2024-07-1231' },
                { value: 'SR2024-07-1323', name: 'SR2024-07-1323' },
                { value: 'SR2024-09-1540', name: 'SR2024-09-1540' },
                { value: 'SR2024-09-1661', name: 'SR2024-09-1661' },
                { value: 'SR2024-11-2047', name: 'SR2024-11-2047' },
                { value: 'SR2024-11-2047', name: 'SR2024-11-2047' },
            ],
            mfo_pap: [
                { value: '310100200067000 - LGU Information Management Program', name: '310100200067000 - LGU Information Management Program' },
                { value: '310100200032000 - LAN, WAN and IP Telephony Expansion', name: '310100200032000 - LAN, WAN and IP Telephony Expansion' },
            ],
            legal_basis: [
                { value: 'RA 11975 REGULAR 2024 CONTINUING', name: 'RA 11975 REGULAR 2024 CONTINUING' },
                { value: 'RA 12116 REGULAR 2025 CURRENT', name: 'RA 12116 REGULAR 2025 CURRENT' },
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
    },
    methods: {
        returnToObligation() {
            this.$router.push({ path: `/finance/budget/index` });

        },
        async postFS() {
            const result = await Swal.fire({
                title: 'Do you want to continue?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Continue',
            });

            if (result.isConfirmed) {
                try {
                    const response = await axios.post('/api/postFundSource', {
                        source: this.form.source,
                        ppa: this.form.ppa,
                        date_created: this.form.date_created,
                        name: this.form.name,
                        particulars: this.form.particulars,
                        legal_basis: this.form.legal_basis
                    });
                    await Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        showConfirmButton: false,
                        timer: 1000
                    });

                    setTimeout(() => {
                        const id = response.data.id;
                        this.$router.push({ path: `/finance/budget/update_fs/${id}` });
                    }, 200);

                }catch (error) {
                    console.error('error saving data', error);
                    // Optionally, handle error.display or set this.errors if it's a 422
                }
            }
        }
    }
};
</script>
