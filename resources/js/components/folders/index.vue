<template>
  <div class="container-fluid folders-page">
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
    <app-folder
      v-for="folder in folders"
      :key="folder.id"
      :folder="folder"
    />
  </div>
</template>

<script>
  export default {
    name: "Index",
		props: {
      folders: {type: Array, required: true, default: () => []}
		}
  }
</script>

<style scoped>

</style>
