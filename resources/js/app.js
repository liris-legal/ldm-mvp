require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'

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
Vue.component('app-top-bar', require('./components/app-bar/top.vue').default);
Vue.component('app-bottom-bar', require('./components/app-bar/bottom-fixed.vue').default);
Vue.component('app-home', require('./components/home.vue').default);
Vue.component('type-lawsuits', require('./components/type-lawsuits/index.vue').default);
Vue.component('lawsuits-component', require('./components/lawsuits/index.vue').default);

// component global
Vue.component('app-thead', require('./components/globals/app-thead.vue').default);
Vue.component('app-document-2', require('./components/globals/app-document-2.vue').default);
Vue.component('app-case-8', require('./components/globals/app-case-8.vue').default);
Vue.component('app-type-lawsuit', require('./components/globals/app-type-lawsuit.vue').default);

const app = new Vue({
    el: '#app',
});
