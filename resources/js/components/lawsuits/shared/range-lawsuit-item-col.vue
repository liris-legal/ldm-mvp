<template>
  <span>
    <template v-if="lawsuit[party].length">
      {{ lawsuit[party][0].name | truncate(15, '...')}}
      <v-badge
        :content="lawsuit[party].length"
        color="blue lighten-3"
        offset-x="0"
        offset-y="8"
      >
        他
      </v-badge>
    </template>
    <template v-else>
      -
    </template>
  </span>
</template>

<script>
  export default {
    name: "RangeLawsuitItemCol",
    props: {
      lawsuit: {required: true, type: Object, default: () => {}},
      party: {required: true, type: String, default: ''},
    },
  }
</script>

