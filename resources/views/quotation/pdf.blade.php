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
            top: 300px;

            margin-bottom: 50px;

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
        .right {
            float: left;
            text-align: left
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
               @if(!empty($company->logo_path) || $company->logo_path!='' ) 
                <img height="150" src="{{ base_path() .'/assets/img/companies/'. $company->id .'/'. $company->logo_path}}">
                @endif
                <h3 class="upper red">{{$company->name}}</h3>
                <h4>{{$company->address}}</h4><br>
                {{__('quotations.remit_to')}}: {{$quotation->remit_to}}<br>
                {{__('quotations.bill_to')}}: {{$quotation->bill_to}}<br>
 <b>{{__('quotations.all_amounts')}}: {{$currency->name}}</b>
            </td>
            <td>
                <h1>{{__('quotations.quotation')}}</h1> <br>
                @if(!empty($customer->logo_path) || $customer->logo_path!='' ) 
                <img height="100" src="{{ base_path() .'/assets/img/customers/'. $customer->id .'/'. $customer->logo_path }}">
                @endif
                <br>

                <b> {{$customer->address}}</b><br>
                {{__('quotations.quotation')}}#{{$quotation->number}}<br>
                {{__('quotations.date')}}: {{ date('d-m-Y', strtotime( $quotation->date->date )) }}<br>
                <b>{{__('quotations.due_date')}}: {{ date('d-m-Y', strtotime( $quotation->due_date )) }}</b><br>
                {{__('quotations.page')}}: <span class="page"></span><br>

                {{__('quotations.for')}}: {{$quotation->concept}}<br>
                {{__('quotations.period')}}: {{$quotation->from}} - {{$quotation->to}}<br>

                {{$project->name}}<br>


            </td>
        </tr>


       
    </table>
</header>


<div class="main">
    <table width="100%" class="detail_table">
        <thead>
        <tr>
            <th class="upper">{{__('quotations.description')}}</th>
            <th class="upper right">{{__('quotations.cost_unitary')}}</th>
            <th class="upper right">{{__('quotations.quantity')}}</th>
            <th class="upper right">{{__('quotations.total')}}</th>
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
        <tr class="">
            <th class="upper  upper left bordered">{{__('quotations.resources')}}</th>
            <th></th>
            <th class=""></th>
            <th class=""></th>
        </tr>
 @if($resources_select=='1')
        @foreach($tasks as $task)
            <?php $totaltarea =0;
            $totlahorastarea=0;?>
            <tr>
                <td colspan="4" style="padding-top:1px; padding-left: {{$task->level}}0px"><h3>{{$task->description}}</h3></td>
            </tr>
            @foreach($quotation_resources as $resource)
                @if($resource->task_id==$task->id)
                    @php

                        $totalrate=$resource->rate;
                        $totalresources = $totalresources+($totalrate * $resource->hours);
                        $totalresources_hours = $totalresources_hours+$resource->hours;

                          $subtotal = $subtotal+($totalrate * $resource->hours);
                    @endphp

                    <tr >
                        <td style="padding-left: {{$task->level}}0px">{{$resource->user_name}}  {{$resource->project_role}}  {{$resource->seniority}}  {{$resource->load}}
                            % - {{$resource->comments}}</td>
                        <td class="right">{{number_format($resource->rate,2,',','.')}}</td>
                        <td class="right">{{$resource->hours}}</td>
                        <td class="right">{{$currency->code}} {{  number_format($totalrate * $resource->hours,2,',','.')}}</td>
                    </tr>
                    <?php $totaltarea = $totaltarea+($totalrate * $resource->hours);
                    $totlahorastarea=$totlahorastarea+$resource->hours?>
                @endif
            @endforeach
            <?php if($task->level==3){?>
            <tr>
                <td colspan="2" style="padding-top:5px; padding-left: {{$task->level}}0px"><h3>Total</h3></td>
                <td>{{$totlahorastarea}}</td>
                <td >{{number_format($totaltarea,2,',','.')}}</td>
            </tr>
            <?php } ?>
        @endforeach
@endif
        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('quotations.total_resources')}}</th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($subtotal),2,',','.')}}</th>
        </tr>

        <tr class="">
            <th class="upper  upper left bordered">{{__('quotations.services')}}</th>
            <th></th>
            <th class=""></th>
            <th class=""></th>
        </tr>
 @if($services_select=='1')
        @foreach($quotation_services as $service)

            @php

                $totalrate=$service->amount_grouped;
                $totalservices=$totalservices+$service->amount_grouped;

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
@endif
        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('quotations.total_services')}} </th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($totalservices),2,',','.')}}</th>
        </tr>

        <tr class="">
            <th class="upper  upper left bordered">{{__('quotations.materials')}}</th>
            <th></th>
            <th class=""></th>
            <th class=""></th>
        </tr>
@if($materials_select=='1')
        @foreach($quotation_materials as $material)
            @php

                $totalrate=$material->amount_grouped;
                $totalmaterials=$totalmaterials+$material->amount_grouped;
               $subtotal = $subtotal+$totalrate
            @endphp

            <tr>
                <td>{{$material->detail}} </td>
                <td class="right">{{number_format($totalrate,2,',','.')}} </td>
                <td class="right">1</td>
                <td class="right">{{$currency->code}} {{number_format($totalrate,2,',','.')}} </td>
            </tr>
        @endforeach
@endif

        <tr class="">
            <th></th>
            <th class="right "></th>
            <th class="right upper">{{__('quotations.total_materials')}}</th>
            <th class="right bordered">{{$currency->code}} {{  number_format(($totalmaterials),2,',','.')}}</th>
        </tr>

        <tr class="">
            <th class="upper  upper left bordered">{{__('quotations.expenses')}}</th>
            <th></th>
            <th class=""></th>
            <th class=""></th>
        </tr>
@if($expenses_select=='1')
        @foreach($quotation_expenses as $expens)
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
@endif
        <tr class="">
            <th></th>
            <th class="right"></th>
            <th class="right upper">{{__('quotations.total_expences')}}</th>
            <th class="right">{{$currency->code}} {{  number_format(($totalexpences),2,',','.')}}</th>
        </tr>


        </tbody>
        <tfoot>



        <tr class="">
            <th class="upper"></th>
            <th class="right"></th>
            <th class="right upper">{{__('quotations.subtotal')}}</th>
            <th class="right bordered">{{$currency->code}} {{number_format($subtotal,2,',','.')}} </th>
        </tr>


        <tr>
            <td></td>
            <td></td>
            <th class="right upper">{{__('quotations.total')}} </th>
            <th class="right ">{{$currency->code}} {{number_format($subtotal,2,',','.')}} </th>
        </tr>
        </tfoot>
    </table>

    <h3>{{__('quotations.observations')}} {{$quotation->comments}}</h3>

    <span class="page-break"></span>
</div>

</body>
</html>
