@extends('layouts.app', ['favoriteTitle' => __('procurements.procurements'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'procurements';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'project_id', name: 'project_id' },
	            { data: 'type', name: 'type' },
	            { data: 'date', name: 'date' },
	            { data: 'description', name: 'description' },
	            { data: 'RFPID', name: 'RFPID', visible: false },
	            { data: 'ContractID', name: 'ContractID', visible: false },
	            { data: 'specifications', name: 'specifications' },
	            { data: 'approver_name', name: 'approver_name' },
	            { data: 'responsable_id', name: 'responsable_id' },
	            { data: 'due_date', name: 'due_date' },
	            { data: 'cost', name: 'cost' },
	            { data: 'cost_currency_id', name: 'cost_currency_id' },
	            { data: 'quality_required', name: 'quality_required' },
	            { data: 'contract_status', name: 'contract_status' },
	            { data: 'provider_id', name: 'provider_id' },
	            { data: 'provider_feedback', name: 'provider_feedback' },
	            { data: 'delivery', name: 'delivery' },
	            { data: 'quality', name: 'quality' },
	            { data: 'overallscore', name: 'overallscore' },
	            { data: 'requirement_status', name: 'requirement_status' },
	            { data: 'delivered_date', name: 'delivered_date' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title="{{__('procurements.offers')}}" href="/procurements/', post: '/rows" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' },
			            { pre: '<a title="{{__('general.edit')}}" href="/procurements/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
                        <?php if (Auth::user()->hasPermission('delete.users')) { ?>
	                       { pre: '<a title="{{__('general.delete')}}" href="/procurements/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
                        <?php } ?>
			        ];

		DtablesUtil(tableName, columns, actions);
	});
	</script>
@endsection

@section('section_title', __('procurements.procurements'))

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
                	<table id="procurements-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('procurements_tooltip.id')}}">{{ __('procurements.id') }}</th>
                	        	<th title="{{__('procurements_tooltip.project')}}">{{ __('procurements.project') }}</th>
                	        	<th title="{{__('procurements_tooltip.type')}}">{{ __('procurements.type') }}</th>
                	        	<th title="{{__('procurements_tooltip.date')}}">{{ __('procurements.date') }}</th>
                	        	<th title="{{__('procurements_tooltip.description')}}">{{ __('procurements.description') }}</th>
                	        	<th title="{{__('procurements_tooltip.RFPID')}}">{{ __('procurements.RFPID') }}</th>
                	        	<th title="{{__('procurements_tooltip.ContractID')}}">{{ __('procurements.ContractID') }}</th>
                	        	<th title="{{__('procurements_tooltip.specifications')}}">{{ __('procurements.specifications') }}</th>
                	        	<th title="{{__('procurements_tooltip.approver_name')}}">{{ __('procurements.approver_name') }}</th>
                	        	<th title="{{__('procurements_tooltip.responsable')}}">{{ __('procurements.responsable') }}</th>
                	        	<th title="{{__('procurements_tooltip.due')}}">{{ __('procurements.due') }}</th>
                	        	<th title="{{__('procurements_tooltip.cost')}}">{{ __('procurements.cost') }}</th>
                	        	<th title="{{__('procurements_tooltip.cost_currency')}}">{{ __('procurements.cost_currency') }}</th>
                	        	<th title="{{__('procurements_tooltip.quality_required')}}">{{ __('procurements.quality_required') }}</th>
                	        	<th title="{{__('procurements_tooltip.contract_status')}}">{{ __('procurements.contract_status') }}</th>
                	        	<th title="{{__('procurements_tooltip.provider')}}">{{ __('procurements.provider') }}</th>
                	        	<th title="{{__('procurements_tooltip.provider_feedback')}}">{{ __('procurements.provider_feedback') }}</th>
                	        	<th title="{{__('procurements_tooltip.delivery')}}">{{ __('procurements.delivery') }}</th>
                	        	<th title="{{__('procurements_tooltip.quality')}}">{{ __('procurements.quality') }}</th>
                	        	<th title="{{__('procurements_tooltip.overallscore')}}">{{ __('procurements.overallscore') }}</th>
                	        	<th title="{{__('procurements_tooltip.requirement_status')}}">{{ __('procurements.requirement_status') }}</th>
                	        	<th title="{{__('procurements_tooltip.delivered')}}">{{ __('procurements.delivered') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{__('procurements.add_new')}}">{{ __('procurements.add_new') }}</a>
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('procurement/create', [
						'currencies' => $currencies,
						'company'    => $company,
						'providers'  => $providers,
						'users'      => $users,
						'url'		 => Request::path()
						]
			)

	@endcomponent
@endsection