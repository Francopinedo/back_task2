/**
 * Created by Giuseppe on 21/02/2018.
 */




var AbsenceType = (function () {
    'use strict';

    var AbsenceType = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            AbsenceType.APP_URL = APP_URL;
            AbsenceType.API_PATH = API_PATH;

        },

        selectsize : '',

        events: function () {


            // $('#city_id').selectize();
            // $('#city_id2').selectize();

            $("#country_id2").on('change', function () {
                console.log('chage....');
                $.ajax({
                    url: AbsenceType.API_PATH + '/cities',
                    type: 'GET',
                    data: {country_id: $(this).val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">Country...</option>';

                        $('#city_id2').selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $('#city_id2').html(html);
                        $('#city_id2').selectize();



                    }
                );
            });


        },



    }
    return AbsenceType;
}());
