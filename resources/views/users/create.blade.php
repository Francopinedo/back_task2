@if (!empty($company_id))

    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-1-1">

            <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

            <form autocomplete="off" role="form" method="POST" action="{{ url('users') }}" id="data-form"
                  data-redirect-on-success="{{ url('users') }}">
                {{ csrf_field() }}
                <input type="hidden" name="company_id" value="{{ isset($company_id)?$company_id:'' }}">
                @if (Auth::user()->hasRole('user'))
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                @endif
                <div class="uk-width-medium-1-1 uk-row-first">
                    <div class="md-input-wrapper">
                        <label>{{ __('users.name') }}</label>
                        <input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                    <div class="md-input-wrapper">
                        <label>{{ __('users.email') }}</label>
                        <input type="email" class="md-input" name="email" autocomplete="off" required><span
                                class="md-input-bar "></span>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required email-error"></span>
                    </div>

                    <div class="md-input-wrapper">
                        <label>{{ __('users.password') }}</label>
                        <input type="password" class="md-input" autocomplete="off" name="password" required><span
                                class="md-input-bar "></span>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required password-error"></span>
                    </div>

                    <div class="md-input-wrapper">
                        <label>{{ __('users.address') }}</label>
                        <input type="text" class="md-input" name="address" required><span class="md-input-bar"></span>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required address-error"></span>
                    </div>

                    <div class="md-input-wrapper">
                        <label>{{ __('users.office_phone') }}</label>
                        <input type="text" class="md-input" name="office_phone" required><span
                                class="md-input-bar"></span>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                  id="office_phone-error"></span></div>

                    <div class="md-input-wrapper">
                        <label>{{ __('users.home_phone') }}</label>
                        <input type="text" class="md-input" name="home_phone" required><span
                                class="md-input-bar"></span>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required home_phone-error"></span>
                    </div>

                    <div class="md-input-wrapper">
                        <label>{{ __('users.cell_phone') }}</label>
                        <input type="text" class="md-input" name="cell_phone" required><span
                                class="md-input-bar"></span>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required cell_phone-error"></span>
                    </div>


                    <div class="md-input-wrapper md-input-select">
                        <label>{{ __('users.city') }}</label>
                        <select name="city_id" id="city_id" data-md-selectize>
                            <option value="">{{ __('users.city') }}...</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span>
                    </div>


                    <div class="md-input-wrapper md-input-select">
                        <label>{{ __('users.office') }}</label>
                        <select name="office_id" id="office_id">
                            <option value="">{{ __('users.office') }}...</option>

                        </select>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span>
                    </div>


                    <div class="md-input-wrapper md-input-select">
                        <label>{{ __('users.permission_role') }}</label>
                        <select name="company_role_id" data-md-selectize>
                            <option value="">{{ __('users.permission_role') }}...</option>
                            @foreach ($companyRoles as $companyRole)
                                <option value="{{ $companyRole->id }}">{{ $companyRole->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                  id="company_role_id-error"></span></div>


                    <div class="md-input-wrapper md-input-select">
                        <label>{{ __('users.project_role') }}</label>
                        <select name="project_role_id" data-md-selectize>
                            <option value="">{{ __('users.project_role') }}...</option>
                            @foreach ($projectRoles as $projectRole)
                                <option value="{{ $projectRole->id }}">{{ $projectRole->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                  id="project_role_id-error"></span></div>


                @if (!empty($seniorities))
                        <div class="md-input-wrapper md-input-select">
                            <label>{{ __('users.seniority') }}</label>
                            <select name="seniority_id" data-md-selectize>
                                <option value="">{{ __('users.seniority') }}...</option>
                                @foreach ($seniorities as $seniority)
                                    <option value="{{ $seniority->id }}">{{ $seniority->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                      id="seniority_id-error"></span></div>
                    @endif

                    @if (isset($workgroups) && !empty($workgroups) && count($workgroups) > 0)

                        <div class="md-input-wrapper md-input-select">
                            <label>{{ __('users.workgroup') }}</label>
                            <select name="workgroup_id" data-md-selectize>
                                <option value="">{{ __('users.workgroup') }}...</option>
                                @foreach ($workgroups as $workgroup)
                                    <option value="{{ $workgroup->id }}">{{ $workgroup->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                      id="workgroup_id-error"></span></div>

                    @endif

                    <div class="uk-margin-medium-top">
                        <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                           href="#" id="add-btn">{{ __('users.add_new') }}</a>
                        <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                           id="cancel-btn">{{ __('general.cancel') }}</a>
                    </div>

                </div>

            </form>
        </div>
    </div>

@endif

<script src="{{ asset('js/table_actions.js') }}"></script>
<script type="text/javascript">
    $('.cancel-ajax_create-btn').on('click', function (e) {
        e.preventDefault();
        $('#ajax_create_div_toggle').hide();
        $('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();

    altair_forms.init();
</script>


<script src="{{ asset('js/users.js') }}"></script>
<script type="text/javascript">

    Users.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
</script>