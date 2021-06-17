var companyPreference = (function () {
    'use strict';

    var companyPreference = {
        /*============================
         =            init            =
         ============================*/
        init: function () {
            var self = this;

            if ($('#upload_widget_opener').length) {


                $("#logo_path").on('change', function (event) {


                    var file = event.originalEvent.srcElement.files[0];

                    var reader = new FileReader();

                    console.log(file);
                    reader.onload = function (e) {
                        $('#logo_path')
                            .attr('src', e.target.result)
                            .width(150)
                            .height(200);
                    };

                    reader.readAsDataURL(file);

                })


            }

            var form = $('#preferences-form');
            $('#save-preferences').on('click', function (e) {
                form.submit();
            });

            $(form).submit(function (event) {
                var formdata = new FormData(form.get(0));
                event.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formdata,
                    dataType: 'json',
                    processData: false, //For posting uploaded files we add this
                    contentType: false, //For posting uploaded files we add this
                    success: function (json) {
                        window.location.replace(form.data('redirect-on-success'));
                    },
                    error: function (json) {
                        if (json.status === 422) {
                            var errors = json.responseJSON;
                            $.each(json.responseJSON, function (key, value) {
                                $('#' + key + '-error').html(value);
                            });
                        } else {
                            // Error
                        }
                    }
                });
            });

        },
        /*==========================================
         =            uploadProfilePhoto            =
         ==========================================*/
        uploadProfilePhoto: function (path) {
            var self = this;

            $.ajax({
                url: API_PATH + 'companies/' + company[id],
                type: 'PATCH',
                data: {'logo_path': path},
                dataType: 'json',
                success: function (json) {
                    // Do something like redirect them to the dashboard...
                    self.changeProfilePhoto(path);
                },
                error: function (json) {
                    if (json.status === 422) {
                        var errors = json.responseJSON;
                        $.each(json.responseJSON, function (key, value) {
                            $('#' + key + '-error').html(value);
                        });
                    } else {
                        // Error
                    }
                }
            });
        },
        changeProfilePhoto: function (path) {


            console.log($('#logo_path').attr('src'));
        }
    };

    return companyPreference;
}());
