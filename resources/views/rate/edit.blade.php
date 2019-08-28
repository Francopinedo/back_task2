<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('rates/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('rates') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $rate->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('rates.country') }}</label>
                	<select name="country_id" id="country_id2" data-md-selectize>
                	    <option value="">{{ __('rates.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}" {{ ($country->id == $rate->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="md-input-wrapper md-input-filled md-input-select">
					<label>{{ __('rates.city') }}</label>
                	<select name="city_id" id="city_id2"  data-md-selectize>
                	    <option value="">{{ __('rates.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}" {{ ($city->id == $rate->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.office') }}</label>
					<select name="office_id"  id="office_id2"  required data-md-selectize>
						<option value="">{{ __('rates.office') }}...</option>
						@foreach ($offices as $office)
							<option value="{{ $office->id }}" {{ ($office->id == $rate->office_id) ? 'selected' : '' }}>{{ $office->title }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>


                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('rates.project_role') }}</label>
                	<select name="project_role_id" data-md-selectize>
                	    <option value="">{{ __('rates.project_role') }}...</option>
                	    @foreach ($project_roles as $project_role)
                	        <option value="{{ $project_role->id }}" {{ ($project_role->id == $rate->project_role_id) ? 'selected' : '' }}>{{ $project_role->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('rates.seniority') }}</label>
                	<select name="seniority_id" data-md-selectize>
                	    <option value="">{{ __('rates.seniority') }}...</option>
                	    @foreach ($seniorities as $seniority)
                	        <option value="{{ $seniority->id }}" {{ ($seniority->id == $rate->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('rates.title') }}</label>
                	<input type="text" class="md-input" name="title" value="{{ $rate->title }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('rates.value') }}</label>
                	<input type="text" class="md-input" name="value" value="{{ $rate->value }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required value-error"></span></div>

               	<div class="md-input-wrapper md-input-filled md-input-select">
               		<label>{{ __('rates.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('rates.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $rate->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('rates.workplace') }}</label>
                	<select name="workplace" data-md-selectize>
                	    <option value="">{{ __('rates.workplace') }}...</option>
                	    <option value="onsite" {{ ($rate->workplace == 'onsite') ? 'selected' : '' }}>On Site</option>
                	    <option value="offshore" {{ ($rate->workplace == 'offshore') ? 'selected' : '' }}>Off Shore</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled md-input-filled"><span class="parsley-required workplace_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('rates.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script src="{{ asset('js/rates.js') }}"></script>
<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
    Rates.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
</script>

