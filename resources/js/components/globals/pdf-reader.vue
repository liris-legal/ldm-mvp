<template>
  <div class="content d-block" style="margin: 4em">
    <div style="width:650px;height:600px;overflow-y:scroll;margin: 0 auto">
      <div id="pdf-viewer"></div>
    </div>
  </div>
</template>

<script>
  // import pdfjsLib from '../../libs/pdf'
  var pdfjsLib = require("pdfjs-dist");
  import pdf from 'pdfjs'

  export default {
    name: "pdf-reader",
    data () {
      return {
        src: 'https://raw.githubusercontent.com/thaild/1LinkIntern/3d3d31045997a1b678cabfde931545375a75fef3/1link/book.pdf',
        pdfDoc: null,
        pageNum: 1,
        pageRendering: false,
        pageNumPending: null,
        scale: 0.8,
        page: 1,
        numPages: 0,
        errors: [],
      }
    },
    computed: {

    },
    mounted () {
      console.log('pdf-reader mounted');

      // Loaded via <script> tag, create shortcut to access PDF.js exports.
      var pdfjsLib = window['pdfjs-dist/build/pdf'];

      // The workerSrc property shall be specified.
      pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

      // Asynchronous download of PDF
      pdfjsLib.getDocument(this.src).promise.then(function(pdfDoc_) {
        this.pdfDoc = pdfDoc_;
        console.log(this.pdfDoc)

        // Initial/first page rendering
        // renderPage2(pageNum);
        for (var i = 1; i <= this.pdfDoc.numPages; i++) {
          this.renderPage(i);
        }
      });
    },
    watch: {

    },
    methods: {
      renderPage(num) {
        this.pageRendering = true;
        // Using promise to fetch the page
        console.log(this.pdfDoc)
        this.pdfDoc.getPage(num).then(function(page) {
          var viewport = page.getViewport({scale: scale});
          var canvasId = 'pdf-viewer-' + num;
          $('#pdf-viewer').append($('<canvas/>', {'id': canvasId}));
          var canvas = document.getElementById(canvasId),
            ctx = canvas.getContext('2d');

          canvas.height = viewport.height;
          canvas.width = viewport.width;

          // Render PDF page into canvas context
          var renderContext = {
            canvasContext: ctx,
            viewport: viewport
          };
          var renderTask = page.render(renderContext);

          // Wait for rendering to finish
          renderTask.promise.then(function() {
            this.pageRendering = false;
            if (this.pageNumPending !== null) {
              // New page rendering is pending
              renderPage(this.pageNumPending);
              this.pageNumPending = null;
            }
          });
        });

        // Update page counters
        document.getElementById('page_num').textContent = num;
      }
    }
  }
</script>

<style lang="css" scoped>
  #buttons {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }
  /* Page content */
  .content {
    padding: 16px;
  }
</style>
