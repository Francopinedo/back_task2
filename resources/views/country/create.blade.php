<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('countries') }}" id="data-form" data-redirect-on-success="{{ url('countries') }}">
    	    {{ csrf_field() }}
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('countries.name') }}</label>
                	<input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

				<div class="md-input-wrapper">
					<label>{{ __('countries.code') }}</label>
					<input type="text" class="md-input" name="code" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required code-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('countries.language') }}</label>
                	<select name="language_id" data-md-selectize>
                	    <option value="">{{ __('countries.language') }}...</option>
                	    @foreach ($languages as $language)
                	        <option value="{{ $language->id }}">{{ $language->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required language_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('countries.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('countries.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('countries.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

