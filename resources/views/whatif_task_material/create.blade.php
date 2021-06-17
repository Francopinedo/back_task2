<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

        <form role="form" method="POST" action="{{ url('whatif_task_materials') }}" id="data-form-ajax_create"
              data-redirect-on-success="{{ url('whatif_tasks/'.$task->id.'/rows') }}">
            {{ csrf_field() }}
            <input type="hidden" name="whatif_task_id" value="{{ $task->id }}">
            <div class="uk-width-medium-1-1 uk-row-first">
                <label>{{ __('whatif_tasks.material') }}</label>
                <div class="md-input-wrapper md-input-select">
                    <select name="material_id" id="material_id">
                        <option value="">{{ __('whatif_tasks.material') }}...</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}">{{ $material->detail }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required material_id-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.detail') }}</label>
                    <input type="text" class="md-input" name="detail" id="detail" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required detail-error"></span></div>

                <div class="md-input-wrapper">
                    <select name="reimbursable" id="reimbursable" data-md-selectize>
                        <option value="1">{{ __('services.reimbursable') }}</option>
                        <option value="0">{{ __('services.no_reimbursable') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required reimbursable-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.cost') }}</label>
                    <input type="text" class="md-input" name="cost" id="materialcost" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required cost-error"></span></div>


                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.amount') }}</label>
                    <input type="text" class="md-input" name="amount" id="materialamount" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required amount-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('whatif_tasks.quantity') }}</label>
                    <input type="text" class="md-input" name="quantity" id="materialquantity" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required quantity-error"></span></div>

                <label>{{ __('whatif_tasks.currency') }}</label>
                <div class="md-input-wrapper">
                    <select name="currency_id" id="currency_id" data-md-selectize>
                        <option value="">{{ __('whatif_tasks.currency') }}...</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required currency_id-error"></span></div>

                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="ajax_create-btn">{{ __('whatif_tasks.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                       id="cancel-ajax_create-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>

<script src="{{ asset('js/whatif_tasksRows.js') }}"></script>
<script type="text/javascript">
    $('.cancel-ajax_create-btn').on('click', function (e) {
        e.preventDefault();
        $('#ajax_create_div_toggle').hide();
        $('#ajax_create_div').removeClass('switcher_active');
    });

    tableActions.initAjaxCreateForm();

    taskRows.initMaterials();



</script>