<style>

    #create_div.switcher_active {
        width: 50%;
    }

</style>   
 <script src="{{ asset('js/contracts.js') }}"></script>
<script>

    $(document).ready(function(){
        contracts.initform();
    })

</script>
    	<form role="form" method="POST" action="{{ url('contracts') }}" id="data-form" data-redirect-on-success="{{ url($url) }}">

<div class="uk-grid" data-uk-grid-margin>
    		<li class="uk-width-medium-1-1 uk-row-first">
		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>
</li>
    	    {{ csrf_field() }}
    		<li class="uk-width-medium-1-2 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('contracts.customer') }}</label>
                	<select name="customer_id" id="customer_id" data-md-selectize>
                	    <option value="">{{ __('contracts.customer') }}...</option>
                	    @foreach ($customers as $customer)
                	        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>



                <select id="project_id" name="project_id" data-md-selectize>
                    <option value="">{{ __('contracts.customer') }}...</option>
                </select>


                <div class="parsley-errors-list filled"><span class="parsley-required project_id-error"></span></div>



                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('contracts.currency') }}</label>
                    <select name="currency_id" id="currency_id" data-md-selectize>
                        <option value="">{{ __('contracts.currency') }}...</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


                <div class="md-input-wrapper">
                	<label>{{ __('contracts.sow_number') }}</label>
                	<input type="text" class="md-input" name="sow_number"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sow_number-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contracts.amendment_number') }}</label>
                	<input type="text" class="md-input" name="amendment_number"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amendment_number-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('contracts.date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>
</li>
    		<li class="uk-width-medium-1-2 uk-row-first">

                <div class="md-input-wrapper">
                    <label for="start_date">{{ __('contracts.start_date') }}</label>
                    <input class="md-input" type="text" id="start_date" name="start_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start_date-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="finish_date">{{ __('contracts.finish_date') }}</label>
                    <input class="md-input" type="text" id="finish_date" name="finish_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required finish_date-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('contracts.engagement') }}</label>
                	<select name="engagement_id" data-md-selectize>
                	    <option value="">{{ __('contracts.engagement') }}...</option>
                	    @foreach ($engagements as $engagement)
                	        <option value="{{ $engagement->id }}">{{ $engagement->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contracts.service_description') }}</label>
                	<input type="text" class="md-input" name="service_description"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required service_description-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contracts.workinghours_from') }}</label>
                	<input type="text" class="md-input" name="workinghours_from" data-uk-timepicker><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workinghours_from-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contracts.workinghours_to') }}</label>
                	<input type="text" class="md-input" name="workinghours_to" data-uk-timepicker><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workinghours_to-error"></span></div>
</li>
    		<li class="uk-width-medium-1-1 uk-row-first">
				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('contracts.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </li>

    </div>
    	</form>

