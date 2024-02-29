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

//ABSTRACT
import dashboard_abstract from "../components/procurement/abstract/index.vue";

//HR Section
import employees_directory from "../components/human_resource/employees_directory/index.vue";
import daily_time_record from "../components/human_resource/daily_time_record/index.vue";

// ICT TA
import dashboard_ict_ta from "../components/rictu/ict_ta/index.vue";
import create_ict from "../components/rictu/ict_ta/create.vue";

//CALENDAR
import calendar from "../components/calendar/index.vue";

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
        //BEFOR DEPLOYMENT, IT MUST BE COMPLETED THE BUG ON AUTHENTICAION AND FOR THE SECURITY
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
    },
    {
        path:'/procurement/abstract/index',
        name:'Abstract of Quotation',
        component:dashboard_abstract
    },
    // {
    //     path:'/rictu/ict_ta/index',
    //     name:'ICT Technical Assistance',
    //     component:dashboard_ict_ta
    // },
    // {
    //     path:'/rictu/ict_ta/create',
    //     name:'Create ICT Technical Assistance',
    //     component:create_ict
    // },
    // {
    //     path:'/human_resource/employees_directory/index',
    //     name:'Employees Directory',
    //     component:employees_directory
    // },
    {
        path:'/calendar/index',
        name:'Calendar',
        component:calendar
       
    },
    {
        path:'/rictu/ict_ta/create',
        name:'Create ICT Technical Assistance',
        component:create_ict
    },
    {
        path:'/human_resource/employees_directory/index',
        name:'Employees Directory',
        component:employees_directory
    },
    {
        path:'/human_resource/daily_time_record/index',
        name:'Daily Time Record',
        component:daily_time_record
    }
   
   





];
const router = createRouter({
    mode: 'history',
    history: createWebHistory(process.env.BASE_URL),
    routes,
    router: router
})


export default router