var emails = (function() {
	'use strict';

	var emails = {
		init: function(){
		    console.log('initianintg..');
			var self = this;

			$('.email-composer-link').on('click', function(){
				var link = $(this);
				$.ajax({
			        url: API_PATH + 'emails/' + link.data('id'),
			        type: 'GET',
			        dataType: 'json',
				    success : function ( json )
				    {
				    	console.log(json);
				    	// pequeño fix para cuando se borra el contenido de un input y se abre otro email
				    	$('.md-input-wrapper').each(function(){
				    		if(! $(this).hasClass('md-input-filled')){
				    			$(this).addClass('md-input-filled');
				    		}
				    	});
				    	$('textarea#mail_new_message').html(json.data.body);
				    	$('input#mail_new_subject').val(json.data.subject);
				    	$('.loading-email').hide();
				    },
				    error: function( json )
				    {
				        if(json.status === 422) {
				            var errors = json.responseJSON;
				            $.each(json.responseJSON, function (key, value) {
				                $('#'+key+'-error').html(value);
				            });
				        } else {
				            // Error
				        }
				    }
			    });
			});
            $('#reload_emails').on('click', function(e){
                console.log('reload');
                e.preventDefault();
                if (window.confirm('Are you sure?')) {

                    var parametros = {
                        "company_id" :company_id
                };

                    $.ajax({
                        data:  parametros,
                        url:   API_PATH + 'emails/reload',
                        type:  'POST',
                        success:  function (response) {
                            location.reload();
                        }
                    });
                }
            });


            $('#reload_cat').on('click', function(e){
                e.preventDefault();
                if (window.confirm('Are you sure?')) {

                    var parametros = {
                        "company_id" :company_id
                    };

                    $.ajax({
                        data:  parametros,
                        url:   API_PATH + 'email_categories/reload',
                        type:  'POST',
                        success:  function (response) {
                            location.reload();
                        }
                    });
                }
            });

			$('.delete-btn').on('click', function(e){
				var link = $(this);
            	e.preventDefault();
            	link.children('i').removeClass('fa-trash-o');
            	link.children('i').addClass('fa-spinner fa-spin fa-fw');
                var $delete_url = $(this).attr('href');

            	UIkit.modal.confirm('Are you sure?', function(){
                    window.location.replace($delete_url);
        			/*$.ajax({
        		        url: $delete_url,
        		        type: 'DELETE',
        		        dataType: 'json',
        			    success : function ( json )
        			    {
    			        	link.closest('li').remove();
        			    },
        			    error: function( json )
        			    {
        			        if(json.status === 422) {
        			            var errors = json.responseJSON;
        			            $.each(json.responseJSON, function (key, value) {
        			                $('#'+key+'-error').html(value);
        			            });
        			        } else {
        			            // Error
        			        }
        			    }
        		    });

        		    link.children('i').addClass('fa-trash-o');
            		link.children('i').removeClass('fa-spinner fa-spin fa-fw');*/

            	}, function(){
            		link.children('i').addClass('fa-trash-o');
            		link.children('i').removeClass('fa-spinner fa-spin fa-fw');
            	});
            });

            $('#add-email-category').on('click', function(){
            	UIkit.modal.prompt(
            		new_category + ':',
            		'',
            		function(val){
            			console.log(val);
        				$.ajax({
        			        url: API_PATH + 'email_categories',
        			        type: 'POST',
        			        dataType: 'json',
        			        data: {title: val, company_id: company_id},
        				    success : function ( json )
        				    {
        				    	location.reload();
        				        // window.location.replace(form.data('redirect-on-success'));
        				    },
        				    error: function( json )
        				    {
        				    	console.log(json);
        				        if(json.status === 422) {
        				            var errors = json.responseJSON;
        				            $.each(json.responseJSON, function (key, value) {
        				                $('#'+key+'-error').html(value);
        				            });
        				        } else {
        				            // Error
        				        }
        				    }
        			    });
            		});
            });

            self.initSend();
		},

		initSend: function(){
			$('#sendEmail').on('click', function(){
				$.ajax({
			        url: '/emails/send',
			        type: 'POST',
			        dataType: 'json',
			        data: $('#email-form').serialize(),
				    success : function ( json )
				    {
				    	console.log(json);
				        // window.location.replace(form.data('redirect-on-success'));
				    },
				    error: function( json )
				    {
				    	console.log(json);
				        if(json.status === 422) {
				            var errors = json.responseJSON;
				            $.each(json.responseJSON, function (key, value) {
				                $('#'+key+'-error').html(value);
				            });
				        } else {
				            // Error
				        }
				    }
			    });
			});
		}

	};

	return emails;
}());