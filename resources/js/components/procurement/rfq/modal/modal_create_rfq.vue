`<template>
    <div v-if="visible" class="modal-background"
        style="  position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1050;">
        <div class="modal" tabindex="1" style="display: block;">
            <div class="modal-dialog modal-xl" style="margin-top: 10%; max-width: 80%;">
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
                                <!-- <MultiSelectInput label="Purchase Request Number" :op?tions="pr_no" v-model="pr_no" /> -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Purchase Request No <small class="err-msg" v-if="errors.pr_no">{{
                                                errors.pr_no }}</small></label>
                                            <multiselect id="PR_multi" v-model="selected" :options="options"
                                                label="label" :multiple="true" :searchable="false"></multiselect>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="inline-label" style="font-size: 0.875rem !important;">
                                            Mode of Procurement
                                            <small class="err-msg" v-if="errors.mode">{{ errors.mode }}</small>
                                        </label>
                                        <SelectInput v-model="selectedMode">
                                            <option value="1" data-id="Small Value Procurement" data-value="1">Small
                                                Value Procu rement
                                            </option>
                                            <option value="2" data-id="Shopping" data-value="2">Shopping</option>
                                            <option value="3" data-id="NP Lease of Venue" data-value="3">NP Lease of
                                                Venue</option>
                                            <option value="4" data-id="Direct Contracting" data-value="4">Direct
                                                Contracting</option>
                                            <option value="5" data-id="Agency to Agency" data-value="5">Agency to Agency
                                            </option>
                                            <option value="6" data-id="Public Bidding" data-value="6">Public Bidding
                                            </option>
                                            <option value="7" data-id="Not Applicable N/A" data-value="7">Not Applicable
                                                N/A</option>
                                        </SelectInput>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>RFQ Number <small class="err-msg" v-if="errors.rfq_no">{{
                                                errors.rfq_no }}</small></label>
                                            <input class="form-control typeahead" type="text" id="rfq_number"
                                                v-model="rfq_no" :readonly="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>RFQ Date <small class="err-msg" v-if="errors.rfq_date">{{
                                                errors.rfq_date
                                                    }}</small></label>
                                            <input class="form-control typehead" type="datetime-local"
                                                v-model="rfq_date" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>RFQ Deadline <small class="err-msg" v-if="errors.rfq_deadline">{{
                                                errors.rfq_deadline
                                                    }}</small></label>
                                            <input class="form-control typehead" type="datetime-local"
                                                v-model="rfq_deadline" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="inline-label">
                                        Particulars
                                        <small class="err-msg" v-if="errors.remarks">{{ errors.remarks }}</small>
                                    </label>
                                    <TextAreaInput v-model="remarks" />
                                </div>

                                <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
                                    @click="close();">Close</button>

                                <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                    @click="validateForm()" style="float: right;">
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import dilg_logo from "../../../../../assets/logo.png";
import TextInput from "../../../micro/TextInput.vue";
import SelectInput from "../../../micro/SelectInput.vue";
import Multiselect from 'vue-multiselect'
import TextAreaInput from "../../../micro/TextAreaInput.vue";
import { toast } from "vue3-toastify";
// import { toGss } from "../../../../globalMethods.js";

export default {
    props: {
        visible: Boolean,
        rfqNo: String, // Define rfqNo as a prop
        // Other props...
    },
    components: {
        TextInput,
        TextAreaInput,
        SelectInput,
        Multiselect

    },
    data() {
        return {
            showDetailsModal: false, // Add a new property to control the visibility of the item details modal
            logo: dilg_logo,
            rfq_no: null,
            selectedItems: [],
            pr_no: [],
            selected: [],
            options: [],
            errors: {},
            selectedMode: null,
            rfq_date: null,
            rfq_deadline: null,
            remarks: null

        }
    },

    mounted() {
        this.generateRFQ();
        this.fetchSubmittedPurchaseRequest();
    },

    methods: {
        validateForm() {
            this.errors = {};

            if (this.selected == 0) {
                this.errors.pr_no = 'This Field is required';
            }

            if (!this.selectedMode) {
                this.errors.mode = 'This Field is required';
            }

            if (!this.rfq_no) {
                this.errors.rfq_no = 'This Field is required';
            }

            if (!this.rfq_date) {
                this.errors.rfq_date = 'This Field is required';
            }

            if (!this.rfq_deadline) {
                this.errors.rfq_deadline = 'This Field is required';
            }

            if (!this.remarks) {
                this.errors.remarks = 'This Field is required';
            }

            if (Object.keys(this.errors).length === 0) {
                try {
                    this.post_create_rfq()
                    // this.$emit('save', this.eventDetails);
                } catch (error) {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                }
            }
        },
        post_create_rfq() {
            const userId = localStorage.getItem('userId');
            axios.post('../../api/post_create_rfq',
                {
                    pr_id_check: this.selected.map(item => item.value),
                    pr_id: `${this.selected.map(item => item.value).join(', ')}`,
                    rfq_no: this.rfq_no,
                    rfq_date: this.rfq_date,
                    rfq_deadline: this.rfq_deadline,
                    mode_id: this.selectedMode,
                    remarks: this.remarks,
                    created_by: userId
                }
            )
                .then(response => {
                    toast.success('RFQ successfully created!', {
                        autoClose: 1000
                    });
                    this.$emit('post');  // Emit updated data to parent
                    this.$emit('close');  // Close modal
                })
                .catch(error => {
                    console.error('error saving data', error);
                })

        },


        generateRFQ: async function () {
            try {
                const response = await axios.get('../../api/generateRFQNo');
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Adding 1 because months are zero-indexed
                const purchaseNoFormat = `${year}`;
                const rfq_no = response.data[0].rfq_count;
                const formattedSequence = rfq_no.toString().padStart(3, '0');

                // set the draft pr no of the user

                this.rfq_no = `${purchaseNoFormat}-${month}-${formattedSequence}`;

                // localStorage.setItem('prId', response.data.userId);

                //this.fetchCartDetails();
                // this.fetchPurchaseRequestDetails();
            } catch (error) {
                console.error('Error fetching data', error);
            }
        },

        async fetchSubmittedPurchaseRequest() {
            try {
                const response = await axios.get('../../api/fetchSubmittedPurchaseRequest');
                // Assuming response.data is an array of objects with 'label' and 'value' properties
                this.options = response.data.map(item => ({
                    label: `${item.pr_no} - ${item.purpose}`,
                    value: item.id
                }))
            } catch (error) {
                console.error('Error fetching submitted purchase requests:', error);
            }
        },

        show() {
            this.showDetailsModal = true;
        },

        close() {
            this.errors = {}
            this.$emit('close');
        },
    },
};
</script>


<style>
/* Style for dimming the background */
/* .modal-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1050;
} */

/* Style for centering the modal */
/* .modal-dialog {
    margin-top: 10%;
    max-width: 80%;
} */

.selected img {
    border: 2px solid #007bff;
    /* Change the border color as needed */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    /* Change the box shadow as needed */
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
    /* Critical: Prevent shrinking issues */
    max-width: 100%;
    /* Constrain to the parent's width */
    flex: 1 0 auto;
    /* Enable dynamic growth */
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
        /* Reduce tag width for smaller screens */
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

.inline-label {
    display: flex;
    align-items: center;
    gap: 8px;
    /* Adjust spacing between label and error */
    margin-bottom: -10px !important;
    /* Override default margin */
}

/* .err-msg {
  color: red;
  font-size: 0.85em;
} */

/* You may need additional styles to customize the appearance of the modal */
</style>`
