<template>
        <div class="col-md-12 grid-margin mb-4 stretch-card">

            <div class="col-md-3 col-sm-12 col-xs-12 mb-6 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-4">Total Purchase Request</p>
                            <p class="fs-30 mb-2">{{ this.total_pr }}</p>
                            <p>{{this.$formatDecimal((this.total_pr / 300)*100)}}% as of today</p>
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
                            <p class="mb-4">With RFQ</p>
                            <p class="fs-30 mb-2">{{ this.rfq_count }}</p>
                            <p>{{this.$formatDecimal((this.rfq_count / 300)*100)}}% as of today</p>
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
                            <p class="mb-4">Awarded</p>
                            <p class="fs-30 mb-2">{{ this.awarded }}</p>
                            <p>{{this.$formatDecimal((this.awarded / 300)*100)}}% as of today</p>
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
                            <p class="mb-4">Purchase Order</p>
                            <p class="fs-30 mb-2">{{ this.po_count }}</p>
                            <p>{{this.$formatDecimal((this.po_count / 300)*100)}}% as of today</p>
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
    name: 'Procurement Statistics',
    data() {
        return {
            total_fund: null,
            total_pr: null,
            rfq_count: null,
            awarded: null,
            po_count: null
        }
    },
    mounted() {
        this.fetch_total_pr();
    },
    methods: {
        fetch_total_pr() {
            this.$count('/api/countPurchaseRequestStatistics', 2024)
                .then(data =>
                {
                    this.total_pr = data.total_pr;
                    this.rfq_count = data.with_rfq;
                    this.awarded = data.awarded;
                    this.po_count = data.with_purchase_order;
                })
                .catch(error => { console.error(error) })
        }
    },
}
</script>
