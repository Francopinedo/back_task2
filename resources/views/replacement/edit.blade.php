<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('replacements/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('replacements') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $replacement->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper md-input-filled md-input-select">
    				<label>{{ __('absences.select_an_absence') }}</label>
                	<select name="absence_id" id="absence_id2" data-md-selectize>
                	    <option value="">{{ __('replacements.select_an_absence') }}...</option>
                	    @foreach ($absences as $absence)
                	        <option value="{{ $absence->id }}" {{ ($absence->id == $replacement->absence_id) ? 'selected' : '' }}>{{ $absence->user->data->name }} ({{ $absence->from }})</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                	<label>{{ __('absences.select_a_replacement') }}</label>
                	<select name="user_id" data-md-selectize>
                	    <option value="">{{ __('replacements.select_a_replacement') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}" {{ ($user->id == $replacement->user_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('replacements.from') }}</label>
                    <input class="md-input" type="text" id="from2" name="from" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ $replacement->from }}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required from-error"></span></div>

                 <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('replacements.to') }}</label>
                    <input class="md-input" type="text" id="to2" name="to" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ $replacement->to }}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required to-error"></span></div>

                 <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('replacements.ticket') }}</label>
                	<input type="text" class="md-input" name="ticket" value="{{ $replacement->ticket }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required ticket-error"></span></div>

                 <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('replacements.comment') }}</label>
                	<input type="text" class="md-input" name="comment" value="{{ $replacement->comment }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('replacements.update') }}</a>
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

    $('#absence_id2').on('change', function () {
        var info_url = API_PATH + 'absences/' + $('#absence_id2').val();
        $.ajax({
            url: info_url,
            type: 'GET',
            dataType: 'json'
        }).done(function (data) {


            $("#from2").val(data.data.from);
            $("#to2").val(data.data.to);
        });
    });

    tableActions.initEditForm();
</script>