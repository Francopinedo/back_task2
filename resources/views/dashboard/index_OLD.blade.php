@extends('layouts.app')
<link rel="stylesheet" href="{{asset('bower_components/chartist/dist/chartist.css')}}"/>
<link rel="stylesheet" href="{{asset('slick-master/slick/slick.css')}}"/>
<link rel="stylesheet" href="{{asset('slick-master/slick/slick-theme.css')}}"/>
<style>
    .slick-slide {
        height: 500px;
    }

    .slick-slide img {
        height: 500px;
    }

    .pd-2 {
        padding: 20px
    }

    .uk-width-1-3 {
        float: left
    }
     .ct-label
     {
        font-size: 14px;
        fill:#fff;
     }
 .ct-label.ct-horizontal{
    white-space: nowrap;
 }
    .ct-label.ct-horizontal.ct-end {
        color: white;
    }

    .ct-label.ct-vertical.ct-start {
        color: white;
    }

    .ct-legend {
        position: relative;
        z-index: 10;
        list-style: none;
        text-align: center;
    }

    .ct-legend li {
        position: relative;
        padding-left: 23px;
        margin-right: 10px;
        margin-bottom: 3px;
        cursor: pointer;
        display: inline-block;
    }

    .ct-legend li:before {
        width: 12px;
        height: 12px;
        position: absolute;
        left: 0;
        content: '';
        border: 3px solid transparent;
        border-radius: 2px;
    }

    .ct-legend li.inactive:before {
        background: transparent;
    }

    .ct-legend.ct-legend-inside {
        position: absolute;
        top: 0;
        right: 0;
    }

    .ct-legend.ct-legend-inside li {
        display: block;
        margin: 0;
    }

    .ct-legend .ct-series-0:before {
        background-color: #1f77b4;
        border-color: #1f77b4;
    }

    .ct-legend .ct-series-1:before {
        background-color: #ff7f0e;
        border-color: #ff7f0e;
    }

    .ct-legend .ct-series-2:before {
        background-color: #2ca02c;
        border-color: #2ca02c;
    }

    .ct-legend .ct-series-3:before {
        background-color: #d17905;
        border-color: #d17905;
    }

    .ct-legend .ct-series-4:before {
        background-color: #453d3f;
        border-color: #453d3f;
    }

    .ct-chart-line-multipleseries .ct-legend .ct-series-0:before {
        background-color: #d70206;
        border-color: #d70206;
    }

    .ct-chart-line-multipleseries .ct-legend .ct-series-1:before {
        background-color: #f4c63d;
        border-color: #f4c63d;
    }

    .ct-chart-line-multipleseries .ct-legend li.inactive:before {
        background: transparent;
    }

    .crazyPink li.ct-series-0:before {
        background-color: #C2185B;
        border-color: #C2185B;
    }

    .crazyPink li.ct-series-1:before {
        background-color: #E91E63;
        border-color: #E91E63;
    }

    .crazyPink li.ct-series-2:before {
        background-color: #F06292;
        border-color: #F06292;
    }

    .crazyPink li.inactive:before {
        background-color: transparent;
    }

    .crazyPink ~ svg .ct-series-a .ct-line, .crazyPink ~ svg .ct-series-a .ct-point {
        stroke: #C2185B;
    }

    .crazyPink ~ svg .ct-series-b .ct-line, .crazyPink ~ svg .ct-series-b .ct-point {
        stroke: #E91E63;
    }

    .crazyPink ~ svg .ct-series-c .ct-line, .crazyPink ~ svg .ct-series-c .ct-point {
        stroke: #F06292;
    }
    .graphic_alert_1{
        color: #f9e79f ;
    }
    .graphic_alert_2{
        color: #f4d03f  ;
    }
    .graphic_alert_3{
        color: #f8c471  ;
    }
    .graphic_alert_4{
        color: #f39c12  ;
    }
    .graphic_alert_5{
        color:  #b9770e ;
    }
    .graphic_alert_6{
        color: #eb984e   ;
    }
    .graphic_alert_7{
        color: #ec7063   ;
    }
.border_dashboard{
     border-color: #999;
    border-style: solid;
}
</style>


@if(session()->has('project_id') && !session('project_id')=='')
@section('section_title', __('dashboard.dashboard'))
@else
@section('section_title', __('dashboard.admin_dashboard'))
@endif
@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                @if(session()->has('message'))
                    <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                        <a href="#" class="uk-alert-close uk-close"></a>
                        {{ session('message') }}
                    </div>
                @endif

                @if (!Auth::user()->hasRole('admin') )



                    <input type="hidden" id="project_id" value="{{session('project_id')}}">
                    @foreach ($categories as $category)

                        <div class="uk-width-1-1">
                    @if(array_search($category->id, array_column($kpis, 'category'))!== false)
                            <div class="uk-alert uk-alert-info" data-uk-alert>
                                {{ $category->name}}
                            </div>
                         @endif
                            <div data-slick='{"slidesToShow": 3, "slidesToScroll": 3}' class="slick">
                                @foreach ($kpis as $kpi)
                                    @if($kpi->category==$category->id && $kpi->showdashboard=='1')
                                 @if($kpi->kpi=="EV or BCWP")
                                       
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-ev" class="ct-chart ct-perfect-fourth" ></div>
                                        </div>
                                        @endif
                                         @if($kpi->kpi=='AC or ACWP')

                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-ac" class="ct-chart ct-perfect-fourth" ></div>
                                        </div>
                                        @endif
					                @if($kpi->kpi=='PV or BCWS')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-pv" class="ct-chart ct-perfect-fourth" ></div>
                                        </div>
                                        @endif

                                        @if($kpi->kpi=='Total Risk Tickets')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartTicketsRiskTotal" class="ct-chart ct-perfect-fourth" ></div>
                                        </div>
                                        @endif


                                        @if($kpi->kpi=='Response Times')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartResourceUtilization" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif

                                        @if($kpi->kpi=='Total Scope Changes Tickets')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartTicketsScopeChangeTotal" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif
                                    
                                        @if($kpi->kpi=='Tickets By Priority')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartTicketsbyPriority" class="ct-chart ct-perfect-fourth border_dashboard" ></div>
                                        </div>
                                        @endif
                                        @if($kpi->kpi=='Tickets By Type')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <!-- <script> Dashboard.chartTicketsStatstype();</script> -->
                                            <div id="chart-chartTicketsbyType" class="ct-chart ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif
                                        @if($kpi->kpi=='Tickets By Status')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartTicketsbyStatus" class="ct-chart ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif
                                        @if($kpi->kpi=='Tasks by Status')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartTasks" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif
                                        @if($kpi->kpi=='Defects or Bugs by Status')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartBugsStatus" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif

                                        @if($kpi->kpi=='Requirements')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartRequirements" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif

                                        @if($kpi->kpi=='Issues')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartIssues" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif

                                        @if($kpi->kpi=='Missing Milestones')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-percentMissingMilestone" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif

                                        
                                        @if($kpi->kpi=='Risk Schedule')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartMilestonesTasks" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif

                                        @if(!session()->has('project_id') && session('project_id')=='')

                                        @if($kpi->kpi=='Overdue Tasks')

                                                        <?php
                                                        //de donde saco el status?
                                                        ?>
                                                        <div class="pd-2">
                                                            <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                            <div id="chart-chartOverdueTasksTotal" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                                        </div>
                                        @endif
                                        @if($kpi->kpi=='Task Completed')

                                                <div class="pd-2">
                                                <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                <div id="chart-chartTaskCompletedTotal" class="ct-chart  ct-perfect-fourth border_dashboard"> </div>
                                                </div>
                                                @endif
                                      @endif
                                    @if(session()->has('project_id') && !session('project_id')=='')
                                        @if($kpi->kpi=='Overdue Tasks')

                                                            <div class="pd-2">
                                                                <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                                <div id="chart-OverdueTasks" class="ct-chart ct-perfect-fourth" ></div>
                                                            </div>
                                         @endif
                                        @if($kpi->kpi=='Chart Capacity')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-chartCapacity" class="ct-chart ct-perfect-fourth" style=" border-color: #999;border-style: solid;"></div>
                                        </div>
                                        @endif
                              @if($kpi->kpi=='Task Completed')

                                            <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-TaskCompleted" class="ct-chart ct-perfect-fourth" > </div>
                                            </div>
                                            @endif

                                        @endif
                                      
                                         @if(session()->has('project_id') && !session('project_id')=='')

                                         @if($kpi->kpi=='Planned Hours')
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-PlannedHours" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif

                                        
                                        @endif

                                        @if(session()->has('project_id') && !session('project_id')=='')
                                         @if($kpi->kpi=='Completed Projects')
                                        <?php
                                        //PENDIENTE, NO SE QUE TIPO DE GRAFICO VA
                                        ?>
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-CompletedProjects" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif
                                        @endif
                                        @if(session()->has('project_id') && !session('project_id')=='')

                                         @if($kpi->kpi=='Cancelled Projects')
                                        <?php
 

                                        //PENDIENTE, NO SE QUE TIPO DE GRAFICO VA
                                        ?>
                                        <div class="pd-2">
                                            <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                            <div id="chart-CancelledProjects" class="ct-chart  ct-perfect-fourth border_dashboard"></div>
                                        </div>
                                        @endif
                                        @endif
                                      

                                    @endif

                                @endforeach
                            </div>
                        </div>
                    @endforeach


            </div>
            @endif
        </div>
    </div>
    </div>
@endsection
@section('scripts')

    <script src="{{asset('bower_components/chartist/dist/chartist.js')}}"></script>
    <script src="{{asset('js/chartist-plugin-legend-master/chartist-plugin-legend.js')}}"></script>
    <script src="{{asset('slick-master/slick/slick.js')}}"></script>
    <script src="{{asset('bower_components/peity/jquery.peity.js')}}"></script>
    <script src="{{asset('flot-master/jquery.flot.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>

    <script>Dashboard.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>','{{session('project_id')}}');</script>

@endsection
