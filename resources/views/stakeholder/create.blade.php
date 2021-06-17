<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('stakeholders') }}" id="data-form" data-redirect-on-success="{{ url($url) }}">
    	    {{ csrf_field() }}
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('stakeholders.contact') }}</label>
    				<select name="contact_id" data-md-selectize>
    				    <option value="">{{ __('stakeholders.contact') }}...</option>
    				    @foreach ($contacts as $contact)
    				        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required contact_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('stakeholders.influence') }}</label>
    				<select name="influence" data-md-selectize>
    				    <option value="">{{ __('stakeholders.influence') }}...</option>
    				    <option value="high">{{ __('stakeholders.high') }}</option>
    				    <option value="medium">{{ __('stakeholders.medium') }}</option>
    				    <option value="low">{{ __('stakeholders.low') }}</option>
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required influence-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('stakeholders.impacted') }}</label>
                	<input type="text" class="md-input" name="impacted" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required impacted-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('stakeholders.impact') }}</label>
                	<input type="text" class="md-input" name="impact" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required impact-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('stakeholders.expectations') }}</label>
                	<input type="text" class="md-input" name="expectations" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required expectations-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('stakeholders.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

