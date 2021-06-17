@extends('layouts.app', ['favoriteTitle' => __('tickets.tickets'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
    <!-- datatables -->
    <script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- datatables buttons-->
    <script src="{{ asset('bower_components/datatables-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('assets/js/custom/datatables/buttons.uikit.js') }}"></script>
    <script src="{{ asset('bower_components/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('bower_components/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('bower_components/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.print.js') }}"></script>

    <!-- datatables custom integration -->
    <script src="{{ asset('assets/js/custom/datatables/datatables.uikit.min.js') }}"></script>

    <!--  datatables functions -->
    {{-- <script src="assets/js/pages/plugins_datatables.min.js"></script> --}}

    <!--  forms advanced functions -->
    {{-- <script src="assets/js/pages/forms_advanced.min.js"></script> --}}

    <script>
        $(function () {
            $('#tickets-table').DataTable({
                ajax: '{{ env('API_PATH') }}tickets/datatables?task_id={{$task->id}}',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                processing: true,
                serverSide: true,
                dom: '<"top" "<"pull-right"f >>Brt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                buttons: [
                    {extend: 'copyHtml5', exportOptions: {columns: ':visible:not(:last-child)'}},
                    {extend: 'excelHtml5', exportOptions: {columns: ':visible:not(:last-child)'}},
                    {extend: 'csvHtml5', exportOptions: {columns: ':visible:not(:last-child)'}},
                    {extend: 'pdfHtml5',orientation:'landscape', exportOptions: {columns: ':visible:not(:last-child)'}},
                ],
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'ticket_id', name: 'ticket_id'},
                    {data: 'description', name: 'description'},
                    {data: 'owner_name', name:'owner_name'},
                    {data: 'status', name: 'status'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'priority', name: 'priority'},
                    {data: 'estimated_hours', name: 'estimated_hours'},
                    {data: 'burned_hours', name: 'burned_hours'},
                    {data: 'progress', name:'progress'},
                    {data: 'created_at', name: 'Created At'},
                ],

                columnDefs: [
                {
                    targets: 1,
                    data: null,
                    render: function (data, type, row) {

                            return '<a title="{{__('general.edit')}}" href="/workboard/'+ row['id'] +'/edit" class="table-actions edit-btn">'+data+'</a>';
                    }
                },
                {
                    targets: 4,
                    data: null,
                    render: function (data, type, row) {

                        if (data == 1)
                            return '{{ __('tickets.status_1') }}';
                        if (data == 2)
                            return '{{ __('tickets.status_2') }}';
                        if (data == 3)
                            return '{{ __('tickets.status_3') }}';
                        if (data == 4)
                            return '{{ __('tickets.status_4') }}';
                        if (data == 5)
                            return '{{ __('tickets.status_5') }}';
                        if (data == 6)
                            return '{{ __('tickets.status_6') }}';
                    }
                },
                    {
                        targets: 6,
                        data: null,
                        render: function (data, type, row) {

                            if (data == 1)
                                return '{{ __('tickets.priority_1') }}';
                            if (data == 2)
                                return '{{ __('tickets.priority_2') }}';
                            if (data == 3)
                                return '{{ __('tickets.priority_3') }}';
                            if (data == 4)
                                return '{{ __('tickets.priority_4') }}';

                        }
                    },
                    {
                        targets: -2,
                        data: null,
                        render: function(data, type, row){
                            if(data != undefined){
                                return '<div>' + data.split('.')[0] + '</div><div class=" progress-bar" style="width: ' + data.split('.')[0] + '%;" role="progressbar" aria-valuenow="' + data.split('.')[0] + '" aria-valuemin="0" aria-valuemax="100"></div>';
                            }else{
                                return '';
                            }
                        }
                    },
                     {
                        targets: -1,
                        data: null,
                        render: function(data, type, row){
                            if (data != undefined && row.estimated_hours != undefined ) { //&& row.progress != undefined
                            let date_1 = new Date(data);
                            let date_2 = new Date();
                            let day_in_milliseconds = 86400000;
                            let diff_in_days = (date_2 - date_1) / day_in_milliseconds;
                            let result = ((diff_in_days * 8) / row.estimated_hours) * 100;
				let tprogress = (row.estimated_hours - row.burned_hours/row.estimated_hours)*100;
                            if (result > 100) {
                                result = 100;
                            } else if(result < 0){
                                result = 0;
                            }
                            let color;

                            if( result < tprogress || (result == 100 )){ //&& row.progress == 100

                                color = 'green';
                            }else if (result > tprogress) {

                                color = 'red';
                            }else{
                                color = 'yellow';
                            }
                            // console.log(result.toFixed(2));

                            return '<div>' + result.toFixed(2) + '</div><div class=" progress-bar" style="width: ' + result.toFixed(2) + '%; background-color: ' + color + '" role="progressbar" aria-valuenow="' + result.toFixed(2) + '" aria-valuemin="0" aria-valuemax="100"></div>';
                        } else {
                            return '';
                        }
                        }
                    }

                    ],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });
        });

        $(document).ready(function () {
            $("#datatables-length").append($(".dataTables_length"));
            $("#datatables-pagination").append($(".simple_numbers"));
        });

    </script>
@endsection

@section('section_title', __('tickets.tickets'))

@section('content')

    <style>
        .progress{
            background-color: transparent;
            box-shadow: none;
        }
        .progress-bar{
            height: 1.3em;
        }
    </style>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <h3>{{__('tickets.title_project')}} : {{$task->name}}</h3>
                    <a href="{{ URL::previous() }}" class="btn btn primary pull-right">Volver</a>

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
                        <table id="tickets-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th title="{{ __('tickets_tooltip.id')}}">{{ __('tickets.id') }}</th>
                                <th title="{{ __('tickets_tooltip.ticket_id')}}">{{ __('tickets.ticket_id') }}</th>

                                <th title="{{ __('tickets_tooltip.description')}}">{{ __('tickets.description') }}</th>
                                <th title="{{__('tickets_tooltip.owner')}}">{{__('tickets.owner')}}</th>
                                <th title="{{ __('tickets_tooltip.status')}}">{{ __('tickets.status') }}</th>
                                <th title="{{ __('tickets_tooltip.due_date')}}">{{ __('tickets.due_date') }}</th>
                                <th title="{{ __('tickets_tooltip.priority')}}">{{ __('tickets.priority') }}</th>
                                <th title="{{ __('tickets_tooltip.estimated_hours')}}">{{ __('tickets.estimated_hours') }}</th>
                                <th title="{{ __('tickets_tooltip.burned_hours')}}">{{ __('tickets.burned_hours') }}</th>
                                <th data-class-name="progress" title="{{ __('tickets_tooltip.progress')}}">{{ __('tickets.progress') }}</th>
                                <th data-class-name="progress" title="{{ __('tickets_tooltip.estimated_progress')}}">{{ __('tickets.estimated_progress') }}</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="uk-grid datatables-bottom">
                            <div class="uk-width-medium-1-3" id="datatables-length"></div>
                            <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
