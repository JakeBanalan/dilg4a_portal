<template>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
                <div class="card-people mt-auto">
                    <img :src="dashboard_img1" alt="people">
                    <!-- <div class="weather-info">
                        <div class="d-flex">
                            <div>
                                <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                            </div>
                            <div class="ml-2">
                                <h4 class="location font-weight-normal">Bangalore</h4>
                                <h6 class="font-weight-normal">India</h6>
                            </div>
                        </div>
                    </div> -->
                </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Procurement Status</p>
                            <p class="fs-30 mb-2">{{this.total_pr}}</p>
                            <p>{{this.$formatDecimal((this.total_pr / 300)*100)}}% as of today</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Active Accounts</p>
                            <p class="fs-30 mb-2">{{this.total_accounts}}</p>
                            <p>22.00% (30 days)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total ICT TA Client's</p>
                            <p class="fs-30 mb-2">34040</p>
                            <p>2.00% (30 days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Upcoming Activities</p>
                            <p class="fs-30 mb-2">47033</p>
                            <p>0.22% (30 days)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style></style>
<script>
import dashboard_img1 from "../../../../assets/images/banner1.png";

export default {
    name: 'StatBox',
    components: {

    }, data() {
        return {
            dashboard_img1: dashboard_img1,
            total_pr:null,
            total_accounts:null
        }
    },
    mounted() {
        // this.fetch_total_pr();
        // this.fetch_total_accounts();
    },
    methods: {
        fetch_total_pr() {
            this.$count('/api/countPurchaseRequestStatistics', 2024)
                .then(data => 
                { 
                    this.total_pr = data.total_pr;
                })
                .catch(error => { console.error(error) })
        },
        fetch_total_accounts()
        {
            this.$count('/api/getActiveAccounts')
                .then(data => 
                { 
                    this.total_accounts = data.total_accounts;
                })
                .catch(error => { console.error(error) })
        }
    },
}
</script>