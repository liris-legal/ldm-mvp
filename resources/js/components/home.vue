<template>
  <div class="container-fluid home-content">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-30">
          ホーム
        </h2>
        <h3 class="description">
          最近表示
        </h3>
      </v-col>
    </v-row>
    <app-thead :thead="thead" />
    <app-document-2
      v-for="document in documents"
      :key="document.id"
      :document="document"
      :column-of-class="columnOfClass"
    />
  </div>
</template>

<script>
  export default {
    name: "Home",
		props: {
      documents: { type: Array, required: true, default: () => [] }
		},
		data() {
      return {
        thead: [
          { id: 1, name: '書面名', class: 'col-7'},
          { id: 2, name: '表示日', class: 'col-5'}
        ],
        columnOfClass: { class1: 'col-7', 'class2': 'col-5'},
			}
		}
  }
</script>

<style scoped>

</style>
