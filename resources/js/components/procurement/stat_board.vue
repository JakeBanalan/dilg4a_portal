<template>

    <div class="col-lg-6 grid-margin stretch-card" v-if="this.role == 'admin'">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Monthly Overview - {{ currentMonth }} {{ currentYear }}</h4>
                <div class="chart-container" style="position: relative; height:400px; width:100%">
                    <canvas ref="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card" v-if="this.role == 'admin'">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Department Overview - {{ currentYear }}</h4>
                <div class="doughnutjs-wrapper" style="height: 400px; width: 100%;">
                    <canvas ref="doughnutChart"></canvas>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { Chart } from 'chart.js/auto';
import { eventBus } from '../eventBus.js';
export default {
    name: 'ProcurementStatistics',
    data() {
        return {
            currentMonth: new Date().toLocaleString('default', { month: 'long' }),
            currentYear: new Date().getFullYear(),
            barChart: null,
            doughnutChart: null,
            barData: {
                labels: [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ],
                datasets: [{
                    label: 'Pesos',
                    data: Array(12).fill(0),
                    backgroundColor: '#36A2EB',
                    borderWidth: 1
                }]
            },
            doughnutData: {
                labels: [],
                datasets: [{
                    label: 'Pesos',
                    data: [],
                    backgroundColor: [],
                    hoverOffset: 4
                }]
            }


        };
    },
    created() {
        this.role = localStorage.getItem('user_role');
    },
    mounted() {
        this.$nextTick(() => {
            this.fetchMonthlyOverview();
            this.fetchDepartmentOverview();
        });
        eventBus.on('updateStats', () => {
            this.fetchMonthlyOverview();
            this.fetchDepartmentOverview();
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
        async fetchMonthlyOverview() {
            try {
                const response = await fetch('/api/monthly-overview');
                const data = await response.json();

                const months = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

                const abcData = months.map(month => {
                    const found = data.find(item => item.month === month);
                    return found ? found.total_abc : 0;
                });

                this.barData.labels = months;
                this.barData.datasets[0].data = abcData;

                this.updateBarChart();
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },

        async fetchDepartmentOverview() {
            try {
                const response = await fetch('/api/department-overview');
                const data = await response.json();

                if (!Array.isArray(data)) {
                    throw new Error("Invalid API response format");
                }

                // Define color mapping for specific departments
                const colorMapping = {
                    "ORD": "#D5D911",
                    "ORD-Legal": "#D5D911",
                    "ORD-Planning": "#BA68C8",
                    "LGMED-MBRTG": "#0071c5",
                    "LGCDD-PDMU": "#48BD0D",
                    "FAD": "#00a65a",
                    "ORD-RICTU": "#D5D911",
                    "LGCDD": "#4A148C",
                    "LGMED": "#0071c5",
                    "BATANGAS": "#607D8B",
                    "CAVITE": "#FF9800",
                    "LAGUNA": "#009688",
                    "QUEZON": "#d50000",
                    "RIZAL": "#81D4FA",
                    "LUCENA CITY": "#FFEB3B",
                    "ORD": "#D5D911",
                };

                // Map API response to chart labels and data
                this.doughnutData.labels = data.map(item => item.pmo_title);
                this.doughnutData.datasets[0].data = data.map(item => item.total_abc);

                // Assign colors based on department names
                this.doughnutData.datasets[0].backgroundColor = data.map(item =>
                    colorMapping[item.pmo_title] || "#CCCCCC" // Default gray if no match
                );

                this.updateDoughnutChart(); // Refresh the chart
            } catch (error) {
                console.error("Error fetching department data:", error);
            }
        },

        updateBarChart() {
            if (this.barChart) {
                this.barChart.destroy();
            }

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
        updateDoughnutChart() {
            if (this.doughnutChart) {
                this.doughnutChart.destroy(); // Destroy existing chart instance
            }

            const ctx = this.$refs.doughnutChart?.getContext('2d');
            if (!ctx) return;

            this.doughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: this.doughnutData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'left'
                        }
                    }
                }
            });
        }


    }
}

</script>
