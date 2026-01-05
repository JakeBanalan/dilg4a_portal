<style scoped>
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

/* Popup menu for minimized sidebar */
.sidebar-popup-menu {
    position: fixed;
    left: 70px;
    background-color: rgb(38, 50, 56);
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    z-index: 1050;
    min-width: 200px;
    max-width: 300px;
    padding: 0;
    margin-top: 0;
}

.popup-menu-header {
    padding: 12px 16px;
    font-weight: 600;
    color: #fff;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background-color: rgba(0, 0, 0, 0.2);
}

.popup-menu-list {
    list-style: none;
    padding: 8px 0;
    margin: 0;
}

.popup-menu-list li {
    margin: 0;
}

.popup-menu-item {
    display: flex;
    align-items: center;
    padding: 10px 16px;
    color: #fff;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.popup-menu-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.popup-menu-item.router-link-active {
    background-color: #1e2a33;
    color: #fff;
}

.popup-menu-icon {
    margin-right: 10px;
    width: 16px;
    text-align: center;
}

/* Expandable popup menu items */
.popup-menu-expandable {
    cursor: pointer;
    user-select: none;
}

.popup-menu-expandable:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.popup-menu-arrow {
    margin-left: auto;
    font-size: 18px;
    font-weight: bold;
    transition: transform 0.2s ease;
    color: rgba(255, 255, 255, 0.7);
}

.popup-menu-expandable.expanded .popup-menu-arrow {
    transform: rotate(90deg);
}

/* Nested children list */
.popup-menu-nested {
    list-style: none;
    padding: 0;
    margin: 0;
    background-color: rgba(0, 0, 0, 0.2);
    border-left: 2px solid rgba(255, 255, 255, 0.1);
    margin-left: 16px;
}

.popup-menu-nested li {
    margin: 0;
}

.popup-menu-nested-item {
    padding-left: 32px !important;
    font-size: 0.9em;
}

.popup-menu-nested-item .popup-menu-icon {
    font-size: 14px;
}

/* Hide popup when sidebar is not minimized */
body:not(.sidebar-icon-only) .sidebar-popup-menu {
    display: none !important;
}

</style>

<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav" v-if="this.user_role == 'admin'">
            <li class="nav-item" v-for="(menuItem, index) in filteredMenuItems" :key="index"
                :class="{ active: $route.path === menuItem.link }">
                <template v-if="hasChildren(menuItem)">
                    <router-link class="nav-link" :to="menuItem.link" :data-target="'#ui-basic-' + index"
                        :aria-controls="'ui-basic-' + index" :aria-expanded="isExpanded(index)"
                        @click.prevent="handleMenuItemClick(index, menuItem, $event)">
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class" />
                        <span class="menu-title"> {{ menuItem.name }}</span>
                        <i class="menu-arrow"></i>
                    </router-link>
                    <!-- Popup menu for minimized sidebar -->
                    <div v-if="hoveredItemIndex === index && isSidebarIconOnly()" class="sidebar-popup-menu" 
                         :style="{ top: popupPosition.top + 'px' }"
                         @mouseleave="closePopup">
                        <div class="popup-menu-header">{{ menuItem.name }}</div>
                        <ul class="popup-menu-list">
                            <li v-for="(childItem, childIndex) in menuItem.children" :key="childIndex">
                                <!-- If child has children, make it expandable -->
                                <template v-if="hasChildren(childItem)">
                                    <div class="popup-menu-item popup-menu-expandable" 
                                         @click="togglePopupItem(childIndex)"
                                         :class="{ expanded: isPopupItemExpanded(childIndex) }">
                                        <font-awesome-icon :icon="childItem.icon" class="popup-menu-icon" />
                                        <span>{{ childItem.name }}</span>
                                        <i class="popup-menu-arrow">›</i>
                                    </div>
                                    <!-- Nested children -->
                                    <ul v-if="isPopupItemExpanded(childIndex)" class="popup-menu-nested">
                                        <li v-for="(grandChildItem, grandChildIndex) in childItem.children" :key="grandChildIndex">
                                            <router-link :to="grandChildItem.link" class="popup-menu-item popup-menu-nested-item" @click="closePopup">
                                                <font-awesome-icon :icon="grandChildItem.icon" class="popup-menu-icon" />
                                                <span>{{ grandChildItem.name }}</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </template>
                                <!-- Direct child without nested children -->
                                <template v-else>
                                    <router-link :to="childItem.link" class="popup-menu-item" @click="closePopup">
                                        <font-awesome-icon :icon="childItem.icon" class="popup-menu-icon" />
                                        <span>{{ childItem.name }}</span>
                                    </router-link>
                                </template>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse" :id="'ui-basic-' + index" :class="{ show: isExpanded(index) }">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item" v-for="(childItem, childIndex) in menuItem.children" :key="childIndex"
                                :class="{ active: $route.path === childItem.link }">
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
                                                :key="grandChildIndex"
                                                :class="{ active: $route.path === grandChildItem.link }">
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
            <li class="nav-item" v-for="(menuItem, index) in filteredMenuItems" :key="index"
                :class="{ active: $route.path === menuItem.link }">
                <template v-if="hasChildren(menuItem)">
                    <router-link class="nav-link" :to="menuItem.link" :data-target="'#ui-basic-' + index"
                        :aria-controls="'ui-basic-' + index" :aria-expanded="isExpanded(index)"
                        @click.prevent="handleMenuItemClick(index, menuItem, $event)">
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class" />
                        <span class="menu-title"> {{ menuItem.name }}</span>
                        <i class="menu-arrow"></i>
                    </router-link>
                    <!-- Popup menu for minimized sidebar -->
                    <div v-if="hoveredItemIndex === index && isSidebarIconOnly()" class="sidebar-popup-menu" 
                         :style="{ top: popupPosition.top + 'px' }"
                         @mouseleave="closePopup">
                        <div class="popup-menu-header">{{ menuItem.name }}</div>
                        <ul class="popup-menu-list">
                            <li v-for="(childItem, childIndex) in menuItem.children" :key="childIndex">
                                <!-- If child has children, make it expandable -->
                                <template v-if="hasChildren(childItem)">
                                    <div class="popup-menu-item popup-menu-expandable" 
                                         @click="togglePopupItem(childIndex)"
                                         :class="{ expanded: isPopupItemExpanded(childIndex) }">
                                        <font-awesome-icon :icon="childItem.icon" class="popup-menu-icon" />
                                        <span>{{ childItem.name }}</span>
                                        <i class="popup-menu-arrow">›</i>
                                    </div>
                                    <!-- Nested children -->
                                    <ul v-if="isPopupItemExpanded(childIndex)" class="popup-menu-nested">
                                        <li v-for="(grandChildItem, grandChildIndex) in childItem.children" :key="grandChildIndex">
                                            <router-link :to="grandChildItem.link" class="popup-menu-item popup-menu-nested-item" @click="closePopup">
                                                <font-awesome-icon :icon="grandChildItem.icon" class="popup-menu-icon" />
                                                <span>{{ grandChildItem.name }}</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </template>
                                <!-- Direct child without nested children -->
                                <template v-else>
                                    <router-link :to="childItem.link" class="popup-menu-item" @click="closePopup">
                                        <font-awesome-icon :icon="childItem.icon" class="popup-menu-icon" />
                                        <span>{{ childItem.name }}</span>
                                    </router-link>
                                </template>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse" :id="'ui-basic-' + index" :class="{ show: isExpanded(index) }">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item" v-for="(childItem, childIndex) in menuItem.children" :key="childIndex"
                                :class="{ active: $route.path === childItem.link }">
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
                                                :key="grandChildIndex"
                                                :class="{ active: $route.path === grandChildItem.link }">
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
import { faCartShopping, faGauge, faList, faChartSimple, faClipboardList, faStore, faBook, faAward, faCalendar, faUsers, faAddressBook, faBoxArchive, faUserTie, faPlaneDeparture, faFileMedical, faComputer, faGroupArrowsRotate, faCoins, faMoneyCheck, faReceipt } from '@fortawesome/free-solid-svg-icons';
import { toast } from "vue3-toastify";
library.add(faGroupArrowsRotate, faCartShopping, faGauge, faList, faChartSimple, faClipboardList, faStore, faBook, faAward, faCalendar, faUsers, faAddressBook, faBoxArchive, faUserTie, faPlaneDeparture, faFileMedical, faComputer, faCoins, faMoneyCheck, faReceipt);

export default {
    name: 'Sidebar',
    data() {
        return {
            user_role: null,
            userId: null,
            expandedItems: [],
            allowedMenus: JSON.parse(localStorage.getItem('module_access')) || [], // Load module access from localStorage
            hoveredItemIndex: null, // Track which menu item is hovered/clicked in minimized mode
            popupPosition: { top: 0 }, // Track popup position
            expandedPopupItems: [], // Track which popup items are expanded (for nested children)
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
                    name: 'HR Section',
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
                    name: 'GSS Section',
                    tooltip: 'General Service Section',
                    icon: 'cart-shopping',
                    class: 'menu-icon-custom',
                    children: [
                        { link: '/procurement/PPMP', name: 'PPMP', icon: 'list' },
                        { link: '/procurement/index', name: 'Purchase Request', icon: 'store' },
                        { link: '/procurement/rfq/index', name: 'R.F.Q', icon: 'book' },
                        // { link: '/procurement/abstract/index', name: 'Abstract of Quotation', icon: 'award' },
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
                        {
                            link: '',
                            name: 'Budget Section',
                            icon: 'book',
                            children: [
                                { link: '/finance/budget/index', name: 'Fund Source', icon: 'book' },
                                { link: '/finance/budget/object_code', name: 'UACS', icon: 'book' },
                                { link: '/finance/budget/obligation', name: 'Obligation', icon: 'book' },
                                { link: '/finance/budget/pr_monitoring', name: 'Procurement Budget Monitoring', icon: 'book' },
                            ]
                        },
                        {
                            link: '',
                            name: 'Accounting Section',
                            icon: 'receipt',
                            children: [
                                { link: '/finance/accounting/nta', name: 'NTA / NCA', icon: 'money-check' },
                                { link: '/finance/accounting/disbursement', name: 'Disbursement', icon: 'file' },
                                // Add more as needed
                            ],
                        },
                        { link: '', name: 'Cash Section', icon: 'book' },
                        { link: '/procurement/abstract/index', name: 'Cash Section', icon: 'book' },
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
    mounted() {
        // Close popup when clicking outside
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeUnmount() {
        // Remove event listener
        document.removeEventListener('click', this.handleClickOutside);
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
            // Check if sidebar is minimized
            const isMinimized = document.body.classList.contains('sidebar-icon-only');
            
            // If sidebar is minimized and item has children, show popup instead
            if (isMinimized) {
                const menuItem = this.filteredMenuItems.find((item, index) => index === key || String(index) === String(key));
                if (menuItem && this.hasChildren(menuItem)) {
                    // Toggle popup visibility
                    this.hoveredItemIndex = this.hoveredItemIndex === key ? null : key;
                    return;
                }
            }
            // Normal collapse behavior when sidebar is expanded
            if (this.isExpanded(key)) {
                this.expandedItems = this.expandedItems.filter(item => item !== key);
            } else {
                this.expandedItems.push(key);
            }
        },
        handleMenuItemClick(index, menuItem, event) {
            // Check if sidebar is minimized
            const isMinimized = document.body.classList.contains('sidebar-icon-only');
            
            // If sidebar is minimized and has children, show popup
            if (isMinimized && this.hasChildren(menuItem)) {
                event.preventDefault();
                // Calculate popup position based on clicked menu item
                const navItem = event.currentTarget.closest('.nav-item');
                if (navItem) {
                    const rect = navItem.getBoundingClientRect();
                    this.popupPosition.top = rect.top - 60; // Adjust for navbar height
                }
                this.toggleCollapse(index);
            } else {
                // Normal behavior when sidebar is expanded
                this.toggleCollapse(index);
            }
        },
        closePopup() {
            this.hoveredItemIndex = null;
            this.expandedPopupItems = []; // Reset expanded items when closing popup
        },
        handleClickOutside(event) {
            // Close popup if clicking outside the sidebar and popup
            if (this.hoveredItemIndex !== null) {
                const sidebar = document.getElementById('sidebar');
                const popup = event.target.closest('.sidebar-popup-menu');
                const navLink = event.target.closest('.nav-link');
                
                if (!sidebar?.contains(event.target) && !popup && !navLink) {
                    this.closePopup();
                }
            }
        },
        isSidebarIconOnly() {
            // Check if sidebar is in icon-only mode
            return document.body.classList.contains('sidebar-icon-only');
        },
        togglePopupItem(childIndex) {
            // Toggle expansion of nested popup items
            const index = this.expandedPopupItems.indexOf(childIndex);
            if (index > -1) {
                this.expandedPopupItems.splice(index, 1);
            } else {
                this.expandedPopupItems.push(childIndex);
            }
        },
        isPopupItemExpanded(childIndex) {
            // Check if popup item is expanded
            return this.expandedPopupItems.includes(childIndex);
        },
    },
    components: {
        FontAwesomeIcon,
    },
};
</script>
