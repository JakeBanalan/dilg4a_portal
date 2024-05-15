<style>
.img-responsive {
    width: 100%;
    height: 100%;
}

input[type="number"] {
    height: 40px;
    /* Change this value to your desired height */
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title"><svg class="svg-inline--fa fa-list" aria-hidden="true"
                                                focusable="false" data-prefix="fas" data-icon="list" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path class="" fill="currentColor"
                                                    d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z">
                                                </path>
                                            </svg>&nbsp;{{ this.app_data.procurement }} </h5>
                                        <div class="d-flex">
                                            <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                                @click="save_app_details()"> Add to
                                                Cart </button>
                                                <router-link :to="'/procurement/select_purchase_item/' + $route.query.pr_id" class="btn btn-outline-primary btn-fw btn-icon-text mx-2"> Continue shopping </router-link>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <img src="../../../assets/proc1.jpg" class="img-responsive" />
                                        </div>
                                        <div class="col-lg-8">
                                            <TextInput label="Item Title" iconValue="circle-question"
                                                v-model="this.app_data.serial_no" :value="this.app_data.serial_no"
                                                :readonly="true" />
                                            <TextInput label="Unit" iconValue="circle-question" v-model="this.app_data.unit_id"
                                                :value="this.app_data.unit" :readonly="true" />
                                            <TextInput label="Item Price" iconValue="circle-question"
                                                v-model="this.app_data.app_price" :value="this.app_data.app_price"
                                                :readonly="true" />
                                            <TextInput label="Quantity" iconValue="circle-question"
                                                v-model="this.quantity" :readonly="false" type="number" />
                                            <TextAreaInput label="Item Description" v-model="this.desc" />

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

<script>
import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import item_table from "./item_table.vue";
import dtable from "./table.vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faCartShopping } from '@fortawesome/free-solid-svg-icons';
import TextAreaInput from '../micro/TextAreaInput.vue';
import SelectInput from "../micro/SelectInput.vue";



library.add(faCartShopping);

export default {
    name: 'Add Item Details',
    data() {
        return {
            app_data: [],
            desc: null,
            unit: null,
            prId: null,
            itemId: null,
            quantity: null
        }
    },
    created() {
        this.prId = this.$route.query.pr_id;
        this.itemId = this.$route.query.item_id;

    },
    mounted() {
        this.get_app_details();
    },
    methods: {
        get_app_details: async function () {
            try {

                axios.get(`../api/get_app_details/${this.itemId}}`).then((res) => {
                    this.app_data = res.data;
                });
            } catch (error) {
                console.error('Error fetching app details:', error);
            }
        },
        save_app_details() {
            axios.post('../api/post_insert_pritem', {
                pr_id: this.prId,
                itemIds: this.itemId,
                description: this.desc,
                unit:this.app_data.unit_id,
                quantity:this.quantity,
                app_price:this.app_data.app_price
            })
                .then((response) => {
                    // Handle the success response
                    toast.success('Items added to the database:', {
                        autoClose: 100
                    });
                })
                .catch((error) => {
                    // Handle the error
                    console.error('Error adding items to the database:', error);
                });

        }
    },


    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        item_table,
        dtable,
        SelectInput,
        TextAreaInput
    },
};
</script>