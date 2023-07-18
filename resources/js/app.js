window.$ = window.jQuery = require('jquery');
window.Vue = require('vue');
//
import './bootstrap'

import Vue from 'vue';
//
import './src/services/axios'
//
import Vuex from 'vuex'

// IMPORT COMPONENTS
import './src/components';

import router from './src/services/router';


Vue.use(Vuex)
  
const app = new Vue({
  router
}).$mount('#app');


import '@fortawesome/fontawesome-free/css/all.css'
