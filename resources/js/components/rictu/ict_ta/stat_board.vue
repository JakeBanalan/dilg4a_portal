<template>
    <div>
        <div class="container col-md-12">
            <div class="header">
                <h1>
                    QP-DILG-ISTMS-RO-17: Provision of Preventive Maintenance and Technical Assistance on Information and
                    Communications Technology (ICT) Resources
                </h1>
            </div>
        </div>
        <div class="stat col-md-12">
            <div class="content">
                <div class="technical-assistance">
                    <p style="font-weight: 600;">Need ICT Technical Assistance?</p>
                    <button class="submit-request" @click="navigateToCreateRequest">
                        Submit a Request
                    </button>
                </div>
                <div class="requests-info">
                    <div class="request-card all-requests">
                        <p style="font-size: 1rem; font-weight: bold;">{{ isAdmin ? 'Total Requests' : 'User Requests' }}</p>
                        <p class="count">{{ isAdmin ? ictStats.adminTotal : ictStats.total }}</p>
                    </div>
                    <div class="request-card completed">
                        <p style="font-size: 1rem; font-weight: bold;">Completed Requests</p>
                        <p class="count">{{ isAdmin ? ictStats.adminCompleted : ictStats.completed }}</p>
                    </div>
                    <div class="request-card ongoing">
                        <p style="font-size: 1rem; font-weight: bold;">Ongoing Requests</p>
                        <p class="count">{{ isAdmin ? ictStats.adminReceived : ictStats.received }}</p>
                    </div>
                    <div class="request-card pending">
                        <p style="font-size: 1rem; font-weight: bold;">Pending Request</p>
                        <p class="count">{{ isAdmin ? ictStats.adminDraft : ictStats.draft }}</p>
                    </div>
                </div>
                <div class="contact-info">
                    <p style="font-size: 1rem !important;">
                        Still having problems? Contact RICTU at local 7406 or dilg4a.it@gmail.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pusher from 'pusher-js';

export default {
    name: 'ICTDashboard',

    data() {
        return {
            userId: null,
            role: null,
            pusher: null,
            channels: [],
            ictStats: {
                // User stats
                total: 0,
                draft: 0,
                received: 0,
                completed: 0,
                returned: 0,

                // Admin stats
                adminTotal: 0,
                adminDraft: 0,
                adminReceived: 0,
                adminCompleted: 0,
                adminReturned: 0
            }
        };
    },

    computed: {
        isAdmin() {
            return this.role === 'admin';
        }
    },

    created() {
        this.userId = localStorage.getItem('userId');
        this.role = localStorage.getItem('user_role');
    },

    mounted() {
        this.initializeData();
        this.setupPusherConnection();
    },

    beforeUnmount() {
        this.cleanupPusherConnection();
    },

    methods: {
        navigateToCreateRequest() {
            this.$router.replace({ path: '/rictu/ict_ta/create' });
        },

        initializeData() {
            // Load appropriate data based on user role
            if (this.isAdmin) {
                this.fetchAdminData();
            } else {
                this.fetchUserData();
            }
        },

        setupPusherConnection() {
            try {
                this.pusher = new Pusher('29d53f8816252d29de52', {
                    cluster: 'ap1'
                });

                // Subscribe to channels and handle events
                const receivedChannel = this.pusher.subscribe('received-ta-channel');
                const completedChannel = this.pusher.subscribe('completed-ta-channel');

                // Store channels for cleanup
                this.channels = [
                    { name: 'received-ta-channel', channel: receivedChannel },
                    { name: 'completed-ta-channel', channel: completedChannel }
                ];

                // Set up event handlers
                receivedChannel.bind('received-ict-ta', this.handleDataRefresh);
                completedChannel.bind('completed-ict-ta', this.handleDataRefresh);

                // Handle connection errors
                this.pusher.connection.bind('error', (err) => {
                    console.error('Pusher connection error:', err);
                });
            } catch (error) {
                console.error('Error setting up Pusher connection:', error);
            }
        },

        handleDataRefresh() {
            // Refresh the appropriate data based on user role
            if (this.isAdmin) {
                this.fetchAdminData();
            } else {
                this.fetchUserData();
            }
        },

        cleanupPusherConnection() {
            if (this.pusher) {
                // Unsubscribe from all channels
                this.channels.forEach(channel => {
                    this.pusher.unsubscribe(channel.name);
                });

                // Disconnect Pusher
                this.pusher.disconnect();
                this.pusher = null;
                this.channels = [];
            }
        },

        fetchUserData() {
            // Use Promise.all to fetch data in parallel for better performance
            Promise.all([
                this.fetchWithTimeout(() => axios.get(`/api/countICTRequest/${this.userId}`)),
                this.fetchWithTimeout(() => axios.get(`/api/countDRAFT/${this.userId}`))
            ])
            .then(([totalResponse, draftsResponse]) => {
                // Update user stats
                this.ictStats.total = totalResponse.data.ict;

                const drafts = draftsResponse.data[0];
                this.ictStats.draft = drafts.draft;
                this.ictStats.received = drafts.received;
                this.ictStats.completed = drafts.completed;
                this.ictStats.returned = drafts.returned;
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
            });
        },

        fetchAdminData() {
            // Use Promise.all to fetch admin data in parallel
            Promise.all([
                this.fetchWithTimeout(() => axios.get('/api/totalCountICTRequest')),
                this.fetchWithTimeout(() => axios.get('/api/totalCountDraft'))
            ])
            .then(([totalResponse, draftsResponse]) => {
                // Update admin stats
                this.ictStats.adminTotal = totalResponse.data.ictTotal;

                const drafts = draftsResponse.data[0];
                this.ictStats.adminDraft = drafts.draft;
                this.ictStats.adminReceived = drafts.received;
                this.ictStats.adminCompleted = drafts.completed;
                this.ictStats.adminReturned = drafts.returned;
            })
            .catch(error => {
                console.error('Error fetching admin data:', error);
            });
        },

        fetchWithTimeout(fetchFunction, timeout = 5000) {
            return new Promise((resolve, reject) => {
                // Set a timeout for the fetch operation
                const timeoutId = setTimeout(() => {
                    reject(new Error('Request timed out'));
                }, timeout);

                // Execute the fetch function
                fetchFunction()
                    .then(response => {
                        clearTimeout(timeoutId);
                        resolve(response);
                    })
                    .catch(error => {
                        clearTimeout(timeoutId);
                        reject(error);
                    });
            });
        }
    }
};
</script>

<style scoped>
/* Add your styles here */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: 100%;
}

.stat {
    display: flex;
    flex-direction: column;
    align-items: right;
    text-align: center;
    width: 100%;
}

.header {
    width: 100%;
    padding: 20px;
}

.header h1 {
    margin: 0;
    color: #00a2e8;
    font-size: 30px;
}

.content {
    display: flex;
    flex-direction: row;
    align-items: center;
}

.technical-assistance {
    margin-bottom: 20px;
}

.technical-assistance p {
    font-size: 1.2rem;
    color: #555;
}

.submit-request {
    background-color: #280e85;
    color: white;
    padding: 5px;
    border: none;
    border-radius: 25px;
    font-size: 1rem;
    margin-top: 10px;
}

.requests-info {
    display: flex;
    gap: 20px;
    margin-left: 70px;
}

.request-card {
    padding: 20px;
    border-radius: 5px;
    width: calc(15vw - 15px);
    height: 130px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.request-card p {
    margin: 0;
}

.request-card .count {
    margin-top: 30px;
    font-size: 4.5rem;
    font-weight: bold;
}

.all-requests {
    color: white;
    background-color: #7701b1;
}

.completed {
    color: white;
    background-color: #efcd51;
}

.ongoing {
    color: white;
    background-color: #215ef8;
}

.pending {
    color: white;
    background-color: #fc4242;
}

.contact-info {
    margin-left: 30px;
    margin-top: 20px;
    font-weight: 500;
    font-style: italic;
}
</style>
