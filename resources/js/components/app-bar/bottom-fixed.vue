<template>
	<v-bottom-navigation fixed light class="bottom-bar">
		<v-row>
			<v-col cols="4" class="text-center">
				<v-btn value="recent" href="/" :class="{'v-btn--active': checkRoute('/')}">
					<span>ホーム</span>
					<v-icon>home</v-icon>
				</v-btn>
			</v-col>
			<v-col cols="4" class="text-center">
				<v-btn value="favorites">
					<span>ファイル</span>
					<v-icon>folder_open</v-icon>
				</v-btn>
			</v-col>
			<v-col cols="4" class="text-center add-button-bottom-app">
					<v-btn id="btn-add-app" value="nearby" v-on:click="showAdd = !showAdd" v-click-outside="hidden">
					<span>作成</span>
					<v-icon>add</v-icon>
				</v-btn>
				<v-list class="list-item-add-button" v-if="showAdd">
					<a href="/" class="block-link">
						<v-list-item>
							<v-list-item-title>新件を作成</v-list-item-title>
						</v-list-item>
					</a>
					<a href="/" class="block-link">
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
    name: "bottom-fixed",
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
       * @function checkRoute
       * @description Check route and active class when click on url
			 * @return boolean
       */
			checkRoute($url) {
				return window.location.pathname === $url;
			}
		},
    directives: {
      /**
       * ClickOutside: Clicks Outside an Element
       */
      ClickOutside
    }
  }
</script>