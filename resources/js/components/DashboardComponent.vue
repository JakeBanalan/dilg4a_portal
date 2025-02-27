<template>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <Navbar></Navbar>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">


            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <Sidebar />
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <StatBox />
                    <BirthdayTable />
                    <!-- <ProcurementDetails /> -->
                    <!-- <DetailedReport /> -->
                    <StatisticDashboard />

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <Footer></Footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
        <NotifModal :visible="modalVisible" :show="showChangePasswordModal" @close="closeModal" />

    </div>
</template>

<script>

import logo from "../../../assets/images/logo.svg";
import logo_mini from "../../../assets/images/logo-mini.svg";
import face28 from "../../../assets/images/faces/face28.jpg";
import face1 from "../../../assets/images/faces/face1.jpg";
import face2 from "../../../assets/images/faces/face2.jpg";
import face3 from "../../../assets/images/faces/face3.jpg";
import face4 from "../../../assets/images/faces/face4.jpg";
import face5 from "../../../assets/images/faces/face5.jpg";
import face6 from "../../../assets/images/faces/face6.jpg";

import Navbar from "./layout/Navbar.vue";
import Sidebar from "./layout/Sidebar.vue";
import Footer from "./layout/Footer.vue";
import BreadCrumbs from "./dashboard_tiles/BreadCrumbs.vue";
import StatBox from "./dashboard_tiles/StatBox.vue";
import ProcurementDetails from "./dashboard_tiles/ProcurementDetails.vue";
import DetailedReport from "./dashboard_tiles/DetailedReport.vue";
import StatisticDashboard from "./dashboard_tiles/StatisticDashboard.vue";
import BirthdayTable from "./dashboard_tiles/BirthdayTable.vue";
import NotifModal from "./NotifModal.vue";


export default {
    name: 'Dashboard',
    components: {
        Navbar,
        Sidebar,
        Footer,
        BreadCrumbs,
        StatBox,
        ProcurementDetails,
        DetailedReport,
        StatisticDashboard,
        BirthdayTable,
        NotifModal
    },
    data() {
        return {
            logo: logo,
            logo_mini: logo_mini,
            face28: face28,
            face1: face1,
            face2: face2,
            face3: face3,
            face3: face3,
            face4: face4,
            face5: face5,
            face6: face6,
            pageTitle: 'Dashboard',
            modalVisible: false,
            showChangePasswordModal: false,
            isUpdatedPassword: null,
            user: null



        }
    },
    // Dashboard component
    created() {
        // Retrieve user ID from Vuex store
        const userId = localStorage.getItem('userId');
        // console.log('User ID:', userId);

        // Call the updateUserId method
        // this.updateUserId();
    },
    mounted() {
        this.fetchUserData();




    },
    methods: {
        checkAndShowModal() {
            // If the password is not updated, show the modal

        },
        closeModal() {
            this.modalVisible = false;
        },
        // Example of using a mutation (if needed)
        updateUserId() {
            // Update user ID using a munptation
            this.$store.commit('setUserId', 'newUserId');
            console.log('User ID updated:', this.$store.state.userId);
        },
        fetchUserData() {
            axios.get('/api/user', {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('api_token')
                }
            })
                .then(response => {
                    this.user = response.data;
                    if (this.user.isUpdatedPassword == 0) {
                        this.modalVisible = true;
                        this.showChangePasswordModal = true;
                    }

                })
                .catch(error => {
                    console.error('Request failed:', error);
                });
        }
    }



}
</script>
