<style>

    #edit_div.switcher_active {
        width: 50%;
    }

</style> 
    	<form role="form" method="POST" action="{{ url('invoices/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('invoices') }}">

<div class="uk-grid" data-uk-grid-margin>
    		<li class="uk-width-medium-1-1 uk-row-first">
		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
</li>
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $invoice->id }}">
    		<li class="uk-width-medium-1-2 uk-row-first">

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.number') }}</label>
                	<input type="text" class="md-input" name="number" value="{{ $invoice->number }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.purchase_order') }}</label>
                	<input type="text" class="md-input" name="purchase_order" value="{{ $invoice->purchase_order }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required purchase_order-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.concept') }}</label>
                	<input type="text" class="md-input" name="concept" value="{{ $invoice->concept }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required concept-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('invoices.from') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="from" value="{{ $invoice->from }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required from-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('invoices.to') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="to" value="{{ $invoice->to }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required to-error"></span></div>
</li>
    		<li class="uk-width-medium-1-2 uk-row-first">


                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('invoices.contact') }}</label>
                	<select name="contact_id" data-md-selectize>
                	    <option value="">{{ __('invoices.contact') }}...</option>
                	    @foreach ($contacts as $contact)
                	        <option value="{{ $contact->id }}" {{ ($contact->id == $invoice->contact_id) ? 'selected' : '' }}>{{ $contact->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required contact_id-error"></span></div>

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('invoices.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('invoices.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $invoice->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('invoices.due_date') }}</label>
                    <input class="md-input"  required type="text" id="uk_dp_1" value="{{ $invoice->due_date=='0000-00-00'?'2050-01-01':$invoice->due_date }}" name="due_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.bill_to') }}</label>
                	<input type="text" class="md-input" name="bill_to" value="{{ $invoice->bill_to }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required bill_to-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.remit_to') }}</label>
                	<input type="text" class="md-input" name="remit_to" value="{{ $invoice->remit_to }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required remit_to-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('invoices.comments') }}</label>
                    <textarea class="md-input" id="comments" name="comments" >{{ $invoice->comments }}</textarea>
                    <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required remit_to-error"></span></div>


</li>
    		<li class="uk-width-medium-1-1 uk-row-first">

                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('invoices.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </li>

</div>
    	</form>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
</script>
