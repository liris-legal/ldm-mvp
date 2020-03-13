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
        show-arrows
        center-active
      >
        <div
          v-for="(plaintiff, index) in lawsuit.plaintiffs"
          :key="'evidence-document-tab-plaintiff-'+index"
          class="d-flex"
        >
          <v-tab v-if="parsePartyTab(plaintiff, index, 'plaintiff')">
            {{ parsePartyTab(plaintiff, index, 'plaintiff') }}
          </v-tab>
        </div>
        <div
          v-for="(defendant, index) in lawsuit.defendants"
          :key="'evidence-document-tab-defendant-'+index"
          class="d-flex"
        >
          <v-tab v-if="parsePartyTab(defendant, index, 'defendant')">
            {{ parsePartyTab(defendant, index, 'defendant') }}
          </v-tab>
        </div>
      </v-tabs>

      <v-tabs-items
        v-model="tabs"
        class="document-items"
      >
        <div
          v-for="(plaintiff, index) in lawsuit.plaintiffs"
          :key="'evidence-document-tab-item-plaintiff-'+index"
        >
          <v-tab-item v-if="parseEvidenceDocuments(plaintiff, 'plaintiff').length > 0">
            <evidence-document-item
              :documents="parseEvidenceDocuments(plaintiff, 'plaintiff')"
              :tab-index="documentTab"
            />
          </v-tab-item>
        </div>
        <div
          v-for="(defendant, index) in lawsuit.defendants"
          :key="'evidence-document-tab-item-defendant-'+index"
        >
          <v-tab-item v-if="parseEvidenceDocuments(defendant, 'defendant').length > 0">
            <evidence-document-item
              :documents="parseEvidenceDocuments(defendant, 'defendant')"
              :tab-index="documentTab"
            />
          </v-tab-item>
        </div>
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
        tabs: 0,
        parties: [],
      }
    },
    watch: {
      parties(val) {
        // console.log('parties', val);
        // console.log('submitterId', this.submitterId)
        this.tabs = this.parties.findIndex(p => p.id === parseInt(this.submitterId))
      }
    },
    mounted() {
      // console.log('tabs ', this.tabs);
      // this.submitterType = this.$route.query.hasOwnProperty('submitter') ? this.$route.query.submitter + 's' : '';
      this.submitterId = this.$route.query.hasOwnProperty('submitterId') ? this.$route.query.submitterId : 0;
    },
    methods: {
      /**
       * @function parseEvidenceDocuments
       * @description get evidence documents of party
       * @return array
       */
      parseEvidenceDocuments(party, condition){
        const _documents = this.parseDocuments(party, condition);

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
        const hasDocument = this.parseDocuments(party, condition);
        if (hasDocument.length > 0 && this.parties.filter(p => p.id === party.id).length === 0) {
          // console.log('party', party);
          // this.parties.push(party);
          this.parties = [...this.parties, party]
          // console.log('parties', this.parties);
        }
        if (hasDocument.length > 0) return partyType + ++index + '書面';
        return null;
      },

      /**
       * @function parseDocuments
       * @description get document by author name
       */
      parseDocuments(party, condition){
        return this.documents.filter(d => d.submitter.description === condition && d.documentable && d.documentable.name === party.name );
      },
    },
  }
</script>
