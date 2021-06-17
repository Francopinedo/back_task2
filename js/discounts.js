/**
 * Created by Giuseppe on 21/02/2018.
 */




var Discounts = (function () {
    'use strict';

    var Discounts = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            Discounts.APP_URL = APP_URL;
            Discounts.API_PATH = API_PATH;

        },

        selectsize : '',


        blocktheother: function (inputtoblock) {


            console.log(inputtoblock);
            if (inputtoblock == '1') {
                $("#amount").val(0);
                $("#amount2").val(0);
            }
            else {
                $("#percentage").val(0);
                $("#percentage2").val(0);
            }
        },

        events: function () {
        },



    }
    return Discounts;
}());
