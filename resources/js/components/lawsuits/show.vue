<template>
    <div class="container-fluid lawsuit-show">
      <lawsuit-header :info="lawsuit" />
      <v-row class="clearfix pr-5 pt-2">
          <v-col class="text-right">
              <v-btn
              v-ripple
              class="mr-0-auto btn-primary pa-3 height-auto text-size-18 font-weight-600">
              All View
              </v-btn>
          </v-col>
      </v-row>

      <div class="claim">
        <v-row>
          <v-col class="col-12 header-content">
            <h3 class="description">最近表示</h3>
          </v-col>
        </v-row>
        <table class="table">
          <thead-columns :thead="thead_claim" />
          <tbody>
            <documents-four-columns />
          </tbody>
        </table>
      </div>

      <div class="evidence-document">
        <v-row>
          <v-col class="col-12 header-content">
            <h3 class="description">証拠書面</h3>
          </v-col>
        </v-row>
        <app-thead :thead="thead_evidence_document" />
        <app-type-lawsuit :typeLawsuit="submitterDocument" />
      </div>

      <div class="other-documents">
        <v-row>
          <v-col class="col-12 header-content">
            <h3 class="description">その他の書面</h3>
          </v-col>
        </v-row>
        <table class="table">
          <thead-columns :thead="thead_claim" />
          <tbody>
            <documents-four-columns />
          </tbody>
        </table>
      </div>
    </div>
</template>
<script>
  /**
   * Index: Clicks Outside an Element
   */
  import ClickOutside from 'vue-click-outside';
  export default {
    data() {
      return {
        thead_claim: [
          { id: 1, label: '書面名', class: 'col-4'},
          { id: 2, label: '提出者', class: 'col-4'},
          { id: 3, label: '提出日', class: 'col-4'},
        ],
        thead_evidence_document: [{ id: 1, name: 'フォルダ名', class: 'col-12'}],
        thead_other_documents: [{ id: 1, name: '書面名', class: 'col-12'}],
        lawsuit: {},
        submitterDocument: {id: 1, name: '原告書面'}
			}
    },
    created() {
      let self = this;
      axios.get('lawsuits/'+self.$route.params.lawsuitId)
      .then(res => { return self.lawsuit = res.data.data})
      .catch(err => {console.log(err.response);
      });
    },
    methods: {
      documentsOfSubmitter(submitter){
        console.log('submiter: ', submitter);
        console.log(this.lawsuit);
      }
    },
    mounted() {
      let self = this;
      this.documentsOfSubmitter(self.lawsuit.defentdants);
    }
  }
</script>
