require('./bootstrap');
window.Vue = require('vue');

import store from '../store/index'
import jQuery from 'jquery';
import BootstrapVue from 'bootstrap-vue'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'font-awesome/css/font-awesome.min.css'
// register globally
Vue.component('multiselect', Multiselect)

window.$ = window.jQuery = jQuery;

Vue.use(BootstrapVue);


Vue.component('infoblock', require('./components/Infoblock').default);
Vue.component('paragraph', require('./components/Section').default);
Vue.component('slider', require('./components/Slider').default);
Vue.component('faculties', require('./components/faculties').default);
Vue.component('sectioninfo', require('./components/sectionInfo').default);
Vue.component('egeSelect', require('./components/egeSelect').default);
Vue.component('subject', require('./components/Subject').default);
Vue.component('speciality', require('./components/speciality').default);
Vue.component('minScore', require('./components/minScore').default);
Vue.component('price', require('./components/price').default);
Vue.component('times', require('./components/times').default);
Vue.component('parse', require('./components/parse').default);
Vue.component('parseNotAdmin', require('./components/parseNotAdmin').default);
Vue.component('archive', require('./components/Archive').default);
Vue.component('cleansing', require('./components/cleansing').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
    data: {
        rootUrl: window.location.hostname
    }
});
