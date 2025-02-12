import { reactive } from 'vue';

export const eventBus = reactive({
    listeners: [],

    on(event, callback) {
        this.listeners.push({ event, callback });
    },

    emit(event, data) {
        this.listeners.forEach((listener) => {
            if (listener.event === event) {
                listener.callback(data);
            }
        });
    }
});
