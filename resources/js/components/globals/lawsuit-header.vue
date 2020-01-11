<template>
  <v-row class="lawsuit-header pa-3 pt-0 pb-0">
    <v-col class="col-lg-5 col-md-5 col-sm-6 col-xl-6">
      <p class="font-size-12 mb-0">
        {{ lawsuit.created_at_wareki }}第{{ lawsuit.number }}号
      </p>
      <p class="font-size-22 pl-4 mb-0">
        {{ lawsuit.name }}
      </p>
    </v-col>
    <v-col class="col-lg-7 col-md-7 col-sm-6 col-xl-6 font-size-18">
      <p class="mb-0">
        原告：{{ lawsuit.plaintiffs | parseName }}
      </p>
      <p class="mb-0">
        被告：{{ lawsuit.defendants | parseName }}
      </p>
    </v-col>
  </v-row>
</template>
<script>
export default {
  props: {
    lawsuit: {type: Object, required: true, default: () => {}}
  }
}
</script>
