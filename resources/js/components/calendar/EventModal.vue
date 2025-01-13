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
                        <form class="formEvent" @submit.prevent="validateForm">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Activity: <small class="err-msg" v-if="errors.title">{{ errors.title }}</small> </label>
                                    <div id="the-basics">
                                        <input  class="form-control typeahead" type="text" id="title"
                                            v-model="eventDetails.title" :disabled="isDisabled"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Activity Description: <small class="err-msg" v-if="errors.description">{{ errors.description }}</small></label>
                                    <div id="the-basics">
                                        <textarea rows="3" col="100" style="height:100px !important;" id="description"
                                            class="form-control" v-model="eventDetails.description"
                                            :disabled="isDisabled"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Start: <small class="err-msg" v-if="errors.start">{{ errors.start }}</small></label>
                                            <div id="the-basics">
                                                <input class="form-control typeahead" type="date" id="start"
                                                    v-model="eventDetails.start" :disabled="isDisabled" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>End: <small class="err-msg" v-if="errors.end">{{ errors.end }}</small></label>
                                            <div id="the-basics">
                                                <input class="form-control typeahead" type="date" id="end"
                                                    v-model="eventDetails.end" :disabled="isDisabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Venue: <small class="err-msg" v-if="errors.venue">{{ errors.venue }}</small></label>
                                    <div id="the-basics">
                                        <input class="form-control typeahead" type="text" id="venue"
                                            v-model="eventDetails.venue" :disabled="isDisabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Target Participants: <small class="err-msg" v-if="errors.remarks">{{ errors.remarks }}</small></label>
                                            <div id="the-basics">
                                                <multiselect
                                                    v-model="eventDetails.remarks" :options="TargetParticipantsOpt"
                                                    :multiple="true" :disabled="isDisabled" :searchable="false">
                                                </multiselect>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>No. of Participants: <small class="err-msg" v-if="errors.enp">{{ errors.enp }}</small></label>
                                            <div id="the-basics">
                                                <input class="form-control typeahead" type="text"
                                                    v-model="eventDetails.enp" id="enp" :disabled="isDisabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Posted By:</label>
                                    <div id="the-basics">
                                        <!-- <input class="form-control typeahead" type="text" readonly id="postedBy"> -->
                                        <input class="form-control typeahead" type="text"
                                            v-model="eventDetails.postedBy" readonly id="postedBy">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
                                @click="closeModal">Close</button>
                            <button type="submit" id="confirmButton" class="btn btn-success" style="float: right;"
                                :disabled="isDisabled">
                                {{ mode === 'add' ? 'Add Event' : 'Save Event' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>

import axios from "axios";
import dilg_logo from "../../../assets/logo.png";
import { toast } from "vue3-toastify";
import Multiselect from 'vue-multiselect'


export default {
    data() {
        return {
            logo: dilg_logo,
            userId: null,
            Author: null,
            hasInteracted: false,
            errors:{},
            TargetParticipantsOpt: ['Regional Office', 'Provincial Office', 'HUC', 'C/MLGOO', 'LGA', 'NGA', 'Others'],

        }
    },
    components: {
        Multiselect
    },
    props: {
        visible: Boolean,
        mode: String,
        eventDetails: Object,
        posted_by: String
        // Other props...
    },
    created() {
        this.userId = localStorage.getItem('userId');
        this.fetchAuthor();

    },
    mounted() {
        // console.log(this.posted_By);

    },
    computed: {
        isDisabled() {
            // console.log(this.Author);
            // console.log(this.eventDetails.postedBy);
            const res = this.Author != this.eventDetails.postedBy;
            // console.log('result', res)
            return res;
        },



    },
    methods: {
        validateForm(){
            this.errors = {};

            if(!this.eventDetails.title){
                this.errors.title = 'This Field is required';
            }

            if(!this.eventDetails.description){
                this.errors.description = 'This Field is required';
            }

            if(!this.eventDetails.start){
                this.errors.start = 'This Field is required';
            }

            if(!this.eventDetails.end){
                this.errors.end = 'This Field is required';
            }

            if(!this.eventDetails.venue){
                this.errors.venue = 'This Field is required';
            }

            if(this.eventDetails.remarks.length === 0){
                this.errors.remarks = 'This Field is required';
            }

            if(!this.eventDetails.enp){
                this.errors.enp = 'This Field is required';
            }

            if(Object.keys(this.errors).length === 0){
                try{
                    this.$emit('save', this.eventDetails);
                }catch(error){
                    if(error.response && error.response.data.errors){
                        this.errors = error.response.data.errors;
                    }
                }
            }
        },
        fetchAuthor() {
            const userId = localStorage.getItem('userId');
            this.$fetchUserData(userId, '../../../../api/fetchUser')
                .then(emp_data => {
                    this.Author = emp_data.name
                });
        },
        closeModal() {
            this.isDisabled = false;
            this.errors = {}
            this.$emit('close');
        },
        getUserInfo() {

        },
        showToatSuccess(message) {
            toast.success(message, {
                autoClose: 1000,
            });
        },
        saveData() {
            // console.log(this.eventDetails);
            // if(this.isValid){
            this.$emit('save', this.eventDetails);
            // }
        },
    }
}

</script>

<style>
.err-msg{
    font-style: italic;
    font-size: 4;
    color:red;
}
/* Style for dimming the background */
.modal-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
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
</style>
