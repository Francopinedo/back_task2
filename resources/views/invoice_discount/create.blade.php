<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('invoice_discounts') }}" id="data-form-ajax_create" data-redirect-on-success="{{ url('invoices/rows/'.$invoice->id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('invoices.discount') }}</label>
                	<select name="discount_id" id="discount_id" data-md-selectize>
                	    <option value="">{{ __('invoices.discount') }}...</option>
                	    @foreach ($discounts as $discount)
                	        <option value="{{ $discount->id }}">{{ $discount->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required discount_id-error"></span></div>

    			<div class="md-input-wrapper">
                	<label>{{ __('invoices.name') }}</label>
                	<input type="text" class="md-input" name="name" id="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('invoices.amount') }}</label>
                	<input type="text" class="md-input" name="amount" id="discountamount2"  onkeydown="InvoiceDiscounts.blocktheother(0);" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

				<div class="md-input-wrapper">
					<label>{{ __('discounts.percentage') }}</label>
					<input type="text" class="md-input" id="discountpercentage2" name="percentage"  required onkeydown="InvoiceDiscounts.blocktheother(1);"><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required percentage-error"></span></div>



				<div class="md-input-wrapper">
					<input type="hidden" class="md-input" id="currency_id" value="{{$invoice->currency_id}}" name="currency_id">
					<label>{{ __('invoices.currency') }}</label>
					@foreach ($currencies as $currency)
						@if($currency->id == $invoice->currency_id)
							<input type="text" readonly class="md-input"  value="{{$currency->name }}"/>
						@endif
					@endforeach
				</div>

               <!-- <div class="md-input-wrapper md-input-select">
                	<label>{{ __('invoices.currency') }}</label>
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('invoices.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>
-->
				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="ajax_create-btn">{{ __('invoices.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-ajax_create-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script src="{{ asset('js/invoice_discounts.js') }}"></script>
<script>  InvoiceDiscounts.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>'); </script>

<script type="text/javascript">

	$('#cancel-ajax_create-btn').on('click', function(e){
    	e.preventDefault();
    	$('#ajax_create_div_toggle').hide();
    	$('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();
    contracts.initDiscounts();
    altair_forms.init();
</script>