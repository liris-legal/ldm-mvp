<template>
	<div class="app-folder">
		<a href="/cases" class="folder-link">
			<v-row v-ripple>
				<v-col class="col-12 row">
					<div class="name font-weight-600">{{ folder.name }}</div>
					<v-spacer></v-spacer>
					<v-btn icon><v-icon>arrow_forward_ios</v-icon></v-btn>
				</v-col>
			</v-row>
		</a>
	</div>
</template>

<script>
  export default {
    props: {
      folder: { type: Object, required: false, default: { id: 1, name: '民事事件', url: '#' } }
    }
  }
</script>

<style scoped>

</style>