<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('project_debit_credit') }}" id="data-form-ajax_create" data-redirect-on-success="{{ url('project_board/project_rows') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="project_id" value="{{ $project->id }}">
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
                    <label for="uk_dp_1">{{ __('invoices.debit_credit_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" required name="date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>



    			<div class="md-input-wrapper">
                	<label>{{ __('projects.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

              

                <div class="md-input-wrapper">
                	<label>{{ __('projects.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="materialcost" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>


				<div class="md-input-wrapper">
					<label>{{ __('projects.amount') }}</label>
					<input type="text" class="md-input" name="amount" id="materialamount" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('projects.signs') }}</label>
                    <select name="signs" id="signs" data-md-selectize>
                        <option value="">{{ __('projects.signs') }}...</option>
                        
                            <option value="+">+</option>
                       <option value="-">-</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required signs-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.currency') }}</label>
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('projects.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


				<div class="md-input-wrapper">
					<select name="frequency" id="frequency" required data-md-selectize>
						<option value="">{{ __('contracts.frequency') }}...</option>
						<option value="anualy">{{ __('contracts.anualy') }}</option>
						<option value="semester">{{ __('contracts.semester') }}</option>
						<option value="quarterly">{{ __('contracts.quarterly') }}</option>
						<option value="bimonthly">{{ __('contracts.bimonthly') }}</option>
						<option value="monthly">{{ __('contracts.monthly') }}</option>
						<option value="weekly">{{ __('contracts.weekly') }}</option>
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required frequency-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="ajax_create-btn">{{ __('projects.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-ajax_create-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script type="text/javascript">
	$('.cancel-ajax_create-btn').on('click', function(e){
    	e.preventDefault();
    	$('#ajax_create_div_toggle').hide();
    	$('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();
    contracts.initMaterials();
    altair_forms.init();
</script>