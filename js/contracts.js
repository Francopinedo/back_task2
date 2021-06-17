var contracts = (function() {
	'use strict';

	var contracts = {
		/**
		 * init
		 */
		init: function(){

		},
		/**
		 * initResources
		 */
		initResources: function(){
			var self = this;

            $('#country_id').selectize();
            $('#city_id2').selectize();
            $('#city_id').selectize();
            $('#country_id2').selectize();

            $("#country_id, #country_id2").on('change', function () {
                console.log('chage....');
                $.ajax({
                    url: API_PATH + '/cities',
                    type: 'GET',
                    data: {country_id: $(this).val(), company_id:$("#company_id").val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">City...</option>';
                        if($('#city_id2').length>0){
                            $('#city_id2').selectize()[0].selectize.destroy();
                        }
                        if($('#city_id').length>0) {
                            $('#city_id').selectize()[0].selectize.destroy();
                        }

                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $('#city_id').html(html);
                        $('#city_id2').html(html);

                        $('#city_id').selectize();
                        $('#city_id2').selectize();
                    }
                );
            });

            $('#office_id').selectize();
            $('#office_id2').selectize();

            $("#city_id, #city_id2").on('change', function () {
                console.log('chage....');
                var html = '<option value="">Office...</option>';
                $.ajax({
                    url: API_PATH + '/offices',
                    type: 'GET',
                    data: {city_id: $(this).val(), company_id:$("#company_id").val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">Office...</option>';
                        if($('#office_id2').length>0){
                            $('#office_id2').selectize()[0].selectize.destroy();
                        }

                        if( $('#office_id').selectize()[0]!=undefined){
                            $('#office_id').selectize()[0].selectize.destroy();
						}



                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.title + '</option>';
                        });

                        $('#office_id2').html(html);
                        $('#office_id').html(html);



                        $('#office_id2').selectize();
                        $('#office_id').selectize();



                    }
                );
            });


			$('#project_role_id,#seniority_id,#currency_id,#workplace,#country_id,#city_id,#office_id').on('change', function(){

				if ($('#project_role_id').val() != '' && $('#seniority_id').val() != '' && $('#currency_id').val() != '' && $('#workplace').val() != ''
				&& $('#country_id').val()!='')  {
					var info_url = API_PATH + 'rates?company_id=' + $('#company_id').val() + '&project_role_id='
						+ $('#project_role_id').val() + '&seniority_id=' + $('#seniority_id').val() + '&currency_id='
						+ $('#currency_id').val() + '&workplace=' + $('#workplace').val()+'&country_id='+$('#country_id').val()+
					'&city_id='+$("#city_id").val()+'&office_id='+$("#office_id").val();

					$.ajax({
	    		        url: info_url,
	    		        type: 'GET',
	    		        dataType: 'json'
	    		    }).done(
	    		        function(data){
	    		        	self.setResources(data.data);
	    		        }
	    		    );
				}
			});



            $('#project_role_id2,#seniority_id2,#currency_id2,#workplace2,#country_id2,#city_id2,#office_id2').on('change', function(){

                if ($('#project_role_id2').val() != '' && $('#seniority_id2').val() != '' && $('#currency_id2').val() != '' && $('#workplace2').val() != ''
                    && $('#country_id2').val()!='')  {
                    var info_url = API_PATH + 'rates?company_id=' + $('#company_id').val() + '&project_role_id='
                        + $('#project_role_id2').val() + '&seniority_id=' + $('#seniority_id2').val() + '&currency_id='
                        + $('#currency_id2').val() + '&workplace=' + $('#workplace2').val()+'&country_id='+$('#country_id2').val()+
                        '&city_id='+$("#city_id2").val()+'&office_id='+$("#office_id2").val();

                    $.ajax({
                        url: info_url,
                        type: 'GET',
                        dataType: 'json'
                    }).done(
                        function(data){
                            data= data.data;
                            $('#rate2').val('');
                            $('#rate_id2').val('');
                            console.log(data[0]);
                            if(data[0]!=undefined){
                                $('#rate2').val(data[0].value);
                                $('#rate_id2').val(data[0].id);
                            }

                        }
                    );
                }
            });
		},
		/**
		 * setResources
		 */
		setResources: function(data){
            $('#rate').val('');
            $('#rate_id').val('');
			if(data[0]!=undefined){
                $('#rate').val(data[0].value);
                $('#rate_id').val(data[0].id);
			}

		},
		/**
		 * initServices
		 */
		initServices: function(){
			var self = this;

			$('#service_id').on('change', function(){

				var info_url = API_PATH + 'services/' + $('#service_id').val();

				$.ajax({
    		        url: info_url,
    		        type: 'GET',
    		        dataType: 'json'
    		    }).done(
    		        function(data){

    		        	self.setServices(data.data);
    		        }
    		    );
			});
		},
		/**
		 * setServices
		 */
		setServices: function(data){
			$('#servicecost').val(data.cost);
			$('#serviceamount').val(data.amount);
			$('#reimbursable').val(data.reimbursable);
			$('#currency_id').val(data.currency_id);
			$('#detail').val(data.detail);
		},

		initform:function () {
            $('#project_id').selectize();


            $('#project_id, #project_id2').on('change', function(){
                var project_id = $(this).val();

                $.ajax({
                    url: API_PATH+'/projects/' + project_id,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function(data){
                        //$('#project_id').html(data.view);


                        data = data.data;
                        //console.log(data);
                        $('#start_date').val(data.start);
                        $('#start_date2').val(data.start);
                        $('#finish_date').val(data.finish);
                        $('#finish_date2').val(data.finish);


                    }
                );
            });

            $('#customer_id').on('change', function(){
                var customer_id = $(this).val();

                $.ajax({
                    url: '/projects/forContracts/' + customer_id,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function(data){
                        //$('#project_id').html(data.view);
                        $('#project_id').selectize()[0].selectize.destroy();



                        var html = '<option value="">Project...</option>';

                        $.each(data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $('#project_id').html(html);
                        $('#project_id').selectize();





                    }
                );
            });
        },
		/**
		 * initExpenses
		 */
		initExpenses: function(){
			var self = this;

			$('#expense_id').on('change', function(){

				var info_url = API_PATH + 'expenses/' + $('#expense_id').val();

				$.ajax({
    		        url: info_url,
    		        type: 'GET',
    		        dataType: 'json'
    		    }).done(
    		        function(data){

    		        	self.setExpenses(data.data);
    		        }
    		    );
			});
		},
		/**
		 * setExpenses
		 */
		setExpenses: function(data){
			$('#expensecost').val(data.cost);
			$('#expenseamount').val(data.amount);
			$('#reimbursable').val(data.reimbursable);
			$('#currency_id').val(data.currency_id);
			$('#detail').val(data.detail);
		},
		/**
		 * initMaterials
		 */
		initMaterials: function(){
			console.log('init materials');
			var self = this;

			$('#material_id').on('change', function(){

				var info_url = API_PATH + 'materials/' + $('#material_id').val();

				$.ajax({
    		        url: info_url,
    		        type: 'GET',
    		        dataType: 'json'
    		    }).done(
    		        function(data){

    		        	self.setMaterials(data.data);
    		        }
    		    );
			});
		},
		/**
		 * setMaterials
		 */
		setMaterials: function(data){
			$('#materialcost').val(data.amount);
			$('#materialamount').val(data.cost);
			$('#reimbursable').val(data.reimbursable);
			$('#currency_id').val(data.currency_id);
			$('#detail').val(data.detail);
		},
		/**
		 * initDiscounts
		 */
		initDiscounts: function(){
			var self = this;

			$('#discount_id').on('change', function(){

				var info_url = API_PATH + 'discounts/' + $('#discount_id').val();

				$.ajax({
    		        url: info_url,
    		        type: 'GET',
    		        dataType: 'json'
    		    }).done(
    		        function(data){

    		        	self.setDiscounts(data.data);
    		        }
    		    );
			});
		},
		/**
		 * setDiscounts
		 */
		setDiscounts: function(data){

            $('#discountamount2').val(data.amount);
            $('#discountamount').val(data.amount);

            if(data.percentage!=undefined){
                $('#discountpercentage2').val(data.percentage);
                $('#discountpercentage').val(data.percentage);

            }



            $('#currency_id').val(data.currency_id);
			$('#name').val(data.detail);
		},
		/**
		 * initTaxes
		 */
		initTaxes: function(){
			var self = this;

			$('#tax_id').on('change', function(){

				var info_url = API_PATH + 'taxes/' + $('#tax_id').val();

				$.ajax({
    		        url: info_url,
    		        type: 'GET',
    		        dataType: 'json'
    		    }).done(
    		        function(data){

    		        	self.setTaxes(data.data);
    		        }
    		    );
			});
		},
		/**
		 * setTaxes
		 */
		setTaxes: function(data){
			$('#taxamount').val(data.value);
			$('#taxamount2').val(data.value);

            if(data.percentage!=undefined){
                $('#taxpercentage').val(data.percentage);
                $('#taxpercentage2').val(data.percentage);
            }

			$('#currency_id').val(data.currency_id);
			$('#name').val(data.detail);
		}
	};

	return contracts;
}());