@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'metadocuments';
		var columns = [
	            { data: 'id', name: 'id'},
                { data: 'name', name: 'name' },
	            { data: 'language.name', name: 'language_name' },
                { data: 'activity.activity_desc', name: 'activity_name' },
                { data: 'doctype.type_desc', name: 'doctype_name' },
                { data: 'version', name: 'version' },
                { data: 'link_logo_left', name: 'link_logo_left' },
                { data: 'link_logo_right', name: 'link_logo_right' },
                { data: 'path_ref', name: 'path_ref'},
	            { data: 'actions', name: 'actions'}
	        ];
		var actions = [
			            { pre: '<a title="{{__('general.edit')}}" href="/metadocuments/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title="{{__('general.delete')}}" href="/metadocuments/', post: '/destroy" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];
		DtablesUtil(tableName, columns, actions);
	});
	</script>
@endsection

@section('section_title', __('metadocuments.metadocuments'))

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

                	<table id="metadocuments-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('metadocuments_tooltip.id') }}">{{ __('metadocuments.id') }}</th>
                	        	<th title="{{ __('metadocuments_tooltip.name') }}">{{ __('metadocuments.name') }}</th>
                	            <th title="{{ __('metadocuments_tooltip.lang') }}">{{ __('metadocuments.lang') }}</th>
                                <th title="{{ __('metadocuments_tooltip.activity') }}">{{ __('metadocuments.activity') }}</th>
                	        	<th title="{{ __('metadocuments_tooltip.docType') }}">{{ __('metadocuments.docType') }}</th>
                                <th title="{{ __('metadocuments_tooltip.version') }}">{{ __('metadocuments.version') }}</th>
                	        	<th title="{{ __('metadocuments_tooltip.link_logo_left') }}">{{ __('metadocuments.link_logo_left') }}</th>
                                <th title="{{ __('metadocuments_tooltip.link_logo_right') }}">{{ __('metadocuments.link_logo_right') }}</th>
                                <th title="{{ __('metadocuments_tooltip.path_ref') }}">{{ __('metadocuments.path_ref') }}</th>
                	            <th title="{{ __('general.actions') }}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('metadocuments.add_new') }}">{{ __('metadocuments.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('metadocuments/create',['languages' => $languages, 'activities' => $activities, 'docTypes' => $docTypes])

	@endcomponent
@endsection