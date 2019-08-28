@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'providers';
		var urlParameters = '?company_id={{ $company->id }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'name', name: 'name' },
	            { data: 'address', name: 'address' },
	            { data: 'city_name', name: 'city_name' },
	            { data: 'email_1', name: 'email_1' },
	            { data: 'email_2', name: 'email_2' },
	            { data: 'email_3', name: 'email_3' },
	            { data: 'phone_1', name: 'phone_1' },
	            { data: 'phone_2', name: 'phone_2' },
	            { data: 'phone_3', name: 'phone_3' },
	            { data: 'billing_name', name: 'billing_name' },
	            { data: 'billing_address', name: 'billing_address' },
	            { data: 'tax_number', name: 'tax_number' },
	            { data: 'bank_name', name: 'bank_name' },
	            { data: 'account_number', name: 'account_number' },
	            { data: 'swiftcode', name: 'swiftcode' },
	            { data: 'aba', name: 'aba' },
	            { data: 'industry_name', name: 'industry_name' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'actions', name: 'actions'}
	        ];
        var extra_buttons = [{
            text: 'IMPORT',
            action: function (e, dt, node, config) {

                var self = this;

                // inicializo acciones del boton editar
                var $switcher_ajax_create = $('#ajax_create_div'),
                    $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
                    $ajax_create_url = 'providers/import';


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
			            { pre: '<a href="/providers/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
			            { pre: '<a href="/providers/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters, extra_buttons);
	});
	</script>
@endsection

@section('section_title', __('providers.providers'))

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

                	<table id="providers-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('providers.id') }}</th>
                	        	<th>{{ __('providers.name') }}</th>
                	        	<th>{{ __('providers.address') }}</th>
                	        	<th>{{ __('providers.city') }}</th>
                	        	<th>{{ __('providers.email_1') }}</th>
                	        	<th>{{ __('providers.email_2') }}</th>
                	        	<th>{{ __('providers.email_3') }}</th>
                	        	<th>{{ __('providers.phone_1') }}</th>
                	        	<th>{{ __('providers.phone_2') }}</th>
                	        	<th>{{ __('providers.phone_3') }}</th>
                	        	<th>{{ __('providers.billing_name') }}</th>
                	        	<th>{{ __('providers.billing_address') }}</th>
                	        	<th>{{ __('providers.tax_number') }}</th>
                	        	<th>{{ __('providers.bank_name') }}</th>
                	        	<th>{{ __('providers.account_number') }}</th>
                	        	<th>{{ __('providers.swiftcode') }}</th>
                	        	<th>{{ __('providers.aba') }}</th>
                	        	<th>{{ __('providers.industry') }}</th>
                	        	<th>{{ __('providers.currency') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('providers.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('provider/create', [
						'countries' => $countries,
						'cities' => $cities,
						'currencies' => $currencies,
						'industries' => $industries,
						'company' => $company]
			)

	@endcomponent
@endsection