<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('absence_types_template') }}" id="data-form"
              data-redirect-on-success="{{ url('absence_types_template') }}">
    	    {{ csrf_field() }}
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('absence_types.title') }}</label>
                	<input type="text" class="md-input" name="title" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('absence_types.days') }}</label>
                	<input type="text" class="md-input" name="days"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required days-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('absence_types.country') }}</label>
                	<select name="country_id"  id="country_id" data-md-selectize>
                	    <option value="">{{ __('absence_types.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}">{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.city') }}</label>
                    <select name="city_id" id="city_id" data-md-selectize>
                        <option value="">{{ __('users.city') }}...</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span>
                </div>


				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('absence_types.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script src="{{ asset('js/absenceType.js') }}"></script>
<script type="text/javascript">

    AbsenceType.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
</script>
