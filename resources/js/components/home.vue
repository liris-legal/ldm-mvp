<template>
  <div class="container-fluid home-content">
    <v-row>
      <v-col class="col-12 header-content">
        <h2 class="title-name font-size-30">
          ホーム
        </h2>
        <h3 class="description font-size-18">
          最近表示
        </h3>
      </v-col>
    </v-row>
    <app-thead :thead="thead" />
    <div
      v-for="document in sortedDocuments"
      :key="document.id"
      class="document-two-columns"
    >
      <a
        :href="'/lawsuits/' + document.lawsuit_id + '/documents?type='+document.type_document_id+'&name='+document.name"
        class="document-link"
      >
        <v-row v-ripple>
          <v-col class="col-7">
            <div class="name">{{ parseDocumentName(document) }}</div>
          </v-col>
          <v-col class="col-5">
            <div class="date">{{ formatDate(document.created_at.split(' ')[0]) }}</div>
          </v-col>
        </v-row>
      </a>
    </div>
  </div>
</template>

<script>
  export default {
    name: "HomeIndex",
		props: {
      documents: { type: Array, required: true, default: () => [] }
		},
		data() {
      return {
        thead: [
          { id: 1, name: '書面名', class: 'col-7'},
          { id: 2, name: '表示日', class: 'col-5'}
        ],
        sortedDocuments: []
			}
		},
    methods: {
      /**
       * @function parseDocumentName
       * @description parse name to display
       */
      parseDocumentName(document){
        if (document.type_document_id !== 2) return document.name;
        if (document.name !== '"証拠説明書"' && document.subnumber === 1)
          return document.name.replace('号証', '') + document.number + '号証の' + document.subnumber;
        else
          return document.name + '' + document.number;
      }
    },
    mounted() {
      // sort document by created_at
      this.sortedDocuments = this.documents.sort((a, b) => a.created_at > b.created_at ? -1 : 1);
    }
  }
</script>

<style scoped>

</style>
