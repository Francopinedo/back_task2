<style>

    #create_div.switcher_active {
        width: 40%;
    }

</style>
    	<form role="form" method="POST" action="{{ url('admin_companies') }}" id="data-form" data-redirect-on-success="{{ url('admin_companies') }}">

<div class="uk-grid" data-uk-grid-margin>

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	    {{ csrf_field() }}

    	    <input type="hidden" class="md-input" name="user_id" value="{{ Auth::id() }}"><span class="md-input-bar"></span>

    		<li class="uk-width-medium-1-2 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('companies.name') }}</label>
                	<input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('companies.address') }}</label>
                	<input type="text" class="md-input" name="address"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span></div>

               <!-- <div class="md-input-wrapper">
                	<select name="city_id" data-md-selectize>
                	    <option value="">{{ __('companies.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}">{{ $city->name }} ({{ $city->location_name }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>
-->
                <div class="md-input-wrapper">
                	<label>{{ __('companies.email') }}</label>
                	<input type="email" class="md-input" name="email"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('companies.phone') }}</label>
                	<input type="text" class="md-input" name="phone"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('companies.billing_name') }}</label>
                	<input type="text" class="md-input" name="billing_name"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('companies.billing_address') }}</label>
                	<input type="text" class="md-input" name="billing_address"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_address-error"></span></div>

				</li>
			    		<li class="uk-width-medium-1-2 uk-row-first">
		

                <div class="md-input-wrapper">
                	<label>{{ __('companies.tax_number') }}</label>
                	<input type="text" class="md-input" name="tax_number1"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required tax_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('companies.bank_name') }}</label>
                	<input type="text" class="md-input" name="bank_name"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required bank_name-error"></span></div>

				<div class="md-input-wrapper">
                	<label>{{ __('companies.account_number') }}</label>
                	<input type="text" class="md-input" name="account_number"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required account_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('companies.swiftcode') }}</label>
                	<input type="text" class="md-input" name="swiftcode"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required swiftcode-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('companies.aba') }}</label>
                	<input type="text" class="md-input" name="aba"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required aba-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('companies.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->code }} ({{ $currency->name }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="industry_id" data-md-selectize>
                	    <option value="">{{ __('companies.industry') }}...</option>
                	    @foreach ($industries as $industry)
                	        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required industry_id-error"></span></div>

				

            </li>
			  <li class="uk-width-medium-1-1 uk-row-first">
						<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('companies.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>
			</li>


</div>
    	</form>

