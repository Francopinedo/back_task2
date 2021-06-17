<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('emails') }}" id="data-form" data-redirect-on-success="{{ url('emails') }}">
    	    {{ csrf_field() }}
            <input type="hidden" name="added_by" value="form">
    	    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
            <div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper">
                	<label>{{ __('emails.title') }}</label>
                	<input type="text" class="md-input" name="title" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('emails.subject') }}</label>
                	<input type="text" class="md-input" name="subject"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required subject-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('emails.message') }}</label>
                	<input type="text" class="md-input" name="body"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required body-error"></span></div>

                <div class="md-input-wrapper">
                	<select name="email_category_id" data-md-selectize>
                	    <option value="">{{ __('emails.email_category_name') }}...</option>
                	    @foreach ($email_categories as $email_category)
                	        <option value="{{ $email_category->id }}">{{ $email_category->title }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required email_category_id-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('emails.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

