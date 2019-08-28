<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

        <form role="form" method="POST" action="{{ url('replacements') }}" id="data-form"
              data-redirect-on-success="{{ url('replacements') }}">
            {{ csrf_field() }}
            <input type="hidden" name="project_id" value="{{ session('project_id') }}">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('absences.select_an_absence') }}</label>
                    <select name="absence_id" id="absence_id" data-md-selectize>
                        <option value="">{{ __('replacements.select_an_absence') }}...</option>
                        @foreach ($absences as $absence)
                            <option value="{{ $absence->id }}">{{ $absence->user->data->name }} ({{ $absence->from }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('absences.select_a_replacement') }}</label>
                    <select name="user_id" data-md-selectize>
                        <option value="">{{ __('replacements.select_a_replacement') }}...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('replacements.from') }}</label>
                    <input class="md-input" type="text" id="from" name="from"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required from-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('replacements.to') }}</label>
                    <input class="md-input" type="text" id="to" name="to"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required to-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('replacements.ticket') }}</label>
                    <input type="text" class="md-input" name="ticket" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required ticket-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('replacements.comment') }}</label>
                    <input type="text" class="md-input" name="comment" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="add-btn">{{ __('replacements.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                       id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>
<script type="text/javascript">
    $('#absence_id').on('change', function () {
        var info_url = API_PATH + 'absences/' + $('#absence_id').val();
        $.ajax({
            url: info_url,
            type: 'GET',
            dataType: 'json'
        }).done(function (data) {


            $("#from").val(data.data.from);
            $("#to").val(data.data.to);
        });
    });
</script>