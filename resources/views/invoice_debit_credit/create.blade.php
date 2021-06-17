<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('invoice_debit_credit') }}" id="data-form-ajax_create" data-redirect-on-success="{{ url('invoices/rows/'.$invoice->id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">


    			    <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.signs') }}</label>
                    <select name="signs" id="signs" data-md-selectize>
                        <option value="">{{ __('projects.signs') }}</option>
                        
                            <option value="+">+</option>
                       <option value="-">-</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required signs-error"></span></div>

    			<div class="md-input-wrapper">
                	<label>{{ __('invoices.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('invoices.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="debit_creditcost" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

				<div class="md-input-wrapper">
					<label>{{ __('invoices.amount') }}</label>
					<input type="text" class="md-input" name="amount" id="debit_creditamount" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>



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
                </div>-->
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="ajax_create-btn">{{ __('invoices.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-ajax_create-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script type="text/javascript">
	$('#cancel-ajax_create-btn').on('click', function(e){
    	e.preventDefault();
    	$('#ajax_create_div_toggle').hide();
    	$('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();
    //contracts.initdebit_credits();
    altair_forms.init();
</script>