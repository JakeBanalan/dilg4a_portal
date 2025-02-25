<template>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <img src="https://flagpedia.net/data/flags/icon/72x54/ph.png" alt="Philippine Flag"
                        style="width: 50px; height: 50px; margin-right: 10px; vertical-align: middle;">
                    <h5 class="font-weight-bold" style="font-size: 28pt; display: inline-block;">{{ currentTime
                    }}</h5>
                    <div style="display: block; margin-left: 60px;">
                        <h5 class="font-weight-bold" style="font-size: 18pt;">{{ dayOfWeek }}, {{ currentDate }}</h5>
                    </div>
                </div>
                <div class="col-12 col-xl-4 text-right">
                    <h3 class="font-weight-bold">{{ $route.name }}</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Add your styles here */
</style>

<script>
export default {
    name: 'BreadCrumbs',
    components: {},
    data() {
        return {
            currentTime: '',
            currentDate: '',
            dayOfWeek: '',
            intervalId: null
        }
    },
    mounted() {
        this.updateTime();
        this.updateDate();
        this.intervalId = setInterval(this.updateTime, 1000);
    },
    beforeDestroy() {
        clearInterval(this.intervalId);
    },
    methods: {
        updateTime() {
            const philippineTime = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" }));
            const hours = philippineTime.getHours();
            const minutes = philippineTime.getMinutes().toString().padStart(2, '0');
            const seconds = philippineTime.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const hours12 = hours % 12 === 0 ? 12 : hours % 12;
            this.currentTime = `${hours12.toString().padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
        },
        updateDate() {
            const philippineDate = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" }));
            const day = philippineDate.getDate().toString().padStart(2, '0');
            const month = philippineDate.toLocaleString("en-US", { month: "long" });
            const year = philippineDate.getFullYear();
            const dayOfWeek = philippineDate.toLocaleString("en-US", { weekday: "long" });
            this.currentDate = `${day} ${month} ${year}`;
            this.dayOfWeek = dayOfWeek;
        }
    }
}
</script>
