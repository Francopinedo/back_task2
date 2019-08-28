<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('task_expenses') }}" id="data-form-ajax_create" data-redirect-on-success="{{ url('tasks/'.$task->id.'/rows') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="task_id" value="{{ $task->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <label>{{ __('tasks.expense') }}</label>
    			 <div class="md-input-wrapper md-input-select">
                	<select name="task_expense" id="expense_id">
                	    <option value="">{{ __('tasks.expense') }}...</option>
                	    @foreach ($expenses as $expens)
                	        <option value="{{ $expens->id }}">{{ $expens->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required expense_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tasks.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <label>{{ __('services.reimbursable') }}</label>
               <div class="md-input-wrapper md-input-select">
                	<select name="reimbursable" id="reimbursable" data-md-selectize>
                	    <option value="1">{{ __('services.reimbursable') }}</option>
                	    <option value="0">{{ __('services.no_reimbursable') }}</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required reimbursable-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('tasks.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="expensecost" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>


                <div class="md-input-wrapper">
                    <label>{{ __('tasks.amount') }}</label>
                    <input type="text" class="md-input" name="amount" id="expenseamount" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>


                <div class="md-input-wrapper">
                    <label>{{ __('tasks.quantity') }}</label>
                    <input type="text" class="md-input" name="quantity" id="expensequantity" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quantity-error"></span></div>


                <label>{{ __('tasks.currency') }}</label>
                <div class="md-input-wrapper md-input-select">
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('tasks.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="ajax_create-btn">{{ __('tasks.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-ajax_create-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script src="{{ asset('js/tasksRows.js') }}"></script>
<script type="text/javascript">
	$('#cancel-ajax_create-btn').on('click', function(e){
    	e.preventDefault();
    	$('#ajax_create_div_toggle').hide();
    	$('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();
    taskRows.initExpenses();

</script>