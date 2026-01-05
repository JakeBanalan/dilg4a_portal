<template>
    <div class="container-scroller">
      <Navbar></Navbar>
      <div class="container-fluid page-body-wrapper">
        <Sidebar />
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <StatBoard />
              <div class="col-lg-12">
                <div class="card mt-12">
                  <div class="card-body">
                    <div class="card-title d-flex justify-content-between align-items-center">
                      <h5 class="card-title">
                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;ICT
                        Technical Assistance Monitoring
                      </h5>
                      <div class="d-flex">
                        <button
                          v-if="role === 'admin'"
                          class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                          @click="openModal()"
                        >
                          Generate Report
                        </button>
                        <button
                          v-if="role === 'admin'"
                          class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                          @click="toggleCard()"
                        >
                          Advanced Search
                        </button>
                      </div>
                    </div>

                    <div class="table-responsive">
                      <!-- Advanced Filter Card -->
                      <div class="card card-animation" v-show="isCardVisible">
                        <div class="card-body">
                          <div class="card-title">
                            <h4>
                              <font-awesome-icon :icon="['fas', 'search']" />&nbsp;ADVANCED FILTER
                            </h4>
                          </div>
                          <div class="row">
                            <div class="col-lg-3">
                              <label style="font-size: 0.875rem;">Control No</label>
                              <input
                                type="text"
                                class="form-control"
                                v-model="filterParams.control_no"
                                placeholder="Control Number"
                                @keyup.enter="filter"
                              />
                            </div>
                            <div class="col-lg-3">
                              <label style="font-size: 0.875rem;">Request By</label>
                              <input
                                type="text"
                                class="form-control"
                                v-model="filterParams.requested_by"
                                placeholder="Requested By"
                                @keyup.enter="filter"
                              />
                            </div>
                            <div class="col-lg-3">
                              <label style="font-size: 0.875rem;">Technical Personnel</label>
                              <input
                                type="text"
                                class="form-control"
                                v-model="filterParams.ict_personnel"
                                placeholder="Technical Personnel"
                                @keyup.enter="filter"
                              />
                            </div>
                            <div class="col-lg-3">
                              <label style="font-size: 0.875rem;">Start Date</label>
                              <input type="date" class="form-control" v-model="filterParams.start_date" />
                            </div>
                            <div class="col-lg-3">
                              <label style="font-size: 0.875rem;">End Date</label>
                              <input type="date" class="form-control" v-model="filterParams.end_date" />
                            </div>
                            <div class="col-lg-3">
                              <label style="font-size: 0.875rem;">Month</label>
                              <select class="form-control" v-model="filterParams.selected_month">
                                <option :value="null">All</option>
                                <option v-for="(month, idx) in monthOptions" :key="idx" :value="idx + 1">
                                  {{ month }}
                                </option>
                              </select>
                            </div>
                            <div class="col-lg-3">
                              <label style="font-size: 0.875rem;">Quarterly</label>
                              <multiselect
                                deselect-label="Can't remove this value"
                                v-model="filterParams.selected_quarter"
                                track-by="value"
                                :options="quarterOptions"
                                label="label"
                                :searchable="false"
                                :allow-empty="false"
                                :multiple="false"
                              >
                              </multiselect>
                            </div>
                            <div class="col-lg-3">
                              <label style="font-size: 0.875rem;">OFFICE/SERVICE/BUREAU DIVISION/SECTION/UNITS</label>
                              <multiselect
                                v-model="filterParams.selected_pmo"
                                :options="pmoOptions"
                                label="label"
                                :multiple="false"
                              ></multiselect>
                            </div>
                            <div class="col-lg-3">
                              <div class="form-group">
                                <label style="font-size: 0.875rem;">Status</label>
                                <multiselect
                                  v-model="filterParams.selected_status"
                                  deselect-label="Can't remove this value"
                                  track-by="value"
                                  label="label"
                                  :options="statusOptions"
                                  :searchable="false"
                                  :allow-empty="false"
                                >
                                </multiselect>
                              </div>
                            </div>
                          </div>

                          <button
                            type="button"
                            class="btn btn-outline-primary btn-fw btn-icon-text"
                            style="float:right;"
                            :disabled="isFiltering"
                            @click="filter"
                          >
                            <span v-if="isFiltering">
                              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                              Filtering...
                            </span>
                            <span v-else>Filter</span>
                          </button>
                          <button
                            type="button"
                            class="btn btn-outline-primary btn-fw btn-icon-text mr-3"
                            style="float:right;"
                            @click="resetFilter"
                          >
                            Clear
                          </button>
                        </div>
                      </div>

                      <!-- ICT Table Component -->
                      <ICTTable ref="ICTTable" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Export Modal -->
      <modal-export :visible="modalVisible" @close="closeModal" />
    </div>
  </template>

  <style src="vue-multiselect/dist/vue-multiselect.css"></style>
  <style scoped>
  .card-animation {
    transition: height 0.5s ease-in-out;
  }

  h5 {
    color: #059886 !important;
    --bs-text-opacity: 1;
  }

  .router-class:hover {
    color: #059886 !important;
  }
  </style>

  <script>
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
  import { library } from '@fortawesome/fontawesome-svg-core';
  import { faList, faSearch, faSquarePollVertical, faUserGear } from '@fortawesome/free-solid-svg-icons';

  library.add(faSearch, faList, faSquarePollVertical, faUserGear);

  import Navbar from '../../layout/Navbar.vue';
  import Sidebar from '../../layout/Sidebar.vue';
  import ICTTable from './table.vue';
  import Multiselect from 'vue-multiselect';
  import StatBoard from './stat_board';
  import ModalExport from '../modal/modal_generate_report.vue';

  import _ from 'lodash';
  export default {
    name: 'ICTTechnicalAssistance',
    components: {
      Navbar,
      Sidebar,
      FontAwesomeIcon,
      ICTTable,
      Multiselect,
      StatBoard,
      'modal-export': ModalExport
    },

    data() {
      return {
        role: null,
        modalVisible: false,
        isCardVisible: false,
        isFiltering: false,
        // Group all filter parameters in one object
        filterParams: {
          control_no: '',
          requested_by: '',
          start_date: '',
          end_date: '',
          ict_personnel: '',
          selected_pmo: null,
          selected_quarter: null,
          selected_status: { label: 'All', value: 6 },
          selected_month: null
        },
        // Options for dropdowns
        quarterOptions: [
          { label: '1st Quarter', value: 1 },
          { label: '2nd Quarter', value: 2 },
          { label: '3rd Quarter', value: 3 },
          { label: '4th Quarter', value: 4 }
        ],
        pmoOptions: [
          { label: "ORD", value: "ORD" },
          { label: "LGMED", value: "LGMED" },
          { label: "LGCDD", value: "LGCDD" },
          { label: "FAD", value: "FAD" },
          { label: "BATANGAS", value: "BATANGAS" },
          { label: "CAVITE", value: "CAVITE" },
          { label: "LAGUNA", value: "LAGUNA" },
          { label: "QUEZON", value: "QUEZON" },
          { label: "RIZAL", value: "RIZAL" },
          { label: "LUCENA CITY", value: "LUCENA CITY" }
        ],
        statusOptions: [
          { label: 'All', value: 6 },
          { label: 'Draft', value: 1 },
          { label: 'Received', value: 2 },
          { label: 'Completed', value: 3 },
          { label: 'Rated', value: 4 }
        ],
        monthOptions: [
          'January', 'February', 'March', 'April', 'May', 'June',
          'July', 'August', 'September', 'October', 'November', 'December'
        ]
      };
    },

    created() {
      this.role = localStorage.getItem('user_role');
    },

    methods: {
      toggleCard() {
        this.isCardVisible = !this.isCardVisible;
      },

      openModal() {
        this.modalVisible = true;
      },

      closeModal() {
        this.modalVisible = false;
      },

      filter: _.debounce(function() {
        if (!this.$refs.ICTTable) {
          console.error('ICTTable reference not found');
          return;
        }
        this.isFiltering = true;
        // Extract values from the filter parameters
        const status = this.filterParams.selected_status?.value || 6;
        const controlNo = this.filterParams.control_no || null;
        const requestedBy = this.filterParams.requested_by || null;
        const ictPersonnel = this.filterParams.ict_personnel || null;
        const startDate = this.filterParams.start_date || null;
        const endDate = this.filterParams.end_date || null;
        const pmo = this.filterParams.selected_pmo?.value || null;
        const quarter = this.filterParams.selected_quarter?.value || null;
        const month = this.filterParams.selected_month || null;
        // Extract year from dates if available
        let year = null;
        if (startDate) {
          year = new Date(startDate).getFullYear();
        } else if (endDate) {
          year = new Date(endDate).getFullYear();
        }
        // Call the table component's load method with the filter parameters
        this.$refs.ICTTable.load_ict_request(
          status,
          controlNo,
          requestedBy,
          startDate,
          endDate,
          pmo,
          ictPersonnel,
          year,
          quarter,
          month
        );
        setTimeout(() => { this.isFiltering = false; }, 600); // Simulate loading state
      }, 400),

      resetFilter() {
        // Reset all filter parameters
        this.filterParams = {
          control_no: '',
          requested_by: '',
          start_date: '',
          end_date: '',
          ict_personnel: '',
          selected_pmo: null,
          selected_quarter: null,
          selected_status: { label: 'All', value: 6 },
          selected_month: null
        };
        // Reset table and reload data
        if (this.$refs.ICTTable) {
          this.$refs.ICTTable.currentPage = 1;
          this.$refs.ICTTable.load_ict_request(6);
        }
      }
    }
  };
  </script>
