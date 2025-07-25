require('./bootstrap');



import { createApp } from 'vue';
import App from './App.vue';
import store from './store/store';
import router from './router';
import './bootstrap'; // Import Echo setup
import * as globalMethods from './globalMethods'; // Import all global methods
import * as VueMultiselect from 'vue-multiselect';
import TextInput from "./components/micro/TextInput.vue";
import TextAreaInput from "./components/micro/TextAreaInput.vue";
import 'select2/dist/css/select2.min.css';
import '@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Select2 from './components/Select2.vue';
import DailyTimeRecord from "./components/human_resource/daily_time_record/index.vue";

const app = createApp(App);

// Add the methods to the Vue prototype
Object.keys(globalMethods).forEach(methodName => {
    app.config.globalProperties[`$${methodName}`] = globalMethods[methodName];
});
app.component('Select2', Select2);
app.component('font-awesome-icon', FontAwesomeIcon); // Register font-awesome-icon globally
app.component('vue-multiselect', VueMultiselect); // Register vue-multiselect globally
app.component('TextInput', TextInput); // Register vue-multiselect globally
app.component('TextAreaInput', TextAreaInput); // Register vue-multiselect globally
app.component('DailyTimeRecord', DailyTimeRecord); // Register DailyTimeRecord globally


// Mount the app with router, store, and other configurations
app.use(router)
    .use(store)
    .mount('#app');


