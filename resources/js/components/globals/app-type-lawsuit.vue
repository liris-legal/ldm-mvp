<template>
  <div class="app-type-lawsuits">
    <a
      :href="routeLawsuitsIndex"
      class="folder-link"
    >
      <v-row
        v-ripple
        class="ma-0"
      >
        <v-col class="col-12 d-flex">
          <div class="name font-weight-600">{{ displayName }}</div>
          <v-spacer />
          <v-btn icon><v-icon>arrow_forward_ios</v-icon></v-btn>
        </v-col>
      </v-row>
    </a>
  </div>
</template>

<script>
  export default {
    props: {
      typeLawsuit: { type: Object, required: true, default: () => {}},
      routeLawsuitsIndex: {type: String, required: false, default: () => '#'},
    },
    computed: {
      /**
       * @function displayName
       * @description Is display name
       * @returns A String
       */
      displayName() {
        if(this.typeLawsuit.submitter !== undefined) {
          return this.typeLawsuit.submitter.name
        } else {
          return this.typeLawsuit.name
        }
      }
    }
  }
</script>
