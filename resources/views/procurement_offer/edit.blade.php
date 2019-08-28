<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('procurement_offers/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('procurements/'.$procurementOffer->procurement_id.'/rows') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $procurementOffer->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.description') }}</label>
                	<input type="text" class="md-input" name="description" value="{{ $procurementOffer->description }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.specifications') }}</label>
                	<input type="text" class="md-input" name="specifications" value="{{ $procurementOffer->specifications }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required specifications-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.delivery_max_days_offered') }}</label>
                	<input type="number" class="md-input" name="delivery_max_days_offered" value="{{ $procurementOffer->delivery_max_days_offered }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery_max_days_offered-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.responsable') }}</label>
                	<select name="delivery_responsable" data-md-selectize>
                	    <option value="">{{ __('procurements.responsable') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}" {{ ($user->id == $procurementOffer->delivery_responsable) ? 'selected' : '' }}>{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery_responsable-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.cost') }}</label>
                	<input type="text" class="md-input" name="cost" value="{{ $procurementOffer->cost }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.quality') }}</label>
                	<input type="text" class="md-input" name="quality" value="{{ $procurementOffer->quality }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('procurements.provider') }}</label>
                	<select name="provider_id" data-md-selectize>
                	    <option value="">{{ __('procurements.provider') }}...</option>
                	    @foreach ($providers as $provider)
                	        <option value="{{ $provider->id }}"  {{ ($provider->id == $procurementOffer->provider_id) ? 'selected' : '' }}>{{ $provider->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required provider_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('procurements.comment') }}</label>
                	<input type="text" class="md-input" name="comment" value="{{ $procurementOffer->comment }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('invoices.update')}}</a>
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
    // contracts.initResources();
    altair_forms.init();
</script>