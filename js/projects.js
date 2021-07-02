/**
 * Created by Giuseppe on 21/02/2018.
 */




var Projects = (function () {
    'use strict';

    var Projects = {
        /**
         * init
         */
        init: function () {
            var self = this;
            $("#customer_id").on('change', function () {
                console.log('sdasdadasdasd');
                $("#customer_name").val($("#customer_id").val());

            })

        },
    }
    return Projects;
}());
