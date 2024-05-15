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
                  <FullCalendar class="calendar" :options="calendarOptions" :events="events"/>
                </div>
              </div>
            </div>
            <!--CARDS - Activity Bar-->
            <div class="col-md-3 grid-margin">
              <!-- <div class="card" style="margin-bottom: 0.5em;">
                <div class="card-body">

                  <div class="row justify-content-center">
                    <div class="form-check col" style="display: flex; margin-left: 2em;">
                      <input type="checkbox" class="form-check-input">
                      <label class="form-check-label" style="margin-left: 0.5em;">Cavite</label>
                    </div>

                    <div class="form-check col" style="display: flex; margin-left: 2em;">
                      <input type="checkbox" class="form-check-input">
                      <label class="form-check-label" style="margin-left: 0.5em;">Laguna</label>
                    </div>
                  </div>

                  <div class="row justify-content-center">
                    <div class="form-check col" style="display: flex; margin-left: 2em;">
                      <input type="checkbox" class="form-check-input">
                      <label class="form-check-label" style="margin-left: 0.5em;">Batangas</label>
                    </div>

                    <div class="form-check col" style="display: flex; margin-left: 2em;">
                      <input type="checkbox" class="form-check-input">
                      <label class="form-check-label" style="margin-left: 0.5em;">Rizal</label>
                    </div>
                  </div>

                  <div class="row justify-content-center">
                    <div class="form-check col" style="display: flex; margin-left: 2em;">
                      <input type="checkbox" class="form-check-input">
                      <label class="form-check-label" style="margin-left: 0.5em;">Quezon</label>
                    </div>

                    <div class="form-check col" style="display: flex; margin-left: 2em;">
                      <input type="checkbox" class="form-check-input">
                      <label class="form-check-label" style="margin-left: 0.5em;">Lucena</label>
                    </div>
                  </div>

                  <div class="row justify-content-center">
                    <div class="form-check col" style="display: flex; margin-left: 2em;">
                      <input type="checkbox" class="form-check-input">
                      <label class="form-check-label" style="margin-left: 0.5em;">Regional Office</label>
                    </div>
                  </div>

                </div>
              </div> -->

              <div class="card" style="max-height: 770px !important; overflow:hidden;">
                <div class="card-body" style="overflow-y:scroll;" >
                  <p class="card-title">Upcoming Events</p>
                  <div class="d-flex align-items-center pb-3 pt-3 border-bottom" v-for="(events,i) in UpcomingEvents" :key="i">
                    <div class="move-calendar ms-3">
                      <span style="display: inline-block;">
                        <time class="icon">
                          <em>{{FormattedDay(events.start)}}</em>
                          <strong>{{FormattedMonth(events.start)}}</strong>
                          <span>{{FormattedDate(events.start)}}</span>
                        </time>
                      </span>
                    </div>
                    <div class="ms-3" style="padding-left: 0.3em;">
                      <h6 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" class="mb-0">{{events.title}}</h6>
                      <small class="text-muted mb-0"><i class="ti-timer me-1"></i> {{FormattedFDate(events.start) }} - {{ FormattedFDate(events.end) }}</small>
                    </div>
                  </div>

                  <!-- </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <FooterVue />
      </div>
    </div>
    <EventModal :visible="modalVisible" :mode="mode" @close="closeModal" @save="saveEventData" :eventDetails="eventDetails" />
  </div>
</template>

<script>
import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import EventModal from './EventModal.vue';
import { toast } from "vue3-toastify";


import moment from 'moment';
import axios from 'axios';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { compareByFieldSpecs } from "@fullcalendar/core/internal";
import { faMonument } from "@fortawesome/free-solid-svg-icons";
import { formatDate } from "@fullcalendar/core";

export default {
  components: {
    axios,
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
      events:[],
      eventDetails: {
        title: "",
        start: "",
        end: "",
        office: "",
        description:"",
        venue:"",
        enp:"",
        postedBy:"",
        remarks:""
      },
      mode:'',
      // isEdit:false,
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
          start: 'title',
          center: '',
          end: 'AddEvent prev next today'
        },
        eventClick: this.handleEventClick,
        selectable: true,
        // editable: true,
        // nextDayThreshold: '13:00:00',
        events:[],
        customButtons: {
          AddEvent: {
            text: '+ Add Event',
            click: this.handleCustomButtonClick,
          },
        },
      }

    }
  },
  created(){
    this.FetchData();
    // this.FetchDetails();
  },
  computed: {
    FormattedFDate(){
      return function(DateString){
        return moment(DateString).format('MMMM DD, YYYY');
      };
    },
    FormattedMonth() {
      return function(DateString){
      return moment(DateString).format('MMMM');
    };
  },
    FormattedDate() {
      return function(DateString){
      return moment(DateString).format('DD');
    };
  },
  FormattedDay() {
      return function(DateString){
      return moment(DateString).format('dddd');
    };
  },
  UpcomingEvents(){
    const currentDate = new Date();
    return this.events.filter(events =>{
      const eventDate = new Date(events.start);
      return eventDate >= currentDate;
    })
  }
  },
  methods: {
    ClearEvents(){
      this.eventDetails= {
        title: "",
        start: "",
        end: "",
        office: "",
        description:"",
        venue:"",
        enp:"",
        postedBy:"",
        remarks:""
      }
    },
    closeModal() {
      this.modalVisible = false
      // console.log(this.mode);

      // console.log("close");
    },
    openModal(mode){
      this.mode = mode;
      this.modalVisible = true
      // console.log("open");
      console.log(this.mode);

    },
    handleCustomButtonClick() {
      this.ClearEvents()
      this.openModal('add')
      // this.modalVisible = true
    },
    FetchData() {
        //fullcalendar events
        // Assuming you're using axios for data fetching
        const response = axios.get(`/api/fetchEventData`)
          .then(response => {
            const events = response.data.map(event => ({
              ...event,
              allDay:true
            }));
            this.calendarOptions.events = events
            console.log(this.calendarOptions.events);
          })
          .catch(error => {
            console.error('Error Fetching items:', error);
          });
          
          //event list
          const response1 = axios.get(`/api/fetchEventData`)
          .then(response1 => {
            const events = response1.data.map(event => ({
              ...event,
              allDay:true
            }));
            this.events = events
          })
          .catch(error => {
            console.error('Error Fetching items:', error);
          });
        const events = response1.data; // Adjust this according to your API response structure
        return events;
    },
    handleEventClick(arg) {
      const {id, title , start, end, office, description, venue, enp, fname, remarks} = this.events.find(
        event => event.id === +arg.event.id
      );
      this.eventDetails = {
        id:id,
        allDay:true,
        title: title,
        start: start,
        end: end,
        office: office,
        description:description,
        venue:venue,
        enp:enp,
        postedBy:fname,
        remarks:remarks
      }
      this.openModal('edit')
      // console.log(this.eventDetails);
    },
    saveEventData(formData) {
      // Here you can insert the formData into your database or perform any other actions
      // console.log(formData); // For demonstration, just log the form data

      if(this.mode == 'add'){
        // console.log(formData)
        axios.post('/api/PostEventData', formData)
        .then(response =>{
          toast.success('Event Added!', {
          autoClose: 1000
        });
        this.FetchData()
        this.closeModal()
        })
        .catch(error => {
          console.error('error saving data',error);
        console.log(formData);

        })
      }else{
        // const response = axios.
        // console.log('edit');
        axios.post('/api/PostUpdateEvent', formData)
        .then(response => {
          toast.success('Event Updated!', {
          autoClose: 1000
        });
        this.FetchData()
        this.closeModal()
        })
        .catch(error =>{
          console.error('error saving data', error)
        })
      }
    }
  }
};
</script>

<style scoped>
/* #059886 COLOR CODE*/
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
