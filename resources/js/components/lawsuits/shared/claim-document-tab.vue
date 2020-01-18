<template>
  <v-tab-item>
    <v-container
      fluid
      class="pa-0"
    >
      <v-tabs
        v-model="claimDocumentTab"
        background-color="transparent"
        class="document-tabs"
        active-class="activated"
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
        v-model="claimDocumentTab"
        class="document-items"
      >
        <v-tab-item
          v-for="document in documents"
          :key="'claim-document-'+document.id"
        >
          <v-card flat>
            <pdf-viewer :document="document" />
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-container>
  </v-tab-item>
</template>

<script>
  export default {
    name: "ClaimDocumentTab",
    props: {
      documents: {required: true, type: Array, default: () => []},
    },
    data() {
      return {
        claimDocumentTab: null,
      }
    },
  }
</script>

<style scoped>

</style>
