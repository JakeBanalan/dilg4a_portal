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
                    <p style="font-weight: 600; ">Need ICT Technical Assistance?</p>
                    <button class="submit-request">
                        <router-link class="submit-request" :to="{ name: 'Create ICT Technical Assistance' }">
                            Submit a Request
                        </router-link>
                    </button>
                </div>
                <div class="requests-info">
                    <div class="request-card all-requests">
                        <p>All Requests</p>
                        <p class="count">{{ this.ict_total }}</p>
                    </div>
                    <div class="request-card completed">
                        <p>Completed Requests</p>
                        <p class="count">{{ this.ict_completed }}</p>
                    </div>
                    <div class="request-card ongoing">
                        <p>Ongoing Requests</p>
                        <p class="count">{{ this.ict_received }}</p>
                    </div>
                    <div class="request-card pending">
                        <p>Pending Request</p>
                        <p class="count">{{ this.ict_draft }}</p>
                    </div>
                </div>
                <div class="contact-info">
                    <p style="font-size: 1rem !important; ">Still having problem? Contact RICTU at local 7406 or dilg4a.it@gmail.com</p>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            role: null,
            ict_total: null,
            ict_draft: null,
            ict_received: null,
            ict_completed: null,
            ict_returned: null,
            ict_hardware: null,
            ict_software: null,

        }
    },
    created() {
        const userId = localStorage.getItem('userId');
        this.role = localStorage.getItem('user_role');
    },
    mounted() {
        this.$countICTRequest('/api/countICTRequest', 2024)
            .then(ict_data => { this.ict_total = ict_data; })
            .catch(error => { console.error(error) })

        // Separate call for hardware count
        this.fetchHardwareCount();
        // Separate call for software count
        this.fetchSoftwareCount();
        this.$count('/api/countDRAFT', 1)
            .then(data => {
                this.ict_draft = data.draft;
                this.ict_received = data.received;
                this.ict_completed = data.completed;
            })
            .catch(error => { console.error(error) })



        // this.$countICTRequest('/api/countICTRequest', 2024)
        // .then(ict_data => { this.ict_data.ict_total = ict_data; })
        // .catch(error => { console.error(error) })

        // this.$countICTRequest('/api/countICTRequest', 2024)
        // .then(ict_data => { this.ict_data.ict_total = ict_data; })
        // .catch(error => { console.error(error) })
    },

    methods: {
        fetchHardwareCount() {
            // Assuming you have a way to make an API call to your backend
            axios.get('/api/countHardwareRequest') // Replace with actual API endpoint
                .then(response => {
                    this.ict_hardware = response.data.hardware_count; // Assuming the response has 'hardware_count' property
                })
                .catch(error => {
                    console.error('Error fetching hardware count:', error);
                });
        },
        fetchSoftwareCount() {
            // Assuming you have a way to make an API call to your backend
            axios.get('/api/countSoftwareRequest') // Replace with actual API endpoint
                .then(response => {
                    this.ict_software = response.data.software_count; // Assuming the response has 'software_count' property
                })
                .catch(error => {
                    console.error('Error fetching hardware count:', error);
                });
        }
    },


}
</script>

<style scoped>
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
    width: 200px;
    height: 120px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.request-card p {
    margin: 0;
}

.request-card .count {
    margin-top: 15px;
    font-size: 3.5rem;
    font-weight: bold;
}

.all-requests {
    color: white;
    background-color: #7701b1;
}

.completed {
    color: white;
    background-color: #efdb92;
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