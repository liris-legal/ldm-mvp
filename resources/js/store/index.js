import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const stores = new Vuex.Store({
  state: {
    notification: null
  },
  mutations: {
    SET_NOTIFICATION(state, message) {
      if (message && message.hasOwnProperty('status') && message.hasOwnProperty('content'))
        state.notification = {type: message.status, message: message.content};
      else
        state.notification = null
    },
  },
  actions: {
    create_notification({ commit }, message) {
      // console.log('set_notification');
      console.log(message);
      return commit('SET_NOTIFICATION', message)
    },
    delete_notification({ commit } ) {
      // console.log('delete_notification');
      return commit('SET_NOTIFICATION', null)
    },
  }
});

export default stores;
