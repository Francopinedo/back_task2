<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('quotation_materials') }}" id="data-form-ajax_create" data-redirect-on-success="{{ url('quotation/rows/'.$quotation->id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('quotations.material') }}</label>
                	<select name="material_id" id="material_id" data-md-selectize>
                	    <option value="">{{ __('quotations.material') }}...</option>
                	    @foreach ($materials as $material)
                	        <option value="{{ $material->id }}">{{ $material->detail }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required material_id-error"></span></div>

    			<div class="md-input-wrapper">
                	<label>{{ __('quotations.detail') }}</label>
                	<input type="text" class="md-input" name="detail" id="detail" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('quotations.cost') }}</label>
                	<input type="text" class="md-input" name="cost" id="materialcost" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

				<div class="md-input-wrapper">
					<label>{{ __('quotations.amount') }}</label>
					<input type="text" class="md-input" name="amount" id="materialamount" required><span class="md-input-bar"></span>
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

               <!-- <div class="md-input-wrapper md-input-select">
                	<label>{{ __('quotations.currency') }}</label>
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('quotations.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>-->
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="ajax_create-btn">{{ __('quotations.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-ajax_create-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script type="text/javascript">
	$('#cancel-ajax_create-btn').on('click', function(e){
    	e.preventDefault();
    	$('#ajax_create_div_toggle').hide();
    	$('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();
    contracts.initMaterials();
    altair_forms.init();
</script>