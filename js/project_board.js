var projectBoard = (function() {
	'use strict';

	var projectBoard = {
		data: {
			resources: [],
			expenses: [],
			services: [],
			materials: [],
			adjustments: []
		},
		init: function(message){
			var self = this;

			$('#update_from_contracts').on('click', function(e){
				e.preventDefault();

				var url = API_PATH + 'project_board/' + $(this).data('project_id') + '/update_from_contract';

            	UIkit.modal.confirm(message, function(){

					$.ajax({
	    		        url: url,
	    		        type: 'GET',
	    		        dataType: 'json'
	    		    }).done(
	    		        function(data){
	    		        	location.reload();
	    		        }
	    		    );
            	});
			});

			// esto esta sin terminar
			// $('#project_board_csv').on('click', function(){
			// 	self.exportCSV();
			// });

			$('#project_board_pdf').on('click', function(){
				self.printPDF();
			});
		},
		printPDF: function(){
			window.print();
		}
		// exportCSV: function(){ // todo esto esta sin terminar
		// 	var self = this;
		// 	var dataToExport = [];

		// 	$.each(self.data.resources, function(index, data){
		// 		console.log(data);
		// 	});

		// 	var x = new CSVExport(self.data);
		// }
	};

	return projectBoard;
}());