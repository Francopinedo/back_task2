var invoice = (function() {
	'use strict';

	var invoice = {
		init: function(message){

            $('.delete-btn').on('click',  function(e){
                e.preventDefault();
                var $delete_url = $(this).attr('href');
                UIkit.modal.confirm('Are you sure?', function(){
                    window.location.replace($delete_url);
                });
            });

			var self = this;

			$('#update_from_project_board').on('click', function(e){
				e.preventDefault();

				var url = API_PATH + 'invoices/' + $(this).data('invoice_id') + '/update_from_project_board';

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

			$('#invoice_pdf').on('click', function(){
				self.printPDF();
			});
		},
		printPDF: function(){
			window.print();
		}
	};

	return invoice;
}());