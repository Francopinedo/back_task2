@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'absence_types';
        var urlParameters= '?company_id={{$company->id}}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'title', name: 'title' },
	            { data: 'days', name: 'days' },
	            { data: 'country_name', name: 'country_name' },
	            { data: 'city_name', name: 'city_name' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a href="/absence_types/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/absence_types/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});

    $('#reload').on('click', function(e){
        e.preventDefault();
        if (window.confirm("{{__('holidays.are_you_sure')}}")) {

            var parametros = {
                "company_id" : {{ $company->id }}
            };

            $.ajax({
                data:  parametros,
                url:   API_PATH + 'absence_types/reload',
                type:  'post',
                success:  function (response) {
                    location.reload();
                }
            });
        }
    });


	</script>
@endsection

@section('section_title', __('absence_types.absence_types'))

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

                	<table id="absence_types-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('absence_types.id') }}</th>
                	        	<th>{{ __('absence_types.title') }}</th>
                	        	<th>{{ __('absence_types.days') }}</th>
                	        	<th>{{ __('absence_types.country') }}</th>
                	        	<th>{{ __('absence_types.city') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
							<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="reload">{{ __('holidays.reload') }}</a>

							<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('absence_types.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('absence_type/create', ['countries' => $countries, 'company'=>$company])

	@endcomponent
@endsection