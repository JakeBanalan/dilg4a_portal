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
                    <div class="modal-body" style="max-height: 650px; overflow:scroll;">
                        <table id="user_table" style="width:100%" class="table table-striped table-bordered">
                            <thead>
                                <tr role="row">
                                    <th>CODE</th>
                                    <th>UACS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" v-model="code" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="uacs" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" style="float: right;margin-left:5px;"
                            @click="postObjectCode()">Save</button>
                        <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
                            @click="CloseModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>


</template>


<script>
import axios from "axios";
import dilg_logo from "../../../../assets/logo.png";
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
            logo: dilg_logo,
            code:'',
            uacs:''
        }
    },
    props: {
        visible: Boolean,
    },
    methods: {
        CloseModal() {
            this.$emit('close');
        },
        postObjectCode() {
            axios.post('/api/postObjectCode', {
                code: this.code,
                uacs: this.uacs
            })
            this.$emit('refresh');
        }
    }
}
</script>


<style>
.err-msg {
    font-style: italic;
    font-size: 4;
    color: red;
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
    /* z-index: 10502; */
    /* Ensure it's above other elements */
}

/* Style for centering the modal */
.modal-dialog {
    top: -6%;

    /* Adjust as needed */
}

.selected img {
    border: 2px solid #007bff;
    /* Change the border color as needed */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    /* Change the box shadow as needed */
}

div::-webkit-scrollbar {
    display: none;
}
</style>