<template>
    <div v-if="visible" class="modal-background">
        <div class="modal" tabindex="1" style="display: block;">
            <div class="modal-dialog modal-xl">
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
                                    <div class="col-md-4">
                                        <SelectInput label="Mode of Procurement" v-model="rfqData.mode_id" :value="rfqData.mode_id">
                                            <option value="1" data-id="1" data-value="1">Small Value Procurement</option>
                                            <option value="2" data-id="2" data-value="2">Shopping</option>
                                            <option value="3" data-id="3" data-value="3">NP Lease of Venue</option>
                                            <option value="4" data-id="4" data-value="4">Direct Contracting</option>
                                            <option value="5" data-id="5" data-value="5">Agency to Agency</option>
                                            <option value="6" data-id="6" data-value="6">Public Bidding</option>
                                            <option value="7" data-id="7" data-value="7">Not Applicable N/A</option>
                                        </SelectInput>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>RFQ Date</label>
                                            <input class="form-control typehead" type="datetime-local" v-model="rfqData.rfq_dateTime" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>RFQ Deadline</label>
                                            <input class="form-control typehead" type="datetime-local" v-model="rfqData.rfq_deadlineTime" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <TextAreaInput v-model="rfqData.particulars" :value="rfqData.particulars" label="Particulars" />
                                </div>

                                <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;" @click="close();">Close</button>

                                <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2" @click="saveChanges()" style="float: right;">
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

    },
    components: {
        TextInput,
        TextAreaInput,
        SelectInput,
        Multiselect
    },
    data() {
        // console.log(this.rfqData);
        return {
            logo: dilg_logo,
            // formData: { ...this.rfqData },  // Clone the data to edit within the modal
        };
    },
    methods: {
        saveChanges() {
            // console.log(this.rfqData);
            this.$emit('update', this.rfqData);  // Emit updated data to parent
            this.$emit('close');  // Close modal
        },
        close() {
            this.$emit('close');
        }
    }
};
</script>

<style>
/* Style for dimming the background */
.modal-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1050;
}

/* Style for centering the modal */
.modal-dialog {
    margin-top: 10%;
    max-width: 50%;
}

.selected img {
    border: 2px solid #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Custom styles for text overflow with ellipsis */
.multiselect__tags #modal_multi {
    display: flex;
    flex-wrap: wrap;
}

.multiselect__tag #modal_multi {
    display: inline-flex;
    align-items: center;
    min-width: 900px;
    max-width: 100%;
    flex: 1 0 auto;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin: 2px;
    padding: 0.25em 0.5em;
    border-radius: 4px;
    font-size: 0.875rem;
}

/* Responsive styling for small screens */
@media (max-width: 768px) {
    .modal-dialog {
        margin-top: 5%;
        max-width: 100%;
    }
    .multiselect__tag #modal_multi {
        max-width: 80%;
    }
}

.multiselect__tag span #modal_multi {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.multiselect__tag-icon #modal_multi {
    margin-left: 4px;
    flex-shrink: 0;
}
</style>
