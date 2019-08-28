<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('rates') }}" id="data-form" data-redirect-on-success="{{ url('rates') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('rates.country') }}</label>
                	<select name="country_id" id="country_id" data-md-selectize>
                	    <option value="">{{ __('rates.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}">{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.city') }}</label>
                	<select name="city_id" id="city_id" data-md-selectize>
                	    <option value="">{{ __('rates.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}">{{ $city->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.office') }}</label>
					<select name="office_id"  id="office_id"  required data-md-selectize>
						<option value="">{{ __('rates.office') }}...</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->title }}</option>
                        @endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('rates.project_role') }}</label>
                	<select name="project_role_id" data-md-selectize>
                	    <option value="">{{ __('rates.project_role') }}...</option>
                	    @foreach ($project_roles as $project_role)
                	        <option value="{{ $project_role->id }}">{{ $project_role->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('rates.seniority') }}</label>
                	<select name="seniority_id" data-md-selectize>
                	    <option value="">{{ __('rates.seniority') }}...</option>
                	    @foreach ($seniorities as $seniority)
                	        <option value="{{ $seniority->id }}">{{ $seniority->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('rates.title') }}</label>
                	<input type="text" class="md-input" name="title" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('rates.value') }}</label>
                	<input type="text" class="md-input" name="value"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required value-error"></span></div>

               	<div class="md-input-wrapper md-input-select">
               		<label>{{ __('rates.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('rates.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>



                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('rates.workplace') }}</label>
                	<select name="workplace" data-md-selectize>
                	    <option value="">{{ __('rates.workplace') }}...</option>
                	    <option value="onsite">On Site</option>
                	    <option value="offshore">Off Shore</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('rates.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>



<script src="{{ asset('js/rates.js') }}"></script>
<script type="text/javascript">

    Rates.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
</script>