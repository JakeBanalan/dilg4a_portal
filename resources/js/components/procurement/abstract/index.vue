<style>
.input-icons {
    width: 100%;
    margin-bottom: 10px;
}

.input-icons i {
    position: absolute;
}

.btn-custom {
    background-color: #059886;
    color: #fff;
}
td{
    text-align: center;
}
</style>x

<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <!-- <StatBox /> -->

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div v-if="isCardVisible">
                                <AbstractInfo />
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">


                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon
                                                :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Abstract of Quotation
                                        </h5>
                                        <div class="d-flex">
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                                @click="openModal()">
                                                Create Abstract
                                            </button>
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                                @click="toggleCard()">
                                                Advanced Search
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="max-width: 30px;">ACTIONS</th>
                                                    <th>STATUS</th>
                                                    <th>PURCHASE REQUEST #</th>
                                                    <th>REQUEST FOR QUOTATION #</th>
                                                    <th>ABSTRACT #</th>
                                                    <th>PURCHASE ORDER</th>
                                                    <th style="max-width: 100px;">P.O AMOUNT</th>
                                                    <th>OFFICE</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="abstract_data in displayedItems" :key="abstract_data.id">
                                                    <td style="width: 10%;">
                                                        <button class="btn btn-icon mr-1"
                                                            style="background-color:#059886;color:#fff;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'circle-check']"></font-awesome-icon>
                                                        </button>
                                                        <button class="btn btn-icon mr-1"
                                                            @click="view_abstract(abstract_data.rfq_id)"
                                                            style="background-color:#059886;color:#fff;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'eye']"></font-awesome-icon>

                                                        </button>
                                                        <button class="btn btn-icon mr-1" @click="exportAbstract(abstract_data.rfq_id)"
                                                            style="background-color:#059886;color:#fff;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'download']"></font-awesome-icon>

                                                        </button>
                                                    </td>
                                                    <td >
                                                        <div class="badge badge-success">{{ abstract_data.status }}
                                                        </div>
                                                    </td>

                                                    <td >
                                                        <b>{{ abstract_data.pr_no }}</b><br>~ PR Date: {{ abstract_data.pr_date }}~

                                                    </td>
                                                    <td > <b>{{ abstract_data.rfq_no }}</b><br> ~ RFQ Date: {{abstract_data.rfq_date}} ~</td>
                                                    <td > <b>{{ abstract_data.abstract_no }}</b><br> ~ Astract Date: {{abstract_data.abstract_date}} ~</td>
                                                    <td v-if="abstract_data.po_no" > <b>{{ abstract_data.po_no }}</b><br> ~ Purchase Order Date: {{abstract_data.po_date}} ~ </td>
                                                    <td v-else> <div class="badge badge-success" @click="create_po(abstract_data.rfq_id)">Create P.O</div> </td>
                                                    <td style="width: 100px;">
                                                        <font-awesome-icon :icon="['fas', 'peso-sign']" /> {{ this.$formatTotalAmount(abstract_data.po_amount) }}</td>
                                                    <td>{{ abstract_data.office }}</td>
                                                </tr>



                                            </tbody>
                                        </table>
                                        <Pagination :total="abstract_data.length" @pageChange="onPageChange" />

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <SelectSupplierModal :visible="modalVisible" @close="closeModal" />

    </div>
</template>


<script>
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
// import StatBox from '../stat_board.vue';
import UserInfo from '../../procurement/user_info.vue';
import Pagination from '../Pagination.vue';
import SelectSupplierModal from "./modal/modal_select_supplier.vue";
import AbstractInfo from "./panel/abstract_info.vue";

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faCircleCheck, faCircleInfo, faDownload, faEye, faLayerGroup, faList, faPesoSign } from '@fortawesome/free-solid-svg-icons';


library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign,faDownload);

export default {
    name: 'Abstract of Quotation',
    data() {
        return {
            modalVisible: false,
            abstract_no: null,
            abstract_data: [],
            supplier: [],
            currentPage: 1,
            itemsPerPage: 5,
            isCardVisible: false,
        }
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        UserInfo,
        Pagination,
        FontAwesomeIcon,
        SelectSupplierModal,
        AbstractInfo,
        // StatBox
    },
    computed: {

        totalPages() {
            return Math.ceil(this.abstract_data.length / this.itemsPerPage);
        },
        displayedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.abstract_data.slice(start, end);
        },
    },
    mounted() {
        this.load_abstract_data();
    },
    methods: {
        exportAbstract(rfq_id) {
            window.location.href = `../../api/export-abstract/${rfq_id}?export=true`;
        },
        create_po(id) {
            this.$router.push({ path: '/procurement/purchase-order/create', query: { id: id } });
        },
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
        },
        view_abstract(id) {
            this.$router.push({ path: '/procurement/abstract/quotation', query: { id: id } });
        },
        load_abstract_data() {
            axios.get(`../../api/load_abstract_data`)
                .then(response => {
                    this.abstract_data = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        onPageChange(page) {
            this.currentPage = page;
            // Fetch data for the new page
            this.loadData();
        },
        openModal() {
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
    }
}
</script>
