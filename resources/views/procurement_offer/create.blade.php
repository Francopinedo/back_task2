<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('procurement_offers') }}" id="data-form-ajax_create" data-redirect-on-success="{{ url('procurements/'.$procurement->id.'/rows') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="procurement_id" value="{{ $procurement->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper">
                	<label>{{ __('procurements.description') }}</label>
                	<input type="text" class="md-input" name="description" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.specifications') }}</label>
                	<input type="text" class="md-input" name="specifications" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required specifications-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.delivery_max_days_offered') }}</label>
                	<input type="number" class="md-input" name="delivery_max_days_offered" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery_max_days_offered-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.responsable') }}</label>
                	<select name="delivery_responsable" data-md-selectize>
                	    <option value="">{{ __('procurements.responsable') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}">{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery_responsable-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.cost') }}</label>
                	<input type="text" class="md-input" name="cost" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.quality') }}</label>
                	<input type="text" class="md-input" name="quality" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quality-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('procurements.provider') }}</label>
                	<select name="provider_id" data-md-selectize>
                	    <option value="">{{ __('procurements.provider') }}...</option>
                	    @foreach ($providers as $provider)
                	        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required provider_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('procurements.comment') }}</label>
                	<input type="text" class="md-input" name="comment" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="ajax_create-btn">{{ __('procurements.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-ajax_create-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

{{-- @push('scripts') --}}
	<script type="text/javascript">
		$('#cancel-ajax_create-btn').on('click', function(e){
	    	e.preventDefault();
	    	$('#ajax_create_div_toggle').hide();
	    	$('#ajax_create_div').removeClass('switcher_active');
	    });

	    tableActions.initAjaxCreateForm();
	    altair_forms.init();
	</script>
{{-- @endpush --}}