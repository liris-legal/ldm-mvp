<template>
  <div class="app-thead">
    <!-- <v-row class="ma-0" > -->
    <v-row>
      <v-col
        v-for="th in thead"
        :key="th.id"
        :class="th.class"
      >
        <div class="name font-weight-600">
          {{ th.name }}
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
  export default {
    name: "AppThead",
		props: {
      thead: { type: Array, required: true, default: function () { return [ { id: 1, name: 'Name', class: 'col-12' } ]} }
		}
  }
</script>

<style scoped>

</style>
