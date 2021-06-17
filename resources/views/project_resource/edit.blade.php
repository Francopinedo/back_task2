<style>

    #edit_div.switcher_active {
        width: 50%;
    }

</style> 
 	<form role="form" method="POST" action="{{ url('project_resources/update') }}"
			  id="data-form-edit" data-redirect-on-success="{{ url('project_board/project_rows') }}">

<div class="uk-grid" data-uk-grid-margin>

        @if(session()->has('message'))
    		<li class="uk-width-medium-1-1 uk-row-first">
            <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                <a href="#" class="uk-alert-close uk-close"></a>
                {{ session('message') }}
            </div>
	</li>
        @endif

       	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $projectResource->id }}">
    	    <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
    	    <input type="hidden" name="rate_id" id="rate_id" value="{{ $projectResource->rate_id }}">
    		<li class="uk-width-medium-1-2 uk-row-first">

                <div class="md-input-wrapper md-input-filled md-input-select">
					<label>{{ __('projects.project_role') }}</label>
                	<select required name="project_role_id" id="project_role_id" data-md-selectize>
                	    <option value="">{{ __('projects.project_role') }}...</option>
                	    @foreach ($projectRoles as $projectRole)
                	        <option value="{{ $projectRole->id }}" {{ ($projectRole->id == $projectResource->project_role_id) ? 'selected' : '' }}>{{ $projectRole->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.seniority') }}</label>
                	<select required name="seniority_id" id="seniority_id" data-md-selectize>
                	    <option value="">{{ __('projects.seniority') }}...</option>
                	    @foreach ($seniorities as $seniority)
                	        <option value="{{ $seniority->id }}" {{ ($seniority->id == $projectResource->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.currency') }}</label>
                	<select  required name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('projects.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $projectResource->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.workplace') }}</label>
                	<select required name="workplace" id="workplace" data-md-selectize>
                	    <option value="">{{ __('projects.workplace') }}...</option>
                	    <option value="onsite" {{ ($projectResource->workplace == 'onsite') ? 'selected' : '' }}>{{ __('projects.onsite') }}...</option>
                	    <option value="offshore" {{ ($projectResource->workplace == 'offshore') ? 'selected' : '' }}>{{ __('projects.offshore') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span></div>


				<div class="md-input-wrapper md-input-filled md-input-select">
					<label>{{ __('rates.country') }}</label>
					<select required name="country_id"  id="country_id2" data-md-selectize>
						<option value="">{{ __('rates.country') }}...</option>
						@foreach ($countries as $country)
							<option value="{{ $country->id }}" {{ ( $country->id == $projectResource->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>


				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.city') }}</label>
					<select name="city_id" id="city_id2" data-md-selectize>
						<option value="">{{ __('rates.city') }}...</option>
						@foreach ($cities as $city)
							<option value="{{ $city->id }}" {{ ( $city->id == $projectResource->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>

						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>
</li>
    		<li class="uk-width-medium-1-2 uk-row-first">
				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.office') }}</label>
					<select name="office_id"  id="office_id2"  required data-md-selectize>
						<option value="">{{ __('rates.office') }}...</option>
						@foreach ($offices as $office)
							<option value="{{ $office->id }}" {{ ( $office->id == $projectResource->office_id) ? 'selected' : '' }}>{{ $office->title }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>




				<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.rate') }}</label>

                	<input type="text" class="md-input" name="rate"  id="rate" value="{{ $projectResource->rate }}" required>
                    <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required rate-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.user') }}</label>
                	<select required name="user_id" id="user_id" data-md-selectize>
                	    <option value="">{{ __('projects.user') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->user_id }}" {{ ($user->user_id == $projectResource->user_id) ? 'selected' : '' }}>{{ $user->user_name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.load') }}</label>
                	<input type="text" class="md-input" name="load" value="{{ $projectResource->load }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required load-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.comments') }}</label>
                	<input type="text" class="md-input" name="comments" value="{{ $projectResource->comments }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comments-error"></span></div>
</li>
    		<li class="uk-width-medium-1-1 uk-row-first">


				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('projects.update')}}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </li>

</div>
    	</form>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
    contracts.initResources();
    altair_forms.init();
</script>
