import { createRouter, createWebHistory } from "vue-router";

import ExampleComponent from "../components/ExampleComponent.vue";
import DashboardComponent from "../components/DashboardComponent.vue";
import LoginComponent from "../components/LoginComponent.vue";
import Procurement from "../components/procurement/index.vue";
import AnnualProcurementPlan from "../components/procurement/AnnualProcurementPlan.vue";

// FORMS
import AddAppItem from "../components/procurement/add_app_item.vue";
import CreatePRItem from "../components/procurement/create_pr.vue"
import ViewPRItem from "../components/procurement/view_pr.vue";
import UpdatePRItem from "../components/procurement/update_pr.vue";

// Statistics
import procurement_stat from "../components/procurement/procurement_stat.vue";
import axios from "axios";

// RFQ
import dashboard_rfq from "../components/procurement/rfq/index.vue";
import rfq_details from "../components/procurement/rfq/rfq_details.vue";

const routes = [
    {
        path: '/',
        name: 'Login',
        component: LoginComponent
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: DashboardComponent,
        // beforeEnter:(to, form, next) => {
        //     axios.get('api/authenticated').then(()=>{
        //         next()
        //     }).catch(() =>{
        //         return next({ name: 'Login'})
        //     })
        // }

    },
    {
        path: '/procurement/index',
        name: 'Procurement',
        component: Procurement
    },
    {
        path: '/procurement/AnnualProcurementPlan',
        name: 'Annual Procurement Plan',
        component: AnnualProcurementPlan,
    },
    {
        path: '/procurement/add_app_item',
        name: 'Add Annual Procurement Plan Item',
        component: AddAppItem,
    },
    {
        path: '/procurement/create_pr',
        name: 'Create Purchase Request Item',
        component: CreatePRItem,
    },
    {
        path: '/procurement/update_pr',
        name: 'update_pr',
        component: UpdatePRItem,
        props: true, // Automatically bind route parameters as props
        beforeEnter: (to, from, next) => {
            // Your beforeEnter logic if needed
            next();
        },
    },

    {
        path: '/procurement/create_pr/:id',
        name: 'Create Purchase Request Item with ID',
        component: CreatePRItem,
        beforeEnter: (to, from, next) => {
            // Check if the page is being refreshed (F5 or browser refresh button)
            if (!from.name) {
                // Redirect to "/procurement/procurement"
                next({ name: 'Procurement' });
            } else {
                // Continue with the normal navigation
                next();
            }
        },
    },
    {
        path: '/procurement/view_pr/:id',
        name: 'View Purchase Request Item',
        component: ViewPRItem,
    },
    {
        path: '/procurement/statistic',
        name: 'Procurement Stat',
        component: procurement_stat,
    },
    {
        path: '/ExampleComponent',
        name: 'ExampleComponent',
        component: ExampleComponent
    },
    {
        path:'/procurement/rfq/index',
        name:'Request For Quotation',
        component:dashboard_rfq
    },
    {
        path:'/procurement/rfq/:id',
        name:'Request For Quotation Details',
        component:rfq_details
    }





];
const router = createRouter({
    mode: 'history',
    history: createWebHistory(process.env.BASE_URL),
    routes,
    router: router
})


export default router