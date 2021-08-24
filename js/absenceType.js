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

            var country =  "#country_id", city="#city_id";
            
            if($("#country_id2").length>0){
                country = "#country_id2";
                city = "#city_id2";
            }

            $(city).selectize();

            $(country).on('change', function () {
                $.ajax({
                    url: AbsenceType.API_PATH + '/cities',
                    type: 'GET',
                    data: {country_id: $(this).val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">City...</option>';

                        $(city).selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $(city).html(html);
                        $(city).selectize();



                    }
                );
            });


        },



    }
    return AbsenceType;
}());
