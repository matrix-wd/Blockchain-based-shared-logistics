
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'home',
        component: Vue.component('Home', require('./pages/user/Home.vue'))
    },
    {
        path: '/city',
        name: 'city',
        component: Vue.component('City', require('./pages/user/City.vue'))
    },
    {
        path: '/protocol',
        name: 'protocol',
        component: Vue.component('Protocol', require('./pages/user/Protocol.vue'))
    },
    {
        path: '/warehouse',
        name: 'warehouse',
        component: Vue.component('Warehouse', require('./pages/user/Warehouse.vue')),
    },
    {
        path: '/resourceInfo',
        name: 'resourceInfo',
        component: Vue.component('ResourceInfo', require('./pages/user/ResourceInfo.vue'))
    },
    {
        path: '/conveyance',
        name: 'conveyance',
        component: Vue.component('Conveyance', require('./pages/user/Conveyance.vue')),
    },
    {
        path: '/historyOrder',
        name: 'historyOrder',
        component: Vue.component('HistoryOrder', require('./pages/user/HistoryOrder.vue'))
    },
    {
        path: '/calculatePrice',
        name: 'calculatePrice',
        component: Vue.component('calculatePrice', require('./pages/user/CalculatePrice.vue'))
    },
    {
        path: '/userInfo',
        name: 'userInfo',
        component: Vue.component('userInfo', require('./pages/user/UserInfo.vue'))
    },
    {
        path: '/createResourceHint',
        name: 'createResourceHint',
        component: Vue.component('createResourceHint', require('./pages/user/create-resource/CreateResourceHint.vue'))
    },
    {
        path: '/createWarehouse',
        name: 'createWarehouse',
        component: Vue.component('createWarehouse', require('./pages/user/create-resource/CreateWarehouse.vue')),
        meta: {
            keepAlive: true // 需要被缓存
        }
    },
    {
        path: '/createConveyance',
        name: 'createConveyance',
        component: Vue.component('createConveyance', require('./pages/user/create-resource/CreateConveyance.vue'))
    },
    {
        path: '/guide',
        name: 'guide',
        component: Vue.component('guide', require('./pages/user/Guide.vue'))
    },
    {
        path: '/tools',
        name: 'tools',
        component: Vue.component('tools', require('./pages/user/Tools.vue'))
    },
    {
        path: '/admin',
        name: 'admin',
        component: Vue.component('admin', require('./pages/admin/Index.vue'))
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Vue.component('dashboard', require('./pages/admin/Dashboard.vue'))
    },
];

export default new VueRouter({
    routes
});