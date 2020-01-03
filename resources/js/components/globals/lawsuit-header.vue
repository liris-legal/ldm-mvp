<template v-if="info">
  <v-row class="lawsuit-header pa-3 pt-0 pb-0">
    <v-col class="col-lg-5 col-md-5 col-sm-6 col-xl-6">
      <p class="text-size-12 mb-0">平成31年（ワ）第{{ info.number }}号</p>
      <p class="text-size-22 pl-4 mb-0">{{ info.name }}</p>
    </v-col>
    <v-col class="col-lg-7 col-md-7 col-sm-6 col-xl-6 text-size-18">
      <p class="mb-0">原告：{{ convertString(info.plaintiffs) }}</p>
      <p class="mb-0">被告：{{ convertString(info.defendants) }}</p>
    </v-col>
  </v-row>
</template>
<script>
export default {
  props: {
    info: {type: Object, required: true}
  },
  methods: {
    /**
     * @function convertString
     * @description convert array to string
     * @return string
     */
    convertString(array){
      if(array !== undefined && array.length > 0){
        let values = array.map(value => { return value.name });
        return values.join(', ');
      } else {
        return ''
      }
    },
  }
}
</script>
