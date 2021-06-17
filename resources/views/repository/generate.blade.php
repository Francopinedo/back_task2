@extends('layouts.app')

@section('section_title', __('metadocuments.doc_generation'))

@section('css')
    <link rel="stylesheet" href="/assets/css/Editor.css" media="all">
@endsection

@section('content')


<div class="row" style="margin-left:1%;">
    <div class="col-8" id="canvasContainer" style="display:none;">
        <div id="loading" style="text-align:center;"></div>

        <div id="canvas"></div>
        <div id="error-message" style="display:none;" class="alert alert-danger alert-dismissible" role="alert"></div>
    </div>
    <div class="col-3"> 
        <form method="POST" action="/repository/store" id="dataForm">
        {{ csrf_field() }}
        
        <div id="formContainer">
            @include('metadocuments.form_document')
        </div>
        <div id="metavariables" style="display:none;">
        </div>
        <div id="metagrids" style="display:none;">
        </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdn.rawgit.com/google/closure-library/97e8a0c0fc7238a56cc4dacd4a96fd4c0735b992/closure/goog/base.js"></script>
    <script src="{{ asset('js/documentviewing-paged-webodf.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/boot.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/doc_generation.js') }}"></script>
    <script type="text/javascript">
        DocGen.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
    </script>
@endsection