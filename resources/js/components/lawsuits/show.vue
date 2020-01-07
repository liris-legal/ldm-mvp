<template>
  <div class="container-fluid lawsuit-show">
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

    <div class="claim">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description">
            最近表示
          </h3>
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
          <h3 class="description">
            証拠書面
          </h3>
        </v-col>
      </v-row>
      <app-thead :thead="thead_evidence_document" />
      <app-type-lawsuit
        v-if="lawsuit.defendants"
        :type-lawsuit="documentsOfSubmitter(lawsuit.defendants, 'defendant')"
      />
      <app-type-lawsuit
        v-if="lawsuit.plaintiffs"
        :type-lawsuit="documentsOfSubmitter(lawsuit.plaintiffs, 'plaintiff')"
      />
    </div>

    <div class="other-documents">
      <v-row>
        <v-col class="col-12 header-content">
          <h3 class="description">
            その他の書面
          </h3>
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
    directives: {
      /**
       * ClickOutside: Clicks Outside an Element
       */
      ClickOutside
    },
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
      axios.get('lawsuits/'+this.$route.params.lawsuitId)
      .then(res => {return this.lawsuit = res.data.data;})
      .catch(err => {console.log(err.response);
      });
    },
    mounted() {
      console.log(this.lawsuit);
    },
    methods: {
      /**
			 * @function hidden
			 * @description to hidden 作成 panel
			 */
      hidden() {
				if(this.showAdd === true){
          this.showAdd = false;
          document.getElementById("btn-add-app").classList.remove('v-btn--active');
				}
      },

      documentsOfSubmitter(array, valueCondition){
        if(array !== undefined && array.length > 0) {
          return array.find(item => { return item.submitter.description === valueCondition });
        }
      }
    }
  }
</script>
