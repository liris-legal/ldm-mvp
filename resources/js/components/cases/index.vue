<template>
	<div class="container-fluid cases-page">
		<v-row>
			<v-col class="col-12 header-content">
				<h2 class="title-name text-size-30">民事事件</h2>
				<h3 class="description"/>
			</v-col>
		</v-row>
		<app-thead :thead="thead" />
		<app-case-8 v-for="item in cases" :key="item.id" :itemCase="item" />
	</div>
</template>

<script>
  export default {
    name: "index",
    data() {
      return {
        thead: [
          { id: 1, name: '事件番号', class: 'col-2'},
          { id: 2, name: '事件名', class: 'col-2'},
          { id: 3, name: '裁判所・部署', class: 'col-2'},
          { id: 4, name: '原告', class: 'col-2'},
          { id: 5, name: '原告代理人', class: 'col-1'},
          { id: 6, name: '被告代理人', class: 'col-1'},
          { id: 7, name: 'その他当事者', class: 'col-1'},
          { id: 8, name: '', class: 'col-1'}
        ],
        columnOfClass: { class1: 'col-7', 'class2': 'col-5'},
      }
    },
		props: {
      cases: { type: Array, required: false, default: [] }
		}
  }
</script>

<style scoped>

</style>