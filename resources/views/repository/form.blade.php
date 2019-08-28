<style>

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

    .template-download {
        background: transparent !important;
    }

</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="bower_components/parsleyjs/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="jQuery-File-Upload-master/css/jquery.fileupload.css">
<link rel="stylesheet" href="jQuery-File-Upload-master/css/jquery.fileupload-ui.css">

<style>
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
    }
</style>
<div class="md-card-content">


    {{ csrf_field() }}

    <input type="hidden" name="project" id="project" value="{{$project->id}}">
    <input type="hidden" name="customer" id="customer" value="{{$project->customer_id}}">
    <div class="uk-grid" data-uk-grid-margin="">
        <div class="uk-width-medium-1-1 uk-row-first">


            <div class="dropdown">
                <button class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light  dropdown-toggle "
                        type="button" data-toggle="dropdown">
                    Directory...<span class="caret"></span></button>
                <ul class="dropdown-menu">
                    @if(isset($directories))
                        @foreach($directories as $directory)

                            <li class="dropdown-submenu" data-toggle="dropdown"><a class="drop dropdown-item"
                                                                                   tabindex="-1"
                                                                                   data-nameshow="{{$directory['nombre']}}"
                                                                                   data-read="{{ (!empty($activeDirectoriesIdsRead[$companyRole->id]) && in_array($directory['id'], $activeDirectoriesIdsRead[$companyRole->id])) ? 'true' : 'false'  }}"
                                                                                   data-write="{{ (!empty($activeDirectoriesIdsWrite[$companyRole->id]) && in_array($directory['id'], $activeDirectoriesIdsWrite[$companyRole->id])) ? 'true' : 'false'  }}"
                                                                                   href="{{ $directory['path'] }}">{{ $directory['nombre'] }}
                                    <span class="caret"></span></a>

                                <ul class="dropdown-menu ">
                                    @foreach ($directory['folders'] as $folder)
                                        <li data-toggle="dropdown"
                                            class="{{count($folder['subfolders']>0)?'dropdown-submenu':''}} dropdown-item">
                                            <a class="drop {{count($folder['subfolders']>0)?'no-drop':''}}"
                                               data-read="{{ (!empty($activeDirectoriesIdsRead[$companyRole->id]) && in_array($folder['id'], $activeDirectoriesIdsRead[$companyRole->id])) ? 'true' : 'false'  }}"
                                               data-write="{{ (!empty($activeDirectoriesIdsWrite[$companyRole->id]) && in_array($folder['id'], $activeDirectoriesIdsWrite[$companyRole->id])) ? 'true' : 'false'  }}"
                                               data-nameshow="{{$directory['nombre'] . "/".$folder['nombre']}}"
                                               href="{{$directory['path'] ."/".$folder['path']}}">{{$folder['nombre']}}
                                                @if(count($folder['subfolders'])>0) <span
                                                        class="caret"></span>@endif</a>
                                            <ul class="{{count($folder['subfolders'])>0?'dropdown-menu':''}}">
                                                @foreach ($folder['subfolders'] as $subfolder)
                                                    <li><a class="drop no-drop"
                                                           data-read="{{ (!empty($activeDirectoriesIdsRead[$companyRole->id]) && in_array($subfolder['id'], $activeDirectoriesIdsRead[$companyRole->id])) ? 'true' : 'false'  }}"
                                                           data-write="{{ (!empty($activeDirectoriesIdsWrite[$companyRole->id]) && in_array($subfolder['id'], $activeDirectoriesIdsWrite[$companyRole->id])) ? 'true' : 'false'  }}"
                                                           data-nameshow="{{$directory['nombre'] . "/".$folder['nombre']."/".$folder['nombre']}}"
                                                           href="{{$directory['path'] ."/".$folder['path']."/".$subfolder['path']}}">{{$subfolder['nombre']}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    @endif

                </ul>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required directory-error"></span></div>


        </div>
    </div>
    <div class="uk-width-1-1">


        <div class="uk-width-1-1 uk-row-first">


            <div class="uk-alert uk-alert-success hidden" data-uk-alert="" id="success-div">
                <a href="#" class="uk-alert-close uk-close" id="success-message"></a>
                Document has been uploaded
            </div>


        </div>
        <div class="uk-width-1-1">


            <form id="fileupload" action="repository/uploadfile" method="post" class="hidden"
                  enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="project" id="" value="{{$project->id}}">
                <input type="hidden" name="customer" id="" value="{{$project->customer_id}}">
                <input type="hidden" name="directory" id="directory_form" value="">
                <label>{{ __('catalog.document') }}</label>

                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/">
                </noscript>
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="col-lg-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="document[]" accept="pplication/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf" multiple>
                </span>
                        <button type="submit" class="btn btn-primary start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>Start upload</span>
                        </button>
                        <button type="reset" class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel upload</span>
                        </button>

                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <!-- The global progress state -->
                    <div class="col-lg-5 fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0"
                             aria-valuemax="100">
                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                        </div>
                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <table role="presentation" class="table table-striped">
                    <tbody class="files"></tbody>
                </table>

            </form>

        </div>


    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-1" style="margin-top: 20px">
            <div class="uk-form-row">
                <h4 id="dir_title"></h4>
                <div class="uk-grid" data-uk-grid-margin="50">
                    <div class="uk-width-medium-1 uk-row-first">
                        <div class="uk-alert uk-alert-danger hidden" data-uk-alert="" id="error-div">
                            <a href="#" class="uk-alert-close uk-close" id="error-message"></a>
                            You do not have permissions to see this folder
                        </div>


                        <div class="uk-input-group uk-width-medium-1 uk-grid" data-uk-grid-margin
                             id="documents">

                        </div>
                    </div>
                </div>
            </div>
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
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
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


    <script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>

    <script src="jQuery-File-Upload-master/js/vendor/jquery.ui.widget.js"></script>
    <script src="jQuery-File-Upload-master/app.js"></script>
    <script src="jQuery-File-Upload-master/js/jquery.iframe-transport.js"></script>
    <script src="jQuery-File-Upload-master/js/jquery.fileupload.js"></script>
    <script src="jQuery-File-Upload-master/js/jquery.fileupload-process.js"></script>
    <script src="jQuery-File-Upload-master/js/jquery.fileupload-validate.js"></script>
    <script src="jQuery-File-Upload-master/js/jquery.fileupload-ui.js"></script>
    <!-- <script src="jQuery-File-Upload-master/js/jquery.fileupload-image.js"></script>-->
    <!-- <script src="jQuery-File-Upload-master/js/main.js"></script>-->

    <script src="{{ asset('js/repository.js') }}"></script>
    <script type="text/javascript">

        Repository.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
    </script>


@endsection


