<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-md-9 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <FullCalendar ref="calendar" :options="calendarOptions" />
                                </div>
                            </div>
                        </div>
                        <!--CARDS - Activity Bar-->
                        <div class="col-md-3 grid-margin">
                            <div class="card" style="max-height: 770px !important; overflow:hidden;">
                                <div class="card-body" style="overflow-y:scroll;">
                                    <p class="card-title">Ledger Filter</p>

                                    <div class="box box-widget widget-user-12">
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-12">
                                            <table class="table table-bordered"
                                                style="border-width: 3px;max-width:100%;">
                                                <tbody>

                                                    <tr>
                                                        <!-- All Offices Checkbox -->
                                                        <td style="background-color: white; color:black; width: 50%;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="'0'"
                                                                @change="filterEvents">
                                                            <label style="margin-left: 15%;">All Offices</label>
                                                        </td>

                                                        <!-- My Personal Events Checkbox -->
                                                        <td
                                                            style="background-color: goldenrod; color: #fff; padding: 9px; width: 50%;">
                                                            <input class="calFilter" type="checkbox"
                                                                name="myPersonalEvents" v-model="showMyPersonalEvents"
                                                                @change="FetchData">
                                                            <label style="margin-left: 15%;">My Personal Events</label>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="background-color: #D5D911; color:white;width:50%;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="6"
                                                                @change="filterEvents()">
                                                            <label style="margin-left:15%;">ORD</label>
                                                        </td>
                                                        <td
                                                            style="background-color: #607D8B; color:#fff;padding:9px;width:50%;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="9"
                                                                @change="filterEvents()">
                                                            <label style="margin-left:15%;">Batangas</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #E60785; color:white;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="5"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">FAD</label>
                                                        </td>
                                                        <td
                                                            style="background-color:#FF9800 ; color:white;;padding:9px;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="10"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">Cavite</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #48BD0D; color:white;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="7"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">LGCDD</label>
                                                        </td>
                                                        <td style="background-color:#009688; color:white;;padding:9px;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="11"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">Laguna</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #E6680E; color:white;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="3"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">MBRTG</label>
                                                        </td>
                                                        <td style="background-color:#81D4FA; color:white;;padding:9px;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="13"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">Rizal</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #0071c5; color:white;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="8"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">LGMED</label>
                                                        </td>
                                                        <td style="background-color:#d50000; color:white;;padding:9px;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="12"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">Quezon</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #8F0CC7; color:white;">
                                                            <input class="calFilter" data-id="9" type="checkbox"
                                                                name="offices[]" v-model="selectedOffices" :value="4"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">PDMU</label>
                                                        </td>
                                                        <td
                                                            style="background-color: #FFEB3B; color:white;;padding:9px;">
                                                            <input class="calFilter" type="checkbox" name="offices[]"
                                                                v-model="selectedOffices" :value="14"
                                                                @change="filterEvents()"><label
                                                                style="margin-left:15%;">Lucena City</label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
        <EventModal :visible="modalVisible" :mode="mode" @close="closeModal" @save="saveEventData"
            :fetchAuthor="fetchAuthor" :eventDetails="eventDetails" />
    </div>
</template>

<script>
import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import EventModal from './EventModal.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import moment from 'moment';
import axios from 'axios';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

export default {
    components: {
        EventModal,
        FullCalendar,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
    },
    data() {
        return {
            modalVisible: false,
            events: [],
            posted_by: null,
            eventDetails: {
                personnalevent: 0, // Ensure it's initialized to 0 or 1
                id: null,
                allDay: true,
                title: '',
                start: '',
                end: '',
                office: '',
                description: '',
                venue: '',
                enp: '',
                postedBy: '',
                remarks: [],
            },
            mode: '',
            userId: null,
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                headerToolbar: {
                    start: 'title',
                    center: '',
                    end: 'AddEvent prev next today',
                },
                eventClick: this.handleEventClick,
                eventDrop: this.handleEventDrop,
                editable: true,
                events: [],
                eventDisplay: 'block',
                dayMaxEvents: 2,
                customButtons: {
                    AddEvent: {
                        text: '+ Add Event',
                        click: this.handleCustomButtonClick,
                    },
                },

            },
            selectedOffices: [0],
            showMyPersonalEvents: true
        }
    },
    created() {
        this.userId = localStorage.getItem('userId');
        this.FetchData();
        this.fetchAuthor();
    },
    computed: {

        FormattedFDate() {
            return function (DateString) {
                return moment(DateString).format('MMMM DD, YYYY');
            };
        },
        FormattedMonth() {
            return function (DateString) {
                return moment(DateString).format('MMMM');
            };
        },
        FormattedDate() {
            return function (DateString) {
                return moment(DateString).format('DD');
            };
        },
        FormattedDay() {
            return function (DateString) {
                return moment(DateString).format('dddd');
            };
        },
        UpcomingEvents() {
            const currentDate = new Date();
            return this.events.filter(events => {
                const eventDate = new Date(events.start);
                return eventDate >= currentDate;
            })
        }
    },
    methods: {
        filterEvents() {
            this.FetchData();
        },

        fetchAuthor() {
            const userId = localStorage.getItem('userId');
            this.$fetchUserData(userId, '../../../../api/fetchUser')
                .then(emp_data => {
                    this.posted_by = emp_data.name
                });
        },
        ClearEvents() {
            this.eventDetails = {
                title: "",
                start: "",
                end: "",
                office: "",
                description: "",
                venue: "",
                enp: "",
                postedBy: "",
                remarks: "",
            }
        },
        closeModal() {
            this.modalVisible = false
        },
        openModal(mode) {
            this.mode = mode;
            this.modalVisible = true

        },
        handleCustomButtonClick() {
            // console.log(this.posted_by)
            this.ClearEvents()
            this.eventDetails.postedBy = this.posted_by;
            this.openModal('add')
            // this.modalVisible = true
        },
        FetchData() {
            const allOfficesSelected = this.selectedOffices.includes('0');

            axios.get(`/api/fetchEventData`, {
                params: {
                    office: allOfficesSelected ? '0' : this.selectedOffices.join(','),
                    personnalevent: this.showMyPersonalEvents ? 1 : 0,
                }
            })
                .then(response => {
                    const events = response.data.map(event => {
                        const startDate = moment(event.start);
                        const endDate = moment(event.end);
                        const duration = endDate.diff(startDate, 'days');

                        return {
                            ...event,
                            allDay: duration > 1, // Multi-day event handling
                            start: moment(event.start).format('YYYY-MM-DD HH:mm:ss'),
                            end: moment(event.end).format('YYYY-MM-DD HH:mm:ss'),
                            backgroundColor: event.color || '#48BD0D', // Default color
                        };
                    });

                    this.calendarOptions.events = events; // Update calendar options
                    this.events = events; // Store events locally
                    this.$refs.calendar.getApi().refetchEvents(); // Refresh calendar
                })
                .catch(error => {
                    console.error('Error Fetching events:', error);
                });
        },

        handleEventClick(arg) {
            const event = this.events.find(event => event.id === +arg.event.id);
            const formatDateForInput = (date) => {
                const dateObj = new Date(date);
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            this.eventDetails = {
                id: event.id,
                allDay: true,
                title: event.title,
                start: formatDateForInput(event.start),
                end: formatDateForInput(event.end),
                office: event.office,
                description: event.description,
                venue: event.venue,
                enp: event.enp,
                postedBy: event.fname,
                remarks: event.remarks,
                personnalevent: event.personnalevent
            };

            this.$nextTick(() => {
                this.openModal('edit');
            });
        },
        handleEventDrop(info) {
            const updatedEvent = {
                id: info.event.id,
                start: moment(info.event.start).format('YYYY-MM-DD HH:mm:ss'),
                end: moment(info.event.end || info.event.start).format('YYYY-MM-DD HH:mm:ss')
            };

            axios.post('/api/PostUpdateEvent', updatedEvent)
                .then(() => {
                    toast.success('Event Updated!', {
                        autoClose: 1000
                    });
                    this.FetchData();
                })
                .catch(error => console.error('Error updating event:', error));
        },

        saveEventData(formData) {
            if (this.mode == 'add') {
                this.$fetchUserData(this.userId, '/api/fetchUser')
                    .then(emp_data => {
                        this.eventDetails.postedBy = emp_data.name
                        axios.post('/api/PostEventData',
                            {
                                postedby: this.userId,
                                office: emp_data.id,
                                title: this.eventDetails.title,
                                color: emp_data.DIVISION_COLOR,
                                start: this.eventDetails.start,
                                end: this.eventDetails.end,
                                description: this.eventDetails.description,
                                venue: this.eventDetails.venue,
                                remarks: this.eventDetails.remarks.join(', '),
                                enp: this.eventDetails.enp,
                                personnalevent: this.eventDetails.personnalevent ? 1 : 0,
                            }
                        )
                            .then(() => {
                                toast.success('Event Added!', {
                                    autoClose: 1000
                                });
                            });
                        this.FetchData();
                        this.closeModal();
                    })
                    .catch(error => {
                        console.error('error saving data', error);
                    })
            } else {
                console.log(formData);
                axios.post('/api/PostUpdateEvent',
                    {
                        id: formData.id,
                        title: this.eventDetails.title,
                        start: this.eventDetails.start,
                        end: this.eventDetails.end,
                        description: this.eventDetails.description,
                        venue: this.eventDetails.venue,
                        remarks: this.eventDetails.remarks.join(', '),
                        enp: this.eventDetails.enp,
                    }
                )
                    .then(() => {
                        toast.success('Event Updated!', {
                            autoClose: 1000
                        });
                        this.FetchData();
                        this.closeModal();
                    })
                    .catch(error => {
                        console.error('error saving data', error)
                    })
            }
        }

    }
};
</script>

<style scoped>
.fc-h-event {
    position: relative;
    display: block;
    font-size: .85em;
    line-height: 1.3;
    border-radius: 3px;
}

.fc-daygrid-event {
    margin: 1px 2px 0;
    padding: 0 1px;
}

.fc-daygrid-day-frame {
    position: relative;
    min-height: 100px;
}

.fc-daygrid-day-number {
    font-size: 1.2em;
    font-weight: bold;
}

.fc-daygrid-day-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4px;
}

.fc-daygrid-day-events {
    margin-top: 4px;
}

.fc-daygrid-event-harness {
    margin-bottom: 2px;
}

.fc-daygrid-event {
    border-radius: 3px;
    padding: 2px 4px;
}

.fc-daygrid-event-dot {
    display: none;
}

.fc-daygrid-event-time {
    font-weight: bold;
}

.fc-daygrid-event-title {
    font-size: 0.9em;
    color: #fff;
}

time.icon {
    font-size: 7px;
    /* change icon size */
    display: block;
    position: relative;
    width: 7em;
    height: 7em;
    background-color: #fff;
    border-radius: 0.6em;
    box-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;
    overflow: hidden;
    backface-visibility: hidden;
    transform: rotate(0deg) skewY(0deg);
    transform-origin: 50% 10%;
}

time.icon * {
    display: block;
    width: 100%;
    font-size: 1em;
    font-weight: bold;
    font-style: normal;
    text-align: center;
}

time.icon strong {
    position: absolute;
    top: 0;
    padding: 0.4em;
    color: #fff;
    background-color: #059886;
    border-bottom: 1px dashed #059886;
    box-shadow: 0 2px 0 #059886;
}

time.icon em {
    position: absolute;
    bottom: 0.3em;
    color: #059886;
}

time.icon span {
    width: 100%;
    font-size: 2.8em;
    letter-spacing: -0.05em;
    padding-top: 0.7em;
    color: #2f2f2f;
}

.move-calendar:hover time,
.move-calendar:focus time {
    -webkit-animation: swing 0.6s ease-out;
    animation: swing 0.6s ease-out;
}



@-webkit-keyframes swing {
    0% {
        -webkit-transform: rotate(0deg) skewY(0deg);
    }

    20% {
        -webkit-transform: rotate(12deg) skewY(4deg);
    }

    60% {
        -webkit-transform: rotate(-9deg) skewY(-3deg);
    }

    80% {
        -webkit-transform: rotate(6deg) skewY(-2deg);
    }

    100% {
        -webkit-transform: rotate(0deg) skewY(0deg);
    }
}

@keyframes swing {
    0% {
        transform: rotate(0deg) skewY(0deg);
    }

    20% {
        transform: rotate(12deg) skewY(4deg);
    }

    60% {
        transform: rotate(-9deg) skewY(-3deg);
    }

    80% {
        transform: rotate(6deg) skewY(-2deg);
    }

    100% {
        transform: rotate(0deg) skewY(0deg);
    }
}

div::-webkit-scrollbar {
    display: none;
}
</style>
