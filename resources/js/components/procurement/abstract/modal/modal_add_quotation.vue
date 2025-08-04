<template>
    <div v-if="visible" class="modal-background"
        style="    position: fixed;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.5);z-index: 1050;">
        <div class="modal" tabindex="1" style="display: block;">
            <div class="modal-dialog modal-xl" style="  overflow: visible !important;margin-top: 10%;max-width: 80%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <div
                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 45%;">
                            <img :src="logo" style="width:60px; height:60px;">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Supplier</label>
                                            <!-- <SelectInput label="Supplier" v-model="rfqData.mode_id" :value="rfqData.mode_id"> -->
                                            <Multiselect :multiple="false" id="supplier.id"
                                                aria-placeholder="Select Supplier" :searchable="false"
                                                label="supplier_title" :options="supplier" track-by="id"
                                                v-model="selectedSuppliers">
                                            </Multiselect>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Quotation Date</label>
                                            <input class="form-control typehead" type="datetime-local" />
                                        </div>
                                    </div> -->
                                </div>

                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th colspan="1" rowspan="2" style="width:40%">DESCRIPTION</th>
                                                    <th colspan="1" rowspan="2" style="width:10%">QUANTITY</th>
                                                    <th colspan="1" rowspan="2" style="width:10%">UNIT</th>
                                                    <th colspan="1" rowspan="2" style="width:10%">ABC</th>
                                                    <th colspan="1" rowspan="2" style="width:10%">TOTAL ABC</th>
                                                    <th colspan="2" rowspan="1">PRICE OFFER FROM SUPPLIER</th>
                                                    <!-- <th colspan="1" rowspan="2" style="width:10%">BID WINNER?</th> -->
                                                </tr>
                                                <tr>
                                                    <th>OFFER PER ITEM</th>
                                                    <th>TOTAL OFFER</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in rfq_opts" :key="item.item_id">
                                                    <td style="text-align:left;">{{ item.description }}</td>
                                                    <td>{{ item.qty }}</td>
                                                    <td>{{ item.unit }}</td>
                                                    <td>{{ item.unit_cost }}</td>
                                                    <td>{{ item.total_abc }}</td>
                                                    <td><input type="text" v-model="SupplierOffer[item.item_id]"
                                                            class="bottom-border-input"></td>
                                                    <td><input type="text" v-model="SupplierTotalOffer[item.item_id]"
                                                            class="bottom-border-input"></td>
                                                    <!-- <td><input type="checkbox" class="rowCheckbox" /></td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
                                    @click="close();">Close</button>

                                <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                    @click="SaveQuotation()" style="float: right;">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import dilg_logo from "../../../../../assets/logo.png";
import TextInput from "../../../micro/TextInput.vue";
import SelectInput from "../../../micro/SelectInput.vue";
import Multiselect from 'vue-multiselect';
import TextAreaInput from "../../../micro/TextAreaInput.vue";
import { toast } from "vue3-toastify";

export default {
    props: {
        visible: Boolean,
        rfqData: Object,
        rfq_opts: Object,
        abstract_no: String,
        abstract_id: String

    },
    components: {
        TextInput,
        TextAreaInput,
        SelectInput,
        Multiselect
    },
    data() {

        return {
            logo: dilg_logo,
            supplier: [],
            selectedSuppliers: "",
            SupplierOffer: [],
            SupplierTotalOffer: [],
            supplier_id: "",
            rfq_id: "",
            offer: "", // offer
            totalOffer: "", // total offer
            // formData: { ...this.rfqData },  // Clone the data to edit within the modal
        };
    },
    mounted() {
        this.fetchSupplier();
    },
    methods: {
        fetchSupplier() {
            axios.get(`../../api/fetch_supplier_list`)
                .then(res => {
                    this.supplier = res.data;
                })
        },
        SaveQuotation() {
            const quotationData = [];
            Object.values(this.rfq_opts).forEach(item => {
                const offer = this.SupplierOffer[item.item_id] || 'N/A';
                const Totaloffer = this.SupplierTotalOffer[item.item_id] || 'N/A';
                const QData = {
                    abstract_id: this.abstract_id,
                    supplier_id: this.selectedSuppliers.id,
                    rfq_id: this.rfqData.rfq_id,
                    item_id: item.item_id,
                    offer: this.SupplierOffer[item.item_id],
                    total_offer: this.SupplierTotalOffer[item.item_id],
                    winner: false
                }
                quotationData.push(QData);
            });
            // console.log("Quotation Data",quotationData);

            this.$emit('submit_quotation', quotationData);

            this.$emit('close');

        },
        close() {
            this.$emit('close');
        }
    }
};
</script>

<style>
.bottom-border-input {
    border-radius: 0% !important;
    border: none !important;
    border-bottom: 2px solid #000 !important;
    /* Adjust color and thickness as needed */
    outline: none !important;
    /* Remove focus outline */
    padding: 5px 0 !important;
    /* Optional padding for better spacing */
    font-size: 16px !important;
    /* Adjust font size */
    width: 90% !important;
    /* Adjust width as needed */
    text-align: center !important;
    /* Center text */
}

.bottom-border-input:focus {
    border-bottom: 2px solid #059886 !important;
    /* Highlight color on focus */
}

.selected img {
    border: 2px solid #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Custom styles for text overflow with ellipsis */
.multiselect__tags {
    display: flex;
    flex-wrap: wrap;
}

.multiselect__tag {
    display: inline-flex;
    align-items: center;
    max-width: 150px;
    /* Adjust the width as needed */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin: 2px;
    /* Adjust margin as needed */
}

/* Responsive styling for small screens */
@media (max-width: 768px) {
    .modal-dialog {
        margin-top: 5%;
        max-width: 100%;
    }

    .multiselect__tag {
        max-width: 80%;
    }
}

.multiselect__tag span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.multiselect__tag-icon {
    margin-left: 4px;
    flex-shrink: 0;
}
</style>
