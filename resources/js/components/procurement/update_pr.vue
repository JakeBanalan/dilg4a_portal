<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row justify-content-end" style="margin-right: 20px;">
                        <button type="button" class="btn btn-primary btn-md"
                            @click="exportPurchaseRequest"><font-awesome-icon :icon="['fas', 'download']" />
                            &nbsp;<b>Export</b></button> &nbsp; &nbsp;
                        <button type="button" class="btn btn-warning btn-md"
                            @click="updatePurchaseRequestDetails"><font-awesome-icon :icon="['fas', 'save']" />
                            &nbsp;<b>Update</b></button>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <label style="font-size: 20pt; color: red; display: flex; align-items: center;">
                                        <input type="checkbox" v-model="isUrgent" :true-value="1" :false-value="0"
                                            disabled style="display: none;">
                                        <span class="custom-checkbox"></span>
                                        Urgent
                                    </label>
                                    <div class="ribbon-top-right"></div>
                                    <div class="forms-sample">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Number:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    placeholder="Purchase Request Number"
                                                    v-model="purchaseRequestData.pr_no" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Office</label>
                                            <div class="col-sm-9">
                                                <select v-model="purchaseRequestData.office">
                                                    <option v-for="office in pmoList" :key="office.value"
                                                        :value="office.value">
                                                        {{ office.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Type</label>
                                            <div class="col-sm-9">
                                                <select v-model="purchaseRequestData.type">
                                                    <option v-for="PurchaseType in procurementType"
                                                        :key="PurchaseType.value" :value="PurchaseType.value">
                                                        {{ PurchaseType.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Date:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control"
                                                    v-model="purchaseRequestData.pr_date" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Target Date:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control"
                                                    v-model="purchaseRequestData.target_date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Particulars:</label>
                                            <div class="col-sm-9">
                                                <textarea id="tinyMceExample" rows="1"
                                                    v-model="purchaseRequestData.particulars"
                                                    placeholder="Enter Particulars"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <button type="button" class="btn btn-primary" style="float: left;"
                                        @click="showAddItemModal"><font-awesome-icon :icon="['fas', 'plus']" /> &nbsp;
                                        Add More Item</button>
                                    <br>
                                    <h3 style="float: right; font-size: 30px; font-weight: 900;">
                                        &nbsp; &nbsp;GRAND TOTAL: Php
                                        <span style="font-weight: bold;">
                                            ₱{{ grandTotal.toLocaleString('en-US', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            }) }}
                                        </span>
                                    </h3>
                                    <br><br>
                                    <div class="forms-sample">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Stock Number</th>
                                                    <th>Unit</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total Cost</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in items" :key="index">
                                                    <td>{{ item.stockno }}</td>
                                                    <td>{{ item.unit }}</td>
                                                    <td>{{ item.name }}</td>
                                                    <td>{{ item.descrip }}</td>
                                                    <td>{{ item.qty }}</td>
                                                    <td>₱{{ item.price?.toLocaleString('en-US', {
                                                        minimumFractionDigits:
                                                            2, maximumFractionDigits: 2
                                                    }) }}</td>
                                                    <td>₱{{ (item.qty * item.price)?.toLocaleString('en-US', {
                                                        minimumFractionDigits: 2, maximumFractionDigits: 2
                                                    }) }}</td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm"
                                                            @click="showEditItemModal(index)">Edit</button>
                                                        <button class="btn btn-danger btn-sm"
                                                            @click="deleteItem(index)">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--ADD ITEM MODAL-->
                        <div class="modal demo-modal" v-if="addItemModalVisible" id="addEditModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div
                                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 45%;">
                                            <img :src="logo" style="width:60px; height:60px;">
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <h1>Add More Item</h1>
                                            <div class="form-group">
                                                <label>Item Name</label>
                                                <v-select :options="availableItems" v-model="addMoreItem"
                                                    @change="addMoreItemList" label="name">
                                                    <template slot="option" slot-scope="option">
                                                        {{ option.name }}
                                                    </template>
                                                </v-select>
                                            </div>
                                            <div class="form-group">
                                                <label>Unit</label>
                                                <input type="text" class="form-control" v-model="addMoreItem.unit"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" id="itemQuantity"
                                                    v-model.number="addMoreItem.qty" min="0">
                                            </div>
                                            <div class="form-group">
                                                <label>ABC</label>
                                                <input type="number" class="form-control" v-model="addMoreItem.price"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea rows="1" v-model="addMoreItem.descrip"
                                                    @keyup.enter="addItem"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light"
                                            @click="closeAddItemModal">Cancel</button>
                                        <button type="button" class="btn btn-primary" @click="addNewItem">Add More
                                            Item</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--EDIT ITEM MODAL-->
                        <div class="modal demo-modal" v-if="editItemModalVisible" id="viewEditModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div
                                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 45%;">
                                            <img :src="logo" style="width:60px; height:60px;">
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <h1>Edit Item</h1>
                                            <div class="form-group">
                                                <label for="editItemName">Item Name</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="editItemUnit">Unit</label>
                                                <input type="text" class="form-control" id="editItemUnit"
                                                    v-model="editItem.unit" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="editItemQuantity">Quantity</label>
                                                <input type="number" class="form-control" id="editItemQuantity"
                                                    v-model="editItem.quantity">
                                            </div>
                                            <div class="form-group">
                                                <label for="editItemPrice">ABC</label>
                                                <input type="number" class="form-control" id="editItemPrice"
                                                    v-model="editItem.price" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="editItemDescription">Description</label>
                                                <textarea rows="1" id="editItemDescription"
                                                    v-model="editItem.descrip"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light"
                                            @click="closeEditItemModal">Cancel</button>
                                        <button type="button" class="btn btn-primary" @click="updateItem">Update
                                            Item</button>
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
import showAddItemModal from "./modal_addItem.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faSpinner, faCartShopping, faListCheck, faPesoSign, faSave } from '@fortawesome/free-solid-svg-icons';
import dilg_logo from "../../../assets/logo.png";
import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import dtable from "../procurement/table.vue";
import UserInfo from "../procurement/user_info.vue";
import StatBox from "../procurement/stat_board.vue";
import vSelect from 'vue-select';
import axios from "axios";
import { toast } from "vue3-toastify";

library.add(faSpinner, faCartShopping, faListCheck, faPesoSign, faSave);

export default {
    name: "update_pr",
    components: {
        FontAwesomeIcon,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        dtable,
        UserInfo,
        showAddItemModal,
        StatBox,
        dilg_logo,
        vSelect
    },
    data() {
        return {
            logo: dilg_logo,
            modalVisible: false,
            addItemModalVisible: false,
            editItemModalVisible: false,
            status: null,
            abc: 0,
            purchaseRequestData: {
                pmo: null,
                type: null,
                pr_date: null,
                target_date: null,
                particulars: null,
                pr_no: null,
                office: null,
                is_urgent: 0,

            },
            procurementType: [
                { value: '1', label: 'Catering Services' },
                { value: '2', label: 'Meals, Venue and Accomodation' },
                { value: '3', label: 'Repair and Maintenance' },
                { value: '4', label: 'Supplies, Materials and Devices' },
                { value: '5', label: 'Other Services' },
                { value: '6', label: 'Reimbursement and Petty Cash' }
            ],
            pmoList: [
                { value: '15', label: 'ORD' },
                { value: '1', label: 'ORD-Legal' },
                { value: '2', label: 'ORD-Planning' },
                { value: '3', label: 'LGMED-MBRTG' },
                { value: '4', label: 'LGCDD-PDMU' },
                { value: '5', label: 'FAD' },
                { value: '6', label: 'ORD-RICTU' },
                { value: '7', label: 'LGCDD' },
                { value: '8', label: 'LGMED' },
            ],
            addMoreItem: {
                id: null,
                name: '',
                qty: 0,
                price: 0,
                descrip: '',
                stockno: '',
                unit: ''
            },
            availableItems: [], // Populated by fetchItems
            editItem: { id: null, name: '', qty: 0, price: 0, descrip: '', stockno: '' },
            editIndex: -1,
            items: [],
            isLoading: false
        };
    },
    computed: {
        grandTotal() {
            return this.items.reduce((total, item) => {
                return total + (item.qty * item.price);
            }, 0);
        },
        isUrgent() {
            return this.purchaseRequestData ? this.purchaseRequestData.is_urgent : 0;
        }
    },
    mounted() {
        this.fetchPurchaseRequestData();
        this.fetchItems();
    },
    methods: {
        fetchItems() {
            this.isLoading = true;
            axios.get('/api/fetchItems')
                .then(response => {
                    if (Array.isArray(response.data)) {
                        this.availableItems = response.data;
                    } else {
                        console.error('Invalid response format:', response.data);
                    }
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        formatNumberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        fetchPurchaseRequestData() {
            const id = this.$route.query.id;
            axios.get(`../api/viewPurchaseRequest/${id}`)
                .then(response => {
                    // console.log("Fetched data:", response.data);
                    const data = response.data.purchaseRequest;
                    // console.dir(data);
                    // Assign other data
                    this.purchaseRequestData.pr_no = data.pr_no;
                    this.purchaseRequestData.office = data.office;
                    this.purchaseRequestData.type = data.type;
                    this.purchaseRequestData.pr_date = data.pr_date;
                    this.purchaseRequestData.target_date = data.target_date;
                    this.purchaseRequestData.particulars = data.particulars;
                    this.purchaseRequestData.is_urgent = data.is_urgent;
                    this.purchaseRequestData.qty = data.qty;
                    this.purchaseRequestData.desc = data.desc;
                    this.purchaseRequestData.stockno = data.serial_no;
                    this.purchaseRequestData.item_title = data.item_title;
                    this.purchaseRequestData.unit = data.unit;
                    this.purchaseRequestData.status = data.status;
                    this.purchaseRequestData.status_id = data.status_id;
                    this.abc = data.abc || 0;
                    this.items = response.data.pr_items.map(item => ({
                        stockno: item.serial_no,
                        unit: item.unit,
                        name: item.item_title,
                        descrip: item.description,
                        qty: item.qty,
                        price: item.price
                    }));
                })
                .catch(error => {
                    // console.error("There was an error fetching the purchase request data!", error);
                });
        },
        showAddItemModal() {
            this.addItemModalVisible = true;
        },
        closeAddItemModal() {
            this.addItemModalVisible = false;
        },
        addNewItem() {
            const selectedItem = this.availableItems.find(item => item.id === this.addMoreItem.id);
            if (selectedItem && this.addMoreItem.qty > 0) {
                this.items.push({ ...selectedItem, qty: this.addMoreItem.qty, descrip: this.addMoreItem.descrip });
                this.addMoreItem = { id: null, name: '', qty: 0, price: 0, descrip: '', stockno: '', unit: '' };
                this.closeAddItemModal();
            } else {
                alert('Please select an item and enter a valid quantity.');
            }
        },
        addMoreItemList() {
            const selectedItem = this.availableItems.find(item => item.id === this.addMoreItem.id);
            if (selectedItem) {
                this.addMoreItem.price = selectedItem.price;
                this.addMoreItem.stockno = selectedItem.stockno;
                this.addMoreItem.unit = selectedItem.unit;
            }
        },

        closeModal() {
            this.modalVisible = false;
        },
        exportPurchaseRequest() {
            window.location.href = `../api/export-purchase-request/${this.$route.query.id}?export=true`;
        },
        updatePurchaseRequestDetails() {
            axios.post(`../api/post_update_purchaseRequestDetailsForm`, {
                pr_id: this.$route.query.id,
                pmo: this.purchaseRequestData.pmo,
                type: this.purchaseRequestData.category,
                pr_date: this.purchaseRequestData.pr_date,
                target_date: this.purchaseRequestData.target_date,
                purpose: this.purchaseRequestData.particulars,
                step: 2
            }).then(() => {
                toast.success('Successfully added!', { autoClose: 100 });
            }).catch((error) => {
                console.error("There was an error updating the purchase request details!", error);
            });
        }
    },
};
</script>


<style>
.custom-checkbox {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-color: #fff;
    border: 2px solid red;
    border-radius: 4px;
    margin-right: 10px;
    position: relative;
    cursor: not-allowed;
}

.custom-checkbox::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12px;
    height: 12px;
    background-color: red;
    border-radius: 2px;
    opacity: 0;
}

input[type="checkbox"]:checked+.custom-checkbox::after {
    opacity: 1;
}
</style>
