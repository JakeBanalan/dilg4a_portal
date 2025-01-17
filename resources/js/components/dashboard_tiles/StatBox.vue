<template>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card-people mt-auto">
                <img :src="currentImage" alt="people">
                <button @click="prevImage" class="arrow left-arrow">&#9664;</button>
                <button @click="nextImage" class="arrow right-arrow">&#9654;</button>
            </div>
        </div>

        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body" style="overflow-y:scroll;">
                    <p class="card-title">Upcoming Events - {{ currentMonth }}</p>
                    <div class="d-flex align-items-center pb-3 pt-3 border-bottom" v-for="(events, i) in UpcomingEvents"
                        :key="i">
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
    </div>
</template>
<style>
.arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.7);
    border: none;
    font-size: 24px;
    cursor: pointer;
    padding: 10px;
    border-radius: 50%;
    z-index: 10;
    opacity: 30%;
}

.left-arrow {
    left: 10px;
}

.right-arrow {
    right: 10px;
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

.fc-event {
    background-color: #059886;
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
<script>
import dashboard_img1 from "../../../../assets/images/banner1.png";
import dashboard_img2 from "../../../../assets/images/banner2.png"; // Add more images
import dashboard_img3 from "../../../../assets/images/banner3.png";
import dashboard_img4 from "../../../../assets/images/banner3.png";
import moment from 'moment';
export default {
    name: 'StatBox',
    data() {
        return {
            images: [dashboard_img1, dashboard_img2, dashboard_img3, dashboard_img4], // Array of images
            currentIndex: 0,
            currentImage: dashboard_img1,
            total_pr: null,
            total_accounts: null,
            UpcomingEvents: [],
        }
    },
    mounted() {
        this.fetch_total_pr();
        this.fetch_total_accounts();
        this.FetchData();
    },
    computed: {
        currentMonth() {
            return moment().format('MMMM YYYY'); // Returns the current month and year
        },
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

    },
    methods: {
        FetchData() {
            // Get the start and end of the current month
            const startOfMonth = moment().startOf('month').format('YYYY-MM-DD HH:mm:ss');
            const endOfMonth = moment().endOf('month').format('YYYY-MM-DD HH:mm:ss');

            // Fetch data for the current month
            axios.get(`/api/dashboardEventData`, {
                params: {
                    start: startOfMonth,
                    end: endOfMonth,
                },
            })
                .then(response => {
                    this.UpcomingEvents = response.data.map(event => ({
                        ...event,
                        start: moment(event.start).format('YYYY-MM-DD HH:mm:ss'),
                        end: moment(event.end).format('YYYY-MM-DD HH:mm:ss'),
                    }));
                })
                .catch(error => {
                    console.error('Error Fetching items:', error);
                });
        },
        nextImage() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.currentImage = this.images[this.currentIndex];
        },
        prevImage() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length
            this.currentImage = this.images[this.currentIndex];
        },
        fetch_total_pr() {
            this.$count('/api/countPurchaseRequestStatistics', 2024)
                .then(data => {
                    this.total_pr = data.total_pr;
                })
                .catch(error => { console.error(error) });
        },
        fetch_total_accounts() {
            this.$count('/api/getActiveAccounts')
                .then(data => {
                    this.total_accounts = data.total_accounts;
                })
                .catch(error => { console.error(error) });
        }
    },
}
</script>
