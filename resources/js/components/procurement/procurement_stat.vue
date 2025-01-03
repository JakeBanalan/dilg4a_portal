<style>
.profile_img {
    width: 100px;
    height: 100px;
    padding: 1px;
    margin-bottom: 15%;
    border-radius: 100%;
    border: 1px solid rgb(18, 15, 76);
}

.user_info {
    display: flex;
    justify-content: space-between;
    margin: 0px;
    vertical-align: middle;
    width: 100%;
}

.rank_banner {
    background-color: rgb(104, 34, 142);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner2 {
    background-color: rgb(128, 22, 22);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner3 {
    background-color: rgb(45, 2, 85);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_wrapper {
    -webkit-clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    height: 4.5rem;
    padding-right: 4px;
    padding-top: 2px;
    position: absolute;
    right: 0px;
    text-align: right;
    top: 0px;
    width: 4.5rem;
}

.card_shadow {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    /* Change box shadow on hover for an interactive effect */

}
</style>
<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-md-12 grid-margin mb-4">
                            <div class="card card_shadow">
                                <div class="card-body">
                                    <div id="detailedReports"
                                        class="carousel slide detailed-report-carousel position-static pt-2"
                                        data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="row">
                                                    <div
                                                        class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                        <div class="ml-xl-4 mt-3">
                                                            <p class="card-title">Detailed Reports</p>
                                                            <h1 class="text-primary">$34,040</h1>
                                                            <h3 class="font-weight-500 mb-xl-4 text-primary">North
                                                                America</h3>
                                                            <p class="mb-2 mb-xl-0">The total number of sessions within
                                                                the date range. It is the period time a user is actively
                                                                engaged with your website, page, or app, etc.</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xl-9">
                                                        <div class="row">
                                                            <div class="col-md-6 border-right">
                                                                <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                                    <table class="table table-borderless report-table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-muted">Illinois</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div
                                                                                        class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-primary"
                                                                                            role="progressbar"
                                                                                            style="width: 70%"
                                                                                            aria-valuenow="70"
                                                                                            aria-valuemin="0"
                                                                                            aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        713</h5>
                                                                                </td>
                                                                            </tr>
                                                                            <!-- Repeat for other states -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <canvas id="north-america-chart"></canvas>
                                                                <div id="north-america-legend"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="row">
                                                    <div
                                                        class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                        <div class="ml-xl-4 mt-3">
                                                            <p class="card-title">Detailed Reports</p>
                                                            <h1 class="text-primary">$34,040</h1>
                                                            <h3 class="font-weight-500 mb-xl-4 text-primary">South
                                                                America</h3>
                                                            <p class="mb-2 mb-xl-0">The total number of sessions within
                                                                the date range. It is the period time a user is actively
                                                                engaged with your website, page, or app, etc.</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xl-9">
                                                        <div class="row">
                                                            <div class="col-md-6 border-right">
                                                                <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                                    <table class="table table-borderless report-table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-muted">Brazil</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div
                                                                                        class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-primary"
                                                                                            role="progressbar"
                                                                                            style="width: 70%"
                                                                                            aria-valuenow="70"
                                                                                            aria-valuemin="0"
                                                                                            aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        713</h5>
                                                                                </td>
                                                                            </tr>
                                                                            <!-- Repeat for other states -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <canvas id="south-america-chart"></canvas>
                                                                <div id="south-america-legend"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#detailedReports" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#detailedReports" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Procurement Progress</h5>
                                    <div class="table-responsive">
                                        <ul class="cd-breadcrumb triangle nav nav-tabs" role="tablist">
                                            <li role="presentation" :class="{ 'active': activeTab === 'tab1' }">
                                                <a @click="changeTab('tab1')" href="#Ideate" aria-controls="ideate"
                                                    role="tab" data-toggle="tab" aria-expanded="false">
                                                    <i class="fa fa-list" aria-hidden="true"></i> Purchase Request Type
                                                    per Division
                                                </a>
                                            </li>
                                            <li role="presentation" :class="{ 'active': activeTab === 'tab2' }">
                                                <a @click="changeTab('tab2')" href="#Ideate" aria-controls="ideate"
                                                    role="tab" data-toggle="tab" aria-expanded="false">
                                                    <i class="fa fa-list" aria-hidden="true"></i>Purchase Request per
                                                    Month
                                                </a>
                                            </li>
                                            <li role="presentation" :class="{ 'active': activeTab === 'tab3' }">
                                                <a @click="changeTab('tab3')" href="#Ideate" aria-controls="ideate"
                                                    role="tab" data-toggle="tab" aria-expanded="false">
                                                    <i class="fa fa-list" aria-hidden="true"></i> Top 20 Purchase
                                                    Request
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel"
                                                :class="{ 'tab-pane active': activeTab === 'tab1', 'tab-pane': activeTab !== 'tab1' }"
                                                id="tab1">
                                                <table class="table table-bordered" style="font-size:10pt;">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="15%" class="header_pink"
                                                                style="vertical-align: middle;text-align:center;">
                                                                Division</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="vertical-align: middle;">Total No. of Catering
                                                                Services</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="vertical-align: middle;">Total No. of Meals,
                                                                Venue and Accomodation </th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="vertical-align: middle;">Total No. of Repair and
                                                                Maintenance</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="vertical-align: middle;">Total No. of Supplies,
                                                                Materials and Devices</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="vertical-align: middle;">Total No. of Other
                                                                Services</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="vertical-align: middle;">Total No. of
                                                                Reimbursement and Petty Cash</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="list_body ">
                                                        <tr style="background-color: #8ae38a;">
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <b>TOTAL</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>45</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>96</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>33</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>147</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>63</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>95</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center; vertical-align: middle;">
                                                                <b>FAD</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>17</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>13</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>33</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>24</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>20</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>77</b></td>
                                                        </tr>
                                                        <!-- Repeat for other divisions -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div role="tabpanel"
                                                :class="{ 'tab-pane active': activeTab === 'tab2', 'tab-pane': activeTab !== 'tab2' }"
                                                id="tab2" style="">
                                                <!-- Your content here -->
                                            </div>
                                            <div role="tabpanel"
                                                :class="{ 'tab-pane active': activeTab === 'tab3', 'tab-pane': activeTab !== 'tab3' }"
                                                id="tab3" style="font-size:10pt;overflow-y:auto;max-height:350px;">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="15%" class="header_pink"
                                                                style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">
                                                                Rank</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">
                                                                Purchase No.</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">
                                                                Purchase Date</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">
                                                                Office</th>
                                                            <th rowspan="2" class="header_yellow"
                                                                style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">
                                                                Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="list_body">
                                                        <tr>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>1</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b><a
                                                                        href="procurement_purchase_request_view.php?&amp;id=2521&amp;pr_no=2023-10-0520">2023-10-0520</a></b>
                                                            </td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>October 24, 2023</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>FAD</b></td>
                                                            <td
                                                                style="font-size:20pt; text-align: center; vertical-align: middle;">
                                                                <b>Php7,360,974.96</b></td>
                                                        </tr>
                                                        <!-- Repeat for other purchase requests -->
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
    </div>
</template>
<script>
import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import DetailedReport from '../dashboard_tiles/DetailedReport.vue';
import axios from 'axios';

export default {
    name: 'Procurement',
    data() {
        return {
            appItem: {
                app_total: null
            },
            activeTab: 'tab1'
        }
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        DetailedReport

    },
    mounted() {
        this.renderDetailedReportChart();
    },
    methods: {
        changeTab(tabName) {
            this.activeTab = tabName; // Update active tab
        },
        toCreatePR() {
            this.$router.push("/gss/create_pr");
        },
        renderDetailedReportChart() {
            if ($("#north-america-chart").length) {
                var areaData = {
                    labels: ["Jan", "Feb", "Mar"],
                    datasets: [{
                        data: [100, 50, 50],
                        backgroundColor: [
                            "#4B49AC", "#FFC100", "#248AFD",
                        ],
                        borderColor: "rgba(0,0,0,0)"
                    }]
                };
                var areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    segmentShowStroke: false,
                    cutoutPercentage: 78,
                    elements: {
                        arc: {
                            borderWidth: 4
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    legendCallback: function (chart) {
                        var text = [];
                        text.push('<div class="report-chart">');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
                        text.push('<p class="mb-0">88333</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
                        text.push('<p class="mb-0">66093</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
                        text.push('<p class="mb-0">39836</p>');
                        text.push('</div>');
                        text.push('</div>');
                        return text.join("");
                    },
                }
                var northAmericaChartPlugins = {
                    beforeDraw: function (chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;

                        ctx.restore();
                        var fontSize = 3.125;
                        ctx.font = "500 " + fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#13381B";

                        var text = "90",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
                var northAmericaChartCanvas = $("#north-america-chart").get(0).getContext("2d");
                var northAmericaChart = new Chart(northAmericaChartCanvas, {
                    type: 'doughnut',
                    data: areaData,
                    options: areaOptions,
                    plugins: northAmericaChartPlugins
                });
                document.getElementById('north-america-legend').innerHTML = northAmericaChart.generateLegend();
            }

            if ($("#order-chart-dark").length) {
                var areaData = {
                    labels: ["10", "", "", "20", "", "", "30", "", "", "40", "", "", "50", "", "", "60", "", "", "70"],
                    datasets: [{
                        data: [200, 480, 700, 600, 620, 350, 380, 350, 850, "600", "650", "350", "590", "350", "620", "500", "990", "780", "650"],
                        borderColor: [
                            '#4747A1'
                        ],
                        borderWidth: 2,
                        fill: false,
                        label: "Orders"
                    },
                    {
                        data: [400, 450, 410, 500, 480, 600, 450, 550, 460, "560", "450", "700", "450", "640", "550", "650", "400", "850", "800"],
                        borderColor: [
                            '#F09397'
                        ],
                        borderWidth: 2,
                        fill: false,
                        label: "Downloads"
                    }
                    ]
                };
                var areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        filler: {
                            propagate: false
                        }
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            ticks: {
                                display: true,
                                padding: 10,
                                fontColor: "#fff"
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false,
                                color: 'transparent',
                                zeroLineColor: '#575757'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            ticks: {
                                display: true,
                                autoSkip: false,
                                maxRotation: 0,
                                stepSize: 200,
                                min: 200,
                                max: 1200,
                                padding: 18,
                                fontColor: "#fff"
                            },
                            gridLines: {
                                display: true,
                                color: "#575757",
                                drawBorder: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    elements: {
                        line: {
                            tension: .35
                        },
                        point: {
                            radius: 0
                        }
                    }
                }
                var revenueChartCanvas = $("#order-chart-dark").get(0).getContext("2d");
                var revenueChart = new Chart(revenueChartCanvas, {
                    type: 'line',
                    data: areaData,
                    options: areaOptions
                });
                document.getElementById('order-legend').innerHTML = revenueChart.generateLegend();

            }

            if ($("#sales-chart-dark").length) {
                var SalesChartCanvas = $("#sales-chart-dark").get(0).getContext("2d");
                var SalesChart = new Chart(SalesChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May"],
                        datasets: [{
                            label: 'Offline Sales',
                            data: [480, 230, 470, 210, 330],
                            backgroundColor: '#98BDFF'
                        },
                        {
                            label: 'Online Sales',
                            data: [400, 340, 550, 480, 170],
                            backgroundColor: '#4B49AC'
                        }
                        ]
                    },
                    options: {
                        cornerRadius: 5,
                        responsive: true,
                        maintainAspectRatio: true,
                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                                top: 20,
                                bottom: 0
                            }
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                gridLines: {
                                    display: true,
                                    drawBorder: false,
                                    color: "#575757"
                                },
                                ticks: {
                                    display: true,
                                    min: 0,
                                    max: 500,
                                    callback: function (value, index, values) {
                                        return value + '$';
                                    },
                                    autoSkip: true,
                                    maxTicksLimit: 10,
                                    fontColor: "#F0F0F0"
                                }
                            }],
                            xAxes: [{
                                stacked: false,
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#F0F0F0"
                                },
                                gridLines: {
                                    color: "#575757",
                                    display: false
                                },
                                barPercentage: 1
                            }]
                        },
                        legend: {
                            display: false
                        },
                        elements: {
                            point: {
                                radius: 0
                            }
                        }
                    },
                });
                document.getElementById('sales-legend').innerHTML = SalesChart.generateLegend();
            }

            if ($("#south-america-chart").length) {
                var areaData = {
                    labels: ["Jan", "Feb", "Mar"],
                    datasets: [{
                        data: [60, 70, 70],
                        backgroundColor: [
                            "#4B49AC", "#FFC100", "#248AFD",
                        ],
                        borderColor: "rgba(0,0,0,0)"
                    }]
                };
                var areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    segmentShowStroke: false,
                    cutoutPercentage: 78,
                    elements: {
                        arc: {
                            borderWidth: 4
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    legendCallback: function (chart) {
                        var text = [];
                        text.push('<div class="report-chart">');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
                        text.push('<p class="mb-0">495343</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
                        text.push('<p class="mb-0">630983</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
                        text.push('<p class="mb-0">290831</p>');
                        text.push('</div>');
                        text.push('</div>');
                        return text.join("");
                    },
                }
                var southAmericaChartPlugins = {
                    beforeDraw: function (chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;

                        ctx.restore();
                        var fontSize = 3.125;
                        ctx.font = "600 " + fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#000";

                        var text = "76",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
                var southAmericaChartCanvas = $("#south-america-chart").get(0).getContext("2d");
                var southAmericaChart = new Chart(southAmericaChartCanvas, {
                    type: 'doughnut',
                    data: areaData,
                    options: areaOptions,
                    plugins: southAmericaChartPlugins
                });
                document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
            }
            if ($("#south-america-chart-dark").length) {
                var areaData = {
                    labels: ["Jan", "Feb", "Mar"],
                    datasets: [{
                        data: [60, 70, 70],
                        backgroundColor: [
                            "#4B49AC", "#FFC100", "#248AFD",
                        ],
                        borderColor: "rgba(0,0,0,0)"
                    }]
                };
                var areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    segmentShowStroke: false,
                    cutoutPercentage: 78,
                    elements: {
                        arc: {
                            borderWidth: 4
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    legendCallback: function (chart) {
                        var text = [];
                        text.push('<div class="report-chart">');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
                        text.push('<p class="mb-0">495343</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
                        text.push('<p class="mb-0">630983</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
                        text.push('<p class="mb-0">290831</p>');
                        text.push('</div>');
                        text.push('</div>');
                        return text.join("");
                    },
                }
                var southAmericaChartPlugins = {
                    beforeDraw: function (chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;

                        ctx.restore();
                        var fontSize = 3.125;
                        ctx.font = "600 " + fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#fff";

                        var text = "76",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
                var southAmericaChartCanvas = $("#south-america-chart-dark").get(0).getContext("2d");
                var southAmericaChart = new Chart(southAmericaChartCanvas, {
                    type: 'doughnut',
                    data: areaData,
                    options: areaOptions,
                    plugins: southAmericaChartPlugins
                });
                document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
            }

        }


    },

}
</script>
