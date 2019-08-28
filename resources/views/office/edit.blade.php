<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('offices/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('offices') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $office->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('offices.title') }}</label>
                	<input type="text" class="md-input" name="title" value="{{ $office->title }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>
                <input type="hidden" name="company_id" value="{{ $company->id }}">
               	<div class="md-input-wrapper md-input-filled md-input-select">
               		<label>{{ __('offices.city') }}</label>
                	<select name="city_id" data-md-selectize>
                	    <option value="">{{ __('offices.city') }}...</option>
                	    @foreach ($cities as $city)
                	        <option value="{{ $city->id }}" {{ ($city->id == $office->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>
                <label>{{ __('offices.workinghours_from') }}</label>
                <div class="md-input-wrapper md-input-filled">

                	<input type="text" class="md-input" name="workinghours_from" value="{{ $office->workinghours_from }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workinghours_from-error"></span></div>
                <label>{{ __('offices.workinghours_to') }}</label>
                <div class="md-input-wrapper md-input-filled">

                	<input type="text" class="md-input" name="workinghours_to" value="{{ $office->workinghours_to }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workinghours_to-error"></span></div>
                <label>{{ __('offices.hours_by_day') }}</label>
                <div class="md-input-wrapper">

                    <input type="number" min="0" max="24" class="md-input" name="hours_by_day"
                           value="{{ $office->hours_by_day }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required hours_by_day-error"></span></div>

                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('offices.update') }}</a>
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