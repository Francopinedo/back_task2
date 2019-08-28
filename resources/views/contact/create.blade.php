<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('contacts') }}" id="data-form" data-redirect-on-success="{{ url('contacts') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="company_id" value="{{ $company->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('contacts.project') }}</label>
    				<select name="project_id" data-md-selectize>
    				    <option value="">{{ __('contacts.project') }}...</option>
    				    @foreach ($projects as $project)
    				        <option value="{{ $project->id }}">{{ $project->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required project_id-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contacts.name') }}</label>
                	<input type="text" class="md-input" name="name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contacts.company') }}</label>
                	<input type="text" class="md-input" name="company" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required company-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contacts.department') }}</label>
                	<input type="text" class="md-input" name="department" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required department-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('contacts.country') }}</label>
    				<select name="country_id" id="country_id" data-md-selectize>
    				    <option value="">{{ __('contacts.country') }}...</option>
    				    @foreach ($countries as $country)
    				        <option value="{{ $country->id }}">{{ $country->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('contacts.city') }}</label>
    				<select name="city_id" id="city_id" data-md-selectize>
    				    <option value="">{{ __('contacts.city') }}...</option>
    				    @foreach ($cities as $city)
    				        <option value="{{ $city->id }}">{{ $city->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('contacts.industry') }}</label>
    				<select name="industry_id" data-md-selectize>
    				    <option value="">{{ __('contacts.industry') }}...</option>
    				    @foreach ($industries as $industry)
    				        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required industry_id-error"></span></div>

    			<div class="md-input-wrapper">
                	<label>{{ __('contacts.email') }}</label>
                	<input type="email" class="md-input" name="email" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contacts.phone') }}</label>
                	<input type="text" class="md-input" name="phone" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phone-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('contacts.comments') }}</label>
                	<input type="text" class="md-input" name="comments" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comments-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('contacts.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>


<script src="{{ asset('js/contact.js') }}"></script>
<script type="text/javascript">

    Contact.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
</script>