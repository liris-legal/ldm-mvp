<template>
  <div
    v-if="routeText"
    class="app-type-lawsuits"
  >
    <a
      :href="routeLink"
      class="folder-link"
    >
      <v-row
        v-ripple
        class="ma-0"
      >
        <v-col class="col-12 d-flex">
          <div class="name">{{ routeText }}</div>
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
      routeText: { type: String, required: false, default: () => ''},
      routeLink: {type: String, required: false, default: () => '#'},
    }
  }
</script>
