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
            <tbody v-if="(role === 'admin' || role === 'user') && displayedItems.length > 0">
                <tr v-for="ict_data in displayedItems" :key="ict_data.id">
                    <td>
                        <template v-if="role === 'admin'">
                            <div v-if="ict_data.status === 'Received'">
                                <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                    @click="view_ict_form(ict_data.id)" aria-label="View Details" title="Show">
                                    <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                </button>
                                <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                    @click="openModal(ict_data.id)" aria-label="Open Modal" title="Complete"
                                    v-if="ict_data.ict_personnel_id == user_id">
                                    <font-awesome-icon :icon="['fas', 'layer-group']"></font-awesome-icon>
                                </button>
                            </div>

                            <div v-else-if="ict_data.status === 'Completed'">
                                <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                    @click="view_ict_form(ict_data.id)" aria-label="View Details" title="Show">
                                    <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                </button>
                            </div>
                            <div v-else-if="ict_data.status === 'Draft'">
                                <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                    @click="received_request(ict_data.id)" aria-label="Confirm Request" title="Confirm"
                                    :disabled="isReceiving">
                                    <font-awesome-icon :icon="['fas', 'circle-check']"></font-awesome-icon>
                                </button>
                                <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                    @click="view_ict_form(ict_data.id)" aria-label="View Details" title="Show">
                                    <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                                </button>
                            </div>
                        </template>
                        <template v-else-if="role === 'user'">
                            <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                @click="view_ict_form(ict_data.id)" aria-label="View Details" title="Show">
                                <font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon>
                            </button>
                        </template>
                    </td>

                    <td>{{ ict_data.status }}</td>
                    <td>
                        <a href="#" v-if="role === 'admin'" @click.prevent="pdf_form(ict_data.id)">
                            <b>{{ ict_data.control_no }}</b>
                        </a>
                        <b v-if="role === 'user'">{{ ict_data.control_no }}</b>
                        <br>
                        <i>~Request Date: {{ formatDate(ict_data.request_date) }}</i>~
                    </td>
                    <td style=" white-space:normal;">{{ ict_data.remarks }}</td>

                    <!-- USER SURVEY LINK -->
                    <template v-if="role === 'user'">
                        <td v-if="ict_data.status === 'Completed'">
                            <button class="btn btn-primary mr-1" :style="{ backgroundColor: '#059886', color: '#fff' }">
                                <font-awesome-icon :icon="['fas', 'square-poll-vertical']" />
                                <a :href="ict_data.css_link" target="_blank" style="color:#fff"> Survey Link</a>
                            </button>
                        </td>
                        <td v-else> ~ </td>
                    </template>

                    <!-- ADMIN SURVEY LINK -->
                    <template v-if="role === 'admin'">
                        <td v-if="ict_data.status === 'Completed'">
                            <button class="btn btn-primary mr-1" style="background-color:#059886;color:#fff;">
                                <font-awesome-icon :icon="['fas', 'square-poll-vertical']" />
                                <a :href="ict_data.css_link" target="_blank" style="color:#fff"> Survey Link</a>
                            </button>
                        </td>
                        <td v-else> ~ </td>
                    </template>

                    <td> {{ formatDate(ict_data.started_date) }}</td>
                    <td> {{ formatTime(ict_data.started_date) }}</td>
                    <td>{{ ucwords(ict_data.requested_by) }}</td>
                    <td>{{ ict_data.office }}</td>
                    <td>{{ ict_data.ict_personnel }}</td>
                    <td> {{ formatDate(ict_data.completed_date) }}</td>
                    <td> {{ formatTime(ict_data.completed_date) }}</td>
                    <td>
                        <span class="badge badge-success">
                            {{ ict_data.request_type }} - {{ ict_data.sub_request_type }}
                        </span>
                    </td>
                </tr>
            </tbody>

        </table>
        <div class="mb-2" style="font-weight: 500;">{{ showingEntriesMessage }}</div>
        <Pagination :total="totalRecords" :currentPage="currentPage" :itemsPerPage="itemsPerPage"
            @pageChange="onPageChange" />

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
import Pusher from 'pusher-js';
import _ from 'lodash';

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
            user_id: '',
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
            started_date: null,
            request_type: null,
            sub_request_type: null,
            assign_ict_officer: null,
            pusher: null,
            isReceiving: false // Add a flag to track request state
        }

    },
    created() {
        this.user_id = localStorage.getItem('userId');
        this.role = localStorage.getItem('user_role');
    },
    computed: {
        totalRecords() {
            return this.ict_data.length; // Total records based on fetched data
        },
        displayedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.ict_data.slice(start, end); // Slice the data for current page
        },
        showingEntriesMessage() {
            const start = (this.currentPage - 1) * this.itemsPerPage + 1;
            const end = Math.min(start + this.itemsPerPage - 1, this.totalRecords);
            return `Showing ${start} to ${end} of ${this.totalRecords} entries`;
        }
    },
    mounted() {
        this.fetchRequests(this.role, 6);

        if (this.role === 'admin') {
            var pusher = new Pusher('29d53f8816252d29de52', {
                cluster: 'ap1'
            });
            const newChannel = pusher.subscribe('ict-ta-channel');
            newChannel.bind('new-ict-ta', _.debounce((data) => {
                this.load_ict_request(6);
            }, 500));

            const receivedChannel = pusher.subscribe('received-ta-channel');
            receivedChannel.bind('received-ict-ta', _.debounce((data) => {
                this.load_ict_request(6);
            }, 500));

            const completedChannel = pusher.subscribe('completed-ta-channel');
            completedChannel.bind('completed-ict-ta', _.debounce((data) => {
                this.load_ict_request(6);
            }, 500));
        } else if (this.role === 'user') {
            var pusher = new Pusher('29d53f8816252d29de52', {
                cluster: 'ap1'
            });
            const receivedChannel = pusher.subscribe('received-ta-channel');
            receivedChannel.bind('received-ict-ta', _.debounce((data) => {
                this.load_ict_perUser_request(6);
            }, 500));

            const completedChannel = pusher.subscribe('completed-ta-channel');
            completedChannel.bind('completed-ict-ta', _.debounce((data) => {
                this.load_ict_perUser_request(6);
            }, 500));
        }
    },
    beforeDestroy() {
        if (this.pusher) {
            this.pusher.unsubscribe('ict-ta-channel');
            this.pusher.unsubscribe('received-ta-channel');
            this.pusher.unsubscribe('completed-ta-channel');
            this.pusher.disconnect(); // Clean up Pusher connection
        }
    },

    methods: {
        ucwords(str) {
            return str.replace(/\w\S*/g, function (txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        },
        onPageChange(page) {
            this.currentPage = page;
        },
        fetchRequests(role, status) {
            if (role === 'admin') {
                this.load_ict_request(status);
            } else if (role === 'user') {
                this.load_ict_perUser_request(status);
            } else {
                console.error('Unknown role');
            }
        },
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
        load_ict_request(status, controlNo = null, requestedBy = null, startDate = null, endDate = null, pmo = null, ictPersonnel = null, year = null, quarter = null) {
            const url = status ? `../../api/fetch_ict_request/${status}` : `../../api/fetch_ict_request`;
            this.currentPage = 1;
            const params = {
                ...(controlNo && { control_no: controlNo }),
                ...(requestedBy && { requested_by: requestedBy }),
                ...(ictPersonnel && { ict_personnel: ictPersonnel }),
                ...(startDate && { start_date: startDate }),
                ...(endDate && { end_date: endDate }),
                ...(pmo && { pmo }),
                ...(year && { year }),
                ...(quarter && { quarter }),
            };

            axios.get(url, { params })
                .then(response => {
                    this.ict_data = response.data.data || [];
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    this.ict_data = [];
                });
        },

        load_ict_perUser_request(status) {
            const url = status ? `../../api/fetch_ict_perUser/${status}/${this.user_id}` : `../../api/fetch_ict_perUser/6/${this.user_id}`;
            axios.get(url)
                .then(response => {
                    this.ict_data = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        //For Complete Modal
        fetch_ict_req_details() {
            const id = this.selected_id
            axios.post(`../../api/fetch_ict_req_details`, {
                control_id: id
            })
                .then(response => {
                    this.control_no = response.data.control_no
                    this.requested_by = response.data.requested_by
                    this.office = response.data.office
                    this.started_date = response.data.started_date
                    this.request_date = response.data.request_date
                    this.request_type = response.data.request_type
                    this.sub_request_type = response.data.sub_request_type
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        view_ict_form(id) {
            // Navigate to the view page with the id as a query parameter
            this.$router.push({ path: '/rictu/ict_ta/view', query: { id: id } });
        },
        pdf_form(id) {
            const url = this.$router.resolve({ path: '/rictu/ict_ta/pdf', query: { id: id } }).href;
            window.open(url, '_blank'); // Open in a new tab
        },
        async received_request(id) {
            if (this.isReceiving) return; // Prevent multiple calls

            this.isReceiving = true;
            const userId = localStorage.getItem('userId');

            try {
                await axios.post('/api/post_received_ict_request', {
                    control_no_id: id,
                    cur_user: userId
                });

                toast.success('Success! This request has been received!', {
                    autoClose: 2000
                });

                this.load_ict_request(6);
            } catch (error) {
                console.error('Error receiving request:', error);
                toast.error('Failed to receive request. Please try again.', {
                    autoClose: 2000
                });
            } finally {
                this.isReceiving = false;
            }
        }

    }
}

</script>
