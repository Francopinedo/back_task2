<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

        <form role="form" method="POST" action="{{ url('absences/update') }}" id="data-form-edit"
              data-redirect-on-success="{{ url('absences') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $absence->id }}">
            <input type="hidden" name="company_id" id="company_id2" value="{{ $company->id }}">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('absences.country') }}</label>
                    <select id="country_id2"  data-md-selectize>
                        <option value="">{{ __('absences.country') }}...</option>
                        @foreach ($countries as $country)
                            <option   {{ ($country->id == $absence_type->country_id) ? 'selected' : '' }}  value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id2-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('absences.city') }}</label>
                    <select id="city_id2" data-md-selectize >
                        <option value="">{{ __('absences.city') }}...</option>
                        @foreach ($cities as $city)
                            <option {{ ($city->id == $absence_type->city_id) ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id2-error"></span></div>


                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('absences.select_a_type_of_absence') }}</label>
                    <select id="absence_type_id2" name="absence_type_id" data-md-selectize>
                        <option value="-1" disabled selected hidden>{{ __('absences.select_a_type_of_absence') }}...
                        </option>
                        @foreach ($absenceTypes as $absence_type)
                            <option value="{{ $absence_type->id }}" {{ ($absence_type->id == $absence->absence_type_id) ? 'selected' : '' }}>{{ $absence_type->title }} ({{ $absence_type->days }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required absence_type_id-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('absences.comment') }}</label>
                    <input type="text" class="md-input" name="comment" value="{{ $absence->comment }}"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('absences.from') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="from"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ $absence->from }}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required from-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('absences.to') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="to"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ $absence->to }}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required to-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('absences.user') }}</label>
                    <select name="user_id" data-md-selectize>
                        <option value="">{{ __('absences.user') }}...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ ($user->id == $absence->user_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="update-btn">{{ __('absences.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
    $('.cancel-edit-btn').on('click', function (e) {
        e.preventDefault();
        $('#edit_div_toggle').hide();
        $('#edit_div').removeClass('switcher_active');
    });


        $('#country_id2').selectize();
        $('#country_id2').selectize();
        $('#country_id2').on('change', function () {
            console.log('change');
            var info_url = API_PATH + '/cities';
            $.ajax({
                url: info_url,
                type: 'GET',
                data: {country_id:  $('#country_id').val()},
                dataType: 'json'
            }).done(
                function (data) {
                    $("#city_id2").html('');

                    $('#absence_type_id2').selectize()[0].selectize.destroy();
                    $("#absence_type_id2").val('');
                    $("#absence_type_id2").html('');
                    var html = '<option value="">Absence Type</option>';
                    $('#absence_type_id2').html(html);
                    $('#absence_type_id2').selectize();

                    $('#city_id2').selectize()[0].selectize.destroy();
                    var html = '<option value="">City</option>';
                    jQuery.each(data.data, function (i, value) {
                        html += '<option value="' + value.id + '">' + value.name +  '</option>';


                    });

                    $('#city_id2').html(html);
                    $('#city_id2').selectize();

                }
            );
        });

        $('#city_id2').on('change', function () {
            var info_url = API_PATH + '/absence_types';
            $.ajax({
                url: info_url,
                type: 'GET',
                data: {company_id:  $('#company_id2').val(), city_id:  $('#city_id2').val()},
                dataType: 'json'
            }).done(function (data) {
                $("#absence_type_id2").html('');
                var html = '<option value="">Absence Type</option>';

                jQuery.each(data.data, function (i, value) {
                    html += '<option value="' + value.id + '">' + value.title + ' (' + value.days+ ')</option>';


                });

                $("#absence_type_id2").val('');
                $('#absence_type_id2').selectize()[0].selectize.destroy();
                $('#absence_type_id2').html(html);
                $('#absence_type_id2').selectize();

            });
        });


        tableActions.initEditForm();


</script>