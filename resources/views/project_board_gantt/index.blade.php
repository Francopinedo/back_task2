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
    <script src="{{ asset('js/project_board.js') }}"></script>
    <script src="{{ asset('js/contracts.js') }}"></script>

    <script>
	$(function() {
	    $('#project_resources-table').DataTable({
	        processing: true,
	        serverSide: true,
	        bPaginate: false,
	        ajax:  '{{ env('API_PATH') }}project_resources/datatables?project_id={{ session('project_id') }}',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'project_role_title', name: 'project_role_title' },
	            { data: 'seniority_title', name: 'seniority_title' },
	            { data: 'user_name', name: 'user_name' },
	            { data: 'rate', name: 'rate' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'load', name: 'load' },
	            { data: 'workplace', name: 'workplace' },
	            // { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            // targets: -1,
	            // data: null,
	            // render: function (data, type, row) {
             //        return '' +
	            // 		'<a href="/project_resources/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            // 		'<a href="/project_resources/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
             //    }
	        } ],
	        initComplete: function(settings, json) {
			    tableActions.initEdit();
			    // tableActions.initAjaxCreate();
			    // tableActions.initDelete('{{ __('general.confirm') }}');
			}
	    });
	});

	// $(function() {
	//     $('#project_expenses-table').DataTable({
	//         processing: true,
	//         serverSide: true,
	//         bPaginate: false,
	//         ajax:  '{{ env('API_PATH') }}project_expenses/datatables?project_id={{ session('project_id') }}',
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
	//             { data: 'reimbursable', name: 'detail' },
	//             { data: 'cost', name: 'cost' },
	//             { data: 'currency_name', name: 'currency_name' },
	//             { data: 'actions', name: 'actions'}
	//         ],
	//         columnDefs: [ {
	//             targets: -1,
	//             data: null,
	//             render: function (data, type, row) {
 //                    return '' +
	//             		'<a href="/project_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	//             		'<a href="/project_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
 //                }
	//         } ],
	//         initComplete: function(settings, json) {
	// 		    tableActions.initEdit();
	// 		    // tableActions.initAjaxCreate();
	// 		    // tableActions.initDelete('{{ __('general.confirm') }}');
	// 		}
	//     });
	// });

	$(function() {
	    $('#project_services-table').DataTable({
	        processing: true,
	        serverSide: true,
	        bPaginate: false,
	        ajax:  '{{ env('API_PATH') }}project_services/datatables?project_id={{ session('project_id') }}',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'detail', name: 'detail' },
	            { data: 'reimbursable', name: 'detail' },
	            { data: 'cost', name: 'cost' },
	            { data: 'currency_name', name: 'currency_name' },
	            // { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            // targets: -1,
	            // data: null,
	            // render: function (data, type, row) {
             //        return '' +
	            // 		'<a href="/project_services/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            // 		'<a href="/project_services/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
             //    }
	        } ],
	        initComplete: function(settings, json) {
			    tableActions.initEdit();
			    // tableActions.initAjaxCreate();
			    // tableActions.initDelete('{{ __('general.confirm') }}');
			}
	    });
	});

	$(function() {
	    $('#project_materials-table').DataTable({
	        processing: true,
	        serverSide: true,
	        bPaginate: false,
	        ajax:  '{{ env('API_PATH') }}project_materials/datatables?project_id={{ session('project_id') }}',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'detail', name: 'detail' },
	            { data: 'reimbursable', name: 'reimbursable' },
	            { data: 'cost', name: 'cost' },
	            { data: 'currency_name', name: 'currency_name' },
	            // { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            // targets: -1,
	            // data: null,
	            // render: function (data, type, row) {
             //        return '' +
	            // 		'<a href="/project_materials/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            // 		'<a href="/project_materials/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
             //    }
	        } ],
	        initComplete: function(settings, json) {
			    tableActions.initEdit();
			    // tableActions.initAjaxCreate();
			    // tableActions.initDelete('{{ __('general.confirm') }}');
			}
	    });
	});

	$(function() {
	    $('#task_resources-table').DataTable({
	        processing: true,
	        serverSide: true,
	        bPaginate: false,
	        ajax:  '{{ env('API_PATH') }}task_resources/datatables?project_id={{ session('project_id') }}',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            // { data: 'project_role_title', name: 'project_role_title' },
	            // { data: 'seniority_title', name: 'seniority_title' },
	            // { data: 'qty', name: 'qty' },
	            // { data: 'rate', name: 'rate' },
	            // { data: 'currency_name', name: 'currency_name' },
	            // { data: 'load', name: 'load' },
	            // { data: 'workplace', name: 'workplace' },
	            // { data: 'comments', name: 'comments' },
	            { data: 'user_name', name: 'user_name' },
	            // { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            // targets: -1,
	            // data: null,
	            // render: function (data, type, row) {
             //        return '' +
	            // 		'<a href="/task_resources/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            // 		'<a href="/task_resources/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
             //    }
	        } ],
	        initComplete: function(settings, json) {
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
	//         ajax:  '{{ env('API_PATH') }}task_expenses/datatables?project_id={{ session('project_id') }}',
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

	$(function() {
	    $('#task_services-table').DataTable({
	        processing: true,
	        serverSide: true,
	        bPaginate: false,
	        ajax:  '{{ env('API_PATH') }}task_services/datatables?project_id={{ session('project_id') }}',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'detail', name: 'detail' },
	            // { data: 'reimbursable', name: 'reimbursable' },
	            // { data: 'cost', name: 'cost' },
	            // { data: 'currency_name', name: 'currency_name' },
	            // { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            // targets: -1,
	            // data: null,
	            // render: function (data, type, row) {
             //        return '' +
	            // 		'<a href="/task_services/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            // 		'<a href="/task_services/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
             //    }
	        } ],
	        initComplete: function(settings, json) {
			    tableActions.initEdit();
			    // tableActions.initAjaxCreate();
			    // tableActions.initDelete('{{ __('general.confirm') }}');
			}
	    });
	});

	$(function() {
	    $('#task_materials-table').DataTable({
	        processing: true,
	        serverSide: true,
	        bPaginate: false,
	        ajax:  '{{ env('API_PATH') }}task_materials/datatables?project_id={{ session('project_id') }}',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'detail', name: 'detail' },
	            // { data: 'reimbursable', name: 'reimbursable' },
	            // { data: 'cost', name: 'cost' },
	            // { data: 'currency_name', name: 'currency_name' },
	            // { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            // targets: -1,
	            // data: null,
	            // render: function (data, type, row) {
             //        return '' +
	            // 		'<a href="/task_materials/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            // 		'<a href="/task_materials/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
             //    }
	        } ],
	        initComplete: function(settings, json) {
			    tableActions.initEdit();
			    // tableActions.initAjaxCreate();
			    // tableActions.initDelete('{{ __('general.confirm') }}');
			}
	    });
	});

	$(document).ready(function() {
		tableActions.initAjaxCreate();
		tableActions.initDelete('{{ __('general.confirm') }}');

		projectBoard.init('{{ __('projects.confirm_update') }}');

	});

	</script>
@endsection

@section('section_title', __('projects.board_vs_gantt'))

@section('content')
	@if(!session()->has('project_id'))
		<div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
	@endif

	@if(session()->has('project_id'))

    <div class="md-card md-card-primary">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                	@if(session()->has('message'))
                		<div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                	@endif



					<h4 class="heading_a uk-margin-bottom">{{ __('projects.resources_board') }}</h4>
                	<table id="project_resources-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('projects.id') }}</th>
                	        	<th>{{ __('projects.project_role') }}</th>
                	        	<th>{{ __('projects.seniority') }}</th>
                	        	<th>{{ __('projects.user') }}</th>
                	        	<th>{{ __('projects.rate') }}</th>
                	        	<th>{{ __('projects.currency') }}</th>
                	        	<th>{{ __('projects.load') }}</th>
                	        	<th>{{ __('projects.workplace') }}</th>
                	        	{{-- <th>{{ __('general.actions') }}</th> --}}
                	        </tr>
                	    </thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card md-card-warning">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                	@if(session()->has('message'))
                		<div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                	@endif

					<h4 class="heading_a uk-margin-bottom">{{ __('projects.resources_gantt') }}</h4>
                	<table id="task_resources-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('task_resources.id') }}</th>
                	        	{{-- <th>{{ __('tasks.project_role') }}</th>
                	        	<th>{{ __('tasks.seniority') }}</th>
                	        	<th>{{ __('tasks.qty') }}</th>
                	        	<th>{{ __('tasks.rate') }}</th>
                	        	<th>{{ __('tasks.currency') }}</th>
                	        	<th>{{ __('tasks.load') }}</th>
                	        	<th>{{ __('tasks.workplace') }}</th>
                	        	<th>{{ __('tasks.comments') }}</th> --}}
                	        	<th>{{ __('tasks.user') }}</th>
                	        	{{-- <th>{{ __('general.actions') }}</th> --}}
                	        </tr>
                	    </thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <br><br><br>

    {{-- <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

					<h4 class="heading_a uk-margin-bottom">{{ __('projects.expenses_board') }}</h4>
                	<table id="project_expenses-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('project.id') }}</th>
                	        	<th>{{ __('projects.detail') }}</th>
                	        	<th>{{ __('projects.reimbursable') }}</th>
                	        	<th>{{ __('projects.cost') }}</th>
                	        	<th>{{ __('projects.currency') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="md-card md-card-primary">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

					<h4 class="heading_a uk-margin-bottom">{{ __('projects.services_board') }}</h4>
                	<table id="project_services-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('project.id') }}</th>
                	        	<th>{{ __('projects.detail') }}</th>
                	        	<th>{{ __('projects.reimbursable') }}</th>
                	        	<th>{{ __('projects.cost') }}</th>
                	        	<th>{{ __('projects.currency') }}</th>
                	        	{{-- <th>{{ __('general.actions') }}</th> --}}
                	        </tr>
                	    </thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card md-card-warning">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

					<h4 class="heading_a uk-margin-bottom">{{ __('projects.services_gantt') }}</h4>
                	<table id="task_services-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('task.id') }}</th>
                	        	<th>{{ __('tasks.detail') }}</th>
                	        	{{-- <th>{{ __('tasks.reimbursable') }}</th>
                	        	<th>{{ __('tasks.cost') }}</th>
                	        	<th>{{ __('tasks.currency') }}</th> --}}
                	        	{{-- <th>{{ __('general.actions') }}</th> --}}
                	        </tr>
                	    </thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>

    <div class="md-card md-card-primary">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

					<h4 class="heading_a uk-margin-bottom">{{ __('projects.materials_board') }}</h4>
                	<table id="project_materials-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('project.id') }}</th>
                	        	<th>{{ __('projects.detail') }}</th>
                	        	<th>{{ __('projects.reimbursable') }}</th>
                	        	<th>{{ __('projects.cost') }}</th>
                	        	<th>{{ __('projects.currency') }}</th>
                	        	{{-- <th>{{ __('general.actions') }}</th> --}}
                	        </tr>
                	    </thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card md-card-warning">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

					<h4 class="heading_a uk-margin-bottom">{{ __('tasks.materials') }}</h4>
                	<table id="task_materials-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('task.id') }}</th>
                	        	<th>{{ __('tasks.detail') }}</th>
                	        	{{-- <th>{{ __('tasks.reimbursable') }}</th>
                	        	<th>{{ __('tasks.cost') }}</th>
                	        	<th>{{ __('tasks.currency') }}</th> --}}
                	        	{{-- <th>{{ __('general.actions') }}</th> --}}
                	        </tr>
                	    </thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="md-fab-wrapper md-fab-in-card" style="position: fixed;">
        <div class="md-fab md-fab-accent md-fab-sheet">
            <i class="fa fa-plus" aria-hidden="true"></i>
            <div class="md-fab-sheet-actions">
                <a href="{{ url('project_resources/'.session('project_id').'/create') }}" class="md-color-white ajax_create-btn"><i class="fa fa-list-ul">&#xE2C7;</i> {{ __('projects.new_resource') }}</a>
                <a href="{{ url('project_expenses/'.session('project_id').'/create') }}" class="md-color-white ajax_create-btn"><i class="fa fa-list-ul"></i> {{ __('projects.new_expense') }}</a>
                <a href="{{ url('project_services/'.session('project_id').'/create') }}" class="md-color-white ajax_create-btn"><i class="fa fa-list-ul"></i> {{ __('projects.new_service') }}</a>
                <a href="{{ url('project_materials/'.session('project_id').'/create') }}" class="md-color-white ajax_create-btn"><i class="fa fa-list-ul"></i> {{ __('projects.new_material') }}</a>
            </div>
        </div>
    </div> --}}
    @endif
@endsection

{{-- @section('create_div')
	@component('project/create', [])

	@endcomponent
@endsection --}}