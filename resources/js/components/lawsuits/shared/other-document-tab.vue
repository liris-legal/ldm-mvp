<template>
  <v-tab-item>
    <v-container
      fluid
      class="pa-0"
    >
      <v-tabs
        v-model="tabs"
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
        v-model="tabs"
        class="document-items"
      >
        <v-tab-item
          v-for="document in documents"
          :key="'other-document-'+document.id"
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
    name: "OtherDocumentTab",
    props: {
      documents: {required: true, type: Array, default: () => []},
      documentTab: {required: false, type: Number, default: () => 0},
    },
    data() {
      return {
        tabs: this.documentTab,
      }
    },
    watch: {
      documentTab(){
        this.tabs = this.documentTab
      }
    },
    mounted() {
      // console.log(this.$options.name + ' mounted');
    }
  }
</script>

<style scoped>

</style>
