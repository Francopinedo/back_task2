<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('cities_template/update') }}"
              id="data-form-edit" data-redirect-on-success="{{ url('cities_template') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $city->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('cities.name') }}</label>
                	<input type="text" class="md-input" name="name" value="{{ $city->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('cities.location') }}</label>
                	<input type="text" class="md-input" name="location_name" value="{{ $city->location_name }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required location_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('cities.timezone') }}</label>
                	<input type="text" class="md-input" name="timezone" value="{{ $city->timezone }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required timezone-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('cities.country') }}</label>
                	<select name="country_id" data-md-selectize>
                	    <option value="">{{ __('cities.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}" {{ ($country->id == $city->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('cities.update') }}</a>
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