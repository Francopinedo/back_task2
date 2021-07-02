@extends('layouts.app', ['favoriteTitle' => __('requirements.requirements'), 'favoriteUrl' => url(Request::path())])

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
	           	{data: 'priority', name: 'priority',
		 			render: function (data, type, row) {
                        if (row.priority == '1') {
							return 'Low';
						}if (row.priority == '2') {
							return 'Medium';
						}if (row.priority == '3') {
							return 'High';
						}
					}

				},
	            { data: 'business_value', name: 'business_value',
	            	render: function (data, type, row) {
                        if (row.business_value == '1') {
							return 'Low';
						}if (row.business_value == '2') {
							return 'Medium';
						}if (row.business_value == '3') {
							return 'High';
						}
					}
	            },
	            { data: 'requester_name', name: 'requester_name' },
	            { data: 'requester_email', name: 'requester_email' },
	            { data: 'requester_type', name: 'requester_type' },
	            { data: 'approval_date', name: 'approval_date' },
	            { data: 'approver_name', name: 'approver_name' },
	            { data: 'comment', name: 'comment' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title="{{__('general.edit')}}" href="/requirements/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
                        <?php if (Auth::user()->hasPermission('delete.users')) { ?>
	                       { pre: '<a title="{{__('general.delete')}}" href="/requirements/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
                        <?php } ?>
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
                	        	<th title="{{ __('requirements_tooltip.id')}}">{{ __('requirements.id') }}</th>
                	        	<th title="{{ __('requirements_tooltip.description')}}">{{ __('requirements.description') }}</th>
                	        	<th title="{{ __('requirements_tooltip.type')}}">{{ __('requirements.type') }}</th>
                	        	<th title="{{ __('requirements_tooltip.date')}}">{{ __('requirements.date') }}</th>
                	        	<th title="{{ __('requirements_tooltip.status_comment')}}">{{ __('requirements.status_comment') }}</th>
                	        	<th title="{{ __('requirements_tooltip.due_date')}}">{{ __('requirements.due_date') }}</th>
                	        	<th title="{{ __('requirements_tooltip.owner')}}">{{ __('requirements.owner') }}</th>
                	        	<th title="{{ __('requirements_tooltip.priority')}}">{{ __('requirements.priority') }}</th>
                	        	<th title="{{ __('requirements_tooltip.business_value')}}">{{ __('requirements.business_value') }}</th>
                	        	<th title="{{ __('requirements_tooltip.requester_name')}}">{{ __('requirements.requester_name') }}</th>
                	        	<th title="{{ __('requirements_tooltip.requester_email')}}">{{ __('requirements.requester_email') }}</th>
                	        	<th title="{{ __('requirements_tooltip.requester_type')}}">{{ __('requirements.requester_type') }}</th>
                	        	<th title="{{ __('requirements_tooltip.approval_date')}}">{{ __('requirements.approval_date') }}</th>
                	        	<th title="{{ __('requirements_tooltip.approver_name')}}">{{ __('requirements.approver_name') }}</th>
                	        	<th title="{{ __('requirements_tooltip.comment')}}">{{ __('requirements.comment') }}</th>
                	        	<th title="{{ __('general.actions') }}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('requirements_tooltip.add_new')}}">{{ __('requirements.add_new') }}</a>
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
					'users' => $users,
					'url' => Request::path()
				]
			)

	@endcomponent
@endsection