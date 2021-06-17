<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('task_expenses/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('tasks/'.$taskExpense->task_id.'/rows') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $taskExpense->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <label>{{ __('tasks.expense') }}</label>
    			<div class="md-input-wrapper">
                	<select name="expense_id" id="expense_id" data-md-selectize>
                	    <option value="">{{ __('tasks.expense') }}...</option>
                	    @foreach ($expenses as $expens)
                	        <option value="{{ $expens->id }}" {{ ($expens->detail == $taskExpense->detail) ? 'selected' : '' }}>{{ $expens->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required expense_id-error"></span></div>

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('tasks.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" value="{{ $taskExpense->detail }}" required><span class="md-input-bar"></span>
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
                	<label>{{ __('tasks.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="expensecost" value="{{ $taskExpense->cost }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>


				<div class="md-input-wrapper md-input-filled">
					<label>{{ __('tasks.cost') }}</label>
					<input type="text" class="md-input" name="amount" id="expenseamount" value="{{ $taskExpense->amount }}" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tasks.quantity') }}</label>
                    <input type="text" class="md-input" name="quantity" id="expensequantity" value="{{ $taskExpense->quantity }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quantity-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('tasks.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $taskExpense->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>
				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('tasks.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>
<script src="{{ asset('js/whatif_tasksRows.js') }}"></script>
<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
   //  tasks.initServices();
    taskRows.initExpenses();
</script>