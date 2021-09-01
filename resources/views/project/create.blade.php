<style>

    .uk-datepicker {
        min-width: initial !important;
        width: 215px !important;
    }

    #create_div.switcher_active {
        width: 50%;
    }
    #sow_number, #identificador, #technical_estimator, #estimated_renueve, #estimated_margin, #target_margin, #financial_deviation_threshold, #time_deviation_threshold, #hours_by_day {
        padding-top: 30px;
        padding-bottom: 10px;
    }

</style>
 <form role="form" method="POST" action="{{ url('projects') }}" id="data-form"
              data-redirect-on-success="{{ url($url) }}">



<div class="uk-grid" data-uk-grid-margin>

   <li class="uk-width-medium-1-1 uk-row-first">
        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
            </li>

             {{ csrf_field() }}
            <li class="uk-width-medium-1-3 uk-row-first">
                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.name') }}</label>
                    <input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.customer') }}</label>
                    <select name="customer_id" data-md-selectize>
                        <option value="">{{ __('projects.customer') }}...</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.customer_name') }}</label>
                    <input type="text" class="md-input" name="customer_name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_name-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('projects_tooltip.start') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="start"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('projects_tooltip.finish') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="finish"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required finish-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.project_manager') }}</label>
                    <select name="project_manager_id" data-md-selectize>
                        <option value="">{{ __('projects.project_manager') }}...</option>
                        @foreach ($project_managers as $pm)
                            <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_manager_id-error"></span>
                </div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.technical_director') }}</label>
                    <select name="technical_director_id" data-md-selectize>
                        <option value="">{{ __('projects.technical_director') }}...</option>
                        @foreach ($technical_directors as $pm)
                            <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required technical_director_id-error"></span></div>
		<div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.delivery_manager') }}</label>
                    <select name="delivery_manager_id" data-md-selectize>
                        <option value="">{{ __('projects.delivery_manager') }}...</option>
                        @foreach ($delivery_managers as $pm)
                            <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery_manager_id-error"></span>
                </div>
		</li>
	            <li class="uk-width-medium-1-3 uk-row-first">



                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.sow_number') }}</label>
                    <input type="text" class="md-input" name="sow_number" id="sow_number"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sow_number-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.identificator') }}</label>
                    <input type="text" class="md-input" name="identificator" id="identificador"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required identificator-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.status') }}</label>
                    <select name="status" data-md-selectize>
                        <option value="">{{ __('projects.status') }}...</option>
                        <option value="{{ __('projects.initiating') }}">{{ __('projects.initiating') }}</option>
                        <option value="{{ __('projects.planning') }}">{{ __('projects.planning') }}</option>
                        <option value="{{ __('projects.executing') }}">{{ __('projects.executing') }}</option>
                        <option value="{{ __('projects.closing') }}">{{ __('projects.closing') }}</option>
                        <option value="{{ __('projects.waiting') }}">{{ __('projects.waiting') }}</option>
                        <option value="{{ __('projects.completed') }}">{{ __('projects.completed') }}</option>
                        <option value="{{ __('projects.cancelled') }}">{{ __('projects.cancelled') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.presales_responsable') }}</label>
                    <select name="presales_resonsable" data-md-selectize>
                        <option value="">{{ __('projects.presales_responsable') }}...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required presales_responsable-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.technical_estimator') }}</label>
                    <select name="technical_estimator" data-md-selectize>
                        <option value="">{{ __('projects.technical_estimator') }}...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required technical_estimator-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.engagement') }}</label>
                    <select name="engagement" data-md-selectize>
                        <option value="">{{ __('projects.engagement') }}...</option>
                        @foreach ($engagements as $engagement)
                            <option value="{{ $engagement->name }}">{{ $engagement->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required engagement-error"></span></div>

 <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.estimated_revenue') }}</label>
                    <input type="text" class="md-input" name="estimated_revenue" id="estimated_renueve"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_revenue-error"></span>
                </div>





			<label>{{ __('projects_tooltip.name_convention') }}</label>
                <div class="md-input-wrapper ">


                    <select name="name_convention[]" multiple data-md-selectize>
                        <option value="">{{ __('projects.name_convention') }}...</option>
                        <option value="CustomerName">CustomerName</option>
                        <option value="ProjectName">ProjectName</option>
                        <option value="ArtifactName">ArtifactName</option>
                        <option value="YYYYMMDDHHMMSS">YYYYMMDDHHMMSS</option>
                        <option value="VersionNumber">VersionNumber</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required name_convention-error"></span></div>


			</li>
				            <li class="uk-width-medium-1-3 uk-row-first">


                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.estimated_cost') }}</label>
                    <input type="text" class="md-input" name="estimated_cost"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_cost-error"></span>
                </div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.estimated_margin') }}</label>
                    <input type="text" class="md-input" name="estimated_margin" id="estimated_margin"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_margin-error"></span>
                </div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.estimated_department_margin') }}</label>
                    <input type="text" class="md-input" name="estimated_department_margin"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required estimated_department_margin-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.target_margin') }}</label>
                    <input type="text" class="md-input" name="target_margin" id="target_margin"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required target_margin-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.financial_deviation_threshold') }}</label>
                    <input type="text" class="md-input" name="financial_deviation_threshold" id="financial_deviation_threshold"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required financial_deviation_threshold-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.time_deviation_threshold') }}</label>
                    <input type="text" class="md-input" name="time_deviation_threshold" id="time_deviation_threshold"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required time_deviation_threshold-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('projects_tooltip.hours_by_day') }}</label>
                    <input type="text" class="md-input hours_by_day" name="hours_by_day" id="hours_by_day"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required hours_by_day-error"></span></div>

                <label>{{ __('projects_tooltip.week_holy_days') }}</label>
                <div class="md-input-wrapper ">


                    <select name="holy_days[]" multiple data-md-selectize>
                        <option value="">{{ __('projects.week_holy_days') }}...</option>
                        <option value="0">Sunday</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>

                    </select>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required holy_days-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects_tooltip.department') }}</label>
                    <select name="department_id" data-md-selectize>
                        <option value="">{{ __('projects.department') }}...</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->title }}
                                ({{ $department->office->data->title }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required department_id-error"></span></div>



            </li>
 <li class="uk-width-medium-1-1 uk-row-first">
     <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="add-btn">{{ __('projects.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                       id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>
 </li>
            </div>
</div>
        </form>


