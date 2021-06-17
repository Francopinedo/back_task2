/**
 * Created by Giuseppe on 21/02/2018.
 */




var Taxes = (function () {
    'use strict';

    var Taxes = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            Taxes.APP_URL = APP_URL;
            Taxes.API_PATH = API_PATH;

        },

        selectsize : '',


        blocktheother: function (inputtoblock) {


            console.log(inputtoblock);
            if (inputtoblock == '1') {
                $("#value").val(0);
                $("#value2").val(0);
            }
            else {
                $("#percentage").val(0);
                $("#percentage2").val(0);
            }
        },

        events: function () {
        },



    }
    return Taxes;
}());
