<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('projects/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('projects') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $project->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.name') }}</label>
                	<input type="text" class="md-input" name="name" value="{{ $project->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.customer') }}</label>
                	<select name="customer_id" data-md-selectize>
                	    <option value="">{{ __('projects.customer') }}...</option>
                	    @foreach ($customers as $customer)
                	        <option value="{{ $customer->id }}" {{ ($customer->id == $project->customer_id) ? 'selected' : '' }}>{{ $customer->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.customer_name') }}</label>
                	<input type="text" class="md-input" name="customer_name" value="{{ $project->customer_name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('projects.start') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="start" value="{{ $project->start }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('projects.finish') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="finish" value="{{ $project->finish }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required finish-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.project_manager') }}</label>
                	<select name="project_manager_id" data-md-selectize>
                	    <option value="">{{ __('projects.project_manager') }}...</option>
                	    @foreach ($users as $pm)
                	        <option value="{{ $pm->id }}" {{ ($pm->id == $project->project_manager_id) ? 'selected' : '' }}>{{ $pm->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_manager_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.technical_director') }}</label>
                	<select name="technical_director_id" data-md-selectize>
                	    <option value="">{{ __('projects.technical_director') }}...</option>
                	    @foreach ($users as $pm)
                	        <option value="{{ $pm->id }}" {{ ($pm->id == $project->technical_director_id) ? 'selected' : '' }}>{{ $pm->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required technical_director_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.delivery_manager') }}</label>
                	<select name="delivery_manager_id" data-md-selectize>
                	    <option value="">{{ __('projects.delivery_manager') }}...</option>
                	    @foreach ($users as $pm)
                	        <option value="{{ $pm->id }}" {{ ($pm->id == $project->delivery_manager_id) ? 'selected' : '' }}>{{ $pm->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery_manager_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.sow_number') }}</label>
                	<input type="text" class="md-input" name="sow_number" value="{{ $project->sow_number }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sow_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.identificator') }}</label>
                	<input type="text" class="md-input" name="identificator" value="{{ $project->identificator }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required identificator-error"></span></div>

				<div class="md-input-wrapper md-input-filled md-input-select">
					<label>{{ __('projects.status') }}</label>
                	<select name="status" data-md-selectize>
                	    <option value="">{{ __('projects.status') }}...</option>
                	    <option value="initiating" {{ ($project->status == 'initiating') ? 'selected' : '' }}>{{ __('projects.initiating') }}...</option>
                	    <option value="planning" {{ ($project->status == 'planning') ? 'selected' : '' }}>{{ __('projects.planning') }}...</option>
                	    <option value="executing" {{ ($project->status == 'executing') ? 'selected' : '' }}>{{ __('projects.executing') }}...</option>
                	    <option value="closing" {{ ($project->status == 'closing') ? 'selected' : '' }}>{{ __('projects.closing') }}...</option>
                	    <option value="waiting" {{ ($project->status == 'waiting') ? 'selected' : '' }}>{{ __('projects.waiting') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.presales_responsable') }}</label>
                	<input type="text" class="md-input" name="presales_responsable" value="{{ $project->presales_responsable }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required presales_responsable-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.technical_estimator') }}</label>
                	<input type="text" class="md-input" name="technical_estimator" value="{{ $project->technical_estimator }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required technical_estimator-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.status') }}</label>
                	<select name="status" data-md-selectize>
                	    <option value="">{{ __('projects.status') }}...</option>
                	    <option value="Staff Augmentation" {{ ($project->status == 'Staff Augmentation') ? 'selected' : '' }}>{{ __('projects.staff_argumentation') }}...</option>
                	    <option value="Time & Materiales" {{ ($project->status == 'Time & Materiales') ? 'selected' : '' }}>{{ __('projects.time_materials') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.estimated_revenue') }}</label>
                	<input type="text" class="md-input" name="estimated_revenue" value="{{ $project->estimated_revenue }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_revenue-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.estimated_cost') }}</label>
                	<input type="text" class="md-input" name="estimated_cost" value="{{ $project->estimated_cost }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_cost-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.estimated_margin') }}</label>
                	<input type="text" class="md-input" name="estimated_margin" value="{{ $project->estimated_margin }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_margin-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.estimated_department_margin') }}</label>
                	<input type="text" class="md-input" name="estimated_department_margin" value="{{ $project->estimated_department_margin }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_department_margin-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.target_margin') }}</label>
                	<input type="text" class="md-input" name="target_margin" value="{{ $project->target_margin }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required target_margin-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.financial_deviation_threshold') }}</label>
                	<input type="text" class="md-input" name="financial_deviation_threshold" value="{{ $project->financial_deviation_threshold }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required financial_deviation_threshold-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.time_deviation_threshold') }}</label>
                	<input type="text" class="md-input" name="time_deviation_threshold" value="{{ $project->time_deviation_threshold }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required time_deviation_threshold-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.department') }}</label>
                	<select name="department_id" data-md-selectize>
                	    <option value="">{{ __('projects.department') }}...</option>
                	    @foreach ($departments as $department)
                	        <option value="{{ $department->id }}" {{ ($department->id == $project->department_id) ? 'selected' : '' }}>{{ $department->title }} ({{ $department->office->data->title }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required department_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('projects.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
</script>