<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('ticket_history') }}" id="data-form" data-redirect-on-success="{{ url('tickets/'.$ticket->id.'/history') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper">
                    <label>{{ __('ticket_histories.date') }}</label>
                    <input class="md-input" type="text" id="date" name="date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="owner_id" data-md-selectize>
                	    <option value="">{{ __('tickets.assignee') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}">{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required owner_id-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="internal_or_external" data-md-selectize>
                	    <option value="internal">{{ __('ticket_histories.internal') }}...</option>
                	    <option value="external">{{ __('ticket_histories.external') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required internal_or_external-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tickets.comment') }}</label>
                	<input type="text" class="md-input" name="comment" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('cities.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

