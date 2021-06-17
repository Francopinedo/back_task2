<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('debit_credit/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('debit_credit') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $debit_credit->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                          <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.debit_credit_code') }}</label>
                    <select name="code" id="code" data-md-selectize>
                        <option value="">{{ __('projects.debit_credit_codes') }}...</option>
                        
                        <option value="proffesional hours" {{ ($debit_credit->code=='proffesional')? 'selected':'' }}>Proffesional Hours</option>
                       <option value="services" {{ ($debit_credit->code=='services')? 'selected':'' }}>Services</option>
                         <option value="materials" {{ ($debit_credit->code=='materials')? 'selected':'' }} >Materials</option>
                       <option value="others" {{ ($debit_credit->code=='others')? 'selected':'' }}>Others</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required code-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('debit_credit.detail') }}</label>
                    <br/>
                     <br/>
                	<input type="text" class="md-input" name="detail" value="{{ $debit_credit->detail }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('debit_credit.amount') }}</label>
                     <br/>
                	<input type="text" class="md-input" name="amount" value="{{ $debit_credit->amount }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

               	<div class="md-input-wrapper md-input-filled md-input-select">
               		<label>{{ __('debit_credit.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('debit_credit.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $debit_credit->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

             <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.signs') }}</label>
                    <select name="signs" id="signs" data-md-selectize>
                        <option value="">{{ __('projects.signs') }}...</option>
                        
                            <option value="+" {{ ($debit_credit->signs=='+')? 'selected':'' }}>+</option>
                       <option value="-"  {{ ($debit_credit->signs=='-')? 'selected':''}}>-</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required signs-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('debit_credit.cost') }}</label>
                     <br/>
                    <input type="text" class="md-input" name="cost" value="{{ $debit_credit->cost }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('debit_credit.cost_currency') }}</label>
                	<select name="cost_currency_id" data-md-selectize>
                	    <option value="">{{ __('debit_credit.cost_currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $debit_credit->cost_currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost_currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('debit_credit.update') }}</a>
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