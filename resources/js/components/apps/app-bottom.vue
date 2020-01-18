<template>
  <v-bottom-navigation
    id="bottom-bar"
    fixed
    light
    height="56"
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
          :class="{'v-btn--active': checkRoutes(['index'])}"
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
          :class="{'v-btn--active': checkRoutes(['typeLawsuitsIndex', 'lawsuitsIndex', 'lawsuitsEdit',
          'lawsuitsShow', 'lawsuitsDocumentShow', 'documentsEdit', 'documentsIndex'])}"
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
          :class="{'v-btn--active': checkRoutes(['lawsuitsCreate', 'documentsCreate'])}"
          @click="showAdd = !showAdd"
        >
          <span>作成</span>
          <v-icon>add</v-icon>
        </v-btn>
        <v-list
          v-if="showAdd"
          :elevation="5"
          class="list-item-add-button"
          min-width="203"
        >
          <v-list-item
            :href="routeCreateLawsuit"
            dense
          >
            <v-list-item-title class="font-size-14">
              新件を作成
            </v-list-item-title>
          </v-list-item>
          <v-list-item
            :href="isLawsuitShow()"
            dense
          >
            <v-list-item-title class="font-size-14">
              ファイルをアップロード
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-col>
    </v-row>
  </v-bottom-navigation>
</template>

<script>
  /**
	 * bottom is component
	 * @property {Boolean} showAdd - Is to show/hidden a block.
	 */
  export default {
    name: "AppBottom",
    props: {
      routeCreateLawsuit: { type: String, required: true, default: () => '' },
      routeListTypeLawsuits: { type: String, required: true, default: () => '' },
      routeCreateDocument: { type: String, required: true, default: () => '' },
    },
    data() {
      return {
        showAdd: false,
			}
    },
    watch: {
      showAdd(val) {
        if (val){
          topBar.style.zIndex = '4';
          overlay.classList.add('app--overlay', 'bottom-bar');
        } else {
          overlay.classList.remove('app--overlay', 'bottom-bar');
          topBar.style.removeProperty('z-index');
        }
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
       * @param {Array} routes
       * @return boolean
       */
      checkRoutes(routes) {
        return !!routes.find(route => route === this.$route.name);
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
<style lang="scss">
  .v-item-group.v-bottom-navigation--fixed {
      z-index: 7;
  }
</style>
