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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon
                                                :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Obligation
                                            Requests & Status
                                        </h5>
                                        <div class="d-flex">
                                            <button class="btn btn-primary btn-fw btn-icon-text mx-2"
                                                @click="createObligation()">
                                                <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                                Create
                                            </button>
                                            <button type="button" class="btn btn-primary btn-fw btn-icon-text mx-2"
                                                @click="toggleSearch">
                                                <font-awesome-icon
                                                    :icon="['fas', 'magnifying-glass']"></font-awesome-icon>
                                                Advanced Search
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered mb-3" id="obligationTable">
                                            <thead>
                                                <tr>
                                                    <th>TYPE</th>
                                                    <th>SERIAL NUMBER</th>
                                                    <th>PAYEE</th>
                                                    <th>PARTICULAR</th>
                                                    <th>AMOUNT</th>
                                                    <th>STATUS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="ob in ob_data" :key="ob.id">
                                                    <td>{{ ob.type.toUpperCase() }}</td>
                                                    <td>{{ ob.serial_no }}</td>
                                                    <td>{{ ob.supplier_title }}</td>
                                                    <td>{{ ob.purpose }}</td>
                                                    <td>₱ {{ ob.amount }}</td>
                                                    <td>{{ ob.status.toUpperCase() }}</td>
                                                    <td>
                                                        <button @click="viewObligation(ob.id)" class="btn btn-icon btn-success mr-1"
                                                            style=" align-items: center; justify-content: center; padding: 0.5em;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'eye']"></font-awesome-icon>
                                                        </button>
                                                        <button class="btn btn-icon btn-warning mr-1"
                                                            style=" align-items: center; justify-content: center; padding: 0.5em;">
                                                            <font-awesome-icon
                                                                :icon="['fas', 'download']"></font-awesome-icon>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
// import StatBox from '../stat_board.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCircleCheck, faCircleInfo, faDownload, faEye, faLayerGroup, faList, faPesoSign, faSearch, faUndo } from '@fortawesome/free-solid-svg-icons';
import { formatTotalAmount } from '../../../globalMethods';
import Pagination from '../../procurement/Pagination.vue';

library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign, faDownload, faSearch, faUndo);

export default {
    name: 'Obligation',
    data() {
        return {
            ob_data: [],
            modalVisible: false,
        };
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        // StatBox,
        Pagination
    },
    mounted() {
        this.fetchObligation();
    },
    computed: {
    },
    methods: {
        viewObligation(id) {
            this.$router.push({ path: `/finance/budget/update_obligation/${id}` });
        },
        fetchObligation() { //for testing purposes
            axios.get(`../../api/fetchObligation`)
                .then(response => {
                    // console.log(response.data);
                    this.ob_data = response.data;
                    this.initializeDataTable();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        initializeDataTable() {
            $('#obligationTable').DataTable().destroy(); // clean up
            this.$nextTick(() => {
                $('#obligationTable').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                });
            });
        },
        createObligation() {
            this.$router.push({ path: `/finance/budget/create_obligation` });
        },
    },
};
</script>
