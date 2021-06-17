@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')

    <script>
	$(function() {
		var tableName = 'countries';
		var columns = [
			            { data: 'id', name: 'id', visible: false },
			            { data: 'name', name: 'name' },
			            { data: 'code', name: 'code' },
			            { data: 'language_name', name: 'language_name' },
			            { data: 'currency_name', name: 'currency_name' },
			            { data: 'actions', name: 'actions'}
			        ];

		var actions = [
			            { pre: '<a title="{{__('general.edit')}}" href="/countries/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title="{{__('general.delete')}}" href="/countries/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions);
	});


     $('#reload').on('click', function (e) {
                  e.preventDefault();
                UIkit.modal.confirm("{{__('header.elements_reload')}}", function () {
                   
          

            $.ajax({

                url:   API_PATH + 'countries/reload',
                type:  'post',
                success:  function (response) {
                    location.reload();
                }
            });

                }, {
                    labels: {
                        'Ok': 'Ok'
                    }
                });
        });



	</script>
@endsection

@section('section_title', __('countries.countries'))

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

                	<table id="countries-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('countries_tooltip.id')}}">{{ __('countries.id') }}</th>
                	        	<th title="{{ __('countries_tooltip.name')}}">{{ __('countries.name') }}</th>
                	        	<th title="{{ __('countries_tooltip.code')}}">{{ __('countries.code') }}</th>
                	        	<th title="{{ __('countries_tooltip.language')}}">{{ __('countries.language') }}</th>
                	        	<th title="{{ __('countries_tooltip.currency')}}">{{ __('countries.currency') }}</th>
                	            <th title="{{ __('general.actions') }}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="reload')}}" title="{{ __('holidays.reload') }}">{{ __('holidays.reload') }}</a>

                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('countries_tooltip.add_new')}}">{{ __('countries.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('country/create', ['languages' => $languages, 'currencies' => $currencies])

	@endcomponent
@endsection
