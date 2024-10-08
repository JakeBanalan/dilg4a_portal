<style>
.navbar {
    background-color: black;
}

.bell {
    height: 30px;
}

/* Add necessary styles for your dropdown */
.preview-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.bg-success {
    background-color: #28a745;
}

.bg-warning {
    background-color: #ffc107;
}

.bg-info {
    background-color: #17a2b8;
}
</style>
<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="../../../../assets/images/logo.png"
                    class="mr-2" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../../../../assets/images/logo.png"
                    alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
            <ul class="navbar-nav mr-lg-2">
                <li class="nav-item nav-search d-none d-lg-block">
                    <div class="input-group">
                        <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                            <span class="input-group-text" id="search">
                                <i class="icon-search"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                            aria-label="search" aria-describedby="search">
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <img class="bell" src="../../../../assets/images/bell.png" alt="Notification Bell" />
                        <span class="count" style="color: black;">{{ notifications.length }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                        aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header"
                            style="font-weight: 900; font-size: 25px;">Notifications</p>

                        <!-- Check if there are notifications -->
                        <a v-if="notifications.length === 0" class="dropdown-item">
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">No Requests</h6>
                            </div>
                        </a>

                        <!-- Render notifications if there are any -->
                        <a v-for="notification in notifications" :key="notification.id"
                            class="dropdown-item preview-item" @click="redirectTo(notification)">
                            <div class="preview-thumbnail">
                                <div :class="['preview-icon', notification.iconColor]">
                                    <i :class="['mx-0', notification.icon]"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">{{ notification.title }}</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">{{ notification.time }}</p>
                            </div>
                        </a>

                    </div>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="../../../../assets/images/logo.png" alt="profile" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item">
                            <i class="ti-settings text-primary"></i>
                            <router-link :to="`/settings/update/${userId}`"
                                style="text-decoration:none;color:inherit;">Settings</router-link>
                        </a>
                        <a class="dropdown-item" @click="logout">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>
                    </div>

                </li>
                <li class="nav-item nav-settings d-none d-lg-flex">
                    <a class="nav-link" href="#">
                        <i class="icon-ellipsis"></i>
                    </a>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
        </div>
    </nav>
</template>
<script>
import Pusher from 'pusher-js';
import { toast } from "vue3-toastify";
export default {
    name: 'Navbar',
    data() {
        return {
            notifications: [],
            username: '',
            userRole: '',
            userId: '',
            loading: true // Add a loading state
        }
    },
    created() {
        this.userId = localStorage.getItem('userId');
    },
    mounted() {
        // Check if the user is logged in
        if (localStorage.getItem('api_token')) {
            // Make an API call to retrieve the currently logged-in user's data
            axios.get('/api/getUserData', {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('api_token')
                }
            })
                .then(response => {
                    this.userRole = response.data.user_role;

                    // Initialize Pusher
                    var pusher = new Pusher('29d53f8816252d29de52', {
                        cluster: 'ap1'
                    });

                    // Subscribe to the appropriate channel based on user role
                    if (this.userRole === 'admin') {
                        // Admin subscribes to the new TA request channel
                        this.subscribeToChannel(pusher, 'ict-ta-channel', 'new-ict-ta', 'New TA Request', 'bg-success', 'ti-alert', '/rictu/ict_ta/index');
                    } 
                    // else if (this.userRole === 'user') {
                    //     // User subscribes to their own channels
                    //     this.subscribeToChannel(pusher, 'received-ta-channel', 'received-ict-ta', 'Your Request has been Received', 'bg-warning', 'ti-check', '/rictu/ict_ta/index');
                    //     this.subscribeToChannel(pusher, 'completed-ta-channel', 'completed-ict-ta', 'Your Request has been Completed. Please take the Survey! Thank you!', 'bg-info', 'ti-thumb-up', '/rictu/ict_ta/index');
                    // }
                    this.loading = false; // Set loading to false after fetching data
                })
                .catch(error => {
                    console.error(error);
                    this.loading = false; // Ensure loading is false if an error occurs
                });
        } else {
            // Handle not logged in case
            console.error('Unauthorized access');
            this.loading = false; // Ensure loading is false if not logged in
        }
    },

    methods: {

        logout() {
            const apiToken = localStorage.getItem('api_token');

            axios.post('/api/logout', null, {
                headers: {
                    Authorization: `Bearer ${apiToken}`
                }
            })
                .then(() => {
                    // Clear local storage and any other cached data
                    localStorage.removeItem('api_token');

                    // Redirect to the login page or another appropriate page
                    // For example, if using Vue Router:
                    this.$router.push('/');
                })
                .catch(error => {
                    console.error('Logout failed:', error);
                });
        },
        subscribeToChannel(pusher, channelName, eventName, notificationTitle, iconColor, iconClass, redirectUrl) {
            let channel = pusher.subscribe(channelName);
            channel.bind(eventName, (data) => {
                // Different logic based on user role
                if (this.userRole === 'admin') {
                    // Admin will see the sender's name in the notification
                    this.notifications.push({
                        id: data.id,
                        title: `${notificationTitle} from ${data.name}`, // Show sender's name
                        iconColor: iconColor,
                        icon: iconClass,
                        time: new Date().toLocaleString(),
                        redirectUrl: redirectUrl // Add the URL for redirection
                    });

                    // Display toast notification for admins with sender's name
                    this.showAlert(`${notificationTitle} from ${data.name}`);
                } 
                // else if (this.userRole === 'user') {
                //     // User will see a general notification about their request status
                //     this.notifications.push({
                //         id: data.id,
                //         title: notificationTitle,
                //         iconColor: iconColor,
                //         icon: iconClass,
                //         time: new Date().toLocaleString(),
                //         redirectUrl: redirectUrl // Add the URL for redirection
                //     });

                //     // Display toast notification for users without sender's name
                //     this.showAlert(notificationTitle);
                // }
            });
        },
        showAlert(title) {
            toast.success(title, {
                autoClose: 1500,  // Close the toast automatically after 1.5 seconds
            });
        },
        redirectTo(notification) {
            // Navigate to the URL for this notification
            window.location.href = notification.redirectUrl;
        }

    }
}
</script>