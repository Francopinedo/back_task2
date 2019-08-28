<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('admin_companies/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('admin_companies') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.name') }}</label>
                	<input type="text" class="md-input" name="name" value="{{ $company->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.address') }}</label>
                	<input type="text" class="md-input" name="address" value="{{ $company->address }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<select name="city_id" data-md-selectize>
                	    <option value="">{{ __('companies.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}" {{ ($city->id == $company->city_id) ? 'selected' : '' }}>{{ $city->name }} ({{ $city->location_name }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.email') }}</label>
                	<input type="email" class="md-input" name="email" value="{{ $company->email }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.phone') }}</label>
                	<input type="text" class="md-input" name="phone" value="{{ $company->phone }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.billing_name') }}</label>
                	<input type="text" class="md-input" name="billing_name" value="{{ $company->billing_name }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.billing_address') }}</label>
                	<input type="text" class="md-input" name="billing_address" value="{{ $company->billing_address }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_address-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.tax_number') }}</label>
                	<input type="text" class="md-input" name="tax_number1" value="{{ $company->tax_number1 }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required tax_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.bank_name') }}</label>
                	<input type="text" class="md-input" name="bank_name" value="{{ $company->bank_name }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required bank_name-error"></span></div>

				<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.account_number') }}</label>
                	<input type="text" class="md-input" name="account_number" value="{{ $company->account_number }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required account_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.swiftcode') }}</label>
                	<input type="text" class="md-input" name="swiftcode" value="{{ $company->swiftcode }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required swiftcode-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('companies.aba') }}</label>
                	<input type="text" class="md-input" name="aba" value="{{ $company->aba }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required aba-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('companies.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $company->currency_id) ? 'selected' : '' }}>{{ $currency->code }} ({{ $currency->name }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<select name="industry_id" data-md-selectize>
                	    <option value="">{{ __('companies.industry') }}...</option>
                	    @foreach ($industries as $industry)
                	        <option value="{{ $industry->id }}" {{ ($industry->id == $company->industry_id) ? 'selected' : '' }}>{{ $industry->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required industry_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('companies.update') }}</a>
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