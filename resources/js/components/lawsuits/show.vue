<template>
    <div class="container-fluid lawsuit-show">
      <lawsuit-header />
      <v-row class="clearfix pr-5 pt-2">
          <v-col class="text-right">
              <v-btn v-ripple class="mr-0-auto btn-primary pa-3 height-auto text-size-18 font-weight-600">All View</v-btn>
          </v-col>
      </v-row>
      <div class="claim">
        <v-row>
          <v-col class="col-12 header-content">
            <h3 class="description">最近表示</h3>
          </v-col>
        </v-row>
        <app-thead :thead="thead_claim" />
      </div>
      <div class="evidence-document">
        <v-row>
          <v-col class="col-12 header-content">
            <h3 class="description">証拠書面</h3>
          </v-col>
        </v-row>
        <app-thead :thead="thead_evidence_document" />
        <!-- <app-type-lawsuit
          v-for="type_lawsuit in type_lawsuits"
          :key="type_lawsuit.id"
          :type_lawsuit="type_lawsuit"
        /> -->
      </div>
      <div class="other-documents">
        <v-row>
          <v-col class="col-12 header-content">
            <h3 class="description">その他の書面</h3>
          </v-col>
        </v-row>
        <app-thead :thead="thead_other_documents" />
      </div>
    </div>
</template>
<script>
  /**
   * Index: Clicks Outside an Element
   */
  import ClickOutside from 'vue-click-outside';
import { log } from 'util';
  export default {
    data() {
      return {
        thead_claim: [
          { id: 1, name: '書面名', class: 'col-4'},
          { id: 2, name: '提出者', class: 'col-4'},
          { id: 3, name: '提出日', class: 'col-4'},
        ],
        thead_evidence_document: [{ id: 1, name: 'フォルダ名', class: 'col-12'}],
        thead_other_documents: [{ id: 1, name: '書面名', class: 'col-12'}],
			}
    },
    methods: {
      
    },
    created() {
      axios.get('lawsuits/1').then(res => {console.log(res.data.data)});
    }
  }
</script>