<template>
    <div v-if="visible" class="modal-background">
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog" style="margin-top: 90px; display: flex; align-items: center;">
                <div class="modal-content" style="width: 100%; margin-bottom: 5%;">
                    <div class="modal-header" style="background-color: #059886;">
                        <div
                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color:#059886; color: #4cae4c; left: 43%;">
                            <img :src="logo" style="width:60px; height:60px;">
                        </div>


                    </div>
                    <div class="modal-body">
                        <h5 class="card-title">
                            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Insert Code for PR-{{
                                prNo }}
                        </h5>
                        <TextInput type="number" label="Code" iconValue="gear" v-model="availability_code" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary btn-fw btn-icon-text"
                            @click="closeModal()"> Cancel </button>
                        <button type="button" class="btn btn-outline-primary btn-fw btn-icon-text"
                            @click="insertCode()"> Post </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import dilg_logo from "../../../../assets/logo.png";
import { toast } from "vue3-toastify";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faEye, faGear, faList, faPaperPlane } from '@fortawesome/free-solid-svg-icons';
library.add(faEye, faPaperPlane, faGear, faList);

export default {
    props: {
        visible: Boolean,
        prNo: String,
        prId: Number
        // Other props...
    },

    data() {
        return {
            showDetailsModal: false, // Add a new property to control the visibility of the item details modal
            logo: dilg_logo,
            availability_code: '',


        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        insertCode() {
            if (!this.availability_code) {
                toast.error('Please enter a value for Availability Code', {
                    autoClose: 1500
                });
                return;
            }
            axios.post(`../api/post_addCode`, {
                id: this.prId,
                availability_code: this.availability_code
            })
                .then((response) => {
                    if (response.status === 200) {
                        toast.success('Availability Code successfully added!', {
                            autoClose: 1500,
                            onClose: () => location.reload()
                        });
                    } else {
                        toast.error('Failed to add Availability Code', {
                            autoClose: 1500
                        });
                    }
                })
                .catch((error) => {
                    toast.error('Error adding Availability Code', {
                        autoClose: 1500
                    });
                    console.error(error);
                })
        },

        // toGSS(id) {
        //     const userId = localStorage.getItem('userId');
        //     axios
        //         .post(`../api/updatePurchaseRequestStatus`, {
        //             id: id,
        //             status: 4,
        //             submitted_by_gss: userId,
        //             is_gss_submitted: true,
        //         })
        //         .then(() => {
        //             const updatedRequest = this.purchaseRequests.find((pr) => pr.id === id);
        //             if (updatedRequest) {
        //                 updatedRequest.isGSSSubmitted = true;
        //             }
        //             toast.success('Successfully submitted to the GSS!', {
        //                 autoClose: 2000, onClose: () => {
        //                     if (this.role === 'admin') {
        //                         this.loadData();
        //                     } else {
        //                         this.loadDataPerUser();
        //                     }
        //                 }
        //             });
        //         })
        //         .catch((error) => {
        //             console.error('Error updating status:', error);
        //             toast.error('Failed to submit to the GSS. Please try again.', {
        //                 autoClose: 2000, onClose: () => {
        //                     if (this.role === 'admin') {
        //                         this.loadData();
        //                     } else {
        //                         this.loadDataPerUser();
        //                     }
        //                 }
        //             });
        //         });
        // },
    },

};
</script>
