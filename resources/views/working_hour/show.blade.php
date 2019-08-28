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

    <script src="{{ asset('js/working_hours.js') }}"></script>

    <script>
	$(function() {
	    $('#working_hours-table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax:  '{{ env('API_PATH') }}working_hours/datatables?user_id={{ $teamUser->user_id }}',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'date', name: 'date' },
	            { data: 'hours', name: 'hours' },
	            // { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            // targets: -1,
	            // data: null,
	            // render: function (data, type, row) {
             //        return '' +
	            // 		'<a href="/working_hours/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            // 		'<a href="/working_hours/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
             //    }
	        } ],
	        initComplete: function(settings, json) {
			    tableActions.initEdit();
			    tableActions.initDelete('{{ __('general.confirm') }}');
			}
	    });
	});

	$(document).ready(function() {
		$("#datatables-length").append($(".dataTables_length"));
		$("#datatables-pagination").append($(".simple_numbers"));

		workingHours.init();
	});

	</script>
@endsection

@section('section_title', __('working_hours.working_hours'))

@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

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

                	@if(empty($customer->city_id))
                		<div class="uk-alert uk-alert-warning" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('working_hours.add_city_to_customer') }}
                        </div>
                	@endif

					@if(session()->has('project_id'))
                	<table id="working_hours-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('working_hours.id') }}</th>
                	        	<th>{{ __('working_hours.date') }}</th>
                	        	<th>{{ __('working_hours.hours') }}</th>
                	        	{{-- <th>{{ __('general.actions') }}</th> --}}
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			{{-- <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="generate_working_hours" data-user_id="{{ $teamUser->user_id }}" data-project_id="{{ session('project_id') }}">{{ __('working_hours.generate') }}</a> --}}
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @section('create_div')
	@component('additional_hour/create', ['users' => $users])

	@endcomponent
@endsection --}}