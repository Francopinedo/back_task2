@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'exchange_rates';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'value', name: 'value' },
                {data: 'currency_unit', name: 'currency_unit'},
	            { data: 'currency_name', name: 'currency_name' },
		{ data: 'quotation_url', name: 'quotation_url' },
			{ data: 'quotation_date', name: 'quotation_date' },
	            { data: 'actions', name: 'actions'}
	        ];

             var extra_buttons = [{
            text: 'IMPORT',
            action: function (e, dt, node, config) {

                var self = this;

                // inicializo acciones del boton editar
                var $switcher_ajax_create = $('#ajax_create_div'),
                    $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
                    $ajax_create_url = 'exchange_rates/import';


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
			            { pre: '<a title={{__('general.edit')}} href="/exchange_rates/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title={{__('general.delete')}} href="/exchange_rates/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters,extra_buttons);
	});
	</script>
@endsection

@section('section_title', __('exchange_rates.exchange_rates'))

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

                	<table id="exchange_rates-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('exchange_rates_tooltip.id')}}">{{ __('exchange_rates.id') }}</th>
                	        	<th title="{{__('exchange_rates_tooltip.value')}}">{{ __('exchange_rates.value') }}</th>
                                <th title="{{ __('exchange_rates_tooltip.currency_code') }}">{{ __('exchange_rates.currency_code') }}</th>
                	        	<th title="{{__('exchange_rates_tooltip.currency')}}">{{ __('exchange_rates.currency') }}</th>
                                <th title="{{__('exchange_rates_tooltip.quotation_url')}}">{{ __('exchange_rates.quotation_url') }}</th>
                                <th title="{{__('exchange_rates_tooltip.quotation_date')}}">{{ __('exchange_rates.quotation_date') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('exchange_rates.add_new') }}">{{ __('exchange_rates.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('exchange_rate/create', ['company' => $company, 'currencies' => $currencies])

	@endcomponent
@endsection
