/**
 * Created by Giuseppe on 21/02/2018.
 */




var InvoiceTaxes = (function () {
    'use strict';

    var InvoiceTaxes = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            InvoiceTaxes.APP_URL = APP_URL;
            InvoiceTaxes.API_PATH = API_PATH;
        },

        selectsize : '',


        blocktheother: function (inputtoblock) {

            console.log(inputtoblock);
            if (inputtoblock == '1') {
                $("#taxamount").val(0);
                $("#taxamount2").val(0);
            }
            else {
                $("#taxpercentage").val(0);
                $("#taxpercentage2").val(0);
            }
        },

        events: function () {
        },



    }
    return InvoiceTaxes;
}());
