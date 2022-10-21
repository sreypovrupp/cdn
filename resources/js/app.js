require('./bootstrap');
require('vue-multiselect/dist/vue-multiselect.min.css');
import {HasError, AlertError} from 'vform/src/components/bootstrap5';
import Form from 'vform';


window.Vue = require('vue');
window.Form = Form;
window.Fire = new Vue();

import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueSweetalert2);

import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect)

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('customer', require('./components/Customer.vue').default);
//Vue.component('pagination', require('laravel-vue-pagination'));

//Food
Vue.component('food_category', require('./components/food/Category.vue').default);
Vue.component('food_product', require('./components/food/Product.vue').default);

const app = new Vue({
    el: '#app',
});
