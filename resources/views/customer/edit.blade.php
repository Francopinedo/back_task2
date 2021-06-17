<style>

    #edit_div.switcher_active {
        width: 40%;
    }

</style>    
	<form role="form"  action="{{ url('customers/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('customers') }}" enctype="multipart/form-data">

<div class="uk-grid" data-uk-grid-margin>
    		<li class="uk-width-medium-1-1 uk-row-first">
		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
</li>
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $customer->id }}">
    		<li class="uk-width-medium-1-3 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.name') }}</label>
                	<input type="text" class="md-input" name="name" value="{{ $customer->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.address') }}</label>
                	<input type="text" class="md-input" name="address" value="{{ $customer->address }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('customers.country') }}</label>
                	<select name="country_id" id="country_id" data-md-selectize>
                	    <option value="">{{ __('customers.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}" {{ ($country->id == $customer->country_id) ? 'selected' : '' }}>{{ $country->name }} </option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>


                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('customers.city') }}</label>
                	<select name="city_id" id="city_id" data-md-selectize>
                	    <option value="">{{ __('customers.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}" {{ ($city->id == $customer->city_id) ? 'selected' : '' }}>{{ $city->name }} ({{ $city->location_name }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.email') }}</label>
                	<input type="email" class="md-input" name="email" value="{{ $customer->email }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.phone') }}</label>
                	<input type="text" class="md-input" name="phone" value="{{ $customer->phone }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.billing_name') }}</label>
                	<input type="text" class="md-input" name="billing_name" value="{{ $customer->billing_name }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.billing_address') }}</label>
                	<input type="text" class="md-input" name="billing_address" value="{{ $customer->billing_address }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required billing_address-error"></span></div>

</li>
    		<li class="uk-width-medium-1-3 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.tax_number') }}</label>
                	<input type="text" class="md-input" name="tax_number1" value="{{ $customer->tax_number1 }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required tax_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.bank_name') }}</label>
                	<input type="text" class="md-input" name="bank_name" value="{{ $customer->bank_name }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required bank_name-error"></span></div>

				<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.account_number') }}</label>
                	<input type="text" class="md-input" name="account_number" value="{{ $customer->account_number }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required account_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.swiftcode') }}</label>
                	<input type="text" class="md-input" name="swiftcode" value="{{ $customer->swiftcode }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required swiftcode-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('customers.aba') }}</label>
                	<input type="text" class="md-input" name="aba" value="{{ $customer->aba }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required aba-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('customers.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('customers.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $customer->currency_id) ? 'selected' : '' }}>{{ $currency->code }} ({{ $currency->name }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('customers.industry') }}</label>
                	<select name="industry_id" data-md-selectize>
                	    <option value="">{{ __('customers.industry') }}...</option>
                	    @foreach ($industries as $industry)
                	        <option value="{{ $industry->id }}" {{ ($industry->id == $customer->industry_id) ? 'selected' : '' }}>{{ $industry->name }}</option>
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
                                        @if (empty($customer->logo_path) || $customer->logo_path=='')
                                            <img alt="logo" id="logo_path_img2"
                                                 src="{{ URL::to('/') }}/assets/img/avatardefault.png">

                                        @else
                                            <img src="{{ URL::to('/') .'/assets/img/customers/'. $customer->id .'/'. $customer->logo_path }}"
                                                 alt="" id="logo_path_img2">
                                        @endif
                                    </div>  
                                                                   <a class="uk-form-file md-btn" id="upload_widget_opener">Upload image
                                        <input type="file" class="uk-form-file md-btn" id="logo_path" name="logo_path" accept="image/*"
                                               onchange="document.getElementById('logo_path_img2').src = window.URL.createObjectURL(this.files[0])"/></a>
                                </div>  
        <div class="parsley-errors-list filled"><span class="parsley-required logo_path-error"></span></div>

</li>


    		<li class="uk-width-medium-1-1 uk-row-first">

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('customers.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </li>

</div>
    	</form>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();


     var form = $('#data-form-edit');
            $('#update-btn').on('click', function (e) {
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
