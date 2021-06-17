@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'services';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'detail', name: 'detail',tooltip:'TEST'},
	            { data: 'amount', name: 'amount' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'reimbursable', name: 'reimbursable' },
	            { data: 'cost', name: 'cost' },
	            { data: 'cc_name', name: 'cc_name' },
	            { data: 'actions', name: 'actions'}
	        ];

        var extra_buttons = [{
            text: 'IMPORT',
            action: function (e, dt, node, config) {

                var self = this;

                // inicializo acciones del boton editar
                var $switcher_ajax_create = $('#ajax_create_div'),
                    $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
                    $ajax_create_url = 'services/import';


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
			            { pre: '<a title={{__('general.edit')}} href="/services/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a title={{__('general.delete')}} href="/services/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters, extra_buttons);
	});

    /*$('#services-table thead th').each(function () {
                            var sTitle;
                            var nTds = $(this);
                            var columnTitle= $(nTds).text();

                             this.setAttribute('title', columnTitle);
                        });*/

	</script>
@endsection

@section('section_title', __('services.services'))

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

                	<table id="services-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('services_tooltip.id')}}">{{ __('services.id') }}</th>
                	        	<th title="{{ __('services_tooltip.detail')}}">{{ __('services.detail') }}</th>
                	        	<th title="{{ __('services_tooltip.amount')}}">{{ __('services.amount') }}</th>
                	        	<th title="{{ __('services_tooltip.currency')}}">{{ __('services.currency') }}</th>
                	        	<th title="{{ __('services_tooltip.reimbursable')}}">{{ __('services.reimbursable') }}</th>
                	        	<th title="{{ __('services_tooltip.cost')}}">{{ __('services.cost') }}</th>
                	        	<th title="{{ __('services_tooltip.cost_currency')}}">{{ __('services.cost_currency') }}</th>
                	        	<th title="{{ __('general.actions') }}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new')}}" title="{{ __('services.add_new') }}">{{ __('services.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('service/create', ['company' => $company, 'currencies' => $currencies])

	@endcomponent
@endsection