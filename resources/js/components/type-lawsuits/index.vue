<template>
  <div class="container-fluid type-lawsuits">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name text-size-18">
          ファイル
        </h2>
        <h3 class="description">
          事件種類
        </h3>
      </v-col>
    </v-row>
    <app-type-lawsuit
      v-for="type_lawsuit in typeLawsuits"
      :key="type_lawsuit.id"
      :route-text="type_lawsuit.name"
      :route-link="routeLawsuitsIndex"
    />
  </div>
</template>

<script>
  export default {
    name: "ListTypeLawsuits",
		props: {
      typeLawsuits: {type: Array, required: true, default: () => []},
      routeLawsuitsIndex: {type: String, required: true, default: () => ''}
		},
  }
</script>

<style scoped>

</style>
