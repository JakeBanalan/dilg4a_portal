<template>
    <div>
        <div class="container-scroller">
            <Navbar></Navbar>
            <div class="container-fluid page-body-wrapper">
                <Sidebar />
                <div class="main-panel">
                    <div class="content-wrapper">
                        <BreadCrumbs />
                        <div class="row">
                            <StatBox />

                            <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                                <div v-if="isCardVisible" class="mb-4">
                                    <AbstractInfo />
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title"
                                            style="display: flex; justify-content: space-between; align-items: center;">
                                            <h5 class="card-title">
                                                <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;
                                                Awarding of
                                                Supplier
                                            </h5>
                                            <div class="button-container">
                                               
                                                <button @click="toggleCard()"
                                                    class="btn btn-outline-primary btn-fw btn-icon-text">Advanced
                                                    Search</button>
                                                    <button @click="openModal()"
                                                    class="btn btn-outline-primary btn-fw btn-icon-text mr-2">Create Supplier
                                                    Quotation</button>
                                            </div>


                                        </div>


                                    </div>
                                </div>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="card-title"
                                            style="display: flex; justify-content: space-between; align-items: center;">
                                            <h5 class="card-title">
                                                <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;
                                                Supplier Quotation
                                            </h5>

                                            <button class="btn btn-outline-primary btn-fw btn-icon-text" @click="award(1)">Award</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-striped table-bordered table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <!-- Loop through each unique id and set it as table headers -->
                                                            <th v-for="(id, index) in Object.keys(appItems)"
                                                                :key="index">{{ id }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <!-- Loop through each quotation array and display the quotations -->
                                                            <td v-for="(quotations, id) in appItems" :key="id">
                                                                <ul>
                                                                    <li v-for="(quotation, index) in quotations"
                                                                        :key="index">{{ quotation}}</li>
                                                                </ul>
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
        </div>
        <SelectSupplierModal :visible="modalVisible" @close="closeModal" />

    </div>

</template>
<style>
.button-container {
    text-align: right;
}
.button-container button {
    float: right;
}
</style>
<script>

import Navbar from '../../../layout/Navbar.vue';
import Sidebar from '../../../layout/Sidebar.vue';
import FooterVue from '../../../layout/Footer.vue';
import BreadCrumbs from '../../../dashboard_tiles/BreadCrumbs.vue';
import StatBox from '../../stat_board.vue';
import Pagination from '../../Pagination.vue';
import AbstractInfo from "../panel/abstract_info.vue";
import SelectSupplierModal from "../modal/modal_select_supplier.vue";


import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faCircleCheck, faCircleInfo, faEye, faLayerGroup, faList, faPesoSign } from '@fortawesome/free-solid-svg-icons';
import TextAreaInput from '../../../micro/TextAreaInput.vue';


library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign);

export default {
    name: 'Awarding',
    data() {
        return {
            isCardVisible: false,
            modalVisible: false,
            suppliers: [], // Array to store supplier names
            appItems: []
        }
    },
    mounted() {
        this.fetch_supplier();
        this.fetch_supplier_quotation();



    },
    methods: {
        toggleCard() {
            this.isCardVisible = !this.isCardVisible;
        },
        openModal() {
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        fetch_supplier() {
            const requestData = {
                id: 1
            };

            axios.post(`../../api/fetch_supplier_title`, requestData)
                .then(response => {
                    this.suppliers = response.data;
                })
                .catch(error => {
                    console.error('Error fetching app item:', error);
                });
        },
        fetch_supplier_quotation() {
            const requestData = {
                id:  this.$route.query.id
            };

            axios.post(`../../api/fetch_supplier_quotation`, requestData)
                .then(response => {
                    const quotes = response.data;

                    // Initialize an empty object to store quotations grouped by supplier title
                    const appItems = {};

                    // Loop through the fetched data and group quotations by supplier title
                    quotes.forEach(quote => {
                        if (!appItems[quote.supplier_title]) {
                            appItems[quote.supplier_title] = [];
                        }
                        if(quote.winner == 1)
                        {
                            appItems[quote.supplier_title].push(quote.item_title + "-(Php " + quote.quotation + ")" + "- winner");
                        }else{
                            appItems[quote.supplier_title].push(quote.item_title + "-(Php " + quote.quotation + ")");

                        }
                    });

                    // Assign the transformed data to appItems
                    this.appItems = appItems;

                    // Extract supplier titles from the response data
                    this.suppliers = Object.keys(appItems);
                })
                .catch(error => {
                    console.error('Error fetching supplier quotations:', error);
                });
        },
        award(id) {
            const userId = localStorage.getItem('userId');

            axios.post('../../api/getSmallestQuotationsForItems', {
                rfq_id: 1, //dummy data

            }).then(() => {
                toast.success('Success! This request has been received!', {
                    autoClose: 2000
                });
                setTimeout(() => {
                    location.reload();
                }, 2000); // Adjust the delay as needed

            }).catch((error) => {

            })

        },

    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
        FontAwesomeIcon,
        AbstractInfo,
        StatBox,
        SelectSupplierModal
    },
}
</script>