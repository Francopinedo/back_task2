<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('ticket_history/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('tickets/'.$ticketHistory->ticket_id.'/history') }}">
    	    {{ csrf_field() }}

			<input type="hidden" name="id" value="{{ $ticketHistory->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled">
                    <label>{{ __('ticket_histories.date') }}</label>
                    <input class="md-input" type="text" id="date" name="date" value="{{ $ticketHistory->date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<select name="owner_id" data-md-selectize>
                	    <option value="">{{ __('tickets.assignee') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}" {{ ($user->id == $ticketHistory->owner_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required owner_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<select name="internal_or_external" data-md-selectize>
                	    <option value="internal" {{ ($ticketHistory->internal_or_external == 'internal') ? 'selected' : '' }}>{{ __('ticket_histories.internal') }}...</option>
                	    <option value="external" {{ ($ticketHistory->internal_or_external == 'external') ? 'selected' : '' }}>{{ __('ticket_histories.external') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required internal_or_external-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('tickets.comment') }}</label>
                	<input type="text" class="md-input" name="comment" value="{{ $ticketHistory->comment }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('requirements.update') }}</a>
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