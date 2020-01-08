<template>
  <div class="container-fluid document document--index">
    <lawsuit-header :lawsuit="lawsuit" />
    <v-row class="clearfix pr-5 pt-2">
      <v-col class="text-right">
        <v-btn
          v-ripple
          class="mr-0-auto btn-primary pa-3 height-auto text-size-18 font-weight-600"
        >
          All View
        </v-btn>
      </v-col>
    </v-row>

    <div class="evidence-statement">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description">
            証拠説明書
          </h3>
        </v-col>
      </v-row>
      <table class="table">
        <thead-columns :thead="theadLabels" />
        <tbody>
          <range-table-row v-for="document in explainDocuments"
                           :key="'explain-document-'+document.id"
                           :document="document"
                           :sub-menu="Boolean(false)"
          />
        </tbody>
      </table>
    </div>

    <div class="evidence-document">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description">
            {{submitter === 'plaintiff' ? "甲" : "乙"}}号証
          </h3>
        </v-col>
      </v-row>
      <table class="table">
        <thead-columns :thead="theadLabels" />
        <tbody>
          <range-table-row v-for="document in evidenceDocuments"
                           :key="'evidence-document-'+document.id"
                           :document="document"
                           :submitter="submitter"
                           :lawsuit-id="parseInt($route.params.lawsuitId)"
          />
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  export default {
    name: "document-index",
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
        explainDocuments: [
          { id: 1, name: '証拠説明書1', created_at: '2019年12月31日'},
          { id: 2, name: '証拠説明書2', created_at: '2020年01月10日'},
        ],
        evidenceDocuments: [
          { id: 4, name: '甲第4号証', created_at: '2019年12月31日'},
          { id: 3, name: '甲第3号証', created_at: '2020年01月10日'},
          { id: 2, name: '甲第2号証', created_at: '2020年01月10日'},
          { id: 1, name: '甲第1号証', created_at: '2020年01月10日'},
        ]
      }
    },
    created() {
      axios.get('lawsuits/'+this.$route.params.lawsuitId)
        .then(res => {return this.lawsuit = res.data.data;})
        .catch(err => {console.log(err.response);
        });

      /**
       * parse params to get submitter
       *
       */
      this.submitter = this.$route.params.submitter;
    },
    mounted() {
      console.log(this.$route.name + ' mounted');
    },
    methods: {
    }
  }
</script>
