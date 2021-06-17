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
	$(function() {
	    $('#project_kpi_alerts-table').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
	        processing: true,
	        serverSide: true,
	        ajax:  '{{ env('API_PATH') }}project_kpi_alerts/datatables?project_id={{ $project_id }}',
	        dom: '<"top">Brt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
			buttons: [
			            { extend: 'copyHtml5', exportOptions: { columns: ':visible:not(:last-child)' } },
			            { extend: 'excelHtml5', exportOptions: { columns: ':visible:not(:last-child)' } },
			            { extend: 'csvHtml5', exportOptions: { columns: ':visible:not(:last-child)' } },
				        { extend: 'pdfHtml5', orientation:'landscape',exportOptions: { columns: ':visible:not(:last-child)' } },
			        ],
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'kpi_description', name: 'kpi_description' },
	            { data: 'red_alert', name: 'red_alert' },
	            { data: 'yellow_alert', name: 'yellow_alert' },
	            { data: 'green_alert', name: 'green_alert' },
				{ data: 'percent_red_alert', name: 'percent_red_alert' },
	            { data: 'percent_yellow_alert', name: 'percent_yellow_alert' },
	            { data: 'percent_green_alert', name: 'percent_green_alert' },
	            { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            targets: -1,
	            data: null,
	            render: function (data, type, row) {
                    return '' +
	            		'<a title="{{__('general.edit')}}" href="/project_kpi_alerts/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' 
	            		<?php if (Auth::user()->hasPermission('delete.users')) { ?>+
	            			'<a title="{{__('general.delete')}}" href="/project_kpi_alerts/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
	            		<?php } ?>;
                }
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
	});



	</script>
@endsection

@section('section_title', __('projects.alerts'))

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




					<h4 class="heading_a uk-margin-bottom">{{ __('projects.alerts') }}</h4>
                	<table id="project_kpi_alerts-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('project_kpi_alerts_tooltip.id')}}">{{ __('project_kpi_alerts.id') }}</th>
                	        	<th title="{{__('project_kpi_alerts_tooltip.kpi')}}">{{ __('project_kpi_alerts.kpi') }}</th>
                	        	<th title="{{__('project_kpi_alerts_tooltip.red_alert')}}">{{ __('project_kpi_alerts.red_alert') }}</th>
                	        	<th title="{{__('project_kpi_alerts_tooltip.yellow_alert')}}">{{ __('project_kpi_alerts.yellow_alert') }}</th>
                	        	<th title="{{__('project_kpi_alerts_tooltip.green_alert')}}">{{ __('project_kpi_alerts.green_alert') }}</th>
								<th title="{{__('project_kpi_alerts_tooltip.percent_red_alert')}}">{{ __('project_kpi_alerts.percent_red_alert') }}</th>
                	        	<th title="{{__('project_kpi_alerts_tooltip.percent_yellow_alert')}}">{{ __('project_kpi_alerts.percent_yellow_alert') }}</th>
                	        	<th title="{{__('project_kpi_alerts_tooltip.percent_green_alert')}}">{{ __('project_kpi_alerts.percent_green_alert') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('project_kpi_alerts.add_new') }}</a>
                		</div>
                	</div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('project_kpi_alert/create', ['kpis' => $kpis,'project_id'=>$project_id, 'url'=>Request::path()])

	@endcomponent
@endsection