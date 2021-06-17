/**
 * Created by Giuseppe on 21/02/2018.
 */
var Contact = (function () {
    'use strict';

    var Contact = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            Contact.events(API_PATH, APP_URL);
            Contact.APP_URL = APP_URL;
            Contact.API_PATH = API_PATH;

        },


        events: function () {


            // $('#country_id').selectize();
            // $('#country_id2').selectize();

            $("#country_id, #country_id2").on('change', function () {
                console.log('chage....');
                $.ajax({
                    url: Contact.API_PATH + '/cities',
                    type: 'GET',
                    data: {country_id: $(this).val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">City...</option>';

                        if($('#city_id2').length>0){
                            $('#city_id2').selectize()[0].selectize.destroy();
                        }
                        $('#city_id').selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $('#city_id').html(html);
                        $('#city_id2').html(html);

                        $('#city_id').selectize();
                        $('#city_id2').selectize();
                    }
                );
            });




        },


    }
    return Contact;
}());
