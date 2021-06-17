/**
 * Created by Giuseppe on 21/02/2018.
 */




var InvoiceDiscounts = (function () {
    'use strict';

    var InvoiceDiscounts = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            InvoiceDiscounts.APP_URL = APP_URL;
            InvoiceDiscounts.API_PATH = API_PATH;
        },

        selectsize : '',


        blocktheother: function (inputtoblock) {

            console.log(inputtoblock);
            if (inputtoblock == '1') {
                $("#discountamount").val(0);
                $("#discountamount2").val(0);
            }
            else {
                $("#discountpercentage").val(0);
                $("#discountpercentage2").val(0);
            }
        },

        events: function () {
        },



    }
    return InvoiceDiscounts;
}());
