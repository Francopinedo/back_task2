<style>

   .uk-width-1-3 a{ word-wrap: break-word; font-size: 14px!important; }
    .uk-width-1-2 a {
        word-wrap: break-word;
        font-size: 14px !important;
    }

    .uk-width-2-3 a {
        word-wrap: break-word;
        float: left;
        font-size: 14px !important;
    }

    .template-upload {
        background: transparent !important;
    }
    .template-download {
        background: transparent !important;
    }

    .floatButton1
    {
        position: fixed;
        top: 50px;
        right: 500px;
        z-index: 100;
    }

    .floatButton2
    {
        position: fixed;
        top: 50px;
        right: 350px;
        z-index: 100;
    }

    .floatButton3
    {
        position: fixed;
        top: 50px;
        right: 200px;
        z-index: 100;
    }

    .floatButton4
    {
        position: fixed;
        top: 50px;
        right: 50px;
        z-index: 100;
    }

    .modal-body
    {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
</style>
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

<script   src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> --}} <!-- TODO mejora Tooltips -->
<script src="{{asset('bower_components/parsleyjs/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>




<link rel="stylesheet" href="{{ asset('jQuery-File-Upload-master/css/jquery.fileupload.css') }}">
<link rel="stylesheet" href="{{ asset('jQuery-File-Upload-master/css/jquery.fileupload-ui.css') }}">

<div class="md-card-content">
    <div id="form">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1 uk-row-first">
                
                <form id="fileupload" action="catalog/uploadfile" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <!-- Lenguaje del sistema | oculto -->                        
                    <div class="uk-form-row" style="display: none;">
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1 uk-row-first">
                                <div class="uk-input-group uk-width-medium-1">
                                    <select name="language" id="language" data-md-selectize>
                                        <option value="{{strtoupper(app()->getLocale())}}">{{strtoupper(app()->getLocale())}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- -------------------------------------------------------- -->
                    <!-- Manual o Automatico | nontagged o tagged -->
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1 uk-row-first">
                                <div class="uk-input-group uk-width-medium-1">
                                    {{-- <span class="uk-input-group-addon">
                                        <i class="fa fa-building-o fa-15"></i>
                                    </span> --}}
                                    <select name="dataType" id="option" data-md-selectize>
                                        
                                        <option value="">{{ __('catalog.option') }}...</option>
                                        @if(!empty($type))
                                            <option value="1" selected> Manual</option>
                                        @endif
                                        <option value="1" > Manual</option>
                                        <option value="2"> Automatic</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--------------------------------------------------->
                    <!-- Directorio de Grupo de Procesos -->
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1 uk-row-first">
                                <div class="uk-input-group uk-width-medium-1 process_group">
                                    <select name="directory" id="directory" data-md-selectize>
                                        <option value="">{{ __('catalog.directory') }}...</option>
                                        @if(isset($directories))
                                            @foreach($directories as $directory)
                                                <option value="{{ $directory->path }}">{{ $directory->nombre }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---------------------------------------------------------->
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1 uk-row-first">
                                <div class="uk-input-group uk-width-medium-1 uk-grid" data-uk-grid-margin  id="documents">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-form-row hidden" id="upload_file_div">
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1 uk-row-first">

                                <label>{{ __('catalog.document') }}</label>

                                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                <noscript><input type="hidden" name="redirect" value="{{ asset('jQuery-File-Upload-master')}}"></noscript>
                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                <div class="row fileupload-buttonbar">
                                    <div class="col-lg-7">
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        <span title="{{__('catalog.add_file_tooltip')}}" class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>{{__('catalog.add_file')}}</span>
                                            <input type="file" name="document" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" multiple>
                                        </span>
                                        <button title="{{__('catalog.start_upload_tooltip')}}" type="submit" class="btn btn-primary start">
                                            <i class="glyphicon glyphicon-upload"></i>
                                            <span>{{__('catalog.start_upload')}}</span>
                                        </button>
                                        <button title="{{__('catalog.cancel_upload_tooltip')}}" type="reset" class="btn btn-warning cancel">
                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                            <span>{{__('catalog.cancel_upload')}}</span>
                                        </button>

                                        <!-- The global file processing state -->
                                        <span class="fileupload-process"></span>
                                    </div>
                                    <!-- The global progress state -->
                                    <div class="col-lg-5 fileupload-progress fade">
                                        <!-- The global progress bar -->
                                        <div class="progress progress-striped active" role="progressbar"aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                        </div>
                                        <!-- The extended global progress state -->
                                        <div class="progress-extended">&nbsp;</div>
                                    </div>
                                </div>
                                <table role="presentation" class="table table-striped">
                                    <tbody class="files"></tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8" id="canvasContainer" style="display:none;">
            <div id="loading" style="text-align:center;"></div>

            <div id="canvas"></div>
            <div id="error-message" style="display:none;" class="alert alert-danger alert-dismissible" role="alert"></div>
        </div>
        <div class="col-3">
            <form method="POST" action="/repository/store" id="dataForm">
                {{ csrf_field() }}
                <div id="label_generation" style="display:none;">
                    <label>{{ __('metadocuments.document') }}</label>
                </div>
                <div id="metavariables" style="display:none;"></div>
                <div id="metagrids" style="display:none;"></div>
            </form>
        </div>
    </div>

    {{-- </div> --}}
</div>

<!-- Modal para enviar por correo -->
<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="color:black;">
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
                    <label>{{ __('emails.subject')  }}</label>
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

<!-- Modal para preview -->
<div class="modal fade" id="modalPreview" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="color:black;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('metadocuments.document_preview') }}</h4>
            </div>
            <div class="modal-body" id="doc_preview">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('metadocuments.close_modal') }}</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')



    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
       <!-- <td>
            <span class="preview"></span>
        </td>-->
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button title="{{__('catalog.start_upload_tooltip')}}" class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>{{__('catalog.start')}}</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button title="{{__('catalog.cancel_upload_tooltip')}}" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>{{__('catalog.cancel')}}</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}


    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}


    </script>


    <script src="{{ asset('JavaScript-Templates/tmpl.min.js') }}"></script>
    <script src="{{ asset('jQuery-File-Upload-master/js/vendor/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('jQuery-File-Upload-master/app.js') }}"></script>
    <script src="{{ asset('jQuery-File-Upload-master/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('jQuery-File-Upload-master/js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('jQuery-File-Upload-master/js/jquery.fileupload-process.js') }}"></script>
    <script src="{{ asset('jQuery-File-Upload-master/js/jquery.fileupload-validate.js') }}"></script>
    <script src="{{ asset('jQuery-File-Upload-master/js/jquery.fileupload-ui.js') }}"></script>
    <!-- <script src="jQuery-File-Upload-master/js/jquery.fileupload-image.js"></script>-->
    <!-- <script src="jQuery-File-Upload-master/js/main.js"></script>-->
      {{-- <script type="text/javascript" src="https://cdn.rawgit.com/google/closure-library/97e8a0c0fc7238a56cc4dacd4a96fd4c0735b992/closure/goog/base.js"></script> --}}
    {{-- <script src="{{ asset('js/documentviewing-paged-webodf.js') }}" type="text/javascript" charset="utf-8"></script> --}}
    {{-- <script src="{{ asset('js/boot.js') }}" type="text/javascript" charset="utf-8"></script> --}}

    <script src="{{ asset('js/catalog.js') }}"></script>
     <script src="{{ asset('js/doc_generation.js') }}"></script>
    <script type="text/javascript">

        DocGen.init('<?php echo e(strtoupper(app()->getLocale())); ?>', '<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
        
        Catalog.init('<?php echo e(strtoupper(app()->getLocale())); ?>', '<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>','{{$type}}','{{$dir}}');

        Catalog.useDirectory('<?php echo e(strtoupper(app()->getLocale())) ?>', '{{$type}}','{{$dir}}');

        Catalog.useDirectory('<?php echo e(strtoupper(app()->getLocale())) ?>', '{{$type}}','{{$dir}}');



    </script>

@endsection
