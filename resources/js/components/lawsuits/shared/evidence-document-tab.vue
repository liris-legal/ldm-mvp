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
        <v-tab
          v-for="(plaintiff, index) in lawsuit.plaintiffs"
          :key="'evidence-document-tab-plaintiff-'+index"
        >
          {{ parsePartyTab(plaintiff, ++index, 'plaintiff') }}
        </v-tab>
        <v-tab
          v-for="(defendant, index) in lawsuit.defendants"
          :key="'evidence-document-tab-defendant-'+index"
        >
          {{ parsePartyTab(defendant, ++index, 'defendant') }}
        </v-tab>
      </v-tabs>

      <v-tabs-items
        v-model="tabs"
        class="document-items"
      >
        <v-tab-item
          v-for="(plaintiff, index) in lawsuit.plaintiffs"
          :key="'evidence-document-tab-item-plaintiff-'+index"
        >
          <evidence-document-item :documents="parseEvidenceDocuments(plaintiff, index, 'plaintiff')" />
        </v-tab-item>

        <v-tab-item
          v-for="(defendant, index) in lawsuit.defendants"
          :key="'evidence-document-tab-item-defendant-'+index"
        >
          <evidence-document-item :documents="parseEvidenceDocuments(defendant, index, 'defendant')" />
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
      lawsuit: {required: true, type: Object, default: () => {}},
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
      parseEvidenceDocuments(party, index, condition){
        const _documents = this.parseDocuments(party, index, condition);

        // only "証拠説明書"
        let evidenceStatementDocuments = _documents.filter(d => d.name === '証拠説明書').sort((a, b) => a.number > b.number ? 1 : -1);
        // except "証拠説明書"
        let evidenceDocuments = _documents.filter(d => d.name !== '証拠説明書');
        evidenceDocuments.sort((a, b) => a.number >= b.number ? -1 : a.subnumber > b.subnumber ? 1 : -1).reverse();

        return evidenceStatementDocuments.concat(evidenceDocuments);
      },
      /**
       * @function parsePartyTab
       * @description get submitter tab
       * @return string|null
       */
      parsePartyTab(party, index, condition){
        const partyType = condition === 'plaintiff' ? '原告' : '被告';
        const hasDocument = this.parseDocuments(party, index, condition);
        if (hasDocument) return partyType + index + '書面';
        return null;
      },

      /**
       * @function parseDocuments
       * @description get document by author name
       */
      parseDocuments(party, index, condition){
        return this.documents.filter(d => { return d.submitter.description === condition && d.documentable.name === party.name });
      }
    },
  }
</script>

<style scoped>

</style>
