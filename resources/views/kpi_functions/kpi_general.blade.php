@if($category_kpi == $category->id)
    <div class="uk-alert uk-alert-info" data-uk-alert>
        <a href="#" class="uk-alert"></a>
        {{ $category->name}}
    </div>
@endif
<div data-slick='{"slidesToShow": 3, "slidesToScroll": 3}' class="slick">
    @foreach ($kpis as $kpi)
        @if($kpi->category==$category->id && $kpi->showkpi=='1')
            @if($category_kpi == '1')
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
            @endif
            @if($category_kpi == '2')
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
        @endif

    @endforeach
</div>