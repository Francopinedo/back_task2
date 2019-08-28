<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('costs/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('costs') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $cost->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('costs.country') }}</label>
                	<select name="country_id" data-md-selectize>
                	    <option value="">{{ __('costs.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}" {{ ($country->id == $cost->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="md-input-wrapper md-input-filled md-input-select">
					<label>{{ __('costs.city') }}</label>
                	<select name="city_id" data-md-selectize>
                	    <option value="">{{ __('costs.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}" {{ ($city->id == $cost->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('costs.seniority') }}</label>
                	<select name="seniority_id" data-md-selectize>
                	    <option value="">{{ __('costs.seniority') }}...</option>
                	    @foreach ($seniorities as $seniority)
                	        <option value="{{ $seniority->id }}" {{ ($seniority->id == $cost->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('costs.project_role') }}</label>
                	<select name="project_role_id" data-md-selectize>
                	    <option value="">{{ __('costs.project_role') }}...</option>
                	    @foreach ($project_roles as $project_role)
                	        <option value="{{ $project_role->id }}" {{ ($project_role->id == $cost->project_role_id) ? 'selected' : '' }}>{{ $project_role->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('costs.workplace') }}</label>
                	<select name="workplace" data-md-selectize>
                	    <option value="">{{ __('costs.workplace') }}...</option>
                	    <option value="onsite" {{ ($cost->workplace == 'onsite') ? 'selected' : '' }}>On Site</option>
                	    <option value="offshore" {{ ($cost->workplace == 'offshore') ? 'selected' : '' }}>Off Shore</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled md-input-filled"><span class="parsley-required workplace_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('costs.detail') }}</label>
                	<input type="text" class="md-input" name="detail" value="{{ $cost->detail }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('costs.value') }}</label>
                	<input type="text" class="md-input" name="value" value="{{ $cost->value }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required value-error"></span></div>

               	<div class="md-input-wrapper md-input-filled md-input-select">
               		<label>{{ __('costs.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('costs.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $cost->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('costs.update') }}</a>
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