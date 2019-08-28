<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('project_expenses/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('project_board/rows') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $projectExpense->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('projects.expense') }}</label>
                	<select name="expense_id" id="expense_id" data-md-selectize>
                	    <option value="">{{ __('projects.expense') }}...</option>
                	    @foreach ($expenses as $expense)
                	        <option value="{{ $expense->id }}" {{ ($expense->id == $projectExpense->expense_id) ? 'selected' : '' }}>{{ $expense->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required expense_id-error"></span></div>

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" value="{{ $projectExpense->detail }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('projects.reimbursable') }}</label>
                	<select name="reimbursable" id="reimbursable" data-md-selectize>
                	    <option value="1" {{ ($expense->reimbursable == 1) ? 'selected' : '' }}>{{ __('services.reimbursable') }}</option>
                	    <option value="0" {{ ($expense->reimbursable == 0) ? 'selected' : '' }}>{{ __('services.no_reimbursable') }}</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required reimbursable-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('projects.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="expensecost" value="{{ $projectExpense->cost }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

				<div class="md-input-wrapper md-input-filled">
					<label>{{ __('projects.amount') }}</label>
					<input type="text" class="md-input" name="amount" id="expenseamount" value="{{ $projectExpense->amount }}" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>




				<div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('projects.currency') }}</label>
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('projects.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $projectExpense->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


				<div class="md-input-wrapper">
					<select name="frequency" id="frequency" required data-md-selectize>
						<option value="">{{ __('contracts.frequency') }}...</option>
						<option value="anualy" {{ ( $projectExpense->frequency == 'monthly') ? 'selected' : '' }}>{{ __('contracts.anualy') }}</option>
						<option value="semester" {{ ( $projectExpense->frequency == 'semester') ? 'selected' : '' }}>{{ __('contracts.semester') }}</option>
						<option value="quarterly" {{ ( $projectExpense->frequency == 'quarterly') ? 'selected' : '' }}>{{ __('contracts.quarterly') }}</option>
						<option value="bimonthly" {{ ( $projectExpense->frequency == 'bimonthly') ? 'selected' : '' }}>{{ __('contracts.bimonthly') }}</option>
						<option value="monthly" {{ ( $projectExpense->frequency == 'monthly') ? 'selected' : '' }}>{{ __('contracts.monthly') }}</option>
						<option value="weekly" {{ ( $projectExpense->frequency == 'weekly') ? 'selected' : '' }}>{{ __('contracts.weekly') }}</option>

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
    contracts.initExpenses();
    altair_forms.init();
</script>