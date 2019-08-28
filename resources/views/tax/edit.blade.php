<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('taxes/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('taxes') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $tax->id }}">
            <input type="hidden" name="company_id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper">
                	<label>{{ __('discounts.detail') }}</label>
                	<input type="text" class="md-input" name="detail" value="{{ $tax->detail }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('discounts.amount') }}</label>
                	<input type="text" class="md-input" name="value" id="value" onkeydown="Taxes.blocktheother(0);" value="{{ $tax->value }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

				<div class="md-input-wrapper">
					<label>{{ __('discounts.percentage') }}</label>
					<input type="text" class="md-input" id="percentage" onkeydown="Taxes.blocktheother(1);" value="{{$tax->percentage}}" name="percentage"><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required percentage-error"></span></div>



				<div class="md-input-wrapper md-input-filled md-input-select">
               		<label>{{ __('discounts.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('discounts.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $tax->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('discounts.country') }}</label>
                    <select name="country_id" data-md-selectize>
                        <option value="">{{ __('discounts.country') }}...</option>
                        @foreach ($countries as $countrie)
                            <option value="{{ $countrie->id }}" {{ ($countrie->id == $tax->country_id) ? 'selected' : '' }}>{{ $countrie->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>


				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('discounts.update') }}</a>
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