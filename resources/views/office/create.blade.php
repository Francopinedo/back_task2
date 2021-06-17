<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('offices') }}" id="data-form" data-redirect-on-success="{{ url('offices') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper">
                	<label>{{ __('offices_tooltip.title') }}</label>
                	<input type="text" class="md-input" name="title" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

               	<div class="md-input-wrapper md-input-select">
               		<label>{{ __('offices_tooltip.city') }}</label>
                	<select name="city_id" data-md-selectize>
                	    <option value="">{{ __('offices.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}">{{ $city->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('offices_tooltip.workinghours_from') }}</label>
                	<input type="text" class="md-input" name="workinghours_from" data-uk-timepicker><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workinghours_from-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('offices_tooltip.workinghours_to') }}</label>
                	<input type="text" class="md-input" name="workinghours_to" data-uk-timepicker><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workinghours_to-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('offices_tooltip.hours_by_day') }}</label>
                	<input type="number" min="0" max="24" class="md-input" name="hours_by_day"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required hours_by_day-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('offices_tooltip.effective_workinghours') }}</label>
                	<input type="number" min="0" max="24" class="md-input" name="effective_workinghours"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required effective_workinghours-error"></span></div>


				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('offices.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

