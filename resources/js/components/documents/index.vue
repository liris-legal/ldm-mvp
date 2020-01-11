<template>
  <div class="container-fluid document document--index">
    <lawsuit-header :lawsuit="lawsuit" />
    <v-row class="clearfix pr-5 pt-2">
      <v-col class="text-right">
        <v-btn
          v-ripple
          class="mr-0-auto btn-primary height-auto font-size-18 font-weight-600"
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
            <range-table-row
              v-for="document in explainDocuments"
              :key="'explain-document-'+document.id"
              :document="document"
              :sub-menu="Boolean(false)"
            />
          </template>
          <template v-else>
            <tr
              v-ripple
              class="range--row-item d-flex pa-0"
            >
              <td
                scope="col"
                class="col col-6 pt-2 pb-2"
              >
                <div class="name">
                  No content
                </div>
              </td>
              <td
                scope="col"
                class="col col-6 pt-2 pb-2"
              />
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <div class="evidence-document">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description font-size-18">
            {{ submitter === 'plaintiff' ? "甲" : "乙" }}号証
          </h3>
        </v-col>
      </v-row>
      <table class="table">
        <thead-columns :thead="theadLabels" />
        <tbody>
          <template v-if="evidenceDocuments.length > 0">
            <range-table-row
              v-for="document in evidenceDocuments"
              :key="'evidence-document-'+document.id"
              :document="document"
              :submitter="submitter"
              :lawsuit-id="parseInt($route.params.lawsuitId)"
            />
          </template>
          <template v-else>
            <tr
              v-ripple
              class="range--row-item d-flex pa-0"
            >
              <td
                scope="col"
                class="col col-6 pt-2 pb-2"
              >
                <div class="name">
                  No content
                </div>
              </td>
              <td
                scope="col"
                class="col col-6 pt-2 pb-2"
              />
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
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
        theadLabels: [
          { id: 1, label: '書面名', class: 'col-6'},
          { id: 2, label: '提出日', class: 'col-6'},
        ],
        lawsuit: {},
        explainDocuments: [],
        evidenceDocuments: []
      }
    },
    created() {
      axios.get('lawsuits/'+this.$route.params.lawsuitId)
        .then(res => {
          this.lawsuit = res.data.data;
          const evidenceDocument = this.lawsuit.documents.filter(d => d.submitter_description === this.submitter &&
           d.type_document.description === 'evidence' );

          const explainDocumentName = this.submitter === 'plaintiff' ? "甲号証" : "乙号証";
          this.evidenceDocuments = evidenceDocument.filter(d => d.name === explainDocumentName);
          this.explainDocuments = evidenceDocument.filter(d => d.name === '証拠説明書');
          })
        .catch(err => {console.log(err.response);});

      /**
       * parse params to get submitter
       *
       */
      this.submitter = this.$route.params.submitter;
    },
    mounted() {
      console.log(this.$route.name + ' mounted');
    }
  }
</script>
