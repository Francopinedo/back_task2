/**
 * Created by Giuseppe on 21/02/2018.
 */




var Projects = (function () {
    'use strict';

    var Projects = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            Projects.APP_URL = APP_URL;
            Projects.API_PATH = API_PATH;

        },

        selectsize : '',

        events: function () {


            $('#office_id').selectize();
            $('#office_id2').selectize();

            $("#city_id, #city_id2").on('change', function () {
                console.log('chage....');
                $.ajax({
                    url: Projects.API_PATH + '/offices',
                    type: 'GET',
                    data: {city_id: $(this).val(), company_id:$("#company_id").val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">Office...</option>';
                        if($('#office_id2').length>0){
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


        },



    }
    return Projects;
}());
