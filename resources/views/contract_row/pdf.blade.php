<html>
<head>
    <style>
        body {
            font-family: Helvetica;
            font-size: 11px;
        }

        @page {
            margin: 30px 30px 30px 30px;
        }

        header {
            font-size: 12px;
            position: fixed;
            left: 0px;

            height: 150px;
            top: -0px;
            right: 0px;

        }

        footer {
            font-size: 12px;
            position: fixed;
            left: 0px;
            bottom: -20px;
            right: 0px;
            border: 1px solid black;
            height: 160px;

        }

        .page:after {
            content: counter(page);
        }

        .main {
            position: relative;
            top: 400px;

            margin-bottom: 150px;

        }

        footer {
            width: 60%;
        }

        footer p {
            text-align: right;
        }

        footer .izq {
            text-align: left;
        }

        .upper {
            text-transform: uppercase;
        }

        .detail_table thead tr:first-child th {
            border-bottom: 1px solid black;
            border-top: 1px solid black;
        }

        .detail_table tfoot {
            border: 0px solid black;
        }

        .detail_table tbody {
            border-bottom: 1px solid black;
            border-top: 1px solid black;
        }

        .right {
            float: right;
            text-align: right
        }

        .red {
            color: red;
        }

        span.page-break {
            page-break-inside: auto;
        }

        .bordered, .bordered th {
            border-bottom: 1px solid #000000;
        }

        h3, h4 {
            padding: 0px;
            line-height: 1px;
        }

        /* class works for table */
        /* table.page-break{
             page-break-before:always
         }*/
        /*tr.page-break  { display: block; page-break-before: auto; }*/

    </style>
</head>
<body>
<header>
    <table width="100%">

        <tr>
            <td width="60%">
                <img height="150" src="{{$company->logo_path}}">
                <h3 class="upper red">{{$company->name}}</h3>
                <h4>{{$company->address}}</h4><br>


            </td>
            <td>
                <h1>{{__('contracts.contract')}}</h1> <br><img height="100" src="{{$customer->logo_path}}">
                <br>
                <b> {{$customer->address}}</b><br>
                {{__('contracts.contract')}}#{{$contract->sow_number}}<br>
                {{__('contracts.amendment_number')}}{{$contract->amendment_number}}<br>
                {{__('invoices.date')}}: {{ date('d-m-Y', strtotime( $contract->date )) }}<br>

                {{__('invoices.page')}}: <span class="page"></span><br>

                {{__('invoices.for')}}: {{$contract->service_description}}<br>
                {{__('invoices.period')}}: {{$contract->start_date}} - {{$contract->finish_date}}<br>

                {{$project->name}}<br>

            </td>
        </tr>


        <tr>
            <td colspan="2">
                <br>
                <b>{{__('invoices.all_amounts')}}: {{$currency->name}}</b><br>

            </td>
        </tr>
    </table>
</header>

<footer>
    <table>

        <tbody>
        <tr>
            <td>{{__('invoices.account_owner')}}</td>
            <td>{{$company->name}}</td>
        </tr>
        <tr>
            <td>{{__('invoices.banck_name')}}</td>
            <td>{{$company->bank_name}}</td>
        </tr>
        <tr>
            <td>{{__('invoices.swift_code')}}</td>
            <td>{{$company->swiftcode}}</td>
        </tr>
        <tr>
            <td>{{__('invoices.aba')}}</td>
            <td>{{$company->aba}}</td>
        </tr>
        <tr>
            <td>{{__('invoices.currency')}}</td>
            <td>{{$currency->name}}</td>
        </tr>

        </tbody>
    </table>
</footer>


<div class="main">
    <table width="100%" class="detail_table">
        <thead>
        <tr>
            <th class="upper">{{__('invoices.description')}}</th>
            <th class="upper right">{{__('invoices.cost_unitary')}}</th>
            <th class="upper right">{{__('invoices.quantity')}}</th>
            <th class="upper right">{{__('invoices.total')}}</th>
        </tr>
        <thead>


        @php
            $subtotal=0;
            $totaltaxes=0;
            $totalresources=0;
            $totalmaterials=0;
            $totalservices=0;
            $totaltaxes=0;
            $totaltaxespercent=0;
            $totalexpences=0;
            $totaldiscounts=0;
            $totaldiscountspercent=0;
            $countservices=0;
            $countmaterials=0;
            $countexpences=0;
            $countdiscounts=0;
            $counttaxes=0;
            $totalresources_hours=0;
        @endphp
        <tbody>
        @foreach($invoice_resources as $resource)
            @php

                $totalrate=$resource->rate_exchage;
                $totalresources = $totalresources+($totalrate);
                $totalresources_hours = $totalresources_hours+$resource->hours;

                  $subtotal = $subtotal+($totalrate);
            @endphp
            <tr>
                <td> {{$resource->project_role_title}}  {{$resource->seniority_title}}  {{$resource->load}}
                    % - {{$resource->comments}}</td>
                <td class="right">{{number_format($resource->rate,2,',','.')}}</td>
                <td class="right">{{$resource->qty}} * {{$resource->hours}} Hours</td>
                <td class="right">{{$currency->code}} {{  number_format($totalrate * $resource->hours,2,',','.')}}</td>
            </tr>
        @endforeach

        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_resources')}}</th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($subtotal),2,',','.')}}</th>
        </tr>


        @foreach($invoice_services as $service)

            @php

                $totalrate=$service->rate_exchage;
                $totalservices=$totalservices+$service->rate_exchage;

                 $countservices++;
                $subtotal = $subtotal+$totalrate
            @endphp
            <tr>
                <td>{{$service->detail}} </td>
                <td class="right">{{ number_format($totalrate,2,',','.') }} </td>
                <td class="right">1</td>
                <td class="right">{{$currency->code}} {{ number_format($totalrate,2,',','.') }} </td>
            </tr>
        @endforeach
        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_services')}} </th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($totalservices),2,',','.')}}</th>
        </tr>


        @foreach($invoice_materials as $material)
            @php

                $totalrate=$material->rate_exchage;
                $totalmaterials=$totalmaterials+$material->rate_exchage;
               $subtotal = $subtotal+$totalrate
            @endphp

            <tr>
                <td>{{$material->detail}} </td>
                <td class="right">{{number_format($totalrate,2,',','.')}} </td>
                <td class="right">1</td>
                <td class="right">{{$currency->code}} {{number_format($totalrate,2,',','.')}} </td>
            </tr>
        @endforeach


        <tr class="">
            <th></th>
            <th class="right "></th>
            <th class="right upper">{{__('invoices.total_materials')}}</th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($totalmaterials),2,',','.')}}</th>
        </tr>


        @foreach($invoice_expenses as $expens)
            @php


                $totalrate=$expens->rate_exchage;
                $totalexpences=$totalexpences+$expens->rate_exchage;
                $countexpences++;
                $subtotal = $subtotal+$totalrate
            @endphp

            <tr>
                <td>{{$expens->detail}} </td>
                <td class="right"> {{number_format($totalrate,2,',','.')}}</td>
                <td class="right">1</td>
                <td class="right">{{$currency->code}} {{number_format($totalrate,2,',','.')}} </td>
            </tr>
        @endforeach

        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_expences')}}</th>
            <th class="right">{{$currency->code}} {{  number_format(($totalexpences),2,',','.')}}</th>
        </tr>


        </tbody>
        <tfoot>





        <tr>
            <td></td>
            <td></td>
            <th class="right upper">{{__('invoices.total')}} </th>
            <th class="right ">{{$currency->code}} {{number_format($subtotal,2,',','.')}} </th>
        </tr>
        </tfoot>
    </table>



    <span class="page-break"></span>
</div>

</body>
</html>
