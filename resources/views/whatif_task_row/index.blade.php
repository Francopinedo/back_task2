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
    <script src="{{ asset('js/whatif_tasksRows.js') }}"></script>

    <script>
        $(function () {
            $('#whatif_task_resources-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}whatif_task_resources/datatables?whatif_task_id={{ $task->id }}',
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
                            '<a href="/whatif_task_resources/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/whatif_task_resources/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
        //     $('#whatif_task_expenses-table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         bPaginate: false,
        //         ajax:  '{{ env('API_PATH') }}whatif_task_expenses/datatables?whatif_task_id={{ $task->id }}',
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
        //             		'<a href="/whatif_task_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
        //             		'<a href="/whatif_task_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
            $('#whatif_task_services-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}whatif_task_services/datatables?whatif_task_id={{ $task->id }}',
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
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a href="/whatif_task_services/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/whatif_task_services/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                }],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });
        });

        $(function () {
            $('#whatif_task_materials-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}whatif_task_materials/datatables?whatif_task_id={{ $task->id }}',
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
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a href="/whatif_task_materials/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/whatif_task_materials/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                }],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });
        });

        $(function () {
            $('#whatif_task_expenses-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}whatif_task_expenses/datatables?whatif_task_id={{ $task->id }}',
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
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a href="/whatif_task_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/whatif_task_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                }],
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

@section('section_title', __('whatif_tasks.items'))

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

                    <h4 class="heading_a uk-margin-bottom">{{ __('whatif_tasks.resources') }}</h4>
                    <table id="whatif_task_resources-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('whatif_task_resources.id') }}</th>

                            {{-- <th>{{ __('whatif_tasks.project_role') }}</th>
                            <th>{{ __('whatif_tasks.seniority') }}</th>

                            <th>{{ __('whatif_tasks.currency') }}</th>
                            <th>{{ __('whatif_tasks.load') }}</th>
                            <th>{{ __('whatif_tasks.workplace') }}</th>
                            <th>{{ __('whatif_tasks.comments') }}</th> --}}
                            <th>{{ __('whatif_tasks.user') }}</th>
                            <th>{{ __('whatif_tasks.role') }}</th>
                            <th>{{ __('whatif_tasks.seniority') }}</th>
                            <th>{{ __('whatif_tasks.hours') }}</th>
                            <th>{{ __('whatif_tasks.rate') }}</th>
                            <th>{{ __('whatif_tasks.currency') }}</th>
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

					<h4 class="heading_a uk-margin-bottom">{{ __('whatif_tasks.expenses') }}</h4>
                	<table id="whatif_task_expenses-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('task.id') }}</th>
                	        	<th>{{ __('whatif_tasks.detail') }}</th>
                	        	<th>{{ __('whatif_tasks.reimbursable') }}</th>
                	        	<th>{{ __('whatif_tasks.cost') }}</th>
                	        	<th>{{ __('whatif_tasks.currency') }}</th>
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

                    <h4 class="heading_a uk-margin-bottom">{{ __('whatif_tasks.services') }}</h4>
                    <table id="whatif_task_services-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('task.id') }}</th>
                            <th>{{ __('whatif_tasks.detail') }}</th>
                            <th>{{ __('whatif_tasks.reimbursable') }}</th>
                            <th>{{ __('whatif_tasks.cost') }}</th>
                            <th>{{ __('whatif_tasks.quantity') }}</th>
                            <th>{{ __('whatif_tasks.amount') }}</th>
                            <th>{{ __('whatif_tasks.currency') }}</th>
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

                    <h4 class="heading_a uk-margin-bottom">{{ __('whatif_tasks.materials') }}</h4>
                    <table id="whatif_task_materials-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('task.id') }}</th>
                            <th>{{ __('whatif_tasks.detail') }}</th>
                            <th>{{ __('whatif_tasks.reimbursable') }}</th>
                            <th>{{ __('whatif_tasks.cost') }}</th>
                            <th>{{ __('whatif_tasks.quantity') }}</th>
                            <th>{{ __('whatif_tasks.amount') }}</th>
                            <th>{{ __('whatif_tasks.currency') }}</th>
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

                    <h4 class="heading_a uk-margin-bottom">{{ __('whatif_tasks.expenses') }}</h4>
                    <table id="whatif_task_expenses-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('task.id') }}</th>
                            <th>{{ __('whatif_tasks.detail') }}</th>
                            <th>{{ __('whatif_tasks.reimbursable') }}</th>
                            <th>{{ __('whatif_tasks.cost') }}</th>
                            <th>{{ __('whatif_tasks.quantity') }}</th>
                            <th>{{ __('whatif_tasks.amount') }}</th>
                            <th>{{ __('whatif_tasks.currency') }}</th>
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
                <a href="{{ url('whatif_task_resource/'.$task->id.'/create') }}" class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul">&#xE2C7;</i> {{ __('whatif_tasks.add_resource') }}</a>
                <a href="{{ url('whatif_task_service/'.$task->id.'/create') }}" class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('whatif_tasks.add_service') }}</a>
                <a href="{{ url('whatif_task_material/'.$task->id.'/create') }}" class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('whatif_tasks.add_material') }}</a>
                <a href="{{ url('whatif_task_expense/'.$task->id.'/create') }}" class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('whatif_tasks.add_expense') }}</a>
            </div>
        </div>
    </div>
@endsection

{{-- @section('create_div')
	@component('whatif_task/create', [])

	@endcomponent
@endsection --}}