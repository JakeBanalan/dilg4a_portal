<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row justify-content-end" style="margin-right: 20px;">
                        <button type="button" class="btn btn-primary btn-md" @click="exportPurchaseRequest"
                            :disabled="isExporting">
                            <font-awesome-icon :icon="['fas', 'download']" />
                            &nbsp;<b>{{ isExporting ? 'Exporting...' : 'Export' }}</b>
                        </button> &nbsp; &nbsp;
                        <button v-if="isUpdateButtonVisible" type="button" class="btn btn-warning btn-md"
                            @click="updatePurchaseRequestDetails">
                            <font-awesome-icon :icon="['fas', 'save']" />
                            &nbsp;<b>Update</b>
                        </button>
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
                                                <input type="date" class="form-control" v-model="formattedPrDate"
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Purchase Request Target Date:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" v-model="formattedTargetDate" />
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
                                    <button v-if="isUpdateButtonVisible" type="button" class="btn btn-primary" style="float: left;"
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
                                    <div class="forms-sample table-responsive" style="max-height: auto;">
                                        <table class="table table-bordered" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Stock Number</th>
                                                    <th>Unit</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total Cost</th>
                                                    <th v-if="isUpdateButtonVisible">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in items" :key="item.id">
                                                    <td>{{ item.stockno }}</td>
                                                    <td>{{ item.unit }}</td>
                                                    <td>{{ item.name }}</td>
                                                    <td>{{ item.descrip }}</td>
                                                    <td>{{ item.qty }}</td>
                                                    <td>₱{{ item.unit_cost?.toLocaleString('en-US', {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2
                                                    }) }}</td>
                                                    <td>₱{{ item.abc?.toLocaleString('en-US', {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2
                                                    }) }}</td>
                                                    <td v-if="isUpdateButtonVisible">
                                                        <button class="btn btn-warning btn-sm"
                                                            @click="EditItemModal(item.id)">
                                                            <font-awesome-icon :icon="['fas', 'pen']" /> &nbsp;Edit
                                                        </button>
                                                        <button class="btn btn-danger btn-sm"
                                                            @click="removeList(item.id)">
                                                            <font-awesome-icon :icon="['fas', 'trash']" /> &nbsp;Delete
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

                    <!-- Status History Section -->
                    <div  class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Status History</h4>
                                    <div v-if="statusHistory.length" class="timeline">
                                        <div v-for="(history, index) in statusHistory" :key="index" class="timeline-item">
                                            <div class="timeline-badge" :class="getStatusBadgeClass(history.status_id)">
                                                <font-awesome-icon :icon="['fas', 'circle']" />
                                            </div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title">{{ history.label }}</h5>
                                                    <p><small class="text-muted">{{ formatDateTime(history.changed_at) }}</small></p>
                                                </div>
                                                <!-- <div class="timeline-body">
                                                    <p v-if="history.changed_by">Changed by: {{ history.changed_by }}</p>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="alert alert-info">
                                        No status history available.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Item Modal -->
                    <div class="modal" v-if="addItemModalVisible" id="addEditModal"
                        style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 5px; z-index: 1050; display: block; background-color: transparent; overflow-y: auto; width: 900px;">
                        <div class="modal-dialog"
                            style="margin: auto; position: relative; transform: translateY(15%);">
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
                                            <label>Item Name <span style="color: red;">*</span></label>
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
                                            <label>Quantity <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" id="itemQuantity"
                                                v-model.number="addMoreItem.qty" min="1"
                                                placeholder="Enter quantity">
                                        </div>
                                        <div class="form-group">
                                            <label>Unit Cost <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" v-model="addMoreItem.price"
                                                min="0.01" placeholder="Enter unit cost">
                                        </div>
                                        <div class="form-group">
                                            <label>Description <span style="color: red;">*</span></label>
                                            <textarea rows="1" v-model="addMoreItem.descrip"
                                                placeholder="Enter description"></textarea>
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

                    <!-- Edit Item Modal -->
                    <div class="modal" v-if="editItemModalVisible" id="viewEditModal"
                        style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 5px; z-index: 1050; display: block; background-color: transparent; overflow-y: auto; width: 900px;">
                        <div class="modal-dialog"
                            style=" margin: auto; position: relative; transform: translateY(15%);">
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
                                            <v-select :options="availableItems" v-model="editItem" label="name">
                                                <template #option="option">
                                                    {{ option.name }}
                                                </template>
                                            </v-select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editItemUnit">Unit</label>
                                            <input type="text" class="form-control" id="editItemUnit"
                                                v-model="editItem.unit" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="editItemQuantity">Quantity</label>
                                            <input type="number" class="form-control" id="editItemQuantity"
                                                v-model="editItem.qty">
                                        </div>
                                        <div class="form-group">
                                            <label for="editItemPrice">ABC</label>
                                            <input type="number" class="form-control" id="editItemPrice"
                                                v-model="editItem.unit_cost">
                                        </div>
                                        <div class="form-group">
                                            <label for="editItemDescription">Description</label>
                                            <textarea rows="1" id="editItemDescription"
                                                v-model="editItem.descrip"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" @click="closeEdit">Cancel</button>
                                    <button type="button" class="btn btn-primary" @click="editItemList">Update
                                        Item</button>
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
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSpinner, faCartShopping, faListCheck, faPesoSign, faSave, faCircle } from '@fortawesome/free-solid-svg-icons';
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

library.add(faSpinner, faCartShopping, faListCheck, faPesoSign, faSave, faCircle);

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
        vSelect,
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
                stat: null,
            },
            statusHistory: [], // Store status history
            procurementType: [
                { value: '1', label: 'Catering Services' },
                { value: '2', label: 'Meals, Venue and Accomodation' },
                { value: '3', label: 'Repair and Maintenance' },
                { value: '4', label: 'Supplies, Materials and Devices' },
                { value: '5', label: 'Other Services' },
                { value: '6', label: 'Reimbursement and Petty Cash' },
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
                unit: '',
            },
            availableItems: [],
            editItem: { id: null, name: '', qty: 0, price: 0, descrip: '', stockno: '' },
            editIndex: -1,
            items: [],
            isLoading: false,
            updatedItems: [],
            isExporting: false,
            isTemporary: [],
            role: null,
            userId: null,
        };
    },
    computed: {
        isUpdateButtonVisible() {
            return this.purchaseRequestData.stat !== 'WITH RFQ' && this.purchaseRequestData.stat !== 'AWARDED';
        },
        grandTotal() {
            return this.items.reduce((sum, item) => {
                return sum + (item.qty * item.unit_cost);
            }, 0);
        },
        isUrgent() {
            return this.purchaseRequestData ? this.purchaseRequestData.is_urgent : 0;
        },
        formattedPrDate: {
            get() {
                return this.formatDate(this.purchaseRequestData.pr_date);
            },
            set(value) {
                this.purchaseRequestData.pr_date = value;
            },
        },
        formattedTargetDate: {
            get() {
                return this.formatDate(this.purchaseRequestData.target_date);
            },
            set(value) {
                this.purchaseRequestData.target_date = value;
            },
        },
    },
    mounted() {
        this.fetchPurchaseRequestData();
        this.fetchItems();
    },
    created() {
        this.role = localStorage.getItem('user_role');
        this.userId = localStorage.getItem('userId');
    },
    methods: {
        showToastSuccess(message) {
            toast.success(message, {
                autoClose: 1000,
            });
        },
        formatDate(date) {
            if (!date) return '';
            const d = new Date(date);
            if (isNaN(d.getTime())) return '';
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
        formatDateTime(datetime) {
            if (!datetime) return '';
            const d = new Date(datetime);
            if (isNaN(d.getTime())) return '';
            return d.toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
        },
        getStatusBadgeClass(statusId) {
            const badgeClasses = {
                2: 'badge-primary', // SUBMITTED TO GSS
                3: 'badge-info', // RECEIVED BY GSS
                5: 'badge-primary', // SUBMITTED TO BUDGET
                6: 'badge-info', // RECEIVED BY BUDGET
                8: 'badge-primary', // SUBMITTED TO ORD
                9: 'badge-info', // RECEIVED BY ORD
                12: 'badge-primary', // AWARDED
            };
            return badgeClasses[statusId] || 'badge-warning';
        },
        getStatusName(statusId) {
            const statusMessages = {
                2: 'SUBMITTED TO GSS',
                3: 'RECEIVED BY GSS',
                4: 'APPROVED BY GSS',
                5: 'SUBMITTED TO BUDGET',
                6: 'RECEIVED BY BUDGET',
                7: 'APPROVED BY BUDGET',
                8: 'SUBMITTED TO ORD',
                9: 'RECEIVED BY ORD',
                10: 'APPROVED BY ORD',
                11: 'WITH RFQ',
                12: 'AWARDED',
                14: 'RETURNED BY GSS',
                15: 'RETURNED BY BUDGET',
                16: 'RETURNED BY ORD',
                17: 'CANCELLED',
            };
            return statusMessages[statusId] || 'DRAFT';
        },
        async fetchPurchaseRequestData() {
            const id = this.$route.query.id;
            axios
                .get(`../api/viewPurchaseRequest/${id}`)
                .then(response => {
                    const { purchaseRequest, prItems, statusHistory } = response.data;
                    this.purchaseRequestData = {
                        ...purchaseRequest,
                        pr_date: this.formatDate(purchaseRequest.pr_date),
                        target_date: this.formatDate(purchaseRequest.target_date),
                        stat: this.getStatusName(purchaseRequest.stat),
                    };
                    this.items = prItems.map(item => ({
                        id: item.id,
                        stockno: item.serial_no,
                        unit: item.unit,
                        name: item.item_title,
                        descrip: item.description,
                        qty: item.qty,
                        unit_cost: item.unit_cost,
                        abc: item.abc,
                    }));
                    this.statusHistory = statusHistory || [];
                })
                .catch(error => {
                    console.error('Error fetching purchase request data:', error);
                    toast.error('Failed to fetch purchase request data.', { autoClose: 1000 });
                });
        },
        fetchItems() {
            axios
                .get('/api/fetchItems', {
                    params: {
                        userId: this.userId,
                    },
                })
                .then(response => {
                    this.availableItems = response.data || [];
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                    this.availableItems = [];
                });
        },
        formatNumberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        showAddItemModal() {
            this.addItemModalVisible = true;
        },
        closeAddItemModal() {
            this.addItemModalVisible = false;
        },
        addNewItem() {
            const selectedItem = this.availableItems.find(item => item.id === this.addMoreItem.id);
            if (selectedItem && Number(this.addMoreItem.qty) > 0) {
                this.items.push({
                    id: selectedItem.id,
                    stockno: selectedItem.stockno,
                    unit: selectedItem.unit,
                    name: selectedItem.name,
                    descrip: this.addMoreItem.descrip,
                    qty: this.addMoreItem.qty,
                    unit_cost: this.addMoreItem.price,
                    abc: this.addMoreItem.qty * this.addMoreItem.price,
                });
                this.addMoreItem = { id: null, name: '', qty: 0, price: 0, descrip: '', stockno: '', unit: '' };
                this.closeAddItemModal();
            } else {
                alert('Please select an item and enter a valid quantity.');
            }
        },
        addMoreItemList() {
            const selectedItem = this.availableItems.find(item => item.id === this.addMoreItem.id);
            if (selectedItem) {
                this.addMoreItem.price = selectedItem.price || 0;
                this.addMoreItem.stockno = selectedItem.stockno;
                this.addMoreItem.unit = selectedItem.unit;
            }
        },
        EditItemModal(itemId) {
            const itemIndex = this.items.findIndex(item => item.id === itemId);
            if (itemIndex === -1) {
                console.error("Item not found for editing:", itemId);
                return;
            }
            this.editIndex = itemIndex;
            this.editItem = JSON.parse(JSON.stringify(this.items[itemIndex]));
            this.editItemModalVisible = true;
        },
        closeEdit() {
            this.editItemModalVisible = false;
            this.editItem = {};
        },
        editItemList() {
            const qty = Number(this.editItem.qty);
            if (this.editItem.id && qty > 0) {
                this.items.splice(this.editIndex, 1, { ...this.editItem });
                this.editItemModalVisible = false;
            } else {
                alert('Please select an item and enter a valid quantity.');
            }
        },
        updatePurchaseRequestDetails() {
            if (!this.purchaseRequestData.pr_date || !this.purchaseRequestData.target_date) {
                toast.error('Please provide valid dates for Purchase Request Date and Target Date.', { autoClose: 1000 });
                return;
            }

            axios
                .post('/api/post_update_purchaseRequest', {
                    pr_id: this.$route.query.id,
                    pmo: this.purchaseRequestData.office,
                    type: this.purchaseRequestData.type,
                    pr_date: this.purchaseRequestData.pr_date,
                    target_date: this.purchaseRequestData.target_date,
                    purpose: this.purchaseRequestData.particulars,
                    items: this.items.map(item => ({
                        id: item.id,
                        qty: item.qty,
                        price: item.unit_cost,
                        descrip: item.descrip || null,
                    })),
                })
                .then(response => {
                    toast.success('Purchase request and items updated successfully!', { autoClose: 1000 });
                    this.fetchPurchaseRequestData();
                })
                .catch(error => {
                    console.error('Error updating purchase request:', error);
                    toast.error('Failed to update purchase request and items. Please check the console for details.', { autoClose: 1000 });
                });
        },
        removeList(itemId) {
            const itemIndex = this.items.findIndex(item => item.id === itemId);
            if (itemIndex === -1) {
                console.error("Item not found for deletion:", itemId);
                return;
            }

            const item = this.items[itemIndex];

            if (!item.id || item.isTemporary) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This temporary item will be removed.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.items.splice(itemIndex, 1);
                        this.showToastSuccess('Temporary item removed.');
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'This item will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post('../api/deletePurchaseRequestItem', {
                            item_id: item.id,
                        })
                        .then(response => {
                            this.showToastSuccess('Item successfully deleted.');
                            this.items.splice(itemIndex, 1);
                        })
                        .catch(error => {
                            Swal.fire('Error', 'Failed to delete the item. Please try again.', 'error');
                        });
                }
            });
        },
        exportPurchaseRequest() {
            const purchaseRequestId = this.$route.query.id;
            this.isExporting = true;

            axios
                .get(`../api/export-purchase-request/${purchaseRequestId}`, {
                    responseType: 'blob',
                })
                .then((response) => {
                    const { data, headers } = response;
                    const fileName = headers['content-disposition']?.match(/filename="?(.+)"?/)?.[1] || 'PurchaseRequest.xlsx';
                    const blob = new Blob([data]);
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = fileName;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                    toast.success('Purchase request exported successfully!', { autoClose: 1000 });
                })
                .catch((error) => {
                    console.error('Error exporting purchase request:', error);
                    toast.error('Failed to export purchase request. Please try again.', { autoClose: 1000 });
                })
                .finally(() => {
                    this.isExporting = false;
                });
        },
    },
};
</script>

<style scoped>
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

#hover:hover {
    background-color: rgba(5, 152, 135, 0.258);
    cursor: pointer;
}

.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 20px;
    width: 4px;
    background: #ddd;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-badge {
    position: absolute;
    left: 12px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.timeline-panel {
    margin-left: 50px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.timeline-title {
    margin: 0;
    font-size: 16px;
    font-weight: 500;
}

.timeline-body p {
    margin: 5px 0;
}
</style>
