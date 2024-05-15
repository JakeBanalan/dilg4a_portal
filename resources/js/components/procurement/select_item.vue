<style>
.select-option {
    height: 40px;
}

.date-option {
    height: 40px;
}

.container .card {
    height: auto;
    width: auto;
    background-color: #fff;
    position: relative;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    font-family: "Poppins", sans-serif;
    border-radius: 20px;
}

.container .card .form {
    width: 100%;
    height: 100%;
    display: flex;
}

.container .card .left-side {
    width: 35%;
    background-color: #304767;
    height: 100%;
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
    padding: 20px 30px;
    box-sizing: border-box;
}

/*left-side-start*/
.left-heading {
    color: #fff;
}

.steps-content {
    margin-top: 30px;
    color: #fff;
}

.steps-content p {
    font-size: 12px;
    margin-top: 15px;
}

.progress-barv2 {
    list-style: none;
    /*color:#fff;*/
    margin-top: 30px;
    font-size: 13px;
    font-weight: 700;
    text-align: left;
    counter-reset: container 0;
}

.progress-barv2 li {
    position: relative;
    margin-left: 40px;
    margin-top: 50px;
    counter-increment: container 1;
    color: #4f6581;
}

.progress-barv2 li::before {
    content: counter(container);
    line-height: 25px;
    text-align: center;
    position: absolute;
    height: 25px;
    width: 25px;
    border: 1px solid #4f6581;
    border-radius: 50%;
    left: -40px;
    top: -5px;
    z-index: 10;
    background-color: #304767;
}

.progress-barv2 li::after {
    content: "";
    position: absolute;
    height: 90px;
    width: 2px;
    background-color: #4f6581;
    z-index: 1;
    left: -27px;
    top: -70px;
}

.progress-barv2 li.active::after {
    background-color: #fff;
}

.progress-barv2 li:first-child:after {
    display: none;
}

/*.progress-barv2 li:last-child:after{*/
/*  display:none;  */
/*}*/
.progress-barv2 li.active::before {
    color: #fff;
    border: 1px solid #fff;
}

.progress-barv2 li.active {
    color: #fff;
}

.d-none {
    display: none;
}

/*left-side-end*/
.container .card .right-side {
    width: 100% !important;
    background-color: #fff;
    height: 100%;
    border-radius: 20px;
}

/*right-side-start*/
.main {
    display: none;
}

.active {
    display: block;
}

.main {
    padding: 10px;
}

.main small {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 2px;
    height: 30px;
    width: 30px;
    background-color: #ccc;
    border-radius: 50%;
    color: yellow;
    font-size: 19px;
}

.text {
    margin-top: 20px;
}

.congrats {
    text-align: center;
}

.text p {
    margin-top: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #cbced4;
}

.input-text {
    margin: 30px 0;
    display: flex;
    gap: 20px;
}

.input-text .input-div {
    width: 100%;
    position: relative;
}

input[type="text"] {
    width: 100%;
    height: 40px;
    border: none;
    outline: 0;
    border-radius: 5px;
    border: 1px solid #cbced4;
    gap: 20px;
    box-sizing: border-box;
    padding: 0px 10px;
}

select {
    width: 100%;
    height: 40px;
    border: none;
    outline: 0;
    border-radius: 5px;
    border: 1px solid #cbced4;
    gap: 20px;
    box-sizing: border-box;
    padding: 0px 10px;
}

.input-text .input-div span {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 14px;
    transition: all 0.5s;
}

.input-div input:focus~span,
.input-div input:valid~span {
    top: -15px;
    left: 6px;
    font-size: 10px;
    font-weight: 600;
}

.input-div span {
    top: -15px;
    left: 6px;
    font-size: 10px;
}

/* .buttons button {
  height: 40px;
  width: 100px;
  border: none;
  border-radius: 5px;
  background-color: #0075ff;
  font-size: 12px;
  color: #fff;
  cursor: pointer;
} */



.button_space {
    display: flex;
    gap: 20px;
}

.button_space button:nth-child(1) {
    background-color: #fff;
    color: #000;
    border: 1px solid#000;
}

.user_card {
    margin-top: 20px;
    margin-bottom: 40px;
    height: 200px;
    width: 100%;
    border: 1px solid #c7d3d9;
    border-radius: 10px;
    display: flex;
    overflow: hidden;
    position: relative;
    box-sizing: border-box;
}

.user_card span {
    height: 80px;
    width: 100%;
    background-color: #dfeeff;
}

.circle {
    position: absolute;
    top: 40px;
    left: 60px;
}

.circle span {
    height: 70px;
    width: 70px;
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px solid #fff;
    border-radius: 50%;
}

.circle span img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.social {
    display: flex;
    position: absolute;
    top: 100px;
    right: 10px;
}

.social span {
    height: 30px;
    width: 30px;
    border-radius: 7px;
    background-color: #fff;
    border: 1px solid #cbd6dc;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 10px;
    color: #cbd6dc;
}

.social span i {
    cursor: pointer;
}

.heart {
    color: red !important;
}

.share {
    color: red !important;
}

.user_name {
    position: absolute;
    top: 110px;
    margin: 10px;
    padding: 0 30px;
    display: flex;
    flex-direction: column;
    width: 100%;
}

.user_name h3 {
    color: #4c5b68;
}

.detail {
    /*margin-top:10px;*/
    display: flex;
    justify-content: space-between;
    margin-right: 50px;
}

.detail p {
    font-size: 12px;
    font-weight: 700;
}

.detail p a {
    text-decoration: none;
    color: blue;
}

.checkmark__circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: #7ac142;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #fff;
    stroke-miterlimit: 10;
    margin: 10% auto;
    box-shadow: inset 0px 0px 0px #7ac142;
    animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
}

.checkmark__check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes scale {

    0%,
    100% {
        transform: none;
    }

    50% {
        transform: scale3d(1.1, 1.1, 1);
    }
}

@keyframes fill {
    100% {
        box-shadow: inset 0px 0px 0px 30px #7ac142;
    }
}

.warning {
    border: 1px solid red !important;
}

/*right-side-end*/
@media (max-width: 750px) {
    .container {
        height: scroll;
    }

    .container .card {
        max-width: 350px;
        height: auto !important;
        margin: 30px 0;
    }

    .container .card .right-side {
        width: 100%;
    }

    .input-text {
        /* display: block; */
    }

    .input-text .input-div {
        /* margin-top: 20px; */
    }

    .container .card .left-side {
        display: none;
    }
}

.selected img {
    border: 2px solid #007bff;
    /* Change the border color as needed */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    /* Change the box shadow as needed */
}
.input-group {
    display: flex;
    align-items: center;
}

.input-group-addon {
    padding: 0 10px;
}
.cart-icon{
    font-size: 45px;
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
                                    <div class="input-group">
                                        <input type="text" v-model="searchValue" class="form-control" name=""
                                            id="" />
                                            
                                        <span class="input-group-addon">
                                            <font-awesome-icon class="cart-icon" :icon="['fas', 'cart-shopping']"></font-awesome-icon>
                                        </span>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <SelectInput label="Category" class="select-option">
                                                <option v-for="app in appCategory" :key="app.id" :value="app.item_category_title">{{ app.item_category_title }}</option>
                                            </SelectInput>
                                        </div>
                                        <div class="col-lg-4">
                                            <SelectInput label="Office" class="select-option">
                                                <option v-for="option in pmo" :key="option.value" :value="option.value">{{ option.label }}</option>
                                                </SelectInput>
                                        </div>
                                        <div class="col-lg-4">
                                            <SelectInput label="Mode of Procurement" class="select-option">
                                                <option v-for="option in mode" :key="option.value" :value="option.value">{{ option.label }}</option>

                                              </SelectInput>
                                        </div>
                                    </div>
                                    <!-- <div v-if="searchResultsCount !== null">
                                        <p>{{ searchResultsCount }} result(s) found.</p>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                        <div class="input-text">
                            <div class="input-div">
                                <div class="row" style="height: 500px;overflow-y:auto">
                                    <div class="col-lg-2 d-none d-lg-block" v-for="item in item_title" :key="item.id">
                                        <div :class="{ 'card mb-4': true, 'selected': isSelected(item.id) } "
                                            style="height: 70%;">
                                            <img @click="toggleItemSelection(item.id)" src="../../../assets/proc1.jpg"
                                                class="card-img-top" alt="Sunset Over the Sea" />
                                            <p style="text-align: center;margin-top:-40px;font-weight: bolder;"> {{
                                            item.sn }} <br>{{ shorten(item.item_title, 11) }} </p>
                                            <p style="margin-top: -10px;text-align:center">Php. {{ item.app_price }}</p>
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
    data() {
        return {
            appCategory:[],
            purchase_no: null,
            userId: null,
            isPurchaseNoEditable: true, // Set initially as editable
            searchResultsCount: null,
            formnumber: 0,
            searchValue: '',
            item_title: [],
            selectedItems: [],
            pr_data: [],

            tableColumns: ['serial_no', 'procurement', 'unit', 'description', 'app_price', 'action'],

            formData: Array.from({ length: 4 }, () => ({})),
            purchaseRequestData: {
                pmo: null,
                pr_type: null,
                pr_date: null,
                target_date: null,
                particulars: null
            },
          
            mode: [
                { value: '1', label: 'Small Value Procurement' },
                { value: '2', label: 'Shopping' },
                { value: '3', label: 'NP Lease of Venue' },
                { value: '4', label: 'Direct Contracting' },
                { value: '5', label: 'Agency to Agency' },
                { value: '6', label: 'Public Bidding' }
            ],
            pmo: [
                { value: '1', label: 'ORD' },
                { value: '2', label: 'FAD' },
                { value: '3', label: 'LGMED' },
                { value: '4', label: 'LGCDD' },
            ]
        };
    },
    // 
    created() {
        this.userId = localStorage.getItem('userId');
    },
    computed: {
        isSelected: function () {
            const selectedSet = new Set(this.selectedItems);
            return function (itemId) {
                return selectedSet.has(itemId);
            };
        },
        item_title: function () {
            var app_item = this.item_title;
            var searchValue = this.searchValue.trim().toLowerCase();

            if (!searchValue) {
                this.searchResultsCount = null;

                return app_item;
            }
            // Use Array.filter to filter items based on search criteria
            var filteredItems = app_item.filter(function (item) {
                return (
                    item.item_title.toLowerCase().indexOf(searchValue) !== -1 ||
                    item.sn.toLowerCase().indexOf(searchValue) !== -1
                );
            });

            this.searchResultsCount = filteredItems.length;
            return filteredItems;

        },
      

    },
    mounted() {
        this.fetchAppItem();
        this.filterByCategory();
    },

    methods: {
    //   filtering app item
    filterByCategory: async function () {
      try {
        const response = await axios.get('/api/app_category'); // Replace '/api/users' with your actual endpoint
        this.appCategory = response.data;
      }catch(error){
        console.error('Error fetching item:', error);

      }
    },
        shorten: function (string, len) {
            return string.substring(0, len + string.substring(len - 1).indexOf(' '));

        },

        toggleItemSelection(itemId) {
    // Check if the item is already selected
    const index = this.selectedItems.indexOf(itemId);
    if (index !== -1) {
        // If selected, remove it from the array
        this.selectedItems.splice(index, 1);
    } else {
        // If not selected, add it to the array
        this.selectedItems.push(itemId);
    }

    // Construct the query parameters for the route
    const queryParams = {
        item_id: itemId,
        pr_id: this.$route.params.id
    };

    // Use Vue Router to navigate to the target route with the query parameters
    this.$router.push({ path: '/procurement/add_app_details', query: queryParams });
},
        addPrItems(selectedItemIds) {
            // Call fetchPRId to get the ID
            this.fetchPRId().then((id) => {
                // Make an API call to your server to add the selected items to the database
                axios.post('/api/post_insert_pritem', {
                    id: id,
                    pr_no: this.purchase_no,
                    itemIds: selectedItemIds,
                    status: 1,
                    step: 3
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
            });
        },
        fetchAppItem() {
            axios
                .get('/api/appitems')
                .then(response => {
                    this.item_title = response.data;
                })
                .catch(error => {
                    console.log(error.response);
                });
        },
        fetchPRId() {
            const pr_no = this.$route.params.id;
            // Return the promise from axios.get
            return axios.get(`/api/get_purchase_request_details?pr_no=${pr_no}`)
                .then((response) => {
                    // Return the value from the response data
                    return response.data.id;
                })
                .catch((error) => {
                    console.error(error);
                    // Throw the error to propagate it to the next catch block if needed
                    throw error;
                });
        },
        removePrItems(selectedItemIds) {
            // Make an API call to your server to remove the selected items from the database
            axios.post('/api/post_remove_pritem', { itemIds: selectedItemIds })
                .then((response) => {
                    // Handle the success response
                    toast.success('Items removed from the database:', {
                        autoClose: 100
                    });
                })
                .catch((error) => {
                    // Handle the error
                    console.error('Error removing items from the database:', error);
                });
        },
        getSelectedItemCount() {
            return this.selectedItems.length;
        },
        //feth data
        fetchAppData() {
            let btn = null;
            axios.get('../api/fetchAppData').then((response) => {
                $('#item_table').DataTable({
                    retrieve: true,
                    data: response.data,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                    columns: [
                        { data: 'sn' },
                        {
                            data: 'item_category_title',
                            render: function (data, type, row) {
                                // Limit the item_category_title to 5 characters
                                if (type === 'display') {
                                    return data.length > 5 ? data.substr(0, 40) + '...' : data;
                                }
                                return data;
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            render: function (data) {
                                return '<label class="badge badge-success" @click="deletePid(' + data.id + ')">Add Item Description</label>';
                            },
                        },
                        { data: 'price' },
                        {
                            data: null,
                            orderable: false,
                            render: function (data) {
                                return '<label class="badge badge-success" @click="deletePid(' + data.id + ')">Add to Cart</label>';
                            },
                        },
                    ],
                });
            }).catch((error) => console.log(error));
        },
        nextStep() {
            if (!this.validateForm()) {
                return false;
            }

            if (this.formnumber < this.mainForms.length - 1) {
                this.formnumber++;
            }

        },
        fetchCartDetails() {
            this.fetchPRId().then((id) => {
                axios.post('/api/fetchCart', { id: id }).then((response) => {
                    $('#cart_table').DataTable({
                        retrieve: true,
                        data: response.data,
                        ordering: false,
                        paging: true,
                        pageLength: 10,
                        columns: [
                            { data: 'serial_no' },
                            {
                                data: 'procurement',
                                render: function (data, type, row) {
                                    // Limit the 'procurement' text to 40 characters and add ellipsis
                                    if (type === 'display') {
                                        return data.length > 40 ? data.substr(0, 40) + '...' : data;
                                    }
                                    return data;
                                },
                            }, { data: 'unit' },
                            { data: 'description' },
                            { data: 'app_price' },
                            // Edit button
                            {
                                data: null,
                                render: function (data, type, row) {
                                    if (type === 'display') {
                                        return '<button class="btn btn-sm btn-primary">Edit</button>';
                                    }
                                    return data;
                                },
                            }


                        ],
                    });
                }).catch((error) => console.log(error));
            });


        },
 
        //show data
        fetchPurchaseRequestDetails() {
            const pr_no = this.$route.params.id;
            // Return the promise from axios.get
            return axios.get(`/api/get_purchase_request_details?pr_no=${pr_no}`)
                .then((response) => {
                    // Update purchaseRequestData with the fetched values
                    this.purchaseRequestData.pmo = response.data.pmo;
                    this.purchaseRequestData.pr_type = response.data.type;
                    this.purchaseRequestData.pr_date = response.data.pr_date;
                    this.purchaseRequestData.target_date = response.data.target_date;
                    this.purchaseRequestData.particulars = response.data.purpose;
                })
                .catch((error) => {
                    console.log('Error fetching purchase request details:', error);
                });
        },
        //step 1
        savePurchaseNo() {
            // Check if purchase_no is not empty and the field is not editable
            if (this.purchase_no) {
                axios
                    .post('/api/post_insert_purchaseNo', {
                        pr_no: this.purchase_no,
                        status: 1,
                        step: 1,
                        user: this.userId,
                        updated_at: null,
                        created_at: null,
                    })
                    .then(() => {
                        toast.success('Successfully added!', {
                            autoClose: 100,
                        });

                        this.formnumber++;
                        setTimeout(() => {
                            this.$router.push({
                                name: 'Create Purchase Request Item with ID',
                                params: { id: this.purchase_no },
                            });
                        }, 2000); // Adjust the delay as needed
                    })
                    .catch((error) => {
                        // Handle error
                    });
            } else {
                // Show error message or handle validation failure
                toast.error('Please enter a valid Purchase Request No.');
            }
        },

        //step 2
        updatePurchaseRequestDetails() {
            axios.post('/api/post_update_purchaseRequestDetails', {
                pr_no: this.purchase_no,
                pmo: this.purchaseRequestData.pmo,
                type: this.purchaseRequestData.pr_type,
                pr_date: this.purchaseRequestData.pr_date,
                target_date: this.purchaseRequestData.target_date,
                purpose: this.purchaseRequestData.particulars,
                step: 2
            }
            ).then(() => {

                toast.success('Successfully added!', {
                    autoClose: 100
                });




            }).catch((error) => {

            })
        }
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        item_table,
        dtable,
        SelectInput
    },
};
</script>