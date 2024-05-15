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
                    <input class="form-control typeahead" type="text" id="title" v-model="eventDetails.title"/>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label>Activity Description:</label>
                  <div id="the-basics">
                    <textarea rows="3" col="100" style="height:100px !important;" id="description" class="form-control" v-model="eventDetails.description" ></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <label>Start:</label>
                      <div id="the-basics">
                        <input class="form-control typeahead" type="datetime-local" id="start"  v-model="eventDetails.start">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <label>End:</label>
                      <div id="the-basics">
                        <input class="form-control typeahead" type="datetime-local" id="end" v-model="eventDetails.end">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label>Venue:</label>
                  <div id="the-basics">
                    <input class="form-control typeahead" type="text" id="venue" v-model="eventDetails.venue">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <label>Target Participants:</label>
                      <div id="the-basics">
                        <select class="form-control-sm form-control">
                          <option v-for="(TargetParticipantsOpt, index) in TargetParticipantsOpt" :key="index" :value="TargetParticipantsOpt.value">{{TargetParticipantsOpt.label}}</option>
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
                        <input class="form-control typeahead" type="text" v-model="eventDetails.enp" id="enp">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label>Posted By:</label>
                  <div id="the-basics">
                    <input class="form-control typeahead" type="text" v-model="eventDetails.postedBy" readonly id="postedBy">
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
              @click="closeModal">Close</button>
              <button type="button" id="confirmButton" class="btn btn-success" style="float: right;" @click="saveData">{{ mode === 'add' ? 'Add Event' : 'Save Event'}}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dilg_logo from "../../../assets/logo.png";
export default {
  data() {
    return {
      logo: dilg_logo,
      // eventDetails: this.value,
      TargetParticipantsOpt: [
        {value: 'Regional Office', label: 'Regional Office'},
        {value: 'Provincial Office', label: 'Provincial Office'},
        {value: 'HUC', label:'HUC'},
        {value: 'C/MLGOO',label:'C/MLGOO'},
        {value: 'LGA', label: 'LGA'},
        {value: 'NGA', label:'NGA'},
        {value: 'Others', label: 'Others'}
      ]
    }
  },
  props: {
    visible: Boolean,
    mode: String,
    eventDetails: Object
    // Other props...
  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
    saveData() {
      // You can perform validation here before saving the data
      // Once validated, you can emit an event to pass the form data to the parent component
      this.$emit('save', this.eventDetails);
      // console.log(this.eventDetails);
      // Optionally, you can reset the form after saving
      // this.resetForm();
    },
    // resetForm() {
    //   // Reset form fields to their initial state
    //   this.formData = {
    //     title: '',
    //     description: '',
    //     start: '',
    //     end: '',
    //     venue: '',
    //     targetParticipants: '',
    //     noOfParticipants: '',
    //     postedBy: ''
    //   };
    // }
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
