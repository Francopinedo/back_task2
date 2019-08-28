@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'holidays';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'date', name: 'date' },
	            { data: 'country_name', name: 'country_name' },
                { data: 'description', name: 'description' },
	            { data: 'added_by', name: 'added_by' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a href="/holidays/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/holidays/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, '?company_id={{ $company->id }}');
	});

    $('#reload').on('click', function(e){
        e.preventDefault();
        if (window.confirm("{{__('holidays.are_you_sure')}}")) {

            var parametros = {
                "company_id" : {{ $company->id }}
            };

            $.ajax({
                    data:  parametros,
                    url:   API_PATH + 'holidays/reload',
                    type:  'post',
                    success:  function (response) {
                        location.reload();
                    }
            });
        }
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

                	<table id="holidays-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('holidays.id') }}</th>
                	        	<th>{{ __('holidays.date') }}</th>
                	        	<th>{{ __('holidays.country') }}</th>
                                <th>{{ __('holidays.description') }}</th>
                	        	<th>{{ __('holidays.added_by') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
							<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="reload">{{ __('holidays.reload') }}</a>
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('holidays.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('holiday/create', ['countries' => $countries, 'company' => $company])

	@endcomponent
@endsection