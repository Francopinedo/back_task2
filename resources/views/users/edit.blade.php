<style>

    #edit_div.switcher_active {
        width: 40%;
    }

</style>
        <form  autocomplete="off" role="form" method="POST" action="{{ url('users/update') }}" id="data-form-edit"
              data-redirect-on-success="{{ url('users') }}">

<div class="uk-grid" data-uk-grid-margin>

        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="hidden" name="company_id" value="{{ isset($company_id)?$company_id:'' }}">

            <li class="uk-width-medium-1-2 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('users.name') }}</label>
                    <input type="text" class="md-input" name="name" value="{{ $user->name }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('users.email') }}</label>
                    <input type="text" class="md-input"  autocomplete="off" name="email" value="{{ $user->email }}" required><span
                            class="md-input-bar "></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('users.address') }}</label>
                    <input type="text" class="md-input" name="address" value="{{ $user->address }}"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('users.office_phone') }}</label>
                    <input type="text" class="md-input" name="office_phone" value="{{ $user->office_phone }}"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required office_phone-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('users.home_phone') }}</label>
                    <input type="text" class="md-input" name="home_phone" value="{{ $user->home_phone }}"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required home_phone-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('users.cell_phone') }}</label>
                    <input type="text" class="md-input" name="cell_phone" value="{{ $user->cell_phone }}"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cell_phone-error"></span>
                </div>

                {{-- <div class="md-input-wrapper md-input-filled">
                        <label>{{ __('cities.timezone') }}</label>
                        <input type="text" class="md-input" name="timezone" value="{{$user->timezone}}"><span
                                class="md-input-bar"></span>
                    </div> --}}

                    <div class="md-input-wrapper md-input-select">
                        <label>{{ __('cities.timezone') }}</label>
                        <select name="timezone" id="timezone" data-md-selectize>
                            <option value="">{{ __('cities.timezone') }}...</option>
                            @foreach ($timezones as $timezone)
                                <option value="{{ $timezone->timezone }}" {{ ($timezone->timezone == $user->timezone) ? 'selected' : '' }}>{{ $timezone->timezone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="parsley-errors-list filled"><span class="parsley-required timezone-error"></span>
                    </div>

                    <div class="md-input-wrapper md-input-select">
                        <label>{{ __('users.country') }}</label>
                        <select name="country_id" id="country_id2" data-md-selectize>
                            <option value="">{{ __('users.country') }}...</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ ($country->id == $user->city_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.city') }}</label>
                    <select name="city_id" id="city_id2" data-md-selectize>
                        <option value="">{{ __('users.city') }}...</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ ($city->id == $user->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>
			
		</li>
	            <li class="uk-width-medium-1-2 uk-row-first">

               

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.office') }}</label>
                    <select name="office_id" id="office_id2" data-md-selectize>
                        <option value="">{{ __('users.office') }}...</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}" {{ ($office->id == $user->office_id) ? 'selected' : '' }}>{{ $office->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>



                    <div class="md-input-wrapper md-input-select">
                        <label>{{ __('users.permission_role') }}</label>
                        <select name="company_role_id" data-md-selectize>
                            <option value="">{{ __('users.permission_role') }}...</option>
                            @foreach ($companyRoles as $companyRole)
                                <option value="{{ $companyRole->id }}" {{ ($companyRole->id == $user->company_role_id) ? 'selected' : '' }}>{{ $companyRole->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                  id="company_role_id-error"></span></div>

                @if (!empty($projectRoles))


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.project_role') }}</label>
                    <select name="project_role_id" data-md-selectize>
                        <option value="">{{ __('users.project_role') }}...</option>
                        @foreach ($projectRoles as $projectRole)
                            <option value="{{ $projectRole->id }}" {{ ($projectRole->id == $user->project_role_id) ? 'selected' : '' }}>{{ $projectRole->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required"
                                                              id="project_role_id-error"></span></div>
				
			

					@endif

                @if (!empty($seniorities))
                    <div class="md-input-wrapper md-input-select">
                        <label>{{ __('users.seniority') }}</label>
                        <select name="seniority_id" data-md-selectize>
                            <option value="">{{ __('users.seniority') }}...</option>
                            @foreach ($seniorities as $seniority)
                                <option value="{{ $seniority->id }}" {{ ($seniority->id == $user->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                  id="seniority_id-error"></span></div>
                @endif


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('users.workgroup') }}</label>
                    <select name="workgroup_id" data-md-selectize>
                        <option value="">{{ __('users.workgroup') }}...</option>
                        @foreach ($workgroups as $workgroup)
                            <option value="{{ $workgroup->id }}" {{ ($workgroup->id == $user->workgroup_id) ? 'selected' : '' }}>{{ $workgroup->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workgroup_id-error"></span>
                </div>

              

            </li>
			            <li class="uk-width-medium-1-1 uk-row-first">
						  <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="update-btn">{{ __('users.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>
</li>

</div>
        </form>

<script src="{{ asset('js/users.js') }}"></script>
<script type="text/javascript">
    $('.cancel-edit-btn').on('click', function (e) {
        e.preventDefault();
        $('#edit_div_toggle').hide();
        $('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
    Users.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
</script>
