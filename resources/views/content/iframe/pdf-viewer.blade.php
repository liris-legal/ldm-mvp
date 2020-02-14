<!DOCTYPE html>
<head>
    <meta charset="utf-8">
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="height=device-height,width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,minimal-ui"/>
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/hammer.min.js')}}"></script>
    <title>PDF Viewer</title>
    <style>
        .pdf-viewer {
            position: absolute;
            max-width: 100%;
            max-height: 100%;
            margin: 0 auto;
            overflow: scroll;
            touch-action: manipulation;
            scroll-behavior: smooth;
            shape-outside: none;
            -webkit-overflow-scrolling: auto;
            -moz-overflow-scrolling: auto;
            overflow-scrolling: auto;
        }
        .canvas-viewer {

        }
    </style>
</head>
<body>
<div class="content d-block">
    <div class="pdf-viewer">
        <div class="canvas-viewer" id="canvas-viewer"></div>
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
            scale = window.devicePixelRatio; // レティナでこの値を1にするとぼやけたcanvasになります

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function(page) {
                var canvasId = 'canvas-id-' + num;
                $('#canvas-viewer').append($('<canvas/>', {'id': canvasId}));
                var canvas = document.getElementById(canvasId),
                    ctx = canvas.getContext('2d');

                // メモリ上における実際のサイズを設定(ピクセル密度の分だけ倍増させます)。
                var viewport = page.getViewport({scale: scale});
                canvas.width = viewport.width * scale;
                canvas.height = viewport.height * scale;
                canvas.style.width = viewport.width + 'px'; // Note: The px unit is required here
                canvas.style.height = viewport.height + 'px';

                // CSS上のピクセル数を前提としているシステムに合わせます。
                ctx.scale(scale, scale);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

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

        // zoomIn
        var zoomIn = function() {
            scale = scale + 0.25;
            renderPage(pageNum);
        };

        // zoomOut
        var zoomOut = function() {
            if (scale <= 0.25) return;
            scale = scale - 0.25;
            renderPage(pageNum);
        };


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
    <script type="text/javascript">
        var element = document.getElementById('canvas-viewer');
        var canvasElement = document.getElementById('canvas-id-1');
        var options = {
            preventDefault: true,
            minZoom: 1,
            maxZoom: 10,
        };
        var hammertime = new Hammer(element, options);
        hammertime.on("dragup dragdown swipeup swipedown", function(ev){
            console.log('disable dragup dragdown swipeup swipedown')
        });

        hammertime.get('pinch').set({ enable: true });
        hammertime.get('pan').set({ threshold: 0 });

        var fixHammerjsDeltaIssue = undefined;
        var pinchStart = { x: undefined, y: undefined };
        var lastEvent = undefined;

        var originalSize = {
            width: window.innerWidth,
            height: window.innerHeight
        };

        var current = {
            x: 0,
            y: 0,
            z: 1,
            zooming: false,
            width: originalSize.width * 1,
            height: originalSize.height * 1,
        };
        console.log(current);

        var last = {
            x: current.x,
            y: current.y,
            z: current.z
        };
        console.log(last);

        function getRelativePosition(element, point, originalSize, scale) {
            var domCoords = getCoords(element);
            console.log(domCoords)

            var elementX = point.x - domCoords.x;
            var elementY = point.y - domCoords.y;

            var relativeX = elementX / (originalSize.width * scale / 2) - 1;
            var relativeY = elementY / (originalSize.height * scale / 2) - 1;
            return { x: relativeX < 0 ? 0 : relativeX , y: relativeY < 0 ? 0 : relativeY }
        }

        function getCoords(elem) { // crossbrowser version
            var box = elem.getBoundingClientRect();

            var body = document.body;
            var docEl = document.documentElement;

            var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
            var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

            var clientTop = docEl.clientTop || body.clientTop || 0;
            var clientLeft = docEl.clientLeft || body.clientLeft || 0;

            var top  = box.top +  scrollTop - clientTop;
            var left = box.left + scrollLeft - clientLeft;

            return { x: left < 0 ? 0 : Math.round(left), y: top < 0 ? 0 : Math.round(top) };
        }

        function scaleFrom(zoomOrigin, currentScale, newScale) {
            var currentShift = getCoordinateShiftDueToScale(originalSize, currentScale);
            var newShift = getCoordinateShiftDueToScale(originalSize, newScale)

            var zoomDistance = newScale - currentScale

            var shift = {
                x: currentShift.x - newShift.x,
                y: currentShift.y - newShift.y,
            }

            var output = {
                x: zoomOrigin.x * shift.x,
                y: zoomOrigin.y * shift.y,
                z: zoomDistance
            }
            // console.log(output)
            return output
        }

        function getCoordinateShiftDueToScale(size, scale){
            var newWidth = scale * size.width;
            var newHeight = scale * size.height;
            var dx = (newWidth - size.width) / 2;
            var dy = (newHeight - size.height) / 2;
            return {
                x: dx,
                y: dy
            }
        }

        hammertime.on('doubletap', function(e) {
            console.log('doubletap')
            var scaleFactor = 1;
            if (current.zooming === false) {
                current.zooming = true;
            } else {
                current.zooming = false;
                scaleFactor = -scaleFactor;
            }

            element.style.transition = "0.3s";
            setTimeout(function() {
                element.style.transition = "none";
            }, 300)

            var zoomOrigin = getRelativePosition(element, { x: e.center.x, y: e.center.y }, originalSize, current.z);
            var d = scaleFrom(zoomOrigin, current.z, current.z + scaleFactor)
            current.x += d.x;
            current.y += d.y;
            current.z += d.z;

            last.x = current.x;
            last.y = current.y;
            last.z = current.z;

            update();
        })

        // touch event
        hammertime.on('pan', function(e) {
            // console.log(e)
            if (lastEvent !== 'pan') {
                fixHammerjsDeltaIssue = {
                    x: e.deltaX,
                    y: e.deltaY
                }
            }

            current.x = last.x + e.deltaX - fixHammerjsDeltaIssue.x;
            current.y = last.y + e.deltaY - fixHammerjsDeltaIssue.y;
            lastEvent = 'pan';
            update();
        })

        hammertime.on('pinch', function(e) {
            // console.log(e)
            var d = scaleFrom(pinchZoomOrigin, last.z, last.z * e.scale);
            current.x = d.x + last.x + e.deltaX;
            current.y = d.y + last.y + e.deltaY;
            current.z = d.z + last.z;
            lastEvent = 'pinch';
            update();
        })

        var pinchZoomOrigin = undefined;
        hammertime.on('pinchstart', function(e) {
            // console.log(e)
            pinchStart.x = e.center.x;
            pinchStart.y = e.center.y;
            pinchZoomOrigin = getRelativePosition(element, { x: pinchStart.x, y: pinchStart.y }, originalSize, current.z);
            lastEvent = 'pinchstart';
        })

        hammertime.on('panend', function(e) {
            last.x = current.x;
            last.y = current.y;
            lastEvent = 'panend';
        })

        hammertime.on('pinchend', function(e) {
            last.x = current.x;
            last.y = current.y;
            // last.z = current.z;
            lastEvent = 'pinchend';
        })

        function update() {
            // console.log(current);
            // console.log(originalSize)

            current.height = Math.abs(current.height) < originalSize.height ? Math.abs(current.height) : originalSize.height;
            current.width = Math.abs(current.width) < originalSize.width ? Math.abs(current.width) : originalSize.width;

            current.height = originalSize.height * current.z;
            current.width = originalSize.width * current.z;
            current.z = 1;
            element.style.transform = "translate3d(" + current.x + "px, " + current.y + "px, 0) scale(" + current.z + ")";
        }
    </script>
</div>
</body>
