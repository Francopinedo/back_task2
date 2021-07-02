var tableActions = (function() {
	'use strict';

	var tableActions = {
		/*===============================
		=            initAdd            =
		===============================*/
		initAdd: function() {

			// inicializo acciones del boton ADD NEW
			var $switcher = $('#create_div'),
			    $switcher_toggle = $('#create_div_toggle'),
			    $add_new = $('#add-new'),
			    $html = $('html'),
			    $body = $('body');

			$('#add-new').on('click', function(e){
				e.preventDefault();
				$('#edit_div').css('position', 'fixed');
				$switcher_toggle.show();
				$('#create_div').addClass('switcher_active');
				// $('#data-form input:visible:enabled:first').focus();
			});

			$('#cancel-btn').on('click', function(e){
				e.preventDefault();
				$switcher_toggle.hide();
				$('#create_div').removeClass('switcher_active');
			});

			$switcher_toggle.click(function(e) {
			    e.preventDefault();
			    $switcher.toggleClass('switcher_active');
			    if ($switcher.hasClass('switcher_active')) {
					$('#data-form *:input[type!=hidden]:first').focus();
			    }
			});

			$('#add-btn').on('click', this.sendDataForm);
		},
		/*================================
		=            initEdit            =
		================================*/
		initEdit: function(){
			console.log('edit...');
			var self = this;
			// inicializo acciones del boton editar
			var $switcher_edit = $('#edit_div'),
		        $switcher_edit_toggle = $('#edit_div_toggle'),
		        $edit_url;

        	$('.edit-btn').on('click', function(e){
            	e.preventDefault();
            	$switcher_edit.css('position', 'absolute');
            	$edit_url = $(this).attr('href');
            	$switcher_edit_toggle.show();
            	$('#edit_div').addClass('switcher_active');
            	self.loadEditForm($edit_url);
            });

	        $switcher_edit_toggle.click(function(e) {
	            e.preventDefault();
	            $switcher_edit.toggleClass('switcher_active');
	        });
		},
		/*==================================
		=            initDelete            =
		==================================*/
		initDelete: function(message){
			var self = this;

			$('table').on('click', '.delete-btn', function(e){
            	e.preventDefault();
            	var $delete_url = $(this).attr('href');
            	UIkit.modal.confirm(message, function(){
            		window.location.replace($delete_url);
            	});
            });
		},
		/*================================
		=            initInfo            =
		================================*/
		initInfo: function(){

			$('.info-btn').on('click', function(e){

				$('#loading_info_div').show();

            	e.preventDefault();
            	var $info_url = $(this).attr('href');

    	    	$.ajax({
    		        url: $info_url,
    		        type: 'GET',
    		        dataType: 'json'
    		    }).done(
    		        function(data){
    		        	$('#loading_info_div').hide();
    		            $('#info_div').html(data.view);
    		        }
    		    );
            });
		},
		/*================================
		=            initAjaxCreate            =
		================================*/
		initAjaxCreate: function(){
			var self = this;

			// inicializo acciones del boton editar
			var $switcher_ajax_create = $('#ajax_create_div'),
		        $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
		        $ajax_create_url;

        	$('.ajax_create-btn').on('click', function(e){
            	e.preventDefault();
            	$ajax_create_url = $(this).attr('href');
            	$switcher_ajax_create_toggle.show();
            	$('#ajax_create_div').addClass('switcher_active');
            	$('#ajax_create_div').css('position','absolute');
            	self.loadAjaxCreateForm($ajax_create_url);
            });

	        $switcher_ajax_create_toggle.click(function(e) {
	            e.preventDefault();
	            $switcher_ajax_create.toggleClass('switcher_active');
              //  $('#ajax_create_div').css('position','relative');
	        });
		},
		/*====================================
		=            initEditForm            =
		====================================*/
		initEditForm: function(){

			//$('#data-form-edit input:visible:enabled:first').focus();

			var form = $('#data-form-edit');

			$('#update-btn').click(function(){
				form.submit();
			});

	    	form.on('submit', function(e) {
	    	    e.preventDefault();
	    	    $.ajax({
	    	        url     : form.attr('action'),
	    	        type    : form.attr('method'),
	    	        data    : form.serialize(),
	    	        dataType: 'json',
	    	        success : function ( json )
	    	        {

	    	            // Do something like redirect them to the dashboard...
	    	            window.location.replace(form.data('redirect-on-success'));
	    	        },
	    	        error: function( json )
	    	        {
	    	            if(json.status === 422) {
	    	                var errors = json.responseJSON;
	    	                $.each(json.responseJSON, function (key, value) {
	    	                    $('.'+key+'-error').html(value);

	    	                });
	    	            } else {
	    	                // Error
	    	            }
	    	        }
	    	    });
		    });
		},
		/*====================================
		=            initAjaxCreateForm            =
		====================================*/
		initAjaxCreateForm: function(){

			//$('#data-form-ajax_create input:visible:enabled:first').focus();

			var form = $('#data-form-ajax_create');

			$('#ajax_create-btn').click(function(){
				form.submit();
			});

	    	form.on('submit', function(e) {
	    	    e.preventDefault();
	    	    $.ajax({
	    	        url     : form.attr('action'),
	    	        type    : form.attr('method'),
	    	        data    : form.serialize(),
	    	        dataType: 'json',
	    	        success : function ( json )
	    	        {
	    	        	var explode = form.data('redirect-on-success').split('/');

	    	            // Do something like redirect them to the dashboard...
                        if (form.data('redirect-on-success').indexOf("rows") >= 0 && explode.length<6){
                            var url = form.data('redirect-on-success')+'/'+json.id;

                            window.location.replace(url)
                        }else{
                            window.location.replace(form.data('redirect-on-success'));
                        }
	    	        },
	    	        error: function( json )
	    	        {
	    	            if(json.status === 422) {
	    	                var errors = json.responseJSON;
	    	                $.each(json.responseJSON, function (key, value) {
	    	                	console.log(key, value);
	    	                    $('.'+key+'-error').html(value);
	    	                });
	    	            } else {
	    	                // Error
	    	            }
	    	        }
	    	    });
		    });
		},
		/*====================================
		=            sendDataForm            =
		====================================*/
		sendDataForm: function(){
		    var form = $('#data-form');
            form.off('submit');
	    	form.on('submit', function(e) {
	    		console.log('unsumit');
	    	    e.preventDefault();
	    	    $.ajax({
	    	        url     : form.attr('action'),
	    	        type    : form.attr('method'),
	    	        data    : form.serialize(),
	    	        dataType: 'json',
	    	        success : function ( json )
	    	        {

                        // if (form.data('redirect-on-success').indexOf("rows") >= 0){
                        // 	var url = form.data('redirect-on-success')+'/'+json.id;
                        // 	console.log(json);
                        //      window.location.replace(url)
                        // }else{
                            window.location.replace(form.data('redirect-on-success'));
						// }

	    	            // Do something like redirect them to the dashboard...
	    	          //  window.location.replace(form.data('redirect-on-success'));
	    	        },
	    	        error: function( json )
	    	        {
	    	            if(json.status === 422) {
	    	                var errors = json.responseJSON;
	    	                $.each(json.responseJSON, function (key, value) {
	    	                    $('.'+key+'-error').html(value);
	    	                    $('#'+key+'-error').html(value);
	    	                });



	    	            } else {

	    	            }
	    	        }
	    	    });
		    });

		    form.submit();
		},
		/*====================================
		=            loadEditForm            =
		====================================*/
		loadEditForm: function ($edit_url){
        	$.ajax({
    	        url: $edit_url,
    	        type: 'GET',
    	        dataType: 'json'
    	    }).done(
    	        function(data){
    	            $('.edit_div').html(data.view);
    	            altair_forms.init();
    	        }
    	    );
        },
        /*====================================
		=            loadAjaxCreateForm            =
		====================================*/
		loadAjaxCreateForm: function ($ajax_create_url){
        	$.ajax({
    	        url: $ajax_create_url,
    	        type: 'GET',
    	        dataType: 'json'
    	    }).done(
    	        function(data){
    	            $('.ajax_create_div').html(data.view);
    	        }
    	    );
        },
	};

	return tableActions;
}());

