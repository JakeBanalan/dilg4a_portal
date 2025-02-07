<template>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Monthly Overview - {{ currentMonth }} {{ currentYear }}</h4>
                <div class="chart-container" style="position: relative; height:400px; width:100%">
                    <canvas ref="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Department Overview - {{ currentYear }}</h4>
                <div class="doughnutjs-wrapper" style="height: 400px; width: 100%;">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Chart } from 'chart.js/auto';

export default {
    name: 'ProcurementStatistics',
    data() {
        return {
            currentMonth: new Date().toLocaleString('default', { month: 'long' }),
            currentYear: new Date().getFullYear(),
            barChart: null,
            doughnutChart: null,
            barData: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Pesos',
                    data: [184061.73, 528990],
                    backgroundColor: '#36A2EB',
                    borderWidth: 1
                }]
            },
            doughnutData: {
                labels: ['ORD', 'FAD', 'LGMED', 'LGCDD'],
                datasets: [{
                    label: 'Pesos',
                    data: [ 4886000.00,  1409811.73, 249000.00, 44700.00],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    hoverOffset: 4
                }]
            }
        };
    },
    mounted() {
        this.$nextTick(() => {
            if (!this.barChart) {
                this.initBarChart();
            }
            if (!this.doughnutChart) {
                this.initDoughnutChart();
            }
        });
    },
    beforeUnmount() {
        if (this.barChart) {
            this.barChart.destroy();
            this.barChart = null;
        }
        if (this.doughnutChart) {
            this.doughnutChart.destroy();
            this.doughnutChart = null;
        }
    },
    methods: {
        initBarChart() {
            const ctx = this.$refs.barChart?.getContext('2d');
            if (!ctx) return;

            this.barChart = new Chart(ctx, {
                type: 'bar',
                data: this.barData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Monthly Comparison' }
                    },
                    scales: {
                        y: { beginAtZero: true },
                        x: { title: { display: true, text: 'Months' } }
                    }
                }
            });
        },
        initDoughnutChart() {
            const ctx = document.getElementById('doughnutChart').getContext('2d');
            if (!ctx) return;

            this.doughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: this.doughnutData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'left' },
                    }
                }
            });
        }
    }
}
</script>
