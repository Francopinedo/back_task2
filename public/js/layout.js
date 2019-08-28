var layout = (function() {
	'use strict';

	var layout = {
		init: function(){
			var self = this;
			self.initProjectSelection();
		},
		initProjectSelection: function(){
			// cargo los cliente cuando se hace click en el enlace del header
			$('#project_selection').on('click', function(){
				$.ajax({
			        url: '/customers/forProjectSelection',
			        type: 'GET',
			        dataType: 'json'
			    }).done(
			        function(data){
			        	$('#projectsForSelection').html('');
			        	$('#optionsProjectSelection').html(data.view);
			        }
			    );
			});

			// cargo los projectos cuando se elige un cliente
			$('#optionsProjectSelection').on('change', function(){
				$.ajax({
			        url: '/projects/forProjectSelection/' + $(this).val(),
			        type: 'GET',
			        dataType: 'json'
			    }).done(
			        function(data){
			        	$('#projectsForSelection').html(data.view);
			        }
			    );
			});

			// $('.md-input-wrapper > select').kendoComboBox();
		},
		selectProject: function(){
			$('.project_for_selection').on('click', function(e){
				e.preventDefault();

				var project_id = $(this).data('id');
				var project_name = $(this).data('name');
				var csrf = $(this).data('csrf');

				var data = {'id': project_id, 'name': project_name, "_token": csrf};

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