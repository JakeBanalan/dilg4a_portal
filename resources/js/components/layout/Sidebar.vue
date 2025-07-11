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
                    <router-link class="nav-link" :to="menuItem.link" :data-target="'#ui-basic-' + index"
                        :aria-controls="'ui-basic-' + index" :aria-expanded="isExpanded(index)"
                        @click.prevent="toggleCollapse(index)">
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class" />
                        <span class="menu-title"> {{ menuItem.name }}</span>
                        <i class="menu-arrow"></i>
                    </router-link>
                    <div class="collapse" :id="'ui-basic-' + index" :class="{ show: isExpanded(index) }">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item" v-for="(childItem, childIndex) in menuItem.children" :key="childIndex">
                                <template v-if="hasChildren(childItem)">
                                    <router-link class="nav-link" :to="childItem.link"
                                        :data-target="'#ui-basic-child-' + childIndex"
                                        :aria-controls="'ui-basic-child-' + childIndex"
                                        :aria-expanded="isExpanded(`${index}-${childIndex}`)"
                                        @click.prevent="toggleCollapse(`${index}-${childIndex}`)">
                                        <font-awesome-icon :icon="childItem.icon" :class="menuItem.class" />
                                        {{ childItem.name }}
                                        <i class="menu-arrow"></i>
                                    </router-link>
                                    <div class="collapse" :id="'ui-basic-child-' + childIndex"
                                        :class="{ show: isExpanded(`${index}-${childIndex}`) }">
                                        <ul class="nav flex-column sub-menu">
                                            <li class="nav-item"
                                                v-for="(grandChildItem, grandChildIndex) in childItem.children"
                                                :key="grandChildIndex">
                                                <router-link class="nav-link" :to="grandChildItem.link">
                                                    <font-awesome-icon :icon="grandChildItem.icon"
                                                        :class="menuItem.class" />
                                                    {{ grandChildItem.name }}
                                                </router-link>
                                            </li>
                                        </ul>
                                    </div>
                                </template>
                                <template v-else>
                                    <router-link class="nav-link" :to="childItem.link">
                                        <font-awesome-icon :icon="childItem.icon" :class="menuItem.class" />
                                        {{ childItem.name }}
                                    </router-link>
                                </template>
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
                    <router-link class="nav-link" :to="menuItem.link" :data-target="'#ui-basic-' + index"
                        :aria-controls="'ui-basic-' + index" :aria-expanded="isExpanded(index)"
                        @click.prevent="toggleCollapse(index)">
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class" />
                        <span class="menu-title"> {{ menuItem.name }}</span>
                        <i class="menu-arrow"></i>
                    </router-link>
                    <div class="collapse" :id="'ui-basic-' + index" :class="{ show: isExpanded(index) }">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item" v-for="(childItem, childIndex) in menuItem.children" :key="childIndex">
                                <template v-if="hasChildren(childItem)">
                                    <router-link class="nav-link" :to="childItem.link"
                                        :data-target="'#ui-basic-child-' + childIndex"
                                        :aria-controls="'ui-basic-child-' + childIndex"
                                        :aria-expanded="isExpanded(`${index}-${childIndex}`)"
                                        @click.prevent="toggleCollapse(`${index}-${childIndex}`)">
                                        <font-awesome-icon :icon="childItem.icon" :class="menuItem.class" />
                                        {{ childItem.name }}
                                        <i class="menu-arrow"></i>
                                    </router-link>
                                    <div class="collapse" :id="'ui-basic-child-' + childIndex"
                                        :class="{ show: isExpanded(`${index}-${childIndex}`) }">
                                        <ul class="nav flex-column sub-menu">
                                            <li class="nav-item"
                                                v-for="(grandChildItem, grandChildIndex) in childItem.children"
                                                :key="grandChildIndex">
                                                <router-link class="nav-link" :to="grandChildItem.link">
                                                    <font-awesome-icon :icon="grandChildItem.icon"
                                                        :class="menuItem.class" />
                                                    {{ grandChildItem.name }}
                                                </router-link>
                                            </li>
                                        </ul>
                                    </div>
                                </template>
                                <template v-else>
                                    <router-link class="nav-link" :to="childItem.link">
                                        <font-awesome-icon :icon="childItem.icon" :class="menuItem.class" />
                                        {{ childItem.name }}
                                    </router-link>
                                </template>
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
                    name: 'Human Resource',
                    tooltip: 'Human Resource',
                    icon: 'users',
                    class: 'menu-icon-custom',
                    children: [
                        { link: '/human_resource/daily_time_record/index', name: 'Daily Time Record', icon: 'clipboard-list' },
                        { link: '/human_resource/employees_directory/index', name: 'Employee Directory', icon: 'address-book' },
                    ],
                },
                {
                    link: '',
                    name: 'Procurement',
                    tooltip: 'General Service Section',
                    icon: 'cart-shopping',
                    class: 'menu-icon-custom',
                    children: [
                        { link: '/procurement/AnnualProcurementPlan', name: 'APP', icon: 'list' },
                        { link: '/procurement/index', name: 'Purchase Request', icon: 'store' },
                        { link: '/procurement/rfq/index', name: 'R.F.Q', icon: 'book' },
                        { link: '/procurement/abstract/index', name: 'Philgeps Awarding', icon: 'award' },
                        { link: '/procurement/pr_monitoring', name: 'Monitoring', icon: 'clipboard-list' },
                    ],
                },
                {
                    link: '',
                    name: 'Finance Section',
                    tooltip: 'Finance',
                    icon: 'book',
                    class: 'menu-icon-custom',
                    children: [
                        { link: '/finance/budget/index', name: 'Budget Section', icon: 'book' },
                        { link: '', name: 'Accounting Section', icon: 'book' },
                        { link: '', name: 'Cash Section', icon: 'book' },
                        { link: '/procurement/abstract/index', name: 'Funds Downloaded', icon: 'book' },
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
                        { link: '/qms/reports_submission/index', name: 'Regional QME', icon: 'clipboard-list' },
                        { link: '/qms/reports_submission/provincial_report', name: 'Provincial QME', icon: 'clipboard-list' },
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
                if (this.allowedMenus.includes(menu.link)) {
                    return true;
                }
                if (menu.children && menu.children.some(child => {
                    if (this.allowedMenus.includes(child.link)) {
                        return true;
                    }
                    return child.children && child.children.some(grandChild => this.allowedMenus.includes(grandChild.link));
                })) {
                    return true;
                }
                return false;
            }).map(menu => {
                if (menu.children) {
                    return {
                        ...menu,
                        children: menu.children.filter(child => {
                            if (this.allowedMenus.includes(child.link)) {
                                return true;
                            }
                            return child.children && child.children.some(grandChild => this.allowedMenus.includes(grandChild.link));
                        }).map(child => {
                            if (child.children) {
                                return {
                                    ...child,
                                    children: child.children.filter(grandChild => this.allowedMenus.includes(grandChild.link)),
                                };
                            }
                            return child;
                        }),
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
            // Check if the item has children
            return item.children && item.children.length > 0;
        },
        isExpanded(key) {
            // Check if the item is expanded
            return this.expandedItems.includes(key);
        },
        toggleCollapse(key) {
            // Toggle the collapse state of the item
            if (this.isExpanded(key)) {
                this.expandedItems = this.expandedItems.filter(item => item !== key);
            } else {
                this.expandedItems.push(key);
            }
        },
    },
    components: {
        FontAwesomeIcon,
    },
};
</script>
