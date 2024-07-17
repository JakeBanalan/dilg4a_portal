<template>
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
        <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
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
   
</template>

<script>
export default {
    name: 'Statistic Board',
    data() {
        return {
            ict_total: null,
            ict_draft: null,
            ict_received: null,
            ict_completed: null,
            ict_returned: null,

        }
    },
    mounted() {
        this.$countICTRequest('/api/countICTRequest', 2024)
            .then(ict_data => { this.ict_total = ict_data; })
            .catch(error => { console.error(error) })

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


}
</script>