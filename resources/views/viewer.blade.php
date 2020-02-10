<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                position: fixed;
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100%;
                width: 100%;
                top: 0;
                left: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content d-block">
                <h1>PDF.js Previous/Next example</h1>

                <div class="row">
                    <button id="prev">Previous</button>
                    <button id="next">Next</button>
                    &nbsp; &nbsp;
                    <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                </div>

                <canvas id="the-canvas"></canvas>

                <script !src="">
                    // If absolute URL from the remote server is provided, configure the CORS
                    // header on that server.
                    var url = 'https://raw.githubusercontent.com/thaild/1LinkIntern/3d3d31045997a1b678cabfde931545375a75fef3/1link/design_pattern_tutorial.pdf';

                    // Loaded via <script> tag, create shortcut to access PDF.js exports.
                    var pdfjsLib = window['pdfjs-dist/build/pdf'];

                    // The workerSrc property shall be specified.
                    pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

                    var pdfDoc = null,
                        pageNum = 1,
                        pageRendering = false,
                        pageNumPending = null,
                        scale = 0.8,
                        canvas = document.getElementById('the-canvas'),
                        ctx = canvas.getContext('2d');

                    /**
                     * Get page info from document, resize canvas accordingly, and render page.
                     * @param num Page number.
                     */
                    function renderPage(num) {
                        pageRendering = true;
                        // Using promise to fetch the page
                        pdfDoc.getPage(num).then(function(page) {
                            var viewport = page.getViewport({scale: scale});
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

                        // Update page counters
                        document.getElementById('page_num').textContent = num;
                    }

                    /**
                     * If another page rendering in progress, waits until the rendering is
                     * finised. Otherwise, executes rendering immediately.
                     */
                    function queueRenderPage(num) {
                        if (pageRendering) {
                            pageNumPending = num;
                        } else {
                            renderPage(num);
                        }
                    }

                    /**
                     * Displays previous page.
                     */
                    function onPrevPage() {
                        if (pageNum <= 1) {
                            return;
                        }
                        pageNum--;
                        queueRenderPage(pageNum);
                    }
                    document.getElementById('prev').addEventListener('click', onPrevPage);

                    /**
                     * Displays next page.
                     */
                    function onNextPage() {
                        if (pageNum >= pdfDoc.numPages) {
                            return;
                        }
                        pageNum++;
                        queueRenderPage(pageNum);
                    }
                    document.getElementById('next').addEventListener('click', onNextPage);

                    /**
                     * Asynchronously downloads PDF.
                     */
                    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                        pdfDoc = pdfDoc_;
                        document.getElementById('page_count').textContent = pdfDoc.numPages;

                        // Initial/first page rendering
                        renderPage(pageNum);
                    });

                </script>
            </div>

        </div>
        <div class="content d-block" style="margin: 4em">

            <h1>PDF.js 'Hello, world!' example</h1>

            <div style="width:650px;height:600px;overflow-y:scroll;margin: 0 auto">
{{--                <canvas id="canvas"></canvas>--}}
                <div id="pdf-viewer"></div>

            </div>

            <script !src="">
                // If absolute URL from the remote server is provided, configure the CORS
                // header on that server.
                var book = 'https://raw.githubusercontent.com/thaild/1LinkIntern/3d3d31045997a1b678cabfde931545375a75fef3/1link/book.pdf';
                var pdfDoc2 = null,
                    pageNum = 1,
                    pageRendering = false,
                    pageNumPending = null,
                    scale = 0.8;

                /**
                 * Get page info from document, resize canvas accordingly, and render page.
                 * @param num Page number.
                 */
                function renderPage2(num) {
                    pageRendering = true;
                    // Using promise to fetch the page
                    pdfDoc2.getPage(num).then(function(page) {
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

                    // Update page counters
                    document.getElementById('page_num').textContent = num;
                }

                // Asynchronous download of PDF
                pdfjsLib.getDocument(book).promise.then(function(pdfDoc_) {
                    pdfDoc2 = pdfDoc_;

                    // Initial/first page rendering
                    // renderPage2(pageNum);
                    for (var i = 1; i <= pdfDoc2.numPages; i++) {
                        renderPage2(i);
                    }
                });
            </script>
        </div>
    </body>
</html>
