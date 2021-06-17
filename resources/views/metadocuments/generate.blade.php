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
        
        <div id="form">
            @include('metadocuments.form_document')
        </div>
        <div id="metavariables" style="display:none;">
        </div>
        <div id="metagrids" style="display:none;">
        </div>
        </form>
    </div>
</div>

<!-- Modal para enviar por correo -->
<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('metadocuments.send_by_mail') }}</h4>
                </div>
                <div class="modal-body">
                <form method="POST" action="/repository/send_by_mail">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div id="email_filename"></div>
                    <div class="uk-form-row">
                        <label>{{ __('emails.to') }}</label>
                        <input type="email" class="form-control" name="to" required></input>
                    </div>

                    <div class="uk-form-row">
                        <label>{{ __('emails.cc') }}</label>
                        <input type="text" class="form-control" name="cc"></input>
                    </div>

                    <div class="uk-form-row">
                        <label>{{ __('emails.subject') }}</label>
                        <input type="text" class="form-control" name="subject" required></input>
                    </div>
                    <div class="uk-form-row">
                        <label>{{ __('emails.message') }}</label>
                        <textarea rows="5" class="form-control" name="message" id="tinymce" required></textarea>
                    </div>

                    <div class="uk-form-row col-sm-12">
                        <button type="submit" class="btn btn-success">{{ __('emails.send') }}</button>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('metadocuments.close_modal') }}</button>
                </div>
            </div>
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