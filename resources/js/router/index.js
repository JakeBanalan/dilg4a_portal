import {
    createRouter,
    createWebHistory
} from "vue-router";

import LoginForm from "../components/LoginForm.vue";
import ExampleComponent from "../components/ExampleComponent.vue";
import DashboardComponent from "../components/DashboardComponent.vue";
import LoginComponent from "../components/LoginComponent.vue";
import Procurement from "../components/procurement/index.vue";
import ProcurementMonitoring from "../components/procurement/pr_monitoring.vue";
import AnnualProcurementPlan from "../components/procurement/AnnualProcurementPlan.vue";

// FORMS
import AddAppItem from "../components/procurement/add_app_item.vue";
import CreatePRItem from "../components/procurement/create_pr.vue"
import ViewPRItem from "../components/procurement/view_pr.vue";
import UpdatePRItem from "../components/procurement/update_pr.vue";
import AddAPPDetails from "../components/procurement/add_item_details.vue";

// Statistics
import procurement_stat from "../components/procurement/procurement_stat.vue";
import axios from "axios";

// RFQ
import dashboard_rfq from "../components/procurement/rfq/index.vue";
import rfq_details from "../components/procurement/rfq/rfq_details.vue";
import view_rfq from "../components/procurement/rfq/view_rfq.vue";

//ABSTRACT
import view_abstract from "../components/procurement/abstract/view_abstract.vue";
import dashboard_abstract from "../components/procurement/abstract/index.vue";
import awarding from "../components/procurement/abstract/panel/awarding.vue";
import quotation from "../components/procurement/abstract/panel/quotation.vue";

//RESOLUTION
import create_reso from "../components/procurement/resolution/create_reso.vue";
import update_reso from "../components/procurement/resolution/update_reso.vue";

// PURCHASE ORDER
import create_po from "../components/procurement/purchase-order/panel/create.vue";

//Finance
import nta_nca from "../components/finance/accounting/nta.vue";
import disdisbursement from "../components/budget/obligation/index.vue";
import ntaShow from "../components/finance/accounting/ntaShow.vue";
import ntaCreate from "../components/finance/accounting/ntaCreate.vue";
import Disbursement from "../components/finance/accounting/disbursement.vue";
import disbursementCreate from "../components/finance/accounting/disbursementCreate.vue";


//HR Section
import employees_directory from "../components/human_resource/employees_directory/index.vue";
import daily_time_record from "../components/human_resource/daily_time_record/index.vue";
import AddMonthlyRecords from "../components/human_resource/daily_time_record/monthly.vue";
import ViewMonthlyRecords from "../components/human_resource/daily_time_record/viewRecord.vue";

// ICT TA
import dashboard_ict_ta from "../components/rictu/ict_ta/index.vue";
import create_ict from "../components/rictu/ict_ta/create.vue";
import view_ict from "../components/rictu/ict_ta/view.vue";
import pdfView from "../components/rictu/ict_ta/pdf_view.vue";

//calendar
import calendar from "../components/calendar/index.vue";

//QMS
import qms_process_owner from "../components/qms/process_owner/index.vue";
import qms_quality_procedure from "../components/qms/quality_procedure/index.vue";
import qms_report_submission from "../components/qms/reports_submission/index.vue";
import qms_provincial_report from "../components/qms/reports_submission/provincial_report.vue";
import qms_report_submission_view from "../components/qms/reports_submission/rs_entry.vue";
import qms_report_submission_update from "../components/qms/reports_submission/rs_update.vue";
import qms_quality_procedure_view from "../components/qms/quality_procedure/qp_entry.vue";
import qms_quality_procedure_update from "../components/qms/quality_procedure/qp_update.vue";
import qms_quality_objective_entry from "../components/qms/quality_procedure/qp_objectives_entry.vue";
import qms_quality_objective_update from "../components/qms/quality_procedure/qp_objectives_update.vue";
import qms_report_submission_quarterly_entry from "../components/qms/reports_submission/rs_obj_entries.vue";
import qms_report_submission_monthly_entry from "../components/qms/reports_submission/rs_monthly_entries.vue";
import qms_report_submission_quarterly_lnd_entry from "../components/qms/reports_submission/rs_quarterly_lnd_entries.vue";



//FINANCE
import finance_budget from "../components/finance/budget/index.vue";
import update_fs from "../components/finance/budget/update_fs.vue";
import create_fs from "../components/finance/budget/create_fs.vue";
import object_code from "../components/finance/budget/object_code.vue";
import budget_obligation from "../components/finance/budget/obligation.vue";
import pr_monitoring from "../components/finance/budget/pr_monitoring.vue";
import create_obligation from "../components/finance/budget/create_obligation.vue";
import update_obligation from "../components/finance/budget/update_obligation.vue";

// settings
import settingPanel from "../components/settings/user-management.vue";
import UpdateUserPanel from "../components/settings/update.vue";
import CreateUserPanel from "../components/settings/create.vue";
import View_abstract from "../components/procurement/abstract/view_abstract.vue";


// import _ from "lodash";
const routes = [{
        path: '/',
        name: 'Login',
        component: LoginComponent,

    },
    {
        path: '/sign-in',
        name: 'sign-in',
        component: LoginForm
    },
    {
        path: '/calendar/index',
        name: 'Calendar',
        component: calendar,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: DashboardComponent,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/calendar/index',
        name: 'Calendar',
        component: calendar,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/finance/budget/index',
        name: 'Budget',
        component: finance_budget,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/budget/create_fs',
        name: 'Create Fund Source',
        component: create_fs,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/budget/update_fs/:id',
        name: 'Fund Source',
        component: update_fs,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/budget/object_code',
        name: 'Object Code',
        component: object_code,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/budget/obligation',
        name: 'Obligation',
        component: budget_obligation,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/budget/update_obligation/:id',
        name: 'Update Obligation',
        component: update_obligation,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/budget/create_obligation',
        name: 'Create Obligation',
        component: create_obligation,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/budget/pr_monitoring',
        name: 'Procurement Monitoring1',
        component: pr_monitoring,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/accounting/nta',
        name: 'NTA / NCA',
        component: nta_nca,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/accounting/nta/:id',
        name: 'ntashow',
        component: ntaShow,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/accounting/nta',
        name: 'nta_nca',
        component: nta_nca,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/accounting/nta/create',
        name: 'Create NTA/NCA',
        component: ntaCreate,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/accounting/disbursement',
        name: 'Disbursement',
        component: Disbursement,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/finance/accounting/disbursement/create',
        name: 'Create Disbursement',
        component: disbursementCreate,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/index',
        name: 'Purchase Request',
        component: Procurement,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/pr_monitoring',
        name: 'Procurement Monitoring',
        component: ProcurementMonitoring,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/PPMP',
        name: 'Project Procurement Plan',
        component: AnnualProcurementPlan,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/add_app_item',
        name: 'Add PPMP',
        component: AddAppItem,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/create_pr',
        name: 'Create Purchase Request Item',
        component: CreatePRItem,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/update_pr',
        name: 'update_pr',
        component: UpdatePRItem,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        },
        props: true, // Automatically bind route parameters as props
        // beforeEnter: (to, from, next) => {
        //     // Your beforeEnter logic if needed
        //     next();
        // },
    },
    {
        path: '/procurement/rfq',
        name: 'Request for Quotation',
        component: view_rfq,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        },
        props: true, // Automatically bind route parameters as props
        // beforeEnter: (to, from, next) => {
        //     // Your beforeEnter logic if needed
        //     next();
        // },
    },
    {
        path: '/procurement/abstract',
        name: 'View Abstract of Quotation',
        component: view_abstract,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        },
        props: true, // Automatically bind route parameters as props
        // beforeEnter: (to, from, next) => {
        //     // Your beforeEnter logic if needed
        //     next();
        // },
    },
    {
        path: '/procurement/create_pr/:id',
        name: 'Create Purchase Request Item with ID',
        component: CreatePRItem,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
        // beforeEnter: (to, from, next) => {
        //     // Check if the page is being refreshed (F5 or browser refresh button)
        //     if (!from.name) {
        //         // Redirect to "/procurement/procurement"
        //         next({ name: 'Procurement' });
        //     } else {
        //         // Continue with the normal navigation
        //         next();
        //     }
        // },
    },
    {
        path: '/procurement/view_pr/:id',
        name: 'View Purchase Request Item',
        component: ViewPRItem,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/add_app_details',
        name: 'Add Item Details',
        component: AddAPPDetails,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/statistic',
        name: 'Procurement Stat',
        component: procurement_stat,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/ExampleComponent',
        name: 'ExampleComponent',
        component: ExampleComponent,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/rfq/index',
        name: 'Request For Quotation',
        component: dashboard_rfq,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/rfq/:id',
        name: 'Request For Quotation Details',
        component: rfq_details,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/abstract/index',
        name: 'Abstract of Quotation',
        component: dashboard_abstract,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/abstract/awarding',
        name: 'Awarding',
        component: awarding,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/abstract/:id',
        name: 'Quotation',
        component: quotation,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/resolution',
        name: 'Create Resolution',
        component: create_reso,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
            {
        path: '/procurement/resolution/update/:id',
        name: 'Update Resolution',
        component: update_reso,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/procurement/purchase-order/:id',
        name: 'Create Purchase Order',
        component: create_po,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },

    {
        path: '/rictu/ict_ta/index',
        name: 'ICT Technical Assistance',
        component: dashboard_ict_ta,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }


    },
    {
        path: '/rictu/ict_ta/create',
        name: 'Create ICT Technical Assistance',
        component: create_ict,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/rictu/ict_ta/:id',
        name: 'View ICT Form',
        component: view_ict,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/rictu/ict_ta/pdf',
        name: 'PDF View',
        component: pdfView,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/qms/process_owner/index',
        name: 'Process Owner',
        component: qms_process_owner,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/qms/quality_procedure/index',
        name: 'Quality Procedures',
        component: qms_quality_procedure,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/qms/quality_procedure/qp_update/:id',
        //PAG MAY PARAMETER NA ID PRE GANITO ANG PAG RROUTE
        name: 'Update QP',
        component: qms_quality_procedure_update,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/qms/quality_procedure/qp_entry', // eto yon kanina
        name: 'Quality Procedure',
        component: qms_quality_procedure_view,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/qms/quality_procedure/qp_objectives_entry/:id', // eto yon kanina
        name: 'Quality Objectives',
        component: qms_quality_objective_entry,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/qms/quality_procedure/qp_objectives_update/:id/:qoe_id', // eto yon kanina
        name: 'Update Quality Objectives',
        component: qms_quality_objective_update,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/qms/reports_submission/index',
        name: 'Regional Reports',
        component: qms_report_submission,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/qms/reports_submission/provincial_report',
        name: 'Provincial Report',
        component: qms_provincial_report,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/qms/reports_submission/rs_entry',
        name: 'Submit Report',
        component: qms_report_submission_view,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/qms/reports_submission/rs_update/:id',
        name: 'Submit Report Submission',
        component: qms_report_submission_update,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/qms/reports_submission/rs_obj_entries/:id/:qoe_id1',
        name: 'Submit Quarterly Report ',
        component: qms_report_submission_quarterly_entry,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/qms/reports_submission/rs_monthly_entries/:id/:qoe_id1',
        name: 'Submit Monthly Report ',
        component: qms_report_submission_monthly_entry,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/qms/reports_submission/rs_quarterly_lnd_entries/:id/:qoe_id1',
        name: 'Submit Quarterly(Learning and Development) Report ',
        component: qms_report_submission_quarterly_lnd_entry,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }

    },
    {
        path: '/human_resource/employees_directory/index',
        name: 'Employees Directory',
        component: employees_directory,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/human_resource/daily_time_record/index',
        name: 'Daily Time Record',
        component: daily_time_record,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/human_resource/daily_time_record/monthly',
        name: 'Add Monthly Records',
        component: AddMonthlyRecords,
        meta: {
            requiresAuth: true,
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                },
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        },
    },
    {
        path: '/human_resource/daily_time_record/:userId',
        name: 'View Monthly Records',
        component: ViewMonthlyRecords,
        meta: {
            requiresAuth: true,
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                },
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        },
    },
    {
        path: '/settings/user-management',
        name: 'User Management',
        component: settingPanel,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/settings/update/:id',
        name: 'Update User',
        component: UpdateUserPanel,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    },
    {
        path: '/settings/create',
        name: 'Create User',
        component: CreateUserPanel,
        meta: {
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('api_token');
            axios.get('/api/authenticated', {
                params: {
                    api_token: token
                }
            }).then(response => {
                if (response.data.authenticated) {
                    next();
                } else {
                    next({
                        name: 'Login'
                    });
                }
            }).catch(() => {
                next({
                    name: 'Login'
                });
            });
        }
    }








];

const router = createRouter({
    mode: 'history',
    history: createWebHistory(process.env.BASE_URL),
    routes,
    router: router
})


router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('api_token');

    // Check if the route requires authentication
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // If the route requires authentication, check if the token is present
        if (!token) {
            // If token is not present, redirect to the sign-in page
            next({
                name: 'Login'
            });
        } else {
            // If token is present, validate the token with the backend
            axios.get('/api/authenticated', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                })
                .then(response => {
                    if (response.data.authenticated) {
                        // If token is valid, proceed with the navigation
                        next();
                    } else {
                        // If token is invalid, redirect to the sign-in page
                        next({
                            name: 'Login'
                        });
                    }
                })
                .catch(() => {
                    // If an error occurs during token validation, redirect to the sign-in page
                    next({
                        name: 'Login'
                    });
                });
        }
    } else {
        // If the route does not require authentication, proceed with the navigation
        next();
    }
});






export default router
