<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('companies/'.$company_id.'/exchange_rates/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('companies/'.$company_id.'/exchange_rates') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $exchangeRate->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                	<select name="currency_id" id="currency_id_on_edit" data-md-selectize >
                	    <option value="">{{ __('exchange_rates.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $exchangeRate->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <input type="hidden" name="company_id" value="{{ $company_id }}">

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('exchange_rates.value') }}</label>
                	<input type="text" class="md-input" name="value" value="{{ $exchangeRate->value }}"><span class="md-input-bar"></span>
                </div>
                <span class="uk-form-help-block"> {{ __('exchange_rates.suggested') }} <span class="suggested_rate"></span></span>
                <div class="parsley-errors-list filled"><span class="parsley-required value-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('exchange_rates.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
    $(document).ready(function () {
    	console.log(0);
		exchangeRates.initOnEdit();
	});
</script>