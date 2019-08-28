var customers_page = (function() {
	'use strict';
	var $i;

	var customers_page = {
		init: function() {

	        var $customers_list = $('#customers_list'),
	            searchArray = [];

	        // get all filters
	        $customers_list.children().each(function() {
	        	if ($(this).attr('data-uk-filter')) {
	        		var thisfilters = $(this).data('uk-filter').split(','),
	        		    thisfiters_length = thisfilters.length;

	        		for($i=0;$i<thisfiters_length;$i++) {
	        		    if($.inArray( thisfilters[$i], searchArray ) == -1) {
	        		        // exclude customers
	        		        searchArray.push(thisfilters[$i]);
	        		    }
	        		}
	        	}
	        });
	        var searchArray_length = searchArray.length;

	        // initialize dynamic grid
	        var $myGrid = UIkit.grid($customers_list,{
	            controls: '#customers_list_filter',
	            gutter: 20
	        });

	        // find user or email
	        $("#customers_list_search").keyup(function(){
	            var sValue = $(this).val().toLowerCase();

	            if(sValue.length > 2) {
	                var filteredItems = '';
	                for($i=0;$i<searchArray_length;$i++) {
	                    if(searchArray[$i].indexOf(sValue) !== -1) {
	                        filteredItems += (filteredItems.length > 1 ? ',' : '') + searchArray[$i];
	                    }
	                }
	                if(filteredItems){
	                    // filter grid items
	                    $myGrid.filter(filteredItems);
	                } else {
	                    // show all
	                    $myGrid.filter('all');
	                }
	            } else if(sValue.length > 0) {
	                // reset filter
	                $myGrid.filter();
	            }

	        });

	        $myGrid.on('afterupdate.uk.grid', function(e, children) {
	            if(children.length > 0) {
	                $('.grid_no_results').fadeOut();
	            } else {
	                $('.grid_no_results').fadeIn();
	            }
	        });

	    }
	};

	return customers_page;
}());