/**
 * Created by Giuseppe on 21/02/2018.
 */




var Forecast = (function () {
    'use strict';

    var Forecast = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH) {

            this.events(API_PATH);

            Forecast.API_PATH = API_PATH;

        },

        table: '',


        urlparams: '',

        pdf:function () {

            var period_from = $("#period_from").val();
            var period_to = $("#period_to").val();
            var project_id = $("#project_id").val();
            var company = $("#company").val();
            var customer_id = $("#customer_id").val();
            var currency_id = $("#currency_id").val();
            var contract_id = $("#contract_id").val();

            var urlParameters = '?period_from=' + period_from
                + '&period_to=' + period_to+'&project_id='+project_id+'&company_id='+company+'&customer_id='+customer_id+'&currency_id='+currency_id
            window.location.href='forecast/pdf' + urlParameters+'&contract_id='+contract_id;

        },
        generateReport: function () {


            $("#table-forecast tbody").html('');
            $("#table-forecast tbody").append('<tr><td></td></tr><tr></tr>');
            $("#table-forecast tbody").append('<tr><td></td></tr><tr></tr>');
            $("#table-forecast tbody").append('<tr><td class="bluelight">TEAM</td></tr>');
            $("#table-forecast tbody").append('<tr><td>Revenue</td></tr>');
            $("#table-forecast tbody").append('<tr><td>Costs</td></tr>');
        //    $("#table-forecast tbody").append('<tr><td class="bluedark">Net Margin (%) and Profit $</td></tr>');
            $("#table-forecast tbody").append('<tr><br> <td></td></tr>');
            $("#table-forecast tbody").append('<tr><td class="bluelight">SERVICES</td></tr>');
            $("#table-forecast tbody").append('<tr><td>Revenue</td></tr>');
            $("#table-forecast tbody").append('<tr><td>Costs</td></tr>');
          //  $("#table-forecast tbody").append('<tr><td class="bluedark">Net Margin (%) and Profit $</td></tr>');
            $("#table-forecast tbody").append('<tr><br> <td></td></tr>');
            $("#table-forecast tbody").append('<tr><td class="bluelight">MATERIALS</td></tr>');
            $("#table-forecast tbody").append('<tr><td>Revenue</td></tr>');
            $("#table-forecast tbody").append('<tr><td>Costs</td></tr>');
            // $("#table-forecast tbody").append('<tr><td class="bluedark">Net Margin (%) and Profit $</td></tr>');
            $("#table-forecast tbody").append('<tr><br> <td></td></tr>');
            $("#table-forecast tbody").append('<tr><td class="bluelight">EXPENSES</td></tr>');
            $("#table-forecast tbody").append('<tr><td>Revenue</td></tr>');
            $("#table-forecast tbody").append('<tr><td>Costs</td></tr>');
         //   $("#table-forecast tbody").append('<tr><td class="bluedark">Net Margin (%) and Profit $</td></tr>');



            $("#table-forecast tbody tr").eq(1).append('<td class="bluedark">'+$("#project_name").val()+'</td>');


     //       $("#table-forecast tbody").append('<tr><td class="pink">$ PROFIT/ MONTH </td></tr>');
      //      $("#table-forecast tbody").append('<tr><td class="pink">% MARGIN/ MONTH </td></tr>');



            var period_from = $("#period_from").val();
            var period_to = $("#period_to").val();
            var project_id = $("#project_id").val();
            var company = $("#company").val();
            var customer_id = $("#customer_id").val();
            var currency_id = $("#currency_id").val();
            var contract_id = $("#contract_id").val();


            var start = period_from.split('-');
            var end = period_to.split('-');
            var startYear = parseInt(start[0]);
            var endYear = parseInt(end[0]);
            var dates = [];
            var quarth= '';

            var beforequart= '';
            var totalcost=0;
            var totalcost_planned=0;
            var totalrevenue=0;
            var totalrevenue_real=0;
            var totalrevenue_planed=0;
            var totalprofit=0;
            var totalmargin=0;

            for (var i = startYear; i <= endYear; i++) {
                var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
                var startMon = i === startYear ? parseInt(start[1]) - 1 : 0;
                var span=0;
                var contador =0;
                for (var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j + 1) {


                    var total_revenue_month =0;
                    var total_cost_month =0;
                 //   var total_profit_month =0;
                 //   var total_margin_month =0;
                 //   var class_total_profit_month = total_profit_month<0?'red':'green';
                 //   var class_total_margin_month = total_margin_month<0?'red':'green';
                    var month = j + 1;
                    console.log('month', month);


                    var displayMonth = month < 10 ? '0' + month : month;

                    var value = [i, displayMonth, '01'].join('-');

                    console.log(value);


                    var locale = "en-us";
                    var month = moment(value, 'YYYY-MM-DD').format('MMMM YYYY');


                    quarth = moment(value, 'YYYY-MM-DD').utc().quarter();


                    var complete_date_end = moment( [i, displayMonth, moment(i+'-'+displayMonth, "YYYY-MM").daysInMonth()].join('-'), 'YYYY-MM-DD').format('YYYY-MM-DD');


                    if(contador==0){
                        value=period_from;
                    }
                    if(j==endMonth){
                        complete_date_end=period_to;
                    }

                    contador++;
                    span = span+3;
                    console.log(beforequart);
                    console.log(quarth);
                    console.log(span);

                    if(beforequart!=quarth || j==endMonth){
                        $("#table-forecast tbody tr:first").append('<td  class="darkpink" colspan="'+span+'"> Q' + quarth +'</td>');
                        span=0;
                        var beforequart= moment(value).add(1, 'M').utc().quarter();
                    }

                    $("#table-forecast tbody tr").eq(1).append('<td colspan="3" class="pink">' + month +'</td>');
                    $("#table-forecast tbody tr").eq(2).append('<td colspan="3" class="pink">Planned</td>');

                    var urlParameters = '?period_from=' + value
                        + '&period_to=' + complete_date_end+'&project_id='+project_id+'&company_id='+company+'&customer_id='+customer_id+'&currency_id='+currency_id
                        +'&contract_id='+contract_id;

                    $.ajax({
                        url:Forecast.API_PATH+'forecast/team'+urlParameters,
                        async:false,
                        success:function(data) {
                            data=data.data;
                          //  console.log(data);
                            var planned_revenue = (data.planned_revenue!=undefined)?data.planned_revenue:0;
                            var planned_revenue_nf = (data.planned_revenue_nf!=undefined)?data.planned_revenue_nf:0;

                            var planned_cost = (data.planned_cost!=undefined)?data.planned_cost:0;
                            var planned_cost_nf = (data.planned_cost_nf!=undefined)?data.planned_cost_nf:0;

                            var planed_profit = (data.planed_profit!=undefined)?data.planed_profit:0;
                            var planed_profit_class = (data.planed_profit_class!=undefined)?data.planed_profit_class:0;

                            var planed_profit_percent = (data.planed_profit_percent!=undefined)?data.planed_profit_percent:0;
                            totalcost_planned=totalcost_planned+planned_cost_nf;
                            totalrevenue_planed=totalrevenue_planed+planned_revenue_nf;

                            $("#toalrevenueplaned").html(totalrevenue_planed.toFixed(2));
                            $("#toalcostplaned").html(totalcost_planned.toFixed(2));
                            $("#table-forecast tbody tr").eq(5).append('<td colspan="3" >'+planned_revenue+'</td>');
                            $("#table-forecast tbody tr").eq(6).append('<td colspan="3" >'+planned_cost+'</td>');
                            $("#table-forecast tbody tr").eq(7).append('<td colspan="3" class="'+planed_profit_class+'" >'+planed_profit+' ('+planed_profit_percent+'%) </td>');
                        }
                    });



                    $.ajax({
                        url:Forecast.API_PATH+'forecast/services'+urlParameters,
                        async:false,
                        success:function(data) {

                            data=data.data;
                            var planned_revenue = (data.planned_revenue!=undefined)?data.planned_revenue:0;
                            var planned_revenue_nf = (data.planned_revenue_nf!=undefined)?data.planned_revenue_nf:0;

                            var planned_cost = (data.planned_cost!=undefined)?data.planned_cost:0;
                            var planned_cost_nf = (data.planned_cost_nf!=undefined)?data.planned_cost_nf:0;

                            var planed_profit = (data.planed_profit!=undefined)?data.planed_profit:0;
                            var planed_profit_class = (data.planed_profit_class!=undefined)?data.planed_profit_class:0;

                            var planed_profit_percent = (data.planed_profit_percent!=undefined)?data.planed_profit_percent:0;
                           totalcost_planned=totalcost_planned+planned_cost_nf;
                            totalrevenue_planed=totalrevenue_planed+planned_revenue_nf;

                            $("#toalrevenueplaned").html(totalrevenue_planed.toFixed(2));
                            $("#toalcostplaned").html(totalcost_planned.toFixed(2));




                            $("#table-forecast tbody tr").eq(9).append('<td colspan="3">'+planned_revenue+'</td>');
                            $("#table-forecast tbody tr").eq(10).append('<td colspan="3">'+planned_cost+'</td>');
                            $("#table-forecast tbody tr").eq(11).append('<td colspan="3" class="'+planed_profit_class+'" >'+planed_profit+' ('+planed_profit_percent+'%) </td>');
                        }
                    });

                    $.ajax({
                        url:Forecast.API_PATH+'forecast/materials'+urlParameters,
                        async:false,
                        success:function(data) {
                            data=data.data;
                           // console.log(data);
                            var planned_revenue = (data.planned_revenue!=undefined)?data.planned_revenue:0;
                            var planned_revenue_nf = (data.planned_revenue_nf!=undefined)?data.planned_revenue_nf:0;

                            var planned_cost = (data.planned_cost!=undefined)?data.planned_cost:0;
                            var planned_cost_nf = (data.planned_cost_nf!=undefined)?data.planned_cost_nf:0;

                            var planed_profit = (data.planed_profit!=undefined)?data.planed_profit:0;
                            var planed_profit_class = (data.planed_profit_class!=undefined)?data.planed_profit_class:0;

                            var planed_profit_percent = (data.planed_profit_percent!=undefined)?data.planed_profit_percent:0;
                            totalcost_planned=totalcost_planned+planned_cost_nf;
                            totalrevenue_planed=totalrevenue_planed+planned_revenue_nf;

                             $("#toalrevenueplaned").html(totalrevenue_planed.toFixed(2));
                          $("#toalcostplaned").html(totalcost_planned.toFixed(2));

                            $("#table-forecast tbody tr").eq(13).append('<td colspan="3">'+planned_revenue+'</td>');
                            $("#table-forecast tbody tr").eq(14).append('<td colspan="3">'+planned_cost+'</td>');
                            $("#table-forecast tbody tr").eq(15).append('<td colspan="3" class="'+planed_profit_class+'" >'+planed_profit+' ('+planed_profit_percent+'%)</td>');
                        }
                    });

                    $.ajax({
                        url:Forecast.API_PATH+'forecast/expenses'+urlParameters,
                        async:false,
                        success:function(data) {
                            data=data.data;
                            var planned_revenue = (data.planned_revenue!=undefined)?data.planned_revenue:0;
                            var planned_revenue_nf = (data.planned_revenue_nf!=undefined)?data.planned_revenue_nf:0;

                            var planned_cost = (data.planned_cost!=undefined)?data.planned_cost:0;
                            var planned_cost_nf = (data.planned_cost_nf!=undefined)?data.planned_cost_nf:0;

                            var planed_profit = (data.planed_profit!=undefined)?data.planed_profit:0;
                            var planed_profit_class = (data.planed_profit_class!=undefined)?data.planed_profit_class:0;

                            var planed_profit_percent = (data.planed_profit_percent!=undefined)?data.planed_profit_percent:0;
                            totalcost_planned=totalcost_planned+planned_cost_nf;
                            totalrevenue_planed=totalrevenue_planed+planned_revenue_nf;
                            $("#toalrevenueplaned").html(totalrevenue_planed.toFixed(2));
                            $("#toalcostplaned").html(totalcost_planned.toFixed(2));

                     

                            $("#table-forecast tbody tr").eq(17).append('<td  colspan="3">'+planned_revenue+'</td>');
                            $("#table-forecast tbody tr").eq(18).append('<td colspan="3">'+planned_cost+'</td>');
                            $("#table-forecast tbody tr").eq(19).append('<td colspan="3" class="'+planed_profit_class+'" >'+planed_profit+' ('+planed_profit_percent+'%)</td>');
                        }
                    });



                }
            }



        },

        parseData:function () {

        },

        events: function (API_PATH) {
            $("#data-form-edit-submit").on('click', function (e) {
                e.preventDefault();
                Forecast.generateReport();
            });

            $("#currency_id").on('change', function () {
              //  console.log('chage....');
                $.ajax({
                    url: API_PATH + '/currencies/'+$("#currency_id").val(),
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {

                        $("#currency_name").html(data.data.name);


                    }
                );
            });


        },


    }
    return Forecast;
}());
