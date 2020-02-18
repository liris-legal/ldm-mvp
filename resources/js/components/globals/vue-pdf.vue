<template>
  <div v-if="src">
    <div class='pdf-viewer-wrapper' v-dragscroll='true' :class='{"zoom-active": zoom > 100 }' >
      <pdf :src="src"
           @num-pages="pageCount = $event"
           @page-loaded="currentPage = $event"
           style="width: 120%"
      />
    </div>
  </div>

  <div v-else>
    <v-container style="height: 65vh;">
      <v-row
        class="fill-height"
        align-content="center"
        justify="center"
      >
        <v-col
          class="subtitle-1 text-center"
          cols="12"
        >
          ファイルの読み込みしています。
        </v-col>
        <v-col cols="6">
          <v-progress-linear
            color="blue lighten-3 accent-4"
            indeterminate
            rounded
            height="6"
          />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
  import pdf from 'vue-pdf'
  import { dragscroll } from 'vue-dragscroll'

  export default {
    name: "VuePdf",
    props: {
      document: {required: true, type: Object, default: () => {}},
    },
    data() {
      return {
        zoom: 100,
        src: null,
        currentPage: 0,
        pageCount: 0,
      }
    },
    directives: { dragscroll },
    components: {
      pdf
    },
    created(){
      axios.post('lawsuits/'+this.document.lawsuit_id+'/documents/'+this.document.id)
        .then(res => {
          this.src = res.data.data.url;
        })
        .catch(err => {
          console.log(err.response);
          alert('Not found document!');
        });
    },
    mounted() {
      console.log('PdfViewer mounted')
    }
  }
</script>

<style lang='scss'>
  .pdf-viewer-wrapper {
    overflow: auto;
    max-height: 70vh;
    &.zoom-active {
      cursor: grab;
    }
  }
</style>
