<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('absence_types_template/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('absence_types_template') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $absenceType->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('absence_types.title') }}</label>
                	<input type="text" class="md-input" name="title" value="{{ $absenceType->title }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('absence_types.days') }}</label>
                	<input type="text" class="md-input" name="days" value="{{ $absenceType->days }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required days-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('absence_types.country') }}</label>
                	<select name="country_id" id="country_id2" data-md-selectize>
                	    <option value="">{{ __('absence_types.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}" {{ ($country->id == $absenceType->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.city') }}</label>
                    <select name="city_id" id="city_id2" data-md-selectize>
                        <option value="">{{ __('users.city') }}...</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ ($city->id == $absenceType->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>



                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('absence_types.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>


<script src="{{ asset('js/absenceType.js') }}"></script>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });
    AbsenceType.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
    tableActions.initEditForm();
</script>