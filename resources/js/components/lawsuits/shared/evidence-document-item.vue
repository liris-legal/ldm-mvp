<template>
  <v-card flat>
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
        {{ document.name }}
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
          <iframe
            name="iframe"
            :src="'/iframe/'+ document.url"
            width="100%"
            height="100%"
            frameborder="0"
            style="height: 67vh;"
          />
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
        documentsTab: null,
      }
    },
  }
</script>

<style scoped>
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
    letter-spacing: 4px;
    padding-bottom: 8px;
  }

</style>
