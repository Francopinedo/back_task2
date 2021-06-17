/**
 * Created by Giuseppe on 21/02/2018.
 */



var Repository = (function () {
    'use strict';

    var Repository = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            Repository.APP_URL = APP_URL;
            Repository.API_PATH = API_PATH;


        },

        selectsize: '',
        showLoading: function () {

            var element = $("#page_content");
            kendo.ui.progress(element, true);
            // $(".k-loading-mask").css('display', 'block');

        },
        hideLoadding: function () {

            var element = $("#page_content");
            kendo.ui.progress(element, false);
            // $(".k-loading-mask").css('display', 'none');
        },

        searchDocuments: function (directory_name) {
            $.ajax({
                url: 'repository/show/' + $("#customer").val() + '/' + $("#project").val() + '/' + directory_name,
                success: function (data) {

                    var html = '';

                    jQuery.each(data.documentos, function (i, value) {

                        var res = value.split('/');

                        var lenght = Object.keys(res).length;

                        var document = res[lenght - 1];
                        html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="repository/download/?file=' + value + '">' + document + ' - </a>   ' +
                            '<a href="/repository/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                            + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                            '</div>';
                    });


                    $("#documents").html(html);




                    $('.delete-btn').on('click', function (e) {
                        var link = $(this);
                        e.preventDefault();
                        link.children('i').removeClass('fa-trash-o');
                        link.children('i').addClass('fa-spinner fa-spin fa-fw');
                        var $delete_url = $(this).attr('href');

                        UIkit.modal.confirm('Are you sure?', function () {

                            $.ajax({
                                url: $delete_url,
                                type: 'get',
                                dataType: 'json',
                                success: function (json) {
                                    if(json.success==true){
                                        Repository.searchDocuments($("#directory_form").val());
                                    }else{
                                        UIkit.modal.alert('Error');
                                    }

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

                            link.children('i').addClass('fa-trash-o');
                            link.children('i').removeClass('fa-spinner fa-spin fa-fw');


                        }, function () {
                            link.children('i').addClass('fa-trash-o');
                            link.children('i').removeClass('fa-spinner fa-spin fa-fw');
                        });
                    });

                }
            })
        },

        events: function () {

               $('#fileupload').fileupload({
                    dataType: 'json',


                    done: function (e, data) {
                        data.context.html('Upload finished.');

                        Repository.searchDocuments($("#directory_form").val());
                    }
                });







            $('.dropdown-submenu a.drop').on("click", function (e) {
                // $('a.drop').next('ul').hide();
                // $(this).next('ul').toggle();

                e.stopPropagation();
                e.preventDefault();

                $(this).parent().siblings().removeClass('open');
                $(this).parent().toggleClass('open');

                if ($(this).hasClass('no-drop')) {
                    console.log('tiene la clase');
                    $('.dropdown').removeClass('open');
                }
                var canread = $(this).attr('data-read');
                var canwrite = $(this).attr('data-write');
                console.log(canwrite);
                if (canwrite == 'false') {
                    $("#fileupload").addClass('hidden');
                } else {
                    $("#fileupload").removeClass('hidden');
                }
                var directory_name = $(this).attr('href');
                $("#directory_form").val(directory_name);
                $("#dir_title").html($(this).attr('data-nameshow'));

                if (canread == 'true') {
                    $("#error-div").addClass('hidden');
                    Repository.searchDocuments(directory_name);
                } else {
                    $("#documents").html('');
                    $("#error-div").removeClass('hidden');
                }
            });


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


        },


    }
    return Repository;
}());
