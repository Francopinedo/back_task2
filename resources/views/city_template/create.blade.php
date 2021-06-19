<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form class="uk-form uk-form-stacked" role="form" method="POST" action="{{ url('cities_template') }}" id="data-form" data-redirect-on-success="{{ url('cities_template') }}">
    	    {{ csrf_field() }}
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('cities.name') }}</label>
                	<input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('cities.location') }}</label>
                	<input type="text" class="md-input" name="location_name"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required location_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('cities_tooltip.timezone') }}</label>
                	<input type="text" class="md-input" name="timezone"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required timezone-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('cities.country') }}</label>
                	<select name="country_id" data-md-selectize>
                	    <option value="">{{ __('cities.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}">{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('cities.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

