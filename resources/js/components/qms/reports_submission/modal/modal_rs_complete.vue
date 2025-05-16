<template>
    <div v-if="visible" class="modal-background"
        style="  position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1050;">
        <div class="modal" tabindex="1" style="display: block;">
            <div class="modal-dialog modal-xl" style="margin-top: 10%; max-width: 60%;">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Quality Procedure Code:</label>
                                            <input class="form-control typehead" type="input" v-model="formData.qp_code" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Period Covered:</label>
                                            <input class="form-control typehead" type="input" v-model="formData.qp_covered" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <TextAreaInput label="Remarks" v-model="formData.remarks" />
                                </div>

                                <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
                                    @click="close();">Close</button>

                                <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2" @click="saveChanges()"
                                    style="float: right;">
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
        formData: Object,

    },
    components: {
        TextInput,
        TextAreaInput,
        SelectInput,
        Multiselect
    },
    data() {
        // console.log(this.formData);
        return {
            logo: dilg_logo,
            // formData: { ...this.rfqData },  // Clone the data to edit within the modal
        };
    },
    methods: {
        saveChanges() {
            console.log(this.formData);
            this.$emit('complete', this.formData);  // Emit updated data to parent
            // this.$emit('close');  // Close modal
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
