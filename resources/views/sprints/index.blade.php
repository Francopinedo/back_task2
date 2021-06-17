@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'sprints';
		var urlParameters = '?project_id={{ $project->id }}';
		var columns = [
	        { data: 'id', name: 'id', visible: false },
  			{ data: 'project_name', name: 'project_name' },
	        { data: 'customer_name', name: 'customer_name' },
  			{ data: 'short_name', name: 'short_name' },
	        { data: 'long_name', name: 'long_name' },
  			{ data: 'Duration', name: 'Duration' },
	        { data: 'version', name: 'version' },
	 		{ data: 'release', name: 'release' },
	        { data: 'milestone', name: 'milestone' },
			{ data: 'NumberOfChangesRequired', name: 'NumberOfChangesRequired' },
	        { data: 'NumberOfChangesResolved', name: 'NumberOfChangesResolved' },
 			{ data: 'time_status', name: 'time_status' },
	        { data: 'task_status', name: 'task_status' },
 			{ data: 'active', name: 'active' },
	        { data: 'actions', name: 'actions'}
	    ];

		var actions = [
 			{ pre: '<a title="{{__('general.ticket')}}" href="/sprints/', post: '/tickets" class="table-actions"><i class="fa fa-ticket" aria-hidden="true"></i></a>' },
 			<?php if (!Auth::user()->hasRole('1')) { ?>
			    { pre: '<a title="{{__('general.edit')}}" href="/sprints/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			<?php } 
			    if (Auth::user()->hasPermission('delete.users') && !Auth::user()->hasRole('1')) { ?>
			    { pre: '<a title="{{__('general.delete')}}" href="/sprints/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			 <?php } ?>
		];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('sprints.sprints'))

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

                	<table id="sprints-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('sprints.id') }}</th>

						<th title="{{ __('sprints_tooltip.project_name') }}">{{ __('sprints.project_name') }}</th>
					<th title="{{ __('sprints_tooltip.customer_name') }}">{{ __('sprints.customer_name') }}</th>
					<th title="{{ __('sprints_tooltip.short_name') }}">{{ __('sprints.short_name') }}</th>
					<th title="{{ __('sprints_tooltip.long_name') }}">{{ __('sprints.long_name') }}</th>
					<th title="{{ __('sprints_tooltip.Duration') }}">{{ __('sprints.Duration') }}</th>
					<th title="{{ __('sprints_tooltip.version') }}">{{ __('sprints.version') }}</th>
					<th title="{{ __('sprints_tooltip.release') }}">{{ __('sprints.release') }}</th>
					<th title="{{ __('sprints_tooltip.milestone') }}">{{ __('sprints.milestone') }}</th>
					<th title="{{ __('sprints_tooltip.NumberOfChangesRequired') }}">{{ __('sprints.NumberOfChangesRequired') }}</th>
					<th title="{{ __('sprints_tooltip.NumberOfChangesResolved') }}">{{ __('sprints.NumberOfChangesResolved') }}</th>
					<th title="{{ __('sprints_tooltip.time_status') }}">{{ __('sprints.time_status') }}</th>
					<th title="{{ __('sprints_tooltip.task_status') }}">{{ __('sprints.task_status') }}</th>
					<th title="{{ __('sprints_tooltip.active') }}">{{ __('sprints.active') }}</th>

                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('sprints.add_new') }}">{{ __('sprints.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
@component('sprints/create', ['customers' => $customers, 'project' => $project,'time_statuss'=>$time_statuss,'task_statuss'=>$task_statuss, 'url'=>Request::path()])

	@endcomponent
@endsection

