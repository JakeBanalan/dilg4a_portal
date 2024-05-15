require('./bootstrap');



import { createApp } from 'vue';
import App from './App.vue';
import store from './store/store';
import router from './router';
import * as globalMethods from './globalMethods'; // Import all global methods
import * as VueMultiselect from 'vue-multiselect';
import TextInput from "./components/micro/TextInput.vue";
import TextAreaInput from "./components/micro/TextAreaInput.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const app = createApp(App);

// Add the methods to the Vue prototype
Object.keys(globalMethods).forEach(methodName => {
    app.config.globalProperties[`$${methodName}`] = globalMethods[methodName];
});
    
app.component('font-awesome-icon', FontAwesomeIcon); // Register font-awesome-icon globally
app.component('vue-multiselect', VueMultiselect); // Register vue-multiselect globally
app.component('TextInput', TextInput); // Register vue-multiselect globally
app.component('TextAreaInput', TextAreaInput); // Register vue-multiselect globally


// Mount the app with router, store, and other configurations
app.use(router)
   .use(store)
   .mount('#app');
   

