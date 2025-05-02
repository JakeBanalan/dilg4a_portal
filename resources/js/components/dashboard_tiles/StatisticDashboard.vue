<template>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">STATISTICS</h4>
                    <div class="stats-container">
                        <div class="stats-info">
                            <div class="stats-row">
                                <div class="stats-item">
                                    <span class="male-box">{{ regularMale }}</span> Male (Regular)
                                </div>
                                <div class="stats-item">
                                    <span class="female-box">{{ regularFemale }}</span> Female (Regular)
                                </div>
                                <div class="stats-item total">
                                    <span class="total-box red">{{ totalRegular }}</span> TOTAL
                                </div>
                            </div>

                            <div class="stats-row">
                                <div class="stats-item">
                                    <span class="male-box blue">{{ contractualMale }}</span> Male (Contractual)
                                </div>
                                <div class="stats-item">
                                    <span class="female-box blue">{{ contractualFemale }}</span> Female (Contractual)
                                </div>
                                <div class="stats-item total">
                                    <span class="total-box blue">{{ totalContractual }}</span> TOTAL
                                </div>
                            </div>

                            <div class="stats-row">
                                <div class="stats-item">
                                    <span class="male-box gray">{{ unknownMale }}</span> Male (Unknown)
                                </div>
                                <div class="stats-item">
                                    <span class="female-box gray">{{ unknownFemale }}</span> Female (Unknown)
                                </div>
                                <div class="stats-item total">
                                    <span class="total-box gray">{{ totalUnknown }}</span> TOTAL
                                </div>
                            </div>
                        </div>
                    </div>
                    <DoughnutChart v-if="chartData" :chart-data="chartData" :chart-options="chartOptions" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import axios from 'axios';
import { DoughnutChart } from 'vue-chart-3';
import { Chart, registerables } from 'chart.js';

// Register Chart.js plugins
Chart.register(...registerables);

export default
    defineComponent({
        components: {
            DoughnutChart,
        },
        setup() {
            // Define ref variables for statistics
            const regularMale = ref(0);
            const regularFemale = ref(0);
            const contractualMale = ref(0);
            const contractualFemale = ref(0);
            const unknownMale = ref(0);
            const unknownFemale = ref(0);
            const totalRegular = ref(0);
            const totalContractual = ref(0);
            const totalUnknown = ref(0);
            const chartData = ref(null);

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            };

            const fetchUserData = async () => {
                try {
                    const response = await axios.get('/api/getGenderEmpStat');
                    const users = response.data;

                    let maleRegular = 0, femaleRegular = 0;
                    let maleContractual = 0, femaleContractual = 0;
                    let maleUnknown = 0, femaleUnknown = 0;

                    users.forEach(user => {
                        if (user.employment_status === "Permanent") {
                            user.gender === "Male" ? maleRegular++ : femaleRegular++;
                        } else if (user.employment_status === "Contract of Service") {
                            user.gender === "Male" ? maleContractual++ : femaleContractual++;
                        } else {
                            // Handle "Unknown" employment status
                            user.gender === "Male" ? maleUnknown++ : femaleUnknown++;
                        }
                    });

                    // Assign values to refs
                    regularMale.value = maleRegular;
                    regularFemale.value = femaleRegular;
                    contractualMale.value = maleContractual;
                    contractualFemale.value = femaleContractual;
                    unknownMale.value = maleUnknown;
                    unknownFemale.value = femaleUnknown;

                    totalRegular.value = maleRegular + femaleRegular;
                    totalContractual.value = maleContractual + femaleContractual;
                    totalUnknown.value = maleUnknown + femaleUnknown;

                    // Update chart data
                    chartData.value = {
                        labels: ["Regular Male", "Regular Female", "Contractual Male", "Contractual Female", "Unknown Male", "Unknown Female"],
                        datasets: [
                            {
                                data: [maleRegular, femaleRegular, maleContractual, femaleContractual, maleUnknown, femaleUnknown],
                                backgroundColor: ["#D9534F", "#F39C12", "#337AB7", "#5BC0DE", "#000000", "#A9A9A9"],
                            },
                        ],
                    };
                } catch (error) {
                    console.error("Error fetching users:", error);
                }
            };

            onMounted(fetchUserData);

            return {
                regularMale,
                regularFemale,
                contractualMale,
                contractualFemale,
                unknownMale,
                unknownFemale,
                totalRegular,
                totalContractual,
                totalUnknown,
                chartData,
                chartOptions,
            };
        },
    });
</script>

<style scoped>
.stats-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.stats-info {
    width: 90%;
}

.stats-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.stats-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: bold;
    font-size: 16px;
}

.total {
    justify-content: flex-end;
}

/* Box Styles */
.male-box,
.female-box,
.total-box {
    padding: 5px 10px;
    border-radius: 5px;
    color: white;
    font-size: 14px;
    font-weight: bold;
    min-width: 40px;
    text-align: center;
    display: inline-block;
}

.male-box {
    background-color: #337ab7;
    /* Blue */
}

.female-box {
    background-color: #d9534f;
    /* Red */
}

.total-box {
    font-size: 14px;
    padding: 5px 15px;
    border-radius: 5px;
    font-weight: bold;
}

.red {
    background-color: #d9534f;
    /* Total Regular */
}

.blue {
    background-color: #5bc0de;
    /* Total Contractual */
}

.gray {
    background-color: #6c757d;
    /* Total Unknown */
}
</style>
