<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('quotation_resources/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('quotation/rows/'.$quotationResource->quotation_id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $quotationResource->id }}">
    	    <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
            <input type="hidden" name="rate_id" id="rate_id" value="{{ $quotationResource->rate_id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('quotations.project_role') }}</label>
                	<select name="project_role_id" id="project_role_id" data-md-selectize>
                	    <option value="">{{ __('projects.project_role') }}...</option>
                	    @foreach ($projectRoles as $projectRole)
                	        <option value="{{ $projectRole->id }}" {{ ($projectRole->id == $quotationResource->project_role_id) ? 'selected' : '' }}>{{ $projectRole->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('quotations.seniority') }}</label>
                	<select name="seniority_id" id="seniority_id" data-md-selectize>
                	    <option value="">{{ __('projects.seniority') }}...</option>
                	    @foreach ($seniorities as $seniority)
                	        <option value="{{ $seniority->id }}" {{ ($seniority->id == $quotationResource->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span></div>

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
                	    <option value="">{{ __('projects.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $quotationResource->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>

                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>
-->
                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('quotations.workplace') }}</label>
                	<select name="workplace" id="workplace" data-md-selectize>
                	    <option value="">{{ __('projects.workplace') }}...</option>
                	    <option value="onsite" {{ ($quotationResource->workplace == 'onsite') ? 'selected' : '' }}>{{ __('projects.onsite') }}...</option>
                	    <option value="offshore" {{ ($quotationResource->workplace == 'offshore') ? 'selected' : '' }}>{{ __('projects.offshore') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span></div>




				<div class="md-input-wrapper md-input-filled md-input-select">
					<label>{{ __('rates.country') }}</label>
					<select required name="country_id" id="country_id" data-md-selectize>
						<option value="">{{ __('rates.country') }}...</option>
						@foreach ($countries as $country)
							<option value="{{ $country->id }}" {{ ( $country->id == $quotationResource->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.city') }}</label>
					<select name="city_id" id="city_id" data-md-selectize>
						<option value="">{{ __('rates.city') }}...</option>
						@foreach ($cities as $city)
							<option value="{{ $city->id }}" {{ ($city->id == $quotationResource->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>

						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.office') }}</label>
					<select name="office_id"  id="office_id"  required data-md-selectize>
						<option value="">{{ __('rates.office') }}...</option>
						@foreach ($offices as $office)
							<option value="{{ $office->id }}" {{ ($office->id == $quotationResource->office_id) ? 'selected' : '' }}>{{ $office->title }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>



				<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.rate') }}</label>
                	<input type="text" class="md-input" name="rate"  id="rate" value="{{ $quotationResource->rate }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required rate-error"></span></div>



    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('quotations.user') }}</label>
                	<select name="user_id" id="user_id" data-md-selectize>
                	    <option value="">{{ __('quotations.user') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->user_id }}"  <?php if($user->user_id == $quotationResource->user_id) echo 'selected' ?>>{{ $user->user_name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.load') }}</label>
                	<input type="text" class="md-input" name="load" value="{{ $quotationResource->load }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required load-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.hours') }}</label>
                	<input type="number" class="md-input" name="hours" value="{{ $quotationResource->hours }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required hours-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.type') }}</label>
                	<input type="text" class="md-input" name="type" value="{{ $quotationResource->type }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required type-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('quotations.comments') }}</label>
                	<input type="text" class="md-input" name="comments" value="{{ $quotationResource->comments }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comments-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('quotations.update')}}</a>
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
    altair_forms.init();
</script>