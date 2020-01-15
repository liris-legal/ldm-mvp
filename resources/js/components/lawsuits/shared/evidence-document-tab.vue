<template>
  <v-tab-item>
    <v-container fluid>
      <v-tabs
        v-model="documentsTab"
        background-color="transparent"
        class="document-tabs"
        active-class="activated"
        height="40"
        hide-slider
      >
        <v-tab
          v-for="(label, index) in documentLabels"
          :key="index"
        >
          {{ label }}
        </v-tab>
      </v-tabs>

      <v-tabs-items
        v-model="documentsTab"
        class="document-items"
      >
        <v-tab-item>
          <evidence-document-item :documents="parseEvidenceDocuments('plaintiff')"/>
        </v-tab-item>

        <v-tab-item>
          <evidence-document-item :documents="parseEvidenceDocuments('defendant')"/>
        </v-tab-item>
      </v-tabs-items>
    </v-container>
  </v-tab-item>
</template>

<script>
  import evidenceDocumentItem from './evidence-document-item'
  export default {
    name: "evidence-document-tab",
    props: {
      documents: {required: true, type: Array, default: () => []},
    },
    data() {
      return {
        documentsTab: null,
        documentLabels: ['原告書面', '被告書面'],
      }
    },
    components:{
      evidenceDocumentItem
    },
    methods: {
      parseEvidenceDocuments(party){
        return this.documents.filter(d => d.submitter.description === party );
      },
    },
  }
</script>

<style scoped>

</style>
