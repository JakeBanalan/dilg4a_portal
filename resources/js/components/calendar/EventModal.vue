<template>
  <div v-if="visible" class="modal-background">
    <div class="modal fade show" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <div
              style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 45%;">
              <img :src="logo" style="width:60px; height:60px;">
            </div>
          </div>
          <div class="modal-body">
            <form class="form-sample">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Activity Title</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label" >Activity Description</label>
                          <div class="col-sm-10">
                            <textarea rows="3" col="100" style="height:100px !important;" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label"> <br>Activity Date</label>
                          <div class="col-sm-8">
                            <p class="card-description">
                              Start Date:
                            </p>
                            <input type="datetime-local" class="form-control"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-sm-8">
                            <p class="card-description">
                              End Date:
                            </p>
                            <input type="datetime-local" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Venue</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label"><br>Participants</label>
                          <div class="col-sm-8">
                            <p class="card-description">
                              Expected Number of Participants
                            </p>
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <!-- <label class="col-sm-4 col-form-label">Target Participants</label> -->
                          <div class="col-sm-8">
                            <p class="card-description">
                              Target Participants:
                            </p>
                            <select class="form-control-sm form-control">
                              <option>Regional Office</option>
                              <option>Provincial Office</option>
                              <option>HUC</option>
                              <option>C/MLGOOs</option>
                              <option>LGU</option>
                              <option>NGA</option>
                              <option>Others</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Posted By:</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
                  @click="close();">Close</button>
                <button type="button" class="btn btn-success" style="float: right;"
                  @click="">Save</button>
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
  data(){
    return {
      logo: dilg_logo
    }
  },
  props: {
    visible: Boolean
    // Other props...
  },
  methods: {
    close() {
      this.$emit('close');
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
  top:-6%;
  
  /* Adjust as needed */
}

.selected img {
  border: 2px solid #007bff;
  /* Change the border color as needed */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
  /* Change the box shadow as needed */
}
</style>