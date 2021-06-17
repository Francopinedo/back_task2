<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('additional_hours/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('additional_hours') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $additionalHour->id }}">

            <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
            <input type="hidden" name="rate_id" id="rate_id2" value="{{ $additionalHour->rate_id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <select required name="project_role_id" id="project_role_id2" data-md-selectize>
                        <option value="">{{ __('contracts.project_role') }}...</option>
                        @foreach ($projectRoles as $projectRole)
                            <option value="{{ $projectRole->id }}" {{ ($projectRole->id == $additionalHour->project_role_id) ? 'selected' : '' }}>{{ $projectRole->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_role_id-error"></span></div>


                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('additional_hours.user') }}</label>
                    <select name="user_id" id="user_id2" data-md-selectize>
                        <option value="">{{ __('additional_hours.user') }}...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}" {{ ($user->user_id == $additionalHour->user_id) ? 'selected' : '' }}>{{ $user->user_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                    <select required name="seniority_id" id="seniority_id2" data-md-selectize>
                        <option value="">{{ __('contracts.seniority') }}...</option>
                        @foreach ($seniorities as $seniority)
                            <option value="{{ $seniority->id }}" {{ ($seniority->id == $additionalHour->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <select required name="currency_id" id="currency_id2" data-md-selectize>
                        <option value="">{{ __('contracts.currency') }}...</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ ($currency->id == $additionalHour->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <select required name="workplace" id="workplace2" data-md-selectize>
                        <option value="">{{ __('contracts.workplace') }}...</option>
                        <option value="onsite" {{ ($additionalHour->workplace == 'onsite') ? 'selected' : '' }}>{{ __('contracts.onsite') }}...</option>
                        <option value="offshore" {{ ($additionalHour->workplace == 'offshore') ? 'selected' : '' }}>{{ __('contracts.offshore') }}...</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required workplace-error"></span></div>


                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('rates.country') }}</label>
                    <select required name="country_id" id="country_id2" data-md-selectize>
                        <option value="">{{ __('rates.country') }}...</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ ($country->id == $additionalHour->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required country_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.city') }}</label>
                    <select name="city_id" id="city_id2" data-md-selectize>
                        <option value="">{{ __('rates.city') }}...</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ ($city->id == $additionalHour->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>

                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required city_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('rates.office') }}</label>
                    <select name="office_id"  id="office_id2"  required>
                        <option value="">{{ __('rates.office') }}...</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}" {{ ($office->id == $additionalHour->office_id) ? 'selected' : '' }}>{{ $office->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required office_id-error"></span></div>

                
                

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('additional_hours.date') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="date" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ $additionalHour->date }}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required date-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('additional_hours.hours') }}</label>
                	<input type="number" min="1" max="24" class="md-input" name="hours" value="{{ $additionalHour->hours }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required hours-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('contracts.rate') }}</label>
                    <input type="text"  class="md-input" name="rate" id="rate2" value="{{ $additionalHour->rate }}" readonly><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required rate-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('additional_hours.comments') }}</label>
                	<input type="text" class="md-input" name="comments" value="{{ $additionalHour->comments }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comments-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('additional_hours.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>
<script src="{{ asset('js/contracts.js') }}"></script>
<script type="text/javascript">
    $('.cancel-edit-btn').on('click', function(e){
        e.preventDefault();
        $('#edit_div_toggle').hide();
        $('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
    contracts.initResources();

    $("#project_role_id2").on('change', function () {
        console.log('searinch user...');
        $.ajax({
            url: API_PATH + 'users/',
            type: 'GET',
            data: {'project_role_id':$("#project_role_id2").val()},
            dataType: 'json'
        }).done(
            function (data) {
                data = data.data;
                var html = '<option value="">Users...</option>';

                if( $('#user_id2').selectize()[0]!=undefined){
                    $('#user_id2').selectize()[0].selectize.destroy();
                }



                $.each(data, function (i, value) {
                    console.log(value);
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });


                $('#user_id2').html(html);

                $('#user_id2').selectize();



            }
        );
    });
    $("#user_id2").on('change', function () {
        $.ajax({
            url:API_PATH+'/users/'+$(this).val(),
            type:'GET',
            dataType:'json',
            success:function (data) {
                console.log(data.data);

                data = data.data;

                $('#office_id2').selectize()[0].selectize.destroy();
                $('#country_id2').selectize()[0].selectize.destroy();
                $('#city_id2').selectize()[0].selectize.destroy();
                $('#seniority_id2').selectize()[0].selectize.destroy();
                $('#workplace2').selectize()[0].selectize.destroy();


                $("#office_id2").val(data.office_id);
                $("#country_id2").val(data.country_id);
                $("#city_id2").val(data.city_id);
                $("#seniority_id2").val(data.seniority_id);
                $("#workplace2").val(data.workplace);

                $('#office_id2').selectize();
                $('#country_id2').selectize();
                $('#city_id2').selectize();
                $('#seniority_id2').selectize();
                $('#workplace2').selectize();


                $.ajax({
                    url: API_PATH + '/cities',
                    type: 'GET',
                    data: {country_id: $("#country_id2").val(), company_id:$("#company_id2").val()},
                    dataType: 'json'
                }).done(
                    function (data2) {
                        var html = '<option value="">City...</option>';

                        if($('#city_id2').length>0) {
                            $('#city_id2').selectize()[0].selectize.destroy();
                        }

                        $.each(data2.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $('#city_id2').html(html);
                        $('#city_id2').val(data.city_id);
                        $('#city_id2').selectize();



                        var html = '<option value="">Office...</option>';
                        $.ajax({
                            url: API_PATH + '/offices',
                            type: 'GET',
                            data: {city_id: $("#city_id").val(), company_id:$("#company_id").val()},
                            dataType: 'json'
                        }).done(
                            function (data3) {
                                var html = '<option value="">Office...</option>';

                                if( $('#office_id2').selectize()[0]!=undefined){
                                    $('#office_id2').selectize()[0].selectize.destroy();
                                }



                                $.each(data3.data, function (i, value) {
                                    console.log(value);
                                    html += '<option value="' + value.id + '">' + value.title + '</option>';
                                });


                                $('#office_id2').html(html);
                                $('#office_id2').val(data.office_id);

                                $('#office_id2').selectize();



                            }
                        );


                    }
                );


            }
        });
    })
</script>