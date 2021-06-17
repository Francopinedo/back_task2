<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('project_debit_credit/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('project_board/project_rows') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $DebitCredit->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    		
                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.debit_credit_code') }}</label>
                    <select name="code" id="code" data-md-selectize>
                        <option value="">{{ __('projects.debit_credit_codes') }}...</option>
                        
                        <option value="proffesional hours" {{ ($DebitCredit->code=='proffesional')? 'selected':'' }}>Proffesional Hours</option>
                       <option value="services" {{ ($DebitCredit->code=='services')? 'selected':'' }}>Services</option>
                         <option value="materials" {{ ($DebitCredit->code=='materials')? 'selected':'' }} >Materials</option>
                       <option value="others" {{ ($DebitCredit->code=='others')? 'selected':'' }}>Others</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required code-error"></span></div>

         <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('projects.debit_credit_date') }}</label>
                    <input class="md-input"  required type="text" id="uk_dp_1" value="{{ $DebitCredit->date }}" name="date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>


    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" value="{{ $DebitCredit->detail }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

              
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="materialcost" value="{{ $DebitCredit->cost }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>


				<div class="md-input-wrapper md-input-filled">
					<label>{{ __('projects.amount') }}</label>
					<input type="text" class="md-input" name="amount" id="materialamount" value="{{ $DebitCredit->amount }}" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

                  <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.signs') }}</label>
                    <select name="signs" id="signs" data-md-selectize>
                        <option value="">{{ __('projects.signs') }}...</option>
                        
                            <option value="+" {{ ($DebitCredit->signs=='+')? 'selected':'' }}>+</option>
                       <option value="-"  {{ ($DebitCredit->signs=='-')? 'selected':''}}>-</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required signs-error"></span></div>


				<div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.currency') }}</label>
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('projects.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $DebitCredit->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


				<div class="md-input-wrapper">
					<select name="frequency" id="frequency" required data-md-selectize>
						<option value="">{{ __('contracts.frequency') }}...</option>
						<option value="anualy" {{ ( $DebitCredit->frequency == 'anualy') ? 'selected' : '' }}>{{ __('contracts.anualy') }}</option>
						<option value="semester" {{ ( $DebitCredit->frequency == 'semester') ? 'selected' : '' }}>{{ __('contracts.semester') }}</option>
						<option value="quarterly" {{ ( $DebitCredit->frequency == 'quarterly') ? 'selected' : '' }}>{{ __('contracts.quarterly') }}</option>
						<option value="bimonthly" {{ ( $DebitCredit->frequency == 'bimonthly') ? 'selected' : '' }}>{{ __('contracts.bimonthly') }}</option>
						<option value="monthly" {{ ( $DebitCredit->frequency == 'monthly') ? 'selected' : '' }}>{{ __('contracts.monthly') }}</option>
						<option value="weekly" {{ ( $DebitCredit->frequency == 'weekly') ? 'selected' : '' }}>{{ __('contracts.weekly') }}</option>

					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required frequency-error"></span></div>



				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('projects.update') }}</a>
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
    contracts.initMaterials();
    altair_forms.init();
</script>