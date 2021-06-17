var layout = (function() {
	'use strict';

	var layout = {
		init: function(){
			var self = this;
			var customer = 0;
			var customername = "";
			self.initProjectSelection();
			self.initCustomerSelection();
		},
		initCustomerSelection: function(){
			// cargo los cliente cuando se hace click en el enlace del header
			$('#customer_selection').on('click', function(){
				$.ajax({
			        url: '/customers/forProjectSelection',
			        type: 'GET',
			        dataType: 'json'
			    }).done(
			        function(data){
			        	$('#optionsCustomerSelection').html('');
				//data.view='<option value="-1" >No customer Selected</option> '+data.view;
			        	$('#optionsCustomerSelection').html('<option value="-1" >No customer Selected</option> '+data.view);
						 
			        }
			    );
			});

			// cargo los projectos cuando se elige un cliente
			$('#optionsCustomerSelection').on('change', function(option){
		/*		$.ajax({
			        url: '/customers/forProjectSelectionButton/' + $(this).val(),
			        type: 'GET',
			        dataType: 'json'
			    }).done(
			        function(data){
				        	$('#customerForSelection').html(data.view);
			        }
			    );*/

			    //e.preventDefault();
			    if($('#optionsCustomerSelection').val()!='-1'){
				var project_id = '';
				var project_name ='';
				var customer_id = $('#optionsCustomerSelection').val();
				var customer_name = $('#optionsCustomerSelection option:selected').html();
				this.customer = customer_id;
				this.customername = customer_name;
				var csrf = $(this).data('csrf');

				var data = {'id': project_id, 'name': project_name,'customer_id':customer_id,'customer_name':customer_name, "_token": csrf};

				$.ajax({
			        url: '/projects/select',
			        type: 'POST',
			        dataType: 'json',
			        data: data
			    }).done(
			        function(data){
			        	console.log(1);
			        	location.reload();
			        }
			    );
				}
			});

			// $('.md-input-wrapper > select').kendoComboBox();
		},
			initProjectSelection: function(){
			// cargo los cliente cuando se hace click en el enlace del header
			$('#project_selection').on('click', function(){
				$.ajax({
			        url: '/projects/forProjectSelection/'+customer_id,
			        type: 'GET',
			        dataType: 'json'
			    }).done(
			        function(data){
			        	$('#optionsProjectSelection').html('');
			//data.view='<option value="-1" >No project Selected</option> '+data.view;
			        	$('#optionsProjectSelection').html('<option value="-1" >No project Selected</option> '+data.view);
						
			        }
			    );



		
			});

			// cargo los projectos cuando se elige un cliente
			$('#optionsProjectSelection').on('change', function(){
			/*	$.ajax({
			        url: '/projects/forProjectSelectionButton/' + $(this).val(),
			        type: 'GET',
			        dataType: 'json'
			    }).done(
			        function(data){
			        	$('#projectsForSelection').html(data.view);
			        }
			    );*/
			    if($('#optionsProjectSelection').val()!='-1'){

			    		var project_id = $('#optionsProjectSelection').val();
				var project_name =$('#optionsProjectSelection option:selected').html();
			
				var csrf = $(this).data('csrf');

				var data = {'id': project_id, 'name': project_name,'customer_id':self.customer_id,'customer_name':self.customer_name, "_token": csrf};

				$.ajax({
			        url: '/projects/select',
			        type: 'POST',
			        dataType: 'json',
			        data: data
			    }).done(
			        function(data){
			        	console.log(1);
			        	location.reload();
			        }
			    );
			}
			});

			// $('.md-input-wrapper > select').kendoComboBox();
		},
		selectCustomer: function(){
			$('.customer_for_selection').on('click', function(e){
				e.preventDefault();

				var project_id = $(this).data('id')==undefined ? '':$(this).data('id') ;
				var project_name = $(this).data('name')==undefined ? '': $(this).data('name') ;
				var customer_id = $(this).data('customer_id');
				var customer_name = $(this).data('customer_name');
				var csrf = $(this).data('csrf');

				var data = {'id': project_id, 'name': project_name,'customer_id':customer_id,'customer_name':customer_name, "_token": csrf};

				$.ajax({
			        url: '/projects/select',
			        type: 'POST',
			        dataType: 'json',
			        data: data
			    }).done(
			        function(data){
			        	console.log(1);
			        	location.reload();
			        }
			    );
			});
		},
				selectProject: function(){
			$('.project_for_selection').on('click', function(e){
				e.preventDefault();

				var project_id = $(this).data('id')==undefined ? '':$(this).data('id') ;
				var project_name = $(this).data('name')==undefined ? '': $(this).data('name') ;
				var customer_id = $(this).data('customer_id');
				var customer_name = $(this).data('customer_name');
				var csrf = $(this).data('csrf');

				var data = {'id': project_id, 'name': project_name,'customer_id':customer_id,'customer_name':customer_name, "_token": csrf};

				$.ajax({
			        url: '/projects/select',
			        type: 'POST',
			        dataType: 'json',
			        data: data
			    }).done(
			        function(data){
			        	console.log(1);
			        	location.reload();
			        }
			    );
			});
		}
	};

	return layout;
}());
