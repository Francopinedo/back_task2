<style>

    #create_div.switcher_active {
        width: 40%;
    }

</style>
{{-- @if (!empty($company_id)) --}}
          <form autocomplete="off" role="form" method="POST" action="{{ url('users') }}" id="data-form"
                  data-redirect-on-success="{{ url($url) }}">
  
    <div class="uk-grid" data-uk-grid-margin>

            <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

                {{ csrf_field() }}
                <input type="hidden" name="company_id" value="{{ isset($company_id)?$company_id:'' }}">
                @if (Auth::user()->hasRole('user'))
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                @endif
                <li class="uk-width-medium-1-2 uk-row-first">
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
                        <label>{{ __('cities.timezone') }}</label>
                        <select name="timezone" id="timezone" data-md-selectize>
                            <option value="">{{ __('cities.timezone') }}...</option>
                            @foreach ($timezones as $timezone)
                                <option value="{{ $timezone->timezone }}">{{ $timezone->timezone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="parsley-errors-list filled"><span class="parsley-required timezone-error"></span>
                    </div>
					</li>
                <li class="uk-width-medium-1-2 uk-row-first">


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
                        <select name="office_id" id="office_id" data-md-selectize>
                            <option value="">{{ __('users.office') }}...</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->title }}</option>
                            @endforeach
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
                @if (!empty($projectRoles))



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
					
	

					
			@endif

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

                   

                </li>
				                <li class="uk-width-medium-1-1 uk-row-first">
								 <div class="uk-margin-medium-top">
                        <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                           href="#" id="add-btn">{{ __('users.add_new') }}</a>
                        <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                           id="cancel-btn">{{ __('general.cancel') }}</a>
                    </div>
                </li>


    </div>
            </form>

{{-- @endif --}}

<script src="{{ asset('js/table_actions.js') }}"></script>
<script type="text/javascript">
    
    $(function(){
        $("#city_id").on('change', function () {
            console.log('chage....');
            var html = '<option value="">Office...</option>';
            $.ajax({
                url: API_PATH + '/offices',
                type: 'GET',
                data: {city_id: $(this).val(), company_id:$("#company_id").val()},
                dataType: 'json'
            }).done(
                function (data) {
                    var html = '<option value="">Office...</option>';
                    
                    $('#office_id').selectize()[0].selectize.destroy();

                    $.each(data.data, function (i, value) {
                        console.log(value);
                        html += '<option value="' + value.id + '">' + value.title + '</option>';
                    });

                    $('#office_id').html(html);
                    $('#office_id').selectize();
                }
            );
        });
    });

    $('.cancel-ajax_create-btn').on('click', function (e) {
        e.preventDefault();
        $('#ajax_create_div_toggle').hide();
        $('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();

    // altair_forms.init();
</script>