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

.active {
    background-color: #f8f9fa;
    /* Apply your active background color here */
    /* Add any other styles for active state */
}
</style>
<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar" style="background-color:rgb(38, 50, 56);">
        <ul class="nav" v-if="this.user_role == 'admin'">
            <li class="nav-item" v-for="(menuItem, index) in filteredMenuItems" :key="index">
                <template v-if="hasChildren(menuItem)">
                    <router-link class="nav-link " :to="menuItem.link" :data-target="'#ui-basic-' + index"
                        :aria-controls="'ui-basic-' + index" :aria-expanded="isExpanded(index)"
                        @click.prevent="toggleCollapse(index)">
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class" />
                        <span class="menu-title"> {{ menuItem.name }}</span>
                        <i class="menu-arrow"></i>
                    </router-link>
                    <div class="collapse" :id="'ui-basic-' + index" :class="{ show: isExpanded(index) }">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item" v-for="(childItem, childIndex) in menuItem.children" :key="childIndex">
                                <router-link class="nav-link" :to="childItem.link">
                                    <font-awesome-icon :icon="childItem.icon" :class="menuItem.class" />
                                    {{ childItem.name }}
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </template>
                <template v-else>
                    <router-link class="nav-link" :to="menuItem.link">
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class" />
                        <span class="menu-title">{{ menuItem.name }}</span>
                    </router-link>
                </template>
            </li>
        </ul>
        <ul class="nav" v-else>
            <li class="nav-item" v-for="(menuItem, index) in filteredMenuItems" :key="index">
                <template v-if="hasChildren(menuItem)">
                    <router-link class="nav-link " :to="menuItem.link" :data-target="'#ui-basic-' + index"
                        :aria-controls="'ui-basic-' + index" :aria-expanded="isExpanded(index)"
                        @click.prevent="toggleCollapse(index)">
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class" />
                        <span class="menu-title"> {{ menuItem.name }}</span>
                        <i class="menu-arrow"></i>
                    </router-link>
                    <div class="collapse" :id="'ui-basic-' + index" :class="{ show: isExpanded(index) }">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item" v-for="(childItem, childIndex) in menuItem.children" :key="childIndex">
                                <router-link class="nav-link" :to="childItem.link">
                                    <font-awesome-icon :icon="childItem.icon" :class="menuItem.class" />
                                    {{ childItem.name }}
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </template>
                <template v-else>
                    <router-link class="nav-link" :to="menuItem.link">
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class" />
                        <span class="menu-title">{{ menuItem.name }}</span>
                    </router-link>
                </template>
            </li>
        </ul>
    </nav>
</template>
<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCartShopping, faGauge, faList, faChartSimple, faClipboardList, faStore, faBook, faAward, faCalendar, faUsers, faAddressBook, faBoxArchive, faUserTie, faPlaneDeparture, faFileMedical, faComputer, faGroupArrowsRotate, faCoins } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";
library.add(faGroupArrowsRotate, faCartShopping, faGauge, faList, faChartSimple, faClipboardList, faStore, faBook, faAward, faCalendar, faUsers, faAddressBook, faBoxArchive, faUserTie, faPlaneDeparture, faFileMedical, faComputer, faCoins);

export default {
    name: 'Sidebar',
    data() {
        return {
            user_role: null,
            userId: null,
            expandedItems: [],
            allowedMenus: JSON.parse(localStorage.getItem('module_access')) || [], // Load module access from localStorage
        };
    },
    props: {
        menuItems: {
            type: Array,
            default: () => [
                {
                    link: '/dashboard',
                    name: 'Dashboard',
                    tooltip: 'Dashboard',
                    icon: 'gauge',
                    class: 'menu-icon-custom',
                },
                {
                    link: '/calendar/index',
                    name: 'Calendar',
                    tooltip: 'Calendar',
                    icon: 'calendar',
                    class: 'menu-icon-custom',
                },
                {
                    link: '',
                    name: 'Procurement',
                    tooltip: 'General Service Section',
                    icon: 'cart-shopping',
                    class: 'menu-icon-custom',
                    children: [
                        { link: '/procurement/AnnualProcurementPlan', name: 'APP', icon: 'list' },
                        { link: '/procurement/index', name: 'Procurement Request', icon: 'store' },
                        { link: '/procurement/rfq/index', name: 'R.F.Q', icon: 'book' },
                        { link: '/procurement/abstract/index', name: 'Philgeps Awarding', icon: 'award' },
                        { link: '/procurement/pr_monitoring', name: 'Monitoring', icon: 'clipboard-list' },
                    ],
                },
                {
                    link: '',
                    name: 'Budget Section',
                    tooltip: 'Buttons',
                    icon: 'book',
                    class: 'menu-icon-custom',
                    children: [
                        { link: '/budget/obligation', name: 'Obligation', icon: 'book' },
                    ],
                },
                {
                    link: '',
                    name: 'RICTU',
                    tooltip: 'RICTU',
                    icon: 'computer',
                    class: 'menu-icon-custom',
                    children: [
                        { link: '/rictu/ict_ta/index', name: 'ICT TA', icon: 'group-arrows-rotate' },
                    ],
                },
                {
                    link: '',
                    name: 'QMS',
                    tooltip: 'Calendar',
                    icon: 'computer',
                    class: 'menu-icon-custom',
                    children: [
                        { link: '/qms/quality_procedure/index', name: 'Quality Procedures', icon: 'clipboard-list' },
                        { link: '/qms/process_owner/index', name: 'Process Owners', icon: 'clipboard-list' },
                        { link: '/qms/reports_submission/index', name: 'Reports Submission', icon: 'clipboard-list' },
                    ],
                },
                {
                    link: '/settings/user-management/',
                    name: 'User Management',
                    tooltip: 'User Management',
                    icon: 'gear',
                    class: 'menu-icon-custom',
                },
            ],
        },
    },
    computed: {
        filteredMenuItems() {
            // Filter menu items based on allowedMenus
            return this.menuItems.filter(menu => {
                // Include parent menu if it has a matching link or any child matches
                if (this.allowedMenus.includes(menu.link)) {
                    return true;
                }
                if (menu.children && menu.children.some(child => this.allowedMenus.includes(child.link))) {
                    return true;
                }
                return false;
            }).map(menu => {
                // If parent menu has children, filter children based on allowedMenus
                if (menu.children) {
                    return {
                        ...menu,
                        children: menu.children.filter(child => this.allowedMenus.includes(child.link)),
                    };
                }
                return menu;
            });
        },
    },
    created() {
        this.user_role = localStorage.getItem('user_role');
        this.userId = localStorage.getItem('userId');
        const moduleAccess = localStorage.getItem('module_access');

        if (moduleAccess) {
            try {
                this.allowedMenus = JSON.parse(moduleAccess);

            } catch (e) {
                console.error('Error parsing module_access:', e);
                this.allowedMenus = [];
            }
        } else {
            this.allowedMenus = [];
        }
    },
    methods: {
        hasChildren(item) {
            return item.children && item.children.length > 0;
        },
        isExpanded(index) {
            return this.expandedItems.includes(index);
        },
        toggleCollapse(index) {
            if (this.isExpanded(index)) {
                const itemIndex = this.expandedItems.indexOf(index);
                this.expandedItems.splice(itemIndex, 1);
            } else {
                this.expandedItems.push(index);
            }
        },
    },
    components: {
        FontAwesomeIcon,
    },
};
</script>
