require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import notificationStore from './store/notification';

/**
 * Vuetify
 */
import Vuetify from 'vuetify'
Vue.use(Vuetify);

/**
 * Component registration
 * @see: https://vuejs.org/v2/guide/components-registration.html
 */
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('app-top-bar', require('./components/app-bar/top.vue').default);
Vue.component('app-bottom-bar', require('./components/app-bar/bottom-fixed.vue').default);
Vue.component('app-home', require('./components/home.vue').default);
Vue.component('type-lawsuits', require('./components/type-lawsuits/index.vue').default);
Vue.component('lawsuits-component', require('./components/lawsuits/index.vue').default);
Vue.component('lawsuits-create', require('./components/lawsuits/create.vue').default);
Vue.component('lawsuits-edit', require('./components/lawsuits/edit.vue').default);
Vue.component('lawsuits-show', require('./components/lawsuits/show.vue').default);

// component global
Vue.component('app-thead', require('./components/globals/app-thead.vue').default);
Vue.component('app-document-two-columns', require('./components/globals/app-document-two-columns.vue').default);
Vue.component('app-type-lawsuit', require('./components/globals/app-type-lawsuit.vue').default);
Vue.component('app-delete-item', require('./components/globals/delete-an-item.vue').default);
Vue.component('lawsuit-header', require('./components/globals/lawsuit-header.vue').default);

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
      const partiesNullable = ['defendant_representatives', 'plaintiff_representatives', 'other_parties'];
      for (let i = 0; i < this.lawsuit[key].length; i++) {
        if ( partiesNullable.includes(key) && this.lawsuit[key][i].name.length === 0 )
          console.log('ignored');
        else
          formData.append(key+'[]', this.lawsuit[key][i].name);
      }
      return formData
    },

    /**
     * Handle error to show message
     *
     * @param errors - an instance errors
     * @param field_name - party name
     * @param index - index of item in parties
     * @return {string} an error message
     * */
    catchError(errors, field_name, index = NaN) {
      let errorMessage, key;
      key = !isNaN(index) ? field_name + "." + index : field_name;

      if (errors.hasOwnProperty(key)){
        errorMessage = errors[key];
        key = key === 'courts_departments' ? 'courts departments' : key;
        return errorMessage[0].replace(key, this.translateColumnName(field_name, 'en_ja'));
      }
    },

    /**
     * To translate party name
     * mode en_ja: translate from english (英語) to japanese (日本語)
     * mode ja_en: translate from japanese to english
     *
     * @param party - party name
     * @param mode - mode to translate
     * @return {string} a translated party name
     * */
    translateColumnName(party, mode) {
      const parties = {number: '事件番号', name: '事件名', courts_departments: '裁判所・部署', plaintiffs: '原告',
        plaintiff_representatives: '原告代理人', defendants: '被告', defendant_representatives: '被告代理人', other_parties: 'その他当事者'};

      if (mode === 'en_ja'){
        return parties[party]
      }
    }
  }
});

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify({
    icons: {
      iconfont: 'mdiSvg',
    },
  }),
  // provide the store using the "store" option.
  // this will inject the store instance to all child components.
  store: notificationStore,
  mounted(){
    console.log('app mounted')
  }
});
