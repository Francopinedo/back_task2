var workingHours = (function() {
	'use strict';

	var workingHours = {
		init: function(){
			console.log(123);
			$('#generate_working_hours').on('click', function(){

				var info_url = API_PATH + 'working_hours/generate/' + $('#generate_working_hours').data('project_id');

				$.ajax({
    		        url: info_url,
    		        type: 'GET',
    		        dataType: 'json'
    		    }).done(
    		        function(data){
    		        	location.reload();
    		        }
    		    );
			});
		}
	};

	return workingHours;
}());