<template>
  <v-tab-item>
    <v-container fluid>
      <v-tabs
        v-model="documentsTab"
        background-color="transparent"
        active-class="activated"
        class="document-tabs"
        height="40"
        show-arrows
        hide-slider
      >
        <v-tab
          v-for="document in documents"
          :key="document.id"
        >
          {{ document.name }}
        </v-tab>
      </v-tabs>

      <v-tabs-items
        v-model="documentsTab"
        class="document-items"
      >
        <v-tab-item
          v-for="document in documents"
          :key="'other-document-'+document.id"
        >
          <v-card flat>
            <iframe
              name="iframe"
              :src="'/iframe/'+ document.url"
              width="100%"
              height="100%"
              frameborder="0"
              style="height: 67vh;"
            />
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-container>
  </v-tab-item>
</template>

<script>
  export default {
    name: "OtherDocumentTab",
    props: {
      documents: {required: true, type: Array, default: () => []},
    },
    data() {
      return {
        documentsTab: null,
      }
    },
    mounted() {
      console.log(this.$options.name + ' mounted');
    }
  }
</script>

<style scoped>

</style>
