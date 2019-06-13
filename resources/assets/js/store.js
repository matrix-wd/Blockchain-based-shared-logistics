/**
 * Adds the promise polyfill for IE 11
 */
require('es6-promise').polyfill();

/**
 * Import Vue and Vuex
 */
import Vue from 'vue';
import Vuex from 'vuex';

/**
 * Initializes Vuex on Vue.
 */
Vue.use(Vuex);
import { user } from './modules/user.js';
import { admin } from './modules/admin.js';
import { home } from './modules/home.js';
import { warehouse } from './modules/warehouse.js';
import { conveyance } from './modules/conveyance.js';
import { attention } from './modules/attention.js';
import { resource } from './modules/resource.js';
import { order } from './modules/order.js';


/**
 * Export our data store.
 */
export default new Vuex.Store({
    modules: {
        user,
        admin,
        home,
        warehouse,
        conveyance,
        attention,
        resource,
        order
    }
});