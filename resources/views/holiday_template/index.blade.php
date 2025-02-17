@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'holidays_templates';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'date', name: 'date' },
	            { data: 'country_name', name: 'country_name' },
	            { data: 'description', name: 'description' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title="{{__('general.edit')}}" href="/holidays_templates/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title="{{__('general.delete')}}" href="/holidays_templates/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions);


        $('#reload').on('click', function(e){
            e.preventDefault();
            if (window.confirm("{{__('header.elements_reload')}}")) {
                var PATH = '<?php echo e(env('APP_URL')); ?>';

                console.log(PATH);
                $.ajax({
                    url:   PATH + '/holidays_templates/reload',
                    type:  'get',
                    success:  function (response) {
                        location.reload();
                    }
                });
            }
        });



    });
	</script>
@endsection

@section('section_title', __('holidays.holidays'))

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

                	<table id="holidays_templates-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('holidays_tooltip.id')}}">{{ __('holidays.id') }}</th>
                	        	<th title="{{__('holidays_tooltip.date')}}">{{ __('holidays.date') }}</th>
                	        	<th title="{{__('holidays_tooltip.country')}}">{{ __('holidays.country') }}</th>
                	        	<th title="{{__('holidays_tooltip.description')}}">{{ __('holidays.description') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="reload" title="{{ __('holidays.reload') }}">{{ __('holidays.reload') }}</a>

                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('holidays.add_new') }}">{{ __('holidays.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('holiday_template/create', ['countries' => $countries])

	@endcomponent
@endsection
