/**
 * Created by Giuseppe on 21/02/2018.
 */




var ProfitAndLoss = (function () {
    'use strict';

    var ProfitAndLoss = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH) {

            this.events(API_PATH);

            ProfitAndLoss.API_PATH = API_PATH;

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
            window.location.href='profit_and_loss/pdf' + urlParameters+'&contract_id='+contract_id;

        },
        generateReport: function () {


            $("#table-profit_and_loss tbody").html('');
            $("#table-profit_and_loss tbody").append('<tr><td></td></tr><tr></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td></td></tr><tr></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="bluelight">TEAM</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td>Revenue</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td>Costs</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="bluedark">Net Margin (%) and Profit $</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><br> <td></td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="bluelight">SERVICES</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td>Revenue</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td>Costs</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="bluedark">Net Margin (%) and Profit $</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><br> <td></td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="bluelight">MATERIALS</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td>Revenue</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td>Costs</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="bluedark">Net Margin (%) and Profit $</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><br> <td></td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="bluelight">EXPENSES</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td>Revenue</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td>Costs</td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="bluedark">Net Margin (%) and Profit $</td></tr>');



            $("#table-profit_and_loss tbody tr").eq(1).append('<td class="bluedark">'+$("#project_name").val()+'</td>');


            $("#table-profit_and_loss tbody").append('<tr><td class="pink">$ PROFIT/ MONTH </td></tr>');
            $("#table-profit_and_loss tbody").append('<tr><td class="pink">% MARGIN/ MONTH </td></tr>');



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
                    var total_profit_month =0;
                    var total_margin_month =0;
                    var class_total_profit_month = total_profit_month<0?'red':'green';
                    var class_total_margin_month = total_margin_month<0?'red':'green';
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
                        $("#table-profit_and_loss tbody tr:first").append('<td  class="darkpink" colspan="'+span+'"> Q' + quarth +'</td>');
                        span=0;
                        var beforequart= moment(value).add(1, 'M').utc().quarter();
                    }

                    $("#table-profit_and_loss tbody tr").eq(1).append('<td colspan="3" class="pink">' + month +'</td>');
                    $("#table-profit_and_loss tbody tr").eq(2).append('<td class="pink">Planned</td><td class="pink">Real</td><td class="pink">Difference</td>');

                    var urlParameters = '?period_from=' + value
                        + '&period_to=' + complete_date_end+'&project_id='+project_id+'&company_id='+company+'&customer_id='+customer_id+'&currency_id='+currency_id
                        +'&contract_id='+contract_id;

                    $.ajax({
                        url:ProfitAndLoss.API_PATH+'profit_and_loss/team'+urlParameters,
                        async:false,
                        success:function(data) {
                            data=data.data;
                          //  console.log(data);
                            var planned_revenue = (data.planned_revenue!=undefined)?data.planned_revenue:0;
                            var planned_revenue_nf = (data.planned_revenue_nf!=undefined)?data.planned_revenue_nf:0;
                            var real_revenue = (data.real_revenue!=undefined)?data.real_revenue:0;
                            var real_revenue_nf = (data.real_revenue_nf!=undefined)?data.real_revenue_nf:0;

                            var planned_cost = (data.planned_cost!=undefined)?data.planned_cost:0;
                            var planned_cost_nf = (data.planned_cost_nf!=undefined)?data.planned_cost_nf:0;
                            var real_cost = (data.real_cost!=undefined)?data.real_cost:0;
                            var real_cost_nf = (data.real_cost_nf!=undefined)?data.real_cost_nf:0;

                            var diference_revenue = (data.diference_revenue!=undefined)?data.diference_revenue:0;
                            var diference_cost = (data.diference_cost!=undefined)?data.diference_cost:0;

                            var planed_profit = (data.planed_profit!=undefined)?data.planed_profit:0;
                            var real_profit = (data.real_profit!=undefined)?data.real_profit:0;
                            var diference_profit = (data.diference_profit!=undefined)?data.diference_profit:0;


                            var planed_profit_class = (data.planed_profit_class!=undefined)?data.planed_profit_class:0;
                            var real_profit_class = (data.real_profit_class!=undefined)?data.real_profit_class:0;
                            var diference_profit_class = (data.diference_profit_class!=undefined)?data.diference_profit_class:0;

                            var planed_profit_percent = (data.planed_profit_percent!=undefined)?data.planed_profit_percent:0;
                            var real_profit_percent = (data.real_profit_percent!=undefined)?data.real_profit_percent:0;
                            var diference_profit_percent = (data.diference_profit_percent!=undefined)?data.diference_profit_percent:0;


                            total_revenue_month = total_revenue_month+real_revenue_nf;
                            total_cost_month = total_cost_month+real_cost_nf;



                            total_profit_month=total_revenue_month-total_cost_month;
                            total_margin_month=total_cost_month<0?0:(total_profit_month/total_cost_month)*100;

                            class_total_profit_month = total_profit_month<0?'red':'green';
                            class_total_margin_month = total_margin_month<0?'red':'green';


                            totalcost=totalcost+real_cost_nf;
                            totalcost_planned=totalcost_planned+planned_cost_nf;
                            totalrevenue=totalrevenue+real_revenue_nf;
                            totalrevenue_planed=totalrevenue_planed+planned_revenue_nf;
                            totalprofit=totalrevenue-totalcost;
                            totalmargin=totalcost<=0?0:(totalprofit/totalcost)*100;

                            $("#totalprofit").html(totalprofit.toFixed(2));
                            $("#totalmargin").html(totalmargin.toFixed(2));
                            $("#toalrevenueplaned").html(totalrevenue_planed.toFixed(2));
                            $("#toalrevenuereal").html(totalrevenue.toFixed(2));
                            $("#toalcostreal").html(totalcost.toFixed(2));
                            $("#totalmargin,#totalprofit ").removeClass('red');
                            $("#totalmargin, #totalprofit").removeClass('green');
                            $("#totalmargin").addClass(totalmargin<=0?'red':'green');
                            $("#totalprofit").addClass(totalprofit<=0?'red':'green');
                            $("#toalcostplaned").html(totalcost_planned.toFixed(2));
                            $("#table-profit_and_loss tbody tr").eq(5).append('<td >'+planned_revenue+'</td><td>'+real_revenue+'</td><td>'+diference_revenue+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(6).append('<td >'+planned_cost+'</td><td>'+real_cost+'</td><td>'+diference_cost+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(7).append('<td class="'+planed_profit_class+'" >'+planed_profit+' ('+planed_profit_percent+'%)' +
                                '</td><td class="'+real_profit_class+'">' +real_profit+' ('+real_profit_percent+'%) </td>' +
                                '<td class="'+diference_profit_class+'">'+diference_profit+' ('+diference_profit_percent+'%) </td>');
                        }
                    });



                    $.ajax({
                        url:ProfitAndLoss.API_PATH+'profit_and_loss/services'+urlParameters,
                        async:false,
                        success:function(data) {

                            data=data.data;
                            var planned_revenue = (data.planned_revenue!=undefined)?data.planned_revenue:0;
                            var planned_revenue_nf = (data.planned_revenue_nf!=undefined)?data.planned_revenue_nf:0;
                            var real_revenue = (data.real_revenue!=undefined)?data.real_revenue:0;
                            var real_revenue_nf = (data.real_revenue_nf!=undefined)?data.real_revenue_nf:0;

                            var planned_cost = (data.planned_cost!=undefined)?data.planned_cost:0;
                            var planned_cost_nf = (data.planned_cost_nf!=undefined)?data.planned_cost_nf:0;
                            var real_cost = (data.real_cost!=undefined)?data.real_cost:0;
                            var real_cost_nf = (data.real_cost_nf!=undefined)?data.real_cost_nf:0;
                            var diference_revenue = (data.diference_revenue!=undefined)?data.diference_revenue:0;
                            var diference_cost = (data.diference_cost!=undefined)?data.diference_cost:0;

                            var planed_profit = (data.planed_profit!=undefined)?data.planed_profit:0;
                            var real_profit = (data.real_profit!=undefined)?data.real_profit:0;
                            var diference_profit = (data.diference_profit!=undefined)?data.diference_profit:0;

                            var planed_profit_class = (data.planed_profit_class!=undefined)?data.planed_profit_class:0;
                            var real_profit_class = (data.real_profit_class!=undefined)?data.real_profit_class:0;
                            var diference_profit_class = (data.diference_profit_class!=undefined)?data.diference_profit_class:0;

                            var planed_profit_percent = (data.planed_profit_percent!=undefined)?data.planed_profit_percent:0;
                            var real_profit_percent = (data.real_profit_percent!=undefined)?data.real_profit_percent:0;
                            var diference_profit_percent = (data.diference_profit_percent!=undefined)?data.diference_profit_percent:0;

                            total_revenue_month = total_revenue_month+real_revenue_nf;
                            total_cost_month = total_cost_month+real_cost_nf;

                            total_profit_month=total_revenue_month-total_cost_month;
                            total_margin_month=total_cost_month<0?0:(total_profit_month/total_cost_month)*100;

                             class_total_profit_month = total_profit_month<0?'red':'green';
                             class_total_margin_month = total_margin_month<0?'red':'green';

                            totalcost=totalcost+real_cost_nf;
                            totalcost_planned=totalcost_planned+planned_cost_nf;
                            totalrevenue=totalrevenue+real_revenue_nf;
                            totalrevenue_planed=totalrevenue_planed+planned_revenue_nf;
                            totalprofit=totalrevenue-totalcost;
                            totalmargin=totalcost<=0?0:(totalprofit/totalcost)*100;

                            $("#totalprofit").html(totalprofit.toFixed(2));
                            $("#toalrevenueplaned").html(totalrevenue_planed.toFixed(2));
                            $("#toalrevenuereal").html(totalrevenue.toFixed(2));
                            $("#toalcostreal").html(totalcost.toFixed(2));
                            $("#totalmargin").html(totalmargin.toFixed(2));
                            $("#totalmargin,#totalprofit ").removeClass('red');
                            $("#totalmargin, #totalprofit").removeClass('green');
                            $("#totalmargin").addClass(totalmargin<=0?'red':'green');
                            $("#totalprofit").addClass(totalprofit<=0?'red':'green');
                            $("#toalcostplaned").html(totalcost_planned.toFixed(2));




                            $("#table-profit_and_loss tbody tr").eq(10).append('<td>'+planned_revenue+'</td><td>'+real_revenue+'</td><td>'+diference_revenue+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(11).append('<td>'+planned_cost+'</td><td>'+real_cost+'</td><td>'+diference_cost+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(12).append('<td class="'+planed_profit_class+'" >'+planed_profit+' ('+planed_profit_percent+'%)' +
                                '</td><td class="'+real_profit_class+'">' +real_profit+' ('+real_profit_percent+'%) </td>' +
                                '<td class="'+diference_profit_class+'">'+diference_profit+' ('+diference_profit_percent+'%) </td>');
                        }
                    });

                    $.ajax({
                        url:ProfitAndLoss.API_PATH+'profit_and_loss/materials'+urlParameters,
                        async:false,
                        success:function(data) {
                            data=data.data;
                           // console.log(data);
                            var planned_revenue = (data.planned_revenue!=undefined)?data.planned_revenue:0;
                            var planned_revenue_nf = (data.planned_revenue_nf!=undefined)?data.planned_revenue_nf:0;
                            var real_revenue = (data.real_revenue!=undefined)?data.real_revenue:0;
                            var real_revenue_nf = (data.real_revenue_nf!=undefined)?data.real_revenue_nf:0;

                            var planned_cost = (data.planned_cost!=undefined)?data.planned_cost:0;
                            var planned_cost_nf = (data.planned_cost_nf!=undefined)?data.planned_cost_nf:0;
                            var real_cost = (data.real_cost!=undefined)?data.real_cost:0;
                            var real_cost_nf = (data.real_cost_nf!=undefined)?data.real_cost_nf:0;

                            var diference_revenue = (data.diference_revenue!=undefined)?data.diference_revenue:0;
                            var diference_cost = (data.diference_cost!=undefined)?data.diference_cost:0;


                            var planed_profit = (data.planed_profit!=undefined)?data.planed_profit:0;
                            var real_profit = (data.real_profit!=undefined)?data.real_profit:0;
                            var diference_profit = (data.diference_profit!=undefined)?data.diference_profit:0;

                            var planed_profit_class = (data.planed_profit_class!=undefined)?data.planed_profit_class:0;
                            var real_profit_class = (data.real_profit_class!=undefined)?data.real_profit_class:0;
                            var diference_profit_class = (data.diference_profit_class!=undefined)?data.diference_profit_class:0;

                            var planed_profit_percent = (data.planed_profit_percent!=undefined)?data.planed_profit_percent:0;
                            var real_profit_percent = (data.real_profit_percent!=undefined)?data.real_profit_percent:0;
                            var diference_profit_percent = (data.diference_profit_percent!=undefined)?data.diference_profit_percent:0;



                            total_revenue_month = total_revenue_month+real_revenue_nf;
                            total_cost_month = total_cost_month+real_cost_nf;

                            total_profit_month=total_revenue_month-total_cost_month;
                            total_margin_month=total_cost_month<0?0:(total_profit_month/total_cost_month)*100;

                             class_total_profit_month = total_profit_month<0?'red':'green';
                             class_total_margin_month = total_margin_month<0?'red':'green';


                            totalcost=totalcost+real_cost_nf;
                            totalrevenue=totalrevenue+real_revenue_nf;
                            totalrevenue_planed=totalrevenue_planed+planned_revenue_nf;
                            totalprofit=totalrevenue-totalcost;
                            totalmargin=totalcost<=0?0:(totalprofit/totalcost)*100;
                            totalcost_planned=totalcost_planned+planned_cost_nf;

                            $("#totalprofit").html(totalprofit.toFixed(2));
                            $("#totalmargin").html(totalmargin.toFixed(2));
                            $("#toalrevenueplaned").html(totalrevenue_planed.toFixed(2));
                            $("#toalrevenuereal").html(totalrevenue.toFixed(2));
                            $("#toalcostreal").html(totalcost.toFixed(2));
                            $("#totalmargin,#totalprofit ").removeClass('red');
                            $("#totalmargin, #totalprofit").removeClass('green');
                            $("#totalmargin").addClass(totalmargin<=0?'red':'green');
                            $("#totalprofit").addClass(totalprofit<=0?'red':'green');
                            $("#toalcostplaned").html(totalcost_planned.toFixed(2));

                            $("#table-profit_and_loss tbody tr").eq(15).append('<td>'+planned_revenue+'</td><td>'+real_revenue+'</td><td>'+diference_revenue+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(16).append('<td>'+planned_cost+'</td><td>'+real_cost+'</td><td>'+diference_cost+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(17).append('<td class="'+planed_profit_class+'" >'+planed_profit+' ('+planed_profit_percent+'%)' +
                                '</td><td class="'+real_profit_class+'">' +real_profit+' ('+real_profit_percent+'%) </td>' +
                                '<td class="'+diference_profit_class+'">'+diference_profit+' ('+diference_profit_percent+'%) </td>');
                        }
                    });

                    $.ajax({
                        url:ProfitAndLoss.API_PATH+'profit_and_loss/expenses'+urlParameters,
                        async:false,
                        success:function(data) {
                            data=data.data;
                          //  console.log(data);
                            var planned_revenue = (data.planned_revenue!=undefined)?data.planned_revenue:0;
                            var planned_revenue_nf = (data.planned_revenue_nf!=undefined)?data.planned_revenue_nf:0;
                            var real_revenue = (data.real_revenue!=undefined)?data.real_revenue:0;
                            var real_revenue_nf = (data.real_revenue!=undefined)?data.real_revenue_nf:0;

                            var planned_cost = (data.planned_cost!=undefined)?data.planned_cost:0;
                            var planned_cost_nf = (data.planned_cost_nf!=undefined)?data.planned_cost_nf:0;
                            var real_cost = (data.real_cost!=undefined)?data.real_cost:0;
                            var real_cost_nf = (data.real_cost_nf!=undefined)?data.real_cost_nf:0;

                            var diference_revenue = (data.diference_revenue!=undefined)?data.diference_revenue:0;
                            var diference_cost = (data.diference_cost!=undefined)?data.diference_cost:0;


                            var planed_profit = (data.planed_profit!=undefined)?data.planed_profit:0;
                            var real_profit = (data.real_profit!=undefined)?data.real_profit:0;
                            var diference_profit = (data.diference_profit!=undefined)?data.diference_profit:0;


                            var planed_profit_class = (data.planed_profit_class!=undefined)?data.planed_profit_class:0;
                            var real_profit_class = (data.real_profit_class!=undefined)?data.real_profit_class:0;
                            var diference_profit_class = (data.diference_profit_class!=undefined)?data.diference_profit_class:0;


                            var planed_profit_percent = (data.planed_profit_percent!=undefined)?data.planed_profit_percent:0;
                            var real_profit_percent = (data.real_profit_percent!=undefined)?data.real_profit_percent:0;
                            var diference_profit_percent = (data.diference_profit_percent!=undefined)?data.diference_profit_percent:0;


                            total_revenue_month = total_revenue_month+real_revenue_nf;
                            total_cost_month = total_cost_month+real_cost_nf;

                            total_profit_month=total_revenue_month-total_cost_month;
                            total_margin_month=total_cost_month<0?0:(total_profit_month/total_cost_month)*100;

                            class_total_profit_month = total_profit_month<0?'red':'green';
                            class_total_margin_month = total_margin_month<0?'red':'green';

                            totalcost_planned=totalcost_planned+planned_cost_nf;
                            totalcost=totalcost+real_cost_nf;
                            totalrevenue=totalrevenue+real_revenue_nf;
                            totalrevenue_planed=totalrevenue_planed+planned_revenue_nf;
                            totalprofit=totalrevenue-totalcost;
                            totalmargin=totalcost<=0?0:(totalprofit/totalcost)*100;

                            $("#totalprofit").html(totalprofit.toFixed(2));
                            $("#totalmargin").html(totalmargin.toFixed(2));
                            $("#toalrevenueplaned").html(totalrevenue_planed.toFixed(2));
                            $("#toalrevenuereal").html(totalrevenue.toFixed(2));
                            $("#toalcostreal").html(totalcost.toFixed(2));
                            $("#toalcostplaned").html(totalcost_planned.toFixed(2));
                            $("#totalmargin,#totalprofit ").removeClass('red');
                            $("#totalmargin, #totalprofit").removeClass('green');
                            $("#totalmargin").addClass(totalmargin<=0?'red':'green');
                            $("#totalprofit").addClass(totalprofit<=0?'red':'green');

                            $("#table-profit_and_loss tbody tr").eq(23).append('<td  class="'+class_total_profit_month+'" COLSPAN="3">'+total_profit_month.toFixed(2)+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(24).append('<td class="'+class_total_margin_month+'" COLSPAN="3">'+total_margin_month.toFixed(2)+'%</td>');




                            $("#table-profit_and_loss tbody tr").eq(20).append('<td>'+planned_revenue+'</td><td>'+real_revenue+'</td><td>'+diference_revenue+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(21).append('<td>'+planned_cost+'</td><td>'+real_cost+'</td><td>'+diference_cost+'</td>');
                            $("#table-profit_and_loss tbody tr").eq(22).append('<td class="'+planed_profit_class+'" >'+planed_profit+' ('+planed_profit_percent+'%)' +
                                '</td><td class="'+real_profit_class+'">' +real_profit+' ('+real_profit_percent+'%) </td>' +
                                '<td class="'+diference_profit_class+'">'+diference_profit+' ('+diference_profit_percent+'%) </td>');
                        }
                    });



                }
            }



        },

        parseData:function () {

        },

        events: function (API_PATH) {
            $("#data-form-edit").on('submit', function (e) {
                e.preventDefault();
                ProfitAndLoss.generateReport();
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
    return ProfitAndLoss;
}());
