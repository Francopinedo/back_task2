<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('invoice_discounts/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('invoices/rows/'.$invoicediscount->invoice_id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $invoicediscount->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('invoices.discount') }}</label>
                	<select name="discount_id" id="discount_id" data-md-selectize>
                	    <option value="">{{ __('invoices.discount') }}...</option>
                	    @foreach ($discounts as $discount)
                	        <option value="{{ $discount->id }}">{{ $discount->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required discount_id-error"></span></div>

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.name') }}</label>
                	<input type="text" class="md-input" name="name" id="name" value="{{ $invoicediscount->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.amount') }}</label>
                	<input type="text" class="md-input" name="amount" id="discountamount" onkeydown="InvoiceDiscounts.blocktheother(0);" value="{{ $invoicediscount->amount }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>


				<div class="md-input-wrapper">
					<label>{{ __('discounts.percentage') }}</label>
					<input type="text" class="md-input" id="discountpercentage" required onkeydown="InvoiceDiscounts.blocktheother(1);" value="{{$invoicediscount->percentage}}" name="percentage">
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

                <!--<div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('invoices.currency') }}</label>
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('invoices.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $invoicediscount->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>
-->
				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('invoices.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script src="{{ asset('js/invoice_discounts.js') }}"></script>
<script>  InvoiceDiscounts.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>'); </script>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
    contracts.initDiscounts();
    altair_forms.init();
</script>