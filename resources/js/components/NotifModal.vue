<template>
    <div v-if="visible" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Change Password Required</h5>
           
          </div>
          <div class="modal-body">
            <p>Please change your password before proceeding to the dashboard.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" @click="changePassword">Proceed</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      visible: {
        type: Boolean,
        required: true
      }
    },
    methods: {
      changePassword() {
        const userId = localStorage.getItem('userId');

        this.$router.push(`/settings/update/${userId}`);
      }
    }
  };
  </script>
  
  <style scoped>
  .modal {
    display: block;
    background: rgba(0, 0, 0, 0.5);
  }
  </style>
  