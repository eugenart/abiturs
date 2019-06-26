require('./bootstrap');
window.Vue = require('vue');

import store from '../store/index'
import jQuery from 'jquery';
import BootstrapVue from 'bootstrap-vue'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
// register globally
Vue.component('multiselect', Multiselect)

window.$ = window.jQuery = jQuery;

Vue.use(BootstrapVue);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'font-awesome/css/font-awesome.min.css'




Vue.component('infoblock', require('./components/Infoblock').default);
Vue.component('paragraph', require('./components/Section').default);
Vue.component('slider', require('./components/Slider').default);
Vue.component('faculties', require('./components/faculties').default);
Vue.component('sectioninfo', require('./components/sectionInfo').default);
Vue.component('egeSelect', require('./components/egeSelect').default);
Vue.component('subject', require('./components/Subject').default);


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
