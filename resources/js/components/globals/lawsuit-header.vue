<template>
  <v-row class="lawsuit-header pa-3 pt-0 pb-0">
    <v-col class="col-lg-5 col-md-5 col-sm-6 col-xl-6">
      <p class="font-size-12 mb-0">
        {{ lawsuit.number }}
      </p>
      <v-skeleton-loader
        :loading="loading"
        height="33"
        width="500"
        type="heading"
      >
        <p class="font-size-22 pl-4 mb-0">
          <a
            :href="'/lawsuits/' + lawsuit.id"
          >
            {{ lawsuit.name }}
          </a>
        </p>
      </v-skeleton-loader>
    </v-col>
    <v-col class="col-lg-7 col-md-7 col-sm-6 col-xl-6 font-size-18">
      <p class="mb-0">
        <v-skeleton-loader
          :loading="loading"
          height="27"
          width="500"
          type="heading"
        >
          原告：{{ lawsuit.plaintiffs | parseParties }}
        </v-skeleton-loader>
      </p>
      <p class="mb-0">
        <v-skeleton-loader
          :loading="loading"
          height="27"
          width="500"
          type="heading"
        >
          被告：{{ lawsuit.defendants | parseParties }}
        </v-skeleton-loader>
      </p>
    </v-col>
  </v-row>
</template>
<script>
export default {
  filters:{
    parseParties(arrays){
      if (arrays === undefined || arrays.length <= 0) return '-';
      return arrays[0].name;
    }
  },
  props: {
    lawsuit: {type: Object, required: true, default: () => {}},
    loading: {type: Boolean, required: true, default: () => true}
  }
}
</script>

<style scoped>
  p > a{
    color: rgba(0,0,0,.87);
    text-decoration: none;
  }
  .v-skeleton-loader--is-loading{
    height: 30px
  }
</style>
