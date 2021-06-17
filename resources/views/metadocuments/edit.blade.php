<style>

    .uk-datepicker{
        min-width: initial!important;
        width: 215px!important;
    }
</style>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
        <form role="form" method="POST" action="{{ url('metadocuments/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('metadocuments') }}">
                <input type="hidden" name="id" value="{{$metadocument->id}}">
    	        @include('metadocuments.form')
				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('metadocuments.update') }}</a>
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
