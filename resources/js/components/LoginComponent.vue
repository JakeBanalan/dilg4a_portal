<template>
    <div>
        <header>
            <nav class="nav navbar navbar-expand-md navbar-dark fixed-top navscroll" style="background-color: #1e1e2d;">
                <div class="container-fluid">
                    <router-link class="navbar-brand" to="/">QMS-Centris</router-link>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation" @click="toggleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse pull-right" :class="{ 'show': isNavbarOpen }"
                        id="navbarCollapse">
                        <form @submit.prevent="loginUser" class="nav-login-form">
                            <div class="form-group nav-input">
                                <input type="text" v-model="form.username" class="form-control form-control-lg"
                                    id="exampleInputEmail1" placeholder="Username">
                            </div>
                            <div class="form-group nav-input">
                                <input type="password" v-model="form.password" class="form-control form-control-lg"
                                    id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="nav-action">
                                <button type="submit" class="btn_submit">SIGN IN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
        <div
            class="card-img-overlay flex-grow-1 py-143 bgi-no-repeat d-flex flex-column justify-content-center align-items-start">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 header-margin">
                        <button type="button" class="btn custom-btn btn-outline-primary btn-fw btn-icon-text"
                            style="top:-40px !important;margin-left:265px;">
                            ONLINE PORTAL
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style>
input[type="text"] {
    width: 100%;
    height: 40px;
    border: none;
    outline: 0;
    border-radius: 5px;
    border: 1px solid #cbced4;
    gap: 20px;
    box-sizing: border-box;
    padding: 0px 10px;
}

nav form {
    display: flex;
}

.navbar-brand {
    font-family: 'Poppins';
}

nav input[type="text"],
nav input[type="password"],
nav input[type="submit"] {
    padding: 5px;
    margin-right: 5px;
    border: none;
    border-radius: 3px;
}

.custom-btn {
    font-family: 'Poppins';
    font-size: 50pt;
    font-weight: bolder;
}

.carousel-control-prev {
    background-color: rgb(3, 58, 33);
    width: 40px !important;
    height: 40px !important;
    padding: 10px;
    border-radius: 50%;
    margin-top: 22%;
    left: -8% !important;
}

.carousel-control-next {
    background-color: rgb(3, 58, 33);
    width: 40px !important;
    height: 40px !important;
    padding: 10px;
    border-radius: 50%;
    margin-top: 22%;
    right: -8% !important;
}

/* =========================================================================================== */
.zoom-bg4 {
    width: 200%;
    overflow: hidden;
}

.zoom-bg4:before {
    content: '';
    display: block;
    width: 100%;
    height: 100%;
    background-size: cover;
    transition: all .3s ease-in-out;
}

.zoom-bg4:hover:before {
    transform: scale(1.2);
}

/* =========================================================================================== */
.zoom-bg5 {
    width: 200%;
    overflow: hidden;
}

.zoom-bg5:before {
    content: '';
    display: block;
    width: 100%;
    height: 100%;
    background-size: cover;
    transition: all .3s ease-in-out;
}

.zoom-bg5:hover:before {
    transform: scale(1.2);
}

.banner-item1 {
    background-image: url('../../../assets/images/banner1.png');
}

.banner-item2 {
    background-image: url('../../../assets/images/banner2.png');
}

.banner-item3 {
    background-image: url('../../../assets/images/banner3.png');
}

.banner-item4 {
    background-image: url('../../../assets/images/banner4.png');
}


@keyframes blink {
    0% {
        background-color: #fff;
        /* Initial background color */
        color: #059886;
        /* Initial text color */
    }

    50% {
        background-color: #059886;
        /* Blinking color */
        color: #fff;
        /* White text color */
    }

    100% {
        background-color: #fff;
        /* Return to initial background color */
        color: #059886;
        /* Return to initial text color */
    }
}

.blinking_btn {
    animation: blink 1s infinite;
    /* Blink animation */
}

.btn_submit {
    color: #fff;
    background-color: #059886;
    border-color: #059886;
    margin-left: 10px;
    line-height: 1;
    font-weight: 400;
    height: 40px;
    border-radius: 5px;
    font-family: 'Poppins';
}

.programs {
    color: #05155e;
    text-align: center;
    font-size: 30pt;
    font-family: 'Poppins'
}

.management-team {
    color: #fff;
    text-align: center;
    font-size: 30pt;
    font-family: 'Poppins'
}

.custom-text a {
    color: #05155e !important;
    font-size: 12pt;
    font-family: 'Poppins'
}

.custom-text p {
    color: #05155e !important;
    font-size: 12pt;
    font-family: 'Poppins'
}

.section_vle {
    background-color: #ffffff;
    color: #fff;
    height: 600px;

}

.card-img-overlay {
    background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 255, 170, 0.2)),
        url('../../../assets/images/img-wall.png');
    width: auto;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.header-margin {
    margin-top: 205px;
}

/* Responsive adjustments for navbar login form and header */
.nav-login-form {
    display: flex;
    align-items: center;
    gap: 8px;
}
.nav-login-form .nav-input {
    display: flex;
}
.nav-login-form .nav-input input {
    min-width: 200px;
}
.nav-action {
    display: flex;
    align-items: center;
}

/* Mobile: stack inputs and make controls full-width */
@media (max-width: 767.98px) {
    .nav-login-form {
        flex-direction: column;
        width: 100%;
        padding: 10px 0;
    }
    .nav-login-form .nav-input {
        width: 100%;
    }
    .nav-login-form .nav-input input {
        width: 100%;
        box-sizing: border-box;
    }
    .nav-action {
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }
    .nav-action .btn_submit {
        width: 100%;
        margin-left: 0;
    }

    /* Reduce header button size and reset margin on small screens */
    .custom-btn {
        font-size: 14pt;
        padding: 6px 10px;
        margin-left: 0 !important;
        top: 0 !important;
    }

    .header-margin {
        margin-top: 120px;
        text-align: center;
    }
}

.typing-text {
    white-space: nowrap;
    overflow: hidden;
    animation: typing 5s steps(40) infinite;
}

.section-img-overlay {
    height: 750px;
    background-size: 100% 100%;
    background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 255, 170, 0.3)),
        url('../../../assets/images/section1.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.section2-img-overlay {
    height: 750px;
    background-size: 100% 100%;
    background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 255, 170, 0.3)),
        url('../../../assets/images/section2.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.section3-img-overlay {
    height: 550px;
    background-size: 100% 100%;
    background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 255, 170, 0.3));
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.section4-img-overlay {
    height: 500px;
    background-size: 100% 100%;
    background-color: #05155e;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
</style>
<script>
import SelectInput from "./micro/SelectInput.vue";

import dilg_banner from "../../../assets/images/login.png";
import content_img from "../../../assets/images/content-page.jpg";

import banner from "../../../assets/images/banner.png";
import axios from 'axios';
import Swal from 'sweetalert2';
import { toast } from "vue3-toastify";

export default {
    name: 'Login',
    data() {
        return {
            isNavbarOpen: false,
            dilg_banner: dilg_banner,
            content_page: content_img,
            header: banner,
            results: {},
            form: {
                email: '',
                password: '',
            },
            errors: []
        }
    },
    mounted() {
    },
    methods: {
        toggleNavbar() {
            this.isNavbarOpen = !this.isNavbarOpen;
        },
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
        // Login component
        loginUser() {
            axios
                .post('/api/login', this.form)
                .then(response => {
                    if (response.data.status) {
                        // Store user details in localStorage
                        localStorage.setItem('userId', response.data.userId);
                        localStorage.setItem('user_role', response.data.user_role);
                        localStorage.setItem('api_token', response.data.api_token);
                        localStorage.setItem('isUpdatedPassword', response.data.isUpdatedPassword);
                        localStorage.setItem('module_access', response.data.module_access || '[]');

                        // Request notification permission
                        this.requestNotificationPermission();

                        // Check if it's the user's birthday
                        const today = new Date().toISOString().slice(5, 10); // Format: MM-DD
                        const userBirthday = response.data.birthdate?.slice(5, 10); // Assuming birthdate is in YYYY-MM-DD format
                        if (today === userBirthday) {
                            localStorage.setItem('isBirthday', 'true');
                            localStorage.setItem('userName', response.data.name);
                        } else {
                            localStorage.setItem('isBirthday', 'false');
                        }

                        // Show success notification
                        this.showSuccessNotification('You are logged in');

                        // Redirect to dashboard after 1 second
                        setTimeout(() => {
                            this.$router.push({ name: 'Dashboard' });
                        }, 1000);
                    } else {
                        this.showFailedNotification('Login Failed');
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
        // Method to request notification permission
        requestNotificationPermission() {
            if (Notification.permission === 'granted') {
            } else if (Notification.permission !== 'denied') {
                // Use SweetAlert2 to request permission
                Swal.fire({
                    title: 'Enable Notifications',
                    text: 'We would like to send you notifications. Do you allow us to send notifications?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Allow',
                    cancelButtonText: 'Deny',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Notification.requestPermission().then(permission => {
                            if (permission === 'granted') {
                                new Notification('Welcome!', { body: 'You are now logged in.' });
                            }
                        });
                    }
                });
            }
        }
    },
    components: {
        SelectInput
    }
}



</script>
