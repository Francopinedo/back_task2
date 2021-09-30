<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('countries/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('countries') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $country->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('countries.name') }}</label>
                	<input type="text" class="md-input" name="name" value="{{ $country->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>


				<div class="md-input-wrapper md-input-filled">
					<label>{{ __('countries.code') }}</label>
					<input type="text" class="md-input" name="code" value="{{ $country->code }}" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required code-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('countries.mask_phone') }}</label>
                    <input type="text" class="md-input" name="mask_phone" value="{{$country->mask_phone}}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required mask_phone-error"></span></div>


				<div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('countries.language') }}</label>
                	<select name="language_id" data-md-selectize>
                	    <option value="">{{ __('countries.language') }}...</option>
                	    @foreach ($languages as $language)
                	        <option value="{{ $language->id }}" {{ ($language->id == $country->language_id) ? 'selected' : '' }}>{{ $language->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required language_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('countries.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('countries.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $country->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('countries.update') }}</a>
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