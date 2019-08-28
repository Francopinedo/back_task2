<html>
<head>
    <style>
        body {
            font-family: sans-serif;
        }

        @page {
            margin: 20px 20px;
        }

        header {
            position: fixed;
            left: 0px;
            top: -160px;
            right: 0px;
            height: 100px;
            background-color: #ddd;
            text-align: center;
        }

        header h1 {
            margin: 10px 0;
        }

        header h2 {
            margin: 0 0 10px 0;
        }

        #capacity_planing-table{
            border: 1px solid black;
        }
        #capacity_planing-table thead th{
            border-bottom: 1px solid black;
        }

        .red {
            background: red;
        }

        .yellow {
            background: yellow;
        }

        .green {
            background: green;
        }
    </style>
<body>


<div class="md-card">
    <div class="md-card-content">

        <div class="uk-grid" data-uk-grid-margin>


            <table class="uk-table" cellspacing="10" width="100%">
                <tr>
                    <th><label>{{ __('capacity_planning.customer_name') }}</label></th>
                    <td>{{ $customer->name }}</td>

                    <th><label>{{ __('capacity_planning.projects') }}</label></th>
                    <td>{{ $project->name  }}</td>

                    <th><label>{{ __('capacity_planning.workgroup') }}</label></th>
                    <td> @if(!empty($workgroup))
                            {{$workgroup->title}}
                        @endif</td>
                </tr>


                <tr>
                    <th><label>{{ __('capacity_planning.period_from') }}</label></th>
                    <td>  {{$period_from}}</td>

                    <th><label>{{ __('capacity_planning.period_to') }}</label></th>
                    <td>{{ $period_to  }}</td>

                    <th><label>{{ __('capacity_planning.contract_working_hours') }}</label></th>
                    <td>
                        {{$hours}} {{__('capacity_planning.hours')}}
                        @if(!empty($contracts[0]->workinghours_from)) {{ $contracts[0]->workinghours_from }}
                        - {{  $contracts[0]->workinghours_to }}
                        @endif
                    </td>
                </tr>


                <tr>
                    <th colspan="4"><h3 style="text-transform: uppercase">{{ $report_label }}</h3></th>

                </tr>


            </table>

        </div>


        <div class="uk-grid" data-uk-grid-margin>

            <div class="uk-width-1-1">


                @if(!empty($result))


                    <table id="capacity_planing-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>

                            <th>{{ __('users.name') }}</th>
                            <th>{{ __('capacity_planning.working_hours') }}</th>
                            <th>{{ __('capacity_planning.absents') }}</th>
                            <th>{{ __('capacity_planning.replacements_hours') }}</th>
                            <th>{{ __('capacity_planning.holidays') }}</th>
                            <th>{{ __('capacity_planning.hours_available') }}</th>
                            <th>{{ __('capacity_planning.hours_asigned') }}</th>
                            <th>{{ __('capacity_planning.efective_capacity') }}</th>

                        </tr>
                        </thead>
                        <tbody>

                        @php

                             $total_hours_available = 0;
                             $total_hours_asigned = 0;
                             $total_efective_capacity = 0;
                        @endphp
                        @foreach ($result as $d)
                            @php
                                $total_hours_available = $total_hours_available+$d->hours_available;
                                $total_hours_asigned = $total_hours_asigned+$d->hours_asigned;

                            @endphp
                            <tr>

                                <td>{{$d->name}}</td>
                                <td>{{$d->working_hours}}</td>
                                <td>{{$d->absents_hours}}</td>
                                <td>{{$d->replacements_hours}}</td>
                                <td>{{$d->holidays_hours}}</td>
                                <td>{{$d->hours_available}}</td>
                                <td>{{$d->hours_asigned}}</td>
                                @php
                                    $class='red';
                                            if($d->efective_capacity<0)
                                    $class='red';
                                if($d->efective_capacity==0)
                                    $class='yellow';
                                if($d->efective_capacity>0)
                                    $class='green';

                                @endphp
                                <td class="{{ $class }}">
                                    {{$d->efective_capacity}}</td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="uk-grid datatables-bottom">
                        <div class="uk-width-medium-1-3" id="datatables-length"></div>
                        <div class="uk-width-medium-1-3" id="datatables-pagination"></div>

                    </div>
                @endif
            </div>
        </div>

        <br><br>
        <div class="uk-grid" data-uk-grid-margin>

            @php
                $total_efective_capacity = $total_hours_available-$total_hours_asigned;
            @endphp
            <div class="uk-width-1-1">


                <table cellpadding="2">
                    <tr>
                        <td>{{ __('capacity_planning.totals_availabe_text') }}</td>
                        <td width="20">{{$total_hours_available}} </td>
                    </tr>
                    <tr>
                        <td>{{ __('capacity_planning.totals_asigned_text') }}</td>
                        <td width="20">{{$total_hours_asigned}} </td>
                    </tr>
                    <tr>
                        <td>{{ __('capacity_planning.totals_effective_capacity_text') }}</td>
                        @php
                            $class='red';
                                    if($total_efective_capacity<0)
                            $class='red';
                        if($total_efective_capacity==0)
                            $class='yellow';
                        if($total_efective_capacity>0)
                            $class='green';

                        @endphp


                        <td width="20" class="{{$class}}">{{$total_efective_capacity}} </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>

