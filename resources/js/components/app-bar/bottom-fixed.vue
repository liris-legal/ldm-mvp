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
          :class="{'v-btn--active': $route.name === checkRoutes(['index'])}"
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
          :href="routeListTypeLawsuits"
          :class="{'v-btn--active': $route.name === checkRoutes(['typeLawsuitsIndex', 'lawsuitsIndex', 'lawsuitsShow'])}"
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
          :class="{'v-btn--active': $route.name === checkRoutes(['lawsuitsCreate', 'documentsCreate'])}"
          @click="showAdd = !showAdd"
        >
          <span>作成</span>
          <v-icon>add</v-icon>
        </v-btn>
        <v-list
          v-if="showAdd"
          class="list-item-add-button"
        >
          <v-list-item :href="routeCreateLawsuit">
            <v-list-item-title>新件を作成</v-list-item-title>
          </v-list-item>
          <v-list-item :href="isLawsuitShow()">
            <v-list-item-title>ファイルをアップロード</v-list-item-title>
          </v-list-item>
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
    props: {
      routeCreateLawsuit: { type: String, required: true, default: () => '' },
      routeListTypeLawsuits: { type: String, required: true, default: () => '' },
      routeCreateDocument: { type: String, required: true, default: () => '' },
    },
    data() {
      return {
        showAdd: false
			}
		},
		methods: {
      /**
			 * @function hidden
			 * @description to hidden 作成 panel
			 */
      hidden() {
				if(this.showAdd === true){
          this.showAdd = false;
          document.getElementById("btn-add-app").classList.remove('v-btn--active');
				}
      },

      /**
       * @function checkRoutes
       * @description Check route and active class when click on url
       *
       * @param {Array} $array - Is a array has many paths
       * @return string
       */
      checkRoutes($array) {
        return $array.find( value => this.$route.name === value );
      },

      /**
       * @function isLawsuitShow
       * @description Check route is lawsuitsShow to enable ファイルをアップロード button
       */
      isLawsuitShow(){
        const routeCreateDocument = this.routeCreateDocument.replace('0', this.$route.params.lawsuitId);
        return this.$route.name === 'lawsuitsShow' ? routeCreateDocument : '#';
      }
		}
  }
</script>
