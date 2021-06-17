@extends('layouts.app', ['favoriteTitle' => __('stakeholders.stakeholders'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'stakeholders';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'contact_name', name: 'contact_name' },
	            { data: 'influence', name: 'influence' },
	            { data: 'impacted', name: 'impacted' },
	            { data: 'impact', name: 'impact' },
	            { data: 'expectations', name: 'expectations' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title="{{__('general.edit')}}" href="/stakeholders/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title="{{__('general.delete')}}" href="/stakeholders/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('stakeholders.stakeholders'))

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

                	{{-- @if(!session()->has('project_id'))
                		<div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                	@endif --}}

					{{-- @if(session()->has('project_id')) --}}
                	<table id="stakeholders-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('stakeholders_tooltip.id')}}">{{ __('stakeholders.id') }}</th>
                	        	<th title="{{ __('stakeholders_tooltip.contact')}}">{{ __('stakeholders.contact') }}</th>
                	        	<th title="{{ __('stakeholders_tooltip.influence')}}">{{ __('stakeholders.influence') }}</th>
                	        	<th title="{{ __('stakeholders_tooltip.impacted')}}">{{ __('stakeholders.impacted') }}</th>
                	        	<th title="{{ __('stakeholders_tooltip.impact')}}">{{ __('stakeholders.impact') }}</th>
                	        	<th title="{{ __('stakeholders_tooltip.expectations')}}">{{ __('stakeholders.expectations') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('stakeholders_tooltip.add_new')}}">{{ __('stakeholders.add_new') }}</a>
                		</div>
                	</div>
                	{{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('stakeholder/create', ['contacts' => $contacts, 'url'=>Request::path()])

	@endcomponent
@endsection