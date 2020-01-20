<template>
  <div class="container-fluid lawsuit-document-show">
    <lawsuit-header :lawsuit="lawsuit" />
    <v-card class="lawsuit-document-card">
      <v-tabs
        v-model="typeTab"
        background-color="transparent"
        color="primary"
        grow
        centered
        class="type-tabs"
        active-class="tab--activated"
        height="40"
      >
        <v-tab
          v-for="type in typeDocuments"
          :key="type.id"
        >
          {{ type.name }}
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="typeTab">
        <!-- ▽ 主張書面-->
        <claim-document-tab
          :documents="claimDocuments"
          :document-tab="claimDocumentTab"
        />
        <!-- △ 主張書面-->

        <!-- ▽ 証拠書面-->
        <evidence-document-tab
          :documents="evidenceDocuments"
          :document-tab="evidenceDocumentTab"
        />
        <!-- △ 証拠書面-->

        <!-- ▽ その他の書面-->
        <other-document-tab
          :documents="otherDocuments"
          :document-tab="otherDocumentTab"
        />
        <!-- △ その他の書面-->
      </v-tabs-items>
    </v-card>
  </div>
</template>
<script>
  import claimDocumentTab from './shared/claim-document-tab'
  import evidenceDocumentTab from './shared/evidence-document-tab'
  import otherDocumentTab from './shared/other-document-tab'

  export default {
    name: "LawsuitDocumentShow",
    components:{
      claimDocumentTab,
      evidenceDocumentTab,
      otherDocumentTab,
    },
    props: {
      typeDocuments: {required: true, type: Array, default: () => []},
    },
    data() {
      return {
        submitter: '',
        submitterKana: '',
        theadLabels: [
          { id: 1, label: '書面名', class: 'col-6'},
          { id: 2, label: '提出日', class: 'col-6'},
        ],
        lawsuit: {},
        typeTab: null,
        claimDocuments: [],
        claimDocumentTab: 0,
        evidenceDocuments: [],
        evidenceDocumentTab: 0,
        otherDocuments: [],
        otherDocumentTab: 0,
      }
    },
    mounted() {
      // disable scroll-y
      document.body.style.overflowY = "hidden";
    },
    created() {
      /**
       * fetch lawsuit data from API
       */
      axios.get('lawsuits/'+this.$route.params.lawsuitId)
        .then(res => {
          this.lawsuit = res.data.data;
          const documents = this.lawsuit.documents;
          this.claimDocuments = documents.filter(d => d.type.description === 'claim');
          this.evidenceDocuments = documents.filter(d => d.type.description === 'evidence' );
          this.otherDocuments = documents.filter(d => d.type.description === 'other');

          // initial tab activated
          this.claimDocumentTab = this.initialData(this.claimDocuments);
          this.evidenceDocumentTab = this.initialData(this.evidenceDocuments);
          this.otherDocumentTab = this.initialData(this.otherDocuments);
          })
        .catch(err => {
          console.log(err.response);
          alert('Not found data!');
        });

      /**
       * initial typeTab
       */
      this.typeTab = this.$route.query.hasOwnProperty('type') ? parseInt(this.$route.query.type) - 1 : 0;
    },
    methods: {
      /**
       * initial documentTab
       */
      initialData(documents){
        if (this.$route.query.hasOwnProperty('type') && parseInt(this.$route.query.type) !== 2){
          const nameTab = this.$route.query.hasOwnProperty('name') ? this.$route.query.name : '';
          return documents.findIndex(e => e.name === nameTab);
        }
        // if (this.$route.query.hasOwnProperty('submitter')){
        //   const submitter = this.$route.query.submitter;
        //   const submitters = ['plaintiff', 'defendant'];
        //   return submitters.findIndex(s => s === submitter);
        // }
        // console.log('not found query');
        return 0;
      }
    }
  }
</script>

<style scoped>
  .type-tabs {
    max-width: 60%;
    margin: 0 auto;
    border-bottom: 1.3px solid #dee2e6;
    padding-top: 1.28em;
  }
  .v-tabs-items{
    padding-top: 1.28em;
  }
  .tab--activated{
    font-weight: 600;
  }
</style>
