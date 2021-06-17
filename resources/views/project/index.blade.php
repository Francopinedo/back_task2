@extends('layouts.app', ['favoriteTitle' => __('projects.projects'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var project = '{{session('project_id')}}';
		var tableName = 'projects'
		var urlParameters = project==''?  '?company_id={{ $company->id }}': '?company_id={{ $company->id }}&project_id='+project;
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
			{ pre: '<a title="{{__('general.owner')}}" href="/project/rows/', post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' },
            { pre: '<a title="{{__('general.archive')}}" href="/sprints/', post: '" class="table-actions"><i class="fa fa-archive" aria-hidden="true"></i></a>' },
            <?php if(!Auth::user()->hasRole('1') ) { ?>
			{ pre: '<a title="{{__('general.edit')}}" href="/projects/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
            <?php } ?>
            { pre: '<a title="{{__('general.file')}}" href="/projects/', post: '/pdf" class="table-actions pdf-btn"><i class="fa fa-file" aria-hidden="true"></i></a>' },
            <?php if (Auth::user()->hasPermission('delete.users') && !Auth::user()->hasRole('1')) { ?>
                { pre: '<a title="{{__('general.delete')}}" href="/projects/', post: '/show" class="table-actions show-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'}
            <?php } ?>
		];

		DtablesUtil(tableName, columns, actions, urlParameters);

        $('table').on('click', '.show-btn', function(e){

            e.preventDefault();
            var $info_url = $(this).attr('href');

            $.ajax({
                url: $info_url,
                type: 'GET',
                dataType: 'json'
            }).done(
              function(data){
                  UIkit.modal.confirm(data.view);
              }
            );
        });

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
                	        	<th title="{{ __('projects_tooltip.id')}}">{{ __('projects.id') }}</th>
                	        	<th title="{{ __('projects_tooltip.name')}}">{{ __('projects.name') }}</th>
                	        	<th title="{{ __('projects_tooltip.customer')}}">{{ __('projects.customer') }}</th>
                	        	<th title="{{ __('projects_tooltip.start')}}">{{ __('projects.start') }}</th>
                	        	<th title="{{ __('projects_tooltip.finish')}}">{{ __('projects.finish') }}</th>
                	        	<th title="{{ __('projects_tooltip.sow_number')}}">{{ __('projects.sow_number') }}</th>
                	        	<th title="{{ __('projects_tooltip.identificator')}}">{{ __('projects.identificator') }}</th>
                	        	<th title="{{ __('projects_tooltip.status')}}">{{ __('projects.status') }}</th>
                	        	<th title="{{ __('projects_tooltip.engagement')}}">{{ __('projects.engagement') }}</th>
                	        	<th title="{{ __('general.actions') }}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('projects_tooltip.add_new')}}">{{ __('projects.add_new') }}</a>
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
	'technical_directors'=>$technical_directors, 'delivery_managers'=>$delivery_managers, 'project_managers'=>$project_managers, 'url'=>Request::path()])

	@endcomponent
@endsection
