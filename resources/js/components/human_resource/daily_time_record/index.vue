<style lang="scss" scoped>

</style>

<template>
    <div class="container-scroller">
      <Navbar />
      <div class="container-fluid page-body-wrapper">
        <Sidebar />
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Select 2</h4>
                  
                  <div class="form-group">
                    <label>Single select box using select 2</label>
                    <select class="js-example-basic-single w-100">
                      <option value="AL">Alabama</option>
                      <option value="WY">Wyoming</option>
                      <option value="AM">America</option>
                      <option value="CA">Canada</option>
                      <option value="RU">Russia</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Multiple select using select 2</label>
                    <select class="js-example-basic-multiple w-100" multiple="multiple">
                      <option value="AL">Alabama</option>
                      <option value="WY">Wyoming</option>
                      <option value="AM">America</option>
                      <option value="CA">Canada</option>
                      <option value="RU">Russia</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <FooterVue />
    </div>
  </template>
  
<script>
import $ from 'jquery';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';

export default {
    name: 'Employees_Directory',
    components: {
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Navbar,
    },

    mounted() {
    if ($(".js-example-basic-single").length) {
      $(".js-example-basic-single").select2();
    }
    if ($(".js-example-basic-multiple").length) {
      $(".js-example-basic-multiple").select2();
    }
  }

  
}
</script>

