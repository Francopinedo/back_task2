<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('tickets') }}" id="data-form" data-redirect-on-success="{{ url('tasks/'.$task->id.'/tickets') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="task_id" value="{{ $task->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.description') }}</label>
                	<input type="text" class="md-input" name="description" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="description-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="type" data-md-selectize>
                	    <option value="1">{{ __('tickets.type_1') }}...</option>
                	    <option value="2">{{ __('tickets.type_2') }}...</option>
                	    <option value="3">{{ __('tickets.type_3') }}...</option>
                	    <option value="4">{{ __('tickets.type_4') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="type-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="assignee_id" data-md-selectize>
                	    <option value="">{{ __('tickets.assignee') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}">{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="assignee_id-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="status" data-md-selectize>
                	    <option value="1">{{ __('tickets.status_1') }}...</option>
                	    <option value="2">{{ __('tickets.status_2') }}...</option>
                	    <option value="3">{{ __('tickets.status_3') }}...</option>
                	    <option value="4">{{ __('tickets.status_4') }}...</option>
                	    <option value="5">{{ __('tickets.status_5') }}...</option>
                	    <option value="6">{{ __('tickets.status_6') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="status-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="group" data-md-selectize>
                	    <option value="1">{{ __('tickets.group_1') }}...</option>
                	    <option value="2">{{ __('tickets.group_2') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="group-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.sprint') }}</label>
                	<input type="text" class="md-input" name="sprint" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="sprint-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tasks.due_date') }}</label>
                    <input class="md-input" type="text" id="due_date" name="due_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="due_date-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="requester_name" data-md-selectize>
                	    <option value="">{{ __('tickets.requester') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->name }}">{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="requester_name-error"></span></div>

                <input type="hidden" name="requester_email" value="">
                <input type="hidden" name="requester_type" value="team">

                <div class="md-input-wrapper">
                	<select name="priority" data-md-selectize>
                	    <option value="1">{{ __('tickets.priority_1') }}...</option>
                	    <option value="2">{{ __('tickets.priority_2') }}...</option>
                	    <option value="3">{{ __('tickets.priority_3') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="priority-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="severity" data-md-selectize>
                	    <option value="1">{{ __('tickets.severity_1') }}...</option>
                	    <option value="2">{{ __('tickets.severity_2') }}...</option>
                	    <option value="3">{{ __('tickets.severity_3') }}...</option>
                	    <option value="4">{{ __('tickets.severity_4') }}...</option>
                	    <option value="5">{{ __('tickets.severity_5') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="severity-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="probability" data-md-selectize>
                	    <option value="1">{{ __('tickets.probability_1') }}...</option>
                	    <option value="2">{{ __('tickets.probability_2') }}...</option>
                	    <option value="3">{{ __('tickets.probability_3') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="probability-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="impact" data-md-selectize>
                	    <option value="1">{{ __('tickets.impact_1') }}...</option>
                	    <option value="2">{{ __('tickets.impact_2') }}...</option>
                	    <option value="3">{{ __('tickets.impact_3') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="impact-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.version') }}</label>
                	<input type="text" class="md-input" name="version" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="version-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.release') }}</label>
                	<input type="text" class="md-input" name="release" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="release-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.estimated_hours') }}</label>
                	<input type="number" class="md-input" name="estimated_hours" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="estimated_hours-error"></span></div>

				<div class="md-input-wrapper">
                	<label>{{ __('tickets.burned_hours') }}</label>
                	<input type="number" class="md-input" name="burned_hours" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="burned_hours-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.story_points') }}</label>
                	<input type="number" class="md-input" name="story_points" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="story_points-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tasks.approval_date') }}</label>
                    <input class="md-input" type="text" id="approval_date" name="approval_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="approval_date-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.approver_name') }}</label>
                	<input type="text" class="md-input" name="approver_name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="approver_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.acceptance_criteria') }}</label>
                	<input type="text" class="md-input" name="acceptance_criteria" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="acceptance_criteria-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.testing_name') }}</label>
                	<input type="text" class="md-input" name="testing_name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="testing_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.done_name') }}</label>
                	<input type="text" class="md-input" name="done_name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="done_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.label') }}</label>
                	<input type="text" class="md-input" name="label" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="label-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.comment') }}</label>
                	<input type="text" class="md-input" name="comment" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="comment-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="owner_id" data-md-selectize>
                	    <option value="">{{ __('tickets.owner') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}">{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required" id="owner_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('cities.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

