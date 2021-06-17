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
        init: function (API_PATH, APP_URL, lang_system, customer_name, project_name, process_group, knowledge_area, directory) {
            this.events(API_PATH, APP_URL, lang_system, customer_name, project_name, process_group, knowledge_area, directory);
            Repository.APP_URL = APP_URL;
            Repository.API_PATH = API_PATH;
            Repository.process_group = process_group;
            Repository.knowledge_area = knowledge_area;
            Repository.directory = directory;
            Repository.lang_system = lang_system == "" ? 'EN':lang_system;
            Repository.customer_name=customer_name;
            Repository.project_name=project_name;
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

        useDirectory: function(customer,project,lang_system,process_group,knowledge_area,dir){
            if(dir){
             
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
                url: Repository.APP_URL+'/repository/show/' + customer + '/'+ project +'/'+ lang_system +'/'+ process_group + '/' + knowledge_area + '/' + dir,
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
                        // console.log(html);
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
                                        Repository.searchDocuments(directory_name);
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
        },
        
        searchDocuments: function (directory_name) {
            $.ajax({
                url: Repository.APP_URL+'/repository/show/' + Repository.customer_name + '/'+ Repository.project_name +'/'+ Repository.lang_system +'/'+ $('#process_group').val() + '/' + $('#knowledge_area').val() + '/' + directory_name,
                success: function (data) {
                    var html = '';

                    jQuery.each(data.documentos, function (i, value) {

                        var res = value.toString().split('/');

                        var lenght = Object.keys(res).length;

                        var document = res[lenght - 1];
                        html += '  <div class="uk-width-1-2"><a style="font-size: 20px" href="repository/download/?file=' + value + '">' + document + ' - </a>   ' +
                            '<a href="/repository/delete/?file=' + value + '" class="md-icon material-icons delete-btn">'
                            + '<i class="fa fa-trash-o" aria-hidden="true"></i> </a>' +
                            '</div>';
                        // console.log(html);
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
                                        Repository.searchDocuments(directory_name);
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
                url: '/repository/uploadfile',
                type: 'post',
                dataType: 'json',
                done: function (e, data) {
                    data.context.html('Upload finished.').fadeOut(2000);

                    Repository.searchDocuments($("#directory").val());
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

            $('#process_group').selectize();
            $('#knowledge_area').selectize();
            $('#directory').selectize();
            $(document).ready(function(){
                if (Repository.process_group!="" && Repository.knowledge_area!="" && Repository.dir!="") {
                    // Grupo de Procesos
                    var pro_group = '<option value="">Process Group ... </option>';
                    if (Repository.process_group) {

                        if (Repository.lang_system == 'EN') {
                            switch(Repository.process_group.substring(0,1)) {
                                case '1':
                                    pro_group += '<option value="1-Initial" selected="selected">1-Initial</option>';
                                    pro_group += '<option value="2-Planning">2-Planning</option>';
                                    pro_group += '<option value="3-Executing">3-Executing</option>';
                                    pro_group += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                                    pro_group += '<option value="5-Closing">5-Closing</option>';
                                break;
                                case '2':
                                    pro_group += '<option value="1-Initial">1-Initial</option>';
                                    pro_group += '<option value="2-Planning" selected="selected">2-Planning</option>';
                                    pro_group += '<option value="3-Executing">3-Executing</option>';
                                    pro_group += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                                    pro_group += '<option value="5-Closing">5-Closing</option>';
                                break;
                                case '3':
                                    pro_group += '<option value="1-Initial">1-Initial</option>';
                                    pro_group += '<option value="2-Planning">2-Planning</option>';
                                    pro_group += '<option value="3-Executing" selected="selected">3-Executing</option>';
                                    pro_group += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                                    pro_group += '<option value="5-Closing">5-Closing</option>';
                                break;
                                case '4':
                                    pro_group += '<option value="1-Initial">1-Initial</option>';
                                    pro_group += '<option value="2-Planning">2-Planning</option>';
                                    pro_group += '<option value="3-Executing">3-Executing</option>';
                                    pro_group += '<option value="4-Monitoring_Control" selected="selected">4-Monitoring & Control</option>';
                                    pro_group += '<option value="5-Closing">5-Closing</option>';
                                break;
                                case '5':
                                    pro_group += '<option value="1-Initial">1-Initial</option>';
                                    pro_group += '<option value="2-Planning">2-Planning</option>';
                                    pro_group += '<option value="3-Executing">3-Executing</option>';
                                    pro_group += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                                    pro_group += '<option value="5-Closing" selected="selected">5-Closing</option>';
                                break;                            
                            } 
                        }
                        if (Repository.lang_system == 'ES') {
                            switch(Repository.process_group.substring(0,1)) {
                                case '1':
                                    pro_group += '<option value="1-Inicio" selected="selected">1-Inicio</option>';
                                    pro_group += '<option value="2-Planificacion">2-Planificacion</option>';
                                    pro_group += '<option value="3-Ejecucion">3-Ejecucion</option>';
                                    pro_group += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                                    pro_group += '<option value="5-Cierre">5-Cierre</option>';
                                break;
                                case '2':
                                    pro_group += '<option value="1-Inicio">1-Inicio</option>';
                                    pro_group += '<option value="2-Planificacion" selected="selected">2-Planificacion</option>';
                                    pro_group += '<option value="3-Ejecucion">3-Ejecucion</option>';
                                    pro_group += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                                    pro_group += '<option value="5-Cierre">5-Cierre</option>';
                                break;
                                case '3':
                                    pro_group += '<option value="1-Inicio">1-Inicio</option>';
                                    pro_group += '<option value="2-Planificacion">2-Planificacion</option>';
                                    pro_group += '<option value="3-Ejecucion" selected="selected">3-Ejecucion</option>';
                                    pro_group += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                                    pro_group += '<option value="5-Cierre">5-Cierre</option>';
                                break;
                                case '4':
                                    pro_group += '<option value="1-Inicio">1-Inicio</option>';
                                    pro_group += '<option value="2-Planificacion">2-Planificacion</option>';
                                    pro_group += '<option value="3-Ejecucion">3-Ejecucion</option>';
                                    pro_group += '<option value="4-Monitoreo_Control" selected="selected">4-Monitoreo y Control</option>';
                                    pro_group += '<option value="5-Cierre">5-Cierre</option>';
                                break;
                                case '5':
                                    pro_group += '<option value="1-Inicio">1-Inicio</option>';
                                    pro_group += '<option value="2-Planificacion">2-Planificacion</option>';
                                    pro_group += '<option value="3-Ejecucion">3-Ejecucion</option>';
                                    pro_group += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                                    pro_group += '<option value="5-Cierre" selected="selected">5-Cierre</option>';
                                break;
                            }
                        }
                    }
                    var k_area = '<option value="">Knowledge Area...</option>';
                    if (Repository.knowledge_area) {
                        if (Repository.lang_system=="EN") {
                            switch(Repository.knowledge_area.substring(0,2)) {
                                case '1-':
                                    k_area += '<option value="1-Integration_Management" selected="selected">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '2-':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management" selected="selected">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '3-':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management" selected="selected">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '4-':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management" selected="selected">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '5-':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management" selected="selected">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '6-':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management" selected="selected">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '7-':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management" selected="selected">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '8-':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management" selected="selected">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '9-':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management" selected="selected">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                                break;
                                case '10':
                                    k_area += '<option value="1-Integration_Management">1-Integration Management</option>';
                                    k_area += '<option value="2-Scope_Management">2-Scope Management</option>';
                                    k_area += '<option value="3-Time_Management">3-Time Management</option>';
                                    k_area += '<option value="4-Cost_Management">4-Cost Management</option>';
                                    k_area += '<option value="5-Quality_Management">5-Quality Management</option>';
                                    k_area += '<option value="6-Team_Management">6-Team Management</option>';
                                    k_area += '<option value="7-Communication_Management">7-Communication Management</option>';
                                    k_area += '<option value="8-Risk_Management">8-Risk Management</option>';
                                    k_area += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                                    k_area += '<option value="10-Procurement_Management" selected="selected">10-Procurement Management</option>';
                                break;
                            }
                        }
                        if (Repository.lang_system=="ES") {
                            switch(Repository.knowledge_area.substring(0,2)) {
                                case '1-':
                                    k_area += '<option value="1-Manejo_Integracion"  selected="selected">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '2-':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance" selected="selected">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '3-':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo" selected="selected">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '4-':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos" selected="selected">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '5-':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad" selected="selected">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '6-':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo" selected="selected">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '7-':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones" selected="selected">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '8-':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos" selected="selected">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '9-':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados" selected="selected">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                                break;
                                case '10':
                                    k_area += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                                    k_area += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                                    k_area += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                                    k_area += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                                    k_area += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                                    k_area += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                                    k_area += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                                    k_area += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                                    k_area += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                                    k_area += '<option value="10-Manjeo_Adquisiciones" selected="selected">10-Manejo De Las Adquisiciones</option>';
                                break;
                            }
                        }
                    }
                    var directory = '<option value=""><Directory...</option>';
                    if (Repository.directory) {
                        if (Repository.lang_system == "EN") {
                            switch(Repository.directory.substring(0,1)) {
                                case '1':
                                    directory += '<option value="1-Urgent" selected="selected">1-Urgent</option>';
                                    directory += '<option value="2-Mails">2-Mails</option>';
                                    directory += '<option value="3-Minutes">3-Minutes</option>';
                                    directory += '<option value="4-Reports">4-Reports</option>';
                                    directory += '<option value="5-Legal">5-Legal</option>';
                                    directory += '<option value="6-Plans">6-Plans</option>';
                                    directory += '<option value="7-Metrics">7-Metrics</option>';
                                    directory += '<option value="8-Others">8-Others</option>';
                                    directory += '<option value="9-Archives">9-Archives</option>';
                                break;
                                case '2':
                                    directory += '<option value="1-Urgent">1-Urgent</option>';
                                    directory += '<option value="2-Mails" selected="selected">2-Mails</option>';
                                    directory += '<option value="3-Minutes">3-Minutes</option>';
                                    directory += '<option value="4-Reports">4-Reports</option>';
                                    directory += '<option value="5-Legal">5-Legal</option>';
                                    directory += '<option value="6-Plans">6-Plans</option>';
                                    directory += '<option value="7-Metrics">7-Metrics</option>';
                                    directory += '<option value="8-Others">8-Others</option>';
                                    directory += '<option value="9-Archives">9-Archives</option>';
                                break;
                                case '3':
                                    directory += '<option value="1-Urgent">1-Urgent</option>';
                                    directory += '<option value="2-Mails">2-Mails</option>';
                                    directory += '<option value="3-Minutes" selected="selected">3-Minutes</option>';
                                    directory += '<option value="4-Reports">4-Reports</option>';
                                    directory += '<option value="5-Legal">5-Legal</option>';
                                    directory += '<option value="6-Plans">6-Plans</option>';
                                    directory += '<option value="7-Metrics">7-Metrics</option>';
                                    directory += '<option value="8-Others">8-Others</option>';
                                    directory += '<option value="9-Archives">9-Archives</option>';
                                break;
                                case '4':
                                    directory += '<option value="1-Urgent">1-Urgent</option>';
                                    directory += '<option value="2-Mails">2-Mails</option>';
                                    directory += '<option value="3-Minutes">3-Minutes</option>';
                                    directory += '<option value="4-Reports" selected="selected">4-Reports</option>';
                                    directory += '<option value="5-Legal">5-Legal</option>';
                                    directory += '<option value="6-Plans">6-Plans</option>';
                                    directory += '<option value="7-Metrics">7-Metrics</option>';
                                    directory += '<option value="8-Others">8-Others</option>';
                                    directory += '<option value="9-Archives">9-Archives</option>';
                                break;
                                case '5':
                                    directory += '<option value="1-Urgent">1-Urgent</option>';
                                    directory += '<option value="2-Mails">2-Mails</option>';
                                    directory += '<option value="3-Minutes">3-Minutes</option>';
                                    directory += '<option value="4-Reports">4-Reports</option>';
                                    directory += '<option value="5-Legal" selected="selected">5-Legal</option>';
                                    directory += '<option value="6-Plans">6-Plans</option>';
                                    directory += '<option value="7-Metrics">7-Metrics</option>';
                                    directory += '<option value="8-Others">8-Others</option>';
                                    directory += '<option value="9-Archives">9-Archives</option>';
                                break;
                                case '6':
                                    directory += '<option value="1-Urgent">1-Urgent</option>';
                                    directory += '<option value="2-Mails">2-Mails</option>';
                                    directory += '<option value="3-Minutes">3-Minutes</option>';
                                    directory += '<option value="4-Reports">4-Reports</option>';
                                    directory += '<option value="5-Legal">5-Legal</option>';
                                    directory += '<option value="6-Plans" selected="selected">6-Plans</option>';
                                    directory += '<option value="7-Metrics">7-Metrics</option>';
                                    directory += '<option value="8-Others">8-Others</option>';
                                    directory += '<option value="9-Archives">9-Archives</option>';
                                break;
                                case '7':
                                    directory += '<option value="1-Urgent">1-Urgent</option>';
                                    directory += '<option value="2-Mails">2-Mails</option>';
                                    directory += '<option value="3-Minutes">3-Minutes</option>';
                                    directory += '<option value="4-Reports">4-Reports</option>';
                                    directory += '<option value="5-Legal">5-Legal</option>';
                                    directory += '<option value="6-Plans">6-Plans</option>';
                                    directory += '<option value="7-Metrics" selected="selected">7-Metrics</option>';
                                    directory += '<option value="8-Others">8-Others</option>';
                                    directory += '<option value="9-Archives">9-Archives</option>';
                                break;
                                case '8':
                                    directory += '<option value="1-Urgent">1-Urgent</option>';
                                    directory += '<option value="2-Mails">2-Mails</option>';
                                    directory += '<option value="3-Minutes">3-Minutes</option>';
                                    directory += '<option value="4-Reports">4-Reports</option>';
                                    directory += '<option value="5-Legal">5-Legal</option>';
                                    directory += '<option value="6-Plans">6-Plans</option>';
                                    directory += '<option value="7-Metrics">7-Metrics</option>';
                                    directory += '<option value="8-Others" selected="selected">8-Others</option>';
                                    directory += '<option value="9-Archives">9-Archives</option>';
                                break;
                                case '9':
                                    directory += '<option value="1-Urgent">1-Urgent</option>';
                                    directory += '<option value="2-Mails">2-Mails</option>';
                                    directory += '<option value="3-Minutes">3-Minutes</option>';
                                    directory += '<option value="4-Reports">4-Reports</option>';
                                    directory += '<option value="5-Legal" selected="selected">5-Legal</option>';
                                    directory += '<option value="6-Plans">6-Plans</option>';
                                    directory += '<option value="7-Metrics">7-Metrics</option>';
                                    directory += '<option value="8-Others">8-Others</option>';
                                    directory += '<option value="9-Archives" selected="selected">9-Archives</option>';
                                break;                            
                            }
                        }
                        if (Repository.lang_system == "ES") {
                            switch(Repository.directory.substring(0,1)) {
                                case '1':
                                    directory += '<option value="1-Urgente" selected="selected">1-Urgente</option>';
                                    directory += '<option value="2-Correos">2-Correos</option>';
                                    directory += '<option value="3-Minutas">3-Minutas</option>';
                                    directory += '<option value="4-Reportes">4-Reportes</option>';
                                    directory += '<option value="5-Legales">5-Legales</option>';
                                    directory += '<option value="6-Planes">6-Planes</option>';
                                    directory += '<option value="7-Metricas">7-Metricas</option>';
                                    directory += '<option value="8-Otros">8-Otros</option>';
                                    directory += '<option value="9-Archivo">9-Archivo</option>';
                                break;
                                case '2':
                                    directory += '<option value="1-Urgente">1-Urgente</option>';
                                    directory += '<option value="2-Correos" selected="selected">2-Correos</option>';
                                    directory += '<option value="3-Minutas">3-Minutas</option>';
                                    directory += '<option value="4-Reportes">4-Reportes</option>';
                                    directory += '<option value="5-Legales">5-Legales</option>';
                                    directory += '<option value="6-Planes">6-Planes</option>';
                                    directory += '<option value="7-Metricas">7-Metricas</option>';
                                    directory += '<option value="8-Otros">8-Otros</option>';
                                    directory += '<option value="9-Archivo">9-Archivo</option>';
                                break;
                                case '3':
                                    directory += '<option value="1-Urgente">1-Urgente</option>';
                                    directory += '<option value="2-Correos">2-Correos</option>';
                                    directory += '<option value="3-Minutas" selected="selected">3-Minutas</option>';
                                    directory += '<option value="4-Reportes">4-Reportes</option>';
                                    directory += '<option value="5-Legales">5-Legales</option>';
                                    directory += '<option value="6-Planes">6-Planes</option>';
                                    directory += '<option value="7-Metricas">7-Metricas</option>';
                                    directory += '<option value="8-Otros">8-Otros</option>';
                                    directory += '<option value="9-Archivo">9-Archivo</option>';
                                break;
                                case '4':
                                    directory += '<option value="1-Urgente">1-Urgente</option>';
                                    directory += '<option value="2-Correos">2-Correos</option>';
                                    directory += '<option value="3-Minutas">3-Minutas</option>';
                                    directory += '<option value="4-Reportes" selected="selected">4-Reportes</option>';
                                    directory += '<option value="5-Legales">5-Legales</option>';
                                    directory += '<option value="6-Planes">6-Planes</option>';
                                    directory += '<option value="7-Metricas">7-Metricas</option>';
                                    directory += '<option value="8-Otros">8-Otros</option>';
                                    directory += '<option value="9-Archivo">9-Archivo</option>';
                                break;
                                case '5':
                                    directory += '<option value="1-Urgente">1-Urgente</option>';
                                    directory += '<option value="2-Correos">2-Correos</option>';
                                    directory += '<option value="3-Minutas">3-Minutas</option>';
                                    directory += '<option value="4-Reportes">4-Reportes</option>';
                                    directory += '<option value="5-Legales" selected="selected">5-Legales</option>';
                                    directory += '<option value="6-Planes">6-Planes</option>';
                                    directory += '<option value="7-Metricas">7-Metricas</option>';
                                    directory += '<option value="8-Otros">8-Otros</option>';
                                    directory += '<option value="9-Archivo">9-Archivo</option>';
                                break;
                                case '6':
                                    directory += '<option value="1-Urgente">1-Urgente</option>';
                                    directory += '<option value="2-Correos">2-Correos</option>';
                                    directory += '<option value="3-Minutas">3-Minutas</option>';
                                    directory += '<option value="4-Reportes">4-Reportes</option>';
                                    directory += '<option value="5-Legales">5-Legales</option>';
                                    directory += '<option value="6-Planes" selected="selected">6-Planes</option>';
                                    directory += '<option value="7-Metricas">7-Metricas</option>';
                                    directory += '<option value="8-Otros">8-Otros</option>';
                                    directory += '<option value="9-Archivo">9-Archivo</option>';
                                break;
                                case '7':
                                    directory += '<option value="1-Urgente">1-Urgente</option>';
                                    directory += '<option value="2-Correos">2-Correos</option>';
                                    directory += '<option value="3-Minutas">3-Minutas</option>';
                                    directory += '<option value="4-Reportes">4-Reportes</option>';
                                    directory += '<option value="5-Legales">5-Legales</option>';
                                    directory += '<option value="6-Planes">6-Planes</option>';
                                    directory += '<option value="7-Metricas" selected="selected">7-Metricas</option>';
                                    directory += '<option value="8-Otros">8-Otros</option>';
                                    directory += '<option value="9-Archivo">9-Archivo</option>';
                                break;
                                case '8':
                                    directory += '<option value="1-Urgente">1-Urgente</option>';
                                    directory += '<option value="2-Correos">2-Correos</option>';
                                    directory += '<option value="3-Minutas">3-Minutas</option>';
                                    directory += '<option value="4-Reportes">4-Reportes</option>';
                                    directory += '<option value="5-Legales">5-Legales</option>';
                                    directory += '<option value="6-Planes">6-Planes</option>';
                                    directory += '<option value="7-Metricas">7-Metricas</option>';
                                    directory += '<option value="8-Otros" selected="selected">8-Otros</option>';
                                    directory += '<option value="9-Archivo">9-Archivo</option>';
                                break;
                                case '9':
                                    directory += '<option value="1-Urgente">1-Urgente</option>';
                                    directory += '<option value="2-Correos">2-Correos</option>';
                                    directory += '<option value="3-Minutas">3-Minutas</option>';
                                    directory += '<option value="4-Reportes">4-Reportes</option>';
                                    directory += '<option value="5-Legales">5-Legales</option>';
                                    directory += '<option value="6-Planes">6-Planes</option>';
                                    directory += '<option value="7-Metricas">7-Metricas</option>';
                                    directory += '<option value="8-Otros">8-Otros</option>';
                                    directory += '<option value="9-Archivo" selected="selected">9-Archivo</option>';
                                break;                            
                            }
                        }
                    }
                    $('#process_group').selectize()[0].selectize.destroy();
                    $('#process_group').html(pro_group);
                    $('#process_group').selectize();

                    $('#knowledge_area').selectize()[0].selectize.destroy();
                    $('#knowledge_area').html(k_area);
                    $('#knowledge_area').selectize();

                    $('#directory').selectize()[0].selectize.destroy();
                    $('#directory').html(directory);
                    $('#directory').selectize();

                }
            });
            
            $('#knowledge_area').selectize();
                    
            $('#process_group').on('change', function(){
                var html = '<option value="">Knowledge Area...</option>';
                if(Repository.lang_system == 'EN'){
                    html += '<option value="1-Integration_Management">1-Integration Management</option>';
                    html += '<option value="2-Scope_Management">2-Scope Management</option>';
                    html += '<option value="3-Time_Management">3-Time Management</option>';
                    html += '<option value="4-Cost_Management">4-Cost Management</option>';
                    html += '<option value="5-Quality_Management">5-Quality Management</option>';
                    html += '<option value="6-Team_Management">6-Team Management</option>';
                    html += '<option value="7-Communication_Management">7-Communication Management</option>';
                    html += '<option value="8-Risk_Management">8-Risk Management</option>';
                    html += '<option value="9-Stakeholder_Management">9-Stakeholder Management</option>';
                    html += '<option value="10-Procurement_Management">10-Procurement Management</option>';
                }
                if(Repository.lang_system == 'ES') {
                    html += '<option value="1-Manejo_Integracion">1-Manejo De La Integracion</option>';
                    html += '<option value="2-Manejo_Alcance">2-Manejo Del Alcance</option>';
                    html += '<option value="3-Manejo_Tiempo">3-Manejo Del Tiempo</option>';
                    html += '<option value="4-Manjeo_Costos">4-Manejo De Los Costos</option>';
                    html += '<option value="5-Manejo_Calidad">5-Manejo De La Calidad</option>';
                    html += '<option value="6-Manjeo_Equipo">6-Manejo Del Equipo</option>';
                    html += '<option value="7-Manjeo_Comunicaciones">7-Manejo De Las Comunicaciones</option>';
                    html += '<option value="8-Manjeo_Riesgos">8-Manejo De Los Riesgos</option>';
                    html += '<option value="9-Manejo_Interesados">9-Manejo De Los Interesados</option>';
                    html += '<option value="10-Manjeo_Adquisiciones">10-Manejo De Las Adquisiciones</option>';
                }
                $('#knowledge_area').selectize()[0].selectize.destroy();


                $('#knowledge_area').html(html);
                $('#knowledge_area').selectize();
            });


            $('#directory').selectize();

            $("#knowledge_area").on('change', function () {
                var html = '<option value="" selected="selected">Directory...</option>';

                if (Repository.lang_system == 'ES') {
                    html += '<option value="1-Urgente">1-Urgente</option>';
                    html += '<option value="2-Correos">2-Correos</option>';
                    html += '<option value="3-Minutas">3-Minutas</option>';
                    html += '<option value="4-Reportes">4-Reportes</option>';
                    html += '<option value="5-Legales">5-Legales</option>';
                    html += '<option value="6-Planes">6-Planes</option>';
                    html += '<option value="7-Metricas">7-Metricas</option>';
                    html += '<option value="8-Otros">8-Otros</option>';
                    html += '<option value="9-Archivo">9-Archivo</option>';
                }
                if (Repository.lang_system == 'EN') {
                    html += '<option value="1-Urgent">1-Urgent</option>';
                    html += '<option value="2-Mails">2-Mails</option>';
                    html += '<option value="3-Minutes">3-Minutes</option>';
                    html += '<option value="4-Reports">4-Reports</option>';
                    html += '<option value="5-Legal">5-Legal</option>';
                    html += '<option value="6-Plans">6-Plans</option>';
                    html += '<option value="7-Metrics">7-Metrics</option>';
                    html += '<option value="8-Others">8-Others</option>';
                    html += '<option value="9-Archives">9-Archives</option>';
                }

                $('#directory').selectize()[0].selectize.destroy();


                $('#directory').html(html);
                $('#directory').selectize();
            });

            $("#directory").on('change', function () {
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

                Repository.searchDocuments($("#directory").val());
            });
        },


    }
    return Repository;
}());
