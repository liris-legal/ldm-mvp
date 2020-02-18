<template>
  <div v-if="loadingTask" class="pdf-viewer-wrapper">
    <v-col class="btn-control-icon text-center">
      <v-col cols="1" sm="1">
        <v-btn
          @click="onZoomOut()"
          :disabled="disabledZoomOut"
          elevation="6" outlined fab x-small color="indigo">
          <v-icon>zoom_out</v-icon>
        </v-btn>
      </v-col>

      <v-col cols="1" sm="1">
        <v-btn
          @click="onZoomIn()"
          :disabled="disabledZoomIn"
          elevation="6" outlined fab x-small color="indigo">
          <v-icon>zoom_in</v-icon>
        </v-btn>
      </v-col>
    </v-col>
    <pdf
      v-for="i in numPages"
      :key="i"
      :src="loadingTask"
      :page="i"
      style="display: inline-block;"
      v-bind:style="{ width: zoom + '%' }"
    ></pdf>
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
        numPages: 0,
        disabledZoomIn: false,
        disabledZoomOut: false,
      }
    },
    components: {
      pdf,
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
    watch: {
      zoom(){
        this.disabledZoomIn = this.zoom > 150;
        this.disabledZoomOut = this.zoom < 80;
      }
    },
    methods:{
      onZoomIn(){
        this.zoom += 5;
        console.log('onZoomIn', this.zoom);
      },
      onZoomOut(){
        this.zoom -= 5;
        console.log('onZoomOut', this.zoom);
      },
    },
    mounted() {
      console.log('VuePdf mounted');
    }
  }
</script>

<style lang='scss'>
  .pdf-viewer-wrapper {
    overflow: auto;
    max-height: 70vh;
    position: relative;
    width: 100%;
    height: 100%;
    &.zoom-active {
      cursor: grab;
    }
    .btn-control-icon{
      position: fixed;
      width: 100%;
      justify-content: center;
      bottom: 30%;
      z-index: 1;

      button {
       background-color: #FFF;
      }
    }
  }
</style>
