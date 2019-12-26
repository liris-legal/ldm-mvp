<template>
  <div class="app-type-lawsuits">
    <a
      href="/lawsuits"
      class="folder-link"
    >
      <v-row v-ripple>
        <v-col class="col-12 row">
          <div class="name font-weight-600">{{ type_lawsuit.name }}</div>
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
      type_lawsuit: { type: Object, required: true, default: {id: 1, name: '民事事件', url: '#' } }
    }
  }
</script>
