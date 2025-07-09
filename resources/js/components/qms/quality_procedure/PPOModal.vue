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
                    <div class="modal-body" style="max-height: 650px;">

                        <label>Process Owner:</label>
                        <multiselect id="process_owner" :options="PPOList" v-model="selectOwnerDetails"
                            track-by="emp_id" label="fname" :multiple="false" :searchable="true"
                            placeholder="Select process owners" />

                        <label>Program Manager:</label>
                        <multiselect :options="UserList" track-by="id" label="fname" v-model="SelectedPM"
                            :multiple="false" :searchable="true" id="program_manager">
                        </multiselect>

                        <label>Provincial QMR:</label>
                        <multiselect :options="UserList" track-by="id" label="fname" v-model="SelectedQMR"
                            :multiple="false" :searchable="true" id="provincial_qmr">
                        </multiselect>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" style="float: right;margin-left:5px;"
                            @click="AddPProcessOwner">Save</button>
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
import Multiselect from 'vue-multiselect';

export default {
    components: {
        Multiselect
    },
    data() {
        return {
            logo: dilg_logo,
            PPOList: [],
            SelectedPPO: [],
            UserList: [],
            SelectedPM: null,
            SelectedQMR: null,
            selectOwnerDetails: null,
            // selectedPPOId: null,
            // selectedPOid: null,
        }
    },
    props: {
        visible: Boolean,
        selectedPPOId: {
            type: [Number, String],
            default: null,
        },
        selectedPOid: {
            type: [Number, String],
            default: null,
        },
        PO_ProcessOwner: {
            type: [Array, Object],
            default: () => [],
        },
    },
    watch: {
        visible(val) {
            if (val) {
                this.fetchPPOUser();
                this.fetchPovinceUser();
                this.filterFetchData();
            }
        },
    },
    methods: {
        CloseModal() {
            this.$emit('close');
        },
        filterFetchData() {
            // console.log("parent_data_process_owner:", this.PO_ProcessOwner);
            if (!this.selectedPOid || !this.PO_ProcessOwner.length) return;

            // Find owners where pmo_id === selectedPOid
            const owners = this.PO_ProcessOwner.filter(po => po.pmo_id === this.selectedPOid);

            // Match them with PPOList once fetched
            const owner = this.PO_ProcessOwner.find(po => po.pmo_id === this.selectedPOid);
            if (owner) {
                // Set Process Owner
                this.selectOwnerDetails = this.PPOList.find(ppo => ppo.emp_id == owner.po_process_owner) || null;

                // Set Program Manager
                this.SelectedPM = this.UserList.find(user => user.id == owner.program_manager) || null;

                // Set Provincial QMR
                this.SelectedQMR = this.UserList.find(user => user.id == owner.provincial_qmr) || null;
            }
        },
        fetchPPOUser() {
            let id = this.selectedPOid;
            axios.get(`/api/fetchPProcessOwner/${id}`)
                .then((response) => {
                    this.PPOList = response.data;
                    // console.log("PPOList:", this.PPOList);
                    this.filterFetchData();  // <-- move this here
                    this.initializeDataTable();
                }).catch((error) => console.log(error));
        },

        fetchPovinceUser() {
            // console.log("selectedPOid:", this.selectedPOid);
            let id = this.selectedPOid;
            // console.log("selectedPOid:", id);
            axios.get(`/api/fetchProvinceUser/${id}`)
                .then((response) => {
                    this.UserList = response.data;
                    // console.log("UserList:", this.UserList);
                    this.filterFetchData();  // <-- move this here
                    this.initializeDataTable();
                }).catch((error) => console.log(error));
        },

        initializeDataTable() {
            $('#user_table').DataTable().destroy(); // clean up
            this.$nextTick(() => {
                $('#user_table').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                });
                this.dataTableInitialized = true;

            });
        },
        AddPProcessOwner() {

            const payload = {
                ppoid: this.selectedPPOId,
                po: this.selectedPOid,
                ppo: this.selectOwnerDetails?.emp_id,
                pm: this.SelectedPM?.id,
                qmr: this.SelectedQMR?.id,
            };
            // console.log("Payload:", payload);
            // console.log("Selected PPO:", );
            // console.log("Selected PM:", );
            // console.log("Selected QMR:", );
            this.$emit('addpprocessowner', payload);
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