<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('quotation/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('quotation') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $quotation->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.number') }}</label>
                	<input type="text" class="md-input" name="number" value="{{ $quotation->number }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required number-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.concept') }}</label>
                	<input type="text" class="md-input" name="concept" value="{{ $quotation->concept }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required concept-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('quotations.from') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="from" value="{{ $quotation->from }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required from-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('quotations.to') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="to" value="{{ $quotation->to }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required to-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('quotations.contact') }}</label>
                	<select name="contact_id" data-md-selectize>
                	    <option value="">{{ __('quotations.contact') }}...</option>
                	    @foreach ($contacts as $contact)
                	        <option value="{{ $contact->id }}" {{ ($contact->id == $quotation->contact_id) ? 'selected' : '' }}>{{ $contact->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required contact_id-error"></span></div>

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('quotations.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('quotations.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $quotation->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('quotations.due_date') }}</label>
                    <input class="md-input"  required type="text" id="uk_dp_1" value="{{ $quotation->due_date }}" name="due_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.bill_to') }}</label>
                	<input type="text" class="md-input" name="bill_to" value="{{ $quotation->bill_to }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required bill_to-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.remit_to') }}</label>
                	<input type="text" class="md-input" name="remit_to" value="{{ $quotation->remit_to }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required remit_to-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('quotations.comments') }}</label>
                    <textarea class="md-input" id="comments" name="comments" >{{ $quotation->comments }}</textarea>
                    <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required remit_to-error"></span></div>




                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('quotations.update') }}</a>
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