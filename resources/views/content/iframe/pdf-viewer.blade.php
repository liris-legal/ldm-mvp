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
        // Constants
        var ZOOM_SPEED_COEFFICIENT = 0.7;

        // Loaded via <script> tag, create shortcut to access PDF.js exports.
        var pdfjsLib = window['pdfjs-dist/build/pdf'];

        // The workerSrc property shall be specified.
        pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

        // If absolute URL from the remote server is provided, configure the CORS
        // header on that server.
        var src = $('input[name=file-src]').val();
        var pdfDoc = null,
            totalPages = 1,
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
                window.width = viewport.width;
                window.height = viewport.height;

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
                    // console.log('rendered, ', canvas);

                    // intialize hammer.js only after the all canvas is created.
                    if( num === totalPages){
                        initHammerJs(document.getElementById('canvas-viewer'));
                    }

                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });

                // intialize hammer.js only after the inner canvas is created.
                // initHammerJs(canvas);
            });
        }

        // Asynchronous download of PDF
        var loadingTask = pdfjsLib.getDocument(src);
        loadingTask.promise.then(function(pdfDoc_) {
            // console.log('PDF loaded');
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

        /**
         * Global variables for hammer.js
         */
        var hammertime = null;
        var element = null;
        var fixHammerjsDeltaIssue = undefined;
        var pinchStart = { x: undefined, y: undefined };
        var lastEvent = undefined;
        var originalSize = {
            width: null,
            height: null,
        };
        var current = {
            x: 0,
            y: 0,
            z: 1,
            zooming: false,
            width: null,
            height: null,
        };
        var last = {
            x: current.x,
            y: current.y,
            z: current.z
        };
        var pinchZoomOrigin = undefined;

        /**
         *  Initializes the hammer js
         * @param elm Element to initialize hammer.js
         */
        function initHammerJs(elm) {
            // var element = document.getElementById('canvas-viewer');
            // var canvasElement = document.getElementById('canvas-id-1');
            // console.log('canvas width:' + elm.offsetWidth);
            // console.log('canvas height:' + elm.offsetHeight);
            element = elm;
            var options = {
                preventDefault: true,
                minZoom: 1,
                maxZoom: 10,
            };
            hammertime = new Hammer(elm, options);

            originalSize.width = elm.offsetWidth,
            originalSize.height = elm.offsetHeight,
            current.width = elm.offsetWidth,
            current.height = elm.offsetHeight,

            // Set hammer js events
            hammertime.on("dragup dragdown swipeup swipedown", function(ev){
                // console.log('disable dragup dragdown swipeup swipedown')
            });
            hammertime.get('pinch').set({ enable: true });
            hammertime.get('pan').set({ threshold: 0 });
            hammertime.on('doubletap', function(e) {
                handleDoubletap(e);
            })
            hammertime.on('pan', function(e) {
                handlePan(e);
            })
            hammertime.on('pinch', function(e) {
                handlePinch(e);
            })
            hammertime.on('pinchstart', function(e) {
                handlePinchstart(e);
            })
            hammertime.on('panend', function(e) {
                handlePanend(e);
            })

            hammertime.on('pinchend', function(e) {
                handlePinchend(e);
            })
        }


        /**
         * Get the actual center of the pdf file not the center of the outer frame.
         * @param x X coordinate of the outer frame
         * @param y Y coordinate of the outer frame
         * @return map containing x and y coordinate
         */
        function convertToActualCenter(x, y) {
            var position = {};
            // Get the offset due to the zoom
            var zoomDx = (originalSize.width - (originalSize.width * current.z)) / 2;
            var zoomDy = (originalSize.height - (originalSize.height * current.z)) / 2;
            // Adjust with offset from scroll and zoom.
            position.x = x - current.x - zoomDx;
            position.y = y - current.y - zoomDy;
            return position;
        }

        /**
         * Handles pinchend event from hammer.js
         * @param e Event
         */
         function handlePinchend(e) {
            last.x = current.x;
            last.y = current.y;
            last.z = current.z;
            lastEvent = 'pinchend';
        }

        /**
         * Handles panend event from hammer.js
         * @param e Event
         */
        function handlePanend(e) {
            last.x = current.x;
            last.y = current.y;
            lastEvent = 'panend';
        }

        /**
         * Handles pinch start event from hammer.js
         * @param e Event
         */
        function handlePinchstart(e) {
            // console.log('e.center.x: ' + e.center.x + ' & e.center.y: ' + e.center.y)
            // console.log('e: ' + e)

            var actualCenter = convertToActualCenter(e.center.x, e.center.y);
            pinchStart.x = actualCenter.x;
            pinchStart.y = actualCenter.y;

            // console.log('pinchStart.x: ' + pinchStart.x + ' & pinchStart.y: ' + pinchStart.y)

            pinchZoomOrigin = getRelativePosition(element, { x: pinchStart.x, y: pinchStart.y }, originalSize, current.z);
            lastEvent = 'pinchstart';
        }

        /**
         * Handles pinch event from hammer.js
         * @param e Event
         */
        function handlePinch(e) {
            // console.log('e.scale: ' + e.scale); // seems scale > 1 for enlargement, < 1 for reduce size.
            // console.log('e.deltaX: ' + e.deltaX); // seems how much moved while pinch
            // console.log('e.deltaY: ' + e.deltaY); // seems how much moved while pinch
            var scale = ((e.scale - 1) * ZOOM_SPEED_COEFFICIENT) + 1;
            var d = scaleFrom(pinchZoomOrigin, last.z, last.z * scale);
            // var d = scaleFrom(pinchZoomOrigin, last.z, last.z * Math.pow(e.scale, ZOOM_SPEED_COEFFICIENT));
            current.x = d.x + last.x + e.deltaX;
            current.y = d.y + last.y + e.deltaY;
            current.z = d.z + last.z;
            lastEvent = 'pinch';
            update();
        }

        /**
         * Handles pan event from hammer.js
         * @param e Event
         */
        function handlePan(e) {
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

            // console.log('current.x: ' + current.x + ' & current.y:' + current.y);
        }

        /**
         * Handles doubletap event from hammer.js
         * @param e Event
         */
        function handleDoubletap(e) {
            // console.log('doubletap')
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
            }, 300);

            var zoomOrigin = getRelativePosition(element, { x: e.center.x, y: e.center.y }, originalSize, current.z);
            var d = scaleFrom(zoomOrigin, current.z, current.z + scaleFactor)
            current.x += d.x;
            current.y += d.y;
            current.z += d.z;

            last.x = current.x;
            last.y = current.y;
            last.z = current.z;

            update();
        }

        function getRelativePosition(element, point, originalSize, scale) {
            var domCoords = getCoords(element);
            // console.log('domCoords:' + domCoords.x + ' ' + domCoords.y);
            // console.log('domCoords.x ' + domCoords.x); // always 0
            // console.log('domCoords.y ' + domCoords.y); // always 0

            // var elementX = point.x - domCoords.x;
            // var elementY = point.y - domCoords.y;

            var elementX = point.x;
            var elementY = point.y;

            var relativeX = elementX / (originalSize.width * scale / 2) - 1;
            var relativeY = elementY / (originalSize.height * scale / 2) - 1;
            return { x: relativeX , y: relativeY }
            // return { x: relativeX < 0 ? 0 : relativeX , y: relativeY < 0 ? 0 : relativeY }
        }

        function getCoords(elem) { // crossbrowser version
            var box = elem.getBoundingClientRect();
            // console.log('box: ' +  box.top +  ' ' + box.left);

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

        function update() {
            // current.height = originalSize.height;
            // current.width = originalSize.width;
            element.style.transform = "translate3d(" + current.x + "px, " + current.y + "px, 0) scale(" + current.z + ")";
        }
    </script>
</div>
</body>
