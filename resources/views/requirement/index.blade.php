@extends('layouts.app', ['favoriteTitle' => __('requirements.requirements'), 'favoriteUrl' => 'requirements'])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'requirements';
		var urlParams = '?project_id={{session('project_id')}}&view_type_project={{Auth::user()->hasPermission('view.projectrequeriments')?1:0}}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'description', name: 'description' },
	            { data: 'type', name: 'type' },
	            { data: 'request_date', name: 'request_date' },
	            { data: 'status_comment', name: 'status_comment', visible: false },
	            { data: 'due_date', name: 'due_date', visible: false },
	            { data: 'owner_name', name: 'owner_name' },
	            { data: 'priority', name: 'priority' },
	            { data: 'business_value', name: 'business_value' },
	            { data: 'requester_name', name: 'requester_name' },
	            { data: 'requester_email', name: 'requester_email' },
	            { data: 'requester_type', name: 'requester_type' },
	            { data: 'approval_date', name: 'approval_date' },
	            { data: 'approver_name', name: 'approver_name' },
	            { data: 'comment', name: 'comment' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a href="/requirements/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/requirements/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParams);
	});
	</script>

@endsection

@section('section_title', __('requirements.requirements'))

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
                	<table id="requirements-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('requirements.id') }}</th>
                	        	<th>{{ __('requirements.description') }}</th>
                	        	<th>{{ __('requirements.type') }}</th>
                	        	<th>{{ __('requirements.date') }}</th>
                	        	<th>{{ __('requirements.status_comment') }}</th>
                	        	<th>{{ __('requirements.due_date') }}</th>
                	        	<th>{{ __('requirements.owner') }}</th>
                	        	<th>{{ __('requirements.priority') }}</th>
                	        	<th>{{ __('requirements.business_value') }}</th>
                	        	<th>{{ __('requirements.requester_name') }}</th>
                	        	<th>{{ __('requirements.requester_email') }}</th>
                	        	<th>{{ __('requirements.requester_type') }}</th>
                	        	<th>{{ __('requirements.approval_date') }}</th>
                	        	<th>{{ __('requirements.approver_name') }}</th>
                	        	<th>{{ __('requirements.comment') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('requirements.add_new') }}</a>
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('requirement/create', [
					'users' => $users
				]
			)

	@endcomponent
@endsection