<template>
  <div class="container-scroller">
    <Navbar />
    <div class="container-fluid page-body-wrapper">
      <Sidebar />
      <div class="main-panel">
        <div class="content-wrapper">
          <BreadCrumbs />
          <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <FullCalendar class="calendar" :options="calendarOptions"/>
                </div>
              </div>
            </div>
            <!--CARDS - Activity Bar-->
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body" style="padding: 10px 10px !important;">
                  <p class="mb-4">Today’s Bookings</p>
                  <p class="fs-30 mb-2">4006</p>
                  <p>10.00% (30 days)</p>
                  <div class="list-wrapper" style="max-height:880px !important; overflow: auto !important; ">
                    <ul class="d-flex flex-column todo-list todo-list-custom">
                      <li class="move-calendar">
                        <span style="display: inline-block;">
                          <time class="icon">
                            <em>Friday</em>
                            <strong>March</strong>
                            <span>15</span>
                          </time>
                        </span>
                        <p class="fs mb-4" style="margin-left: 0.5em; font-size:18px; font-weight:bold;">ACTIVITY TITLE
                        </p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <FooterVue />
      </div>
    </div>
    <EventModal :visible="modalVisible" @close="closeModal"/>
  </div>
</template>

<script>
import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import EventModal from './EventModal';

import { defineComponent } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import bootstrapPlugin from '@fullcalendar/bootstrap'

// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-icons/font/bootstrap-icons.css'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import {faChevronRight, faChevronLeft} from '@fortawesome/free-solid-svg-icons';
library.add(faChevronRight,faChevronLeft);

export default defineComponent ({
  components: {
    EventModal,
    FullCalendar,
    Navbar,
    Sidebar,
    FooterVue,
    BreadCrumbs
  },
  data() {
    return {
      modalVisible: false,
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin, bootstrapPlugin],
        themeSystem:'bootstrap',
        initialView: 'dayGridMonth',
        headerToolbar: {
          start:'title',
          center: '',
          end: 'prev,today,next'
        },
        buttonIcons: {
          prev: 'chevrons-left',
          next: 'chevrons-right'
        },
        dateClick: this.handleDateClick,
        eventClick: this.handleEventClick,
        selectable: true,
        editable: true,
        select: this.handleDateSelect,
        // eventContent: this.renderEventContent, 
        events: [
          { id: '1', title: 'Event 1', start: '2024-02-01', end: '2024-02-03T14:30:00', division: 'LGMED' ,color: '#5233FF '},
          { id: '2', title: 'Event 2', start: '2024-02-05', end: '2024-02-05', division: 'LGCDD' ,color:'#33FFC7'},
          { id: '3', title: 'Event 3', start: '2024-02-14', end: '2024-02-15T15:30:00', division: 'FAD', color: '#E0FF33'},
          { id: '4', title: 'Event 4', start: '2024-02-23', end: '2024-02-23', division: 'ORD', color: '#f8a64b'}
          // Add more events as needed
        ],
      }
    }
  },
  methods: {
    handleDateClick: function (arg) {
      alert('date click! ' + arg.dateStr)
      console.log('event' + arg.dateStr)
    },
    handleDateSelect(info) {
      alert('selected ' + info.startStr + ' to ' + info.endStr);
    },
    handleEventClick() {
      this.modalVisible = true
    },
    closeModal() {
      this.modalVisible = false
    },
  }
});
</script>

<style scoped>

time.icon {
  font-size: 7px; /* change icon size */
  display: block;
  position: relative;
  width: 7em;
  height: 7em;
  background-color: #fff;
  border-radius: 0.6em;
  box-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;
  overflow: hidden;
  -webkit-backface-visibility: hidden;
  -webkit-transform: rotate(0deg) skewY(0deg);
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
  padding: 0.4em 0;
  color: #fff;
  background-color: #4b49ac;
  border-bottom: 1px dashed #4b49ac;
  box-shadow: 0 2px 0 #4b49ac;
}

time.icon em {
  position: absolute;
  bottom: 0.3em;
  color: #4b49ac;
}

time.icon span {
  width: 100%;
  font-size: 2.8em;
  letter-spacing: -0.05em;
  padding-top: 1em;
  color: #2f2f2f;
}

.move-calendar:hover time,
.move-calendar:focus time {
  -webkit-animation: swing 0.6s ease-out;
  animation: swing 0.6s ease-out;
}

@-webkit-keyframes swing {
  0% { -webkit-transform: rotate(0deg) skewY(0deg); }
  20% { -webkit-transform: rotate(12deg) skewY(4deg); }
  60% { -webkit-transform: rotate(-9deg) skewY(-3deg); }
  80% { -webkit-transform: rotate(6deg) skewY(-2deg); }
  100% { -webkit-transform: rotate(0deg) skewY(0deg); }
}

@keyframes swing {
  0% { transform: rotate(0deg) skewY(0deg); }
  20% { transform: rotate(12deg) skewY(4deg); }
  60% { transform: rotate(-9deg) skewY(-3deg); }
  80% { transform: rotate(6deg) skewY(-2deg); }
  100% { transform: rotate(0deg) skewY(0deg); }
}

div::-webkit-scrollbar {
  display: none;
}

/* CALENDAR */
/* .calendar {
  width: 100%;
  background-color: #fff;
} */

.fc-daygrid-event-harness {
  height: 10px !important;
}

</style>
