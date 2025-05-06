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
            <a class="navbar-brand brand-logo mr-5" href="#"><img src="../../../../assets/images/logo.png" class="mr-2"
                    alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="#"><img src="../../../../assets/images/logo.png"
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
                            class="dropdown-item preview-item" @click="redirectTo(notification)"
                            :data-notification-id="notification.id">
                            <div class="preview-thumbnail">
                                <div :class="['preview-icon', notification.iconColor]">
                                    <i :class="['mx-0', notification.icon]"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <div class="d-flex justify-content-between">
                                    <h6 class="preview-subject font-weight-normal">{{ notification.title }}</h6>
                                    <button class="btn btn-link p-0"
                                        @click.stop="clearSingleNotification(notification.id)">
                                        <i class="ti-close text-danger"></i>
                                    </button>
                                </div>
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
            loading: true,
            pusher: null,
            channels: [] // Store channel references to properly unsubscribe later
        }
    },
    created() {
        this.userId = localStorage.getItem('userId');
    },
    beforeUnmount() {
        // Clean up Pusher connections before component is destroyed
        this.cleanPusher();
    },
    mounted() {
        this.initializeUserData();
    },
    methods: {
        async initializeUserData() {
            if (!localStorage.getItem('api_token')) {
                console.error('Unauthorized access');
                this.loading = false;
                return;
            }

            try {
                const response = await axios.get('/api/getUserData', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('api_token')
                    }
                });

                this.userRole = response.data.user_role;
                this.initializePusher();
                this.loading = false;
            } catch (error) {
                console.error('Failed to fetch user data:', error);
                this.loading = false;
            }
        },

        initializePusher() {
            // Initialize Pusher with error handling
            try {
                this.pusher = new Pusher('29d53f8816252d29de52', {
                    cluster: 'ap1',
                    // Add proper error handling
                    enabledTransports: ['ws', 'wss'],
                    disabledTransports: []
                });

                this.pusher.connection.bind('error', (err) => {
                    console.error('Pusher connection error:', err);
                });

                // Set up channels based on user role
                if (this.userRole === 'admin') {
                    this.setupAdminChannels();
                } else if (this.userRole === 'user') {
                    this.setupUserChannels();
                }
            } catch (err) {
                console.error('Error initializing Pusher:', err);
            }
        },

        setupAdminChannels() {
            // Admin subscribes to the new TA request channel
            this.subscribeToChannel('ict-ta-channel', 'new-ict-ta', 'New TA Request', 'bg-success', 'ti-alert', '/rictu/ict_ta/index', this.userId);

            // // Subscribe to additional channels
            // this.subscribeToChannel('received-ta-channel', 'received-ict-ta');
            // this.subscribeToChannel('completed-ta-channel', 'completed-ict-ta');
        },

        setupUserChannels() {
            this.subscribeToChannel('completed-ta-channel', 'completed-ict-ta', 'Your Request has been Completed. Please take the Survey! Thank you!', 'bg-info', 'ti-thumb-up', '/rictu/ict_ta/index');
            this.subscribeToChannel('received-ta-channel', 'received-ict-ta', 'Your Request has been Received', 'bg-info', 'ti-info', '/rictu/ict_ta/index');
        },

        clearSingleNotification(notificationId) {
            // Prevent event bubbling and safely remove notification
            this.notifications = this.notifications.filter(notification => notification.id !== notificationId);
            this.$forceUpdate();
        },

        async logout() {
            try {
                // Clean up Pusher connections before logout
                this.cleanPusher();

                const apiToken = localStorage.getItem('api_token');
                await axios.post('/api/logout', null, {
                    headers: {
                        Authorization: `Bearer ${apiToken}`
                    }
                });

                localStorage.removeItem('api_token');
                this.$router.push('/');
            } catch (error) {
                console.error('Logout failed:', error);
            }
        },

        subscribeToChannel(channelName, eventName, notificationTitle, iconColor, iconClass, redirectUrl, requesterId) {
            if (!this.pusher) {
                console.error('Pusher not initialized');
                return;
            }

            try {
                const channel = this.pusher.subscribe(channelName);
                // Store channel reference for cleanup
                this.channels.push({ name: channelName, channel });

                channel.bind(eventName, (data) => {
                    // Handle notifications differently based on user role
                    this.handleNotificationEvent(data, channelName, eventName, notificationTitle, iconColor, iconClass, requesterId);
                });

                // Handle subscription errors
                channel.bind('pusher:subscription_error', (status) => {
                    console.error(`Subscription to ${channelName} failed with status ${status}`);
                });
            } catch (err) {
                console.error(`Error subscribing to channel ${channelName}:`, err);
            }
        },

        handleNotificationEvent(data, channelName, eventName, notificationTitle, iconColor, iconClass, requesterId) {
            // Extract notification processing logic to separate method
            if (this.userRole === 'admin') {
                this.handleAdminNotification(data, notificationTitle, iconColor, iconClass, requesterId);
            } else if (this.userRole === 'user') {
                this.handleUserNotification(data, channelName, notificationTitle, iconColor, iconClass);
            }
        },

        handleAdminNotification(data, notificationTitle, iconColor, iconClass, requesterId) {
            // Only handle notifications meant for this admin (avoid duplicate processing)
            if (data.requester_id !== requesterId) {
                const notification = {
                    id: data.id,
                    title: `${notificationTitle} from ${data.name}`,
                    iconColor: iconColor,
                    icon: iconClass,
                    time: new Date().toLocaleString(),
                    redirectUrl: "/rictu/ict_ta/index"
                };

                this.notifications.push(notification);
                this.showAlert(`${notificationTitle} from ${data.name}`);

                // Show browser notification if permission granted
                this.showBrowserNotification(notification.title, iconClass, data.id);
            }
        },

        handleUserNotification(data, channelName, notificationTitle, iconColor, iconClass) {
            // Only process notifications for this user
            if (data.requester_id === this.userId) {
                const notification = {
                    id: data.id,
                    title: `${notificationTitle} by ${data.receiverName}`,
                    iconColor: iconColor,
                    icon: iconClass,
                    time: new Date().toLocaleString(),
                    redirectUrl: "/rictu/ict_ta/index"
                };

                this.notifications.push(notification);
                this.showAlert(`${notificationTitle} by ${data.receiverName}`);
                // Handle completed notifications specially
                if (channelName === 'completed-ta-channel') {
                    this.showCompletedNotification(data, notificationTitle);
                } else {
                    this.showReceivedNotification(data, notificationTitle);
                }

                // Show browser notification
                this.showBrowserNotification(notification.title, iconClass, data.id);
            }
        },

        showCompletedNotification(data, notificationTitle) {
            Swal.fire({
                icon: 'success',
                title: `${notificationTitle} by ${data.receiverName}`,
                showConfirmButton: true,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed && data.link) {
                    window.open(data.link, '_blank');
                } else if (result.isConfirmed && !data.link) {
                    Swal.fire('No Survey Available', 'There is no survey link for this month.', 'info');
                }
            });
        },

        showReceivedNotification(data, notificationTitle) {
            Swal.fire({
                icon: 'success',
                title: `${notificationTitle} by ${data.receiverName}`,
                showConfirmButton: true,
                confirmButtonText: 'OK',
            });
        },

        showBrowserNotification(title, iconClass, id) {
            if (Notification.permission === 'granted') {
                new Notification(title, {
                    icon: iconClass,
                    tag: id
                });
            }
        },

        showAlert(title) {
            toast.success(title, {
                autoClose: 1500,
            });
        },

        redirectTo(notification) {
            window.location.href = notification.redirectUrl;
        },

        cleanPusher() {
            if (this.pusher) {
                this.channels.forEach(channel => {
                    this.pusher.unsubscribe(channel);
                });

                // Only disconnect if not already disconnecting or closed
                const state = this.pusher.connection.state;
                if (state === 'connected' || state === 'connecting') {
                    this.pusher.disconnect();
                }

                // Clean up references
                this.pusher = null;
                this.channels = [];
            }
        }

    }
}
</script>
