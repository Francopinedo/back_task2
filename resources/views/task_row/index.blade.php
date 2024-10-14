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
    <script src="{{ asset('js/tasksRows.js') }}"></script>

    <script>
        $(function () {
            $('#task_resources-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}task_resources/datatables?task_id={{ $task->id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},


                    //{data: 'seniority_title', name: 'seniority_title'},

                 //   {data: 'currency_name', name: 'currency_name'},
                  //  {data: 'workplace', name: 'workplace'},
                    //   {data: 'comments', name: 'comments'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'project_role_title', name: 'project_role_title'},
                    {data: 'seniority_name', name: 'seniority_name'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'rate', name: 'rate'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a href="/task_resources/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/task_resources/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                }],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });
        });

        // $(function() {
        //     $('#task_expenses-table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         bPaginate: false,
        //         ajax:  '{{ env('API_PATH') }}task_expenses/datatables?task_id={{ $task->id }}',
        //         dom: '<"top">rt<"bottom"lp><"clear">',
        //         language: {
        // 		    paginate: {
        // 		      	previous: "<<",
        // 		      	next: ">>"
        // 		    }
        // 		},
        //         columns: [
        //             { data: 'id', name: 'id', visible: false },
        //             { data: 'detail', name: 'detail' },
        //             { data: 'reimbursable', name: 'reimbursable' },
        //             { data: 'cost', name: 'cost' },
        //             { data: 'currency_name', name: 'currency_name' },
        //             { data: 'actions', name: 'actions'}
        //         ],
        //         columnDefs: [ {
        //             targets: -1,
        //             data: null,
        //             render: function (data, type, row) {
        //                    return '' +
        //             		'<a href="/task_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
        //             		'<a href="/task_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        //                }
        //         } ],
        //         initComplete: function(settings, json) {
        // 		    tableActions.initEdit();
        // 		    // tableActions.initAjaxCreate();
        // 		    // tableActions.initDelete('{{ __('general.confirm') }}');
        // 		}
        //     });
        // });

        $(function () {
            $('#task_services-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}task_services/datatables?task_id={{ $task->id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'detail', name: 'detail'},
                    {data: 'reimbursable', name: 'reimbursable'},
                    {data: 'cost', name: 'cost'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'amount', name: 'amount'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [
                    {
                        targets: -1,
                        data: null,
                        render: function (data, type, row) {
                            return '' +
                                '<a href="/task_services/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                '<a href="/task_services/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                    },
                    {
                        targets: 2,
                        data: null,
                        render: function (data, type, row) {

                            if (data == 1)
                                return '{{ __('tasks.yes') }}';
                            if (data == 0)
                                return '{{ __('tasks.no') }}';

                        }
                    },
                ],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });
        });

        $(function () {
            $('#task_materials-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}task_materials/datatables?task_id={{ $task->id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'detail', name: 'detail'},
                    {data: 'reimbursable', name: 'reimbursable'},
                    {data: 'cost', name: 'cost'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'amount', name: 'amount'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [
                    {
                        targets: -1,
                        data: null,
                        render: function (data, type, row) {
                            return '' +
                                '<a href="/task_materials/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                '<a href="/task_materials/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                    },
                    {
                        targets: 2,
                        data: null,
                        render: function (data, type, row) {

                            if (data == 1)
                                return '{{ __('tasks.yes') }}';
                            if (data == 0)
                                return '{{ __('tasks.no') }}';

                        }
                    },
                ],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });
        });

        $(function () {
            $('#task_expenses-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}task_expenses/datatables?task_id={{ $task->id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'detail', name: 'detail'},
                    {data: 'reimbursable', name: 'reimbursable'},
                    {data: 'cost', name: 'cost'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'amount', name: 'amount'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [
                    {
                        targets: -1,
                        data: null,
                        render: function (data, type, row) {
                            return '' +
                                '<a href="/task_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                '<a href="/task_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                    },
                    {
                        targets: 2,
                        data: null,
                        render: function (data, type, row) {

                            if (data == 1)
                                return '{{ __('tasks.yes') }}';
                            if (data == 0)
                                return '{{ __('tasks.no') }}';

                        }
                    },
                ],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });
        });


        $(document).ready(function () {
            tableActions.initAjaxCreate();
            tableActions.initDelete('{{ __('general.confirm') }}');
        });

    </script>
@endsection

@section('section_title', __('tasks.items'))

@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">
                    <h3>Editing resources for task: {{$task->name}}</h3>
                    @if(session()->has('message'))
                        <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                    @endif

                    <h4 class="heading_a uk-margin-bottom" title="{{ __('tasks_tooltip.resources')}}">{{ __('tasks.resources') }}</h4>
                    <table id="task_resources-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('task_resources.id') }}</th>

                            {{-- <th title="{{ __('tasks_tooltip.project_role')}}">{{ __('tasks.project_role') }}</th>
                            <th title="{{ __('tasks_tooltip.seniority')}}">{{ __('tasks.seniority') }}</th>

                            <th title="{{ __('tasks_tooltip.currency')}}">{{ __('tasks.currency') }}</th>
                            <th title="{{ __('tasks_tooltip.load')}}">{{ __('tasks.load') }}</th>
                            <th title="{{ __('tasks_tooltip.workplace')}}">{{ __('tasks.workplace') }}</th>
                            <th title="{{ __('tasks_tooltip.comments')}}">{{ __('tasks.comments') }}</th> --}}
                            <th title="{{ __('tasks_tooltip.user')}}">{{ __('tasks.user') }}</th>
                            <th title="{{ __('tasks_tooltip.role')}}">{{ __('tasks.role') }}</th>
                            <th title="{{ __('tasks_tooltip.seniority')}}">{{ __('tasks.seniority') }}</th>
                            <th title="{{ __('tasks_tooltip.hours')}}">{{ __('tasks.hours') }}</th>
                            <th title="{{ __('tasks_tooltip.rate')}}">{{ __('tasks.rate') }}</th>
                            <th title="{{ __('tasks_tooltip.currency')}}">{{ __('tasks.currency') }}</th>
                            <th>{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

					<h4 class="heading_a uk-margin-bottom" title="{{ __('tasks_tooltip.expenses')}}">{{ __('tasks.expenses') }}</h4>
                	<table id="task_expenses-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('task.id') }}</th>
                	        	<th title="{{ __('tasks_tooltip.detail')}}">{{ __('tasks.detail') }}</th>
                	        	<th title="{{ __('tasks_tooltip.reimbursable')}}">{{ __('tasks.reimbursable') }}</th>
                	        	<th title="{{ __('tasks_tooltip.cost')}}">{{ __('tasks.cost') }}</th>
                	        	<th title="{{ __('tasks_tooltip.currency')}}">{{ __('tasks.currency') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <h4 class="heading_a uk-margin-bottom" title="{{ __('tasks_tooltip.services')}}">{{ __('tasks.services') }}</h4>
                    <table id="task_services-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('task.id') }}</th>
                            <th title="{{ __('tasks_tooltip.detail')}}">{{ __('tasks.detail') }}</th>
                            <th title="{{ __('tasks_tooltip.reimbursable')}}">{{ __('tasks.reimbursable') }}</th>
                            <th title="{{ __('tasks_tooltip.cost')}}">{{ __('tasks.cost') }}</th>
                            <th title="{{ __('tasks_tooltip.quantity')}}">{{ __('tasks.quantity') }}</th>
                            <th title="{{ __('tasks_tooltip.amount')}}">{{ __('tasks.amount') }}</th>
                            <th title="{{ __('tasks_tooltip.currency')}}">{{ __('tasks.currency') }}</th>
                            <th>{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <h4 class="heading_a uk-margin-bottom" title="{{ __('tasks_tooltip.materials')}}">{{ __('tasks.materials') }}</h4>
                    <table id="task_materials-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('task.id') }}</th>
                            <th title="{{ __('tasks_tooltip.detail')}}">{{ __('tasks.detail') }}</th>
                            <th title="{{ __('tasks_tooltip.reimbursable')}}">{{ __('tasks.reimbursable') }}</th>
                            <th title="{{ __('tasks_tooltip.cost')}}">{{ __('tasks.cost') }}</th>
                            <th title="{{ __('tasks_tooltip.quantity')}}">{{ __('tasks.quantity') }}</th>
                            <th title="{{ __('tasks_tooltip.amount')}}">{{ __('tasks.amount') }}</th>
                            <th title="{{ __('tasks_tooltip.currency')}}">{{ __('tasks.currency') }}</th>
                            <th>{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <h4 class="heading_a uk-margin-bottom" title="{{ __('tasks_tooltip.')}}">{{ __('tasks.expenses') }}</h4>
                    <table id="task_expenses-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('task.id') }}</th>
                            <th title="{{ __('tasks_tooltip.detail')}}">{{ __('tasks.detail') }}</th>
                            <th title="{{ __('tasks_tooltip.reimbursable')}}">{{ __('tasks.reimbursable') }}</th>
                            <th title="{{ __('tasks_tooltip.cost')}}">{{ __('tasks.cost') }}</th>
                            <th title="{{ __('tasks_tooltip.quantity')}}">{{ __('tasks.quantity') }}</th>
                            <th title="{{ __('tasks_tooltip.amount')}}">{{ __('tasks.amount') }}</th>
                            <th title="{{ __('tasks_tooltip.currency')}}">{{ __('tasks.currency') }}</th>
                            <th>{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-fab-wrapper md-fab-in-card" style="position: fixed;">
        <div class="md-fab md-fab-accent md-fab-sheet">
            <i class="fa fa-plus" aria-hidden="true"></i>
            <div class="md-fab-sheet-actions">
                <a href="{{ url('task_resources/'.$task->id.'/create') }}" class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul">&#xE2C7;</i> {{ __('tasks.add_resource') }}</a>
                <a href="{{ url('task_services/'.$task->id.'/create') }}" class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('tasks.add_service') }}</a>
                <a href="{{ url('task_materials/'.$task->id.'/create') }}" class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('tasks.add_material') }}</a>
                <a href="{{ url('task_expenses/'.$task->id.'/create') }}" class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('tasks.add_expense') }}</a>
            </div>
        </div>
    </div>
@endsection

{{-- @section('create_div')
	@component('task/create', [])

	@endcomponent
@endsection --}}