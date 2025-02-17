@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'rates';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'country_name', name: 'country_name' },
	            { data: 'city_name', name: 'city_name' },
	            { data: 'project_role_title', name: 'project_role_title' },
	            { data: 'seniority_title', name: 'seniority_title' },
	            { data: 'title', name: 'title' },
	            { data: 'value', name: 'value' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'workplace', name: 'workplace' },
	            { data: 'office_name', name: 'office_name' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title={{__('general.edit')}} href="/rates/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title={{__('general.delete')}} href="/rates/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('rates.rates'))

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

                	<table id="rates-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('rates_tooltip.id')}}">{{ __('rates.id') }}</th>
                	        	<th title="{{ __('rates_tooltip.country')}}">{{ __('rates.country') }}</th>
                	        	<th title="{{ __('rates_tooltip.city')}}">{{ __('rates.city') }}</th>
                	        	<th title="{{ __('rates_tooltip.project_role')}}">{{ __('rates.project_role') }}</th>
                	        	<th title="{{ __('rates_tooltip.seniority')}}">{{ __('rates.seniority') }}</th>
                	        	<th title="{{ __('rates_tooltip.title')}}">{{ __('rates.title') }}</th>
                	        	<th title="{{ __('rates_tooltip.value')}}">{{ __('rates.value') }}</th>
                	        	<th title="{{ __('rates_tooltip.currency')}}">{{ __('rates.currency') }}</th>
                	        	<th title="{{ __('rates_tooltip.workplace')}}">{{ __('rates.workplace') }}</th>
                	        	<th title="{{ __('rates_tooltip.office')}}">{{ __('rates.office') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('rates_tooltip.add_new')}}">{{ __('rates.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('rate/create', ['company' => $company, 'countries' => $countries, 'cities' => $cities,
	 'project_roles' => $project_roles, 'currencies' => $currencies, 'seniorities' => $seniorities,  'offices'=>$offices]
	)

	@endcomponent
@endsection