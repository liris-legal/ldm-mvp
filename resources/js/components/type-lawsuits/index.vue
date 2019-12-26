<template>
  <div class="container-fluid type-lawsuits">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-30">
          ファイル
        </h2>
        <h3 class="description">
          事件種類
        </h3>
      </v-col>
    </v-row>
    <app-type-lawsuit
      v-for="type_lawsuit in type_lawsuits"
      :key="type_lawsuit.id"
      :type_lawsuit="type_lawsuit"
    />
  </div>
</template>

<script>
  export default {
		props: {
      type_lawsuits: {type: Array, required: true, default: []}
		}
  }
</script>

<style scoped>

</style>
