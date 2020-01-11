<template>
  <div class="container-fluid lawsuit-show">
    <lawsuit-header :lawsuit="lawsuit" />
    <v-row class="clearfix pr-5 pt-2">
      <v-col class="text-right">
        <v-btn
          v-ripple
          class="mr-0-auto btn-primary pa-3 height-auto font-size-18 font-weight-600"
        >
          All View
        </v-btn>
      </v-col>
    </v-row>

    <div class="claim">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description font-size-18">
            主張書面
          </h3>
        </v-col>
      </v-row>
      <table class="table">
        <thead-columns :thead="thead_label" />
        <tbody>
          <documents-four-columns />
        </tbody>
      </table>
    </div>

    <div class="evidence-document">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description font-size-18">
            証拠書面
          </h3>
        </v-col>
      </v-row>
      <app-thead :thead="thead_evidence_document" />
      <app-type-lawsuit
        v-if="lawsuit.plaintiffs"
        :route-text="submitterOfDocument(lawsuit.plaintiffs, 'plaintiff')"
        :route-link="routeDefendantDocumentsIndex"
      />

      <app-type-lawsuit
        v-if="lawsuit.defendants"
        :route-text="submitterOfDocument(lawsuit.defendants, 'defendant')"
        :route-link="routePlaintiffDocumentsIndex"
      />
    </div>

    <div class="other-documents">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description font-size-18">
            その他の書面
          </h3>
        </v-col>
      </v-row>
      <table class="table">
        <thead-columns :thead="thead_label" />
        <tbody>
          <documents-four-columns />
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  export default {
    name: "LawsuitShow",
    props: {
      routePlaintiffDocumentsIndex: {
        required: true,
        type: String,
        default() {
          return ''
        }
      },
      routeDefendantDocumentsIndex: {
        required: true,
        type: String,
        default() {
          return ''
        }
      },
    },
    data() {
      return {
        thead_label: [
          { id: 1, label: '書面名', class: 'col-4'},
          { id: 2, label: '提出者', class: 'col-4'},
          { id: 3, label: '提出日', class: 'col-4'},
        ],
        thead_evidence_document: [{ id: 1, name: 'フォルダ名', class: 'col-12'}],
        thead_other_documents: [{ id: 1, name: '書面名', class: 'col-12'}],
        lawsuit: {},
			}
    },
    created() {
      axios.get('lawsuits/'+this.$route.params.lawsuitId)
      .then(res => {return this.lawsuit = res.data.data;})
      .catch(err => {console.log(err.response);
      });
    },
    methods: {
      /**
       * @function submitterOfDocument
       * @description get submitter of document
       * @return string
       */
      submitterOfDocument(documents, condition){
        if(documents !== undefined && documents.length > 0) {
          const document = documents.find(document => { return document.submitter.description === condition });
          return document.submitter.name + '書面'
        }
      }
    }
  }
</script>
