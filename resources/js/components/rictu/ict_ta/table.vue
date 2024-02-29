<style scoped>
td {
    text-align: center;
}
</style>
<template>
    <div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr role="row">
                    <th rowspan="2" style="width:6%!important;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="ACTIONS: activate to sort column ascending">ACTIONS</th>
                    <th rowspan="2" style="width:6%!important;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="ACTIONS: activate to sort column ascending">SURVEY LINK</th>
                    <th rowspan="2" style="width: 10%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="ICT TECHNICAL ASSISTANCE REFERENCE NO.: activate to sort column ascending">
                        ICT TECHNICAL ASSISTANCE REFERENCE NO.</th>
                    <th colspan="2" scope="colgroup" style="text-align: center;" rowspan="1">RECEIVED</th>
                    <th rowspan="2" style="width: 10%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="NAME OF THE END-USER: activate to sort column ascending"> NAME OF THE
                        END-USER</th>
                    <th rowspan="2" style="width: 5%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1"
                        aria-label="OFFICE/SERVICE/ BUREAU DIVISION/SECTIO N/UNIT: activate to sort column ascending">
                        OFFICE/SERVICE/<br> BUREAU<br> DIVISION/SECTIO<br> N/UNIT</th>
                    <th rowspan="2" style="width: 10%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="ISSUE/CONCERN: activate to sort column ascending"> ISSUE/CONCERN</th>
                    <th rowspan="2" style="width: 10%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="TECHNICAL PERSONNEL ASSIGNED: activate to sort column ascending"> TECHNICAL
                        PERSONNEL ASSIGNED</th>
                    <th colspan="2" scope="colgroup" rowspan="1">COMPLETED</th>
                    <th rowspan="2" style="width: 5%;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="TYPE OF REQUEST: activate to sort column ascending">TYPE OF REQUEST</th>
                    <th rowspan="2" style="width:5%!important;" class="sorting" tabindex="0" aria-controls="ict_monitoring"
                        colspan="1" aria-label="STATUS: activate to sort column ascending">STATUS</th>

                </tr>
                <tr role="row">
                    <th scope="col" class="sorting" tabindex="0" aria-controls="ict_monitoring" rowspan="1" colspan="1"
                        aria-label="DATE: activate to sort column ascending">DATE</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="ict_monitoring" rowspan="1" colspan="1"
                        aria-label="TIME: activate to sort column ascending">TIME</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="ict_monitoring" rowspan="1" colspan="1"
                        aria-label="DATE: activate to sort column ascending">DATE</th>
                    <th scope="col" class="sorting" tabindex="0" aria-controls="ict_monitoring" rowspan="1" colspan="1"
                        aria-label="TIME: activate to sort column ascending">TIME</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="ict_data in displayedItems" :key="ict_data.id">
                    <td>
                        <button class="btn    btn-icon mr-1" style="background-color:#059886;color:#fff;" @click="received_request(ict_data.id)"><font-awesome-icon :icon="['fas', 'circle-check']"></font-awesome-icon></button>
                        <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"><font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon></button>
                        <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"><font-awesome-icon :icon="['fas', 'layer-group']"></font-awesome-icon></button>
                    </td>
                    <td> https://ecsm.dilg.gov.ph/?survey=2vgomscuf </td>
                    <td>R4A-{{ ict_data.control_no }}<br><i>~Request Date: {{ ict_data.requested_date }}</i>~</td>
                    <td>~</td>
                    <td>~</td>
                    <td>{{ ict_data.requested_by }}</td>
                    <td>{{ ict_data.office }}</td>
                    <td style="white-space: pre-wrap;text-align:justify;">{{ ict_data.remarks }} </td>
                    <td>{{ ict_data.ict_personnel }}</td>
                    <td>{{ ict_data.office }}</td>
                    <td>{{ ict_data.office }}</td>


                    <td> <span class="badge badge-success">{{ ict_data.type_of_request }}</span> </td>

                    <td>{{ ict_data.office }}</td>




                </tr>
            </tbody>
        </table>
        <Pagination :total="ict_data.length" @pageChange="onPageChange" />

    </div>
</template>
<script>
import Pagination from '../../procurement/Pagination.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faLayerGroup, faCircleCheck } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";

library.add(faEye, faLayerGroup, faCircleCheck);
export default {
    name: 'ict table',
    components: {
        Pagination,
        FontAwesomeIcon
    },
    data() {
        return {
            ict_data: [],
            currentPage: 1,
            itemsPerPage: 10,
        }
    },
    computed: {
        
        totalPages() {
            return Math.ceil(this.ict_data.length / this.itemsPerPage);
        },
        displayedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.ict_data.slice(start, end);
        },
    },
    mounted() {
        this.load_ict_request()
    },
    methods: {

        load_ict_request() {
            axios.get(`../../api/fetch_ict_request`)
                .then(response => {
                    this.ict_data = response.data.data;
                    console.log(this.ict_data);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        onPageChange(page) {
            this.currentPage = page;
            // Fetch data for the new page
            this.loadData();
        },
        received_request(id) {
            console.log(id)
        const userId = localStorage.getItem('userId');

            axios.post('/api/post_received_ict_request', {
                control_no_id: id,
                cur_user: userId

            }).then(() => {
                toast.success('Success! This request has been received!', {
                    autoClose: 2000
                });

                setTimeout(() => {
                    this.$router.push({ name: 'ICT Technical Assistance' });
                }, 2000); // Adjust the delay as needed

            }).catch((error) => {

            })

        }
    }
}

</script>