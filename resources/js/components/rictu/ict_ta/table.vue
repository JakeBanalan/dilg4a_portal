<style scoped>
td {
    text-align: center;
}

th {
    text-align: center;
}
</style>
<template>
    <div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr role="row">
                    <th rowspan="2" style="width:6%!important;" class="sorting" tabindex="0"
                        aria-controls="ict_monitoring" colspan="1"
                        aria-label="ACTIONS: activate to sort column ascending">ACTIONS</th>
                    <th rowspan="2" style="width:5%!important;" class="sorting" tabindex="0"
                        aria-controls="ict_monitoring" colspan="1"
                        aria-label="STATUS: activate to sort column ascending">STATUS</th>
                    <th rowspan="2" style="width: 10%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1"
                        aria-label="ICT TECHNICAL ASSISTANCE REFERENCE NO.: activate to sort column ascending">
                        ICT TECHNICAL ASSISTANCE REFERENCE NO.</th>
                    <th rowspan="2" style="width: 10%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="ISSUE/CONCERN: activate to sort column ascending"> ISSUE/CONCERN</th>

                    <th rowspan="2" style="width:6%!important;" class="sorting" tabindex="0"
                        aria-controls="ict_monitoring" colspan="1"
                        aria-label="ACTIONS: activate to sort column ascending">SURVEY LINK</th>

                    <th colspan="2" scope="colgroup" style="text-align: center;" rowspan="1">RECEIVED</th>
                    <th rowspan="2" style="width: 10%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="NAME OF THE END-USER: activate to sort column ascending"> NAME OF THE
                        END-USER</th>
                    <th rowspan="2" style="width: 5%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1"
                        aria-label="OFFICE/SERVICE/ BUREAU DIVISION/SECTIO N/UNIT: activate to sort column ascending">
                        OFFICE/SERVICE/<br> BUREAU<br> DIVISION/SECTIO<br> N/UNIT</th>

                    <th rowspan="2" style="width: 10%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="TECHNICAL PERSONNEL ASSIGNED: activate to sort column ascending">
                        TECHNICAL
                        PERSONNEL ASSIGNED</th>
                    <th colspan="2" scope="colgroup" rowspan="1">COMPLETED</th>
                    <th rowspan="2" style="width: 5%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="TYPE OF REQUEST: activate to sort column ascending">TYPE OF REQUEST</th>


                </tr>
                <tr role="row">
                    <th scope="col" class="sorting" tabindex="0" aria-controls="ict_monitoring" rowspan="1" colspan="1"
                        aria-label="DATE: activate to sort column ascending">DATE</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="ict_monitoring" rowspan="1" colspan="1"
                        aria-label="TIME: activate to sort column ascending">TIME</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="ict_monitoring" rowspan="1" colspan="1"
                        aria-label="DATE: activate to sort column ascending">DATE</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="ict_monitoring" rowspan="1" colspan="1"
                        aria-label="TIME: activate to sort column ascending">TIME</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="ict_data in displayedItems" :key="ict_data.id">
                    <td v-if="this.role == 'admin'">
                        <div v-if="ict_data.status === 'Received'">
                            <!-- Render buttons for viewing and opening modal -->
                            <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                @click="view_ict_form(ict_data.id)">
                                <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                            </button>
                            <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                @click="openModal(ict_data.id)">
                                <font-awesome-icon :icon="['fas', 'layer-group']"></font-awesome-icon>
                            </button>
                        </div>
                        <div v-else-if="ict_data.status === 'Completed'">
                            <!-- Render buttons for viewing and opening modal -->
                            <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                @click="view_ict_form(ict_data.id)" title="Show">
                                <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                            </button>
                        </div>
                        <div v-else>
                            <!-- Render button for marking as received -->
                            <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                @click="received_request(ict_data.id)" title="Confirm">
                                <font-awesome-icon :icon="['fas', 'circle-check']"></font-awesome-icon>
                            </button>
                            <!-- Render buttons for viewing and opening modal -->
                            <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                @click="view_ict_form(ict_data.id)" title="Show">
                                <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                            </button>
                            <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                @click="openModal(ict_data.id)" title="Complete">
                                <font-awesome-icon :icon="['fas', 'layer-group']"></font-awesome-icon>
                            </button>
                        </div>



                    </td>
                    <td v-else>
                        <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                            @click="view_ict_form(ict_data.id)">
                            <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                        </button>
                    </td>

                    <td>{{ ict_data.status }}</td>
                    <td><b>{{ ict_data.control_no }}</b><br><i>~Request Date: {{ formatDate(ict_data.requested_date)
                            }}</i>~</td>
                    <td style="white-space:normal;">{{ ict_data.remarks }} </td>

                    <td v-if="ict_data.status_id == 3">
                        <button class="btn btn-primary mr-1" style="background-color:#059886;color:#fff;">
                            <font-awesome-icon :icon="['fas', 'square-poll-vertical']" />
                            <a :href="ict_data.css_link" target="_blank" style="color:#fff"> Survey Link</a>
                        </button>
                    </td>
                    <td v-else> ~ </td>


                    <td> {{ formatDate(ict_data.received_date) }}</td>
                    <td> {{ formatTime(ict_data.received_date) }}</td>
                    <td>{{ ict_data.requested_by }}</td>
                    <td>{{ ict_data.office }}</td>
                    <td>{{ ict_data.ict_personnel }}</td>
                    <td> {{ formatDate(ict_data.completed_date) }}</td>
                    <td> {{ formatTime(ict_data.completed_date) }}</td>
                    <td> <span class="badge badge-success">{{ ict_data.request_type }} - {{ ict_data.sub_request_type
                            }}</span> </td>





                </tr>
            </tbody>
        </table>
        <Pagination :total="ict_data.length" @pageChange="onPageChange" />

    </div>
    <modal_complete_ta :visible="modalVisible" @close="closeModal" :id="selected_id" :control_no="control_no"
        :requested_by="requested_by" :office="office" :request_date="request_date" :request_type="request_type"
        :sub_request_type="sub_request_type" />
</template>
<script>
import Pagination from '../../procurement/Pagination.vue';
import modal_complete_ta from '../modal/modal_complete_ta.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";

library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical);
export default {
    name: 'ict table',
    components: {
        Pagination,
        FontAwesomeIcon,
        modal_complete_ta
    },
    data() {
        return {
            ict_data: [],
            role: null,
            currentPage: 1,
            itemsPerPage: 10,
            modalVisible: false,
            selected_id: null,

            id: null,
            control_no: null,
            requested_by: null,
            office: null,
            request_date: null,
            request_type: null,
            sub_request_type: null,
        }

    },
    created() {
        this.role = localStorage.getItem('user_role');
        console.log(new Date());
    },
    computed: {

        totalPages() {
            return Math.ceil(this.ict_data.length / this.itemsPerPage);
        },
        displayedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.ict_data.slice(start, end);
        },
    },
    mounted() {
        this.load_ict_request(6)
        // load the data when the user click the control_no to be completed
        // then pass the control_no and id to the modal

    },
    methods: {
        openModal(id) {
            this.selected_id = id;
            this.fetch_ict_req_details();

            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },
        formatTime(date) {
            if (!date || date === '0000-00-00') {
                return null; // Return null if the date is null or '0000-00-00'
            } else {
                const formattedDate = new Date(date).toLocaleString('en-US', {

                    hour: 'numeric',
                    minute: 'numeric',
                    second: 'numeric'
                });
                return formattedDate;
            }
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

        load_ict_request(status) {
            const url = status ? `../../api/fetch_ict_request/${status}` : `../../api/fetch_ict_request`;
            axios.get(url)
                .then(response => {
                    this.ict_data = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        fetch_ict_req_details() {
            const id = this.selected_id
            axios.post(`../../api/fetch_ict_req_details`, {
                control_id: id
            })
                .then(response => {
                    this.control_no = response.data.control_no
                    this.requested_by = response.data.requested_by
                    this.office = response.data.office
                    this.request_date = response.data.request_date
                    this.request_type = response.data.request_type
                    this.sub_request_type = response.data.sub_request_type
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        view_ict_form(id) {
            this.$router.push({ path: '/rictu/ict_ta/view', query: { id: id } });
        },
        onPageChange(page) {
            this.currentPage = page;
            // Fetch data for the new page
            this.loadData();
        },
        received_request(id) {
            const userId = localStorage.getItem('userId');

            axios.post('/api/post_received_ict_request', {
                control_no_id: id,
                cur_user: userId
            }).then(() => {
                toast.success('Success! This request has been received!', {
                    autoClose: 2000
                });

                // Refresh the page after 2000 milliseconds (2 seconds)
                setTimeout(() => {
                    window.location.reload();
                }, 2000);

                this.load_ict_request(6);

            }).catch((error) => {

            })
        }

    }
}

</script>