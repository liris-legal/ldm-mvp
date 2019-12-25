<template>
  <v-bottom-navigation
    fixed
    light
    class="bottom-bar"
  >
    <v-row>
      <v-col
        cols="4"
        class="text-center"
      >
        <v-btn
          value="recent"
          href="/"
          :class="{'v-btn--active': checkRoutes(['/'])}"
        >
          <span>ホーム</span>
          <v-icon>home</v-icon>
        </v-btn>
      </v-col>
      <v-col
        cols="4"
        class="text-center"
      >
        <v-btn
          value="favorites"
          href="folders"
          :class="{'v-btn--active': checkRoutes(['/folders', '/cases'])}"
        >
          <span>ファイル</span>
          <v-icon>folder_open</v-icon>
        </v-btn>
      </v-col>
      <v-col
        cols="4"
        class="text-center add-button-bottom-app"
      >
        <v-btn
          id="btn-add-app"
          v-click-outside="hidden"
          value="nearby"
          @click="showAdd = !showAdd"
        >
          <span>作成</span>
          <v-icon>add</v-icon>
        </v-btn>
        <v-list
          v-if="showAdd"
          class="list-item-add-button"
        >
          <a
            href="/"
            class="block-link"
          >
            <v-list-item>
              <v-list-item-title>新件を作成</v-list-item-title>
            </v-list-item>
          </a>
          <a
            href="/"
            class="block-link"
          >
            <v-list-item>
              <v-list-item-title>ファイルをアップロード</v-list-item-title>
            </v-list-item>
          </a>
        </v-list>
      </v-col>
    </v-row>
  </v-bottom-navigation>
</template>

<script>
  import ClickOutside from 'vue-click-outside'
	/**
	 * bottom-fixed is component
	 * @property {Boolean} showAdd - Is to show/hidden a block.
	 */
  export default {
    name: "BottomFixed",
    directives: {
      /**
       * ClickOutside: Clicks Outside an Element
       */
      ClickOutside
    },
    data() {
      return {
        showAdd: false
			}
		},
		methods: {
      /**
			 * @function hidden
			 * @description To remove class v-btn-active
			 */
      hidden() {
				if(this.showAdd === true){
          this.showAdd = false;
          let getClass = document.getElementById("btn-add-app");
          getClass.classList.remove('v-btn--active');
				}
      },

      /**
       * @function checkRoutes
       * @description Check route and active class when click on url
       *
       * @param {Array} $array - Is a array has many paths
       * @return boolean
       */
      checkRoutes($array) {
        return $array.find( value => window.location.pathname === value );
      }
		}
  }
</script>