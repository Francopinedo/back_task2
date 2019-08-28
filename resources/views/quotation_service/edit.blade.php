<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('quotation_services/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('quotation/rows/'.$quotation->id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $quotationService->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('quotations.service') }}</label>
                	<select name="service_id" id="service_id" data-md-selectize>
                	    <option value="">{{ __('quotations.service') }}...</option>
                	    @foreach ($services as $service)
                	        <option value="{{ $service->id }}">{{ $service->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required expense_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" value="{{ $quotationService->detail }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="servicecost" value="{{ $quotationService->cost }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>


				<div class="md-input-wrapper md-input-filled">
					<label>{{ __('quotations.amount') }}</label>
					<input type="text" class="md-input" name="amount" id="serviceamount" value="{{ $quotationService->amount }}" required><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

				<div class="md-input-wrapper">
					<input type="hidden" class="md-input" id="currency_id" value="{{$quotation->currency_id}}" name="currency_id">
					<label>{{ __('quotations.currency') }}</label>
					@foreach ($currencies as $currency)
						@if($currency->id == $quotation->currency_id)
							<input type="text" readonly class="md-input"  value="{{$currency->name }}"/>
						@endif
					@endforeach
				</div>

               <!-- <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('quotations.currency') }}</label>
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('quotations.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $quotationService->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>
-->
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
    contracts.initServices();
    altair_forms.init();
</script>