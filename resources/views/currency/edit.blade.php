<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('currencies/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('currencies') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $currency->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('currencies.name') }}</label>
                	<input type="text" class="md-input" name="name" value="{{ $currency->name }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('currencies.code') }}</label>
                	<input type="text" class="md-input" name="code" value="{{ $currency->code }}" required><span class="md-input-bar "></span>
                </div>
				<div class="parsley-errors-list filled"><span class="parsley-required code-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('currencies.update') }}</a>
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

    tableActions.initEditForm();
</script>