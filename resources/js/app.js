window.$ = window.jQuery = require('jquery');
window.Vue = require('vue');
//
import '@fortawesome/fontawesome-free/css/all.css'
import Vue from 'vue';
//
import './src/services/axios'

import './bootstrap'
//
import Vuex from 'vuex'
Vue.use(Vuex)

// IMPORT COMPONENTS
import './src/components';

import router from './src/services/router';


import VueSweetalert2 from "vue-sweetalert2";
Vue.use(VueSweetalert2);
  
  
const app = new Vue({
  router
}).$mount('#app');