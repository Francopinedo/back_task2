@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'debit_credit';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'detail', name: 'detail' },
	            { data: 'amount', name: 'amount' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'signs', name: 'signs' },
	            { data: 'cost', name: 'cost' },
	            { data: 'actions', name: 'actions'}
	        ];

        var extra_buttons = [{
            text: 'IMPORT',
            action: function (e, dt, node, config) {

                var self = this;

                // inicializo acciones del boton editar
                var $switcher_ajax_create = $('#ajax_create_div'),
                    $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
                    $ajax_create_url = 'debit_credit/import';


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
			            { pre: '<a title={{__('general.edit')}} href="/debit_credit/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title={{__('general.delete')}} href="/debit_credit/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters, extra_buttons);
	});
	</script>
@endsection

@section('section_title', __('debit_credit.debit_credit'))

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

                	<table id="debit_credit-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('debit_credit_tooltip.id')}}">{{ __('debit_credit.id') }}</th>
                	        	<th title="{{ __('debit_credit_tooltip.detail')}}">{{ __('debit_credit.detail') }}</th>
                	        	<th title="{{ __('debit_credit_tooltip.amount')}}">{{ __('debit_credit.amount') }}</th>
                	        	<th title="{{ __('debit_credit_tooltip.currency')}}">{{ __('debit_credit.currency') }}</th>
                	        	<th title="{{ __('debit_credit_tooltip.signs')}}">{{ __('debit_credit.signs') }}</th>
                	        	<th title="{{ __('debit_credit_tooltip.cost')}}">{{ __('debit_credit.cost') }}</th>
                	        	<th title="{{ __('general.actions') }}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('debit_credit_tooltip.add_new')}}">{{ __('debit_credit.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('debit_credit/create', ['company' => $company, 'currencies' => $currencies])

	@endcomponent
@endsection