
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('quotation') }}" id="data-form-ajax_create" data-redirect-on-success="{{ url('quotation/rows/') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="project_id" value="{{ session('project_id') }}">
            <input type="hidden" name="customer_id" value="{{ $project->customer_id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <input type="hidden" name="from_project_board" value="{{ isset($from_project_board)?$from_project_board:0 }}">
    			<div class="md-input-wrapper">
                	<label>{{ __('invoices.number') }}</label>
                	<input type="text" class="md-input" name="number" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required number-error"></span></div>

               <!-- <div class="md-input-wrapper">
                	<label>{{ __('invoices.purchase_order') }}</label>
                	<input type="text" class="md-input" name="purchase_order" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required purchase_order-error"></span></div>-->

                <div class="md-input-wrapper">
                	<label>{{ __('invoices.concept') }}</label>
                	<input type="text" class="md-input" name="concept" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required concept-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('invoices.from') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="from"  value="{{$project->start}}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required from-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('invoices.to') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="to" value="{{$project->finish}}"  data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required to-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('invoices.contact') }}</label>
                	<select name="contact_id" data-md-selectize>
                	    <option value="">{{ __('invoices.contact') }}...</option>
                	    @foreach ($contacts as $contact)
                	        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required contact_id-error"></span></div>

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('invoices.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('invoices.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('invoices.due_date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" required name="due_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.bill_to') }}</label>
                	<input type="text" class="md-input" name="bill_to" value="{{ $project->customer->data->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required bill_to-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.remit_to') }}</label>
                	<input type="text" class="md-input" name="remit_to" value="{{ $company->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required remit_to-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('invoices.comments') }}</label>
                    <textarea class="md-input" id="comments" name="comments" ></textarea>
                        <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required remit_to-error"></span></div>



                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="ajax_create-btn">{{ __('invoices.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
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
    altair_forms.init();
</script>