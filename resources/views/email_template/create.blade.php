<style>

    #create_div.switcher_active{
        width: 600px;
    }
</style>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('email_templates') }}" id="data-form" data-redirect-on-success="{{ url('email_templates') }}">
    	    {{ csrf_field() }}
            <input type="hidden" name="added_by" value="form">
            <div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('email_templates.title') }}</label>
                	<input type="text" class="md-input" name="title" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('email_templates.subject') }}</label>
                	<input type="text" class="md-input" name="subject"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required subject-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('email_templates.body') }}</label>
                    <textarea  class="md-input" name="body"></textarea> <span class="md-input-bar"></span>

                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required body-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                	<label>{{ __('email_templates.email_category_template_name') }}</label>
                	<select name="email_category_template_id" data-md-selectize>
                	    <option value="">{{ __('email_templates.email_category_template_name') }}...</option>
                	    @foreach ($email_category_templates as $email_category_template)
                	        <option value="{{ $email_category_template->id }}">{{ $email_category_template->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email_category_template_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('email_templates.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

