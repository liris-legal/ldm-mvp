<template>
	<div class="v-application app-login container">
		<v-form>
			<v-container>
				<v-row>
					<v-col cols="12" class="app-logo">
						<v-img class="mr-0-auto" src="images/logo.svg" alt="Liris" max-width="120" max-height="153"></v-img>
					</v-col>
				</v-row>
				<v-row class="container-app-login">
					<v-col cols="12" class="pa-0">
						<v-text-field placeholder="メールアドレス" outlined ripple></v-text-field>
					</v-col>
					<v-col cols="12" class="pa-0">
						<v-text-field placeholder="パスワード" outlined ripple></v-text-field>
					</v-col>
					<v-col cols="12">
						<v-btn color="#1452CC" large block>ログイン</v-btn>
					</v-col>
				</v-row>
			</v-container>
		</v-form>
	</div>
</template>

<script>
  export default {
    name: "login"
  }
</script>

<style scoped>

</style>