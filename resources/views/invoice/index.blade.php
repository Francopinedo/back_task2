@extends('layouts.app', ['favoriteTitle' => __('invoices.invoices'), 'favoriteUrl' => 'invoices'])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'invoices';
		var urlParameters = '?project_id={{ session('project_id') }}';
		var columns = [
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
	        ];

		var actions = [
			            { pre: '<a href="/invoices/rows/', post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/invoices/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/invoices/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
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
                	        	<th>{{ __('invoices.id') }}</th>
                	        	<th>{{ __('invoices.number') }}</th>
                	        	<th>{{ __('invoices.purchase_order') }}</th>
                	        	<th>{{ __('invoices.concept') }}</th>
                	        	<th>{{ __('invoices.from') }}</th>
                	        	<th>{{ __('invoices.to') }}</th>
                	        	<th>{{ __('invoices.contact') }}</th>
                	        	<th>{{ __('invoices.currency') }}</th>
                	        	<th>{{ __('invoices.due_date') }}</th>
                	        	<th>{{ __('invoices.total') }}</th>
                	        	<th>{{ __('invoices.bill_to') }}</th>
                	        	<th>{{ __('invoices.remit_to') }}</th>
                	        	<th>{{ __('invoices.comments') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<!--<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('invoices.add_new') }}</a>-->
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