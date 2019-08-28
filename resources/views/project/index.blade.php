@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'projects';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'name', name: 'name' },
	            { data: 'customer_name', name: 'customer_name' },
	            { data: 'start', name: 'start' },
	            { data: 'finish', name: 'finish' },
	            { data: 'sow_number', name: 'sow_number' },
	            { data: 'identificator', name: 'identificator' },
	            { data: 'status', name: 'status' },
	            { data: 'engagement', name: 'engagement' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a href="/project/rows/', post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/projects/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/projects/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('projects.projects'))

@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                	@if(empty($customers))
                		<div class="uk-alert uk-alert-danger" data-uk-alert>
                            {{ __('projects.add_a_customer') }}
                        </div>
                	@endif

                	@if(empty($users))
                		<div class="uk-alert uk-alert-danger" data-uk-alert>
                            {{ __('projects.add_users') }}
                        </div>
                	@endif

                	@if(session()->has('message'))
                		<div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                	@endif

					@if(!empty($customers) && !empty($users))
                	<table id="projects-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('projects.id') }}</th>
                	        	<th>{{ __('projects.name') }}</th>
                	        	<th>{{ __('projects.customer') }}</th>
                	        	<th>{{ __('projects.start') }}</th>
                	        	<th>{{ __('projects.finish') }}</th>
                	        	<th>{{ __('projects.sow_number') }}</th>
                	        	<th>{{ __('projects.identificator') }}</th>
                	        	<th>{{ __('projects.status') }}</th>
                	        	<th>{{ __('projects.engagement') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('projects.add_new') }}</a>
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('project/create', ['customers' => $customers, 'departments' => $departments, 'users' => $users, 'engagements'=>$engagements,
	'technical_directors'=>$technical_directors, 'delivery_managers'=>$delivery_managers, 'project_managers'=>$project_managers])

	@endcomponent
@endsection