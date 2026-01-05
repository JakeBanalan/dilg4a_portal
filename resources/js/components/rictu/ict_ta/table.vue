<template>
    <div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th rowspan="2" style="width:6%">ACTIONS</th>
                        <th rowspan="2" style="width:5%">STATUS</th>
                        <th rowspan="2" style="width:10%">ICT TECHNICAL ASSISTANCE REFERENCE NO.</th>
                        <th rowspan="2" style="width:10%">ISSUE/CONCERN</th>
                        <th rowspan="2" style="width:6%">SURVEY LINK</th>
                        <th colspan="2" scope="colgroup" style="text-align:center">RECEIVED</th>
                        <th rowspan="2" style="width:10%">NAME OF THE END-USER</th>
                        <th rowspan="2" style="width:5%">OFFICE/SERVICE/<br>BUREAU<br>DIVISION/SECTION/UNIT</th>
                        <th rowspan="2" style="width:10%">TECHNICAL PERSONNEL ASSIGNED</th>
                        <th colspan="2" scope="colgroup">COMPLETED</th>
                        <th rowspan="2" style="width:5%">TYPE OF REQUEST</th>
                    </tr>
                    <tr role="row">
                        <th scope="col">DATE</th>
                        <th scope="col">TIME</th>
                        <th scope="col">DATE</th>
                        <th scope="col">TIME</th>
                    </tr>
                </thead>
                <tbody
                    v-if="allowedRoles.includes(role) && displayedItems.length > 0">
                    <tr v-for="ict_data in displayedItems" :key="ict_data.id">
                        <td>
                            <ActionButtons :role="role" :status="ict_data.status" :id="ict_data.id" :user-id="user_id"
                                :ict-personnel-id="ict_data.ict_personnel_id" @view="view_ict_form"
                                @open-modal="openModal" @receive-request="received_request"
                                :is-receiving="isReceiving" />
                        </td>
                        <td>{{ ict_data.status }}</td>
                        <td>
                            <a href="#" v-if="role === 'admin'" @click.prevent="pdf_form(ict_data.id)">
                                <b>{{ ict_data.control_no }}</b>
                            </a>
                            <b v-else>{{ ict_data.control_no }}</b>
                            <br>
                            <i>~Request Date: {{ formatDate(ict_data.request_date) }}~</i>
                        </td>
                        <td style="white-space:normal;">{{ ict_data.remarks }}</td>
                        <td>
                            <template v-if="ict_data.status === 'Completed'">
                                <SurveyLinkButton
                                    v-if="ict_data.css_link"
                                    :css-link="ict_data.css_link"
                                    :disabled="ict_data.take_survey == 1"
                                    @clicked="markSurveyTaken(ict_data)"
                                />
                                <template v-else>
                                    <button class="btn btn-warning btn-sm" @click="noSurveyLinkAlert()">
                                        No Survey Link
                                    </button>
                                </template>
                            </template>
                            <template v-else>~</template>
                        </td>
                        <td>{{ formatDate(ict_data.started_date) }}</td>
                        <td>{{ formatTime(ict_data.started_date) }}</td>
                        <td>{{ ucwords(ict_data.requested_by) }}</td>
                        <td>{{ ict_data.office }}</td>
                        <td>{{ ict_data.ict_personnel }}</td>
                        <td>{{ formatDate(ict_data.completed_date) }}</td>
                        <td>{{ formatTime(ict_data.completed_date) }}</td>
                        <td>
                            <span class="badge badge-success">
                                {{ ict_data.request_type }} - {{ ict_data.sub_request_type }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-2" style="font-weight: 500;">{{ showingEntriesMessage }}</div>

        <Pagination :total="totalRecords" :currentPage="currentPage" :itemsPerPage="itemsPerPage"
            @pageChange="onPageChange" />
    </div>

    <modal-complete-ta v-if="modalVisible" :visible="modalVisible" @close="closeModal" :id="selected_id"
        :control_no="control_no" :requested_by="requested_by" :office="office" :request_date="request_date"
        :request_type="request_type" :sub_request_type="sub_request_type" />
</template>

<script>
import Pagination from '../../procurement/Pagination.vue';
import ModalCompleteTa from '../modal/modal_complete_ta.vue';
import ActionButtons from '../../micro/ActionButtons.vue';
import SurveyLinkButton from '../../micro/SurveyLinkButton.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";
import Pusher from 'pusher-js';
import _ from 'lodash';

library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical);

export default {
    name: 'ICTMonitoringTable',
    components: {
        Pagination,
        FontAwesomeIcon,
        'modal-complete-ta': ModalCompleteTa,
        ActionButtons,
        SurveyLinkButton
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
            control_no: null,
            requested_by: null,
            office: null,
            request_date: null,
            request_type: null,
            sub_request_type: null,
            isReceiving: false,
            pusherChannels: [],
            isLoading: false,
            dateCache: {}
        };
    },

    created() {
        this.user_id = localStorage.getItem('userId');
        this.role = localStorage.getItem('user_role');
    },

    computed: {
        totalRecords() {
            return this.ict_data.length;
        },

        displayedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.ict_data.slice(start, end);
        },

        showingEntriesMessage() {
            const start = this.ict_data.length ? (this.currentPage - 1) * this.itemsPerPage + 1 : 0;
            const end = Math.min(start + this.itemsPerPage - 1, this.totalRecords);
            return `Showing ${start} to ${end} of ${this.totalRecords} entries`;
        },

        allowedRoles() {
            return ['admin', 'user', 'gss_admin', 'budget_admin', 'ord_admin'];
        }
    },

    mounted() {
        this.fetchRequests(this.role, 6);
        this.setupPusherChannels();
    },

    beforeDestroy() {
        this.cleanupPusherChannels();
    },

    methods: {
        setupPusherChannels() {
            const pusher = new Pusher('29d53f8816252d29de52', {
                cluster: 'ap1'
            });

            // Common channels for both roles
            const receivedChannel = pusher.subscribe('received-ta-channel');
            receivedChannel.bind('received-ict-ta', _.debounce(() => {
                this.refreshData();
            }, 500));

            const completedChannel = pusher.subscribe('completed-ta-channel');
            completedChannel.bind('completed-ict-ta', _.debounce(() => {
                this.refreshData();
            }, 500));

            // Admin-specific channel
            if (this.role === 'admin') {
                const newChannel = pusher.subscribe('ict-ta-channel');
                newChannel.bind('new-ict-ta', _.debounce(() => {
                    this.refreshData();
                }, 500));

                this.pusherChannels = ['ict-ta-channel', 'received-ta-channel', 'completed-ta-channel'];
            } else {
                this.pusherChannels = ['received-ta-channel', 'completed-ta-channel'];
            }

            this.pusher = pusher;
        },

        cleanupPusherChannels() {
            if (this.pusher) {
                this.pusherChannels.forEach(channel => {
                    this.pusher.unsubscribe(channel);
                });
                this.pusher.disconnect();
            }
        },

        refreshData() {
            if (this.role === 'admin') {
                this.load_ict_request(6);
            } else if (this.role === 'user') {
                this.load_ict_perUser_request(6);
            }
        },

        ucwords(str) {
            if (!str) return '';
            return str.replace(/\w\S*/g, txt =>
                txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
            );
        },

        onPageChange(page) {
            this.currentPage = page;
        },

        fetchRequests(role, status) {
            if (role === 'admin') {
                this.load_ict_request(status);
            } else if (role === 'gss_admin' || role === 'budget_admin' || role === 'ord_admin' || role === 'user') {
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
            if (!date || date === '0000-00-00') return null;

            // Use cache to avoid repeated formatting
            const cacheKey = `time_${date}`;
            if (this.dateCache[cacheKey]) return this.dateCache[cacheKey];

            try {
                const formatted = new Date(date).toLocaleString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
                this.dateCache[cacheKey] = formatted;
                return formatted;
            } catch (error) {
                console.error('Date formatting error:', error);
                return null;
            }
        },

        formatDate(date) {
            if (!date || date === '0000-00-00') return null;

            // Use cache to avoid repeated formatting
            const cacheKey = `date_${date}`;
            if (this.dateCache[cacheKey]) return this.dateCache[cacheKey];

            try {
                const formatted = new Date(date).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                this.dateCache[cacheKey] = formatted;
                return formatted;
            } catch (error) {
                console.error('Date formatting error:', error);
                return null;
            }
        },

        load_ict_request(status, controlNo = null, requestedBy = null, startDate = null, endDate = null, pmo = null, ictPersonnel = null, year = new Date().getFullYear(), quarter = null, month = null) {
            const url = status ? `../../api/fetch_ict_request/${status}` : `../../api/fetch_ict_request`;
            this.currentPage = 1;
            this.isLoading = true;

            const params = {
                ...(controlNo && { control_no: controlNo }),
                ...(requestedBy && { requested_by: requestedBy }),
                ...(startDate && { start_date: startDate }),
                ...(endDate && { end_date: endDate }),
                ...(pmo && { pmo }),
                ...(ictPersonnel && { ict_personnel: ictPersonnel }),
                ...(year && { year }),
                ...(quarter && { quarter }),
                ...(month && { month }),
            };

            axios.get(url, { params })
                .then(response => {
                    this.ict_data = response.data.data || [];
                    // Clear date cache when new data arrives
                    this.dateCache = {};
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    this.ict_data = [];
                    toast.error('Failed to load requests', { autoClose: 2000 });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        load_ict_perUser_request(status) {
            const url = `../../api/fetch_ict_perUser/${status || 6}/${this.user_id}`;
            this.isLoading = true;

            axios.get(url)
                .then(response => {
                    this.ict_data = response.data.data || [];
                    // Clear date cache when new data arrives
                    this.dateCache = {};
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                    this.ict_data = [];
                    toast.error('Failed to load your requests', { autoClose: 2000 });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        fetch_ict_req_details() {
            axios.post(`../../api/fetch_ict_req_details`, {
                control_id: this.selected_id
            })
                .then(response => {
                    const data = response.data;
                    this.control_no = data.control_no;
                    this.requested_by = data.requested_by;
                    this.office = data.office;
                    this.request_date = data.request_date;
                    this.request_type = data.request_type;
                    this.sub_request_type = data.sub_request_type;
                })
                .catch(error => {
                    console.error('Error fetching request details:', error);
                    toast.error('Failed to load request details', { autoClose: 2000 });
                });
        },

        view_ict_form(id) {
            this.$router.push({
                path: '/rictu/ict_ta/view',
                query: { id }
            });
        },

        pdf_form(id) {
            const url = this.$router.resolve({
                path: '/rictu/ict_ta/pdf',
                query: { id }
            }).href;
            window.open(url, '_blank');
        },

        async received_request(id) {
            if (this.isReceiving) return;

            this.isReceiving = true;

            try {
                await axios.post('/api/post_received_ict_request', {
                    control_no_id: id,
                    cur_user: this.user_id
                });

                toast.success('Success! This request has been received!', {
                    autoClose: 2000
                });

                this.refreshData();
            } catch (error) {
                console.error('Error receiving request:', error);
                toast.error('Failed to receive request. Please try again.', {
                    autoClose: 2000
                });
            } finally {
                this.isReceiving = false;
            }
        },

        async markSurveyTaken(item) {
            if (!item || !item.id) return;
            if (!item.css_link) {
                this.noSurveyLinkAlert();
                return;
            }
            try {
                await axios.post('/api/markTakeSurvey', { id: item.id });
                // update local state so button becomes disabled
                item.take_survey = 1;
                toast.success('Thank you for completing the survey!', { autoClose: 2000 });
                this.refreshData();
                // Notify dashboard to re-check pending survey status
                window.dispatchEvent(new CustomEvent('survey-taken'));
            } catch (error) {
                console.error('Error marking survey taken:', error);
                toast.error('Failed to mark survey as taken', { autoClose: 2000 });
            }
        },

        noSurveyLinkAlert() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Survey Link Available',
                    text: 'No survey link is available for this request. Please contact the admin.',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('No survey link is available for this request. Please contact the admin.');
            }
        }
    }
};
</script>

<style scoped>
td {
    text-align: center;
}

th {
    text-align: center;
}

/* Improve mobile usability */
@media (max-width: 991px) {
    .table {
        font-size: 12px;
    }

    .table td,
    .table th {
        white-space: nowrap;
    }
}
</style>
