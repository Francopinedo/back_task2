<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('providers') }}" id="data-form" data-redirect-on-success="{{ url('providers') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('providers.name') }}</label>
                	<input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.address') }}</label>
                	<input type="text" class="md-input" name="address"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('providers.city') }}</label>
                	<select name="city_id" data-md-selectize>
                	    <option value="">{{ __('providers.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}">{{ $city->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.email_1') }}</label>
                	<input type="text" class="md-input" name="email_1"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email_1-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.email_2') }}</label>
                	<input type="text" class="md-input" name="email_2"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email_2-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.email_3') }}</label>
                	<input type="text" class="md-input" name="email_3"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email_3-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.phone_1') }}</label>
                	<input type="text" class="md-input" name="phone_1"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone_1-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.phone_2') }}</label>
                	<input type="text" class="md-input" name="phone_2"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone_2-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.phone_3') }}</label>
                	<input type="text" class="md-input" name="phone_3"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone_3-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.billing_name') }}</label>
                	<input type="text" class="md-input" name="billing_name"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.billing_address') }}</label>
                	<input type="text" class="md-input" name="billing_address"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_address-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.tax_number') }}</label>
                	<input type="text" class="md-input" name="tax_number"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required tax_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.bank_name') }}</label>
                	<input type="text" class="md-input" name="bank_name"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required bank_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.account_number') }}</label>
                	<input type="text" class="md-input" name="account_number"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required account_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.swiftcode') }}</label>
                	<input type="text" class="md-input" name="swiftcode"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required swiftcode-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('providers.aba') }}</label>
                	<input type="text" class="md-input" name="aba"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required aba-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('providers.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('providers.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('providers.industry') }}</label>
                	<select name="industry_id" data-md-selectize>
                	    <option value="">{{ __('providers.industry') }}...</option>
                	    @foreach ($industries as $industry)
                	        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required industry_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('cities.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

