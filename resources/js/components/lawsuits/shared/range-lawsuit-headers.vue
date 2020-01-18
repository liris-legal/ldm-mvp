<template>
  <th
    scope="col"
    class="col col-3"
  >
    {{ title }}{{ index === 1? '': index }}{{ index === 1 && length > 1 ? index : '' }}
    <v-spacer v-if="isLast" />
  </th>
</template>

<script>
  export default {
    name: "RangeLawsuitHeaders",
    props: {
      title: {required: true, type: String, default: ''},
      index: {required: true, type: Number, default: 0},
      length: {required: true, type: Number, default: 0},
      isLast: {required: false, type: Boolean, default: false},
    },
  }
</script>

