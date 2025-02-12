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
                                    <p class="card-title">Annual Procurement Plan for F.Y {{ currentYear }}</p>
                                    <div class="box-tools">
                                        <button @click="addAppItem()" type="button"
                                            class="btn btn-primary btn-icon-text">
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

                <FooterVue />

            </div>

        </div>
        <div class="modal fade" id="app-modal" tabindex="-1" role="dialog" aria-labelledby="app-modal-label"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title">Edit Item</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ModalBodyComponent ref="modalBodyComponent" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="handleSaveButton()">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import app_table from './app_table.vue';
import axios from 'axios';
import vSelect from 'vue-select';
import { toast } from 'vue3-toastify';
import ModalBodyComponent from './ModalBodyComponent';

export default {
    name: 'AnnualProcurementPlan',

    data() {
        return {
            currentYear: new Date().getFullYear(),
            appItem: {
                app_total: null
            },
            stockNumber: null
        }
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        app_table,
        vSelect,
        ModalBodyComponent
    },
    mounted() {
        this.fetchAppData();
        this.$countTotalItem(2023).then(appItem => { this.appItem.app_total = appItem }).catch(error => { console.error('Error fetching totalitem data:', error) })


    },

    methods: {

        addAppItem() {
            this.$router.push("/procurement/add_app_item");
        },
        async fetchAppData(appYear = new Date().getFullYear()) {
            try {
                const response = await axios.get(`../api/fetchAppData`, { params: { appYear } });
                this.populateTable(response.data);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },

        populateTable(data) {
            if ($.fn.DataTable.isDataTable('#app_table')) {
                $('#app_table').DataTable().clear().rows.add(data).draw();
            } else {
                $('#app_table').DataTable({
                    retrieve: true,
                    data: data,
                    ordering: false,
                    paging: true,
                    filter: true,
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
                            data: null,
                            orderable: false,
                            render: function (data) {
                                return `<button class="btn btn-info edit-btn" data-id="${data.app_id}">Edit</button>`;
                            },
                        },
                    ],
                    columnDefs: [
                        { targets: [0, 1, 3, 4, 5, 6, 7], searchable: false },
                    ],
                });
            }
            $(document).on('click', '#app-modal .close, #app-modal .btn-secondary', function () {
                $('#app-modal').modal('hide');
            });

            this.handleViewButton();
        },

        handleViewButton() {
            $('#app_table').on('click', '.edit-btn', (event) => {
                var appId = $(event.target).data('id');
                axios.get(`../api/fetchAppDataById`, {
                    params: { appId }
                })
                    .then((response) => {
                        this.populateModal(response.data);
                    })
                    .catch((error) => {
                        console.error('Error fetching data:', error);
                    });
            });
        },
        populateModal(data) {
            this.id = data.app_id;
            this.$refs.modalBodyComponent.populateModal(data);
            $('#app-modal').modal('show');
        },
        handleSaveButton() {
            // Get the data from the ModalBodyComponent
            const modalBody = this.$refs.modalBodyComponent;

            if (!modalBody) {
                toast.error('Error: Modal body not found');
                return;
            }

            // Extract data
            const data = {
                id: modalBody.id,
                sn: modalBody.sn,
                code: modalBody.itemCode,
                merge_code: modalBody.merge_code,
                item_title: modalBody.itemTitle,
                unit_id: modalBody.unitTile,  // Now storing the correct ID
                source_of_funds_id: modalBody.sourceOfFundsTitle,  // Correct ID
                category_id: modalBody.itemCategory,  // Correct ID
                pmo_id: modalBody.pmoTitle,  // Correct ID
                qty: modalBody.itemQty,
                mode: modalBody.modeOfProcTitle,  // Correct ID
                app_price: modalBody.price,
                remarks: modalBody.remarks,
                description: modalBody.description,
            };

            if (!data.id) {
                toast.error("Error: Item ID is missing.");
                return;
            }

            // Send update request
            axios.post(`../api/updateAppDataById/${data.id}`, data)
                .then(async (response) => { // Make function async for better timing
                    toast.success(response.data.message, { autoClose: 1000 });

                    // Ensure the modal is hidden first before fetching new data
                    $('#app-modal').modal('hide');

                    // Add a small delay before fetching the updated data
                    await new Promise(resolve => setTimeout(resolve, 500));

                    // Fetch the latest data
                    this.fetchAppData();
                })
                .catch((error) => {
                    if (error.response) {
                        if (error.response.status === 404) {
                            toast.error('Error: App item not found.', { autoClose: 1000 });
                        } else if (error.response.status === 500) {
                            toast.error('Server Error: ' + error.response.data.message, { autoClose: 1000 });
                        } else {
                            toast.error('Unexpected error: ' + error.response.data.message, { autoClose: 1000 });
                        }
                    } else {
                        toast.error('Network Error: ' + error.message, { autoClose: 1000 });
                    }
                    console.error('Error updating App item:', error);
                });
        }


    },

}
</script>
