<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('stakeholders/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('stakeholders') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $stakeholder->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('stakeholders.contact') }}</label>
    				<select name="contact_id" data-md-selectize>
    				    <option value="">{{ __('stakeholders.contact') }}...</option>
    				    @foreach ($contacts as $contact)
    				        <option value="{{ $contact->id }}" {{ ($contact->id == $stakeholder->contact_id) ? 'selected' : '' }}>{{ $contact->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required contact_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('stakeholders.influence') }}</label>
    				<select name="influence" data-md-selectize>
    				    <option value="">{{ __('stakeholders.influence') }}...</option>
    				    <option value="high" {{ ($stakeholder->influence == 'high') ? 'selected' : '' }}>{{ __('stakeholders.high') }}</option>
    				    <option value="medium" {{ ($stakeholder->influence == 'medium') ? 'selected' : '' }}>{{ __('stakeholders.medium') }}</option>
    				    <option value="low" {{ ($stakeholder->influence == 'low') ? 'selected' : '' }}>{{ __('stakeholders.low') }}</option>
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required influence-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('stakeholders.impacted') }}</label>
                	<input type="text" class="md-input" name="impacted" value="{{ $stakeholder->impacted }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required impacted-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('stakeholders.impact') }}</label>
                	<input type="text" class="md-input" name="impact" value="{{ $stakeholder->impact }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required impact-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('stakeholders.expectations') }}</label>
                	<input type="text" class="md-input" name="expectations" value="{{ $stakeholder->expectations }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required expectations-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('stakeholders.update') }}</a>
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