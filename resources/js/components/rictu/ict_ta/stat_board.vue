<template>
    <!-- <div v-if="this.role == 'admin'">
        <div class="col-md-12 grid-margin mb-4 stretch-card">

            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-4">ICT Technical Assistance Request</p>
                            <p class="fs-30 mb-2">{{ this.ict_total }}</p>

                            <p>{{ this.$formatDecimal((this.ict_total / 300) * 100) }}% as of today</p>
                        </div>
                        <div>
                            <font-awesome-icon :icon="['fas', 'square-poll-vertical']" class="fa-6x" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-4">Draft ICT Technical Assistance</p>
                            <p class="fs-30 mb-2">{{ this.ict_draft }}</p>

                            <p>{{ this.$formatDecimal((this.ict_draft / 300) * 100) }}% as of today</p>
                        </div>
                        <div>
                            <font-awesome-icon :icon="['fas', 'square-poll-vertical']" class="fa-6x" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-4">Received Technical Assistance</p>
                            <p class="fs-30 mb-2">{{ this.ict_received }}</p>

                            <p>{{ this.$formatDecimal((this.ict_received / 300) * 100) }}% as of today</p>
                        </div>
                        <div>
                            <font-awesome-icon :icon="['fas', 'square-poll-vertical']" class="fa-6x" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent" v-if="this.role == 'admin'">
                <div class="card card-dark-blue">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-4">Completed Technical Assistance</p>
                            <p class="fs-30 mb-2">{{ this.ict_completed }}</p>

                            <p>{{ this.$formatDecimal((this.ict_completed / 300) * 100) }}% as of today</p>
                        </div>
                        <div>
                            <font-awesome-icon :icon="['fas', 'square-poll-vertical']" class="fa-6x" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 grid-margin mb-4 stretch-card">
            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-4">Hardware Request</p>
                            <p class="fs-30 mb-2">{{ this.ict_hardware }}</p>
                            <p>{{ this.$formatDecimal((this.ict_hardware / 500) * 100) }}% as of this year</p>
                        </div>
                        <div>
                            <font-awesome-icon :icon="['fas', 'computer']" class="fa-6x" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-4">Software Request</p>
                            <p class="fs-30 mb-2">{{ this.ict_software }}</p>
                            <p>{{ this.$formatDecimal((this.ict_software / 500) * 100) }}% as of this year</p>
                        </div>
                        <div>
                            <font-awesome-icon :icon="['fas', 'gear']" class="fa-6x" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div v-if="this.role == 'user'">
        <div class="container col-md-12">
            <div class="header">
                <h1>
                    QP-DILG-ISTMS-RO-17: Provision of Preventive Maintenance and Technical Assistance on Information and
                    Communications Technology (ICT) Resources
                </h1>
            </div>
        </div>
        <div class="stat col-md-12">
            <div class="content">
                <div class="technical-assistance">
                    <p style="font-weight: 600;">Need ICT Technical Assistance?</p>
                    <button class="submit-request" @click="$router.replace({ path: '/rictu/ict_ta/create' })">
                        Submit a Request
                    </button>
                </div>
                <div class="requests-info">
                    <div class="request-card all-requests">
                        <p style="font-size: 1rem; font-weight: bold;">User Requests</p>
                        <p class="count">{{ this.ict_total }}</p>
                    </div>
                    <div class="request-card completed">
                        <p style="font-size: 1rem; font-weight: bold;">Completed Requests</p>
                        <p class="count">{{ this.ict_completed }}</p>
                    </div>
                    <div class="request-card ongoing">
                        <p style="font-size: 1rem; font-weight: bold;">Ongoing Requests</p>
                        <p class="count">{{ this.ict_received }}</p>
                    </div>
                    <div class="request-card pending">
                        <p style="font-size: 1rem; font-weight: bold;">Pending Request</p>
                        <p class="count">{{ this.ict_draft }}</p>
                    </div>
                </div>
                <div class="contact-info">
                    <p style="font-size: 1rem !important;">
                        Still having problems? Contact RICTU at local 7406 or dilg4a.it@gmail.com
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div v-if="this.role == 'admin'">
        <div class="container col-md-12">
            <div class="header">
                <h1>
                    QP-DILG-ISTMS-RO-17: Provision of Preventive Maintenance and Technical Assistance on Information and
                    Communications Technology (ICT) Resources
                </h1>
            </div>
        </div>
        <div class="stat col-md-12">
            <div class="content">
                <div class="technical-assistance">
                    <p style="font-weight: 600;">Need ICT Technical Assistance?</p>
                    <button class="submit-request" @click="$router.replace({ path: '/rictu/ict_ta/create' })">
                        Submit a Request
                    </button>
                </div>
                <div class="requests-info">
                    <div class="request-card all-requests">
                        <p style="font-size: 1rem; font-weight: bold;">Total Requests</p>
                        <p class="count">{{ ict_adminTotal }}</p> <!-- Remove 'this.' -->
                    </div>
                    <div class="request-card completed">
                        <p style="font-size: 1rem; font-weight: bold;">Completed Requests</p>
                        <p class="count">{{ ict_adminCompleted }}</p>
                    </div>
                    <div class="request-card ongoing">
                        <p style="font-size: 1rem; font-weight: bold;">Ongoing Requests</p>
                        <p class="count">{{ ict_adminReceived }}</p>
                    </div>
                    <div class="request-card pending">
                        <p style="font-size: 1rem; font-weight: bold;">Pending Request</p>
                        <p class="count">{{ ict_adminDraft }}</p>
                    </div>
                </div>
                <div class="contact-info">
                    <p style="font-size: 1rem !important;">
                        Still having problems? Contact RICTU at local 7406 or dilg4a.it@gmail.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user_id: null,
            role: null,
            ict_total: 0,
            ict_draft: 0,
            ict_received: 0,
            ict_completed: 0,
            ict_returned: 0,
            ict_hardware: 0,
            ict_software: 0,
            ict_adminTotal: 0,
            ict_adminDraft: 0,
            ict_adminReceived: 0,
            ict_adminCompleted: 0,
            ict_adminReturned: 0,
            ict_adminHardware: 0,
            ict_adminSoftware: 0,
        };
    },
    created() {
        this.user_id = localStorage.getItem('userId');
        this.role = localStorage.getItem('user_role');
    },
    mounted() {
        this.fetchICTRequestCount();
        this.fetchDraftData();
        this.fetchICTAdminCount();
        this.fetchICTAdminDraft();
        // this.fetchHardwareCount();
        // this.fetchSoftwareCount();

    },
    methods: {
        fetchICTAdminCount() {
            // Fetch total ICT requests
            axios.get(`../../api/totalCountICTRequest/2024`)
                .then(response => {
                    // console.log(response.data); // Log the response to check the structure
                    this.ict_adminTotal = response.data.ictTotal;
                })
                .catch(error => {
                    console.error('Error fetching ICT admin total:', error);
                });
        },

        fetchICTAdminDraft() {
            // Fetch draft data
            axios.get('../../api/totalCountDraft')
                .then(response => {
                    // console.log('test',response.data);
                    const data = response.data;
                    this.ict_adminDraft = response.data[0].draft;
                    this.ict_adminReceived = response.data[0].received;
                    this.ict_adminCompleted = response.data[0].completed;
                    this.ict_adminReturned = response.data[0].returned;
                })
                .catch(error => {
                    console.error('Error fetching draft data:', error);
                });

        },
        fetchICTRequestCount() {
            axios.get(`/api/countICTRequest/${this.user_id}/2024`)
                .then(response => {
                    this.ict_total = response.data.ict;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchDraftData() {
            axios.get(`/api/countDRAFT/${this.user_id}`)
                .then(response => {
                    this.ict_draft = response.data[0].draft;
                    this.ict_received = response.data[0].received;
                    this.ict_completed = response.data[0].completed;
                    this.ict_returned = response.data[0].returned;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        // fetchHardwareCount() {
        //     axios.get(`/api/countHardwareRequest/${this.user_id}`)
        //         .then(response => {
        //             this.ict_hardware = response.data.hardware_count;
        //         })
        //         .catch(error => {
        //             console.error('Error fetching hardware count:', error);
        //         });
        // },
        // fetchSoftwareCount() {
        //     axios.get(`/api/countSoftwareRequest/${this.user_id}`)
        //         .then(response => {
        //             this.ict_software = response.data.software_count;
        //         })
        //         .catch(error => {
        //             console.error('Error fetching software count:', error);
        //         });
        // },
    },
};
</script>

<style scoped>
/* Add your styles here */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: 100%;
}

.stat {
    display: flex;
    flex-direction: column;
    align-items: right;
    text-align: center;
    width: 100%;
}

.header {
    width: 100%;
    padding: 20px;
}

.header h1 {
    margin: 0;
    color: #00a2e8;
    font-size: 30px;
}

.content {
    display: flex;
    flex-direction: row;
    align-items: center;
}

.technical-assistance {
    margin-bottom: 20px;
}

.technical-assistance p {
    font-size: 1.2rem;
    color: #555;
}

.submit-request {
    background-color: #280e85;
    color: white;
    padding: 5px;
    border: none;
    border-radius: 25px;
    font-size: 1rem;
    margin-top: 10px;
}

.requests-info {
    display: flex;
    gap: 20px;
    margin-left: 70px;
}

.request-card {
    padding: 20px;
    border-radius: 5px;
    width: calc(15vw - 15px);
    height: 130px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.request-card p {
    margin: 0;
}

.request-card .count {
    margin-top: 30px;
    font-size: 4.5rem;
    font-weight: bold;
}

.all-requests {
    color: white;
    background-color: #7701b1;
}

.completed {
    color: white;
    background-color: #efcd51;
}

.ongoing {
    color: white;
    background-color: #215ef8;
}

.pending {
    color: white;
    background-color: #fc4242;
}

.contact-info {
    margin-left: 30px;
    margin-top: 20px;
    font-weight: 500;
    font-style: italic;
}
</style>