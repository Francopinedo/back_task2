<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('procurements') }}" id="data-form" data-redirect-on-success="{{ url('procurements') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="project_id" value="{{ session('project_id') }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('procurements.internal_or_external') }}</label>
                	<select name="type" data-md-selectize>
                	    <option value="internal">{{ __('procurements.internal') }}...</option>
                	    <option value="external">{{ __('procurements.external') }}...</option>
                	    <option value="any">{{ __('procurements.any') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required type-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('procurements.date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.description') }}</label>
                	<input type="text" class="md-input" name="description" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.specifications') }}</label>
                	<input type="text" class="md-input" name="specifications" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required specifications-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.approver_name') }}</label>
                	<input type="text" class="md-input" name="approver_name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required approver_name-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.responsable') }}</label>
                	<select name="responsable_id" data-md-selectize>
                	    <option value="">{{ __('procurements.responsable') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}">{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required responsable_id-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('procurements.due_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="due_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.cost') }}</label>
                	<input type="text" class="md-input" name="cost" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.currency') }}</label>
                	<select name="cost_currency_id" data-md-selectize>
                	    <option value="">{{ __('procurements.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.quality') }}</label>
                	<select name="quality_required" data-md-selectize>
                	    <option value="1">{{ __('procurements.quality_1') }}...</option>
                	    <option value="2">{{ __('procurements.quality_2') }}...</option>
                	    <option value="3">{{ __('procurements.quality_3') }}...</option>
                	    <option value="4">{{ __('procurements.quality_4') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality_required-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.contract_status') }}</label>
                	<select name="contract_status" data-md-selectize>
                	    <option value="starting">{{ __('procurements.starting') }}...</option>
                	    <option value="running">{{ __('procurements.running') }}...</option>
                	    <option value="standby">{{ __('procurements.standby') }}...</option>
                	    <option value="finished">{{ __('procurements.finished') }}...</option>
                	    <option value="other">{{ __('procurements.other') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required contract_status-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.provider') }}</label>
                	<select name="provider_id" data-md-selectize>
                	    <option value="">{{ __('procurements.provider') }}...</option>
                	    @foreach ($providers as $provider)
                	        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required provider_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.provider_feedback') }}</label>
                	<select name="provider_feedback" data-md-selectize>
                	    <option value="1">{{ __('procurements.provider_1') }}...</option>
                	    <option value="2">{{ __('procurements.provider_2') }}...</option>
                	    <option value="3">{{ __('procurements.provider_3') }}...</option>
                	    <option value="4">{{ __('procurements.provider_4') }}...</option>
                	    <option value="5">{{ __('procurements.provider_5') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality_required-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.delivery') }}</label>
                	<input type="text" class="md-input" name="delivery" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.quality') }}</label>
                	<input type="text" class="md-input" name="quality" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.overallscore') }}</label>
                	<select name="overallscore" data-md-selectize>
                	    <option value="1">{{ __('procurements.score_1') }}...</option>
                	    <option value="2">{{ __('procurements.score_2') }}...</option>
                	    <option value="3">{{ __('procurements.score_3') }}...</option>
                	    <option value="4">{{ __('procurements.score_4') }}...</option>
                	    <option value="5">{{ __('procurements.score_5') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality_required-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.requirement_status') }}</label>
                	<select name="requirement_status" data-md-selectize>
                	    <option value="starting">{{ __('procurements.starting') }}...</option>
                	    <option value="running">{{ __('procurements.running') }}...</option>
                	    <option value="standby">{{ __('procurements.standby') }}...</option>
                	    <option value="finished">{{ __('procurements.finished') }}...</option>
                	    <option value="other">{{ __('procurements.other') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required requirement_status-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('procurements.delivered_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="delivered_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivered_date-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('cities.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

