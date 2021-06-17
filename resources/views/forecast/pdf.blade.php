<html>
<head>


    <style>

        @page {
            margin: 30px 30px 30px 30px;
        }

        .hidden {
            display: none
        }

        .red {
            background: red !important;
            -webkit-print-color-adjust: exact;
        }

        .green {
            background: green !important;
            -webkit-print-color-adjust: exact;
        }
        .pink{
            background: #ff5722;
        }

        .darkpink{
            background: #ff6fb3;
        }
        .bluelight{
            background: #4e88fb !important;
        }
        .bluedark{
            background: #473cfb !important;
        }

        @media print {
            .hidden {
                display: block !important;
            }

            table td:last-child {
                display: block !important
            }

            span.page-break {
                page-break-inside: auto !important;
            }
        }

        span.page-break {
            page-break-inside: auto;
        }
    </style>

</head>

<body>
<div class="md-card ">


    <div class="md-card-content" style="overflow: auto">
        <div class="uk-grid" data-uk-grid-margin>

            <div class="uk-width-1-1">
                <h2>{{__('forecast.forecast')}}</h2>
            </div>
            <div class="uk-width-1-1">{{__('invoices.all_amounts')}}: <span id="currency_name">{{$currency->name}}</span><br></div>
            <div class="uk-width-1-1">




                <table width="100%" border="1" id="table-forecast">

                    <tbody>
                    <tr>
                        <td>  </td>
                        @foreach($months as $item)

                            <td colspan="3" class="pink"> {{$item}}</td>


                        @endforeach
                    </tr>
                    <tr>
                        <td>  </td>
                        @foreach($months as $item)

                            <td  colspan="3"  class="pink"> Planed</td>
                    

                        @endforeach
                    </tr>
                    <tr>
                        <td   class="bluelight"> TEAM </td>
                        <td colspan="{{ (count($teams)*3)}}">  </td>
                    </tr>
                    <tr>
                        <td> Revenue</td>
                    @foreach($teams as $item)

                        <td colspan="3" > {{$item->planned_revenue}}</td>
                  
                    @endforeach
                    </tr>
                    <tr>
                        <td> Cost</td>
                        @foreach($teams as $item)

                            <td colspan="3" > {{$item->planned_cost}}</td>
  
                        @endforeach
                    </tr>

                    <tr>
                        <td class="bluedark"> Net Margin (%) and Profit $</td>
                        @foreach($teams as $item)

                            <td  colspan="3"  class="{{$item->planed_profit_class}}"> {{$item->planed_profit}}</td>
                        </td>

                        @endforeach
                    </tr>






                    <!---SERVICES-->

                    <tr>
                        <td   class="bluelight"> SERVICES </td>
                        <td colspan="{{ (count($teams)*3)}}">  </td>
                    </tr>
                    <tr>
                        <td> Revenue</td>
                        @foreach($services as $item)

                            <td  colspan="3" > {{$item->planned_revenue}}</td>
 
                        @endforeach
                    </tr>
                    <tr>
                        <td> Cost</td>
                        @foreach($services as $item)


                            <td  colspan="3" > {{$item->planned_cost}}</td>
 

                        @endforeach
                    </tr>

                    <tr>
                        <td class="bluedark"> Net Margin (%) and Profit $</td>
                        @foreach($services as $item)

                            <td  colspan="3"  class="{{$item->planed_profit_class}}"> {{$item->planed_profit}}</td>
 </td>

                        @endforeach
                    </tr>






                    <!---MATERIALS-->

                    <tr>
                        <td   class="bluelight"> MATERIALS </td>
                        <td colspan="{{ (count($teams)*3)}}">  </td>
                    </tr>
                    <tr>
                        <td> Revenue</td>
                        @foreach($materials as $item)

                            <td colspan="3" > {{$item->planned_revenue}}</td>
 
                        @endforeach
                    </tr>
                    <tr>
                        <td> Cost</td>
                        @foreach($materials as $item)

                            <td  colspan="3" > {{$item->planned_cost}}</td>
 
                        @endforeach
                    </tr>

                    <tr>
                        <td class="bluedark"> Net Margin (%) and Profit $</td>
                        @foreach($materials as $item)

                            <td  colspan="3"  class="{{$item->planed_profit_class}}"> {{$item->planed_profit}}</td>
 </td>

                        @endforeach
                    </tr>





                    <!---EXPENSES-->

                    <tr>
                        <td   class="bluelight"> EXPENSES </td>
                        <td colspan="{{ (count($teams)*3)}}">  </td>
                    </tr>
                    <tr>
                        <td> Revenue</td>
                        @foreach($expenses as $item)

                            <td colspan="3" > {{$item->planned_revenue}}</td>
 
                        @endforeach
                    </tr>
                    <tr>
                        <td> Cost</td>
                        @foreach($expenses as $item)


                            <td colspan="3" > {{$item->planned_cost}}</td>
 

                        @endforeach
                    </tr>

                    <tr>
                        <td class="bluedark"> Net Margin (%) and Profit $</td>
                        @foreach($expenses as $item)

                            <td colspan="3" class="{{$item->planed_profit_class}}"> {{$item->planed_profit}}</td>
 </td>

                        @endforeach
                    </tr>

                    <!-- total months--->
                    <tr>
                        <td class="pink"> $ PROFIT/ MONTH</td>
                        @foreach($total_profit_month as $item)
                            <td  COLSPAN="3" class="{{$item['class']}}"> {{number_format($item['total'],2,',','.')}}</td>
                            @endforeach

                    </tr>

                 

                </table>


                <table>
                    <tr>
                        <td class="bluedark">$ TOTAL PROFIT</td><td class="{{$totalprofit<0?'red':'green'}}" >{{number_format($totalprofit,2,',','.')}}</td>
                    </tr>
                   
                </table>
                <span class="page-break"></span>
            </div>
        </div>
    </div>
</div>

</body>
</html>