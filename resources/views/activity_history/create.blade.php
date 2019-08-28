<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('activities_history') }}" id="data-form"
			  data-redirect-on-success="">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="agenda_id" value="{{ $agenda->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('activities_history.date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('activities_history.description') }}</label>
                	<input type="text" class="md-input" name="description" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

    			<div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('activities_history.due') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="due" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due-error"></span></div>

    			<div class="md-input-wrapper md-input-select">
                	<label>{{ __('activities_history.follower') }}</label>
    				<select name="follower_id" data-md-selectize>
    				    <option value="">{{ __('activities_history.follower') }}...</option>
    				    @foreach ($users as $follower)
    				        <option value="{{ $follower->id }}">{{ $follower->name }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required follower_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('activities_history.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script src="{{ asset('js/table_actions.js') }}"></script>
<script type="text/javascript">
    $('.cancel-ajax_create-btn').on('click', function (e) {
        e.preventDefault();
        $('#ajax_create_div_toggle').hide();
        $('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();

    altair_forms.init();
</script>