<template>
    <div v-if="visible" class="modal-background"
        style="position: fixed;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.5);z-index: 1050;">
        <div class="modal" tabindex="1" style="display: block;">
            <div class="modal-dialog modal-xl" style="  overflow: visible !important;margin-top: 5%;max-width: 30%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <div
                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 42%;">
                            <img :src="logo" style="width:60px; height:60px;">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <h1>Do you wish to proceed with the Purchase Order for Abstract No. <span
                                    style="color: #007bff;"></span>?</h1>
                            <div class="details">
                                <!-- <div><span>RFQ NO:</span>{{ prData.rfq_no }}</div> -->
                                <!-- <div><span>ABSTRACT NO :</span>{{ aoq_no }}</div> -->
                                <!-- <div><span>RFQ ID :</span>{{ prData.rfq_id }}</div> -->
                                <div><span>Purchas Order Number :</span>{{ po_no }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" @click="close">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="proceed">
                            <i class="icon-arrow-right"></i>&nbsp;Proceed to Encoding</button>
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
        rfq_no: String,
        id: String,
        prData: Object

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
            po_no: null,
        };
    },
    mounted() {
        this.generatePONo();
    },
    methods: {
        generatePONo: async function () {
            try {
                const response = await axios.get('../../api/generatePurchaseOrderNo');

                // Get current year and month
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed

                // Extract sequence number from response
                const sequence = response.data[0]?.abstract || 1; // Fallback to 1 if undefined
                const paddedSequence = String(sequence).padStart(3, '0');

                // Format PO number
                this.po_no = `${year}-${month}-${paddedSequence}`;
                // console.log("Generated PO No:", this.po_no);

            } catch (error) {
                console.error('Error generating PO number:', error);
            }
        },
        // proceed() {
        //     const rfq_id = this.prData.rfq_id;
        //     axios.post('/api/PostAbstract', {
        //         abstract_no: this.aoq_no,
        //         rfq_id: this.prData.rfq_id,
        //     })
        //         .then(response => {
        //             // Assuming the abstract ID is returned in response.data.abstract_id
        //             const abstract_id = response.data.abstract_id;
        //             const rfq_id = response.data.rfq_id;

        //             this.$router.push({
        //                 path: '/procurement/abstract',
        //                 query: { id: rfq_id, abstract: abstract_id }
        //             });

        //             this.$emit('close');  // Close modal
        //         })
        //         .catch(error => {
        //             console.error('Error posting abstract:', error);
        //         });
        // },
        close() {
            this.$emit('close');
        }
    }
};
</script>

<style>
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
