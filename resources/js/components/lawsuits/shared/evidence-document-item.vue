<template>
  <v-card
    flat
    class="ma-0"
  >
    <v-tabs
      v-model="documentsTab"
      class="item-tabs"
      vertical
      active-class="activated"
      hide-slider
    >
      <v-tab
        v-for="document in documents"
        :key="'item-document-'+document.id"
        class="text-vertical"
      >
        {{ parseName(document) }}
        <span class="text-initial">{{ document.number }}</span>
        {{ hasConjunction(document.name, document.number) ? 'の' : ''}}
        <span class="text-initial" v-show="hasConjunction(document.name, document.number)">{{ document.subnumber }}</span>
      </v-tab>
    </v-tabs>

    <v-tabs-items
      v-model="documentsTab"
      class="item-content"
    >
      <v-tab-item
        v-for="document in documents"
        :key="'document-'+document.id"
      >
        <v-card flat>
          <pdf-viewer :document="document" />
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
  export default {
    name: "EvidenceDocumentItem",
    props: {
      documents: {required: true, type: Array, default: () => []},
    },
    data() {
      return {
        documentsTab: 0,
      }
    },
    methods:{
      /**
       * @function parseName
       * @description parse name to display
       */
      parseName(document){
        const ignorePattern = '号証';
        if (document.type.id === 2 && document.name.includes(ignorePattern)){
          return document.name.replace(ignorePattern, '')
        }
        return document.name
      },

      /**
       * @function hasConjunction
       * @description has の ?
       */
      hasConjunction(name, number){
        if (name !== "証拠説明書")
          return this.documents.filter(d => d.number === number).length > 1;
        else
          return false
      },

    }
  }
</script>

<style scoped lang="scss">
  .item-tabs{
    position: relative;
  }
  .item-content {
    /*margin-right: 136px;*/
    padding-right: 8em;
    padding-top: 0.1px;
    text-align: justify;
    min-height: 68vh;
    height: auto;
  }
  .text-vertical{
    writing-mode:vertical-lr;
    -webkit-transform:rotate(0deg);
    -moz-transform:rotate(0deg);
    -o-transform: rotate(0deg);
    -ms-transform:rotate(0deg);
    transform: rotate(0deg);
    white-space:nowrap;
    display:block;
    height: auto !important;
    letter-spacing: 3px;
  }
  .text-initial{
    writing-mode: lr !important;
  }
  .text-vertical.v-tab.activated.v-tab--active, .v-slide-group__content.v-tabs-bar__content, .v-tab--active.v-tab:not(:focus):before{
      width: 48px;
  }
  .item-content{
      padding-right: 3.8em;
  }

</style>
