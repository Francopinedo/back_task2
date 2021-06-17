var Ticket = (function () {
    'use strict';

    var Ticket = {
        /*============================
         =            init            =
         ============================*/
        init: function () {
            var self = this;


            $("#severity, #severity2, #impact, #impact2, #probability2, #probability").selectize();

            console.log('inciiado');
            $("#type, #type2").on('change', function () {


                if ($(this).val() != 3) {
                    console.log($(this).val());


                    $("#severity").selectize()[0].selectize.destroy();
                    $("#impact").selectize()[0].selectize.destroy();
                    $("#probability").selectize()[0].selectize.destroy();

                    if ($("#severity2").length > 0) {
                        $("#severity2, #impact2, #probability2").selectize()[0].selectize.destroy();
                        $("#severity2, #impact2, #probability2").val(0);
                        $("#severity2, #impact2, #probability2").selectize();
                    }
                    $("#severity, #impact, #probability").val(0);
                    $("#severity, #impact, #probability").selectize();
                }
            })

            $("#approver_name_selet, #approver_name_selet2").on('change', function () {
                console.log('sdasdadasdasd');
                $("#approver_name").val($("#approver_name_selet").val());
                $("#approver_name2").val($("#approver_name_selet2").val());

            })

        },

    };

    return Ticket;
}());