@extends('layouts.app')

@section('section_title', __('metadocuments.doc_generation'))

@section('css')
    <link rel="stylesheet" href="/assets/css/Editor.css" media="all">
@endsection

@section('content')


<div class="row" style="margin-left:1%;">
    <div class="col-3"> 
        
        
        
        <div id="formContainer">
        <form method="POST" action="/repository/store" id="dataForm"></form>
        </div>
    </div>
    <div class="col-8" id="canvasContainer">
        <div id="loading" style="text-align:center;"></div>

        <div id="canvas"></div>
    </div>
</div>

@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdn.rawgit.com/google/closure-library/97e8a0c0fc7238a56cc4dacd4a96fd4c0735b992/closure/goog/base.js"></script>
    <script src="{{ asset('js/webodf.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/Editor.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/doc_generation.js') }}"></script>
    <script type="text/javascript">
        DocGen.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
    </script>

    <script>

        var path = '3-1-MinutaDiaria.odt',
            pos = path.indexOf('#'),
            formElement = document.getElementById('dataForm'),
            odfElement = document.getElementById('canvas'),
            odfCanvas,
            fieldEditor,
            formFieldMap,
            /**@const*/textns = "urn:oasis:names:tc:opendocument:xmlns:text:1.0";

        odfCanvas = new odf.OdfCanvas(odfElement);
        odfCanvas.load(path);

        odfCanvas.addListener("statereadychange", function () {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", 'metavariables/get_from_file/ES/3-Ejecucion/3-1-MinutaDiaria');
            xhr.onload = function (e) {
                formFieldMap = JSON.parse(xhr.response); 
                fieldEditor = new ko.fields.Editor(path, formElement, odfCanvas, formFieldMap);

                // Attach a click listener to the ODF element
                // to transfer focus when clicking on a text:user-field-get
                odfCanvas.getElement().addEventListener('click', function (event) {
                    var node = event.target;

                    while (node) {
                        if (node.namespaceURI === textns
                                && node.localName === 'user-field-get'
                                && node.hasAttributeNS(textns, 'name')) {
                            fieldEditor.focusField(node.getAttributeNS(textns, 'name'));
                        }
                        node = node.parentNode;
                    }
                });
            };
            xhr.send();
        });
    </script>

    
@endsection