@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')

	<script>
	$(function() {
		var tableName = 'cities';
		var urlParameters= '?company_id={{$company->id}}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'name', name: 'name' },
	            { data: 'location_name', name: 'location_name' },
	            { data: 'country_name', name: 'country_name' },
	            { data: 'timezone', name: 'timezone' },
	            { data: 'actions', name: 'actions'}
	        ];

 var extra_buttons = [{
            text: 'IMPORT',
            action: function (e, dt, node, config) {

                var self = this;

                // inicializo acciones del boton editar
                var $switcher_ajax_create = $('#ajax_create_div'),
                    $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
                    $ajax_create_url = 'cities/import';


                e.preventDefault();

                $switcher_ajax_create_toggle.show();
                $('#ajax_create_div').addClass('switcher_active');
                $('#ajax_create_div').css('position', 'absolute');
                $.ajax({
                    url: $ajax_create_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function(data){
                        $('.ajax_create_div').html(data.view);
                    }
                );


                $switcher_ajax_create_toggle.click(function (e) {
                    e.preventDefault();
                    $switcher_ajax_create.toggleClass('switcher_active');
                    //  $('#ajax_create_div').css('position','relative');
                });

            }
        }];

		var actions = [
			            { pre: '<a title={{__('general.edit')}} href="/cities/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title={{__('general.delete')}} href="/cities/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters,extra_buttons);
	});



    $('#reload').on('click', function(e){


         e.preventDefault();
                UIkit.modal.confirm("{{__('header.elements_reload')}}", function () {
                         var parametros = {
                "company_id" : {{ $company->id }}
            };

            $.ajax({
                data:  parametros,
                url:   API_PATH + 'cities/reload',
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

@section('section_title', __('cities.cities'))

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

                	<table id="cities-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('cities_tooltip.id')}}">{{ __('cities.id') }}</th>
                	        	<th title="{{__('cities_tooltip.name')}}">{{ __('cities.name') }}</th>
                	        	<th title="{{__('cities_tooltip.location')}}">{{ __('cities.location') }}</th>
                	        	<th title="{{__('cities_tooltip.country')}}">{{ __('cities.country') }}</th>
                	        	<th title="{{__('cities_tooltip.timezone')}}">{{ __('cities.timezone') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="reload" title="{{ __('holidays.reload') }}">{{ __('holidays.reload') }}</a>
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('cities.add_new') }}">{{ __('cities.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('city/create', ['countries' => $countries, 'company'=>$company])

	@endcomponent
@endsection
