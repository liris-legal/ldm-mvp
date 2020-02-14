<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="height=device-height,width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,minimal-ui"/>
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/hammer.min.js')}}"></script>
    <title>PDF Viewer</title>
    <style>
        .pdf-viewer {
            /*position: absolute;*/
            max-width: 100%;
            max-height: 100%;
            margin: 0 auto;
            text-align: center;
            overflow: scroll;
            touch-action: manipulation;
            scroll-behavior: smooth;
            shape-outside: none;
            -webkit-overflow-scrolling: auto;
            -moz-overflow-scrolling: auto;
            overflow-scrolling: auto;
        }
    </style>
</head>
<body>
    <div class="pdf-viewer">
        <embed src="https://drive.google.com/viewerng/viewer?embedded=true&url={{$src}}" width="735" height="600">
    </div>
</body>
