<template>
  <v-app-bar
    id="top-bar"
    color="#0B104D"
    fixed
    elevate-on-scroll
    height="46"
    dark
    class="top-bar"
  >
    <v-btn
      v-if="!checkRoute('/')"
      icon
      height="36"
      width="36"
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
      height="36"
      width="36"
      @click="displayMenu = !displayMenu"
    >
      <v-icon>format_align_justify</v-icon>
    </v-btn>
    <v-list
      v-show="displayMenu"
      :elevation="5"
      class="list-menu-top-bar"
      min-width="203"
    >
      <v-list-item dense>
        <v-list-item-title class="font-size-14">
          {{ user.email }}
        </v-list-item-title>
      </v-list-item>
      <v-list-item dense>
        <v-list-item-title
          class="font-size-14"
          @click="logout"
        >
          ログアウト
        </v-list-item-title>
      </v-list-item>
    </v-list>
  </v-app-bar>
</template>

<script>
	/**
	 * app-top-bar component include information person of user and logout.
	 * @property {Boolean} displayMenu - Is to show/hidden Menu App-nav-top
	 */
  import rangeAlerts from '../globals/range-alerts'
  import {mapState} from "vuex";

  export default {
    components: {
      rangeAlerts
    },
	  props: {
      authenticatedUser: { type: Object, required: true, default: () => {} },
      routeLogout: { type: String, required: true, default: () => '' }
		},
	  data() {
	    return {
        displayMenu: false
			}
    },
    computed: {
      ...mapState(['notification', 'user']),
    },
    watch: {
      /**
       * @function displayMenu
       * @description to display account Menu button
       */
      displayMenu(val) {
        if (val){
          bottomBar.style.zIndex = '4';
          setTimeout(function(){ overlay.classList.add('app--overlay', 'top-bar'); }, 250);
        } else {
          overlay.classList.remove('app--overlay', 'top-bar');
          bottomBar.style.removeProperty('z-index');
        }
      }
    },
    created() {
      this.$store.dispatch('set_user', this.authenticatedUser);
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
          this.$store.dispatch('set_user', {});
          location.reload();
				})
				.catch( err => {
          console.log(err.response.data);
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
<style lang="scss">
  .v-toolbar__content{
    padding-right: 6px;
  }
</style>
