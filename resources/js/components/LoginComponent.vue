<template>
    <div>
        <header>
            <nav class="nav navbar navbar-expand-md navbar-dark fixed-top navscroll" style="background-color: #1e1e2d;">
                <div class="container-fluid">
                    <router-link class="navbar-brand" to="/">QMS-Centris</router-link>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation" @click="toggleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse pull-right" :class="{ 'show': isNavbarOpen }"
                        id="navbarCollapse">
                        <form @submit.prevent="loginUser">
                            <div class="form-group">
                                <input type="text" v-model="form.username" class="form-control form-control-lg"
                                    id="exampleInputEmail1" placeholder="Username" style="font-family:'Poppins'">
                            </div>
                            <div class="form-group ml-2">
                                <input type="password" v-model="form.password" class="form-control form-control-lg"
                                    id="exampleInputPassword1" placeholder="Password"
                                    style="font-family:'Poppins';height: 40px;">
                            </div>
                            <div>
                                <button type="submit" class="btn_submit">SIGN IN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
        <div
            class="card-img-overlay flex-grow-1 py-143 bgi-no-repeat d-flex flex-column justify-content-center align-items-start">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 header-margin">
                        <!-- <img :src="header" class="" style="width:1200px;margin-bottom:600px;"/> -->

                        <button type="button" class="btn custom-btn btn-outline-primary btn-fw btn-icon-text"
                            style="top:-40px !important;margin-left:265px;">
                            ONLINE PORTAL
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <!-- <section class="section-img-overlay">

        </section>
        <section class="section-img-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mb-4 mt-5">
                        <h1 class="programs">Quality Procedures</h1>
                    </div>
                    <div class="col-lg-6 custom-text">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                            galley of type and scrambled it to make a type specimen book. It has survived not only five
                            centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                            passages, and more recently with desktop publishing software like Aldus PageMaker including
                            versions of Lorem Ipsum.</p>
                    </div>
                    <div class="col-lg-6 custom-text">
                        <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                            galley of type and scrambled it to make a type specimen book. It has survived not only five
                            centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                            passages, and more recently with desktop publishing software like Aldus PageMaker including
                            versions of Lorem Ipsum.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section2-img-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mb-4 mt-5">
                        <h1 class="programs">Frequency of Monitoring</h1>
                    </div>
                    <div class="col-lg-6">
                    </div>
                    <div class="col-lg-6 custom-text">
                        <ul>

                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/43"
                                    style="color:darkgreen;">ACTS Conducts Its First Virtual Recognition Day for Senior
                                    High
                                    School</a></li>
                            <hr>
                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/44"
                                    style="color:darkgreen;">ACTS COMPUTER COLLEGE HATID-ARAL SA BARANGAY</a></li>
                            <hr>
                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/45"
                                    style="color:darkgreen;">ACTS COMPUTER COLLEGE DISTRIBUTION OF TERTIARY EDUCATION
                                    SUBSIDY (TES) FOR THE COLLEGE STUDENTS</a></li>
                            <hr>
                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/46"
                                    style="color:darkgreen;">ACTS COMPUTER COLLEGE VIRTUAL STUDENTS’ AND PARENTS’
                                    ORIENTATION 2020 OF THE COLLEGE DEPARTMENT</a></li>
                            <hr>
                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/47"
                                    style="color:darkgreen;">ACTS COMPUTER COLLEGE SENIOR HIGH SCHOOL (SHS) DEPARTMENT
                                    VIRTUAL PARENTS’ ORIENTATION 2020</a></li>
                            <hr>
                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/39"
                                    style="color:darkgreen;">ACTS FACULTY AND STAFF CHRISTMAS PARTY 2019: A Blissful Day
                                    Full of Blessings</a></li>
                            <hr> <button type="button" class="btn btn-success showdiv" style="opacity: 1;"> <a
                                    style="color:#fff;" href="https://actscc.edu.ph/news/">READ MORE
                                    NEWS</a><a></a></button><a>

                            </a>
                        </ul>
                    </div>
                </div>
            </div>

        </section>
        <section class="section3-img-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mb-4 mt-5">
                        <h1 class="programs">Management Reviews</h1>
                    </div>

                    <div class="col-lg-4 custom-text">
                        <ul>

                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/43"
                                    style="color:darkgreen;">ACTS Conducts Its First Virtual Recognition Day for Senior
                                    High
                                    School</a></li>
                            <hr>
                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/44"
                                    style="color:darkgreen;">ACTS COMPUTER COLLEGE HATID-ARAL SA BARANGAY</a></li>
                            <hr>
                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/45"
                                    style="color:darkgreen;">ACTS COMPUTER COLLEGE DISTRIBUTION OF TERTIARY EDUCATION
                                    SUBSIDY (TES) FOR THE COLLEGE STUDENTS</a></li>
                            <hr>
                            <li class="showdiv" style="opacity: 1;"><a href="https://actscc.edu.ph/news/46"
                                    style="color:darkgreen;">ACTS COMPUTER COLLEGE VIRTUAL STUDENTS’ AND PARENTS’
                                    ORIENTATION 2020 OF THE COLLEGE DEPARTMENT</a></li>
                            <hr>

                            <hr> <button type="button" class="btn btn-success showdiv" style="opacity: 1;"> <a
                                    style="color:#fff;" href="https://actscc.edu.ph/news/">READ MORE
                                    NEWS</a><a></a></button><a>

                            </a>
                        </ul>

                    </div>
                    <div class="col-lg-8">
                        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="banner-item1 zoom-bg5"
                                        style="background-size: cover; background-repeat: no-repeat; background-position: center; height: 350px; width: 100%; border-radius: 20px;">
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="banner-item2 zoom-bg4"
                                        style="background-size: cover; background-repeat: no-repeat; background-position: center; height: 350px; width: 100%; border-radius: 20px;">
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="banner-item3 zoom-bg4"
                                        style="background-size: cover; background-repeat: no-repeat; background-position: center; height: 350px; width: 100%; border-radius: 20px;">
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="banner-item4 zoom-bg4"
                                        style="background-size: cover; background-repeat: no-repeat; background-position: center; height: 350px; width: 100%; border-radius: 20px;">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-container">
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section4-img-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mb-4 mt-5">
                        <h1 class="management-team">QMS Management Team</h1>
                    </div>
                    <div class="col-lg-3">
                        <div class="card mt-5">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card mt-5">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card mt-5">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card mt-5">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section> -->


    </div>

</template>

<style>
nav form {
    display: flex;
}

.navbar-brand {
    font-family: 'Poppins';
}

nav input[type="text"],
nav input[type="password"],
nav input[type="submit"] {
    padding: 5px;
    margin-right: 5px;
    border: none;
    border-radius: 3px;
}

.custom-btn {
    font-family: 'Poppins';
    font-size: 50pt;
    font-weight: bolder;
}

.carousel-control-prev {
    background-color: rgb(3, 58, 33);
    width: 40px !important;
    height: 40px !important;
    padding: 10px;
    border-radius: 50%;
    margin-top: 22%;
    left: -8% !important;
}

.carousel-control-next {
    background-color: rgb(3, 58, 33);
    width: 40px !important;
    height: 40px !important;
    padding: 10px;
    border-radius: 50%;
    margin-top: 22%;
    right: -8% !important;
}

/* =========================================================================================== */
.zoom-bg4 {
    width: 200%;
    overflow: hidden;
}

.zoom-bg4:before {
    content: '';
    display: block;
    width: 100%;
    height: 100%;
    background-size: cover;
    transition: all .3s ease-in-out;
}

.zoom-bg4:hover:before {
    transform: scale(1.2);
}

/* =========================================================================================== */
.zoom-bg5 {
    width: 200%;
    overflow: hidden;
}

.zoom-bg5:before {
    content: '';
    display: block;
    width: 100%;
    height: 100%;
    background-size: cover;
    transition: all .3s ease-in-out;
}

.zoom-bg5:hover:before {
    transform: scale(1.2);
}

.banner-item1 {
    background-image: url('../../../assets/images/banner1.png');
}

.banner-item2 {
    background-image: url('../../../assets/images/banner2.png');
}

.banner-item3 {
    background-image: url('../../../assets/images/banner3.png');
}

.banner-item4 {
    background-image: url('../../../assets/images/banner4.png');
}


@keyframes blink {
    0% {
        background-color: #fff;
        /* Initial background color */
        color: #059886;
        /* Initial text color */
    }

    50% {
        background-color: #059886;
        /* Blinking color */
        color: #fff;
        /* White text color */
    }

    100% {
        background-color: #fff;
        /* Return to initial background color */
        color: #059886;
        /* Return to initial text color */
    }
}

.blinking_btn {
    animation: blink 1s infinite;
    /* Blink animation */
}

.btn_submit {
    color: #fff;
    background-color: #059886;
    border-color: #059886;
    margin-left: 10px;
    line-height: 1;
    font-weight: 400;
    height: 40px;
    border-radius: 5px;
    font-family: 'Poppins';
}

.programs {
    color: #05155e;
    text-align: center;
    font-size: 30pt;
    font-family: 'Poppins'
}

.management-team {
    color: #fff;
    text-align: center;
    font-size: 30pt;
    font-family: 'Poppins'
}

.custom-text a {
    color: #05155e !important;
    font-size: 12pt;
    font-family: 'Poppins'
}

.custom-text p {
    color: #05155e !important;
    font-size: 12pt;
    font-family: 'Poppins'
}

.section_vle {
    background-color: #ffffff;
    color: #fff;
    height: 600px;

}

.card-img-overlay {
    background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 255, 170, 0.2)),
        url('../../../assets/images/img-wall.png');
    width: auto;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.header-margin {
    margin-top: 205px;
}

.typing-text {
    white-space: nowrap;
    overflow: hidden;
    animation: typing 5s steps(40) infinite;
}

.section-img-overlay {
    height: 750px;
    background-size: 100% 100%;
    background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 255, 170, 0.3)),
        url('../../../assets/images/section1.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.section2-img-overlay {
    height: 750px;
    background-size: 100% 100%;
    background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 255, 170, 0.3)),
        url('../../../assets/images/section2.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.section3-img-overlay {
    height: 550px;
    background-size: 100% 100%;
    background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 255, 170, 0.3));
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.section4-img-overlay {
    height: 500px;
    background-size: 100% 100%;
    background-color: #05155e;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
</style>
<script>
import SelectInput from "./micro/SelectInput.vue";

import dilg_banner from "../../../assets/images/login.png";
import content_img from "../../../assets/images/content-page.jpg";

import banner from "../../../assets/images/banner.png";
import axios from 'axios';
import { toast } from "vue3-toastify";

export default {
    name: 'Login',
    data() {
        return {
            isNavbarOpen: false,
            dilg_banner: dilg_banner,
            content_page: content_img,
            header: banner,
            results: {},
            form: {
                email: '',
                password: '',
            },
            errors: []
        }
    },
    mounted() {
        // this.renderChart();
        // this.renderSalesChart();
        // this.renderDetailedReportChart();
    },
    methods: {
        toggleNavbar() {
            this.isNavbarOpen = !this.isNavbarOpen;
        },
        showFailedNotification(message) {
            toast.error(message, {
                autoClose: 1000,
            });
        },
        showSuccessNotification(message) {
            toast.success(message, {
                autoClose: 1000,
            });
        },
        // Login component
        loginUser() {
            axios
                .post('/api/login', this.form)
                .then(response => {
                    if (response.data.status) {
                        // Storing user details in localStorage for global access
                        localStorage.setItem('userId', response.data.userId);
                        localStorage.setItem('user_role', response.data.user_role);
                        localStorage.setItem('api_token', response.data.api_token);
                        localStorage.setItem('isUpdatedPassword', response.data.isUpdatedPassword);
                        console.log(response.data.isUpdatedPassword);

                        // Showing success notification
                        this.showSuccessNotification('You are logged in');

                        // Request notification permission
                        this.requestNotificationPermission();

                        // Redirect to dashboard after 1 second
                        setTimeout(() => {
                            this.$router.push({ name: 'Dashboard' });
                        }, 1000);
                    } else {
                        this.showFailedNotification('Login Failed');
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data) {
                        // Display server-side errors
                        this.errors = error.response.data.errors;
                    } else {
                        // Log any other errors
                        console.log(error);
                    }
                });
        },
        // Method to request notification permission
        requestNotificationPermission() {
            if (Notification.permission === 'granted') {
                // Permission already granted, notifications can be shown
                console.log('Notification permission already granted.');
            } else if (Notification.permission !== 'denied') {
                // Request notification permission from the user
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        console.log('Notification permission granted.');
                        // Optional: Show a welcome notification
                        new Notification('Welcome!', { body: 'You are now logged in.' });
                    } else {
                        console.log('Notification permission denied.');
                    }
                });
            }
        },

        // renderDetailedReportChart() {
        //     if ($("#stat").length) {
        //         var SalesChartCanvas = $("#stat").get(0).getContext("2d");
        //         var SalesChart = new Chart(SalesChartCanvas, {
        //             type: 'horizontalBar',
        //             data: {
        //                 labels: ["REGION I", "REGION II", "REGION III - CENTRAL LUZON", "REGION IV-A", "REGION V - BICOL REGION", "REGION VI - WESTERN VISAYAS", "REGION VII - CENTRAL VISAYAS", "REGION VIII - EASTERN VISAYAS", "REGION IX - ZAMBOANGA PENINSULA", "REGION X - NORTHERN MINDANAO", "REGION XI - DAVAO REGION", "REGION XII - SOCCSSARGEN", "NATIONAL CAPITAL REGION", "CORDILLERA ADMINISTRATIVE REGION", "AUTONOMOUS REGION IN MUSLIM MINDANAO", "REGION XIII - CARAGA", "MIMAROPA"],
        //                 datasets: [{
        //                     label: 'Sex',
        //                     data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],

        //                     backgroundColor: '#98BDFF'
        //                 },
        //                 {
        //                     label: 'Age',
        //                     data: [480, 230, 470, 24310, 33430, 3433, 230, 4750, 33, 2552, 4580, 736, 4750, 2310, 464, 3544],
        //                     backgroundColor: '#4B49AC'
        //                 },
        //                 {
        //                     label: 'Total',
        //                     data: [480, 230, 4470, 2310, 344, 34343, 230, 4750, 2150, 3554, 4545, 2305, 4570, 2434, 33430, 344],
        //                     backgroundColor: 'rgb(111, 191, 178)'
        //                 },

        //                 ]
        //             },
        //             options: {
        //                 cornerRadius: 5,
        //                 responsive: true,
        //                 maintainAspectRatio: true,
        //                 layout: {
        //                     padding: {
        //                         left: 0,
        //                         right: 0,
        //                         top: 20,
        //                         bottom: 0
        //                     }
        //                 },
        //                 scales: {
        //                     yAxes: [{
        //                         display: true,
        //                         gridLines: {
        //                             display: true,
        //                             drawBorder: false,
        //                             color: "#F2F2F2"
        //                         },
        //                         ticks: {
        //                             display: true,
        //                             min: 0,
        //                             max: 20,
        //                             callback: function (value, index, values) {
        //                                 return value;
        //                             },
        //                             autoSkip: true,
        //                             maxTicksLimit: 10,
        //                             fontColor: "#6C7383"
        //                         }
        //                     }],
        //                     xAxes: [{
        //                         stacked: false,
        //                         ticks: {
        //                             beginAtZero: true,
        //                             fontColor: "#6C7383"
        //                         },
        //                         gridLines: {
        //                             color: "rgba(0, 0, 0, 0)",
        //                             display: false
        //                         },
        //                         barPercentage: 1
        //                     }]
        //                 },
        //                 legend: {
        //                     display: false
        //                 },
        //                 elements: {
        //                     point: {
        //                         radius: 0
        //                     }
        //                 }
        //             },
        //         });
        //         document.getElementById('stat-legend').innerHTML = SalesChart.generateLegend();
        //     }
        //     if ($("#north-america-chart").length) {
        //         var areaData = {
        //             labels: ["Jan", "Feb", "Mar"],
        //             datasets: [{
        //                 data: [100, 50, 50],
        //                 backgroundColor: [
        //                     "#4B49AC", "#FFC100", "#248AFD",
        //                 ],
        //                 borderColor: "rgba(0,0,0,0)"
        //             }]
        //         };
        //         var areaOptions = {
        //             responsive: true,
        //             maintainAspectRatio: true,
        //             segmentShowStroke: false,
        //             cutoutPercentage: 78,
        //             elements: {
        //                 arc: {
        //                     borderWidth: 4
        //                 }
        //             },
        //             legend: {
        //                 display: false
        //             },
        //             tooltips: {
        //                 enabled: true
        //             },
        //             legendCallback: function (chart) {
        //                 var text = [];
        //                 text.push('<div class="report-chart">');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
        //                 text.push('<p class="mb-0">88333</p>');
        //                 text.push('</div>');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
        //                 text.push('<p class="mb-0">66093</p>');
        //                 text.push('</div>');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
        //                 text.push('<p class="mb-0">39836</p>');
        //                 text.push('</div>');
        //                 text.push('</div>');
        //                 return text.join("");
        //             },
        //         }
        //         var northAmericaChartPlugins = {
        //             beforeDraw: function (chart) {
        //                 var width = chart.chart.width,
        //                     height = chart.chart.height,
        //                     ctx = chart.chart.ctx;

        //                 ctx.restore();
        //                 var fontSize = 3.125;
        //                 ctx.font = "500 " + fontSize + "em sans-serif";
        //                 ctx.textBaseline = "middle";
        //                 ctx.fillStyle = "#13381B";

        //                 var text = "90",
        //                     textX = Math.round((width - ctx.measureText(text).width) / 2),
        //                     textY = height / 2;

        //                 ctx.fillText(text, textX, textY);
        //                 ctx.save();
        //             }
        //         }
        //         var northAmericaChartCanvas = $("#north-america-chart").get(0).getContext("2d");
        //         var northAmericaChart = new Chart(northAmericaChartCanvas, {
        //             type: 'doughnut',
        //             data: areaData,
        //             options: areaOptions,
        //             plugins: northAmericaChartPlugins
        //         });
        //         document.getElementById('north-america-legend').innerHTML = northAmericaChart.generateLegend();
        //     }

        //     if ($("#order-chart-dark").length) {
        //         var areaData = {
        //             labels: ["10", "", "", "20", "", "", "30", "", "", "40", "", "", "50", "", "", "60", "", "", "70"],
        //             datasets: [{
        //                 data: [200, 480, 700, 600, 620, 350, 380, 350, 850, "600", "650", "350", "590", "350", "620", "500", "990", "780", "650"],
        //                 borderColor: [
        //                     '#4747A1'
        //                 ],
        //                 borderWidth: 2,
        //                 fill: false,
        //                 label: "Orders"
        //             },
        //             {
        //                 data: [400, 450, 410, 500, 480, 600, 450, 550, 460, "560", "450", "700", "450", "640", "550", "650", "400", "850", "800"],
        //                 borderColor: [
        //                     '#F09397'
        //                 ],
        //                 borderWidth: 2,
        //                 fill: false,
        //                 label: "Downloads"
        //             }
        //             ]
        //         };
        //         var areaOptions = {
        //             responsive: true,
        //             maintainAspectRatio: true,
        //             plugins: {
        //                 filler: {
        //                     propagate: false
        //                 }
        //             },
        //             scales: {
        //                 xAxes: [{
        //                     display: true,
        //                     ticks: {
        //                         display: true,
        //                         padding: 10,
        //                         fontColor: "#fff"
        //                     },
        //                     gridLines: {
        //                         display: false,
        //                         drawBorder: false,
        //                         color: 'transparent',
        //                         zeroLineColor: '#575757'
        //                     }
        //                 }],
        //                 yAxes: [{
        //                     display: true,
        //                     ticks: {
        //                         display: true,
        //                         autoSkip: false,
        //                         maxRotation: 0,
        //                         stepSize: 200,
        //                         min: 200,
        //                         max: 1200,
        //                         padding: 18,
        //                         fontColor: "#fff"
        //                     },
        //                     gridLines: {
        //                         display: true,
        //                         color: "#575757",
        //                         drawBorder: false
        //                     }
        //                 }]
        //             },
        //             legend: {
        //                 display: false
        //             },
        //             tooltips: {
        //                 enabled: true
        //             },
        //             elements: {
        //                 line: {
        //                     tension: .35
        //                 },
        //                 point: {
        //                     radius: 0
        //                 }
        //             }
        //         }
        //         var revenueChartCanvas = $("#order-chart-dark").get(0).getContext("2d");
        //         var revenueChart = new Chart(revenueChartCanvas, {
        //             type: 'line',
        //             data: areaData,
        //             options: areaOptions
        //         });
        //         document.getElementById('order-legend').innerHTML = revenueChart.generateLegend();

        //     }

        //     if ($("#sales-chart-dark").length) {
        //         var SalesChartCanvas = $("#sales-chart-dark").get(0).getContext("2d");
        //         var SalesChart = new Chart(SalesChartCanvas, {
        //             type: 'bar',
        //             data: {
        //                 labels: ["Jan", "Feb", "Mar", "Apr", "May"],
        //                 datasets: [{
        //                     label: 'Offline Sales',
        //                     data: [480, 230, 470, 210, 330],
        //                     backgroundColor: '#98BDFF'
        //                 },
        //                 {
        //                     label: 'Online Sales',
        //                     data: [400, 340, 550, 480, 170],
        //                     backgroundColor: '#4B49AC'
        //                 }
        //                 ]
        //             },
        //             options: {
        //                 cornerRadius: 5,
        //                 responsive: true,
        //                 maintainAspectRatio: true,
        //                 layout: {
        //                     padding: {
        //                         left: 0,
        //                         right: 0,
        //                         top: 20,
        //                         bottom: 0
        //                     }
        //                 },
        //                 scales: {
        //                     yAxes: [{
        //                         display: true,
        //                         gridLines: {
        //                             display: true,
        //                             drawBorder: false,
        //                             color: "#575757"
        //                         },
        //                         ticks: {
        //                             display: true,
        //                             min: 0,
        //                             max: 500,
        //                             callback: function (value, index, values) {
        //                                 return value + '$';
        //                             },
        //                             autoSkip: true,
        //                             maxTicksLimit: 10,
        //                             fontColor: "#F0F0F0"
        //                         }
        //                     }],
        //                     xAxes: [{
        //                         stacked: false,
        //                         ticks: {
        //                             beginAtZero: true,
        //                             fontColor: "#F0F0F0"
        //                         },
        //                         gridLines: {
        //                             color: "#575757",
        //                             display: false
        //                         },
        //                         barPercentage: 1
        //                     }]
        //                 },
        //                 legend: {
        //                     display: false
        //                 },
        //                 elements: {
        //                     point: {
        //                         radius: 0
        //                     }
        //                 }
        //             },
        //         });
        //         document.getElementById('sales-legend').innerHTML = SalesChart.generateLegend();
        //     }

        //     if ($("#south-america-chart").length) {
        //         var areaData = {
        //             labels: ["Jan", "Feb", "Mar"],
        //             datasets: [{
        //                 data: [60, 70, 70],
        //                 backgroundColor: [
        //                     "#4B49AC", "#FFC100", "#248AFD",
        //                 ],
        //                 borderColor: "rgba(0,0,0,0)"
        //             }]
        //         };
        //         var areaOptions = {
        //             responsive: true,
        //             maintainAspectRatio: true,
        //             segmentShowStroke: false,
        //             cutoutPercentage: 78,
        //             elements: {
        //                 arc: {
        //                     borderWidth: 4
        //                 }
        //             },
        //             legend: {
        //                 display: false
        //             },
        //             tooltips: {
        //                 enabled: true
        //             },
        //             legendCallback: function (chart) {
        //                 var text = [];
        //                 text.push('<div class="report-chart">');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
        //                 text.push('<p class="mb-0">495343</p>');
        //                 text.push('</div>');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
        //                 text.push('<p class="mb-0">630983</p>');
        //                 text.push('</div>');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
        //                 text.push('<p class="mb-0">290831</p>');
        //                 text.push('</div>');
        //                 text.push('</div>');
        //                 return text.join("");
        //             },
        //         }
        //         var southAmericaChartPlugins = {
        //             beforeDraw: function (chart) {
        //                 var width = chart.chart.width,
        //                     height = chart.chart.height,
        //                     ctx = chart.chart.ctx;

        //                 ctx.restore();
        //                 var fontSize = 3.125;
        //                 ctx.font = "600 " + fontSize + "em sans-serif";
        //                 ctx.textBaseline = "middle";
        //                 ctx.fillStyle = "#000";

        //                 var text = "76",
        //                     textX = Math.round((width - ctx.measureText(text).width) / 2),
        //                     textY = height / 2;

        //                 ctx.fillText(text, textX, textY);
        //                 ctx.save();
        //             }
        //         }
        //         var southAmericaChartCanvas = $("#south-america-chart").get(0).getContext("2d");
        //         var southAmericaChart = new Chart(southAmericaChartCanvas, {
        //             type: 'doughnut',
        //             data: areaData,
        //             options: areaOptions,
        //             plugins: southAmericaChartPlugins
        //         });
        //         document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
        //     }
        //     if ($("#south-america-chart-dark").length) {
        //         var areaData = {
        //             labels: ["Jan", "Feb", "Mar"],
        //             datasets: [{
        //                 data: [60, 70, 70],
        //                 backgroundColor: [
        //                     "#4B49AC", "#FFC100", "#248AFD",
        //                 ],
        //                 borderColor: "rgba(0,0,0,0)"
        //             }]
        //         };
        //         var areaOptions = {
        //             responsive: true,
        //             maintainAspectRatio: true,
        //             segmentShowStroke: false,
        //             cutoutPercentage: 78,
        //             elements: {
        //                 arc: {
        //                     borderWidth: 4
        //                 }
        //             },
        //             legend: {
        //                 display: false
        //             },
        //             tooltips: {
        //                 enabled: true
        //             },
        //             legendCallback: function (chart) {
        //                 var text = [];
        //                 text.push('<div class="report-chart">');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
        //                 text.push('<p class="mb-0">495343</p>');
        //                 text.push('</div>');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
        //                 text.push('<p class="mb-0">630983</p>');
        //                 text.push('</div>');
        //                 text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
        //                 text.push('<p class="mb-0">290831</p>');
        //                 text.push('</div>');
        //                 text.push('</div>');
        //                 return text.join("");
        //             },
        //         }
        //         var southAmericaChartPlugins = {
        //             beforeDraw: function (chart) {
        //                 var width = chart.chart.width,
        //                     height = chart.chart.height,
        //                     ctx = chart.chart.ctx;

        //                 ctx.restore();
        //                 var fontSize = 3.125;
        //                 ctx.font = "600 " + fontSize + "em sans-serif";
        //                 ctx.textBaseline = "middle";
        //                 ctx.fillStyle = "#fff";

        //                 var text = "76",
        //                     textX = Math.round((width - ctx.measureText(text).width) / 2),
        //                     textY = height / 2;

        //                 ctx.fillText(text, textX, textY);
        //                 ctx.save();
        //             }
        //         }
        //         var southAmericaChartCanvas = $("#south-america-chart-dark").get(0).getContext("2d");
        //         var southAmericaChart = new Chart(southAmericaChartCanvas, {
        //             type: 'doughnut',
        //             data: areaData,
        //             options: areaOptions,
        //             plugins: southAmericaChartPlugins
        //         });
        //         document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
        //     }

        // },
        // renderChart() {
        //     if (document.getElementById('order-chart')) {
        //         const areaData = {
        //             labels: ['10', '', '', '20', '', '', '30', '', '', '40', '', '', '50', '', '', '60', '', '', '70'],
        //             datasets: [
        //                 {
        //                     data: [
        //                         200, 480, 700, 600, 620, 350, 380, 350, 850, '1000', '650', '350', '590', '350', '620', '500', '990', '780', '650',
        //                     ],
        //                     borderColor: ['#4747A1'],
        //                     borderWidth: 2,
        //                     fill: false,
        //                     label: 'Orders',
        //                 },
        //                 {
        //                     data: [
        //                         400, 450, 410, 500, 480, 600, 450, 550, 460, '125000', '450', '700', '450', '640', '550', '650', '400', '850', '800',
        //                     ],
        //                     borderColor: ['#F09397'],
        //                     borderWidth: 2,
        //                     fill: false,
        //                     label: 'Downloads',
        //                 },
        //             ],
        //         };

        //         const areaOptions = {
        //             responsive: true,
        //             maintainAspectRatio: true,
        //             plugins: {
        //                 filler: {
        //                     propagate: false,
        //                 },
        //             },
        //             scales: {
        //                 xAxes: [
        //                     {
        //                         display: true,
        //                         ticks: {
        //                             display: true,
        //                             padding: 10,
        //                             fontColor: '#6C7383',
        //                         },
        //                         gridLines: {
        //                             display: false,
        //                             drawBorder: false,
        //                             color: 'transparent',
        //                             zeroLineColor: '#eeeeee',
        //                         },
        //                     },
        //                 ],
        //                 yAxes: [
        //                     {
        //                         display: true,
        //                         ticks: {
        //                             display: true,
        //                             autoSkip: false,
        //                             maxRotation: 0,
        //                             stepSize: 200,
        //                             min: 200,
        //                             max: 1200,
        //                             padding: 18,
        //                             fontColor: '#6C7383',
        //                         },
        //                         gridLines: {
        //                             display: true,
        //                             color: '#f2f2f2',
        //                             drawBorder: false,
        //                         },
        //                     },
        //                 ],
        //             },
        //             legend: {
        //                 display: false,
        //             },
        //             tooltips: {
        //                 enabled: true,
        //             },
        //             elements: {
        //                 line: {
        //                     tension: 0.35,
        //                 },
        //                 point: {
        //                     radius: 0,
        //                 },
        //             },
        //         };

        //         const revenueChartCanvas = document.getElementById('order-chart').getContext('2d');
        //         const revenueChart = new Chart(revenueChartCanvas, {
        //             type: 'line',
        //             data: areaData,
        //             options: areaOptions,
        //         });
        //     }
        // },
        // renderSalesChart() {
        //     if ($("#sales-chart").length) {
        //         var SalesChartCanvas = $("#sales-chart").get(0).getContext("2d");
        //         var SalesChart = new Chart(SalesChartCanvas, {
        //             type: 'bar',
        //             data: {
        //                 labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "August", "September", "October", "November", "December"],
        //                 datasets: [{
        //                     label: 'Offline Sales',
        //                     data: [480, 230, 470, 210, 330, 565, 565, 89, 562, 633, 142, 565],
        //                     backgroundColor: '#059886'
        //                 },
        //                 {
        //                     label: 'Online Sales',
        //                     data: [400, 340, 550, 480, 170, 4564, 566, 4566, 555, 696, 223],
        //                     backgroundColor: '#18d8c1'
        //                 }
        //                 ]
        //             },
        //             options: {
        //                 cornerRadius: 5,
        //                 responsive: true,
        //                 maintainAspectRatio: true,
        //                 layout: {
        //                     padding: {
        //                         left: 0,
        //                         right: 0,
        //                         top: 20,
        //                         bottom: 0
        //                     }
        //                 },
        //                 scales: {
        //                     yAxes: [{
        //                         display: true,
        //                         gridLines: {
        //                             display: true,
        //                             drawBorder: false,
        //                             color: "#F2F2F2"
        //                         },
        //                         ticks: {
        //                             display: true,
        //                             min: 0,
        //                             max: 560,
        //                             callback: function (value, index, values) {
        //                                 return value + '$';
        //                             },
        //                             autoSkip: true,
        //                             maxTicksLimit: 10,
        //                             fontColor: "#6C7383"
        //                         }
        //                     }],
        //                     xAxes: [{
        //                         stacked: false,
        //                         ticks: {
        //                             beginAtZero: true,
        //                             fontColor: "#6C7383"
        //                         },
        //                         gridLines: {
        //                             color: "rgba(0, 0, 0, 0)",
        //                             display: false
        //                         },
        //                         barPercentage: 1
        //                     }]
        //                 },
        //                 legend: {
        //                     display: false
        //                 },
        //                 elements: {
        //                     point: {
        //                         radius: 0
        //                     }
        //                 }
        //             },
        //         });
        //         document.getElementById('sales-legend').innerHTML = SalesChart.generateLegend();
        //     }
        // }
    },
    components: {
        SelectInput
    }
}



</script>