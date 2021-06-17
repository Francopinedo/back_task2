<style>

    #create_div.switcher_active {
        width: 40%;
    }

</style>
    	<form role="form"  action="{{ url('customers') }}" id="data-form" data-redirect-on-success="{{ url('customers') }}">

<div class="uk-grid" data-uk-grid-margin>
    		<li class="uk-width-medium-1-1 uk-row-first">
		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>
</li>
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">

    	    <input type="hidden" class="md-input" name="user_id" value="{{ Auth::id() }}">

    		<li class="uk-width-medium-1-3 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('customers.name') }}</label>
                	<input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('customers.address') }}</label>
                	<input type="text" class="md-input" name="address"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span></div>



                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('customers.country') }}</label>
                	<select name="country_id" id="country_id" data-md-selectize>
                	    <option value="">{{ __('customers.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}" >{{ $country->name }} </option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>



                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('customers.city') }}</label>
                	<select name="city_id" id="city_id" data-md-selectize>
                	    <option value="">{{ __('customers.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}">{{ $city->name }} ({{ $city->location_name }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('customers.email') }}</label>
                	<input type="email" class="md-input" name="email"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('customers.phone') }}</label>
                	<input type="text" class="md-input" name="phone"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('customers.billing_name') }}</label>
                	<input type="text" class="md-input" name="billing_name"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('customers.billing_address') }}</label>
                	<input type="text" class="md-input" name="billing_address"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_address-error"></span></div>

</li>
    		<li class="uk-width-medium-1-3 uk-row-first">


                <div class="md-input-wrapper">
                	<label>{{ __('customers.tax_number') }}</label>
                	<input type="text" class="md-input" name="tax_number1"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required tax_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('customers.bank_name') }}</label>
                	<input type="text" class="md-input" name="bank_name"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required bank_name-error"></span></div>

				<div class="md-input-wrapper">
                	<label>{{ __('customers.account_number') }}</label>
                	<input type="text" class="md-input" name="account_number"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required account_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('customers.swiftcode') }}</label>
                	<input type="text" class="md-input" name="swiftcode"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required swiftcode-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('customers.aba') }}</label>
                	<input type="text" class="md-input" name="aba"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required aba-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('customers.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('customers.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->code }} ({{ $currency->name }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('customers.industry') }}</label>
                	<select name="industry_id" data-md-selectize>
                	    <option value="">{{ __('customers.industry') }}...</option>
                	    @foreach ($industries as $industry)
                	        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required industry_id-error"></span></div>
		


			</li>


            <li class="uk-width-medium-1-3 uk-row-first">



        <div class="md-input-wrapper md-input-select">
        <label>{{ __('customers.logo_path') }}</label>    
<br/>
                <div class="thumbnail">

                                            <img alt="logo" id="logo_path_img"
                                                 src="{{ URL::to('/') }}/assets/img/avatardefault.png">

                                    
                                    </div>  
                               
                                    <a class="uk-form-file md-btn" id="upload_widget_opener">Upload image
                                        <input type="file"
                                               id="logo_path" name="logo_path" accept="image/*" onchange="document.getElementById('logo_path_img').src = window.URL.createObjectURL(this.files[0])"
                                               >
                                    </a>
                                </div>  
            </li>

    		<li class="uk-width-medium-1-1 uk-row-first">
				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('customers.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>


		</li>
		</div>
    	</form>

<script>
  var form = $('#data-form');
            $('#add-btn').on('click', function (e) {
                form.submit();
            });

            $(form).submit(function (event) {
                var formdata = new FormData(form.get(0));
                event.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formdata,
                    dataType: 'json',
                    processData: false, //For posting uploaded files we add this
                    contentType: false, //For posting uploaded files we add this
                    success: function (json) {
                        window.location.replace(form.data('redirect-on-success'));
                    },
                    error: function (json) {
                        if (json.status === 422) {
                            var errors = json.responseJSON;
                            $.each(json.responseJSON, function (key, value) {
                                $('.' + key + '-error').html(value);
                            });
                        } else {
                            // Error
                        }
                    }
                });
            });
</script>


