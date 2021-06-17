@extends('layouts.app', ['favoriteTitle' => __('invoices.invoices'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
	@include('datatables.basic')
	<script>
	// $(function() {
	// 	var tableName = 'invoices';
	// 	var urlParameters = '?project_id={{ session('project_id') }}';
	// 	var columns = [
	//             { data: 'id', name: 'id', visible: true },
	//             { data: 'number', name: 'number' },
	//             { data: 'purchase_order', name: 'purchase_order' },
	//             { data: 'concept', name: 'concept' },
	//             { data: 'from', name: 'from' },
	//             { data: 'to', name: 'to' },
	//             { data: 'contact_name', name: 'contact_name' },
	//             { data: 'currency_name', name: 'currency_name' },
	//             { data: 'due_date', name: 'due_date' },
	//             { data: 'total', name: 'total' },
	//             { data: 'bill_to', name: 'bill_to' },
	//             { data: 'remit_to', name: 'remit_to' },
	//             { data: 'comments', name: 'comments' },
	//             { data: 'actions', name: 'actions'}
	//         ];

	// 	var actions = [
	// 		            { pre: '<a title="{{__('general.owner')}}" href="/invoices/rows/', post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' },
	// 		            { pre: '<a title="{{__('general.edit')}}" href="/invoices/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
	// 		            { pre: '<a title="{{__('general.delete')}}" href="/invoices/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
	// 		        ];

	// 	DtablesUtil(tableName, columns, actions, urlParameters);
	// });

	$(function() {
		var project = '{{session('project_id')}}';
		var tableName = 'invoices'
		var urlParameters = project==''?  '?company_id={{ $company->id }}': '?company_id={{ $company->id }}&project_id='+project;
	    $('#invoices-table').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
	        processing: true,
	        serverSide: true,
	        ajax:  '{{ env('API_PATH') }}'+tableName+'/datatables'+urlParameters,
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
				{ data: 'id', name: 'id', visible: true },
	            { data: 'number', name: 'number' },
	            { data: 'purchase_order', name: 'purchase_order' },
	            { data: 'concept', name: 'concept' },
	            { data: 'from', name: 'from' },
	            { data: 'to', name: 'to' },
	            { data: 'contact_name', name: 'contact_name' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'due_date', name: 'due_date' },
	            { data: 'total', name: 'total' },
	            { data: 'bill_to', name: 'bill_to' },
	            { data: 'remit_to', name: 'remit_to' },
	            { data: 'comments', name: 'comments' },
	            { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            targets: -1,
	            data: null,
	            render: function (data, type, row) {
					if(row.emited=='0'){
					return '' 
+					'<a title="{{__('general.edit')}}" href="/invoices/rows/' + row.id + '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' 

						+'<a title="{{__('general.edit')}}" href="/invoices/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
					 +	'<a title="{{__('general.delete')}}" href="/invoices/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
							}else {
								return '' +
								'<a title="{{__('general.edit')}}" href="/invoices/rows/' + row.id + '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' ;

		var actions = [
			            { pre: '<a title="{{__('invoices.items')}}" href="/invoices/rows/', post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' },
			            { pre: '<a title="{{__('general.edit')}}" href="/invoices/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
                        <?php if (Auth::user()->hasPermission('delete.users')) { ?>
                            { pre: '<a title="{{__('general.delete')}}" href="/invoices/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
                        <?php } ?>
			        ];

	$(document).ready(function() {
		$("#datatables-length").append($(".dataTables_length"));
		$("#datatables-pagination").append($(".simple_numbers"));
	});



	</script>
@endsection

@section('section_title', __('invoices.invoices'))

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

					@if(session()->has('project_id'))
                	<table id="invoices-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('invoices_tooltip.id')}}">{{ __('invoices.id') }}</th>
                	        	<th title="{{ __('invoices_tooltip.number')}}">{{ __('invoices.number') }}</th>
                	        	<th title="{{ __('invoices_tooltip.purchase_order')}}">{{ __('invoices.purchase_order') }}</th>
                	        	<th title="{{ __('invoices_tooltip.concept')}}">{{ __('invoices.concept') }}</th>
                	        	<th title="{{ __('invoices_tooltip.from')}}">{{ __('invoices.from') }}</th>
                	        	<th title="{{ __('invoices_tooltip.to')}}">{{ __('invoices.to') }}</th>
                	        	<th title="{{ __('invoices_tooltip.contact')}}">{{ __('invoices.contact') }}</th>
                	        	<th title="{{ __('invoices_tooltip.currency')}}">{{ __('invoices.currency') }}</th>
                	        	<th title="{{ __('invoices_tooltip.due_date')}}">{{ __('invoices.due_date') }}</th>
                	        	<th title="{{ __('invoices_tooltip.total')}}">{{ __('invoices.total') }}</th>
                	        	<th title="{{ __('invoices_tooltip.bill_to')}}">{{ __('invoices.bill_to') }}</th>
                	        	<th title="{{ __('invoices_tooltip.remit_to')}}">{{ __('invoices.remit_to') }}</th>
                	        	<th title="{{ __('invoices_tooltip.comments')}}">{{ __('invoices.comments') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<!--<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('invoices_tooltip.add_new')}}">{{ __('invoices.add_new') }}</a>-->
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

<!--@if(session()->has('project_id'))
@section('create_div')
	@component('invoice/create', ['currencies' => $currencies, 'contacts' => $contacts, 'project' => $project, 'company' => $company])

	@endcomponent
@endsection
@endif-->