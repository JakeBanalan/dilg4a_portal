<template>
    <div class="container-scroller">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top navscroll" style="background-color: #1e1e2d;">
                <div class="container-fluid">
                    <router-link class="navbar-brand" to="/">Your Brand</router-link>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation" @click="toggleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" :class="{ 'show': isNavbarOpen }" id="navbarCollapse">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ path: '/' }" exact>Home</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ path: '/guidelines' }"
                                    active-class="active">Guidelines</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ path: '/registration' }"
                                    active-class="active">Quality Procedures</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ path: '/certified-establishments' }"
                                    active-class="active">Process Owners</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ path: '/inspection-and-certification-team' }"
                                    active-class="active">Reports Submission</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ path: '/sign-in' }"
                                    active-class="active">Log-in</router-link>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
        </header>
        <img :src="header" class="mt-5" />

        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0 justify-content-center"> <!-- Added justify-content-center -->
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left py-5 px-12 px-sm-5">
                                <div class="brand-logo text-center"> <!-- Added text-center -->
                                    <img :src="dilg_banner" alt="logo">
                                </div>
                                <h4 class="header-align-center">Finance and Administrative System</h4>
                                <h6 class="font-weight-light header-align-center">Sign in to continue.</h6>
                                <form class="pt-3" @submit.prevent="loginUser">
                                    <div class="form-group">
                                        <input type="text" v-model="form.username" class="form-control form-control-lg"
                                            id="exampleInputEmail1" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" v-model="form.password"
                                            class="form-control form-control-lg" id="exampleInputPassword1"
                                            placeholder="Password">
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit"
                                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                                            IN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>

</template>
<style>
.auth .brand-logo img {
    width: 20% !important;


}

.header-align-center {
    text-align: center;
}
</style>
<script>
import dilg_banner from "../../assets/logo.png";
import axios from 'axios';
import { toast } from "vue3-toastify";

export default {
    name: 'sign-in',
    data() {
        return {
            dilg_banner: dilg_banner,
            results: {},
            form: {
                username: '',
                password: '',
            },
            errors: []
        }
    },
    methods: {
        showFailedNotification(message) {
            toast.error(message, {
                autoClose: 1000,
            });
        },
        showSuccessNotification(message) {
            toast.success(message, {
                autoClose: 1000,
            });
        },
       
    loginUser() {
        axios
            .post('/api/login', this.form)
            .then(response => {
                if (response.data.status) {
                    //this code is to make user id accessible globally
                    localStorage.setItem('userId', response.data.userId);
                    localStorage.setItem('user_role', response.data.user_role);
                    localStorage.setItem('api_token', response.data.api_token);


                    this.showSuccessNotification('You are logged in');
                    setTimeout(() => {
                        this.$router.push({ name: 'Dashboard' });
                    }, 1000);
                } else {
                    this.showFailedNotification('Login Failed');
                    // Handle login failure, show error message, etc.
                }
            })
            .catch(error => {
                if (error.response && error.response.data) {
                    // Server returned an error response
                    this.errors = error.response.data.errors;
                } else {
                    // Error occurred during the request
                    console.log(error);
                }
            });
    }

}
}



</script>