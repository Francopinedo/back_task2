<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

        <form role="form" method="POST" action="{{ url('team_users/update') }}" id="data-form-edit"
              data-redirect-on-success="{{ url('team_users') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $teamUser->id }}">
            <input type="hidden" name="company_id" value="{{ $company->id }}">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('team_users.project') }}</label>
                    <input type="hidden" id="team_project_id" name="project_id" value="{{$project->id}}">
                    <span>{{$project->name}}</span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_id-error"></span>
                </div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('team_users.user') }}</label>
                    <input type="hidden" name="user_id" id="user_id" value="{{$teamUser->user_id}}">
                    <span>{{ $user->name }}</span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('team_users.from') }}</label>
                    <input required class="md-input" type="text" id="date_from" name="date_from"
                           value="{{isset($teamUser->date_from)?$teamUser->date_from:$project->start}}"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date_from-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('team_users.to') }}</label>
                    <input required class="md-input" type="text" id="date_to" name="date_to"
                           value="{{isset($teamUser->date_to)?$teamUser->date_to:$project->finish}}"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date_to-error"></span></div>



                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.project_role') }}</label>
                    <select name="project_role_id" required id="project_role" data-md-selectize>
                        <option value="">{{ __('users.project_role') }}...</option>
                        @foreach ($projectRoles as $projectRole)
                            <option value="{{ $projectRole->id }}" {{ ($projectRole->id == $teamUser->project_role_id) ? 'selected' : '' }}>{{ $projectRole->title }}</option>
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
                            <option value="{{ $seniority->id }}" {{ ( $seniority->id == $teamUser->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span>
                </div>


                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.workplace') }}</label>
                    <select required name="workplace" id="workplace2" data-md-selectize>
                        <option value="">{{ __('projects.workplace') }}...</option>
                        <option value="onsite" {{ ($teamUser->workplace == 'onsite') ? 'selected' : '' }}>{{ __('projects.onsite') }}...</option>
                        <option value="offshore" {{ ($teamUser->workplace == 'offshore') ? 'selected' : '' }}>{{ __('projects.offshore') }}...</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.country') }}</label>
                    <select name="country_id" required id="country_id2" data-md-selectize>
                        <option value="">{{ __('rates.country') }}...</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ ( $country->id == $teamUser->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span>
                </div>



                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.city') }}</label>
                    <select name="city_id" id="city_id2" data-md-selectize>
                        <option value="">{{ __('rates.city') }}...</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ ( $city->id == $teamUser->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.office') }}</label>
                    <select name="office_id"  id="office_id2"  required data-md-selectize>
                        <option value="">{{ __('rates.office') }}...</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}" {{ ( $office->id == $teamUser->office_id) ? 'selected' : '' }}>{{ $office->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>







                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('team_users.working_hours') }}</label>
                    <input required name="hours" id="working_hours" class="md-input"
                           value="{{ isset($teamUser->hours)?$teamUser->hours:$office->hours_by_day}}">

                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required working_hours-error"></span></div>


                <label>{{ __('team_users.load') }}</label>
                <input required name="load" id="load" class="md-input"
                       value="{{ isset($teamUser->load)?$teamUser->load:''}}">

            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required working_hours-error"></span></div>




            <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="update-btn">{{ __('team_users.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>

<script src="{{ asset('js/team_users.js') }}"></script>
<script type="text/javascript">
    $('.cancel-edit-btn').on('click', function (e) {
        e.preventDefault();
        $('#edit_div_toggle').hide();
        $('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();





    TeamUsers.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');


</script>


