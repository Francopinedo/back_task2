<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('projects') }}" id="data-form" data-redirect-on-success="{{ url('projects') }}">
    	    {{ csrf_field() }}
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('projects.name') }}</label>
                	<input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.customer') }}</label>
                	<select name="customer_id" data-md-selectize>
                	    <option value="">{{ __('projects.customer') }}...</option>
                	    @foreach ($customers as $customer)
                	        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.customer_name') }}</label>
                	<input type="text" class="md-input" name="customer_name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_name-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('projects.start') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="start" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('projects.finish') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="finish" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required finish-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.project_manager') }}</label>
                	<select name="project_manager_id" data-md-selectize>
                	    <option value="">{{ __('projects.project_manager') }}...</option>
                	    @foreach ($users as $pm)
                	        <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_manager_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.technical_director') }}</label>
                	<select name="technical_director_id" data-md-selectize>
                	    <option value="">{{ __('projects.technical_director') }}...</option>
                	    @foreach ($users as $pm)
                	        <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required technical_director_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.delivery_manager') }}</label>
                	<select name="delivery_manager_id" data-md-selectize>
                	    <option value="">{{ __('projects.delivery_manager') }}...</option>
                	    @foreach ($users as $pm)
                	        <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery_manager_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.sow_number') }}</label>
                	<input type="text" class="md-input" name="sow_number"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sow_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.identificator') }}</label>
                	<input type="text" class="md-input" name="identificator"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required identificator-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.status') }}</label>
                	<select name="status" data-md-selectize>
                	    <option value="">{{ __('projects.status') }}...</option>
                	    <option value="initiating">{{ __('projects.initiating') }}...</option>
                	    <option value="planning">{{ __('projects.planning') }}...</option>
                	    <option value="executing">{{ __('projects.executing') }}...</option>
                	    <option value="closing">{{ __('projects.closing') }}...</option>
                	    <option value="waiting">{{ __('projects.waiting') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.presales_responsable') }}</label>
                	<input type="text" class="md-input" name="presales_responsable"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required presales_responsable-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.technical_estimator') }}</label>
                	<input type="text" class="md-input" name="technical_estimator"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required technical_estimator-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.engagement') }}</label>
                	<select name="engagement_id" data-md-selectize>
                	    <option value="">{{ __('projects.engagement') }}...</option>
                	    <option value="Staff Augmentation">{{ __('projects.staff_argumentation') }}...</option>
                	    <option value="Time & Materiales">{{ __('projects.time_presales') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required engagement-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.estimated_revenue') }}</label>
                	<input type="text" class="md-input" name="estimated_revenue"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_revenue-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.estimated_cost') }}</label>
                	<input type="text" class="md-input" name="estimated_cost"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_cost-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.estimated_margin') }}</label>
                	<input type="text" class="md-input" name="estimated_margin"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_margin-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.estimated_department_margin') }}</label>
                	<input type="text" class="md-input" name="estimated_department_margin"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_department_margin-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.target_margin') }}</label>
                	<input type="text" class="md-input" name="target_margin"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required target_margin-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.financial_deviation_threshold') }}</label>
                	<input type="text" class="md-input" name="financial_deviation_threshold"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required financial_deviation_threshold-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('projects.time_deviation_threshold') }}</label>
                	<input type="text" class="md-input" name="time_deviation_threshold"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required time_deviation_threshold-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.department') }}</label>
                	<select name="department_id" data-md-selectize>
                	    <option value="">{{ __('projects.department') }}...</option>
                	    @foreach ($departments as $department)
                	        <option value="{{ $department->id }}">{{ $department->title }} ({{ $department->office->data->title }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required department_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('projects.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

