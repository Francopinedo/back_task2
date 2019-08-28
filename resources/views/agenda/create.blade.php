<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('agendas') }}" id="data-form" data-redirect-on-success="{{ url('agendas') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">
    	    <input type="hidden" name="creator_id" value="{{ Auth::id() }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('agendas.project') }}</label>
    				<select name="project_id" data-md-selectize>
    				    <option value="">{{ __('agendas.project') }}...</option>
    				    @foreach ($projects as $project)
    				        <option value="{{ $project->id }}">{{ $project->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required project_id-error"></span></div>

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('agendas.knowledge_area') }}</label>
    				<select name="knowledge_area" data-md-selectize>
    				    <option value="">{{ __('agendas.knowledge_area') }}...</option>
    				    <option value="Startup-Up & Integration Management">Startup-Up & Integration Management</option>
    				    <option value="Scope Management">Scope Management</option>
    				    <option value="Time Management">Time Management</option>
    				    <option value="Cost Management">Cost Management</option>
    				    <option value="Quality Management">Quality Management</option>
    				    <option value="Human Resource Management">Human Resource Management</option>
    				    <option value="Communications Management">Communications Management</option>
    				    <option value="StakeHolder Management">StakeHolder Management</option>
    				    <option value="Risk Management">Risk Management</option>
    				    <option value="Procurement Management">Procurement Management</option>
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required knowledge_area-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('agendas.item_number') }}</label>
                	<input type="number" class="md-input" name="item_number" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required item_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('agendas.description') }}</label>
                	<input type="text" class="md-input" name="description" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('agendas.start') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="start" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('agendas.status') }}</label>
    				<select name="status" data-md-selectize>
    				    <option value="">{{ __('agendas.status') }}...</option>
    				    <option value="Open">Open</option>
    				    <option value="Pending Internal">Pending Internal</option>
    				    <option value="Pending External">Pending External</option>
    				    <option value="In Progress">In Progress</option>
    				    <option value="Done">Done</option>
    				    <option value="Closed">Closed</option>
    				    <option value="Cancelled">Cancelled</option>
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>

    			<div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('agendas.due') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="due" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due-error"></span></div>

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('agendas.owner') }}</label>
    				<select name="owner_id" data-md-selectize>
    				    <option value="">{{ __('agendas.owner') }}...</option>
    				    @foreach ($users as $owner)
    				        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required owner_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('agendas.detail') }}</label>
                	<input type="text" class="md-input" name="detail" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('agendas.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

