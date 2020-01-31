<template>
  <v-tab-item class="evidence-document-tab">
    <v-container
      fluid
      class="pa-0"
    >
      <v-tabs
        v-model="tabs"
        background-color="transparent"
        class="document-tabs"
        active-class="activated"
        height="40"
        hide-slider
      >
        <v-tab v-if="parseParties(documents, 'plaintiff')">
          {{ parseParties(documents, 'plaintiff') }}
        </v-tab>
        <v-tab v-if="parseParties(documents, 'defendant')">
          {{ parseParties(documents, 'defendant') }}
        </v-tab>
      </v-tabs>

      <v-tabs-items
        v-model="tabs"
        class="document-items"
      >
        <v-tab-item>
          <evidence-document-item :documents="parseEvidenceDocuments('plaintiff')" />
        </v-tab-item>

        <v-tab-item>
          <evidence-document-item :documents="parseEvidenceDocuments('defendant')" />
        </v-tab-item>
      </v-tabs-items>
    </v-container>
  </v-tab-item>
</template>

<script>
  import evidenceDocumentItem from './evidence-document-item'
  export default {
    name: "EvidenceDocumentTab",
    components:{
      evidenceDocumentItem
    },
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
    },
    methods: {
      /**
       * @function parseEvidenceDocuments
       * @description get evidence documents of party
       * @return array
       */
      parseEvidenceDocuments(party){
        const documents = this.documents.filter(d => d.submitter.description === party);
        // except "証拠説明書"
        let evidenceStatementDocuments = documents.filter(d => d.name === '証拠説明書').sort((a, b) => a.number > b.number ? 1 : -1);

        let evidenceDocuments = documents.filter(d => d.name !== '証拠説明書');
        evidenceDocuments.sort((a, b) => a.number >= b.number ? -1 : a.subnumber > b.subnumber ? 1 : -1).reverse();

        return evidenceStatementDocuments.concat(evidenceDocuments);
      },
      /**
       * @function parseParties
       * @description get submitter of document
       * @return string|null
       */
      parseParties(parties, condition){
        if(parties && parties.length > 0) {
          const hasDocument = parties.find(d => { return d.submitter.description === condition });
          if (hasDocument) return hasDocument.submitter.name + '書面';
          return null;
        }
      }
    },
  }
</script>

<style scoped>

</style>
