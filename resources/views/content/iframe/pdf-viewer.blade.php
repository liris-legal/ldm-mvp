<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <title>PDF Viewer</title>
    <style>
        .canvas-viewer {
            width: 100vh;
            margin: 0 auto;
            overflow: scroll;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>
<body>
<div class="content d-block">
    <div class="canvas-viewer">
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
            pageNumPending = null;

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function(page) {
                var canvasId = 'canvas-id-' + num;
                $('#pdf-viewer').append($('<canvas/>', {'id': canvasId}));
                var canvas = document.getElementById(canvasId),
                    ctx = canvas.getContext('2d');

                // メモリ上における実際のサイズを設定(ピクセル密度の分だけ倍増させます)。
                var scale = window.devicePixelRatio; // レティナでこの値を1にするとぼやけたcanvasになります
                var viewport = page.getViewport({scale: scale});
                canvas.width = viewport.width * scale;
                canvas.height = viewport.height * scale;
                canvas.style.width = viewport.width + 'px'; // Note: The px unit is required here
                canvas.style.height = viewport.height + 'px';

                // CSS上のピクセル数を前提としているシステムに合わせます。
                ctx.scale(scale, scale);

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
