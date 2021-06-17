@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'expenses';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'detail', name: 'detail' },
	            { data: 'amount', name: 'amount' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'reimbursable', name: 'reimbursable' },
	            { data: 'cost', name: 'cost' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title={{__('general.edit')}} href="/expenses/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title={{__('general.delete')}} href="/expenses/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('expenses.expenses'))

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

                	<table id="expenses-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('expenses_tooltip.id')}}">{{ __('expenses.id') }}</th>
                	        	<th title="{{__('expenses_tooltip.detail')}}">{{ __('expenses.detail') }}</th>
                	        	<th title="{{__('expenses_tooltip.amount')}}">{{ __('expenses.amount') }}</th>
                	        	<th title="{{__('expenses_tooltip.currency')}}">{{ __('expenses.currency') }}</th>
                	        	<th title="{{__('expenses_tooltip.reimbursable')}}">{{ __('expenses.reimbursable') }}</th>
                	        	<th title="{{__('expenses_tooltip.cost')}}">{{ __('expenses.cost') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('expenses.add_new') }}">{{ __('expenses.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('expense/create', ['company' => $company, 'currencies' => $currencies])

	@endcomponent
@endsection