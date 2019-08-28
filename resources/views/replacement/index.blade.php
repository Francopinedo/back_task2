@extends('layouts.app', ['favoriteTitle' => __('replacements.replacements'), 'favoriteUrl' => 'replacements'])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'replacements';
		var urlParameters = '?project_id={{ session('project_id') }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'absence_data', name: 'absence_data' },
	            { data: 'user_name', name: 'user_name' },
	            { data: 'replacement_user_name', name: 'replacement_user_name' },
	            { data: 'from', name: 'from' },
	            { data: 'to', name: 'to' },
	            { data: 'ticket', name: 'ticket' },
	            { data: 'comment', name: 'comment' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a href="/replacements/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/replacements/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('replacements.replacements'))

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
                	<table id="replacements-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('replacements.id') }}</th>
                	        	<th>{{ __('replacements.absence') }}</th>
                	        	<th>{{ __('replacements.user') }}</th>
                	        	<th>{{ __('replacements.replacement') }}</th>
                	        	<th>{{ __('replacements.from') }}</th>
                	        	<th>{{ __('replacements.to') }}</th>
                	        	<th>{{ __('replacements.ticket') }}</th>
                	        	<th>{{ __('replacements.comment') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('replacements.add_new') }}</a>
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('replacement/create', ['absences' => $absences, 'users' => $users])

	@endcomponent
@endsection