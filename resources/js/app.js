require('./bootstrap');
window.Vue = require('vue');

import store from '../store/index'
import jQuery from 'jquery';
import BootstrapVue from 'bootstrap-vue'
import moment from 'moment'
import vuemoment from 'vue-moment'

Vue.use(BootstrapVue)
Vue.use(moment)
Vue.use(vuemoment )

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.$ = window.jQuery = jQuery;

Vue.component('infoblock', require('./components/Infoblock').default);
Vue.component('paragraph', require('./components/Section').default);


Vue.filter("formatDate", function (value) {
    console.log('filter')
    if (value) {
        return moment(String(value)).format('MM/DD/YY')
    }
})

const app = new Vue({
    store,
    el: '#app'
});
