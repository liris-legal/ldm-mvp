require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
/**
 * VueRouter
 */
import VueRouter from 'vue-router'
Vue.use(VueRouter);
/**
 * Vuetify
 */
import Vuetify from 'vuetify'
Vue.use(Vuetify)
export default new Vuetify({
    icons: {
        iconfont: 'mdiSvg',
    },
})
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('top-bar', require('./components/app-bar/top.vue').default);
Vue.component('bottom-bar', require('./components/app-bar/bottom.vue').default);
Vue.component('app-home', require('./components/home.vue').default);

const app = new Vue({
    el: '#app',
});
