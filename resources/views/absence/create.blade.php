<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('absences') }}" id="data-form" data-redirect-on-success="{{ url('absences') }}">
    	    {{ csrf_field() }}
            <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
    	     <input type="hidden" name="project_id" value="{{ session('project_id') }}">
    		<div class="uk-width-medium-1-1 uk-row-first">


    			<div class="md-input-wrapper md-input-select">
    				<label>{{ __('absences.country') }}</label>
                	<select id="country_id" data-md-selectize>
                	    <option value="">{{ __('absences.country') }}...</option>
                	    @foreach ($countries as $country)
                	        <option value="{{ $country->id }}">{{ $country->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('absences.city') }}</label>
                    <select id="city_id" data-md-selectize>
                        <option value="">{{ __('absences.city') }}...</option>

                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>


                <select id="absence_type_id" name="absence_type_id">

                </select>

                <div class="md-input-wrapper">
                	<label>{{ __('absences.comment') }}</label>
                	<input type="text" class="md-input" name="comment" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('absences.from') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="from" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required from-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('absences.to') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="to" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required to-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('absences.user') }}</label>
                	<select name="user_id" data-md-selectize>
                	    <option value="">{{ __('absences.user') }}...</option>
                	    @foreach ($users as $user)
                	        <option value="{{ $user->id }}">{{ $user->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('absences.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

<script type="text/javascript">



    $('#country_id').selectize();
    $('#country_id').selectize();
    $('#country_id').on('change', function () {
        console.log('change');
        var info_url = API_PATH + '/cities';
        $.ajax({
            url: info_url,
            type: 'GET',


            data: {country_id:  $('#country_id').val()},
            dataType: 'json'
        }).done(
            function (data) {
                $("#city_id").html('');


                $('#absence_type_id').selectize()[0].selectize.destroy();
                $("#absence_type_id").html('');
                $("#absence_type_id").val('');
                var html = '<option value="">Absence Type</option>';
                $('#absence_type_id').html(html);
                $('#absence_type_id').selectize();


                $('#city_id').selectize()[0].selectize.destroy();
                var html = '<option value="">City</option>';
                jQuery.each(data.data, function (i, value) {
                    html += '<option value="' + value.id + '">' + value.name +  '</option>';


                });

                $('#city_id').html(html);
                $('#city_id').selectize();
            }
        );
    });

    $('#city_id').on('change', function () {
        var info_url = API_PATH + '/absence_types';
        $.ajax({
            url: info_url,
            type: 'GET',
            data: {company_id:  $('#company_id').val(), city_id:  $('#city_id').val()},
            dataType: 'json'
        }).done(function (data) {
            $("#absence_type_id").html('');
            var html = '<option value="">Absence Type</option>';

            jQuery.each(data.data, function (i, value) {
                html += '<option value="' + value.id + '">' + value.title + ' (' + value.days+ ')</option>';


            });

            $("#absence_type_id").val('');
            $('#absence_type_id').selectize()[0].selectize.destroy();
            $('#absence_type_id').html(html);
            $('#absence_type_id').selectize();

        });
    });




</script>
