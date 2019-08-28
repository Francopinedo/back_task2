<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        @if(session()->has('message'))
            <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                <a href="#" class="uk-alert-close uk-close"></a>
                {{ session('message') }}
            </div>
        @endif
        <form role="form" method="POST" action="{{ url('project_resources') }}" id="data-form-ajax_create"
              data-redirect-on-success="{{ url('project_board/rows') }}">
            {{ csrf_field() }}
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
            <input type="hidden" name="rate_id" id="rate_id" value="">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.project_role') }}</label>
                    <select name="project_role_id" id="project_role_id" required data-md-selectize>
                        <option value="">{{ __('projects.project_role') }}...</option>
                        @foreach ($projectRoles as $projectRole)
                            <option value="{{ $projectRole->id }}">{{ $projectRole->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required"
                                                              id="project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.seniority') }}</label>
                    <select name="seniority_id" id="seniority_id" required data-md-selectize>
                        <option value="">{{ __('projects.seniority') }}...</option>
                        @foreach ($seniorities as $seniority)
                            <option value="{{ $seniority->id }}">{{ $seniority->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span>
                </div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.currency') }}</label>
                    <select name="currency_id" id="currency_id" required data-md-selectize>
                        <option value="">{{ __('projects.currency') }}...</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span>
                </div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.workplace') }}</label>
                    <select name="workplace" id="workplace" required data-md-selectize>
                        <option value="">{{ __('projects.workplace') }}...</option>
                        <option value="onsite">{{ __('projects.onsite') }}...</option>
                        <option value="offshore">{{ __('projects.offshore') }}...</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span>
                </div>


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
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.office') }}</label>
                    <select name="office_id"  id="office_id"  required>
                        <option value="">{{ __('rates.office') }}...</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>




                <div class="md-input-wrapper">
                    <label>{{ __('projects.rate') }}</label>

                    <input type="text"  class="md-input" name="rate" id="rate" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required rate-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.user') }}</label>
                    <select name="user_id" id="user_id" required data-md-selectize>
                        <option value="">{{ __('projects.user') }}...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->user_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects.load') }}</label>
                    <input type="text" class="md-input" name="load" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required load-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects.comments') }}</label>
                    <input type="text" class="md-input" name="comments" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comments-error"></span></div>




                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="ajax_create-btn">{{ __('projects.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                       id="cancel-ajax_create-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>


<script type="text/javascript">
    $('#cancel-ajax_create-btn').on('click', function (e) {
        e.preventDefault();
        $('#ajax_create_div_toggle').hide();
        $('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();
    contracts.initResources();
    altair_forms.init();
</script>
