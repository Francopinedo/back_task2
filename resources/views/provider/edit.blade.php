<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('providers/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('providers') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $provider->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.name') }}</label>
                	<input type="text" class="md-input" name="name" value="{{ $provider->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.address') }}</label>
                	<input type="text" class="md-input" name="address" value="{{ $provider->address }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('providers.city') }}</label>
                	<select name="city_id" data-md-selectize>
                	    <option value="">{{ __('providers.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}" {{ ($city->id == $provider->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.email_1') }}</label>
                	<input type="text" class="md-input" name="email_1" value="{{ $provider->email_1 }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email_1-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.email_2') }}</label>
                	<input type="text" class="md-input" name="email_2" value="{{ $provider->email_2 }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email_2-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.email_3') }}</label>
                	<input type="text" class="md-input" name="email_3" value="{{ $provider->email_3 }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email_3-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.phone_1') }}</label>
                	<input type="text" class="md-input" name="phone_1" value="{{ $provider->phone_1 }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone_1-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.phone_2') }}</label>
                	<input type="text" class="md-input" name="phone_2" value="{{ $provider->phone_2 }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone_2-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.phone_3') }}</label>
                	<input type="text" class="md-input" name="phone_3" value="{{ $provider->phone_3 }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone_3-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.billing_name') }}</label>
                	<input type="text" class="md-input" name="billing_name" value="{{ $provider->billing_name }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.billing_address') }}</label>
                	<input type="text" class="md-input" name="billing_address" value="{{ $provider->billing_address }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_address-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.tax_number') }}</label>
                	<input type="text" class="md-input" name="tax_number" value="{{ $provider->tax_number }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required tax_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.bank_name') }}</label>
                	<input type="text" class="md-input" name="bank_name" value="{{ $provider->bank_name }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required tax_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.account_number') }}</label>
                	<input type="text" class="md-input" name="account_number" value="{{ $provider->account_number }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required account_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.swiftcode') }}</label>
                	<input type="text" class="md-input" name="swiftcode" value="{{ $provider->swiftcode }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required swiftcode-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('providers.aba') }}</label>
                	<input type="text" class="md-input" name="aba" value="{{ $provider->aba }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required aba-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('providers.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('providers.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($city->id == $provider->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('providers.industry') }}</label>
                	<select name="industry_id" data-md-selectize>
                	    <option value="">{{ __('providers.industry') }}...</option>
                	    @foreach ($industries as $industry)
                	        <option value="{{ $industry->id }}" {{ ($city->id == $provider->industry_id) ? 'selected' : '' }}>{{ $industry->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required industry_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('providers.update') }}</a>
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
</script>