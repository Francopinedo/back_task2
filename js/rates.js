var Rates = (function () {
    'use strict';

    var Rates = {

        APP_URL: '',
        API_PATH: '',

        init: function (API_PATH, APP_URL) {

            Rates.APP_URL = APP_URL;
            Rates.API_PATH = API_PATH;

            Rates.events();


        },

        events: function () {


            $('#country_id').selectize();
            $('#country_id2').selectize();

            $("#country_id, #country_id2").on('change', function () {



                if ($('#city_id2').length > 0) {
                    $('#city_id2').selectize()[0].selectize.destroy();
                }

                if ($('#office_id2').length > 0) {
                    $('#office_id2').selectize()[0].selectize.destroy();
                }
                $('#city_id').selectize()[0].selectize.destroy();
                $('#office_id').selectize()[0].selectize.destroy();


                $('#city_id').html('');
                $('#city_id2').html('');

                $('#office_id').html('<option value="">Office...</option>');
                $('#office_id2').html('<option value="">Office...</option>');



                console.log('chage....');
                $.ajax({
                    url: Rates.API_PATH + '/cities',
                    type: 'GET',
                    data: {country_id: $(this).val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">City...</option>';


                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $('#city_id').html(html);
                        $('#city_id2').html(html);

                        $('#city_id').selectize();
                        $('#city_id2').selectize();

                        $('#office_id2').selectize();
                        $('#office_id').selectize();

                    }
                );
            });


            $('#office_id').selectize();
            $('#office_id2').selectize();

            $("#city_id, #city_id2").on('change', function () {
                console.log('chage....');

                $('#office_id').html('');
                $('#office_id2').html('');


                $.ajax({
                    url: Rates.API_PATH + '/offices',
                    type: 'GET',
                    data: {city_id: $(this).val(), company_id: $("#company_id").val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">Office...</option>';
                        if ($('#office_id2').length > 0) {
                            $('#office_id2').selectize()[0].selectize.destroy();
                        }

                        $('#office_id').selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.title + '</option>';
                        });

                        $('#office_id2').html(html);
                        $('#office_id').html(html);


                        $('#office_id2').selectize();
                        $('#office_id').selectize();


                    }
                );
            });


        }

    };

    return Rates;
}());