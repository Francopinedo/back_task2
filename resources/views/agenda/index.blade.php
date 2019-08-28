@extends('layouts.app', ['favoriteTitle' => __('agendas.agendas'), 'favoriteUrl' => 'agendas'])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'agendas';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'project_name', name: 'project_name' },
	            { data: 'knowledge_area', name: 'knowledge_area' },
	            { data: 'item_number', name: 'item_number' },
	            { data: 'description', name: 'description' },
	            { data: 'start', name: 'start' },
	            { data: 'status', name: 'status' },
	            { data: 'due', name: 'due' },
	            { data: 'owner_name', name: 'owner_name' },
	            { data: 'detail', name: 'detail' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a href="/agenda/rows/', post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/agendas/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/agendas/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('agendas.agendas'))

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
                	<table id="agendas-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('agendas.id') }}</th>
                	        	<th>{{ __('agendas.project') }}</th>
                	        	<th>{{ __('agendas.knowledge_area') }}</th>
                	        	<th>{{ __('agendas.item_number') }}</th>
                	        	<th>{{ __('agendas.description') }}</th>
                	        	<th>{{ __('agendas.start') }}</th>
                	        	<th>{{ __('agendas.status') }}</th>
                	        	<th>{{ __('agendas.due') }}</th>
                	        	<th>{{ __('agendas.owner') }}</th>
                	        	<th>{{ __('agendas.detail') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('agendas.add_new') }}</a>
                		</div>
                	</div>
                	{{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('agenda/create', ['company' => $company, 'projects' => $projects, 'users' => $users])

	@endcomponent
@endsection