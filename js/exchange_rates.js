var exchangeRates = (function() {
	'use strict';

	var exchangeRates = {
		init: function(){
			$('#currency_id').on('change', function(){
				var id = $(this).val();
				var code;
				$.getJSON( API_PATH + 'currencies/' + id , function( data ) {
				  	code = data.data.code;

				  	var url = 'http://apilayer.net/api/live?access_key=5cd143ea4a9dd78e9c1b581f49bd6a17&currencies=' + code + '&source=USD&format=1';
				  	$.getJSON( url, function( data ) {
				  		if(typeof data.quotes['USD' + code] === 'number'){
				  			$('.suggested_rate').text(data.quotes['USD' + code]);
						}
						else
						{
							$('.suggested_rate').text('Not Found');
						}
				  	});
				});
			});
		},
		initOnEdit: function(){
			$('#currency_id_on_edit').on('change', function(){
				var id = $(this).val();
				var code;
				$.getJSON( API_PATH + 'currencies/' + id , function( data ) {
				  	code = data.data.code;

				  	var url = 'http://apilayer.net/api/live?access_key=5cd143ea4a9dd78e9c1b581f49bd6a17&currencies=' + code + '&source=USD&format=1';
				  	$.getJSON( url, function( data ) {
				  		if(typeof data.quotes['USD' + code] === 'number'){
				  			$('.suggested_rate').text(data.quotes['USD' + code]);
						}
						else
						{
							$('.suggested_rate').text('Not Found');
						}
				  	});
				});
			});
		}
	};

	return exchangeRates;
}());