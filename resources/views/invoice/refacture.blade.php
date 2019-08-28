<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

        <form role="form" method="POST" action="{{ url('invoices') }}" id="data-form"
              data-redirect-on-success="{{ url('invoices/rows/') }}">
            {{ csrf_field() }}
            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
            <div class="uk-width-medium-1-1 uk-row-first">


                <div class="md-input-wrapper">
                    <label>{{ __('invoices.number') }}</label>
                    <textarea class="md-input" name="justification" required></textarea>
                    <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required number-error"></span></div>


                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="add-btn">{{ __('invoices.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                       id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>

    </div>
</div>

