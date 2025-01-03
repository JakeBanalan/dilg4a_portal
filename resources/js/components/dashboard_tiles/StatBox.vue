<template>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card-people mt-auto">
                <img :src="currentImage" alt="people">
                <button @click="prevImage" class="arrow left-arrow">&#9664;</button>
                <button @click="nextImage" class="arrow right-arrow">&#9654;</button>
            </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Procurement Status</p>
                            <p class="fs-30 mb-2">{{ this.total_pr }}</p>
                            <p>{{ this.$formatDecimal((this.total_pr / 300) * 100) }}% as of today</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Active Accounts</p>
                            <p class="fs-30 mb-2">{{ this.total_accounts }}</p>
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
<style>
.arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.7);
    border: none;
    font-size: 24px;
    cursor: pointer;
    padding: 10px;
    border-radius: 50%;
    z-index: 10;
    opacity: 30%;
}

.left-arrow {
    left: 10px;
}

.right-arrow {
    right: 10px;
}
</style>
<script>
import dashboard_img1 from "../../../../assets/images/banner1.png";
import dashboard_img2 from "../../../../assets/images/banner2.png"; // Add more images
import dashboard_img3 from "../../../../assets/images/banner3.png";
import dashboard_img4 from "../../../../assets/images/banner3.png";

export default {
    name: 'StatBox',
    data() {
        return {
            images: [dashboard_img1, dashboard_img2, dashboard_img3, dashboard_img4], // Array of images
            currentIndex: 0,
            currentImage: dashboard_img1,
            total_pr: null,
            total_accounts: null
        }
    },
    mounted() {
        this.fetch_total_pr();
        this.fetch_total_accounts();
    },
    methods: {
        nextImage() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.currentImage = this.images[this.currentIndex];
        },
        prevImage() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length
            this.currentImage = this.images[this.currentIndex];
        },
        fetch_total_pr() {
            this.$count('/api/countPurchaseRequestStatistics', 2024)
                .then(data => {
                    this.total_pr = data.total_pr;
                })
                .catch(error => { console.error(error) });
        },
        fetch_total_accounts() {
            this.$count('/api/getActiveAccounts')
                .then(data => {
                    this.total_accounts = data.total_accounts;
                })
                .catch(error => { console.error(error) });
        }
    },
}
</script>