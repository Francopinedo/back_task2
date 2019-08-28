<style>


    #edit_div.switcher_active {
        width: 600px;
    }

    .uk-width-medium-1-2 {
        padding: 5px
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('bower_components/parsleyjs/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('jQuery-File-Upload-master/css/jquery.fileupload.css')}}">
<link rel="stylesheet" href="{{ asset('jQuery-File-Upload-master/css/jquery.fileupload-ui.css')}}">
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
        <form role="form" method="POST" id="upload-form-edit" action="{{ url('tickets/uploadfile') }}"
              enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{ $ticket->id }}">
            <input type="hidden" name="last_updater_id" value="{{ Auth::id() }}">


            <div class="uk-width-1-1">


                <div class="uk-width-1-1 uk-row-first">


                    <div class="uk-alert uk-alert-success hidden" data-uk-alert="" id="success-div">
                        <a href="#" class="uk-alert-close uk-close" id="success-message"></a>
                        Document has been uploaded
                    </div>


                </div>
                <div class="uk-width-1-1">


                    {{ csrf_field() }}

                    <input type="hidden" name="tc" id="" value="{{$project->id}}">
                    <input type="hidden" name="project" id="" value="{{$project->id}}">
                    <input type="hidden" name="customer" id="" value="{{$project->customer_id}}">
                    <input type="hidden" name="directory" id="directory_form" value="">
                    <label>{{ __('catalog.document') }}</label>

                    <!-- Redirect browsers with JavaScript disabled to the origin page -->

                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="row fileupload-buttonbar">
                        <div class="col-lg-12">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="document[]" accept="pplication/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" multiple>


                </span>
                            <button type="submit" class="btn btn-primary start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start upload</span>
                            </button>
                            <button type="reset" class="btn btn-warning cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Cancel upload</span>
                            </button>
                            <div class="parsley-errors-list filled"><span
                                        class="parsley-required document-error"></span></div>
                            <!-- The global file processing state -->
                            <span class="fileupload-process"></span>

                        </div>
                        <!-- The global progress state -->
                        <div class="col-lg-12 fileupload-progress fade">
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


                </div>


            </div>

            <div class="uk-grid">
                <div class="uk-width-medium-1-1">
                    <div class="uk-form-row">

                        <div class="uk-grid" data-uk-grid-margin="10">
                            <div class="uk-width-medium-1 uk-row-first">

                                <div class="uk-input-group uk-width-medium-1 uk-grid" data-uk-grid-margin
                                     id="documents">

                                    @foreach($documentos as $documento)
                                        @php $documento2 = explode('/', $documento); @endphp
                                        <a href="{{url('repository/download/?file='.$documento)}}">{{$documento2[4]}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="uk-width-medium-1-1 uk-pading-left">
                <div class="uk-margin-medium-top">

                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>


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

<script src="{{ asset('jQuery-File-Upload-master/js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{ asset('jQuery-File-Upload-master/app.js')}}"></script>
<script src="{{ asset('jQuery-File-Upload-master/js/jquery.iframe-transport.js')}}"></script>
<script src="{{ asset('jQuery-File-Upload-master/js/jquery.fileupload.js')}}"></script>
<script src="{{ asset('jQuery-File-Upload-master/js/jquery.fileupload-process.js')}}"></script>
<script src="{{ asset('jQuery-File-Upload-master/js/jquery.fileupload-validate.js')}}"></script>
<script src="{{ asset('jQuery-File-Upload-master/js/jquery.fileupload-ui.js')}}"></script>
<script type="text/javascript">

    $('.cancel-edit-btn').on('click', function (e) {
        e.preventDefault();
        $('#edit_div_toggle').hide();
        $('#edit_div').removeClass('switcher_active');
    });


    //  tableActions.initEditForm();
    $('#upload-form-edit').fileupload({
        dataType: 'json',

        done: function (e, data) {
            data.context.html('Upload finished.');

            //Repository.searchDocuments($("#upload-form-edit").val());
        }
    });

</script>
<!-- <script src="jQuery-File-Upload-master/js/jquery.fileupload-image.js"></script>-->
