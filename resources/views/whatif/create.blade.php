<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('whatif') }}" id="data-form" >
    	    {{ csrf_field() }}
            <input type="hidden" name="user_id" id="user_id" value="{{ \Auth::id() }}">

    	     <input type="hidden" name="project_id" value="{{ session('project_id') }}">
    		<div class="uk-width-medium-1-1 uk-row-first">


    		
         

                <div class="md-input-wrapper">
                	<label>{{ __('whatif.comment') }}</label>
                	<input type="text" class="md-input" name="comment" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

               

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('whatif.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
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

    //tasks.initEditForm();
    altair_forms.init();
</script>
