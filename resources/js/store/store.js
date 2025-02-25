// store.js
import { createStore } from 'vuex';

export default createStore({
    state: {
        userId: null,
        filterParams: {}
        // Add other state properties as needed
    },
    mutations: {
        setUserId(state, userId) {
            state.userId = userId;
        },
        // Add other mutations as needed
    },
    actions: {
        // Add actions as needed
    },
    getters: {
        // Add getters as needed
    },
});

