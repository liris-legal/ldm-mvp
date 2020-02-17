<template>
  <div v-if="src">
    <iframe
      name="iframe"
      :src="'/iframe/lawsuits/'+document.lawsuit_id+'/documents/'+document.id"
      width="100%"
      height="100%"
      frameborder="0"
      style="height: 67vh;"
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
  export default {
    name: "PdfViewer",
    props: {
      document: {required: true, type: Object, default: () => {}},
    },
    data() {
      return {
        src: null,
      }
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
