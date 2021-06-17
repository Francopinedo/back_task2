@extends('layouts.app', ['favoriteTitle' => __('costs.costs'), 'favoriteUrl' => 'costs'])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'costs';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'country_name', name: 'country_name' },
	            { data: 'city_name', name: 'city_name' },
	            { data: 'seniority_title', name: 'seniority_title' },
	            { data: 'project_role_title', name: 'project_role_title' },
	            { data: 'workplace', name: 'workplace' },
	            { data: 'detail', name: 'detail' },
	            { data: 'value', name: 'value' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title={{__('general.edit')}} href="/costs/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title={{__('general.delete')}} href="/costs/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('costs.costs'))

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

                	<table id="costs-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('costs_tooltip.id')}}">{{ __('costs.id') }}</th>
                	        	<th title="{{ __('costs_tooltip.country')}}">{{ __('costs.country') }}</th>
                	        	<th title="{{ __('costs_tooltip.city')}}">{{ __('costs.city') }}</th>
                	        	<th title="{{ __('costs_tooltip.seniority')}}">{{ __('costs.seniority') }}</th>
                	        	<th title="{{ __('costs_tooltip.project_role')}}">{{ __('costs.project_role') }}</th>
                	        	<th title="{{ __('costs_tooltip.workplace')}}">{{ __('costs.workplace') }}</th>
                	        	<th title="{{ __('costs_tooltip.detail')}}">{{ __('costs.detail') }}</th>
                	        	<th title="{{ __('costs_tooltip.value')}}">{{ __('costs.value') }}</th>
                	        	<th title="{{ __('costs_tooltip.currency')}}">{{ __('costs.currency') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('costs_tooltip.add_new')}}">{{ __('costs.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('cost/create', ['company' => $company, 'countries' => $countries, 'cities' => $cities, 'seniorities' => $seniorities, 'project_roles' => $project_roles, 'currencies' => $currencies])

	@endcomponent
@endsection