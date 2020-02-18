<template>
  <div v-if="src">
    <pdf :src="src"
         @num-pages="pageCount = $event"
         @page-loaded="currentPage = $event"
    />
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
        src: null,
        currentPage: 0,
        pageCount: 0,
      }
    },
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
