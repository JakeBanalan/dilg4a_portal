<style>
.menu-icon-custom {
    font-size: 1rem;
    line-height: 1;
    margin-right: 1rem;
}
.nav-item{
    font-family: 'Poppins';
}
.active {
    background-color: #f8f9fa; /* Apply your active background color here */
    /* Add any other styles for active state */
}
</style>
<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item" v-for="(menuItem, index) in menuItems" :key="index">
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
                        <font-awesome-icon :icon="menuItem.icon" :class="menuItem.class"/>
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
import { faCartShopping,faGauge,faList,faChartSimple, faClipboardList, faStore,faBook,faAward,faCalendar,faUsers, faAddressBook, faBoxArchive, faUserTie, faPlaneDeparture, faFileMedical } from '@fortawesome/free-solid-svg-icons';

library.add(faCartShopping,faGauge,faList,faChartSimple,faClipboardList,faStore,faBook,faAward,faCalendar,faUsers,faAddressBook,faBoxArchive,faUserTie,faPlaneDeparture,faFileMedical);

export default {
    name: 'Sidebar',
    props: {
        menuItems: {
            type: Array,
            default: () => [
                {
                    link: '/dashboard',
                    name: 'Dashboard',
                    tooltip: 'Dashboard',
                    icon: 'gauge',
                    class: 'menu-icon-custom'
                },
                
               {
                    link: '/calendar/index',
                    name: 'Calendar',
                    tooltip: 'calendar',
                    icon: 'calendar',
                    class: 'menu-icon-custom'
                },
                
                {
                    link: '',
                    name: 'Procurement',
                    tooltip: 'General Service Section',
                    icon: 'cart-shopping',
                    class: 'menu-icon-custom',

                    children: [
                        {
                            link: '/procurement/AnnualProcurementPlan',
                            name: 'APP',
                            tooltip: 'Buttons',
                            icon: 'list',
                        },
                        {
                            link: '/procurement/index',
                            name: 'Procurement',
                            tooltip: 'Buttons',
                            icon: 'store',
                        },
                        {
                            link: '/procurement/rfq/index',
                            name: 'R.F.Q',
                            tooltip: 'Buttons',
                            icon: 'book',
                        },
                        {
                            link: '/procurement/abstract/index',
                            name: 'Awarding',
                            tooltip: 'Buttons',
                            icon: 'award',
                        },
                        {
                            link: '/procurement/statistic',
                            name: 'Statistics',
                            tooltip: 'Buttons',
                            icon: 'chart-simple',
                        },
                        {
                            link: '/procurement/index',
                            name: 'Reports',
                            tooltip: 'Buttons',
                            icon: 'clipboard-list',
                        },
                    ],
                    
                },
                {
                    link: '',
                    name: 'HR Section',
                    tooltip: 'General Service Section',
                    icon: 'users',
                    class: 'menu-icon-custom',
                    children: [
                        {
                            link: '/human_resource/employees_directory/index',
                            name: 'Employees Directory',
                            tooltip: 'Buttons',
                            icon: 'address-book',
                        },
                        {
                            link: '',
                            name: 'Daily Time Record',
                            tooltip: 'Buttons',
                            icon: 'clipboard-list',
                        },
                        {
                            link: '',
                            name: 'RO and ROO',
                            tooltip: 'Buttons',
                            icon: 'box-archive',
                        },
                        {
                            link: '',
                            name: 'Official Businees',
                            tooltip: 'Buttons',
                            icon: 'user-tie',
                        },
                        {
                            link: '',
                            name: 'Travel Order',
                            tooltip: 'Buttons',
                            icon: 'plane-departure',
                        },
                        {
                            link: '',
                            name: 'Health Monitoring',
                            tooltip: 'Buttons',
                            icon: 'file-medical',
                        },
                    ],
                    
                },
                {
                    link: '',
                    name: 'RICTU',
                    tooltip: 'RICTU',
                    icon: 'computer',
                    class: 'menu-icon-custom',

                    children: [
                        {
                            link: '/rictu/ict_ta/index',
                            name: 'ICT TA',
                            tooltip: 'Buttons',
                            icon: 'list',
                        },
                        // {
                        //     link: '/ict/reports/view',
                        //     name: 'Reports',
                        //     tooltip: 'Buttons',
                        //     icon: 'list',
                        // },
                ]
                }
                
            ],
        },
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
    data() {
        return {
            expandedItems: [],
        };
    },
    components: {
        FontAwesomeIcon,
    },
};
</script>
