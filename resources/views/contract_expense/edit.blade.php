<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('contract_expenses/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('contract/rows/'.$contractExpense->contract_id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $contractExpense->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled">
                	<select name="expense_id" id="expense_id" data-md-selectize>
                	    <option value="">{{ __('contracts.expense') }}...</option>
                	    @foreach ($expenses as $expense)
                	        <option value="{{ $expense->id }}" {{ ($expense->id == $contractExpense->expense_id) ? 'selected' : '' }}>{{ $expense->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required expense_id-error"></span></div>

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" value="{{ $contractExpense->detail }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="reimbursable" id="reimbursable" data-md-selectize>
                	    <option value="1" {{ ($expense->reimbursable == 1) ? 'selected' : '' }}>{{ __('services.reimbursable') }}</option>
                	    <option value="0" {{ ($expense->reimbursable == 0) ? 'selected' : '' }}>{{ __('services.no_reimbursable') }}</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required reimbursable-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="expensecost" value="{{ $contractExpense->cost }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

				<div class="md-input-wrapper md-input-filled">
					<label>{{ __('contracts.amount') }}</label>
					<input type="text" class="md-input" name="amount" id="expenseamount" value="{{ $contractExpense->amount }}" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>



				<div class="md-input-wrapper md-input-filled">
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('contracts.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $contractExpense->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


				<div class="md-input-wrapper">
					<select name="frequency" id="frequency" required data-md-selectize>
						<option value="">{{ __('contracts.frequency') }}...</option>
						<option value="anualy" {{ ( $contractExpense->frequency == 'anualy') ? 'selected' : '' }}>{{ __('contracts.anualy') }}</option>
						<option value="semester" {{ ( $contractExpense->frequency == 'semester') ? 'selected' : '' }}>{{ __('contracts.semester') }}</option>
						<option value="quarterly" {{ ( $contractExpense->frequency == 'quarterly') ? 'selected' : '' }}>{{ __('contracts.quarterly') }}</option>
						<option value="bimonthly" {{ ( $contractExpense->frequency == 'bimonthly') ? 'selected' : '' }}>{{ __('contracts.bimonthly') }}</option>
						<option value="monthly" {{ ( $contractExpense->frequency == 'monthly') ? 'selected' : '' }}>{{ __('contracts.monthly') }}</option>
						<option value="weekly" {{ ( $contractExpense->frequency == 'weekly') ? 'selected' : '' }}>{{ __('contracts.weekly') }}</option>

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
    $(document).ready(function() {

        $('.cancel-edit-btn').on('click', function(e){
            e.preventDefault();
            $('#edit_div_toggle').hide();
            $('#edit_div').removeClass('switcher_active');
        });

        tableActions.initEditForm();
        contracts.initExpenses();
        altair_forms.init();

    })

</script>