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
        <claim-document-tab :documents="claimDocuments" />
        <!-- △ 主張書面-->

        <!-- ▽ 証拠書面-->
        <evidence-document-tab :documents="evidenceDocuments" />
        <!-- △ 証拠書面-->

        <!-- ▽ その他の書面-->
        <other-document-tab :documents="otherDocuments" />
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
        evidenceDocuments: [],
        otherDocuments: [],
      }
    },
    mounted() {
      // disable scroll-y
      document.body.style.overflowY = "hidden";
    },
    created() {
      axios.get('lawsuits/'+this.$route.params.lawsuitId)
        .then(res => {
          this.lawsuit = res.data.data;
          const documents = this.lawsuit.documents;
          this.claimDocuments = documents.filter(d => d.type.description === 'claim');
          this.evidenceDocuments = documents.filter(d => d.type.description === 'evidence' );
          this.otherDocuments = documents.filter(d => d.type.description === 'other');
          })
        .catch(err => {
          console.log(err.response);
          alert('Not found data!');
        });
    },
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
