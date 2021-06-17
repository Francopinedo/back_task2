<style>

    #edit_div.switcher_active {
        width: 40%;
    }

</style> 
    <form role="form" method="POST" action="{{ url('agendas/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('agendas') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $agenda->id }}">

<div class="uk-grid" data-uk-grid-margin>
            <li class="uk-width-medium-1-1 uk-row-first">
        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
</li>

	   
    		<li class="uk-width-medium-1-2 uk-row-first">

                <div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('agendas.project') }}</label>
    				<select name="project_id" data-md-selectize>
    				    <option value="">{{ __('agendas.project') }}...</option>
    				    @foreach ($projects as $project)
    				        <option value="{{ $project->id }}" {{ ($project->id == $agenda->project_id) ? 'selected' : '' }}>{{ $project->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required project_id-error"></span></div>

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('agendas.knowledge_area') }}</label>
    				<select name="knowledge_area" data-md-selectize>
    				    <option value="">{{ __('agendas.knowledge_area') }}...</option>
    				    <option value="Startup-Up & Integration Management" {{ ($agenda->knowledge_area == 'Startup-Up & Integration Management') ? 'selected' : '' }}>Startup-Up & Integration Management</option>
    				    <option value="Scope Management" {{ ($agenda->knowledge_area == 'Scope Management') ? 'selected' : '' }}>Scope Management</option>
    				    <option value="Time Management" {{ ($agenda->knowledge_area == 'Time Management') ? 'selected' : '' }}>Time Management</option>
    				    <option value="Cost Management" {{ ($agenda->knowledge_area == 'Cost Management') ? 'selected' : '' }}>Cost Management</option>
    				    <option value="Quality Management" {{ ($agenda->knowledge_area == 'Quality Management') ? 'selected' : '' }}>Quality Management</option>
    				    <option value="Human Resource Management" {{ ($agenda->knowledge_area == 'Human Resource Management') ? 'selected' : '' }}>Human Resource Management</option>
    				    <option value="Communications Management" {{ ($agenda->knowledge_area == 'Communications Management') ? 'selected' : '' }}>Communications Management</option>
    				    <option value="StakeHolder Management" {{ ($agenda->knowledge_area == 'StakeHolder Management') ? 'selected' : '' }}>StakeHolder Management</option>
    				    <option value="Risk Management" {{ ($agenda->knowledge_area == 'Risk Management') ? 'selected' : '' }}>Risk Management</option>
    				    <option value="Procurement Management" {{ ($agenda->knowledge_area == 'Procurement Management') ? 'selected' : '' }}>Procurement Management</option>
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required knowledge_area-error"></span></div>

                
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('agendas.description') }}</label>
                	<input type="text" class="md-input" name="description" value="{{ $agenda->description }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>
</li>
            <li class="uk-width-medium-1-2 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('agendas.start') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="start" value="{{ $agenda->start }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('agendas.status') }}</label>
    				<select name="status" data-md-selectize>
    				    <option value="">{{ __('agendas.status') }}...</option>
    				    <option value="Open" {{ ($agenda->status == 'Open') ? 'selected' : '' }}>Open</option>
    				    <option value="Pending Internal" {{ ($agenda->status == 'Pending Internal') ? 'selected' : '' }}>Pending Internal</option>
    				    <option value="Pending External" {{ ($agenda->status == 'Pending External') ? 'selected' : '' }}>Pending External</option>
    				    <option value="In Progress" {{ ($agenda->status == 'In Progress') ? 'selected' : '' }}>In Progress</option>
    				    <option value="Done" {{ ($agenda->status == 'Done') ? 'selected' : '' }}>Done</option>
    				    <option value="Closed" {{ ($agenda->status == 'Closed') ? 'selected' : '' }}>Closed</option>
    				    <option value="Cancelled" {{ ($agenda->status == 'Cancelled') ? 'selected' : '' }}>Cancelled</option>
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>

    			<div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('agendas.due') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="due" value="{{ $agenda->due }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due-error"></span></div>

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('agendas.owner') }}</label>
    				<select name="owner_id" data-md-selectize>
    				    <option value="">{{ __('agendas.owner') }}...</option>
    				    @foreach ($users as $owner)
    				        <option value="{{ $owner->id }}" {{ ($owner->id == $agenda->owner_id) ? 'selected' : '' }}>{{ $owner->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required owner_id-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('requirements.priority') }}</label>
                    <select name="owner_id" data-md-selectize>
                        <option value="0">{{ __('requirements.priority') }}...</option>
                       
                            <option {{$agenda->priority==1?'selected':''}} value="1">{{ __('requirements.priority_1')}}</option>
                            <option {{$agenda->priority==2?'selected':''}}  value="2">{{ __('requirements.priority_2')}}</option>
                            <option {{$agenda->priority==3?'selected':''}}  value="3">{{ __('requirements.priority_3')}}</option>
                       
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required priority-error"></span></div>


               <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('agendas.detail') }}</label>
                 <textarea cols="30" rows="4" name="detail" class="md-input autosized" style="overflow-x: hidden; word-wrap: break-word; height: 180px;" title="{{ __('agendas.detail') }}">{{ $agenda->detail }}</textarea>
			<span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>
</li>       
        <li class="uk-width-medium-1-1 uk-row-first">
				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('agendas.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </li>

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
