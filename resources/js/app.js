require('./bootstrap');
window.Vue = require('vue');

import store from './store'

import jQuery from 'jquery';

window.$ = window.jQuery = jQuery;

Vue.component('sidebar', require('./components/SideBarComponent.vue').default);
Vue.component('infoblock', require('./components/Infoblock').default);

const app = new Vue({
    store,
    el: '#app'
});
