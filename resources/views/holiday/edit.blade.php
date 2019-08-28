<style>

    .uk-datepicker{
        min-width: initial!important;
        width: 215px!important;
    }
</style>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('holidays/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('holidays') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $holiday->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label for="uk_dp_1">{{ __('holidays.date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="date" value="{{ $holiday->date }}" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('holidays.description') }}</label>
                	<input type="text" class="md-input" name="description" value="{{ $holiday->description }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('holidays.country') }}</label>
                	<select name="country_id" data-md-selectize>
                	    <option value="">{{ __('holidays.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}" {{ ($country->id == $holiday->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('holidays.update') }}</a>
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