<style>



    #create_div.switcher_active {
        width: 40%;
    }

</style>
<form role="form" method="POST" action="{{ url('team_users') }}" id="data-form" data-redirect-on-success="{{ url($url) }}">
     
<div class="uk-grid" data-uk-grid-margin>

    		<li class="uk-width-medium-1-1 uk-row-first">
		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>
</li>
    	       <input type="hidden" name="company_id" value="{{ $company->id }}">
    	    {{ csrf_field() }}
			</li>
    		<li class="uk-width-medium-1-2 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('team_users.project') }}</label>
                	<select name="project_id" id="team_project_id" onchange="" data-md-selectize>
                	    <option value="">{{ __('team_users.project') }}...</option>
                	    @foreach ($projects as $project)
                	        <option value="{{ $project->id }}">{{ $project->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_id-error"></span></div>



                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.country') }}</label>
                    <select name="country_id" required id="country_id" data-md-selectize>
                        <option value="">{{ __('rates.country') }}...</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span>
                </div>



                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.city') }}</label>
                    <select name="city_id" id="city_id" data-md-selectize>
                        <option value="">{{ __('rates.city') }}...</option>
                        @foreach($cities as $citie)
                            <option value="{{ $citie->id }}">{{ $citie->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.office') }}</label>
                    <select name="office_id"  id="office_id"  required data-md-selectize>
                        <option value="">{{ __('rates.office') }}...</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>






                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.permission_role') }}</label>
                    <select name="company_role_id" required id="company_role_id" data-md-selectize>
                        <option value="">{{ __('users.permission_role') }}...</option>
                        @foreach ($companyRoles as $companyRole)
                            <option value="{{ $companyRole->id }}">{{ $companyRole->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required company_role_id-error"></span>
                </div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.project_role') }}</label>
                    <select name="project_role_id" required id="project_role" data-md-selectize>
                        <option value="">{{ __('users.project_role') }}...</option>
                        @foreach ($projectRoles as $companyRole)
                            <option value="{{ $companyRole->id }}">{{ $companyRole->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role-error"></span>
                </div>



                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.seniority') }}</label>
                    <select name="seniority_id" required id="seniority_id" data-md-selectize>
                        <option value="">{{ __('users.seniority') }}...</option>
                        @foreach ($seniorities as $seniority)
                            <option value="{{ $seniority->id }}">{{ $seniority->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span>
                </div>
				</li>
    		<li class="uk-width-medium-1-2 uk-row-first">


                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.workplace') }}</label>
                    <select required name="workplace" id="workplace" data-md-selectize>
                        <option value="">{{ __('projects.workplace') }}...</option>
                        <option value="onsite" >{{ __('projects.onsite') }}...</option>
                        <option value="offshore">{{ __('projects.offshore') }}...</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span></div>




                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('team_users.user') }}</label>
                	<select name="user_id" id="user_id"  onchange="TeamUsers.serachUser()" data-md-selectize>
                	    <option value="">{{ __('team_users.user') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}">{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('team_users.from') }}</label>
					<input class="md-input" required type="text" id="date_from" name="date_from" value="" data-uk-datepicker="{format:'YYYY-MM-DD'}">
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required date_from-error"></span></div>


				<div class="md-input-wrapper md-input-select">
					<label>{{ __('team_users.to') }}</label>
					<input class="md-input" required type="text" id="date_to" name="date_to" value="" data-uk-datepicker="{format:'YYYY-MM-DD'}">
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required date_to-error"></span></div>



				<div class="md-input-wrapper md-input-select">
					<label>{{ __('team_users.working_hours') }}</label>
					<input name="hours" required id="working_hours" class="md-input"
						   value="">

				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required working_hours-error"></span></div>


		
  <div class="md-input-wrapper md-input-select">
                <label>{{ __('users.rate') }}</label>
                <br/>
                <input required name="rate" id="rate" class="md-input" readonly>

            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required rate-error"></span></div>


		</li>
    		<li class="uk-width-medium-1-1 uk-row-first">

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('team_users.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </li>

    	</form>
</div>

<script src="{{ asset('js/team_users.js') }}"></script>
<script type="text/javascript">
    $(function(){
        TeamUsers.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
    });
</script>
