var DocGen = (function () {
    'use strict';

    var DocGen = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            DocGen.APP_URL = APP_URL;
            DocGen.API_PATH = API_PATH;



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
        events: function () {

                $.ajax({
                    url: 'catalog/show/tagged/' + $("#language").val() + '/' + $("#directory").val(),
                    success: function (data) {
                        console.log(data);
                        var html = '';

                        jQuery.each(data.documentos, function (i, value) {

                            var res = value.split('/');

                            html += '  <div class="uk-width-1-2"><a style="font-size: 20px" onclick="getFromFile(' + value + ')">' + res[2] + ' </a>   ' + '</div>';

                        });

                        console.log(html);
                        $("#documents").html(html);
                    }
                })


                $('#directory').selectize();

                $("#language").on('change', function () {
                    var html = '<option value="">Directory...</option>';

                    if ($("#language").val() == 'ES') {
                        html += '<option value="1-Inicio">1-Inicio</option>';
                        html += '<option value="2-Planificacion">2-Planificacion</option>';
                        html += '<option value="3-Ejecucion">3-Ejecucion</option>';
                        html += '<option value="4-Monitoreo">4-Monitoreo</option>';
                        html += '<option value="5-Cierre">5-Cierre</option>';
                    }
                    if ($("#language").val() == 'EN') {
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


                $("#language").on('change', function () {
                    if($("#directory").val()!="" || $("#directory").val()!=0)
                    {
                        $("#upload_file_div2").removeClass("hidden");
                    }
                    else
                    {
                        $("#upload_file_div2").addClass("hidden");
                    }            

                });

            $("#directory").on('change', function () {
                if($("#directory").val()!="" || $("#directory").val()!=0)
                    {
                $("#upload_file_div2").removeClass("hidden");
                    }else{
                    $("#upload_file_div2").addClass("hidden");
                    }                
                $.ajax({
                    url: 'catalog/show/tagged/' + $("#language").val() + '/' + $("#directory").val(),
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
            });
        }


    }
    return DocGen;
}());

function getFromFile(file)
{
    loading = '<div class="fa-3x"><i class="fa fa-refresh fa-spin"></i></div>'
    $('#loading').html(loading)
    //Separamos nombre de lenguaje y carpeta
    res = file.split('/')
    file = res[3] //Para pasarlo a input hidden
    //Separamos nombre de extensión
    filename = res[3].split('.')

    //Agregamos el nombre del archivo a un input hidden
    var form0 = '<input type="hidden" name="filename" value="'+file+'">'
    $("#metavariables").html(form0)

    $("form#metaform").change()

    $.get('metavariables/get_from_file/'+res[0]+'/'+res[2]+'/'+filename[0], function (result) {

        if (result == 99)
        {
            $("#error-message").html('Please verify that the document have the correct format');
            $('#error-message').show();
            return;
        }
        else
        {
            $('#error-message').html();
            $('#error-message').hide();
        }

        $('#form_document').hide()

        var preview = '<iframe id="previewframe" src = "assets/plugins/ViewerJS/#/'+filename[0]+'.odt" width="100%" height="500" allowfullscreen webkitallowfullscreen></iframe>'
        $('#preview').html(preview)

        var form = '<h4>Complete variables to generate the document</h4>'

        $(result).each( function() {
                form += '<div class="row">'
                form += '<div class="uk-form-row col-sm-12">';
                form += '<label>'+this.name+' '
                
                if (this.caption != null)
                {
                    form += '<i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="'+this.caption+'">'
                    form += '</i>'
                }
                
                form += '</label>'
                
                if (this.width != null)
                {
                    width = this.width
                }
                else
                {
                    width = '50'
                }
                
                if (this.metavariable_kind_name == 'Textarea')
                {
                    form += '<textarea class="form-control"  id="'+this.name+'" name="'+this.name+'" style="width:50%;" rows="5"></textarea>'
                }
                else
                {
                    form += '<input type="'+this.metavariable_kind_name+'" class="form-control" id="'+this.name+'" name="'+this.name+'" style="width:'+width+'%"></input>'
                }

                

                form += '</div></div><hr>'

        });
        
        $("#metavariables").html(form);
    });

    //Obtenemos metagrids
    $.get('metagrids/get_from_file/'+res[0]+'/'+res[2]+'/'+filename[0], function (result) {
        if (!$('#error-message').is(':empty') || result == 99)
        {
            $("#error-message").html('Please verify that the document have the correct format');
            $('#error-message').show();
            $("#loading").html('');
            return;
        }
        else
        {
            $('#error-message').html();
            $('#error-message').hide();
        }

        form = '<br><br><br><h4>Tables</h4>'
        $(result).each( function() {
            
                form += '<strong>Name: '+this.name+'</strong><br>'
                if (this.caption != null)
                    form += '<strong>Caption:</strong><span style="color:red;">'+this.caption+'</span><hr>'
                form += '<div class="col-sm-1">';
                form += '<label>Rows</label>'
                form += '<input type="number" class="form-control" name="'+this.name+'_rows" id="'+this.name+'_rows" onchange="setRowsColumns(\''+this.name+'\')">'
                form += '<span class="md-input-bar "></span>'
                form += '</div>'

                form += '<div class="col-sm-1">';
                form += '<label>Columns</label>'
                form += '<input type="number" class="form-control" name="'+this.name+'_columns" id="'+this.name+'_columns" onchange="setRowsColumns(\''+this.name+'\')">'
                form += '<span class="md-input-bar "></span>'
                form += '</div>'
                form += '<table id="'+this.name+'_table" class="table"></table>'

        });

        form += '<div class="uk-form-row col-sm-6">'
        form += '<div class="uk-grid" data-uk-grid-margin="">'
        form += '<div class="uk-width-medium-1 uk-row-first">'
        form += '<div class="md-input-wrapper">'
        form += '<button class="btn btn-success" id="generate" type="submit">Generate</button>'
        form += '<span class="md-input-bar "></span>'
        form += '</div></div></div></div>'
        
        $("#metagrids").html(form);
        $("#metavariables").show(500);
        $("#metagrids").show(500);
        $("#loading").html('');
    });
}

function setRowsColumns(table_name)
{
    if ($('#'+table_name+'_rows').val() && $('#'+table_name+'_columns').val())
    {
        i = 0
        table = '<label>Insert values for table '+table_name+'</label>'
        while (i < $('#'+table_name+'_rows').val())
        {
            j = 0
            if (i == 0) //Cabeceras con color distinto
                table += '<tr style="background-color: darkblue;">'
            else
                table += '<tr>'
            while (j < $('#'+table_name+'_columns').val())
            {
                value = ''
                if ($('#'+table_name+'_'+i+'_'+j).val())
                    value = $('#'+table_name+'_'+i+'_'+j).val()

                table += '<td><input type="text" class="form-control" id="'+table_name+'_'+i+'_'+j+'" name="'+table_name+'_'+i+'_'+j+'" value="'+value+'"></input></td>'
                j++
            }
            table += '</tr>'
            i++
        }

        $('#'+table_name+'_table').html(table)
    }
}

$("form#metaform").change(function(e) {
    var formData = new FormData(this);

    $.ajax({
        url: 'update_preview',
        type: 'POST',
        data: formData,
        success: function (data) {
            document.getElementById('previewframe').contentWindow.location.reload();
        },
        cache: false,
        contentType: false,
        processData: false
    });

    event.preventDefault();
});
