<style>
    #rate, #quantity{
        padding-top: 25px;
    }
</style>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

        <form role="form" method="POST" action="{{ url('task_resources/update') }}" id="data-form-edit"
              data-redirect-on-success="{{ url('tasks/'.$taskResource->task_id.'/rows') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $taskResource->id }}">
            <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
            <input type="hidden" name="task_id" id="company_id" value="{{ $taskResource->task_id }}">
            <input type="hidden" name="task_estimated_hours" id="company_id" value="{{ $task->estimated_hours }}">
            <div class="uk-width-medium-1-1 uk-row-first">

                <label>{{ __('tasks.role') }}</label>
                <div class="md-input-wrapper md-input-select">
                    <select name="project_role_id" id="project_role_id" data-md-selectize>
                        <option value="">{{ __('tasks.role') }}...</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ ($role->id == $taskResource->project_role_id) ? 'selected' : '' }}>{{ $role->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>


                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.seniority') }}</label>
                    <select required name="seniority_id" id="seniority_id" data-md-selectize>
                        <option value="">{{ __('projects.seniority') }}...</option>
                        @foreach ($seniorities as $seniority)
                            <option value="{{ $seniority->id }}" {{ ($seniority->id == $taskResource->seniority_id) ? 'selected' : '' }}>{{ $seniority->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seniority_id-error"></span></div>

                <label>{{ __('tasks.user') }}</label>
                <div class="md-input-wrapper md-input-select">
                    <select name="user_id" id="user_id" data-md-selectize>
                        <option value="">{{ __('tasks.user') }}...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ ($user->id == $taskResource->user_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required user_id-error"></span></div>


                <label>{{ __('tasks.currency') }}</label>

                <div class="md-input-wrapper">
                    <select name="currency_id" id="currency_id" data-md-selectize>
                        <option value="">{{ __('tasks.currency') }}...</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ (isset($taskResource->currency_id) && $currency->id == $taskResource->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>



                <div class="md-input-wrapper">
                    <label>{{ __('tasks.rate') }}</label>
                    <input type="text" class="md-input" value="{{$taskResource->rate}}" name="rate" id="rate"
                           required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required rate-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tasks.hours') }}</label>
                    <input type="text" class="md-input" value="{{$taskResource->quantity}}" name="quantity"
                           id="quantity" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quantity-error"></span></div>


                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="update-btn">{{ __('contracts.update')}}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>
<script src="{{ asset('js/tasksRows.js') }}"></script>
<script type="text/javascript">
    $('.cancel-edit-btn').on('click', function (e) {
        e.preventDefault();
        $('#edit_div_toggle').hide();
        $('#edit_div').removeClass('switcher_active');
    });
    //taskRows.initResources();
    tableActions.initEditForm();

    $('#project_role_id,#seniority_id,#currency_id,#workplace').on('change', function () {

        if ($('#project_role_id').val() != '' && $('#seniority_id').val() != '' && $('#currency_id').val() != '' && $('#workplace').val() != '') {
            var info_url = API_PATH + 'rates?company_id=' + $('#company_id').val() + '&project_role_id=' + $('#project_role_id').val()
                + '&seniority_id=' + $('#seniority_id').val() + '&currency_id=' + $('#currency_id').val();
            //+ '&workplace=' + $('#workplace').val();

            $.ajax({
                url: info_url,
                type: 'GET',
                dataType: 'json'
            }).done(
                function (data) {
                    $('#rate').val(data[0].value);
                    $('#rate_id').val(data[0].id);
                }
            );
        }
    });

</script>