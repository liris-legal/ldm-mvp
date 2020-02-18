<template>
  <div v-if="loadingTask" class="pdf-viewer-wrapper">
    <panZoom :options="{minZoom: 0.5, maxZoom: 5}">
      <pdf
        v-for="i in numPages"
        :key="i"
        :src="loadingTask"
        :page="i"
        style="display: inline-block; width: 120%"
      ></pdf>
    </panZoom>
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

  export default {
    name: "VuePdf",
    props: {
      document: {required: true, type: Object, default: () => {}},
    },
    data() {
      return {
        zoom: 100,
        loadingTask: null,
        currentPage: 0,
        pageCount: 0,
        numPages: 0,
      }
    },
    components: {
      pdf
    },
    created(){
      axios.post('lawsuits/'+this.document.lawsuit_id+'/documents/'+this.document.id)
        .then(res => {
          this.loadingTask = pdf.createLoadingTask(res.data.data.url);
          this.loadingTask.then(pdf => {
            this.numPages = pdf.numPages;
          });
        })
        .catch(err => {
          console.log(err.response);
          alert('Not found document!');
        });
    },
    mounted() {
      console.log('PdfViewer mounted');
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
