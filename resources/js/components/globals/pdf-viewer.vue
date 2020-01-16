<template>
  <iframe
    name="iframe"
    :src="'/iframe?url='+ encodeURIComponent(document.url)"
    width="100%"
    height="100%"
    frameborder="0"
    style="height: 67vh;"
  />
</template>

<script>
  export default {
    name: "pdf-viewer",
    props: {
      document: {required: true, type: Object, default: () => {}},
    },
  }
</script>
