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
        init: function (lang_system, API_PATH, APP_URL,typedoc,directory) {
            this.events(lang_system, API_PATH, APP_URL,typedoc,directory);
            Catalog.APP_URL = APP_URL;
            Catalog.API_PATH = API_PATH;
            Catalog.typedoc = typedoc;
            // Catalog.language = language==''?'English':language; // Language of Directory
            Catalog.directory = directory;
            Catalog.lang_system = lang_system =='' ? 'EN': lang_system; // Language of System
            
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
      
        useDirectory: function (lang_system,type,dir) {
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

                    $('#label_generation').hide();
                    
                    $.ajax({
                        url: Catalog.APP_URL+'/catalog/show/'+lang_system+'/nontagged/' + dir,
                        success: function (data) {
                            // console.log(data);
                            var html = '';

                            jQuery.each(data.documentos, function (i, value) {

                                var res = value.split('/');

                                html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="'+Catalog.APP_URL+'/catalog/download/?file=' + value + '">' + res[3] + ' - </a>   ' +
                                '<a href="/catalog/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                                + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                                '</div>';
                            });

                            // console.log(html);
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
                                                
                                                Catalog.useDirectory(lang_system,type,dir);
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

                    

                    $('#label_generation').show()

                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/'+lang_system+'/tagged/' + dir,
                            success: function (data) {
                                // console.log(data);
                                var html = '';
        
                                jQuery.each(data.documentos, function (i, value) {
        
                                    var res = value.split('/');
        
                                    html += '  <div class="uk-width-1-2"><a style="font-size: 20px" onclick="getFromFile(\'' + value + '\')">' + res[3] + ' </a>   ' + '</div>';
                                });
        
                                // console.log(html);
                                $("#documents").html(html);
                            }
                        })
                } 

            }
        },

        getfilesDirectory: function (lang_system,type,dir) {
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

                    //Nos aseguramos de que el form tenga el action original
                    $('#fileupload').attr('action', 'catalog/uploadfile');
                    $('#label_generation').hide();

                    $.ajax({
                        url: Catalog.APP_URL+'/catalog/show/'+lang_system+'/nontagged/' + dir,
                        success: function (data) {
                            // console.log(data);
                            var html = '';

                            jQuery.each(data.documentos, function (i, value) {

                                var res = value.split('/');

                                html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="'+Catalog.APP_URL+'/catalog/download/?file=' + value + '">' + res[3] + ' - </a>   ' +
                                '<a href="/catalog/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                                + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                                '</div>';
                            });

                            // console.log(html);
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
                                                UIkit.notify(json.message, {status:'success'});
                                                Catalog.getfilesDirectory(lang_system,type,dir);
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

                    //Cambiamos action de form
                    $('#fileupload').attr('action', '/repository/store');
                    
                        $.ajax({
                            url: Catalog.APP_URL+'/catalog/show/'+lang_system+'/tagged/' + dir,
                            success: function (data) {
                                // console.log(data);
                                var html = '';
        
                                jQuery.each(data.documentos, function (i, value) {
        
                                    var res = value.split('/');
        
                                    html += '  <div class="uk-width-1-2"><a style="font-size: 20px" onclick="getFromFile(\'' + value + '\')">' + res[3] + ' </a>   ' + '</div>';
                                });
        
                                // console.log(html);
                                $("#documents").html(html);
                            }
                        })
                } 

            }
        },

        events: function () {
            $('#fileupload').fileupload({
                url: '/catalog/uploadfile',
                type: 'post',
                dataType: 'json',
                done: function (e, data) {
                    if(data.result.success == true){
                        UIkit.notify(data.result.message, {status:'warning'});
                        data.context.html('');
                    } else {
                        UIkit.notify(data.result.message, {status:'success'});
                        data.context.html('');
                    }

                    Catalog.getfilesDirectory(Catalog.lang_system,$('#option').val(), $('#directory').val());
                }
            });
            
            $('#directory').selectize();
            $(document).ready(function(){

                if($('#option').val()!="" || $('#option').val()!=0){
                    if(Catalog.directory == ""){
                        var html = '<option value="">Directory...</option>';
                            
                        if (Catalog.lang_system == 'ES') {
                            html += '<option value="1-Inicio">1-Inicio</option>';
                            html += '<option value="2-Planificacion">2-Planificacion</option>';
                            html += '<option value="3-Ejecucion">3-Ejecucion</option>';
                            html += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                            html += '<option value="5-Cierre">5-Cierre</option>';
                        }
                        if (Catalog.lang_system == 'EN') { 
                            html += '<option value="1-Initial">1-Initial</option>';
                            html += '<option value="2-Planning">2-Planning</option>';
                            html += '<option value="3-Executing">3-Executing</option>';
                            html += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                            html += '<option value="5-Closing">5-Closing</option>';
                        }
                    }else{
                        if (Catalog.lang_system == 'EN') {
                            switch(Catalog.directory.substring(0,1)) {
                                case '1':
                                    html += '<option value="1-Initial" selected="selected">1-Initial</option>';
                                    html += '<option value="2-Planning">2-Planning</option>';
                                    html += '<option value="3-Executing">3-Executing</option>';
                                    html += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                                    html += '<option value="5-Closing">5-Closing</option>';
                                break;
                                case '2':
                                    html += '<option value="1-Initial">1-Initial</option>';
                                    html += '<option value="2-Planning" selected="selected">2-Planning</option>';
                                    html += '<option value="3-Executing">3-Executing</option>';
                                    html += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                                    html += '<option value="5-Closing">5-Closing</option>';
                                break;
                                case '3':
                                    html += '<option value="1-Initial">1-Initial</option>';
                                    html += '<option value="2-Planning">2-Planning</option>';
                                    html += '<option value="3-Executing" selected="selected">3-Executing</option>';
                                    html += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                                    html += '<option value="5-Closing">5-Closing</option>';
                                break;
                                case '4':
                                    html += '<option value="1-Initial">1-Initial</option>';
                                    html += '<option value="2-Planning">2-Planning</option>';
                                    html += '<option value="3-Executing">3-Executing</option>';
                                    html += '<option value="4-Monitoring_Control" selected="selected">4-Monitoring & Control</option>';
                                    html += '<option value="5-Closing">5-Closing</option>';
                                break;
                                case '5':
                                    html += '<option value="1-Initial">1-Initial</option>';
                                    html += '<option value="2-Planning">2-Planning</option>';
                                    html += '<option value="3-Executing">3-Executing</option>';
                                    html += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                                    html += '<option value="5-Closing" selected="selected">5-Closing</option>';
                                break;                            
                            } 
                        }
                        if (Catalog.lang_system == 'ES') {
                            switch(Catalog.directory.substring(0,1)) {
                                case '1':
                                    html += '<option value="1-Inicio" selected="selected">1-Inicio</option>';
                                    html += '<option value="2-Planificacion">2-Planificacion</option>';
                                    html += '<option value="3-Ejecucion">3-Ejecucion</option>';
                                    html += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                                    html += '<option value="5-Cierre">5-Cierre</option>';
                                break;
                                case '2':
                                    html += '<option value="1-Inicio">1-Inicio</option>';
                                    html += '<option value="2-Planificacion" selected="selected">2-Planificacion</option>';
                                    html += '<option value="3-Ejecucion">3-Ejecucion</option>';
                                    html += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                                    html += '<option value="5-Cierre">5-Cierre</option>';
                                break;
                                case '3':
                                    html += '<option value="1-Inicio">1-Inicio</option>';
                                    html += '<option value="2-Planificacion">2-Planificacion</option>';
                                    html += '<option value="3-Ejecucion" selected="selected">3-Ejecucion</option>';
                                    html += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                                    html += '<option value="5-Cierre">5-Cierre</option>';
                                break;
                                case '4':
                                    html += '<option value="1-Inicio">1-Inicio</option>';
                                    html += '<option value="2-Planificacion">2-Planificacion</option>';
                                    html += '<option value="3-Ejecucion">3-Ejecucion</option>';
                                    html += '<option value="4-Monitoreo_Control" selected="selected">4-Monitoreo y Control</option>';
                                    html += '<option value="5-Cierre">5-Cierre</option>';
                                break;
                                case '5':
                                    html += '<option value="1-Inicio">1-Inicio</option>';
                                    html += '<option value="2-Planificacion">2-Planificacion</option>';
                                    html += '<option value="3-Ejecucion">3-Ejecucion</option>';
                                    html += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                                    html += '<option value="5-Cierre" selected="selected">5-Cierre</option>';
                                break;
                            }
                        }
                    }
                }
                $('#directory').selectize()[0].selectize.destroy();

                $('#directory').html(html);
                $('#directory').selectize();
            });

            $("#option").on('change', function () {
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
                var tipo=$('#option').val();
                // var languages=$('#language').val();
                var directory=$('#directory').val();
                var lang_system=Catalog.lang_system;
                if(tipo!='' && directory!='')
                    Catalog.useDirectory(lang_system,tipo,directory);
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

                    Catalog.getfilesDirectory(Catalog.lang_system,$('#option').val(), $('#directory').val());

                    // $.ajax({
                    //     url: Catalog.APP_URL+'/catalog/show/'+Catalog.lang_system+'/nontagged/' + $("#directory").val(),
                    //     success: function (data) {
                    //         // console.log(data);
                    //         var html = '';

                    //         jQuery.each(data.documentos, function (i, value) {

                    //             var res = value.split('/');

                    //             html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="'+Catalog.APP_URL+'/catalog/download/?file=' + value + '">' + res[3] + ' - </a>   ' +
                    //             '<a href="/catalog/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                    //             + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                    //             '</div>';
                    //         });

                    //         // console.log(html);
                    //         $("#documents").html(html);
                    //     }
                    // })
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
                        url: Catalog.APP_URL+'/catalog/show/'+Catalog.lang_system+'/tagged/' + $("#directory").val(),
                        success: function (data) {
                            // console.log(data);
                            var html = '';
    
                            jQuery.each(data.documentos, function (i, value) {
    
                                var res = value.split('/');
    
                                html += '  <div class="uk-width-1-2"><a style="font-size: 20px" onclick="getFromFile(\'' + value + '\')">' + res[3] + ' </a>   ' + '</div>';
                            });
    
                            // console.log(html);
                            $("#documents").html(html);
                        }
                    })
                }

            });
        },


    }
    return Catalog;
}());
