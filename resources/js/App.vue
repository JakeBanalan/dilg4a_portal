<template>
    <RouterView/>
</template>
<style>
    .menu-icon-custom {
        font-size: 1rem;
        line-height: 1;
        margin-right: .50rem;
    }
    
    .nav-item {
        font-family: 'Poppins';
        color: #fff;
    }
    
    /* Active link highlighting */
    .router-link-active,
    .router-link-exact-active,
    .nav-item.active>.nav-link {
        background-color: #1e2a33;
        /* Darker highlight for active */
        color: #fff;
        font-weight: 500;
    }
    
    /* Sidebar scrollable */
    .collapse {
        transition: all 0.3s ease;
    }
    
    /* Sidebar background */
    .sidebar-offcanvas {
        background-color: rgb(38, 50, 56);
    }
    
    /* Desktop: Fixed sidebar */
    @media (min-width: 992px) {
        .sidebar {
            position: fixed;
            top: 60px; /* Start below fixed navbar */
            left: 0;
            width: 235px; /* Match sidebar width */
            height: calc(100vh - 60px); /* Full height minus navbar */
            overflow-y: auto;
            z-index: 1040; /* keep above main content */
            transition: width 0.3s ease; /* Smooth transition when minimizing */
        }
        
        /* Ensure main content doesn't overlap with fixed sidebar */
        .main-panel {
            margin-left: 235px !important;
            transition: margin-left 0.3s ease; /* Smooth transition when sidebar minimizes */
        }
        
        /* When sidebar is minimized (icon-only mode) */
        body.sidebar-icon-only .sidebar {
            width: 70px; /* Minimized sidebar width */
        }
        
        body.sidebar-icon-only .main-panel {
            margin-left: 70px !important; /* Adjust main content for minimized sidebar */
        }
    }
    
    /* Mobile: Sidebar overlay */
    @media (max-width: 991px) {
        .sidebar {
            position: fixed;
            top: 60px;
            left: -235px; /* Hidden by default on mobile */
            width: 235px;
            height: calc(100vh - 60px);
            overflow-y: auto;
            z-index: 1040;
            transition: left 0.3s ease;
        }
        
        .sidebar-offcanvas.active {
            left: 0; /* Show when active */
        }
        
        .main-panel {
            margin-left: 0 !important;
        }
    }
    
    </style>
<script>
import ExampleComponent from "./components/ExampleComponent.vue";
import LoginComponent from "./components/LoginComponent.vue";
import DashboardComponent from "./components/DashboardComponent.vue";
import Procurement from "./components/procurement/index.vue";
import create_ict from "./components/rictu/ict_ta/create.vue";
import AnnualProcurementPlan from "./components/procurement/AnnualProcurementPlan.vue";
import Sidebar from "./components/layout/Sidebar.vue";
import DailyTimeRecord from "./components/human_resource/daily_time_record/index.vue";

export default {
    name: "App",
    components: {
        ExampleComponent,
        LoginComponent,
        DashboardComponent,
        Sidebar,
        Procurement,
        AnnualProcurementPlan,
        create_ict,
        DailyTimeRecord
    }
}

</script>
