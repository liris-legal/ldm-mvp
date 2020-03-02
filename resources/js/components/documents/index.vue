<template>
  <div class="container-fluid document document--index">
    <lawsuit-header
      :lawsuit="lawsuit"
      :loading="loading"
    />
    <v-row class="clearfix pr-5 pt-2">
      <v-col class="text-right">
        <v-btn
          v-ripple
          class="mr-0-auto btn-primary height-auto font-size-18 font-weight-600"
          @click="showAllDocument(lawsuit.id)"
        >
          All View
        </v-btn>
      </v-col>
    </v-row>

    <div class="evidence-statement">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description font-size-18">
            証拠説明書
          </h3>
        </v-col>
      </v-row>
      <table class="table">
        <thead-columns :thead="theadLabels" />
        <tbody>
          <template v-if="explainDocuments.length > 0">
            <range-row-item
              v-for="document in explainDocuments"
              :key="'explain-document-'+document.id"
              :document="document"
              :document-name="document.name+''+document.number"
              :lawsuit-id="parseInt($route.params.lawsuitId)"
            />
          </template>
          <template v-else>
            <range-row-item />
          </template>
        </tbody>
      </table>
    </div>

    <div class="evidence-document">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description font-size-18">
            {{ party }}号証
          </h3>
        </v-col>
      </v-row>
      <table class="table">
        <thead-columns :thead="theadLabels" />
        <tbody>
          <template v-if="evidenceDocuments.length > 0">
            <range-row-item
              v-for="document in evidenceDocuments"
              :key="'evidence-document-'+document.id"
              :document="document"
              :document-name="parseDocumentName(document.number, document.subnumber)"
              :lawsuit-id="parseInt($route.params.lawsuitId)"
            />
          </template>
          <template v-else>
            <range-row-item />
          </template>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  import {mapState} from "vuex";

  export default {
    name: "DocumentIndex",
    props: {
      lawsuitId: {
        required: true,
        type: String,
        default: ''
      },
    },
    data() {
      return {
        submitter: '',
        party: '',
        theadLabels: [
          { id: 1, label: '書面名', class: 'col-6'},
          { id: 2, label: '提出日', class: 'col-6'},
        ],
        lawsuit: {},
        explainDocuments: [],
        evidenceDocuments: [],
        loading: true,
      }
    },
    computed: {
      ...mapState(['user']),
    },
    created() {
      /**
       * parse $route params
       *
       */
      this.submitter = this.$route.params.submitter;
      this.submitterId = this.$route.params.submitterId;
      this.party = this.submitter === 'plaintiff' ? "甲" : "乙";

      /**
       * @description fetch lawsuits data from API
       */
      axios.get('users/'+this.user.id+'/lawsuits/'+this.$route.params.lawsuitId)
        .then(res => {
          this.lawsuit = res.data.data;
          const evidenceDocument = this.lawsuit.documents.filter(d => d.type.description === 'evidence' && d.submitter.description === this.submitter);
          const filteredEvidence = evidenceDocument.filter(e => e.documentable && e.documentable.id === parseInt(this.submitterId));

          const explainDocumentName = this.submitter === 'plaintiff' ? "甲号証" : "乙号証";
          this.evidenceDocuments = filteredEvidence.filter(d => d.name === explainDocumentName).sort((a, b) => a.subnumber >= b.subnumber ? 1 : -1).sort((a, b) => a.number >= b.number ? 1 : -1);
          this.explainDocuments = filteredEvidence.filter(d => d.name === '証拠説明書').sort((a, b) => a.number > b.number ? 1 : -1);
          })
        .catch(err => {console.log(err);})
      .finally(() => {
        this.loading = false;
      });
    },
    methods: {
      /**
       * @function parseDocumentName
       * @description parse name to display
       */
      parseDocumentName(number, subnumber){
        if (subnumber > 0)
          return this.party+'第'+number+'号証の'+subnumber;
        else
          return this.party+'第'+number+'号証';
        // if (subnumber === 1)
        //   if(this.evidenceDocuments.filter(d => d.number === number).length > 1)
        //     return this.party+'第'+number+'号証の'+subnumber;
        //   else
        //     return this.party+'第'+number+'号証';
        // else
        //   return this.party + '第' + number + '号証の' + subnumber
      }
    }
  }
</script>
