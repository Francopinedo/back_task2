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
		@if($company->logo_path!="")
                <img height="150" src="{{ base_path() .'/assets/img/companies/'. $company->id .'/'. $company->logo_path }}">
		@endif
                <h3 class="upper red">{{$company->name}}</h3>
                <h4>{{$company->address}}</h4><br>
                {{__('invoices.remit_to')}}: {{$invoice->remit_to}}<br>
                {{__('invoices.bill_to')}}: {{$invoice->bill_to}}<br>

            </td>
            <td>
                <h1>{{__('invoices.invoice')}}</h1> <br>
		@if($customer->logo_path!="")
		<img height="100" src="{{ base_path()  .'/assets/img/customers/'. $customer->id .'/'. $customer->logo_path }}">
		@endif
                <br>
                <b> {{$customer->address}}</b><br>
                {{__('invoices.invoice')}}#{{$invoice->number}}<br>
                {{__('invoices.date')}}: {{ date('d-m-Y', strtotime( $invoice->date->date )) }}<br>
                <b>{{__('invoices.due_date')}}: {{ $invoice->due_date=='0000-00-00'?'0000-00-00': date('d-m-Y', strtotime( $invoice->due_date )) }}</b><br>
                {{__('invoices.page')}}: <span class="page"></span><br>

                {{__('invoices.for')}}: {{$invoice->concept}}<br>
                {{__('invoices.period')}}: {{$invoice->from}} - {{$invoice->to}}<br>
                {{__('invoices.contract')}}: {{$contract->sow_number}}  {{$contract->start_date}}
                - {{$contract->finish_date}}<br><br>
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
        <thead>
        <tr>
            <th colspan="2">
                {{__('invoices.wire_payment')}}
            </th>
        </tr>
        </thead>
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
            $totaldebit=0;
            $totalcredit=0;
            $totaldiscounts=0;
            $totaldiscountspercent=0;
            $countservices=0;
            $countmaterials=0;
            $countexpences=0;
            $countdiscounts=0;
            $counttaxes=0;
             $countdebit=0;
              $countcredit=0;
            $totalresources_hours=0;
            $total_invoices=0;
        @endphp
        <tbody>
        @foreach($invoice_resources as $resource)
            @php

                $totalrate=$resource->rate;
                $totalresources = $totalresources+($totalrate * $resource->hours);
                $totalresources_hours = $totalresources_hours+$resource->hours;

                  $subtotal = $subtotal+($totalrate * $resource->hours);
                  $total_invoices=$subtotal;
            @endphp
            <tr>
                <td>{{$resource->user_name}}  {{$resource->project_role}}  {{$resource->seniority}}  {{$resource->load}}
                    % - {{$resource->comments}}</td>
                <td class="right">{{number_format($resource->rate,2,',','.')}}</td>
                <td class="right">{{$resource->hours}}</td>
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

                $totalrate=$service->amount;
                $totalservices=$totalservices+$service->amount;

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
        @php
        $total_invoices=$total_invoices+$totalservices;
        @endphp
        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_services')}} </th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($totalservices),2,',','.')}}</th>
        </tr>


        @foreach($invoice_materials as $material)
            @php

                $totalrate=$material->amount;
                $totalmaterials=$totalmaterials+$material->amount;
               $subtotal = $subtotal+$totalrate
            @endphp

            <tr>
                <td>{{$material->detail}} </td>
                <td class="right">{{number_format($totalrate,2,',','.')}} </td>
                <td class="right">1</td>
                <td class="right">{{$currency->code}} {{number_format($totalrate,2,',','.')}} </td>
            </tr>
        @endforeach
        @php
        $total_invoices=$total_invoices+$totalmaterials;
        @endphp

        <tr class="">
            <th></th>
            <th class="right "></th>
            <th class="right upper">{{__('invoices.total_materials')}}</th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($totalmaterials),2,',','.')}}</th>
        </tr>


        @foreach($invoice_expenses as $expens)
            @php


                $totalrate=$expens->amount;
                $totalexpences=$totalexpences+$expens->amount;
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
        @php
        $total_invoices=$total_invoices+$totalexpences;
        @endphp
        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_expences')}}</th>
            <th class="right">{{$currency->code}} {{  number_format(($totalexpences),2,',','.')}}</th>
        </tr>


       @foreach($invoice_debit as $debit)
            @php


                $totalrate=$debit->amount;
                $totaldebit=$totaldebit+$debit->amount;
                $countdebit++;
                $subtotal = $subtotal+$totalrate
            @endphp

            <tr>
                <td>{{$debit->detail}} </td>
                <td class="right"> {{number_format($totalrate,2,',','.')}}</td>
                <td class="right">1</td>
                <td class="right">{{$currency->code}} {{number_format($totalrate,2,',','.')}} </td>
            </tr>
        @endforeach
        @php
        $total_invoices=$total_invoices+$totaldebit;
        @endphp
        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_debit')}}</th>
            <th class="right">{{$currency->code}} {{  number_format(($totaldebit),2,',','.')}}</th>
        </tr>


           @foreach($invoice_credit as $credit)
            @php


                $totalrate=$credit->amount;
                $totalcredit=$totalcredit+$credit->amount;
                $countcredit++;
                $subtotal = $subtotal+$totalrate
            @endphp

            <tr>
                <td>{{$credit->detail}} </td>
                <td class="right"> {{number_format($totalrate,2,',','.')}}</td>
                <td class="right">1</td>
                <td class="right">{{$currency->code}} {{number_format($totalrate,2,',','.')}} </td>
            </tr>
        @endforeach
        @php
        $total_invoices=$total_invoices-$totalcredit;
        @endphp
        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_credit')}}</th>
            <th class="right"> - {{$currency->code}} {{  number_format(($totalcredit),2,',','.')}}</th>
        </tr>


        </tbody>
        <tfoot>


        @foreach($invoice_discounts as $discount)
            @php

                $extra ='' ;
                    $totalrate=$discount->amount;

                    if($totalrate==null || $totalrate==0 || $totalrate==''){


                       $totaldiscountspercent= $totaldiscountspercent + $discount->percentage;
                        $extra='%';
                         $totalrate=$discount->percentage;

                    }else{

                        $totaldiscounts=$totaldiscounts+$discount->amount;
                       $totalrate=$discount->amount;

                    }
                    $countdiscounts++;

            @endphp

            <tr>
                <td></td>
                <td class="right"></td>
                <td class="right">{{$discount->name}}</td>
                <td class="right"> - {{$currency->code}} {{number_format($totalrate,2,',','.')}} {{$extra}} </td>
            </tr>
        @endforeach


        @php
            if($totaldiscountspercent>0){

                $totaldiscounts =  $totaldiscounts + (($subtotal * $totaldiscountspercent) / 100);
             }

         $subtotal = $subtotal-$totaldiscounts;
       
        $total_invoices=$total_invoices-$totaldiscounts;
       
        @endphp

        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_discounts')}}</th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($totaldiscounts),2,',','.')}}</th>
        </tr>


        <tr class="">
            <th class="upper"></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.subtotal')}}</th>
            <th class="right bordered">{{$currency->code}} {{number_format($subtotal,2,',','.')}} </th>
        </tr>

        @foreach($invoice_taxes as $tax)
            @php

                $totalrate=$tax->amount;

                    $extra ='';
                if($totalrate==null || $totalrate==0 || $totalrate==''){
                   $totaltaxespercent= $totaltaxespercent + $tax->percentage;
                    $totalrate=$tax->percentage;
                     $extra='%';
                }else{
                   $totaltaxes=$totaltaxes+$tax->amount;
                   $totalrate=$tax->amount;

                }

                $counttaxes++;

            @endphp
      

            <tr>
                <td></td>
                <td class="right"></td>
                <td class="right">{{$tax->name}}</td>
                <td class="right">{{$currency->code}} {{number_format($totalrate,2,',','.')}} {{$extra}}</td>
            </tr>
        @endforeach


        @php
            if($totaltaxespercent>0){

                $totaltaxes =  $totaltaxes + (($subtotal * $totaltaxespercent) / 100);
             }

             $subtotal = $subtotal+$totaltaxes;
        $total_invoices=$total_invoices+$totaltaxes;
  
        @endphp
        <tr class="">
            <th class="upper"></th>
            <th class="right"></th>
            <th class="right upper">{{__('invoices.total_taxes')}}</th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($totaltaxes),2,',','.')}}</th>
        </tr>


        <tr>
            <td></td>
            <td></td>
            <th class="right upper">{{__('invoices.total')}} </th>
            <th class="right ">{{$currency->code}} {{number_format($total_invoices,2,',','.')}} </th>
        </tr>
        </tfoot>
    </table>

    <h3>{{__('invoices.observations')}} </h3><h3><span style=" line-height: 1.6;">{{$invoice->comments}}</span></h3>

    <span class="page-break"></span>
</div>

</body>
</html>
