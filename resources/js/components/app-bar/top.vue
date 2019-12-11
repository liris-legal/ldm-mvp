<template>
		<v-app-bar color="deep-purple accent-4"	dense	dark class="top-bar">
			<v-btn icon><v-icon>arrow_back_ios</v-icon></v-btn>
			<v-spacer></v-spacer>
			<v-btn icon v-on:click="displayMenu = !displayMenu">
				<v-icon>apps</v-icon>
			</v-btn>
			<v-list class="list-menu-top-bar" v-show="displayMenu">
				<v-list-item>
					<v-list-item-title>abcde@gmail.com</v-list-item-title>
				</v-list-item>
				<v-list-item>
					<v-list-item-title>ログアウト</v-list-item-title>
				</v-list-item>
			</v-list>
		</v-app-bar>
</template>

<script>
	export default {
	  data() {
	    return {
        displayMenu: false
			}
		},
		mounted() {
      console.log(this.displayMenu)
    }
  }
</script>