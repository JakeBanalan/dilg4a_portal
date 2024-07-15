
<style>
.table-responsive-custom {
    display: block;
    -webkit-overflow-scrolling: touch;
}

.box-tools {
    position: absolute;
    right: 20px;
    top: 10px;
}
</style>
<template>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <Navbar></Navbar>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">


            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <Sidebar />
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-md-12 grid-margin mb-4 stretch-card">

                            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                                <div class="card card-tale">
                                    <div class="card-body">
                                        <p class="mb-4">APP Item Encoded</p>
                                        <p class="fs-30 mb-2">{{ this.appItem.app_total }}</p>
                                        <p>10.00% (as of today)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                                <div class="card card-dark-blue">
                                    <div class="card-body">
                                        <p class="mb-4">APP Item with same Stock No</p>
                                        <p class="fs-30 mb-2">61344</p>
                                        <p>22.00% (30 days)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                                <div class="card card-light-blue">
                                    <div class="card-body">
                                        <p class="mb-4">Newly Encoded App Item</p>
                                        <p class="fs-30 mb-2">34040</p>
                                        <p>2.00% (30 days)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                                <div class="card card-light-danger">
                                    <div class="card-body">
                                        <p class="mb-4">App Item without Office</p>
                                        <p class="fs-30 mb-2">47033</p>
                                        <p>0.22% (30 days)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin mb-4 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">Annual Procurement Plan for F.Y 2023</p>
                                    <div class="box-tools">
                                        <button @click="addAppItem()" type="button" class="btn btn-primary btn-icon-text">
                                            <i class="ti-plus btn-icon-prepend"></i>
                                            Create Item
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <div id="example_wrapper"
                                                    class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6"></div>
                                                        <div class="col-sm-12 col-md-6"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <app_table />
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
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <FooterVue />
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
</template>
<script>
import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import app_table from './app_table.vue';
import axios from 'axios';

export default {
    name: 'AnnualProcurementPlan',
    data() {
        return {
            appItem: {
                app_total: null
            }
        }
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        app_table,
    },
    mounted() {
        this.fetchAppData();
        this.$countTotalItem(2023).then(appItem => { this.appItem.app_total = appItem}).catch(error => { console.error('Error fetching totalitem data:',error)})


    },
    methods: {
        addAppItem() {
            this.$router.push("/procurement/add_app_item");
        },
   
        fetchAppData() {
            let btn = null;
            axios.get('../api/fetchAppData').then((response) => {
                $('#app_table').DataTable({
                    retrieve: true,
                    data: response.data,
                    ordering: false,
                    paging: true,
                    pageLength: 10,

                    columns: [
                        { data: 'sn' },
                        { data: 'item_category_title' },
                        { data: 'item_title' },
                        { data: 'pmo_title' },
                        { data: 'mode_of_proc_title' },
                        { data: 'source_of_funds_title' },
                        { data: 'price' },
                        { data: 'app_year' },
                        {
                            data: null, orderable: false, render: function (data) {
                                return '<label class="badge badge-info" @click="deletePid(' + data.id + ')">View</label>';
                            },
                        },

                    ],

                });
            })
            .catch((error) => console.log(error));

        },
    },

}
</script>