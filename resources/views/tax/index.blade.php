@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'taxes';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'detail', name: 'detail' },
	            { data: 'value', name: 'value' },
	            { data: 'percentage', name: 'percentage' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'country_name', name: 'country_name' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a href="/taxes/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/taxes/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('taxes.taxes'))

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

                	<table id="taxes-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('taxes.id') }}</th>
                	        	<th>{{ __('taxes.detail') }}</th>
                	        	<th>{{ __('taxes.value') }}</th>
                	        	<th>{{ __('taxes.percentage') }}</th>
                	        	<th>{{ __('taxes.currency') }}</th>
                	        	<th>{{ __('taxes.country') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('taxes.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('tax/create', ['company' => $company, 'currencies' => $currencies,'countries'=>$countries])

	@endcomponent
@endsection