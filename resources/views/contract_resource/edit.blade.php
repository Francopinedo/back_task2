<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('contract_resources/update') }}"
              id="data-form-edit" data-redirect-on-success="{{ url('contract/rows/'.$contractResource->contract_id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $contractResource->id }}">
    	    <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
    	    <input type="hidden" name="rate_id" id="rate_id2" value="{{ $contractResource->rate_id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                	<select required name="project_role_id" id="project_role_id2" data-md-selectize>
                	    <option value="">{{ __('contracts.project_role') }}...</option>
                	    @foreach ($projectRoles as $projectRole)
                	        <option value="{{ $projectRole->id }}" {{ ($projectRole->id == $contractResource->project_role_id) ? 'selected' : '' }}>{{ $projectRole->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<select required name="seniority_id" id="seniority_id2" data-md-selectize>
                	    <option value="">{{ __('contracts.seniority') }}...</option>
                	    @foreach ($seniorities as $seniority)
                	        <option value="{{ $seniority->id }}" {{ ($seniority->id == $contractResource->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<select required name="currency_id" id="currency_id2" data-md-selectize>
                	    <option value="">{{ __('contracts.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $contractResource->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<select required name="workplace" id="workplace2" data-md-selectize>
                	    <option value="">{{ __('contracts.workplace') }}...</option>
                	    <option value="onsite" {{ ($contractResource->workplace == 'onsite') ? 'selected' : '' }}>{{ __('contracts.onsite') }}...</option>
                	    <option value="offshore" {{ ($contractResource->workplace == 'offshore') ? 'selected' : '' }}>{{ __('contracts.offshore') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span></div>


				<div class="md-input-wrapper md-input-filled md-input-select">
					<label>{{ __('rates.country') }}</label>
					<select required name="country_id" id="country_id2" data-md-selectize>
						<option value="">{{ __('rates.country') }}...</option>
						@foreach ($countries as $country)
							<option value="{{ $country->id }}" {{ ($country->id == $contractResource->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.city') }}</label>
					<select name="city_id" id="city_id2" data-md-selectize>
						<option value="">{{ __('rates.city') }}...</option>
						@foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ ($city->id == $contractResource->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>

                        @endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.office') }}</label>
					<select name="office_id"  id="office_id2"  required data-md-selectize>
						<option value="">{{ __('rates.office') }}...</option>
						@foreach ($offices as $office)
                            <option value="{{ $office->id }}" {{ ($office->id == $contractResource->office_id) ? 'selected' : '' }}>{{ $office->title }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>


				<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.rate') }}</label>
                	<input type="text"  class="md-input" name="rate" id="rate2" value="{{ $contractResource->rate }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required rate-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.qty') }}</label>
                	<input type="text" class="md-input" name="qty" value="{{ $contractResource->qty }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required qty-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.load') }}</label>
                	<input type="text" class="md-input" name="load" value="{{ $contractResource->load }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required load-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('contracts.comments') }}</label>
                	<input type="text" class="md-input" name="comments" value="{{ $contractResource->comments }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comments-error"></span></div>



				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('contracts.update')}}</a>
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
    contracts.initResources();

</script>