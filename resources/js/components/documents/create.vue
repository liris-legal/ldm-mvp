<template>
  <h1>
    create document
  </h1>
</template>

<script>
  export default {
    name: "document-create",
    props: {
      storeRoute: { required: true, type: String, default: ''},
      lawsuitId: {required: true,  type: String, default: ''},
    },
  }
</script>

<style scoped>

</style>
