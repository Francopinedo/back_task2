<style>

    #edit_div.switcher_active {
        width: 50%;
    }

</style>   
    	<form role="form" method="POST" action="{{ url('requirements/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('requirements') }}">

 <div class="uk-grid" data-uk-grid-margin>
    		<li class="uk-width-medium-1-1 uk-row-first">
		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
</li>
    	    {{ csrf_field() }}

			<input type="hidden" name="id" value="{{ $requirement->id }}">
    		<li class="uk-width-medium-1-2 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('requirements.description') }}</label>
                	<input type="text" class="md-input" name="description" value="{{ $requirement->description }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('requirements.type') }}</label>
                	<select name="type" data-md-selectize>
                	    <option value="project" {{ ($requirement->type = 'project') ? 'selected' : '' }}>{{ __('requirements.type_project') }}...</option>
                	    <option value="product" {{ ($requirement->type = 'product') ? 'selected' : '' }}>{{ __('requirements.type_product') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required type-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('requirements.request_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="request_date" value="{{ $requirement->request_date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required request_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('requirements.status_comment') }}</label>
                	<input type="text" class="md-input" name="status_comment" value="{{ $requirement->status_comment }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required status_comment-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('requirements.due_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="due_date" value="{{ $requirement->due_date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('requirements.responsable') }}</label>
                	<select name="owner_id" data-md-selectize>
                	    <option value="">{{ __('requirements.responsable') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}" {{ ($user->id == $requirement->owner_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required owner_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('requirements.priority') }}</label>
                	<select name="priority" data-md-selectize>
                	    <option value="1" {{ ($requirement->priority = '1') ? 'selected' : '' }}>{{ __('requirements.priority_1') }}...</option>
                	    <option value="2" {{ ($requirement->priority = '2') ? 'selected' : '' }}>{{ __('requirements.priority_2') }}...</option>
                	    <option value="3" {{ ($requirement->priority = '3') ? 'selected' : '' }}>{{ __('requirements.priority_3') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required priority-error"></span></div>
</li>
	<li class="uk-width-medium-1-2 uk-row-first">

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('requirements.business_value') }}</label>
                	<select name="business_value" data-md-selectize>
                	    <option value="1" {{ ($requirement->business_value = '1') ? 'selected' : '' }}>{{ __('requirements.business_value_1') }}...</option>
                	    <option value="2" {{ ($requirement->business_value = '2') ? 'selected' : '' }}>{{ __('requirements.business_value_2') }}...</option>
                	    <option value="3" {{ ($requirement->business_value = '3') ? 'selected' : '' }}>{{ __('requirements.business_value_3') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required business_value-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('requirements.requester_name') }}</label>
                	<input type="text" class="md-input" name="requester_name" value="{{ $requirement->requester_name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required requester_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('requirements.requester_email') }}</label>
                	<input type="text" class="md-input" name="requester_email" value="{{ $requirement->requester_email }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required requester_email-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('requirements.requester_type') }}</label>
                    <div class="md-input-wrapper">
                        <label>{{ __('requirements.requester_type') }}</label>

                        <select class="md-input"  data-md-selectize  name="requester_type">
                            <option {{ $requirement->requester_type=='INTERNAL'?'selected':'' }} value="INTERNAL">Internal</option>
                            <option {{ $requirement->requester_type=='EXTERNAL'?'selected':'' }} value="EXTERNAL">External</option>
                        </select>
                    </div>


                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required requester_type-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('requirements.approval_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="approval_date" value="{{ $requirement->approval_date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required approval_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('requirements.approver_name') }}</label>
                	<input type="text" class="md-input" name="approver_name" value="{{ $requirement->approver_name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required approver_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('requirements.comment') }}</label>
                	<input type="text" class="md-input" name="comment" value="{{ $requirement->comment }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>
</li>
	<li class="uk-width-medium-1-1 uk-row-first">

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('requirements.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </li>

</div>
    	</form>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
</script>
