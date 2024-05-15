<template>
    <div v-if="visible" class="modal-background">
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog" style="margin-top: 20px; display: flex; align-items: center;">
                <div class="modal-content" style="width: 150%; margin-bottom: 5%;">
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
                        <TextInput label="Code" iconValue="gear" v-model="code" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary btn-fw btn-icon-text"
                            @click="closeModal()"> Reset </button>
                        <button type="button" class="btn btn-outline-primary btn-fw btn-icon-text"
                            @click="insertCode()"> Continue </button>
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
            code: null,


        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        insertCode() {
            axios.post(`../api/post_addCode`, {
                id: this.prId,
                code: this.code
            }
            ).then(() => {
                toast.success('Availability Code successfully added!', {
                    autoClose: 100
                });
                location.reload();

            }).catch((error) => {

            })
        }
    },

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
    /* Adjust the opacity to make it darker or lighter */
    z-index: 1050;
    /* Ensure it's above other elements */
}

/* Style for centering the modal */
.modal-dialog {
    margin-top: 10%;
    /* Adjust as needed */
}

.selected img {
    border: 2px solid #007bff;
    /* Change the border color as needed */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    /* Change the box shadow as needed */
}

/* Style for dimming the background */
.modal-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Adjust the opacity to make it darker or lighter */
    z-index: 1050;
    /* Ensure it's above other elements */
}

/* Style for centering the modal */
.modal-dialog {
    margin-top: 10%;
    /* Adjust as needed */
}

/* You may need additional styles to customize the appearance of the modal */
</style>