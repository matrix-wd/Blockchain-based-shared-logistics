
require('./bootstrap');

import Vue from 'vue';
import router from './routes.js';
import store from './store.js';
import VCharts from 'v-charts';
Vue.use(VCharts);

import iView from 'iview';
import 'iview/dist/styles/iview.css';
import '../less/index.less';
import lang from 'iview/dist/locale/zh-CN';
Vue.use(iView, lang);
/**
 * 每次跳转后都回到顶部
 */
router.afterEach((to,from,next) => {
    window.scrollTo(0,0);
});


new Vue({
    el: '#app',
    router,
    store
});