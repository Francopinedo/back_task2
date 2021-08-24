@extends('layouts.app')

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
                processing: true,
                serverSide: true,
                ajax: '{{ env('API_PATH') }}tickets/datatables?sprint_id={{$sprint->id}}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'ticket_id', name: 'ticket_id'},
                    {data: 'description', name: 'description'},
                    {data: 'type', name: 'type'},
                    {data: 'assignee_name', name: 'assignee_name'},
                    {data: 'status', name: 'status'},
                    {data: 'group', name: 'group'},
                    // {data: 'sprint', name: 'sprint'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'requester_name', name: 'requester_name'},
                    {data: 'priority', name: 'priority'},
                    {data: 'severity', name: 'severity'},
                    {data: 'impact', name: 'impact'},
                    {data: 'probability', name: 'probability'},

                    {data: 'owner_name', name: 'owner_name'},
                    {data: 'estimated_hours', name: 'estimated_hours'},
                    {data: 'burned_hours', name: 'burned_hours'},

                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [
                {
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a href="/tickets/' + row.id + '/history" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' +
                            '<a href="/tickets/' + row.id + '/edit_sprint" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/tickets/' + row.id + '/files" class="table-actions edit-btn"><i class="fa fa-paperclip" aria-hidden="true"></i></a>' +
                            '<a href="/tickets/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                }, {
                    targets: 3,
                    data: null,
                    render: function (data, type, row) {

                        if (data == 1)
                            return '{{ __('tickets.type_1') }}';
                        if (data == 2)
                            return '{{ __('tickets.type_2') }}';
                        if (data == 3)
                            return '{{ __('tickets.type_3') }}';
                        if (data == 4)
                            return '{{ __('tickets.type_4') }}';
                        if (data == 5)
                            return '{{ __('tickets.type_5') }}';
                    }
                },
                    {
                        targets: 5,
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
                                return '{{ __('tickets.group_1') }}';
                            if (data == 2)
                                return '{{ __('tickets.group_2') }}';

                        }
                    },
                    {
                        targets: 9,
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
                        targets: 10,
                        data: null,
                        render: function (data, type, row) {
                            if (data == 0)
                                return '{{ __('tickets.severity_0') }}';
                            if (data == 1)
                                return '{{ __('tickets.severity_1') }}';
                            if (data == 2)
                                return '{{ __('tickets.severity_2') }}';
                            if (data == 3)
                                return '{{ __('tickets.severity_3') }}';
                            if (data == 4)
                                return '{{ __('tickets.severity_4') }}';
                            if (data == 5)
                                return '{{ __('tickets.severity_5') }}';

                        }
                    },
                    {
                        targets: 11,
                        data: null,
                        render: function (data, type, row) {
                            if (data == 0)
                                return '{{ __('tickets.impact_0') }}';
                            if (data == 1)
                                return '{{ __('tickets.impact_1') }}';
                            if (data == 2)
                                return '{{ __('tickets.impact_2') }}';
                            if (data == 3)
                                return '{{ __('tickets.impact_3') }}';


                        }
                    }, {
                        targets: 12,
                        data: null,
                        render: function (data, type, row) {
                            if (data == 0)
                                return '{{ __('tickets.probability_0') }}';
                            if (data == 1)
                                return '{{ __('tickets.priority_1') }}';
                            if (data == 2)
                                return '{{ __('tickets.probability_2') }}';
                            if (data == 3)
                                return '{{ __('tickets.probability_3') }}';


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

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <h3>{{__('tickets.tickets_test')}} {{$sprint->long_name}}</h3>
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
                                <th title="{{__('tickets_tooltip.id')}}">{{ __('tickets.id') }}</th>
                                <th title="{{__('tickets_tooltip.ticket_id')}}">{{ __('tickets.ticket_id') }}</th>
                                <th title="{{__('tickets_tooltip.description')}}">{{ __('tickets.description') }}</th>
                                <th title="{{__('tickets_tooltip.type')}}">{{ __('tickets.type') }}</th>
                                <th title="{{__('tickets_tooltip.assignee')}}">{{ __('tickets.assignee') }}</th>
                                <th title="{{__('tickets_tooltip.status')}}">{{ __('tickets.status') }}</th>
                                <th title="{{__('tickets_tooltip.group')}}">{{ __('tickets.group') }}</th>
                                {{-- <th title="{{__('tickets_tooltip.sprint')}}">{{ __('tickets.sprint') }}</th> --}}
                                <th title="{{__('tickets_tooltip.due_date')}}">{{ __('tickets.due_date') }}</th>
                                <th title="{{__('tickets_tooltip.requester')}}">{{ __('tickets.requester') }}</th>

                                <th title="{{__('tickets_tooltip.priority')}}">{{ __('tickets.priority') }}</th>
                                <th title="{{__('tickets_tooltip.severity')}}">{{ __('tickets.severity') }}</th>
                                <th title="{{__('tickets_tooltip.impact')}}">{{ __('tickets.impact') }}</th>
                                <th title="{{__('tickets_tooltip.probability')}}">{{ __('tickets.probability') }}</th>
                                <th title="{{__('tickets_tooltip.owner')}}">{{ __('tickets.owner') }}</th>
                                <th title="{{__('tickets_tooltip.estimated_hours')}}">{{ __('tickets.estimated_hours') }}</th>
                                <th title="{{__('tickets_tooltip.burned_hours')}}">{{ __('tickets.burned_hours') }}</th>

                                <th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="uk-grid datatables-bottom">
                            <div class="uk-width-medium-1-3" id="datatables-length"></div>
                            <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                            <div class="uk-width-medium-1-3">
                                <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                                   href="#" id="add-new">{{ __('tickets.add_new') }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
    @component('ticket/create_sprint', [
                    'users' => $users,
                    'users2' => $users2,
                    'contacts' => $contacts,
                    'sprint' => $sprint,
                ]
            )

    @endcomponent
@endsection
