@extends('layouts.app', ['favoriteTitle' => __('whatif.whatif_title'), 'favoriteUrl' => 'whatif'])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'whatif';
		var urlParameters = '?project_id={{ session('project_id') }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	               { data: 'comment', name: 'comment' },
                       { data: 'created_at', name: 'created_at' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [

			            { pre: '<a title="{{__('general.edit')}}" href="/whatif/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
                     { pre: '<a title="{{__('whatif_tasks.whatif_tasks')}}" href="/whatif_tasks/', post: '" class="table-actions whatif-btn"><i class="fa fa-archive" aria-hidden="true"></i></a>' },
			            { pre: '<a title="{{__('general.delete')}}" href="/whatif/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>

    <script>

	</script>
@endsection

@section('section_title', __('whatif.whatif'))

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
                	<table id="whatif-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('whatif_tooltip.id')}}">{{ __('whatif.id') }}</th>

                	        	<th title="{{__('whatif_tooltip.comment')}}">{{ __('whatif.comment') }}</th>
                                    <th title="{{__('whatif_tooltip.created_at')}}">{{ __('whatif.created_at') }}</th>

                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('whatif.add_new') }}">{{ __('whatif.add_new') }}</a>
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('whatif/create')

	@endcomponent
@endsection