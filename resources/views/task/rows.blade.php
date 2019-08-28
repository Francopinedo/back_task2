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
	    $('#procurement_offers-table').DataTable({
	        processing: true,
	        serverSide: true,
	        bPaginate: false,
	        ajax:  '{{ env('API_PATH') }}procurement_offers/datatables?procurement_id={{ $procurement_id }}',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'description', name: 'description' },
	            { data: 'specifications', name: 'specifications' },
	            { data: 'delivery_max_days_offered', name: 'delivery_max_days_offered' },
	            { data: 'delivery_responsable', name: 'delivery_responsable' },
	            { data: 'cost', name: 'cost' },
	            { data: 'quality', name: 'quality' },
	            { data: 'provider_id', name: 'provider_id' },
	            { data: 'comment', name: 'comment' },
	            { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            targets: -1,
	            data: null,
	            render: function (data, type, row) {
                    return '' +
	            		'<a href="/procurement_offers/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            		'<a href="/procurement_offers/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
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
	});

	</script>
@endsection

@section('section_title', __('procurements.offers'))

@section('content')

	@if(!session()->has('project_id'))
		<div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
	@endif

	@if(session()->has('project_id'))
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



					<h4 class="heading_a uk-margin-bottom">{{ __('procurements.offers') }}</h4>
                	<table id="procurement_offers-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('procurements.id') }}</th>
                	        	<th>{{ __('procurements.description') }}</th>
                	        	<th>{{ __('procurements.specifications') }}</th>
                	        	<th>{{ __('procurements.delivery_max_days_offered') }}</th>
                	        	<th>{{ __('procurements.delivery_responsable') }}</th>
                	        	<th>{{ __('procurements.cost') }}</th>
                	        	<th>{{ __('procurements.quality') }}</th>
                	        	<th>{{ __('procurements.provider') }}</th>
                	        	<th>{{ __('procurements.comment') }}</th>
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
                <a href="{{ url('procurement_offers/'.$procurement_id.'/create') }}" class="md-color-white ajax_create-btn"><i class="fa fa-list-ul">&#xE2C7;</i> {{ __('procurements.new_offer') }}</a>
            </div>
        </div>
    </div>
    @endif
@endsection

{{-- @section('create_div')
	@component('procurement/create', [])

	@endcomponent
@endsection --}}