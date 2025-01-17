<template>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Procurement Details</p>
                    <p class="font-weight-500">The total number of sessions within the date range. It is the
                        period time a user is actively engaged with your website, page or app, etc</p>
                    <div class="d-flex flex-wrap mb-5">
                        <div class="mr-5 mt-3">
                            <p class="text-muted">Purchase Request</p>
                            <h3 class="text-primary fs-30 font-weight-medium">12.3k</h3>
                        </div>
                        <div class="mr-5 mt-3">
                            <p class="text-muted">RFQ</p>
                            <h3 class="text-primary fs-30 font-weight-medium">14k</h3>
                        </div>
                        <div class="mr-5 mt-3">
                            <p class="text-muted">Awarrding</p>
                            <h3 class="text-primary fs-30 font-weight-medium">71.56%</h3>
                        </div>
                        <div class="mt-3">
                            <p class="text-muted">Purchase Order</p>
                            <h3 class="text-primary fs-30 font-weight-medium">34040</h3>
                        </div>
                    </div>
                    <canvas id="order-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">To Do Lists</h4>
                    <div class="list-wrapper pt-2">
                        <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                            <li>
                                <div class="form-check form-check-flat">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Meeting with Urban Team
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li class="completed">
                                <div class="form-check form-check-flat">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox" checked>
                                        Duplicate a project for new customer
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li>
                                <div class="form-check form-check-flat">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Project meeting with CEO
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li class="completed">
                                <div class="form-check form-check-flat">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox" checked>
                                        Follow up of team zilla
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li>
                                <div class="form-check form-check-flat">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Level up for Antony
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="add-items d-flex mb-0 mt-2">
                        <input type="text" class="form-control todo-list-input" placeholder="Add new task">
                        <button class="add btn btn-icon text-primary todo-list-add-btn bg-transparent"><i
                                class="icon-circle-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>



export default {
    name: 'ProcurementDetails',
    components: {

    },
    data() {
        return {

        }
    },
    mounted() {
        this.renderChart();
        this.renderSalesChart();
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

    },
    methods: {
        renderChart() {
            if (document.getElementById('order-chart')) {
                const areaData = {
                    labels: ['10', '', '', '20', '', '', '30', '', '', '40', '', '', '50', '', '', '60', '', '', '70'],
                    datasets: [
                        {
                            data: [
                                200, 480, 700, 600, 620, 350, 380, 350, 850, '1000', '650', '350', '590', '350', '620', '500', '990', '780', '650',
                            ],
                            borderColor: ['#4747A1'],
                            borderWidth: 2,
                            fill: false,
                            label: 'Orders',
                        },
                        {
                            data: [
                                400, 450, 410, 500, 480, 600, 450, 550, 460, '125000', '450', '700', '450', '640', '550', '650', '400', '850', '800',
                            ],
                            borderColor: ['#F09397'],
                            borderWidth: 2,
                            fill: false,
                            label: 'Downloads',
                        },
                    ],
                };

                const areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        filler: {
                            propagate: false,
                        },
                    },
                    scales: {
                        xAxes: [
                            {
                                display: true,
                                ticks: {
                                    display: true,
                                    padding: 10,
                                    fontColor: '#6C7383',
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false,
                                    color: 'transparent',
                                    zeroLineColor: '#eeeeee',
                                },
                            },
                        ],
                        yAxes: [
                            {
                                display: true,
                                ticks: {
                                    display: true,
                                    autoSkip: false,
                                    maxRotation: 0,
                                    stepSize: 200,
                                    min: 200,
                                    max: 1200,
                                    padding: 18,
                                    fontColor: '#6C7383',
                                },
                                gridLines: {
                                    display: true,
                                    color: '#f2f2f2',
                                    drawBorder: false,
                                },
                            },
                        ],
                    },
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        enabled: true,
                    },
                    elements: {
                        line: {
                            tension: 0.35,
                        },
                        point: {
                            radius: 0,
                        },
                    },
                };

                const revenueChartCanvas = document.getElementById('order-chart').getContext('2d');
                const revenueChart = new Chart(revenueChartCanvas, {
                    type: 'line',
                    data: areaData,
                    options: areaOptions,
                });
            }
        },
        renderSalesChart() {
            if ($("#sales-chart").length) {
                var SalesChartCanvas = $("#sales-chart").get(0).getContext("2d");
                var SalesChart = new Chart(SalesChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May"],
                        datasets: [{
                            label: 'Pending Survey',
                            data: [480, 230, 470, 210, 330],
                            backgroundColor: '#98BDFF'
                        },
                        {
                            label: 'Completed Survey',
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
                                    color: "#F2F2F2"
                                },
                                ticks: {
                                    display: true,
                                    min: 0,
                                    max: 560,
                                    callback: function (value, index, values) {
                                        return value + '$';
                                    },
                                    autoSkip: true,
                                    maxTicksLimit: 10,
                                    fontColor: "#6C7383"
                                }
                            }],
                            xAxes: [{
                                stacked: false,
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#6C7383"
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, 0)",
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
        }
    },
};
</script>
