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
        init: function (API_PATH, APP_URL,typedoc,language,directory) {
                       
            this.events(API_PATH, APP_URL,typedoc,language,directory);
            Catalog.APP_URL = APP_URL;
            Catalog.API_PATH = API_PATH;
            Catalog.typedoc = typedoc;
            Catalog.language = language==''?'EN':language;
            Catalog.directory = directory;


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
      
         useDirectory: function (type,language,dir) {
            if(dir){
              if (type == 1)
                {
                        if(dir!="" || dir!=0)
                        {
                            $("#upload_file_div").removeClass("hidden");
                            $("#upload_file_div2").addClass("hidden");
                        }
                        else
                        {
                            $("#upload_file_div").addClass("hidden");
                            $("#upload_file_div2").addClass("hidden");
                        }

                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/nontagged/' + language + '/' + dir,
                            success: function (data) {
                                console.log(data);
                                var html = '';

                                jQuery.each(data.documentos, function (i, value) {

                                    var res = value.split('/');

                                    html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="'+Catalog.APP_URL+'/catalog/download/?file=' + value + '">' + res[3] + ' - </a>   ' +
                                    '<a href="/catalog/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                                    + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                                    '</div>';
                                });

                                console.log(html);
                                $("#documents").html(html);
                            }
                        })
                }
                else if (type == 2)
                {
                    if(dir!="" || dir!=0)
                    {
                        $("#upload_file_div2").removeClass("hidden");
                        $("#upload_file_div").addClass("hidden");
                    }
                    else
                    {
                        $("#upload_file_div2").addClass("hidden");
                        $("#upload_file_div").addClass("hidden");
                    }
                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/tagged/' + language + '/' + dir,
                            success: function (data) {
                                console.log(data);
                                var html = '';
        
                                jQuery.each(data.documentos, function (i, value) {
        
                                    var res = value.split('/');
        
                                    html += '  <div class="uk-width-1-2"><a style="font-size: 20px" onclick="getFromFile(\'' + value + '\')">' + res[3] + ' </a>   ' + '</div>';
                                });
        
                                console.log(html);
                                $("#documents").html(html);
                            }
                        })
                } 

            }
        },

              getfilesDirectory: function (type,language,dir) {
            if(dir){
              if (type == 1)
                {
                        if(dir!="" || dir!=0)
                        {
                            $("#upload_file_div").removeClass("hidden");
                            $("#upload_file_div2").addClass("hidden");
                        }
                        else
                        {
                            $("#upload_file_div").addClass("hidden");
                            $("#upload_file_div2").addClass("hidden");
                        }

                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/nontagged/' + language + '/' + dir,
                            success: function (data) {
                                console.log(data);
                                var html = '';

                                jQuery.each(data.documentos, function (i, value) {

                                    var res = value.split('/');

                                    html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="'+Catalog.APP_URL+'/catalog/download/?file=' + value + '">' + res[3] + ' - </a>   ' +
                                    '<a href="/catalog/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                                    + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                                    '</div>';
                                });

                                console.log(html);
                                $("#documents").html(html);
                            }
                        })
                }
                else if (type == 2)
                {
                    if(dir!="" || dir!=0)
                    {
                        $("#upload_file_div2").removeClass("hidden");
                        $("#upload_file_div").addClass("hidden");
                    }
                    else
                    {
                        $("#upload_file_div2").addClass("hidden");
                        $("#upload_file_div").addClass("hidden");
                    }
                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/tagged/' + language + '/' + dir,
                            success: function (data) {
                                console.log(data);
                                var html = '';
        
                                jQuery.each(data.documentos, function (i, value) {
        
                                    var res = value.split('/');
        
                                    html += '  <div class="uk-width-1-2"><a style="font-size: 20px" onclick="getFromFile(\'' + value + '\')">' + res[3] + ' </a>   ' + '</div>';
                                });
        
                                console.log(html);
                                $("#documents").html(html);
                            }
                        })
                } 

            }
        },

        events: function () {
    
            
               $('#fileupload').fileupload({
                    dataType: 'json',


                    done: function (e, data) {
                        data.context.html('Upload finished.');

                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/nontagged/' + $("#lenguage").val() + '/' + $("#directory").val(),
                            success: function (data) {
                                console.log(data);
                                var html = '';

                                jQuery.each(data.documentos, function (i, value) {

                                    var res = value.split('/');

                                html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="'+Catalog.APP_URL+'/catalog/download/?file=' + value + '">' + res[2] + ' - </a>   ' +
                                    '<a href="/catalog/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                                    + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                                    '</div>';
                                });

                                console.log(html);
                                $("#documents").html(html);
                            }
                        })

                    }
                });


            $('#directory').selectize();

            $("#lenguage").on('change', function () {
                if(Catalog.directory==''){
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
                }else{
                    var ndir="";
                if ($("#lenguage").val() == 'ES') {
                    switch(Catalog.directory.substring(0,1)) {
                          case '1':
                    html = '<option value="1-Inicio">1-Inicio</option>';
                    ndir="1-Inicio";
                            break;
                          case '2':
                    html = '<option value="2-Planificacion">2-Planificacion</option>';
                            ndir="2-Planificacion";
                            break;
                            case '3':
                    html = '<option value="3-Ejecucion">3-Ejecucion</option>';
                    ndir="3-Ejecucion";
                            break;
                          case '4':
                    html = '<option value="4-Monitoreo">4-Monitoreo</option>';
                    ndir="4-Monitoreo";
                            break;
                            case '5':
                    html = '<option value="5-Cierre">5-Cierre</option>';
                    ndir="5-Cierre";
                            break;
                                                    
                        } 
                }
                if ($("#lenguage").val() == 'EN') {
                 switch(Catalog.directory.substring(0,1)) {
                          case '1':
                    html = '<option value="1-Initial">1-Initial</option>';
                    ndir="1-Initial";
                            break;
                          case '2':
                    html = '<option value="2-Planning">2-Planning</option>';
                            ndir="2-Planning";
                            break;
                            case '3':
                    html = '<option value="3-Executing">3-Executing</option>';
                    ndir="3-Executing";
                            break;
                          case '4':
                    html = '<option value="4-Monitoring">4-Monitoring</option>';
                    ndir="4-Monitoring";
                            break;
                            case '5':
                    html = '<option value="5-Closing">5-Closing</option>';
                    ndir="5-Closing";
                            break;
                                                    
                        } 
                }
                 $('#directory').selectize()[0].selectize.destroy();

                $('#directory').html(html);
                $('#directory').selectize();
                        var tipo=Catalog.typedoc==''?'1':Catalog.typedoc;
                        var languages=Catalog.language==''?'EN':Catalog.language;
                        Catalog.useDirectory(tipo,languages,ndir);
            }
                $('#directory').selectize()[0].selectize.destroy();


                $('#directory').html(html);
                $('#directory').selectize();

            });


        $("#lenguage").on('change', function () {
            if ($('#option').val() == 1)
            {
                if($("#directory").val()!="" || $("#directory").val()!=0)
                {
                    $("#upload_file_div").removeClass("hidden");
                    $("#upload_file_div2").addClass("hidden");
                }
                else
                {
                    $("#upload_file_div").addClass("hidden");
                    $("#upload_file_div2").addClass("hidden");
                }        
            }
            else
            {
                if($("#directory").val()!="" || $("#directory").val()!=0)
                {
                    $("#upload_file_div2").removeClass("hidden");
                    $("#upload_file_div").addClass("hidden");
                }
                else
                {
                    $("#upload_file_div2").addClass("hidden");
                    $("#upload_file_div").addClass("hidden");
                }
            }
        });

            $("#directory").on('change', function () {
                if ($('#option').val() == 1)
                {
                        if($("#directory").val()!="" || $("#directory").val()!=0)
                        {
                            $("#upload_file_div").removeClass("hidden");
                            $("#upload_file_div2").addClass("hidden");
                        }
                        else
                        {
                            $("#upload_file_div").addClass("hidden");
                            $("#upload_file_div2").addClass("hidden");
                        }

                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/nontagged/' + $("#lenguage").val() + '/' + $("#directory").val(),
                            success: function (data) {
                                console.log(data);
                                var html = '';

                                jQuery.each(data.documentos, function (i, value) {

                                    var res = value.split('/');

                                    html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="'+Catalog.APP_URL+'/catalog/download/?file=' + value + '">' + res[3] + ' - </a>   ' +
                                    '<a href="/catalog/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                                    + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                                    '</div>';
                                });

                                console.log(html);
                                $("#documents").html(html);
                            }
                        })
                }
                else if ($('#option').val() == 2)
                {
                    if($("#directory").val()!="" || $("#directory").val()!=0)
                    {
                        $("#upload_file_div2").removeClass("hidden");
                        $("#upload_file_div").addClass("hidden");
                    }
                    else
                    {
                        $("#upload_file_div2").addClass("hidden");
                        $("#upload_file_div").addClass("hidden");
                    }
                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/tagged/' + $("#lenguage").val() + '/' + $("#directory").val(),
                            success: function (data) {
                                console.log(data);
                                var html = '';
        
                                jQuery.each(data.documentos, function (i, value) {
        
                                    var res = value.split('/');
        
                                    html += '  <div class="uk-width-1-2"><a style="font-size: 20px" onclick="getFromFile(\'' + value + '\')">' + res[3] + ' </a>   ' + '</div>';
                                });
        
                                console.log(html);
                                $("#documents").html(html);
                            }
                        })
                }

            });


        },


    }
    return Catalog;
}());
