var DocGen = (function () {
    'use strict';

    var DocGen = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (lang_system, API_PATH, APP_URL) {
            this.events(lang_system, API_PATH, APP_URL);
            DocGen.APP_URL = APP_URL;
            DocGen.API_PATH = API_PATH;
            DocGen.lang_system=lang_system; // Language of System
            
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
            // if($('#directory').val() !=""){
		        // $.ajax({
          //           url: DocGen.APP_URL+'/catalog/show/'+DocGen.lang_system+'/tagged/'+ $('#directory').val(),
          //           success: function (data) {
          //               console.log(data);
          //               var html = '';

          //               jQuery.each(data.documentos, function (i, value) {

          //                   var res = value.split('/');

          //                   html += '  <div class="uk-width-1-2"><a style="font-size: 20px" onclick="getFromFile(' + value + ')">' + res[2] + ' </a>   ' + '</div>';

          //               });

          //               console.log(html);
          //               $("#documents").html(html);
          //           }
          //       })
            // }


            $('#directory').selectize();

            $("#option").on('change', function () {
                var html = '<option value="">Directory...</option>';

                if (DocGen.lang_system == 'ES') {
                    html += '<option value="1-Inicio">1-Inicio</option>';
                    html += '<option value="2-Planificacion">2-Planificacion</option>';
                    html += '<option value="3-Ejecucion">3-Ejecucion</option>';
                    html += '<option value="4-Monitoreo_Control">4-Monitoreo y Control</option>';
                    html += '<option value="5-Cierre">5-Cierre</option>';
                }
                if (DocGen.lang_system == 'EN') {
                    html += '<option value="1-Initial">1-Initial</option>';
                    html += '<option value="2-Planning">2-Planning</option>';
                    html += '<option value="3-Executing">3-Executing</option>';
                    html += '<option value="4-Monitoring_Control">4-Monitoring & Control</option>';
                    html += '<option value="5-Closing">5-Closing</option>';
                }

                $('#directory').selectize()[0].selectize.destroy();


                $('#directory').html(html);
                $('#directory').selectize();


            });


            $("#option").on('change', function () {
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
                    url: DocGen.APP_URL+'/catalog/show/' + DocGen.lang_system + '/tagged/' + $("#directory").val(),
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
            });
        }


    }
    return DocGen;
}());

function getFromFile(file)
{
    $('#canvasContainer').show(500);

    loading = '<div class="fa-3x"><i class="fa fa-refresh fa-spin"></i></div>'
	$('#loading').html(loading)
    //Separamos nombre de lenguaje y carpeta
    res = file.split('/')
    file = res[3] //Para pasarlo a input hidden
    //Separamos nombre de extensión
    filename = res[3].split('.')

    //Agregamos el nombre del archivo a un input hidden
    var form0 = '<input type="hidden" name="filename" value="'+file+'">'
    form0 += '<input type="hidden" name="filename2" value="'+filename[0]+'">'
    $("#metavariables").html(form0)

    $.get(DocGen.APP_URL+'/metavariables/get_from_file/'+res[0]+'/'+res[2]+'/'+filename[0], function (result) {

        if (result == 99)
        {
           // alert('hola')
            $("#error-message").html('Please verify that the document have the correct format');
            $('#error-message').show();
            return;
        }
        else
        {
            $('#error-message').html();
            $('#error-message').hide();
            $('#label_generation').hide();
            $("#loading").html('');
        }
        
        $('#form').hide()

        //var odfelement = document.getElementById("canvas"),
        //odfcanvas = new odf.OdfCanvas(odfelement);
        //odfcanvas.load(DocGen.APP_URL+'/'+filename[0]+'.odt');
        
        var preview = '<iframe id="previewframe2" src = "'+DocGen.APP_URL+'/assets/plugins/ViewerJS/#/'+filename[0]+'.odt" width="100%" height="1000px" allowfullscreen webkitallowfullscreen></iframe>'
        $('#doc_preview').html(preview)
        //TODO: El de arriba está obsoleto, se debe eliminar
        
        var preview = '<iframe id="previewframe" src = "'+DocGen.APP_URL+'/assets/plugins/ViewerJS/#/'+filename[0]+'.odt" width="100%" height="1000px" allowfullscreen webkitallowfullscreen></iframe>'
        $('#canvas').html(preview)

        var form = '<h4>Complete variables to generate the document</h4>'
        //Agregamos botones en estado flotante
        form += '<div class="v-application v-application--is-ltr">'
        form += '<button class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton1" type="submit" onclick="genDocument(3)">Save Draft</button>'
        form += '&nbsp;'
        form += '<button class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton2" type="submit" onclick="genDocument(1)">Generate DOCX</button>'
        form += '&nbsp;'
        form += '<button class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton3" type="submit" onclick="genDocument(2)">Generate PDF</button>'
        form += '&nbsp;'
        form += '<button class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton4" type="submit" onclick="#">Digital Signature</button>'
        form += '&nbsp;'
        form += '</div>'
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
                    width = '100'
                }
                
                if (this.metavariable_kind_name == 'Textarea')
                {
                    form += '<textarea class="form-control"  id="'+this.name+'" name="'+this.name+'" rows="5">'+this.var+'</textarea>'
                }
                else
                {
                    form += '<input type="'+this.metavariable_kind_name+'" class="form-control" id="'+this.name+'" name="'+this.name+'" style="width:'+width+'%" value="'+this.var+'"></input>'
                    //form += '<input type="'+this.metavariable_kind_name+'" class="form-control" id="'+this.name+'" onfocus="updateDocPreview(\''+this.name+'\')" name="'+this.name+'" style="width:'+width+'%" value="'+this.var+'"></input>'
                }

                form += '</div></div>'

        });
        form += '<input type="hidden" name="language" value="'+DocGen.lang_system+'">'
        form += '<input type="hidden" name="directory" value="'+$("#directory").val()+'">'
        form += '<input type="hidden" name="filename2" value="'+filename[0]+'">'
        $("#metavariables").show(500);
        $("#metavariables").html(form);

        $("form#dataForm").change();

        //$("#previewframe").css({'height':($("form#dataForm").height()+'px')});
    });

    //Obtenemos metagrids
    $.get(DocGen.APP_URL+'/metagrids/get_from_file/'+res[0]+'/'+res[2]+'/'+filename[0], function (result) {
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

                form += '<div class="row">'
                form += '<div class="uk-form-row col-sm-12">';
                form += '<label>'+this.name+' '
                
                if (this.caption != null)
                {
                    form += '<i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="'+this.caption+'">'
                    form += '</i>'
                }
                
                form += '</label>'
                form += '</br>'
                form += '<div class="col-sm-6">';
                form += '<label>Rows</label>'
                form += '<input type="number" class="form-control" name="'+this.name+'_rows" id="'+this.name+'_rows" onchange="setRowsColumns(\''+this.name+'\')">'
                form += '<span class="md-input-bar "></span>'
                form += '</div>'

                form += '<div class="col-sm-6">';
                form += '<label>Columns</label>'
                form += '<input type="number" class="form-control" name="'+this.name+'_columns" id="'+this.name+'_columns" onchange="setRowsColumns(\''+this.name+'\')">'
                form += '<span class="md-input-bar "></span>'
                form += '</div>'
                form += '<table id="'+this.name+'_table" class="table"></table>'

        });
        //Agregamos (nuevamente) el nombre del archivo a un input hidden
        form += '<input type="hidden" name="filename" value="'+file+'">'
        //input hidden para tipo de documento
        form += '<input type="hidden" name="kind" id="kind">'
        form += '<div class="uk-form-row col-sm-12">'
        form += '<div class="uk-grid" data-uk-grid-margin="">'
        form += '<div class="uk-width-medium-1 uk-row-first">'
        form += '<span class="md-input-bar "></span>'
        form += '</div></div></div></div>'
        
        $("#metagrids").html(form);
        $("#metavariables").show(500);
        $("#metagrids").show(500);
        $("#loading").html('');

    });

    $("form#dataForm").change()

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

$("form#dataForm").change(function(e) {

    var form = '<input type="hidden" name="language" value="'+DocGen.lang_system+'">'
    form += '<input type="hidden" name="directory" value="'+$("#directory").val()+'"><input type="hidden" name="filename" value="'+filename[0]+'.'+filename[1]+'">'
    
    $("#dataForm").append(form);
    var formData = new FormData(this);
    
	$.ajax({
	    url: DocGen.APP_URL+'/update_preview',
	    type: 'POST',
	    data: formData,
	    success: function (data) {
            //$('#canvas').remove();
            //$('#canvasContainer').html('<div id="canvas"></div>');
            //$('#canvas').html('');
            //var odfelement = document.getElementById("canvas"),
            //odfcanvas = new odf.OdfCanvas(odfelement);
            //odfcanvas.load(DocGen.APP_URL+'/'+data+'.odt');
            var iframe = document.getElementById('previewframe2');
            iframe.src = iframe.src;
            $('#previewframe').remove()
            var preview = '<iframe id="previewframe" src = "'+DocGen.APP_URL+'/assets/plugins/ViewerJS/#/'+data+'.odt" width="100%" height="1000px" allowfullscreen webkitallowfullscreen></iframe>'
            $('#canvas').html(preview)
            //$("#previewframe").css({'height':($("form#dataForm").height()+'px')});
            //document.getElementById('previewframe').contentDocument.location.reload(true);
        },
	    cache: false,
	    contentType: false,
	    processData: false
    });

    e.preventDefault();
});

function genDocument(kind)
{
    event.preventDefault()
    $('#kind').val(kind)
    $("form#dataForm").submit()
}

function showModalEmail(filename)
{
    event.preventDefault()
    $("form#dataForm").change()
    $('#email_filename').html('<input type="hidden" value="'+filename+'" name="filename">')
}

function showModalPreview(filename)
{
    event.preventDefault()
    var preview = '<iframe id="previewframe2" src = "'+DocGen.APP_URL+'/assets/plugins/ViewerJS/#/'+filename+'.odt" width="100%" height="1000px" allowfullscreen webkitallowfullscreen></iframe>'
    $('#canvas').html(preview)

    
    //var odfelement = document.getElementById("doc_preview"),
    //odfcanvas = new odf.OdfCanvas(odfelement);
    //odfcanvas.load(DocGen.APP_URL+'/'+filename+'.odt');
}

function updateDocPreview(id)
{
    console.log('entre')
    //Guardamos en un string el preview
    str = $('#previewframe').contents().find("body").html();
    n = str.search("Resumen ejecutivo");
    //$('#previewframe').contents().find("html,body").animate({ 
    //    scrollTop: 500
    //}, { 
    //    duration: 'medium', easing: 'swing' 
    //});

    //alert(n)
    $('#previewframe').contents().scrollTop(5000);

    //added = 'AAAA';
    //output = [str.slice(0, n), added, str.slice(n)].join('');
    //output = str.replace("Fecha", "AAAA");
    //alert(output)
    //$('#previewframe').contents().find("body").html(output);

    //var iframe = $('#canvas frame').contents();

    //iframe.scrollTop(n);

    //alert(n)
    //$('#canvas:contains("Fecha")').css('background-color', 'red');
}