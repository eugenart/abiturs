require('./bootstrap');
window.Vue = require('vue');

import store from '../store/index'
import jQuery from 'jquery';
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.$ = window.jQuery = jQuery;

Vue.component('infoblock', require('./components/Infoblock').default);
Vue.component('paragraph', require('./components/Section').default);
Vue.component('slider', require('./components/Slider').default);

Vue.filter("formatDate", function (value) {
    if (value) {
        let dateSplit = value.split('-')
        return dateSplit[2] + '.' + dateSplit[1] + '.' + dateSplit[0]
    }
})

const app = new Vue({
    store,
    el: '#app'
});
