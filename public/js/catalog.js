/**
 * Created by Giuseppe on 21/02/2018.
 */




var Catalog = (function () {
    'use strict';

    var Catalog = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            Catalog.APP_URL = APP_URL;
            Catalog.API_PATH = API_PATH;



        },

        selectsize: '',

        events: function () {
            $('#directory').selectize();

            $("#lenguage").on('change', function () {
                var html = '<option value="">Directory...</option>';

                if ($("#lenguage").val() == 'ES') {
                    html += '<option value="1-Inicio">1-Inicio</option>';
                    html += '<option value="2-Planificacion">2-Planificacion</option>';
                    html += '<option value="3-Ejecucion">3-Ejecucion</option>';
                    html += '<option value="4-Monitoreo">4-Monitoreo</option>';
                    html += '<option value="5-Cierre">5-Cierre</option>';
                }
                if ($("#lenguage").val() == 'EN') {
                    html += '<option value="1-Initial">1-Initial</option>';
                    html += '<option value="2-Planning">2-Planning</option>';
                    html += '<option value="3-Executing">3-Executing</option>';
                    html += '<option value="4-Monitoring">4-Monitoring</option>';
                    html += '<option value="5-Closing">5-Closing</option>';
                }

                $('#directory').selectize()[0].selectize.destroy();


                $('#directory').html(html);
                $('#directory').selectize();


            });


            $("#directory").on('change', function () {

                $.ajax({
                    url: 'catalog/show/' + $("#lenguage").val() + '/' + $("#directory").val(),
                    success: function (data) {
                        console.log(data);
                        var html = '';

                        jQuery.each(data.documentos, function (i, value) {

                            var res = value.split('/');

                            html += '  <div class="uk-width-1-3"><a style="font-size: 20px" href="catalog/download/'+value+'">' + res[2] + '</a> </div>';
                        });

                        console.log(html);
                        $("#documents").html(html);
                    }
                })


            });


        },


    }
    return Catalog;
}());
