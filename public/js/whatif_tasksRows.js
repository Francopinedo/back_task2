var whatif_taskRows = (function () {
    'use strict';

    var whatif_taskRows = {
        /**
         * init
         */
        init: function () {

        },
        /**
         * initResources
         */
        initResources: function () {
            var self = this;

            $('#project_role_id,#seniority_id').on('change', function () {

                if ($('#project_role_id').val() != '' && $('#seniority_id').val() != '') {
                    var info_url = API_PATH + 'users?company_id=' + $('#company_id').val() + '&project_role_id=' + $('#project_role_id').val() + '&seniority_id='
                        + $('#seniority_id').val() ;
                        //+ '&workplace=' + $('#workplace').val();

                    $.ajax({
                        url: info_url,
                        type: 'GET',
                        dataType: 'json'
                    }).done(
                        function (data) {
                            $('#user_id').html('');
                            $('#user_id').selectize()[0].selectize.destroy();
                            console.log(data);
                            data = data.data;

                            var html = '<option value="">Users</option>';
                            jQuery.each(data, function (i, value) {

                                 html += '<option value="'+value.id+'">'+value.name+'</option>';
                            });
                            $('#user_id').html(html);
                            $('#user_id').selectize();

                        });
                }
            });




            $('#project_role_id,#seniority_id,#currency_id,#workplace').on('change', function () {

                if ($('#project_role_id').val() != '' && $('#seniority_id').val() != '' && $('#currency_id').val() != '' && $('#workplace').val() != '') {
                    var info_url = API_PATH + 'rates?company_id=' + $('#company_id').val() + '&project_role_id=' + $('#project_role_id').val()
                        + '&seniority_id=' + $('#seniority_id').val() + '&currency_id=' + $('#currency_id').val();
                        //+ '&workplace=' + $('#workplace').val();

                    $.ajax({
                        url: info_url,
                        type: 'GET',
                        dataType: 'json'
                    }).done(
                        function (data) {
                            self.setResources(data.data);
                        }
                    );
                }
            });
        },
        /**
         * setResources
         */
        setResources: function (data) {
            $('#rate').val(data[0].value);
            $('#rate_id').val(data[0].id);
        },
        /**
         * initServices
         */
        initServices: function () {
            var self = this;
            $('#service_id').selectize();
            $('#reimbursable').selectize();
            $('#currency_id').selectize();
            $('#service_id').on('change', function () {

                var info_url = API_PATH + 'services/' + $('#service_id').val();

                $.ajax({
                    url: info_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {

                        self.setServices(data.data);
                    }
                );
            });
        },
        /**
         * setServices
         */
        setServices: function (data) {
            $('#reimbursable').selectize()[0].selectize.destroy();
            $('#currency_id').selectize()[0].selectize.destroy();

            $('#detail').val(data.detail);
            $('#servicecost').val(data.cost);
            $('#serviceamount').val(data.amount);
            $('#reimbursable').val(data.reimbursable);
            $('#currency_id').val(data.currency_id);

            $('#reimbursable').selectize();
            $('#currency_id').selectize();
        },
        /**
         * initExpenses
         */
        initExpenses: function () {
            var self = this;
            $('#expense_id').selectize();
            $('#reimbursable').selectize();
            $('#currency_id').selectize();
            $('#expense_id').on('change', function () {

                var info_url = API_PATH + 'expenses/' + $('#expense_id').val();

                $.ajax({
                    url: info_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {

                        self.setExpenses(data.data);
                    }
                );
            });
        },
        /**
         * setExpenses
         */
        setExpenses: function (data) {
            $('#reimbursable').selectize()[0].selectize.destroy();
            $('#currency_id').selectize()[0].selectize.destroy();


            $('#expensecost').val(data.cost);
            $('#expenseamount').val(data.amount);
            $('#reimbursable').val(data.reimbursable);
            $('#currency_id').val(data.currency_id);
            $('#detail').val(data.detail);

            $('#reimbursable').selectize();
            $('#currency_id').selectize();
        },
        /**
         * initMaterials
         */
        initMaterials: function () {
            var self = this;
            $('#material_id').selectize();
            $('#reimbursable').selectize();
            $('#currency_id').selectize();

            $('#material_id').on('change', function () {

                var info_url = API_PATH + 'materials/' + $('#material_id').val();

                $.ajax({
                    url: info_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {

                        self.setMaterials(data.data);
                    }
                );
            });
        },
        /**
         * setMaterials
         */
        setMaterials: function (data) {

            $('#reimbursable').selectize()[0].selectize.destroy();
            $('#currency_id').selectize()[0].selectize.destroy();
            $('#materialcost').val(data.cost);
            $('#materialamount').val(data.amount);
            $('#reimbursable').val(data.reimbursable);
            $('#currency_id').val(data.currency_id);
            $('#detail').val(data.detail);

            $('#reimbursable').selectize();
            $('#currency_id').selectize();
        },
        /**
         * initDiscounts
         */
        initDiscounts: function () {
            var self = this;

            $('#discount_id').on('change', function () {

                var info_url = API_PATH + 'discounts/' + $('#discount_id').val();

                $.ajax({
                    url: info_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {

                        self.setDiscounts(data.data);
                    }
                );
            });
        },
        /**
         * setDiscounts
         */
        setDiscounts: function (data) {
            $('#discountamount2').val(data.amount);
            $('#discountamount').val(data.amount);

            if (data.percentage != undefined) {
                $('#discountpercentage2').val(data.percentage);
                $('#discountpercentage').val(data.percentage);

            }

            $('#currency_id').val(data.currency_id);
            $('#name').val(data.detail);
        },
        /**
         * initTaxes
         */
        initTaxes: function () {
            var self = this;

            $('#tax_id').on('change', function () {

                var info_url = API_PATH + 'taxes/' + $('#tax_id').val();

                $.ajax({
                    url: info_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {

                        self.setTaxes(data.data);
                    }
                );
            });
        },
        /**
         * setTaxes
         */
        setTaxes: function (data) {
            $('#taxamount').val(data.value);

            if (data.percentage != undefined) {
                $('#taxpercentage').val(data.percentage);
                $('#taxpercentage2').val(data.percentage);
            }

            $('#currency_id').val(data.currency_id);
            $('#name').val(data.detail);
        }
    };

    return whatif_taskRows;
}());