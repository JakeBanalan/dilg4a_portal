<style>
th,
td {
    padding: 8px;
    /* Optional: Add padding for better spacing */
    white-space: nowrap;
    /* Prevent text from wrapping */
    overflow: hidden;
    /* Hide overflow content */
    text-overflow: ellipsis;
    /* Display ellipsis (...) for overflowed text */
    max-width: 300px;
    /* Maximum width of cells */
}

.profile_img {
    width: 100px;
    height: 100px;
    padding: 1px;
    margin-bottom: 15%;
    border-radius: 100%;
    border: 1px solid rgb(18, 15, 76);
}

.user_info {
    display: flex;
    justify-content: space-between;
    margin: 0px;
    vertical-align: middle;
    width: 100%;
}

.rank_banner {
    background-color: rgb(104, 34, 142);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner2 {
    background-color: rgb(128, 22, 22);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner3 {
    background-color: rgb(45, 2, 85);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_wrapper {
    -webkit-clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    height: 4.5rem;
    padding-right: 4px;
    padding-top: 2px;
    position: absolute;
    right: 0px;
    text-align: right;
    top: 0px;
    width: 4.5rem;
}

.card_shadow {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    /* Change box shadow on hover for an interactive effect */

}
</style>
<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <!-- <RFQSTAT /> -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;
                                            Object Code
                                        </h5>
                                        <div class="d-flex">
                                            <button class="btn btn-primary btn-fw btn-icon-text mx-2"
                                                @click="openModal()">
                                                <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                                Create
                                            </button>
                                            <button type="button" class="btn btn-primary btn-fw btn-icon-text mx-2"
                                                @click="toggleSearch">
                                                <font-awesome-icon
                                                    :icon="['fas', 'magnifying-glass']"></font-awesome-icon>
                                                Advanced Search
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Advanced Search Form -->
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <div v-if="searchVisible">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" placeholder="RFQ #">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" placeholder="Created By">
                                                </div>
                                            </div>

                                            <div class="d-flex" style="float:right;">
                                                <button type="button" class="btn btn-primary btn-icon-text"
                                                    @click="applySearch">
                                                    <font-awesome-icon
                                                        :icon="['fas', 'magnifying-glass']"></font-awesome-icon>
                                                    Search</button>
                                                <button type="button" class="btn btn-secondary btn-icon-text mx-2"
                                                    @click="resetSearch">
                                                    <font-awesome-icon :icon="['fas', 'rotate']"></font-awesome-icon>
                                                    Reset</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive" style="padding-top:10px;">
                                        <table class="table table-striped table-bordered" id="oblitable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">CODE</th>
                                                    <th style="width: 10%;">UACS</th>
                                                    <th style="width: 10%;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="ObjectCode in ObjectCode" :key="ObjectCode.id">
                                                    <td>{{ ObjectCode.code }}</td>
                                                    <td>{{ ObjectCode.uacs }}</td>
                                                    <td style="width:5%;">
                                                        <div
                                                            style="  display: flex;gap: 0.1em; justify-content: center;">
                                                            <!-- <button @click="viewFs(ObjectCode.id)" class="btn btn-icon mr-1"
                                                                style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                                <font-awesome-icon
                                                                    :icon="['fas', 'eye']"></font-awesome-icon>
                                                            </button> -->
                                                            <button @click="deleteOC(ObjectCode.id)"
                                                                class="btn btn-icon mr-1"
                                                                style=" align-items: center; justify-content: center; padding: 0.5em; background-color: #059886; color: #fff;">
                                                                <font-awesome-icon
                                                                    :icon="['fas', 'trash']"></font-awesome-icon>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <ObjectCodeModal :visible="isModalVisible" @close="closeModal" @refresh="fetchObjectCode" />
                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import ObjectCodeModal from './oc_modal.vue';
import axios from 'axios';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faEye, faPaperPlane, faRotate, faMagnifyingGlass, faPlus } from '@fortawesome/free-solid-svg-icons';
import router from '../../../router';
library.add(faEye, faPaperPlane, faRotate, faMagnifyingGlass, faPlus);
export default {
    name: 'ObjectCode',
    props: {

    },
    data() {
        return {
            ObjectCode: [],
            searchVisible: false,
            isModalVisible: false,
        };
    },
    components: {
        ObjectCodeModal,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        FontAwesomeIcon,
    },
    computed: {
    },
    created() {
    },
    mounted() {
        this.fetchObjectCode();
    },
    methods: {
        openModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.fetchObjectCode();
            this.isModalVisible = false;
        },

        fetchObjectCode() {
            axios.get('/api/fetchObjectCode')
                .then(response => {
                    this.ObjectCode = response.data;
                    this.initializeDataTable(); // Initialize DataTable after data is fetched
                })
                .catch(error => {
                    console.error('Error fetching fund sources:', error);
                });
        },

        toggleSearch() {
            this.searchVisible = !this.searchVisible;
        },

        viewFs(id) {
            // console.log(router.getRoutes())
            this.$router.push({ path: `/finance/budget/update_fs/${id}` });

        },
        async deleteOC(id) {
            const result = await Swal.fire({
                title: 'Do you want to continue?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Continue',
            });
            if (result.isConfirmed) {
                try {
                    const response = await axios.post('/api/deleteOC', {
                        id: id
                    });
                    await Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        showConfirmButton: false,
                        timer: 1000
                    });

                    setTimeout(() => {
                        this.fetchObjectCode();
                        // const id = response.data.id;
                        // this.$router.push({ path: `/finance/budget/update_fs/${id}` });
                    }, 200);

                } catch (error) {
                    console.error('error saving data', error);
                    // Optionally, handle error.display or set this.errors if it's a 422
                }
            }
        },
        initializeDataTable() {
            $('#oblitable').DataTable().destroy(); // clean up
            this.$nextTick(() => {
                $('#oblitable').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                });
            });
        },
    },

}
</script>
