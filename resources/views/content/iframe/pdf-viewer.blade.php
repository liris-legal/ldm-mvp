<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <title>PDF Viewer</title>
</head>
<body>
<div class="content d-block">
    <div style="width:100vh;margin: 0 auto">
        <div id="pdf-viewer"></div>
        <div>
            <h2 class="message"></h2>
        </div>
    </div>

    <input type="hidden" name="file-src" value="{{$src}}">

    <script !src="">
        // Loaded via <script> tag, create shortcut to access PDF.js exports.
        var pdfjsLib = window['pdfjs-dist/build/pdf'];

        // The workerSrc property shall be specified.
        pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

        // If absolute URL from the remote server is provided, configure the CORS
        // header on that server.
        var src = $('input[name=file-src]').val();
        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1;

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function(page) {
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
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });
        }

        // Asynchronous download of PDF
        var loadingTask = pdfjsLib.getDocument(src);
        loadingTask.promise.then(function(pdfDoc_) {
            console.log('PDF loaded');
            pdfDoc = pdfDoc_;

            // Initial/first page rendering
            for (var i = 1; i <= pdfDoc.numPages; i++) {
                renderPage(i);
            }
        }, function (reason) {
            // PDF loading error
            console.error(reason);
            $('.message')[0].innerText = "ERROR: " + reason.message;
        });
    </script>
</div>
</body>
