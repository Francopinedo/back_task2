@extends('layouts.app', ['favoriteTitle' => __('sidebar.KPIS_Report_Time'), 'favoriteUrl' => url(Request::path())])
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
        font-size: 9px;
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
        background-color: #d70206;
        border-color: #d70206;
    }

    .ct-legend .ct-series-1:before {
        background-color: #2ca02c;
        border-color: #2ca02c;
    }

    .ct-legend .ct-series-2:before {
        background-color: #ff7f0e;
        border-color: #ff7f0e;
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
</style>



@section('section_title', __('kpis.kpis'))

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

                @if(!session()->has('project_id'))
                    <div class="uk-width-1-1">
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                    </div>
                @endif

                @if(session()->has('project_id'))

                    <input type="hidden" id="project_id" value="{{session('project_id')}}">
                    @foreach ($categories as $category)

                        <div class="uk-width-1-1">
                            @if($category_kpi !== '')
                                @include('kpi_functions.kpi_general')
                            @else
                                @if(array_search($category->id, array_column($kpis, 'category'))!== false)
                                    <div class="uk-alert uk-alert-info" data-uk-alert>
                                        <a href="#" class="uk-alert"></a>
                                        {{ $category->name}}
                                    </div>
                                @endif
                                <div data-slick='{"slidesToShow": 3, "slidesToScroll": 3}' class="slick">
                                    @foreach ($kpis as $kpi)
                                        @if($kpi->category==$category->id && $kpi->showkpi=='1')
        					               @if($kpi->kpi=="EV or BCWP")
                                               
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-ev" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='AC or ACWP')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-ac" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='PV or BCWS')
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-pv" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='CPI')
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-cpi" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='SPI')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-spi" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='EAC')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}} (CASE 1)</h3><h5> {{$kpi->nombre}}: (you suppose your
                                                        future perfomance will be the same than the actual one: PV/CPI. In the
                                                        beginning of the project PV = EAC</h5>
                                                    <div id="chart-eac1" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}} (CASE 2)</h3><h5>{{$kpi->nombre}}: (you are over buget but
                                                        wont happen again and you will continue with the planned cost
                                                        estimated). EAC = AC + (BAC – EV).</h5>
                                                    <div id="chart-eac2" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}} (CASE 3)</h3><h5> {{$kpi->nombre}}: (your are over budget,
                                                        behind schedule but customer still requires to complete the project on
                                                        time). EAC = AC + (BAC – EV)/(CPI*SPI). </h5>
                                                    <div id="chart-eac3" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                                <!-- PENDIENTE CALCULAR BIEN-->
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}} (CASE 4):</h3><h5> {{$kpi->nombre}}: (This is the case
                                                        when you find out that your cost estimate was flawed and you need to
                                                        calculate the new cost estimate for the remaining project’s work.). EAC
                                                        = AC + Bottom-up Estimate to Complete. The results from all of them are
                                                        USD.-</h5>
                                                    <div id="chart-eac4" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='VAC')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}} (EAC CASE 1)</h3><h5>{{$kpi->nombre}}
                                                        : {{$kpi->description}}</h5>
                                                    <div id="chart-vac1" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}} (EAC CASE 2)</h3><h5>{{$kpi->nombre}}
                                                        : {{$kpi->description}}</h5>
                                                    <div id="chart-vac2" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}} (EAC CASE 3)</h3><h5>{{$kpi->nombre}}
                                                        : {{$kpi->description}}</h5>
                                                    <div id="chart-vac3" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}} (EAC CASE 4)</h3><h5>{{$kpi->nombre}}
                                                        : {{$kpi->description}}</h5>
                                                    <div id="chart-vac4" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='SV')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5> {{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-sv" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='MFN')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-mfn" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='FNSL')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}:{{$kpi->description}}</h5>
                                                    <div id="chart-fnsl" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='ROI')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-roi" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='RRR')

                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-rrr" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='Activities')
                                              
                                                <?php
                                                //PENDIENTE, HAY QUE HACER UN TICKET O TASK ISTORY QUE ALMACENE ESO
                                                ?>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-Activities" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='Milestones')
                                               
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-Milestones" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='Reviews')

                                               
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-Reviews" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='Commitments')

                                                <?php
                                                //PENDIENTE, QUE SON Commitments?
                                                ?>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-Commitments" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
        					               @endif
                                            @if($kpi->kpi=='Overdue Tasks')

                                                <?php
                                                //de donde saco el status?
                                                ?>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-OverdueTasks" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                   			@endif
                                            @if($kpi->kpi=='Task Completed')

                                                      <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-TaskCompleted" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                             				@endif
                                            @if($kpi->kpi=='Planned Hours')
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-PlannedHours" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
        			                         @endif
                                            @if($kpi->kpi=='Completed Projects')
                                                <?php
                                                //PENDIENTE, NO SE QUE TIPO DE GRAFICO VA
                                                ?>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-CompletedProjects" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='Cancelled Projects')
                                                <?php
                                                //PENDIENTE, NO SE QUE TIPO DE GRAFICO VA
                                                ?>
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-CancelledProjects" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif
                                            @if($kpi->kpi=='Response Times')
                                                <div class="pd-2">
                                                    <h3>{{$kpi->kpi}}</h3><h5>{{$kpi->nombre}}: {{$kpi->description}}</h5>
                                                    <div id="chart-ResponseTimes" class="ct-chart ct-perfect-fourth"></div>
                                                </div>
                                            @endif

                                        @endif

                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
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
    <script src="{{asset('js/kpis.js')}}"></script>

    <script>
        Kpis.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>','{{ $category_kpi }}');
    </script>

@endsection
