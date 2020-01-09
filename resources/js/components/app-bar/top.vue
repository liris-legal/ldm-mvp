<template>
  <v-app-bar
    color="deep-purple accent-4"
    dense
    dark
    class="top-bar"
  >
    <v-btn
      v-if="!checkRoute('/')"
      icon
      @click="goBack()"
    >
      <v-icon>arrow_back_ios</v-icon>
    </v-btn>
    <range-alerts
      v-if="notification"
      :notification="notification"
    />
    <v-spacer />
    <v-btn
      v-click-outside="hidden"
      icon
      @click="displayMenu = !displayMenu"
    >
      <v-icon>apps</v-icon>
    </v-btn>
    <v-list
      v-show="displayMenu"
      class="list-menu-top-bar"
    >
      <v-list-item>
        <v-list-item-title>{{ user.email }}</v-list-item-title>
      </v-list-item>
      <v-list-item>
        <v-list-item-title @click="logout">
          ログアウト
        </v-list-item-title>
      </v-list-item>
    </v-list>
  </v-app-bar>
</template>

<script>
	/**
	 * top-bar component include infomation person of user and logout.
	 * @property {Boolean} displayMenu - Is to show/hidden Menu App-nav-top
	 */
  import rangeAlerts from '../globals/range-alerts'
  import {mapState} from "vuex";

  export default {
    components: {
      rangeAlerts
    },
	  props: {
      user: { type: Object, required: true, default: () => {} },
      routeLogout: { type: String, required: true, default: () => '' }
		},
	  data() {
	    return {
        displayMenu: false
			}
    },
    computed: {
      ...mapState(['notification']),
    },
		methods: {
	    /**
			 * @function logout
			 * @description user logout.
			 */
	    logout() {
				axios({method: 'post', url: this.routeLogout})
				.then( res => {
          console.log(res);
          // this.$store.dispatch('create_notification', res.data.message);
          location.reload();
				})
				.catch( err => {
          console.log(err.response.data);
          // location.reload();
				});
			},
      /**
			 * @function hidden
       * @description To hidden a block
       */
			hidden() {
	      this.displayMenu = false;
			},

      /**
       * @function checkRoute
       * @description Check route and active class when click on url
       * @return boolean
       */
      checkRoute($url) {
        return window.location.pathname === $url;
      }
		}
  }
</script>
