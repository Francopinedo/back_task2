<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('invoice_resources/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('invoices/rows/'.$invoiceResource->invoice_id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $invoiceResource->id }}">
    	    <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
            <input type="hidden" name="rate_id" id="rate_id" value="{{ $invoiceResource->rate_id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('invoices.project_role') }}</label>
                	<select name="project_role_id" id="project_role_id" data-md-selectize>
                	    <option value="">{{ __('projects.project_role') }}...</option>
                	    @foreach ($projectRoles as $projectRole)
                	        <option value="{{ $projectRole->id }}" {{ ($projectRole->id == $invoiceResource->project_role_id) ? 'selected' : '' }}>{{ $projectRole->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('invoices.seniority') }}</label>
                	<select name="seniority_id" id="seniority_id" data-md-selectize>
                	    <option value="">{{ __('projects.seniority') }}...</option>
                	    @foreach ($seniorities as $seniority)
                	        <option value="{{ $seniority->id }}" {{ ($seniority->id == $invoiceResource->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span></div>

				<div class="md-input-wrapper">
					<input type="hidden" class="md-input" id="currency_id" value="{{$invoice->currency_id}}" name="currency_id">
					<label>{{ __('invoices.currency') }}</label>
					@foreach ($currencies as $currency)
						@if($currency->id == $invoice->currency_id)
							<input type="text" readonly class="md-input"  value="{{$currency->name }}"/>
						@endif
					@endforeach
				</div>

               <!-- <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('invoices.currency') }}</label>
                	<select name="currency_id" id="currency_id" data-md-selectize>
                	    <option value="">{{ __('projects.currency') }}...</option>
                	    @foreach ($currencies as $currency)
                	        <option value="{{ $currency->id }}" {{ ($currency->id == $invoiceResource->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	    @endforeach
                	</select>
                </div>

                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>
-->
                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('invoices.workplace') }}</label>
                	<select name="workplace" id="workplace" data-md-selectize>
                	    <option value="">{{ __('projects.workplace') }}...</option>
                	    <option value="onsite" {{ ($invoiceResource->workplace == 'onsite') ? 'selected' : '' }}>{{ __('projects.onsite') }}...</option>
                	    <option value="offshore" {{ ($invoiceResource->workplace == 'offshore') ? 'selected' : '' }}>{{ __('projects.offshore') }}...</option>
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span></div>




				<div class="md-input-wrapper md-input-filled md-input-select">
					<label>{{ __('rates.country') }}</label>
					<select required name="country_id" id="country_id" data-md-selectize>
						<option value="">{{ __('rates.country') }}...</option>
						@foreach ($countries as $country)
							<option value="{{ $country->id }}" {{ ( $country->id == $invoiceResource->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.city') }}</label>
					<select name="city_id" id="city_id" data-md-selectize>
						<option value="">{{ __('rates.city') }}...</option>
						@foreach ($cities as $city)
							<option value="{{ $city->id }}" {{ ($city->id == $invoiceResource->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>

						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

				<div class="md-input-wrapper md-input-select">
					<label>{{ __('rates.office') }}</label>
					<select name="office_id"  id="office_id"  required data-md-selectize>
						<option value="">{{ __('rates.office') }}...</option>
						@foreach ($offices as $office)
							<option value="{{ $office->id }}" {{ ($office->id == $invoiceResource->office_id) ? 'selected' : '' }}>{{ $office->title }}</option>
						@endforeach
					</select>
				</div>
				<div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>



				<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.rate') }}</label>
                	<input type="text" class="md-input" name="rate"  id="rate" value="{{ $invoiceResource->rate }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required rate-error"></span></div>

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('invoices.user') }}</label>
                	<select name="user_id" id="user_id" data-md-selectize>
                	    <option value="">{{ __('invoices.user') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->user_id }}"  <?php if($user->user_id == $invoiceResource->user_id) echo 'selected' ?>>{{ $user->user_name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.load') }}</label>
                	<input type="text" class="md-input" name="load" value="{{ $invoiceResource->load }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required load-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.hours') }}</label>
                	<input type="number" class="md-input" name="hours" value="{{ $invoiceResource->hours }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required hours-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.type') }}</label>
                	<input type="text" class="md-input" name="type" value="{{ $invoiceResource->type }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required type-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('invoices.comments') }}</label>
                	<input type="text" class="md-input" name="comments" value="{{ $invoiceResource->comments }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comments-error"></span></div>

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
    contracts.initResources();
    altair_forms.init();
</script>