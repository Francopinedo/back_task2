var companyPreference = (function() {
	'use strict';

	var companyPreference = {
		init: function(){
			var self = this;

			// solo envio los input que cambiaron
			$('.old_input').on('keyup', function(){
				$(this).attr('name', 'old[' + $(this).data('prefix') + '][' + $(this).data('id') + ']');
			});

			// Envio form
			$('#save-preferences').on('click', function(e){
				e.preventDefault();
				$(this).bind('click', false);
				self.sendForm();
			});

			self.initDynamicInputs();
		},
		initDelete: function(){
			var self = this;

			$('.delete-btn').on('click', function(e){
				var link = $(this);
            	e.preventDefault();
            	link.children('i').removeClass('fa-times');
            	link.children('i').addClass('fa-spinner fa-spin fa-15 fa-fw');

            	UIkit.modal.confirm('Are you sure?', function(){
        			$.ajax({
        		        url: API_PATH + link.data('resource') + '/' + link.data('id'),
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

        		    link.children('i').addClass('fa-times');
            		link.children('i').removeClass('fa-spinner fa-spin fa-15 fa-fw');

            	}, function(){
            		link.children('i').addClass('fa-times');
            		link.children('i').removeClass('fa-spinner fa-spin fa-15 fa-fw');
            	});
            });
		},
		initDynamicInputs: function(){
			var self= this;
			// Agrego inputs dinamicamente
		},
		sendForm: function(){
			var form = $('#preferences-form');
			$.ajax({
		        url: form.attr('action'),
		        type: 'PATCH',
		        dataType: 'json',
		        data: form.serialize(),
			    success : function ( json )
			    {
			        window.location.replace(form.data('redirect-on-success'));
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
                        window.location.replace(form.data('redirect-on-success'));
			        }
			        $('#save-preferences').unbind('click', false);
			    }
		    });
		}
	};


	return companyPreference;
}());