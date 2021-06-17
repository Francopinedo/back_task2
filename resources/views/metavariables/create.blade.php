<style>

    #create_div.switcher_active{
        width: 600px;
    }
</style>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>
		<form role="form" method="POST" action="{{ url('metavariables') }}" id="data-form" data-redirect-on-success="{{ url('metavariables') }}">
				@include('metavariables.form')

				<div class="uk-margin-medium-top">
					<a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('metavariables.add_new') }}</a>
					<a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
				</div>
			</div>
		</form>
    </div>
</div>

