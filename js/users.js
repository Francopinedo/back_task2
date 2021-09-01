/**
 * Created by Giuseppe on 21/02/2018.
 */




var Users = (function () {
    'use strict';

    var Users = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            Users.APP_URL = APP_URL;
            Users.API_PATH = API_PATH;

        },

        selectsize : '',

        events: function () {

            var country =  "#country_id", city="#city_id", office="#office_id";
            
            if($("#country_id2").length>0){
                country = "#country_id2";
                city = "#city_id2";
                office="#office_id2";
            }
            // Filtrar la ciudad dependiendo el pais
            $(city).selectize();
            $(country).on('change', function () {
                $.ajax({
                    url: Users.API_PATH + '/cities',
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
            // Filtrar la la oficina dependiendo la ciudad
            $(office).selectize();
            $(city).on('change', function () {
                var html = '<option value="">Office...</option>';
                $.ajax({
                    url: Users.API_PATH + '/offices',
                    type: 'GET',
                    data: {city_id: $(this).val(), company_id:$("#company_id").val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">Office...</option>';
                        
                        $(office).selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            html += '<option value="' + value.id + '">' + value.title + '</option>';
                        });

                        $(office).html(html);
                        $(office).selectize();
                    }
                );
            });


        },



    }
    return Users;
}());
