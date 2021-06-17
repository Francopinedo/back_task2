<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('costs') }}" id="data-form" data-redirect-on-success="{{ url('costs') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('costs.country') }}</label>
                	<select name="country_id" data-md-selectize>
                	    <option value="">{{ __('costs.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}">{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('costs.city') }}</label>
                	<select name="city_id" data-md-selectize>
                	    <option value="">{{ __('costs.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}">{{ $city->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
					<label>{{ __('costs.seniority') }}</label>
                	<select name="seniority_id" data-md-selectize>
                	    <option value="">{{ __('costs.seniority') }}...</option>
                	    @foreach ($seniorities as $seniority)
                	        <option value="{{ $seniority->id }}">{{ $seniority->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('costs.project_role') }}</label>
                	<select name="project_role_id" data-md-selectize>
                	    <option value="">{{ __('costs.project_role') }}...</option>
                	    @foreach ($project_roles as $project_role)
                	        <option value="{{ $project_role->id }}">{{ $project_role->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('costs.workplace') }}</label>
                	<select name="workplace_id" data-md-selectize>
                	    <option value="">{{ __('costs.workplace') }}...</option>
                	    <option value="onsite">On Site</option>
                	    <option value="offshore">Off Shore</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('costs.detail') }}</label>
                	<input type="text" class="md-input" name="detail" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('costs.value') }}</label>
                    <br>
                	<input type="text" class="md-input" name="value"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required value-error"></span></div>

               	<div class="md-input-wrapper md-input-select">
               		<label>{{ __('costs.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('costs.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('costs.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

