<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('procurements/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('procurements') }}">
    	    {{ csrf_field() }}

			<input type="hidden" name="id" value="{{ $procurement->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.internal_or_external') }}</label>
                	<select name="type" data-md-selectize>
                	    <option value="internal" {{ ($procurement->type == 'internal') ? 'selected' : '' }}>{{ __('procurements.internal') }}...</option>
                	    <option value="external" {{ ($procurement->type == 'external') ? 'selected' : '' }}>{{ __('procurements.external') }}...</option>
                	    <option value="any" {{ ($procurement->type == 'any') ? 'selected' : '' }}>{{ __('procurements.any') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required type-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('procurements.date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="date" value="{{ $procurement->date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.description') }}</label>
                	<input type="text" class="md-input" name="description" value="{{ $procurement->description }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.specifications') }}</label>
                	<input type="text" class="md-input" name="specifications" value="{{ $procurement->specifications }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required specifications-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.approver_name') }}</label>
                	<input type="text" class="md-input" name="approver_name" value="{{ $procurement->approver_name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required approver_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.responsable') }}</label>
                	<select name="responsable_id" data-md-selectize>
                	    <option value="">{{ __('procurements.responsable') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}" {{ ($procurement->responsable_id == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required responsable_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('procurements.due_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="due_date" value="{{ $procurement->due_date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.cost') }}</label>
                	<input type="text" class="md-input" name="cost" value="{{ $procurement->cost }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.currency') }}</label>
                	<select name="cost_currency_id" data-md-selectize>
                	    <option value="">{{ __('procurements.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($procurement->cost_currency_id == $currency->id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.quality_required') }}</label>
                	<select name="quality_required" data-md-selectize>
                	    <option value="1" {{ ($procurement->quality_required == '1') ? 'selected' : '' }}>{{ __('procurements.quality_1') }}...</option>
                	    <option value="2" {{ ($procurement->quality_required == '2') ? 'selected' : '' }}>{{ __('procurements.quality_2') }}...</option>
                	    <option value="3" {{ ($procurement->quality_required == '3') ? 'selected' : '' }}>{{ __('procurements.quality_3') }}...</option>
                	    <option value="4" {{ ($procurement->quality_required == '4') ? 'selected' : '' }}>{{ __('procurements.quality_4') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality_required-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.contract_status') }}</label>
                	<select name="contract_status" data-md-selectize>
                	    <option value="starting" {{ ($procurement->contract_status == 'starting') ? 'selected' : '' }}>{{ __('procurements.starting') }}...</option>
                	    <option value="running" {{ ($procurement->contract_status == 'running') ? 'selected' : '' }}>{{ __('procurements.running') }}...</option>
                	    <option value="standby" {{ ($procurement->contract_status == 'standby') ? 'selected' : '' }}>{{ __('procurements.standby') }}...</option>
                	    <option value="finished" {{ ($procurement->contract_status == 'finished') ? 'selected' : '' }}>{{ __('procurements.finished') }}...</option>
                	    <option value="other" {{ ($procurement->contract_status == 'other') ? 'selected' : '' }}>{{ __('procurements.other') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required contract_status-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.provider') }}</label>
                	<select name="provider_id" data-md-selectize>
                	    <option value="">{{ __('procurements.provider') }}...</option>
                	    @foreach ($providers as $provider)
                	        <option value="{{ $provider->id }}" {{ ($procurement->provider_id == $provider->id) ? 'selected' : '' }}>{{ $provider->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required provider_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.provider_feedback') }}</label>
                	<select name="provider_feedback" data-md-selectize>
                	    <option value="1" {{ ($procurement->provider_feedback == '1') ? 'selected' : '' }}>{{ __('procurements.score_1') }}...</option>
                	    <option value="2" {{ ($procurement->provider_feedback == '2') ? 'selected' : '' }}>{{ __('procurements.provider_2') }}...</option>
                	    <option value="3" {{ ($procurement->provider_feedback == '3') ? 'selected' : '' }}>{{ __('procurements.provider_3') }}...</option>
                	    <option value="4" {{ ($procurement->provider_feedback == '4') ? 'selected' : '' }}>{{ __('procurements.provider_4') }}...</option>
                	    <option value="5" {{ ($procurement->provider_feedback == '5') ? 'selected' : '' }}>{{ __('procurements.provider_5') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality_required-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.delivery') }}</label>
                	<input type="text" class="md-input" name="delivery" value="{{ $procurement->delivery }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.quality') }}</label>
                	<input type="text" class="md-input" name="quality" value="{{ $procurement->quality }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.overallscore') }}</label>
                	<select name="overallscore" data-md-selectize>
                	    <option value="1" {{ ($procurement->overallscore == '1') ? 'selected' : '' }}>{{ __('procurements.score_1') }}...</option>
                	    <option value="2" {{ ($procurement->overallscore == '2') ? 'selected' : '' }}>{{ __('procurements.score_2') }}...</option>
                	    <option value="3" {{ ($procurement->overallscore == '3') ? 'selected' : '' }}>{{ __('procurements.score_3') }}...</option>
                	    <option value="4" {{ ($procurement->overallscore == '4') ? 'selected' : '' }}>{{ __('procurements.score_4') }}...</option>
                	    <option value="5" {{ ($procurement->overallscore == '5') ? 'selected' : '' }}>{{ __('procurements.score_5') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality_required-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.requirement_status') }}</label>
                	<select name="requirement_status" data-md-selectize>
                	    <option value="starting" {{ ($procurement->requirement_status == 'starting') ? 'selected' : '' }}>{{ __('procurements.starting') }}...</option>
                	    <option value="running" {{ ($procurement->requirement_status == 'running') ? 'selected' : '' }}>{{ __('procurements.running') }}...</option>
                	    <option value="standby" {{ ($procurement->requirement_status == 'standby') ? 'selected' : '' }}>{{ __('procurements.standby') }}...</option>
                	    <option value="finished" {{ ($procurement->requirement_status == 'finished') ? 'selected' : '' }}>{{ __('procurements.finished') }}...</option>
                	    <option value="other" {{ ($procurement->requirement_status == 'other') ? 'selected' : '' }}>{{ __('procurements.other') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required requirement_status-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('procurements.delivered_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="delivered_date" value="{{ $procurement->delivered_date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivered_date-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('procurements.update') }}</a>
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