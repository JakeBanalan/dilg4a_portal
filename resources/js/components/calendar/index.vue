<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <FullCalendar ref="calendar" :options="calendarOptions" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <!--PH HOLIDAYS-->
                            <div class="row">
                                <div class="col-md-12 grid-margin">
                                    <div class="card">
                                        <!-- Fixed Header -->
                                        <div class="card-header fixed-header">
                                            <p class="card-title">Philippine Holidays - {{ currentYear }}</p>
                                        </div>

                                        <!-- Scrollable Content -->
                                        <div class="card-body scrollable-card-body">
                                            <div class="row">
                                                <div class="col-md-6" v-for="(event, i) in mergedEvents" :key="i">
                                                    <div class="d-flex align-items-center pb-3 pt-3 border-bottom">
                                                        <div class="move-calendar ms-3">
                                                            <span style="display: inline-block;">
                                                                <time class="icon">
                                                                    <em>{{ FormattedDay(event.start) }}</em>
                                                                    <strong>{{ FormattedMonth(event.start) }}</strong>
                                                                    <span>{{ FormattedDate(event.start) }}</span>
                                                                </time>
                                                            </span>
                                                        </div>

                                                        <div class="ms-3" style="padding-left: 0.3em;">
                                                            <h6 class="mb-0"
                                                                :class="event.isHoliday ? 'text-danger' : 'text-blue'"
                                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                                {{ event.title }}
                                                            </h6>
                                                            <small class="mb-0"
                                                                :class="event.isHoliday ? 'text-danger' : 'text-blue'">
                                                                <i class="ti-timer me-1"></i> {{
                                                                    FormattedFDate(event.start) }} - {{
                                                                    FormattedFDate(event.end) }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- End Scrollable Content -->
                                    </div>
                                </div>
                            </div>

                            <!--PERSONAL EVENT AND OFFICE EVENT-->
                            <div class="row">
                                <div class="col-md-6 grid-margin">
                                    <div class="card">
                                        <div class="card-body scrollable-card-body">
                                            <div class="card-header fixed-header">
                                                <p class="card-title">Upcoming Office Events - {{ currentMonth }}</p>
                                            </div>
                                            <div class="d-flex align-items-center pb-3 pt-3 border-bottom"
                                                v-for="(events, i) in UpcomingEvents" :key="i">
                                                <div class="move-calendar ms-3">
                                                    <span style="display: inline-block;">
                                                        <time class="icon">
                                                            <em>{{ FormattedDay(events.start) }}</em>
                                                            <strong>{{ FormattedMonth(events.start) }}</strong>
                                                            <span>{{ FormattedDate(events.start) }}</span>
                                                        </time>
                                                    </span>
                                                </div>
                                                <div class="ms-3" style="padding-left: 0.3em;">
                                                    <h6 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                                                        class="mb-0">{{ events.title }}</h6>
                                                    <small class="text-muted mb-0"><i class="ti-timer me-1"></i> {{
                                                        FormattedFDate(events.start) }} - {{ FormattedFDate(events.end)
                                                        }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin">
                                    <div class="card">
                                        <div class="card-body scrollable-card-body">
                                            <!-- Fixed Header -->
                                            <div class="card-header fixed-header">
                                                <p class="card-title">My Personal Events - {{ currentMonth }}</p>
                                            </div>
                                            <div class="d-flex align-items-center pb-3 pt-3 border-bottom"
                                                v-for="(myEvents, i) in MyUpcomingEvents" :key="i">
                                                <div class="move-calendar ms-3">
                                                    <span style="display: inline-block;">
                                                        <time class="icon">
                                                            <em>{{ FormattedDay(myEvents.start) }}</em>
                                                            <strong>{{ FormattedMonth(myEvents.start) }}</strong>
                                                            <span>{{ FormattedDate(myEvents.start) }}</span>
                                                        </time>
                                                    </span>
                                                </div>
                                                <div class="ms-3" style="padding-left: 0.3em;">
                                                    <h6 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                                                        class="mb-0 text-blue">{{ myEvents.title }}</h6>
                                                    <small class="text-blue mb-0"><i class="ti-timer me-1"></i> {{
                                                        FormattedFDate(myEvents.start) }} - {{
                                                            FormattedFDate(myEvents.end)
                                                        }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--LEDGER FILTER-->
                            <div class="col-md-12 grid-margin">
                                <div class="card">
                                    <div class="card-body" style="overflow-y:scroll;">
                                        <p class="card-title">Ledger Filter</p>
                                        <div class="box box-widget widget-user-12">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-12">
                                                <table class="table table-bordered"
                                                    style="border-width: 3px;max-width:100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                style="background-color: whitesmoke; color: black; padding: 9px; width: 50%;">
                                                                <input type="checkbox" v-model="selectedOffices"
                                                                    name="offices[]" value="0" @change="filterEvents()">
                                                                <label style="margin-left: 15%;">All offices</label>
                                                            </td>
                                                            <td
                                                                style="background-color: goldenrod; color: #fff; padding: 9px; width: 50%;">
                                                                <input type="checkbox" v-model="showMyPersonalEvents"
                                                                    @change="FetchData">
                                                                <label style="margin-left: 15%;">My Personal
                                                                    Events</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="background-color: #D5D911; color:white;width:50%;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="6" @change="filterEvents()">
                                                                <label style="margin-left:15%;">ORD</label>
                                                            </td>
                                                            <td
                                                                style="background-color: #607D8B; color:#fff;padding:9px;width:50%;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="9" @change="filterEvents()">
                                                                <label style="margin-left:15%;">Batangas</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background-color: #E60785; color:white;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="5" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">FAD</label>
                                                            </td>
                                                            <td
                                                                style="background-color:#FF9800 ; color:white;;padding:9px;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="10" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">Cavite</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background-color: #48BD0D; color:white;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="7" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">LGCDD</label>
                                                            </td>
                                                            <td
                                                                style="background-color:#009688; color:white;;padding:9px;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="11" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">Laguna</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background-color: #E6680E; color:white;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="3" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">MBRTG</label>
                                                            </td>
                                                            <td
                                                                style="background-color:#81D4FA; color:white;;padding:9px;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="13" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">Rizal</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background-color: #0071c5; color:white;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="8" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">LGMED</label>
                                                            </td>
                                                            <td
                                                                style="background-color:#d50000; color:white;;padding:9px;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="12" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">Quezon</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background-color: #8F0CC7; color:white;">
                                                                <input class="calFilter" data-id="9" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="4" @change="filterEvents()"><label
                                                                    style="margin-left:15%;">PDMU</label>
                                                            </td>
                                                            <td
                                                                style="background-color: #FFEB3B; color:white;;padding:9px;">
                                                                <input class="calFilter" type="checkbox"
                                                                    name="offices[]" v-model="selectedOffices"
                                                                    :value="14" @change="filterEvents()"><label
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
                </div>
                <FooterVue />
            </div>
        </div>
        <EventModal :visible="modalVisible" :mode="mode" @close="closeModal" @save="saveEventData" @delete="deleteEvent"
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
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
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
                plugins: [
                    dayGridPlugin,
                    interactionPlugin,
                ],
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
                dayMaxEvents: 3,
                customButtons: {
                    AddEvent: {
                        text: '+ Add Event',
                        click: this.handleCustomButtonClick,
                    },
                },
                eventContent: (arg) => {
                    const event = arg.event;
                    const duration = moment(event.end).diff(moment(event.start), 'days');
                    const isLongEvent = duration > 1;

                    return {
                        html: `<div class="fc-event-main-frame">
                ${isLongEvent ? `<div class="fc-event-time">${moment(event.start).format('MMM D')} - ${moment(event.end).format('MMM D')}</div>` : ''}
                <div class="fc-event-title">${event.title}</div>
            </div>`
                    };
                },
            },
            selectedOffices: [0],
            showMyPersonalEvents: true,
            UpcomingEvents: [],
            MyUpcomingEvents: [],
            philippineHolidays: [],
        }
    },
    created() {
        this.userId = localStorage.getItem('userId');
        this.EventData();
        this.FetchData();
        this.fetchAuthor();
    },
    computed: {
        currentMonth() {
            return moment().format('MMMM YYYY'); // Returns the current month and year
        },
        currentYear() {
            return moment().format('YYYY'); // Returns the current month and year
        },
        FormattedFDate() {
            return function (DateString) {
                return moment(DateString).format('MMMM DD, YYYY');
            };
        },
        mergedEvents() {
            // Filter only personal events and holidays
            return this.events.filter(event => event.isHoliday || event.personnalevent);
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
            this.modalVisible = false; // Hide the modal
            this.mode = ''; // Reset the mode
        },
        openModal(mode) {
            this.mode = mode; // Set the mode ('add' or 'edit')
            this.modalVisible = true; // Show the modal

            // Set isDisabledFlag and isEditMode based on the mode
            if (mode === 'edit') {
                this.isDisabledFlag = false; // Enable fields in 'edit' mode initially
                this.isEditMode = true; // Set edit mode to true
            } else if (mode === 'add') {
                this.isDisabledFlag = false; // Enable fields in 'add' mode
            }
        },
        handleCustomButtonClick() {
            this.ClearEvents()
            this.eventDetails.postedBy = this.posted_by;
            this.openModal('add')
        },
        EventData() {
            const startOfMonth = moment().startOf('month').format('YYYY-MM-DD HH:mm:ss');
            const endOfMonth = moment().endOf('month').format('YYYY-MM-DD HH:mm:ss');

            axios.get(`/api/dashboardEventData`, {
                params: {
                    start: startOfMonth,
                    end: endOfMonth,
                },
            })
                .then(response => {
                    // Store all events
                    this.UpcomingEvents = response.data.map(event => ({
                        ...event,
                        start: moment(event.start).format('YYYY-MM-DD HH:mm:ss'),
                        end: moment(event.end).format('YYYY-MM-DD HH:mm:ss'),
                    }));

                    // 🔹 Instead of making another API call, filter personal events here
                    this.MyUpcomingEvents = this.UpcomingEvents.filter(event => event.userId === this.userId);
                })
                .catch(error => {
                    console.error('Error Fetching events:', error);
                });
        },
        FetchData() {
            const allOfficesSelected = this.selectedOffices.includes('0');
            const showPersonalEvents = this.showMyPersonalEvents;
            const userId = this.userId;

            if (this.selectedOffices.length === 0 && !showPersonalEvents) {
                this.calendarOptions.events = [];
                this.events = [];
                this.$refs.calendar.getApi().refetchEvents();
                return;
            }

            // Fetch events from your API
            axios.get('/api/fetchEventData', {
                params: {
                    office: allOfficesSelected ? '0' : this.selectedOffices.join(','),
                    personnalevent: showPersonalEvents ? 1 : 0,
                    user_id: userId,
                }
            })
                .then(response => {
                    // Process the events response data
                    const events = response.data.map(event => {
                        const startDate = moment(event.start);
                        const endDate = moment(event.end);
                        const duration = endDate.diff(startDate, 'days');

                        return {
                            ...event,
                            allDay: duration > 1,
                            start: startDate.format('YYYY-MM-DD HH:mm:ss'),
                            end: endDate.format('YYYY-MM-DD HH:mm:ss'),
                            backgroundColor: event.color || '#48BD0D',
                        };
                    });

                    // Fetch Philippine Holidays and merge with events
                    axios.get(`https://date.nager.at/api/v3/PublicHolidays/${new Date().getFullYear()}/PH`)
                        .then(holidayResponse => {
                            const holidays = holidayResponse.data.map(holiday => ({
                                title: holiday.localName,
                                start: holiday.date,
                                allDay: true,
                                backgroundColor: '#665878',
                                borderColor: '#665878',
                                textColor: '#FFFFFF',
                                isHoliday: true
                            }));

                            // Merge events and holidays
                            this.calendarOptions.events = [...events, ...holidays];
                            this.events = [...events, ...holidays];

                            // Refresh calendar
                            this.$refs.calendar.getApi().refetchEvents();
                        })
                        .catch(error => {
                            console.error('Error fetching Philippine holidays:', error);
                            // If holidays fail, still update events
                            this.calendarOptions.events = events;
                            this.events = events;
                            this.$refs.calendar.getApi().refetchEvents();
                        });

                    this.EventData();
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while fetching events. Please try again later.',
                    });
                });
        },
        handleEventClick(arg) {
            const event = this.events.find(event => event.id === +arg.event.id) || this.events.find(event => event.title === arg.event.title);

            if (!event) return;

            const formatDateForInput = (date) => {
                const dateObj = new Date(date);
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            if (event.isHoliday) {
                // Show alert for holiday events instead of opening the modal
                Swal.fire({
                    icon: 'info',
                    title: event.title,
                    text: `This is a public holiday on ${formatDateForInput(event.start)}.`,
                    confirmButtonText: 'OK'
                });
                return; // Prevent further execution
            }

            // Handle regular event click by opening the modal
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
            const event = this.events.find(e => e.id === +info.event.id);

            if (!event) return;

            // Prevent holiday events from being moved
            if (event.isHoliday) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Action Not Allowed',
                    text: 'Public holidays cannot be moved.',
                    confirmButtonText: 'OK'
                });

                // Revert the holiday event to its original position
                info.revert();
                return;
            }

            const eventAuthor = event.postedBy || event.fname || event.createdBy;

            if (String(eventAuthor) !== String(this.posted_by)) {
                Swal.fire({
                    title: 'Error',
                    text: 'You do not have permission to update this event.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                });

                // Revert the event back to its original position
                info.revert();
                return;
            }

            const updatedEvent = {
                id: info.event.id,
                start: moment(info.event.start).format('YYYY-MM-DD HH:mm:ss'),
                end: moment(info.event.end || info.event.start).format('YYYY-MM-DD HH:mm:ss')
            };

            // Send the updated event data to the server
            axios.post('/api/PostUpdateDragDrop', updatedEvent)
                .then(() => {
                    toast.success('Event Updated!', { autoClose: 1000 });
                    this.FetchData();
                })
                .catch(error => {
                    console.error('Error updating event:', error);
                    info.revert();
                });
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
                                color: this.eventDetails.personnalevent ? '#DAA520' : emp_data.DIVISION_COLOR,
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
                        this.modalVisible = false;
                        this.isDisabledFlag = true;
                        this.FetchData();
                    })
                    .catch(error => {
                        console.error('error saving data', error)
                    })
            }
        },
        deleteEvent(id) {
            if (this.eventDetails.postedBy !== this.posted_by) {
                Swal.fire({
                    title: 'Error',
                    text: 'You do not have permission to delete this event.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/DeleteEvent', { id: id })
                        .then(() => {
                            toast.success('Event Deleted!', {
                                autoClose: 1000
                            });
                            this.FetchData(); // Refresh the event list
                            this.closeModal(); // Close the modal
                        })
                        .catch(error => {
                            console.error('Error deleting event:', error);
                        });
                }
            });
        },
    }
};
</script>

<style scoped>
.scrollable-card-body {
    overflow-y: scroll;
    height: 300px;
}

.text-blue {
    color: blue;
}

.fc {
    /* the calendar root */
    max-width: 1100px;
    margin: 0 auto;
}

.fc-event {
    margin: 1px 2px 0;
    padding: 2px 4px;
    overflow: visible;
    white-space: normal;
    /* Allow text to wrap */
    word-break: break-word;
    /* Prevent text overflow */
}

.fc-event-main-frame {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: 2px 4px;
}

.fc-event-time {
    font-size: 0.8em;
    font-weight: bold;
    margin-bottom: 2px;
}

.fc-event-title {
    font-size: 0.9em;
    color: #fff;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
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

.card {
    position: relative;
}

.fixed-header {
    position: sticky;
    top: 0;
    background: white;
    z-index: 1000;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.scrollable-card-body {
    max-height: 400px;
    /* Adjust height as needed */
    overflow-y: auto;
}
</style>
