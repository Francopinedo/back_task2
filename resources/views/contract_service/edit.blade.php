<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('contract_services/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('contract/rows/'.$contractService->contract_id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $contractService->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper">
                	<select name="service_id" id="service_id" data-md-selectize>
                	    <option value="">{{ __('contracts.service') }}...</option>
                	    @foreach ($services as $service)
                	        <option value="{{ $service->id }}" {{ ($service->id == $contractService->service_id) ? 'selected' : '' }}>{{ $service->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required expense_id-error"></span></div>

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" value="{{ $contractService->detail }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="reimbursable" id="reimbursable" data-md-selectize>
                	    <option value="1">{{ __('services.reimbursable') }}</option>
                	    <option value="0">{{ __('services.no_reimbursable') }}</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required reimbursable-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="servicecost" value="{{ $contractService->cost }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>


				<div class="md-input-wrapper md-input-filled">
					<label>{{ __('contracts.amount') }}</label>
					<input type="text" class="md-input" name="amount" id="serviceamount" value="{{ $contractService->amount }}" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>


				<div class="md-input-wrapper md-input-filled">
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('contracts.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $contractService->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


				<div class="md-input-wrapper">
					<select name="frequency" id="frequency" required data-md-selectize>
						<option value="">{{ __('contracts.frequency') }}...</option>
						<option value="anualy" {{ ( $contractService->frequency == 'anualy') ? 'selected' : '' }}>{{ __('contracts.anualy') }}</option>
						<option value="semester" {{ ( $contractService->frequency == 'semester') ? 'selected' : '' }}>{{ __('contracts.semester') }}</option>
						<option value="quarterly" {{ ( $contractService->frequency == 'quarterly') ? 'selected' : '' }}>{{ __('contracts.quarterly') }}</option>
						<option value="bimonthly" {{ ( $contractService->frequency == 'bimonthly') ? 'selected' : '' }}>{{ __('contracts.bimonthly') }}</option>
						<option value="monthly" {{ ( $contractService->frequency == 'monthly') ? 'selected' : '' }}>{{ __('contracts.monthly') }}</option>
						<option value="weekly" {{ ( $contractService->frequency == 'weekly') ? 'selected' : '' }}>{{ __('contracts.weekly') }}</option>

					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required frequency-error"></span></div>



				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('contracts.update') }}</a>
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
    contracts.initServices();
    altair_forms.init();
</script>