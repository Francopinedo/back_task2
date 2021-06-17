<style>

    #edit_div.switcher_active {
        width: 50%;
    }

</style> 
<script src="{{ asset('js/contracts.js') }}"></script>
<script>

    $(document).ready(function(){
        contracts.initform();
    })


</script>
    	<form role="form" method="POST" action="{{ url('contracts/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('contracts') }}">

<div class="uk-grid" data-uk-grid-margin>
    		<li class="uk-width-medium-1-1 uk-row-first">
		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
</li>
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $contract->id }}">
    		<li class="uk-width-medium-1-2 uk-row-first">

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('contracts.customer') }}</label>
                	<select name="customer_id" id="customer_id" data-md-selectize>
                	    <option value="">{{ __('contracts.customer') }}...</option>
                	    @foreach ($customers as $customer)
                	        <option value="{{ $customer->id }}" {{ ($customer->id == $contract->customer_id) ? 'selected' : '' }}>{{ $customer->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>




                <select id="project_id2" name="project_id" data-md-selectize>
                	<label>{{ __('contracts.select_a_project') }}</label>
					<option value="">{{ __('contracts.select_a_project') }}...</option>
            	    @foreach ($projects as $project)
            	        <option value="{{ $project->id }}" {{ ($project->id == $contract->project_id) ? 'selected' : '' }}>{{ $project->name }}</option>
            	    @endforeach
                </select>
                <div class="parsley-errors-list filled"><span class="parsley-required project_id-error"></span></div>



                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('contracts.currency') }}</label>
                    <select name="currency_id" id="currency_id" data-md-selectize>
                        <option value="">{{ __('contracts.currency') }}...</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ (isset($contract->currency_id) && $currency->id == $contract->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.sow_number') }}</label>
                	<input type="text" class="md-input" name="sow_number" value="{{ $contract->sow_number }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sow_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.amendment_number') }}</label>
                	<input type="text" class="md-input" name="amendment_number" value="{{ $contract->amendment_number }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amendment_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('contracts.date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="date" value="{{ $contract->date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>
</li>
    		<li class="uk-width-medium-1-2 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <label for="start_date">{{ __('contracts.start_date') }}</label>
                    <input class="md-input" type="text" id="start_date2" name="start_date" value="{{ $contract->start_date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="finish_date">{{ __('contracts.finish_date') }}</label>
                    <input class="md-input" type="text" id="finish_date2" name="finish_date" value="{{ $contract->finish_date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required finish_date-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('contracts.engagement') }}</label>
                	<select name="engagement_id" data-md-selectize>
                	    <option value="">{{ __('contracts.engagement') }}...</option>
                	    @foreach ($engagements as $engagement)
                	        <option value="{{ $engagement->id }}" {{ ($engagement->id == $contract->engagement_id) ? 'selected' : '' }}>{{ $engagement->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.service_description') }}</label>
                	<input type="text" class="md-input" name="service_description" value="{{ $contract->service_description }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required service_description-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.workinghours_from') }}</label>
                	<input type="text" class="md-input" name="workinghours_from" value="{{ $contract->workinghours_from }}" data-uk-timepicker><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workinghours_from-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.workinghours_to') }}</label>
                	<input type="text" class="md-input" name="workinghours_to" value="{{ $contract->workinghours_to }}" data-uk-timepicker><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workinghours_to-error"></span></div>
</li>    	
		<li class="uk-width-medium-1-1 uk-row-first">

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('contracts.update') }}</a>
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
