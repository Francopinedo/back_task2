<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('companies/'.$company_id.'/exchange_rates') }}" id="data-form" data-redirect-on-success="{{ url('companies/'.$company_id.'/exchange_rates') }}">
    	    {{ csrf_field() }}
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper">
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('exchange_rates.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <input type="hidden" name="company_id" value="{{ $company_id }}">

                <div class="md-input-wrapper">
                	<label>{{ __('exchange_rates.value') }}</label>
                	<input type="text" class="md-input" name="value" required><span class="md-input-bar"></span>
                </div>
                <span class="uk-form-help-block"> {{ __('exchange_rates.suggested') }} <span class="suggested_rate"></span></span>
                <div class="parsley-errors-list filled"><span class="parsley-required value-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('exchange_rates.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

