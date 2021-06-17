<style>

    #create_div.switcher_active {
        width: 600px;
    }

    .uk-width-medium-1-2 {
        padding: 5px
    }
</style>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">


        <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

        @if(session()->has('message'))
            <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                <a href="#" class="uk-alert-close uk-close"></a>
                {{ session('message') }}
            </div>
        @endif


        <form role="form" method="POST" action="{{ url('task') }}" id="data-form">
            {{ csrf_field() }}
            <input type="hidden" name="project_id" value="{{ session('project_id') }}">
            <div class="uk-width-medium-1-2 uk-row-first uk-pading-left">

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.description') }}</label>
                    <input type="text" class="md-input" name="description" id="description" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.start_date') }}</label>
                    <input class="md-input" type="text" id="start_date" name="start_date"
                           data-uk-datepicker="{format:'YYYY-MM-DD', minDate:'{{$project->start}}'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start_date-error"></span></div>


                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.due_date') }}</label>
                    <input class="md-input" type="text" id="due_date" name="due_date"
                           data-uk-datepicker="{format:'YYYY-MM-DD',  minDate:'{{$project->start}}'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('whatif_tasks.requirements') }}</label>
                    <select name="requirement_id" id="requirement_id" data-md-selectize>
                        <option value="">{{ __('whatif_tasks.requirements') }}...</option>
                        @foreach ($requirements as $requirement)
                            <option value="{{ $requirement->id }}">{{ $requirement->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required requirement_id-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('whatif_tasks.progress') }}</label>
                    <input type="number" class="md-input" id="progress" name="progress" value="0" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required progress-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('whatif_tasks.depends') }}</label>
                    <input type="text" class="md-input" name="depends" value="" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required depends-error"></span></div>



                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('whatif_tasks.priority') }}</label>
                    <select name="priority" id="priority" data-md-selectize>
                        <option value="1">{{ __('whatif_tasks.low') }}...</option>
                        <option value="2">{{ __('whatif_tasks.medium') }}...</option>
                        <option value="3">{{ __('whatif_tasks.high') }}...</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required priority-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.estimated_hours') }}</label>
                    <input type="number" readonly class="md-input" name="estimated_hours" id="estimated_hours" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_hours-error"></span>
                </div>
            </div>
            <div class="uk-width-medium-1-2 uk-pading-left">
                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.burned_hours') }}</label>
                    <input readonly type="number" class="md-input" name="burned_hours" id="burned_hours"    required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required burned_hours-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('whatif_tasks.business_value') }}</label>
                    <select name="business_value" id="business_value" data-md-selectize>
                        <option value="1">{{ __('whatif_tasks.low') }}...</option>
                        <option value="2">{{ __('whatif_tasks.medium') }}...</option>
                        <option value="3">{{ __('whatif_tasks.high') }}...</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required business_value-error"></span>
                </div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.phase') }}</label>
                    <input type="text" class="md-input" name="phase" id="phase" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required phase-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.version') }}</label>
                    <input type="text" class="md-input" name="version" id="version" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required version-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.release') }}</label>
                    <input type="text" class="md-input" name="release" id="release" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required release-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.label') }}</label>
                    <input type="text" class="md-input" name="label" id="label" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required label-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.comments') }}</label>
                    <input type="text" class="md-input" name="comments" id="comments" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comments-error"></span></div>
            </div>
            <div class="uk-width-medium-1-1 uk-pading-left">
                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="add-task">{{ __('whatif_tasks.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                       id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
    $('#cancel-btn').on('click', function (e) {
        e.preventDefault();
        $('#create_div_toggle').hide();
        $('#create_div').removeClass('switcher_active');
    });

    //whatif_tasks.initEditForm();
    altair_forms.init();
</script>