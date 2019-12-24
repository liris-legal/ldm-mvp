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
    >
      <v-icon>arrow_back_ios</v-icon>
    </v-btn>
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
  import ClickOutside from 'vue-click-outside'
	export default {
    directives: {
	    /**
			 * ClickOutside: Clicks Outside an Element
			 */
      ClickOutside
    },
	  props: {
      user: { type: Object, required: true, default: () => {} }
		},
	  data() {
	    return {
        displayMenu: false
			}
		},
		methods: {
	    /**
			 * @function logout
			 * @async
			 * @description user logout.
			 */
	    async logout() {
				await axios({
					method: 'post',
					url: 'logout'
				})
				.then( res => {location.reload() })
				.catch( err => {
				  if(err.response.status === 401){
            console.log(err.response.data.message);
					}
          location.reload();
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
