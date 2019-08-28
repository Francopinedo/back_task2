@extends('layouts.app', ['favoriteTitle' => __('working_hours.working_hours'), 'favoriteUrl' => 'working_hours'])

<style>
    .weekend {
        background: #ffad42;
    }

    .total {
        background: #85a4ff;
    }
</style>
@section('scripts')

    @if(session()->has('project_id'))
        <script>
            var element = $("#page_content");
            kendo.ui.progress(element, true);
        </script>
    @endif
    @include('datatables.basic')

    <script src="{{ asset('js/working_hours.js') }}"></script>

    <script>


        $(function () {


            $('#hours-table').DataTable({
                dom: '<"top">Brt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                "scrollX": true,
                "scrollY": true,
                buttons: [
                    {
                        extend: 'copyHtml5', exportOptions: {columns: ':visible'}, orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    {
                        extend: 'excelHtml5', exportOptions: {columns: ':visible'}, orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    {
                        extend: 'csvHtml5', exportOptions: {columns: ':visible'}, orientation: 'landscape',
                        pageSize: 'A0'
                    },
                    /* {
                     extend: 'pdfHtml5', exportOptions: {columns: ':visible'}, orientation: 'landscape',
                     pageSize: 'LEGAL'
                     },*/
                ],


                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();


                    console.log(data);
                    var i = 0;
                    api.columns().every(function () {

                        var sum = this
                            .data()
                            .reduce(function (a, b) {


                                console.log(a);
                                console.log(b);

                                var x = parseFloat(a) || 0;

                                if (isNaN(x)) {
                                    x = 0;
                                }


                                //   console.log(x);
                                // console.log(b);
                                if (b != null) {

                                    var y = parseFloat(b) || 0;


                                    if (isNaN(y)) {
                                        y = 0;
                                    }
                                    //  console.log(y);


                                    return parseFloat(x) + parseFloat(y);
                                }
                            }, 0);


                        if (sum != undefined) {

                            if (i != 0) {
                                $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                            }


                        }


                        i++;
                    });


                },

                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    tableActions.initDelete('<?php echo e(__('general.confirm')); ?>');
                    tableActions.initInfo();
                    var element = $("#page_content");
                    kendo.ui.progress(element, false);
                },


            });
        });

        $(document).ready(function () {

            workingHours.init();
        });

    </script>


@endsection

@section('section_title', __('working_hours.working_hours'))
<style>
    td, th {
        word-wrap: inherit !important;
    }
</style>
@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <div class="uk-alert uk-alert-warning" data-uk-alert>
                        <a href="#" class="uk-alert-close uk-close"></a>
                        {{ __('working_hours.only_with_office') }}
                    </div>

                    @if(session()->has('message'))
                        <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                    @endif

                    @if(!session()->has('project_id'))
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                    @endif

                    @if(session()->has('project_id'))

                        <div class="md-card">
                            <div class="md-card-content">
                                <form role="form" id="" method="GET" id="">
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-1-6">

                                            <div class="md-input-wrapper">
                                                <label>{{ __('general.from') }}</label>

                                            </div>
                                        </div>
                                        <div class="uk-width-1-6">
                                            <div class="md-input-wrapper">
                                                <input class="md-input" required type="text" readonly id="period_from"
                                                       name="start"
                                                       placeholder="{{ __('capacity_planning.period_from') }}"
                                                       value="{{$begin}}"
                                                       data-uk-datepicker="{format:'YYYY-MM-DD', minDate:'{{$project->start}}',  maxDate:'{{$project->finish}}'}">
                                            </div>
                                        </div>
                                        <div class="uk-width-1-6">

                                            <div class="md-input-wrapper">
                                                <label>{{ __('general.to') }}</label>

                                            </div>
                                        </div>

                                        <div class="uk-width-1-6">
                                            <div class="md-input-wrapper">
                                                <input class="md-input" required
                                                       placeholder="{{ __('capacity_planning.period_to') }} "
                                                       type="text"
                                                       readonly name="finish" id="period_to"
                                                       value="{{$end}}"
                                                       data-uk-datepicker="{format:'YYYY-MM-DD', minDate:'{{$project->start}}',  maxDate:'{{$project->finish}}'}">
                                            </div>
                                        </div>


                                        <div class="uk-width-1-6 float-right">
                                            <button class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                                                    type="submit">
                                                {{ __('team_users.working_hours') }}
                                            </button>


                                        </div>
                                    </div>


                                </form>

                            </div>
                            <table class="uk-table uk-table-striped" style="width: 100%" id="hours-table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <?php  foreach($users[0]->workingHours as $workingHour) {
                                    $week = false;
                                    $date = new DateTime($workingHour->date);
                                    $dow = $date->format('w');
                                    if (in_array($dow, $project->holy_days)) {
                                        $week = true;
                                    }
                                    ?>
                                    <th <?php if ($week) echo 'class="weekend"'?>><?php echo $workingHour->date;?></th>
                                    <?php } ?>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  foreach($users as $user) {?>
                                <tr>
                                    <td><?= $user->name ?></td>
                                    <?php  foreach($user->workingHours as $workingHour) {        ?>
                                    <th>
                                        <?php //if(isset($workingHour->id)){?>
                                        <?= $workingHour->hours >= 0 ? $workingHour->hours : 0 ?>
                                    </th>

                                    <?php }?>
                                    <td class="total"><span style="font-size: 17px"><?= $user->totaluser?></span></td>
                                </tr>
                                <tr>
                                    <td><?= $user->name ?> Additional Hours</td>
                                    <?php  foreach($user->aditionalHours as $workingHour) { ?>
                                    <th>

                                        <?php //if(isset($workingHour->id)){?>
                                        <?= $workingHour->hours >= 0 ? $workingHour->hours : 0 ?>

                                    </th>

                                    <?php }?>
                                    <td class="total"><span style="font-size: 17px"><?= $user->totaluserAddti?></span></td>
                                </tr>


                                <?php }?>

                                </tbody>
                                <tfoot>
                                <td>Total</td>
                                <?php  foreach($user->workingHours as $workingHour) { ?>
                                <th>

                                </th>

                                <?php }?>
                                <td></td>
                                </tfoot>
                            </table>

                            <br><br>


                            @endif
                        </div>
                </div>
            </div>
        </div>
@endsection


