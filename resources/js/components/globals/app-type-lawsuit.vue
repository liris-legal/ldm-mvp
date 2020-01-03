<template>
  <div class="app-type-lawsuits">
    <a
      href="#"
      class="folder-link"
    >
      <v-row v-ripple>
        <v-col class="col-12 row">
          <div class="name font-weight-600">{{ typeLawsuit.name }}</div>
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
      typeLawsuit: { type: Object, required: true}
    }
  }
</script>
