require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'

/**
 * Vuetify
 */
import Vuetify from 'vuetify'

Vue.use(Vuetify);
export default new Vuetify({
  icons: {
    iconfont: 'mdiSvg',
  },
})

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('app-top-bar', require('./components/app-bar/top.vue').default);
Vue.component('app-bottom-bar', require('./components/app-bar/bottom-fixed.vue').default);
Vue.component('app-home', require('./components/home.vue').default);
Vue.component('type-lawsuits', require('./components/type-lawsuits/index.vue').default);
Vue.component('lawsuits-component', require('./components/lawsuits/index.vue').default);
Vue.component('lawsuits-create', require('./components/lawsuits/create.vue').default);
Vue.component('lawsuits-edit', require('./components/lawsuits/edit.vue').default);

// component global
Vue.component('app-thead', require('./components/globals/app-thead.vue').default);
Vue.component('app-document-2', require('./components/globals/app-document-2.vue').default);
Vue.component('app-case-8', require('./components/globals/app-case-8.vue').default);
Vue.component('app-type-lawsuit', require('./components/globals/app-type-lawsuit.vue').default);
Vue.component('app-delete-item', require('./components/globals/delete-an-item.vue').default);

// Global Mixin defined
Vue.mixin({
  methods: {
    /**
     * Add a new item to an array
     * @param lawsuit an instance lawsuit object
     * @param parties type of parties
     */
    pushToParties(lawsuit, parties) {
      let item = {name: ''};
      return lawsuit[parties].push(item);
    },

    /**
     * Remove an item in parties
     * @param lawsuit an instance lawsuit object
     * @param parties type of parties
     * @param index - Ordinal number element input of the typeSubmitter
     * */
    removeItemFromParties(lawsuit, parties, index) {
      return lawsuit[parties].splice(index, 1);
    },

    /**
     * Counter item of parties add index to title
     * @param parties type of parties
     * @param index Ordinal number element of parties
     * @return {number||string}
     * */
    countParties(parties, index) {
      if (index)
        return parties.length <= 1 ? '' : index;
      else
        return parties.length
    },

    /**
     * Convert Object To Array
     * @param formData - an instance formData
     * @param key - an string key object
     * @return {Array}
     * */
    convertObjectDataToArrayRequest(formData, key){
      for (let i = 0; i < this.lawsuit[key].length; i++) {
        if (this.lawsuit[key][i].name.length > 0)
          formData.append(key+'[]', this.lawsuit[key][i].name);
      }
      return formData
    },
  }
});

const app = new Vue({
  el: '#app',
});
