<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('taxes') }}" id="data-form" data-redirect-on-success="{{ url('taxes') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper">
                	<label>{{ __('discounts.detail') }}</label>
                	<input type="text" class="md-input" name="detail" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('discounts.amount') }}</label>
                	<input type="text" class="md-input" name="value" id="value2" onkeydown="Taxes.blocktheother(0);"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>


				<div class="md-input-wrapper">
					<label>{{ __('discounts.percentage') }}</label>
					<input type="text" class="md-input" id="percentage2" name="percentage" onkeydown="Taxes.blocktheother(1);"><span class="md-input-bar"></span>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required percentage-error"></span></div>



				<div class="md-input-wrapper md-input-select">
               		<label>{{ __('discounts.currency') }}</label>
                	<select name="currency_id" data-md-selectize>
                	    <option value="">{{ __('discounts.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>


				<div class="md-input-wrapper md-input-select">
					<label>{{ __('discounts.country') }}</label>
					<select name="country_id" data-md-selectize>
						<option value="">{{ __('discounts.country') }}...</option>
						@foreach ($countries as $country)
							<option value="{{ $country->id }}">{{ $country->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>


				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('discounts.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script src="{{ asset('js/taxes.js') }}"></script>
<script>  Taxes.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>'); </script>
