<style>
.card-title{
  color: #059886;
}

</style>
<template>
  <div class="card">
    <div class="card-body">
   
      <div class="card">
        <div class="card-body">
          <p class="card-title">
            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp; Purchase Request List</p>
          <div class="box-tools">
            <button @click="toCreatePR()" type="button" class="btn btn-outline-primary btn-fw btn-icon-text">
              Create PR
            </button>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="row">
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-6"></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <procurement_table />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-7"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import procurement_table from '../../components/procurement/procurement_table.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faList } from '@fortawesome/free-solid-svg-icons';


library.add(faList);
export default {
  name: 'DetailedReport',
  components: {
    procurement_table,
    FontAwesomeIcon
  },
  mounted() {
  },
  methods: {
    toCreatePR() {
            this.$router.push("/procurement/create_pr");
        },
    
  }
}
</script>