<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('discounts/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('discounts') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $discount->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper">
                	<label>{{ __('discounts.detail') }}</label>
                	<input type="text" class="md-input" name="detail" required value="{{ $discount->detail }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('discounts.amount') }}</label>
                	<input type="text" class="md-input" name="amount" id="amount" required onkeydown="Discounts.blocktheother(0);" value="{{ $discount->amount }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>


				<div class="md-input-wrapper">
					<label>{{ __('discounts.percentage') }}</label>
					<input type="text" class="md-input" id="percentage" required onkeydown="Discounts.blocktheother(1);"  name="percentage"
                           value="{{isset($discount->percentage)?$discount->percentage:0}}" >
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required percentage-error"></span></div>


               	<div class="md-input-wrapper md-input-filled md-input-select">
               		<label>{{ __('expenses.currency') }}</label>
                	<select name="currency_id" data-md-selectize required>
                	    <option value="">{{ __('discounts.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $discount->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('discounts.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>


<script src="{{ asset('js/discounts.js') }}"></script>
<script>  Discounts.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>'); </script>

<script type="text/javascript">
	$('.cancel-edit-btn').on('click', function(e){
    	e.preventDefault();
    	$('#edit_div_toggle').hide();
    	$('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
</script>