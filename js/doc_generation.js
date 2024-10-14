var DocGen = (function () {
    'use strict';

    var DocGen = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (lang_system, API_PATH, APP_URL, company_id) {
            this.events(lang_system, API_PATH, APP_URL, company_id);
            DocGen.APP_URL = APP_URL;
            DocGen.API_PATH = API_PATH;
            DocGen.lang_system=lang_system; // Language of System
            DocGen.company_id = company_id;
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
                if($('#option').val() == 1){
                    $('#notify').hide();
                    $('#customer').hide();
                    $('#project').hide();
                    $('#container_knowledge_area').hide();
                    $('#container_subfolders').hide();
                }

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

                if($('#option').val() == 2){
                    if($('input[name=project_session]').val() == '1'){
                        $('#customer').show();
                        $('#project').show();
                    }

                    $('#notify').show();
                    $('#container_knowledge_area').show();
                    $('#container_subfolders').show();
                }

                $('#customer_name').on('change', function(){
                    if($(this).val() != ""){
                        $('#notify').hide();
                    }
                });

                if($("#directory").val()!="" || $("#directory").val()!=0)
                    {
                $("#upload_file_div2").removeClass("hidden");
                }else{
                $("#upload_file_div2").addClass("hidden");
                }                
                
            });
            $('#container_subfolders').on('change', function(){
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
                });
            });
        }


    }
    return DocGen;
}());

var g_per = 0;
function cus_scroll(i, per) {
    var doc_ob=document.getElementById("previewframe").contentDocument;
    if(doc_ob.getElementById("canvasContainer") != null){
        doc_ob.getElementById("canvasContainer").scroll(0,i);
        var len = doc_ob['childNodes'][1]['childNodes'][2]['childNodes'][1]['childNodes'][5]['childNodes'].length;
        if((i <= (len-3)*1000) && (i <= (len-3)*1000*per/100)) {
            i+=30;
            var cus_timer = setTimeout(function(){ cus_scroll(i, per) }, 10);
        }
    }
}

function onFocusOnInputField(per) {
    //setTimeout(function(){ cus_scroll(0, per) }, 50);
    var doc_ob=document.getElementById("previewframe").contentDocument;
    g_per = per;
    console.log(per);
}

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
            //alert(JSON.stringify(result));
            $('#error-message').html();
            $('#error-message').hide();
            $('#label_generation').hide();
            $("#loading").html('');
        }
console.log(result);
        $('#form').hide()
        var preview = '<iframe id="previewframe" src = "'+DocGen.APP_URL+'/assets/plugins/ViewerJS/#/'+filename[0]+'.odt" width="100%" height="1000px" allowfullscreen webkitallowfullscreen></iframe>'
        $('#canvas').html(preview)

        var form = '<h4>Complete variables to generate the document</h4>'

        form += '<div class="v-application v-application--is-ltr">'
        form += '<a class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton0" onclick="genDocument(0)">REFRESH</a>'
        form += '&nbsp;'
        form += '<a class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton1" type="submit" onclick="genDocument(1)">SAVE</a>'
        form += '&nbsp;'
        // form += '<a class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton2" onclick="genDocument(2)">GENERATE<br>DOCX</a>'
        // form += '&nbsp;'
        form += '<a class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton2" onclick="genDocument(2)">GENERATE<br>PDF</a>'
        //form += '<a class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton3" href="./'+result[result.length-1]+'.pdf" onclick="genDocument(3)" target="_blank" download>GENERATE<br>PDF</a>'
        form += '&nbsp;'
        // form += '<a type="button" class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton3" href="http://localhost/laravel-signature-pad?v='+result[result.length-1]+'.odt" target="_blank" onclick="catch_signature("'+result[result.length-1]+'.odt")" disabled="true">DIGITAL<br>SIGNATURE</a>'
        form += '<a type="button" title="Boton desabilitado, esta en configuracion" class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton3" disabled="true">DIGITAL<br>SIGNATURE</a>'

        form += '&nbsp;'
        form += '<a class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton4" onclick="genDocument(5)">SEND</a>'
        form += '&nbsp;'
        form += '<a class="v-btn v-btn--bottom v-btn--contained theme--dark v-size--default primary floatButton5" onclick="genDocument(6)">EXIT</a>'
        form += '&nbsp;'
        form += '</div>'

        // Etiquetas para el campo de seleccion de logos companies
        form += '<div class="row">'
        form += '<div class="uk-form-row col-sm-12">'
        form += '<label form="file">Seleccionar Logo de Compania'
        form += '<i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Logo de Compania"></i>'
        form += '</label>'
        form += '<select name="company_logo" id="company_logo" class="form-control" onchange="document.getElementById(logo_company).src = window.URL.createObjectURL(this.value)">'
        form += '</select>'
            // Mostrar imagen
            form += '<div class="thumbnail contenedor_compania">'
            form += '</div>'
        form += '</div>'
        form += '</div>'

        // Etiquetas para el campo de seleccion de logos customers
        form += '<div class="row">'
        form += '<div class="uk-form-row col-sm-12">'
        form += '<label form="file">Seleccionar Logo de Cliente'
        form += '<i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Seleccionar un Logo"></i>'
        form += '</label>'
        form += '<select name="customer_logo" id="customer_logo" class="form-control">'
        form += '</select>'
            // Mostrar imagen
            form += '<div class="thumbnail contenedor_customers">'
            form += '</div>'
        form += '</div>'
        form += '</div>'
        // Cargar el listado de logos de company
        var logos_company = 'logos/companies/'+DocGen.company_id+'/';
        $.ajax({
            url : logos_company,
            success: function (data) {
                $(data).find("a").attr("href", function (i, val) {
                    if( val.match(/\.(jpe?g|png)$/) ) { 
                        $("#company_logo").append( "<option value='"+ val +"'>'"+val+"'</option>" );
                    } 
                });
                $('.contenedor_compania').append('<img alt="Logo" width="50%" id="logo_company" src="logos/companies/'+DocGen.company_id+'/'+$('#company_logo').find('option').first().val()+'"/>');
            }
        });
        // Cargar el listado de los logos de customers
        var logos_customers = 'logos/customers/'+$('#customer_name').val()+'/';
        $.ajax({
            url : logos_customers,
            success: function (data) {
                $(data).find("a").attr("href", function (i, val) {
                    if( val.match(/\.(jpe?g|png)$/) ) { 
                        $("#customer_logo").append( "<option value='"+ val +"'>'"+val+"'</option>" );
                    } 
                });
                $('.contenedor_customers').append('<img alt="Logo" width="50%" id="logo_customer" src="logos/customers/'+$('#customer_name').val()+'/'+$('#customer_logo').find('option').first().val()+'"/>');
            }
        });

        $(result).each( function(index) {
           if(typeof this === 'object' && isNaN(this)){
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
                    form += '<textarea class="form-control"  id="'+this.name+'" name="'+this.name+'" rows="5" onchange="onFocusOnInputField('+(100*index/$(result).length)+')" title="'+this.caption+'">'+this.var+'</textarea>'
                }
                else
                {
                    form += '<input type="'+this.metavariable_kind_name+'" class="form-control" id="'+this.name+'" name="'+this.name+'" style="width:'+width+'%" onchange="onFocusOnInputField('+(100*index/$(result).length)+')" title="'+this.caption+'" value="'+this.var+'"></input>'
                    //form += '<input type="'+this.metavariable_kind_name+'" class="form-control" id="'+this.name+'" name="'+this.name+'" style="width:'+width+'%" value="'+this.var+'"></input>'
                }

                form += '</div></div>'
            }else{
                $('#previewframe').remove();
                var ti = new Date().getTime();
                var preview = '<iframe id="previewframe" src = "'+DocGen.APP_URL+'/assets/plugins/ViewerJS/#/'+filename[0]+'.odt" width="100%" height="98%" allowfullscreen webkitallowfullscreen></iframe>'
                $('#canvas').html(preview);

            }

        });
        form += '<input type="hidden" name="language" value="'+DocGen.lang_system+'">'
        form += '<input type="hidden" name="project_id" value="'+$('#project_name').val()+'">'
        form += '<input type="hidden" name="customer_id" value="'+$('#customer_name').val()+'">'        
        form += '<input type="hidden" name="directory" value="'+$("#directory").val()+'">'
        form += '<input type="hidden" name="knowledge_area" value="'+$('#knowledge_area').val()+'">'
        form += '<input type="hidden" name="archives" value="'+$('#archives').val()+'">'
        form += '<input type="hidden" name="filename2" value="'+filename[0]+'">'

        $("#metavariables").show(500);
        $("#metavariables").html(form);


        //$("#previewframe").css({'height':($("form#dataForm").height()+'px')});
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
    });
    //Obtenemos metagrids
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

                table += '<td><input type="text" class="form-control" onchange="onFocusOnInputField(50)" id="'+table_name+'_'+i+'_'+j+'" name="'+table_name+'_'+i+'_'+j+'" value="'+value+'"></input></td>'
                j++
            }
            table += '</tr>'
            i++
        }

        $('#'+table_name+'_table').html(table)
    }
}




var formData=false;
var formobj=false;
$("form#dataForm").change(function(e) {
    $('#logo_company').attr('src', 'logos/companies/'+DocGen.company_id+'/'+$('#company_logo').val());
    $('#logo_customer').attr('src', 'logos/customers/'+$('#customer_name').val()+'/'+$('#customer_logo').val());

    var form = '<input type="hidden" name="language" value="'+DocGen.lang_system+'">'
    form += '<input type="hidden" name="directory" value="'+$("#directory").val()+'"><input type="hidden" name="filename" value="'+filename[0]+'.'+filename[1]+'">'
    form += '<input type="hidden" name="customer_id" value="'+$('#customer_name').val()+'">'
    form += '<input type="hidden" name="project_id" value="'+$('#project_name').val()+'">'
    form += '<input type="hidden" name="knowledge_area" value="'+$('#knowledge_area').val()+'">'
    form += '<input type="hidden" name="archives" value="'+$('#archives').val()+'">'
    
    $("#dataForm").append(form);
    formData = new FormData(this);
    formobj = this;
    
    e.preventDefault();
});

var pressed_preview = false;
function genDocument(kind)
{
    if(kind == 0 && formobj!=false && formData!=false){
       // loading = '<div class="fa-3x"><i class="fa fa-refresh fa-spin"></i></div>'
        //$('#loading').html(loading)
        $('#kind').val(kind);
        for(var i = 0; i < formobj.length; i++){
            if(formobj[i].value!='') formData.append(formobj[i].name,formobj[i].value);
        }

        $.ajax({
            url: DocGen.APP_URL+'/update_preview',
            type: 'POST',
            data: formData,
            success: function (data) {
             $('#previewframe').remove();
                console.log(data);
                var preview = '<iframe id="previewframe" src="'+DocGen.APP_URL+'/assets/plugins/ViewerJS/#/'+data+'.odt" width="100%" height="98%" allowfullscreen webkitallowfullscreen></iframe>'
                $('#canvas').html(preview)
                pressed_preview = true;
                //$('#loading').html();
                setTimeout(function(){cus_scroll(0,g_per);}, 1500);

           },
            cache: false,
            contentType: false,
            processData: false
        });
    }else if(kind > 0 && kind < 5 && pressed_preview){
        $('#kind').val(kind);
        for(var i = 0; i < formobj.length; i++){
            if(formobj[i].value!='') formData.append(formobj[i].name,formobj[i].value);
        }

        $.ajax({
            url: DocGen.APP_URL+'/update_preview',
            type: 'POST',
            data: formData,
            success: function (data) {
             $('#previewframe').remove()
             var ti = new Date().getTime();
                var preview = '<iframe id="previewframe" src = "'+DocGen.APP_URL+'/assets/plugins/ViewerJS/#/'+data+'.odt" width="100%" height="98%" allowfullscreen webkitallowfullscreen></iframe>'
                $('#canvas').html(preview)
                pressed_preview = true;
                setTimeout(function(){cus_scroll(0,g_per);}, 1500);
                if(kind!=4)alert('Action success!')
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }else if(kind == 5 && pressed_preview){
        $('#kind').val(kind);
        for(var i = 0; i < formobj.length; i++){
            if(formobj[i].value!='') formData.append(formobj[i].name,formobj[i].value);
        }

        $.ajax({
            url: DocGen.APP_URL+'/update_preview',
            type: 'POST',
            data: formData,
            success: function (data) {
                alert(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }else if(kind == 6){
        document.location.href = 'catalog';
    }else{
        alert("You have to enter form data first. and press preview to see the result.");
    }
}

function showSignature(){
    event.preventDefault();
    window.location = "/laravel-signature-pad";
    //$('#page_content_inner').html('<div href="http://localhost/laravel-signature-pad"></div>');
    //let href = $(this).attr('data-attr');
    /*$.ajax({
        url: href,
        beforeSend: function() {
            $('#loader').show();
        },
        // return the result
        success: function(result) {
            $('#smallModal').modal("show");
            $('#smallBody').html(result).show();
        },
        complete: function() {
            $('#loader').hide();
        },
        error: function(jqXHR, testStatus, error) {
           
            alert("Page " + href + " cannot open. Error:" + error);
            $('#loader').hide();
        },
        timeout: 8000
    })
    */
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

function catch_signature(filename){
    console.log(filename);
    $.ajax({
        url: DocGen.APP_URL+'/catch_signature',
        data: {
            filename: filename,
        },
        type: 'GET',
        success: function (data) {
            if(data=='fail'){
                catch_signature();
            }else{
                genDocument(4);
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateDocPreview(id)
{
    //Guardamos en un string el preview
    str = $('#previewframe').contents().find("body").html();
    n = str.search("Resumen ejecutivo");
}