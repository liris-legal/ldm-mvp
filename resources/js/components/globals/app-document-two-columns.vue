<template>
  <div class="app-document-two-columns">
    <a
      href="#"
      class="document-link"
    >
      <v-row v-ripple>
        <v-col :class="columnOfClass.class1">
          <div class="name">{{ document.name }}</div>
        </v-col>
        <v-col :class="columnOfClass.class2">
          <div class="date">{{ document.created_at_wareki }}</div>
        </v-col>
      </v-row>
    </a>
  </div>
</template>

<script>
  export default {
    name: "RangeDocument",
    props: {
      document: { type: Object, required: true, default: () => {} },
      columnOfClass: { type: Object, required: true, default: () => {} }
		}
  }
</script>

<style scoped>

</style>
