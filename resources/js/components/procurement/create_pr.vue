<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="modal demo-modal" v-if="modalVisible">
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
                                        <h1>Do you wish to continue with Purchase Request No:</h1>
                                        <h2> <span style="color: #007bff;">{{ purchase_no }}</span>?</h2>
                                        <div class="details">
                                            <div><span>END-USER:</span> {{ userData.name }}</div>
                                            <div><span>OFFICE :</span> {{ userData.pmo_title }}</div>
                                            <div><span>Region :</span> REGION IV-A - CALABARZON</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light"
                                        @click="cancelAndRedirect">Cancel</button>
                                    <button type="button" class="btn btn-primary" @click="proceedWithEncoding">
                                        <i class="icon-arrow-right"></i>&nbsp;Proceed to Encoding</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <button type="button" class="btn btn-primary btn-md" @click="post_create_pr"><font-awesome-icon
                                :icon="['fas', 'save']" /> &nbsp;<b>Saved & Proceed</b></button>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <label style="font-size: 20pt; color: red; display: flex; align-items: center;">
                                        <input type="checkbox" v-model="isUrgent" :true-value="1" :false-value="0"
                                            style="display: none;">
                                        <span class="custom-checkbox"></span>
                                        Urgent
                                    </label>
                                    <div class="ribbon-top-right"></div>
                                    <p class="card-description" style="color:red; font-size: 20pt;">* Required *</p>
                                    <div class="forms-sample">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Number:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="exampleInputUsername2"
                                                    placeholder="Purchase Request Number" v-model="purchase_no"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Office</label>
                                            <div class="col-sm-9">
                                                <select v-model="prData.pmo">
                                                    <option v-for="office in pmo" :key="office.value"
                                                        :value="office.value">{{ office.label }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Type</label>
                                            <div class="col-sm-9">
                                                <select v-model="prData.pr_type">
                                                    <option v-for="PurchaseType in pr_type" :key="PurchaseType.value"
                                                        :value="PurchaseType.value">{{ PurchaseType.label }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Date:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" v-model="prData.pr_date"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Target Date:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" v-model="prData.target_date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Particulars:</label>
                                            <div class="col-sm-9">
                                                <textarea id="tinyMceExample" rows="1" v-model="prData.particulars"
                                                    placeholder="Enter Particulars"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Item Table -->
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <button type="button" class="btn btn-primary" style="float: left;"
                                        @click="showAddItemModal"><font-awesome-icon :icon="['fas', 'plus']" /> &nbsp;
                                        Add Item</button>
                                    <br>
                                    <h3 style="float: right; font-size: 30px; font-weight: 900;">&nbsp; &nbsp;GRAND
                                        TOTAL: Php <span style="font-weight: bold;">₱{{ formattedGrandTotal }}</span>
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
                                                    <td>{{ item.quantity }}</td>
                                                    <td>₱{{ item.price.toFixed(2) }}</td>
                                                    <td>₱{{ (item.quantity * item.price).toFixed(2) }}</td>
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
                        <div class="modal demo-modal" v-if="addItemModalVisible" id="addItemModal">
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
                                            <h1>Add New Item</h1>
                                            <div class="form-group">
                                                <label>Item Name</label>
                                                <select class="form-control" id="itemName" v-model="newItem.id"
                                                    @change="updateItemPrice">
                                                    <option v-for="item in availableItems" :key="item.id"
                                                        :value="item.id">{{ item.name }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Unit</label>
                                                <input type="text" class="form-control" v-model="newItem.unit" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" id="itemQuantity"
                                                    v-model="newItem.quantity" min="0" @keyup.enter="addItem">
                                            </div>
                                            <div class="form-group">
                                                <label>ABC</label>
                                                <input type="number" class="form-control" id="itemPrice"
                                                    v-model="newItem.price" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea rows="1" v-model="newItem.descrip"
                                                    @keyup.enter="addItem"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light"
                                            @click="closeAddItemModal">Cancel</button>
                                        <button type="button" class="btn btn-primary" @click="addItem">Add Item</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--EDIT ITEM MODAL-->
                        <div class="modal demo-modal" v-if="editItemModalVisible" id="editItemModal">
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
                                                <select class="form-control" id="editItemName" v-model="editItem.id"
                                                    @change="updateEditItemPrice">
                                                    <option v-for="item in availableItems" :key="item.id"
                                                        :value="item.id">{{ item.name }}</option>
                                                </select>
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
import dilg_logo from "../../../assets/logo.png";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import Modal from "../modals/Modal.vue";
import item_table from "./item_table.vue";
import dtable from "./table.vue";
import axios from "axios";
import "vue3-toastify/dist/index.css";
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCircleCheck, faCircleInfo, faEye, faLayerGroup, faList, faPesoSign, faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import TextAreaInput from '../micro/TextAreaInput.vue';

library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign, faQuestionCircle);

export default {
    name: 'Create Purchase Request Item',
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        item_table,
        dtable,
        TextAreaInput,
        Modal,
        dilg_logo
    },
    data() {
        return {
            logo: dilg_logo,
            modalVisible: false,
            addItemModalVisible: false,
            editItemModalVisible: false,
            isUrgent: null,
            purchase_no: null,
            purchase_id: null,
            userData: {
                name: null,
                office: null,
            },
            prData: {
                pmo: null,
                pr_type: null,
                particulars: null,
                pr_date: new Date().toISOString().substr(0, 10),
                target_date: new Date().toISOString().substr(0, 10),
            },
            pmo: [
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
            pr_type: [
                { value: '1', label: 'Catering Services' },
                { value: '2', label: 'Meals, Venue and Accomodation' },
                { value: '3', label: 'Repair and Maintenance' },
                { value: '4', label: 'Supplies, Materials and Devices' },
                { value: '5', label: 'Other Services' },
                { value: '6', label: 'Reimbursement and Petty Cash' }
            ],
            newItem: { id: null, name: '', quantity: 0, price: 0, descrip: '', stockno: '', unit: '' },
            editItem: { id: null, name: '', quantity: 0, price: 0, descrip: '', stockno: '' },
            editIndex: -1,
            items: [],
            availableItems: []
        }
    },
    computed: {
        grandTotal() {
            return this.items.reduce((total, item) => total + (item.quantity * item.price), 0).toFixed(2);
        },
        formattedGrandTotal() {
            return this.formatNumberWithCommas(this.grandTotal);
        }
    },
    mounted() {
        this.generatePurchaseRequestNo();
        this.fetchEndUserInfo();
        this.fetchItems();
        setTimeout(() => {
            this.openModal();
        }, 1);
    },
    methods: {
        showToastSuccess(message) {
            toast.success(message, {
                autoClose: 1000,
            });
        },
        showToastError(message) {
            toast.error(message, {
                autoClose: 1000,
            });
        },
        formatNumberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        fetchItems() {
            axios.get('/api/fetchItems')
                .then(response => {
                    this.availableItems = response.data;
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                });
        },
        fetchEndUserInfo() {
            const userId = localStorage.getItem('userId');
            axios.get(`../../../api/fetchUser/${userId}`)
                .then((response) => {
                    this.userData = response.data
                }).catch(error => {
                    return null;
                });
        },
        async generatePurchaseRequestNo() {
            try {
                const response = await axios.get('../api/generatePurchaseRequestNo');
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                const purchaseNoFormat = `${year}-${month}`;
                const purchaseNoFromApi = response.data[0].pr_count;
                const formattedSequence = purchaseNoFromApi.toString().padStart(5, '0');

                this.purchase_no = this.$route.query.pr_no || `${purchaseNoFormat}-${formattedSequence}`;
                this.purchase_id = response.data[0].pr_count;
            } catch (error) {
                console.error('Error fetching data', error);
            }
        },
        post_create_pr() {
            const userId = localStorage.getItem('userId');
            const requestData = {
                created_by: userId,
                pr_no: this.purchase_no,
                pmo: this.prData.pmo,
                type: this.prData.pr_type,
                pr_date: this.prData.pr_date,
                target_date: this.prData.target_date,
                isUrgent: this.isUrgent ? 1 : 0,
                purpose: this.prData.particulars,
                items: this.items.map(item => ({
                    id: item.id,
                    quantity: item.quantity,
                    price: item.price,
                    description: item.descrip,
                    stockno: item.stockno,
                    unit: item.unit
                }))
            };

            axios.post('/api/post_create_purchaseRequest', requestData)
                .then((response) => {
                    this.showToastSuccess('Purchase request and items created successfully!');
                    setTimeout(() => {
                        window.location.href = '/procurement/index';
                    }, 1500);
                })
                .catch((error) => {
                    console.error('Error creating purchase request:', error);
                    this.showToastError('Error creating purchase request!');
                });
        },

        openModal() {
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        proceedWithEncoding() {
            this.closeModal();
        },
        cancelAndRedirect() {
            this.closeModal();
            window.location.href = '/procurement/index';
        },
        showAddItemModal() {
            this.addItemModalVisible = true;
        },
        closeAddItemModal() {
            this.addItemModalVisible = false;
        },
        addItem() {
            const selectedItem = this.availableItems.find(item => item.id === this.newItem.id);
            if (selectedItem && this.newItem.quantity > 0) {
                this.items.push({ ...selectedItem, quantity: this.newItem.quantity, descrip: this.newItem.descrip });
                this.newItem = { id: null, name: '', quantity: 0, price: 0, descrip: '', stockno: '', unit: '' };
                this.closeAddItemModal();
            } else {
                alert('Please select an item and enter a valid quantity.');
            }
        },
        showEditItemModal(index) {
            this.editIndex = index;
            this.editItem = { ...this.items[index] };
            this.editItemModalVisible = true;
        },
        closeEditItemModal() {
            this.editItemModalVisible = false;
        },
        updateItem() {
            if (this.editItem.id && this.editItem.quantity > 0) {
                this.items.splice(this.editIndex, 1, { ...this.editItem });
                this.editItemModalVisible = false;
            } else {
                alert('Please select an item and enter a valid quantity.');
            }
        },
        deleteItem(index) {
            this.showToastSuccess('Item successfully deleted.');
            this.items.splice(index, 1);
        },
        updateItemPrice() {
            const selectedItem = this.availableItems.find(item => item.id === this.newItem.id);
            if (selectedItem) {
                this.newItem.price = selectedItem.price;
                this.newItem.stockno = selectedItem.stockno;
                this.newItem.unit = selectedItem.unit;
            }
        },
        updateEditItemPrice() {
            const selectedItem = this.availableItems.find(item => item.id === this.editItem.id);
            if (selectedItem) {
                this.editItem.price = selectedItem.price;
                this.editItem.descrip = selectedItem.descrip;
                this.editItem.stockno = selectedItem.stockno;
                this.editItem.unit = selectedItem.unit;
            }
        }
    }
};
</script>

<style>
.custom-checkbox {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-color: #fff;
    border: 2px solid black;
    border-radius: 4px;
    margin-right: 10px;
    position: relative;
    pointer-events: none;
}

.custom-checkbox::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12px;
    height: 12px;
    background-color: black;
    border-radius: 2px;
    opacity: 0;
}

input[type="checkbox"]:checked+.custom-checkbox::after {
    opacity: 1;
}

select {
    width: 100%;
    height: 40px;
    border: none;
    outline: 0;
    border-radius: 5px;
    border: 1px solid #cbced4;
    box-sizing: border-box;
    padding: 0px 10px;
}

.modal.demo-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 5px;
    z-index: 1050;
    display: block;
    background-color: rgba(0, 0, 0, 0.5);
    overflow-y: auto;

}

.modal-dialog {
    margin: auto;
    position: relative;
    transform: translateY(20%);
}

.modal-content .container h1 {
    font-size: 2em;
    margin-bottom: 10px;
}

.modal-content .container h2 {
    font-size: 2em;
    color: #007bff;
    margin-bottom: 20px;
}

.modal-content .button {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 1em;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.modal-content .button i {
    margin-right: 5px;
}

.modal-content .details {
    text-align: left;
    margin-top: 20px;
}

.modal-content .details div {
    margin-bottom: 10px;
}

.modal-content .details div span {
    font-weight: bold;
}
</style>
