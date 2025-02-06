<template>
    <div v-if="visible" class="modal-background">
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog" style="margin-top: 5%; display: flex; align-items: center;">
                <div class="modal-content" style="width: 150%; margin-bottom: 5%;">
                    <div class="modal-header">
                        <div
                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 44%;">
                            <img :src="logo" style="width:60px; height:60px;">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <TextInput label="Control Number" iconValue="hashtag" :value="control_no"
                                            disabled />
                                    </div>
                                    <div class="col-lg-6">
                                        <TextInput label="Requested By" iconValue="user" :value="requested_by"
                                            disabled />
                                    </div>
                                    <div class="col-lg-6">
                                        <TextInput type="text" label="Request Date" :value="formatDate(request_date)"
                                            iconValue="calendar" style="height: 40px;" disabled />
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <TextInput type="datetime-local" label="Completed Date(Required)"
                                            iconValue="calendar" v-model="completed_date" :min="currentDateTime"
                                            style="height: 40px;" />
                                    </div>
                                </div>
                                <TextInput label="Office" iconValue="building" :value="office" disabled />

                                <TextInput label="Type of Request" iconValue="gear" :value="request_type" />

                                <TextAreaInput label="Recommendation" v-model="recommendation" />

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-primary btn-fw btn-icon-text" @click="complete_ict_ta()"
                            :disabled="!isValidDate(completed_date)">Save</button>
                        <button class="btn btn-outline-primary btn-fw btn-icon-text" @click="close()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import dilg_logo from "../../../../assets/logo.png";
import TextInput from "../../micro/TextInput.vue";
import TextAreaInput from "../../micro/TextAreaInput.vue";
import axios from 'axios'; // Import Axios library
import { toast } from "vue3-toastify";

export default {
    name: 'modal_complete_ta',
    data() {
        return {
            logo: dilg_logo,
            cid: null,
            completed_date: null,
            recommendation: null
        };
    },
    props: {
        visible: Boolean,
        id: Number,
        control_no: String,
        requested_by: String,
        request_date: String,
        office: String,
        request_type: String,
        sub_request_type: String
    },
    components: {
        TextInput,
        TextAreaInput
    },
    computed: {
        currentDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    },
    methods: {
        isValidDate(date) {
            if (!date) return false;
            const dateParts = date.split('-');
            const year = parseInt(dateParts[0], 10);
            const month = parseInt(dateParts[1], 10);
            const day = parseInt(dateParts[2], 10);
            if (year < 1 || month < 1 || month > 12 || day < 1 || day > 31) return false;
            return true;
        },
        formatDate(date) {
            if (!date || date === '0000-00-00') {
                return null; // Return null if the date is null or '0000-00-00'
            } else {
                const formattedDate = new Date(date).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',

                });
                return formattedDate;
            }
        },
        close() {
            this.$emit('close');
        },
        complete_ict_ta() {
            axios.post('/api/post_complete', {
                id: this.id,
                completed_date: this.completed_date,
                recommendation: this.recommendation
            })
                .then(response => {
                    toast.success('Success! This request has been completed!', {
                        autoClose: 2000
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2100);
                })
                .catch(error => {
                    // Handle error
                    console.error('Error saving data:', error);
                });
        }
    }
};
</script>
