@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'companies';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'name', name: 'name' },
	            { data: 'phone', name: 'phone' },
	            {data: 'country_name', name: 'country_name'},
	            { data: 'city_name', name: 'city_name' },
	            { data: 'industry_name', name: 'industry_name' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
            {
                pre: '<a title="{{__('general.edit')}}" href="/admin_companies/',
                post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
            },
            { pre: '<a title="{{__('general.delete')}}" href="/admin_companies/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' },

            { pre: '<a href="/admin_companies/', post: '" title="{{ __('companies.show') }}" class="table-actions info-btn" data-uk-modal="{target:\'#modal_info\'}"><i class="fa fa-info-circle" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions);
	});
	</script>
@endsection

@section('section_title', __('companies.companies'))

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

                	<table id="companies-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('companies_tooltip.id')}}">{{ __('companies.id') }}</th>
                	        	<th title="{{__('companies_tooltip.name')}}">{{ __('companies.name') }}</th>
                	        	<th title="{{__('companies_tooltip.phone')}}">{{ __('companies.phone') }}</th>
                	        	<th title="{{__('companies_tooltip.country')}}">{{ __('companies.country') }}</th>
                	        	<th title="{{__('companies_tooltip.city')}}">{{ __('companies.city') }}</th>
                	        	<th title="{{__('companies_tooltip.industry')}}">{{ __('companies.industry') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			@role('Admin')
                			@else
                				<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('companies.add_new') }}">{{ __('companies.add_new') }}</a>
                			@endrole
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('admin_company/create', ['cities' => [], 'countries' => $countries, 'currencies' => $currencies, 'industries' => $industries])

	@endcomponent
@endsection