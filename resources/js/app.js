require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import stores from "./store";

/**
 * Vuetify
 */
import Vuetify from 'vuetify'
Vue.use(Vuetify);

/**
 * VueRouter
 */
import VueRouter from 'vue-router'
Vue.use(VueRouter);
import router  from './router';

/**
 * Component registration
 * @see: https://vuejs.org/v2/guide/components-registration.html
 */
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('app-top', require('./components/apps/app-top.vue').default);
Vue.component('app-bottom', require('./components/apps/app-bottom.vue').default);
Vue.component('app-home', require('./components/home.vue').default);

// type-lawsuits
Vue.component('type-lawsuits', require('./components/type-lawsuits/index.vue').default);

// lawsuits
Vue.component('lawsuits-component', require('./components/lawsuits/index.vue').default);
Vue.component('lawsuits-create', require('./components/lawsuits/create.vue').default);
Vue.component('lawsuits-edit', require('./components/lawsuits/edit.vue').default);
Vue.component('lawsuits-show', require('./components/lawsuits/show.vue').default);

// document
Vue.component('document-index', require('./components/documents/index.vue').default);
Vue.component('document-create', require('./components/documents/create.vue').default);
Vue.component('document-edit', require('./components/documents/edit.vue').default);

// component globals
Vue.component('app-thead', require('./components/globals/app-thead.vue').default);
Vue.component('app-type-lawsuit', require('./components/globals/app-type-lawsuit.vue').default);
Vue.component('app-delete-item', require('./components/globals/delete-an-item.vue').default);
Vue.component('lawsuit-header', require('./components/globals/lawsuit-header.vue').default);
// component globals/tables
Vue.component('thead-columns', require('./components/globals/tables/thead-columns.vue').default);
Vue.component('range-row-item', require('./components/globals/tables/range-table-row.vue').default);

// Global Mixin defined
import {mixin} from "./mixin";
Vue.mixin(mixin);

const app = new Vue({
  el: '#app',
  router: router,
  vuetify: new Vuetify({
    icons: {
      // provide the v-select icon using the mdi icon
      iconfont: 'mdiSvg',
    },
  }),
  // provide the store using the "store" option.
  // this will inject the store instance to all child components.
  store: stores,
  mounted(){
    console.log('app mounted')
  },
});
