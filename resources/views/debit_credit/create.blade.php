<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('debit_credit') }}" id="data-form" data-redirect-on-success="{{ url('debit_credit') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                  <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.debit_credit_code') }}</label>
                    <select name="code" id="code" data-md-selectize>
                        <option value="">{{ __('projects.debit_credit_codes') }}...</option>
                        
                        <option value="proffesional hours" >Proffesional Hours</option>
                       <option value="services">Services</option>
                         <option value="materials" >Materials</option>
                       <option value="others">Others</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required code-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('debit_credit.detail') }}</label>
                     <br/>
                	<input type="text" class="md-input" name="detail" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('debit_credit.amount') }}</label>
                     <br/>
                	<input type="text" class="md-input" name="amount"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

               	<div class="md-input-wrapper md-input-select">
               		<label>{{ __('debit_credit.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('debit_credit.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                 <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.signs') }}</label>
                    <select name="signs" id="signs" data-md-selectize>
                        <option value="">{{ __('projects.signs') }}...</option>
                        
                            <option value="+">+</option>
                       <option value="-">-</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required signs-error"></span></div>


                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('debit_credit.cost') }}</label>
                     <br/>
                    <input type="text" class="md-input" name="cost"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('debit_credit.cost_currency') }}</label>
                	<select name="cost_currency_id" data-md-selectize>
                	    <option value="">{{ __('debit_credit.cost_currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost_currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('debit_credit.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

