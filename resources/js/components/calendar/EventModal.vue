<template>
    <div v-if="visible" class="modal-background">
        <div class="modal" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-l">
                <div class="modal-content">
                    <div class="modal-header">
                        <div
                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 45%;">
                            <img :src="logo" style="width:60px; height:60px;">
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="formEvent">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Activity:</label>
                                    <div id="the-basics">
                                        <input class="form-control typeahead" type="text" id="title"
                                            v-model="eventDetails.title" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Activity Description:</label>
                                    <div id="the-basics">
                                        <textarea rows="3" col="100" style="height:100px !important;" id="description"
                                            class="form-control" v-model="eventDetails.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Start:</label>
                                            <div id="the-basics">
                                                <input class="form-control typeahead" type="date" id="start"
                                                    v-model="eventDetails.start">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>End:</label>
                                            <div id="the-basics">
                                                <input class="form-control typeahead" type="date" id="end"
                                                    v-model="eventDetails.end">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Venue:</label>
                                    <div id="the-basics">
                                        <input class="form-control typeahead" type="text" id="venue"
                                            v-model="eventDetails.venue">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Target Participants:</label>
                                            <div id="the-basics">
                                                <select class="form-control-sm form-control"
                                                    v-model="eventDetails.participants">
                                                    <option
                                                        v-for="(TargetParticipantsOpt, index) in TargetParticipantsOpt"
                                                        :key="index" :value="TargetParticipantsOpt.value">
                                                        {{ TargetParticipantsOpt.label }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>No. of Participants:</label>
                                            <div id="the-basics">
                                                <input class="form-control typeahead" type="text"
                                                    v-model="eventDetails.enp" id="enp">
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
                                        <input class="form-control typeahead" type="text" v-model="eventDetails.postedBy" readonly id="postedBy">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
                                @click="closeModal">Close</button>
                            <button type="button" id="confirmButton" class="btn btn-success" style="float: right;"
                                @click="saveData">{{ mode === 'add' ? 'Add Event' : 'Save Event' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import dilg_logo from "../../../assets/logo.png";
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
            logo: dilg_logo,
            userId: null,
            TargetParticipantsOpt: [
                { value: 'Regional Office', label: 'Regional Office' },
                { value: 'Provincial Office', label: 'Provincial Office' },
                { value: 'HUC', label: 'HUC' },
                { value: 'C/MLGOO', label: 'C/MLGOO' },
                { value: 'LGA', label: 'LGA' },
                { value: 'NGA', label: 'NGA' },
                { value: 'Others', label: 'Others' }
            ],

        }
    },
    props: {
        visible: Boolean,
        mode: String,
        eventDetails: Object,
        posted_by:String
        // Other props... 
    },
    created() {
        this.userId = localStorage.getItem('userId');

    },
    mounted() {
       
    },
    methods: {
        closeModal() {
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
            this.$fetchUserData(this.userId, '../../../../api/fetchUser')
                .then(emp_data => {
                    this.eventDetails.postedBy = emp_data.name
                    axios.post('/api/post_create_event', {
                        postedby: this.userId,
                        office: emp_data.id,
                        title: this.eventDetails.title,
                        color: emp_data.DIVISION_COLOR,
                        start: this.eventDetails.start,
                        end: this.eventDetails.end,
                        description: this.eventDetails.description,
                        venue: this.eventDetails.venue,
                        participants: this.eventDetails.participants,
                        enp: this.eventDetails.enp,
                    }).then(() => {
                        this.showToatSuccess('Event added!');
                        setTimeout(() => {
                            location.reload();
                        }, 2000); // Adjust the delay as needed

                    }).catch((error) => {

                    })
                });

        },

    }
}

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
</style>
