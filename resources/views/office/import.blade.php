<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
        <div class="uk-alert uk-alert-info  status_code-error" data-uk-alert="">{{__('general.import_instructions')}} title, city, workinghours_from, workinghours_to, real_working_hours,effective_workinghours
        </div>
        <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('offices/do_import') }}"
              id="data-form-import" data-redirect-on-success="{{ url('offices') }}">
            {{ csrf_field() }}

            <div class="uk-width-medium-1-1 uk-row-first">
                <label>{{ __('offices.file') }}</label>
                <div class="md-input-wrapper md-input-filled">

                    <input type="file" accept="text/csv" name="file"><span class="md-input-bar"></span>
                    <div class="parsley-errors-list filled"><span class="parsley-required file-error"></span></div>
                </div>

                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="upload-btn">{{ __('offices.import') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
    $('.cancel-edit-btn').on('click', function (e) {
        e.preventDefault();
        $('#ajax_create_div_toggle').hide();
        $('#ajax_create_div').removeClass('switcher_active');
    });
    var form = $('#data-form-import');

    $('#upload-btn').click(function () {
        form.submit();
    });

    form.on('submit', function (e) {
        var formData = new FormData($(this)[0]);

        e.preventDefault();
        $.ajax({
            url: 'offices/do_import',
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                //  alert(data)
                window.location.replace(form.data('redirect-on-success'));
            },
            error:function (json) {
                if(json.status === 422) {
                    var errors = json.responseJSON;
                    $.each(json.responseJSON, function (key, value) {
                        $('.'+key+'-error').html(value);

                    });
                } else {
                    // Error
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });
</script>
