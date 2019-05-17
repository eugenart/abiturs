require('./bootstrap');
window.Vue = require('vue');

import store from '../store/index'

import jQuery from 'jquery';

window.$ = window.jQuery = jQuery;

Vue.component('infoblock', require('./components/Infoblock').default);
Vue.component('paragraph', require('./components/Section').default);

const app = new Vue({
    store,
    el: '#app'
});
