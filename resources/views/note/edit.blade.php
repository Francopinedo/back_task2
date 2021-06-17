<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	<form role="form" method="POST" action="{{ url('notes/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('notes') }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $note->id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('notes.title') }}</label>
                	<input type="text" class="md-input" name="title" value="{{ $note->title }}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required title-error"></span></div>

				<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('notes.content') }}</label>
                	<textarea class="md-input" name="description" required> {{ $note->description }}</textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<div class="uk-form-row">
						<div class="uk-width-medium-1-1">
                            <span class="icheck-inline">
<div class="md-card md-bg-white-500-notes">
                                <input type="radio" name="color" name="white" value="white" data-md-icheck {{ ($note->color == NULL) ? 'checked' : '' }}/>
                                <label class="inline-label">{{ __('notes.white') }}</label>
</div>
                            </span>
                            <span class="icheck-inline">
<div class="md-card md-bg-green-500-notes">
                                <input type="radio" name="color" name="green" value="green" data-md-icheck {{ ($note->color == 'green') ? 'checked' : '' }} />
                                <label class="inline-label " style="padding: 5px;">{{ __('notes.green') }}</label>
</div>
                            </span>
                            <span class="icheck-inline">
<div class="md-card md-bg-yellow-500-notes">
                                <input type="radio" name="color" name="yellow" value="yellow" data-md-icheck {{ ($note->color == 'yellow') ? 'checked' : '' }} />
                                <label class="inline-label " style="padding: 5px;">{{ __('notes.yellow') }}</label>
</div>
                            </span>
                            <span class="icheck-inline">
<div class="md-card md-bg-red-500-notes">
                                <input type="radio" name="color" name="red" value="red" data-md-icheck {{ ($note->color == 'red') ? 'checked' : '' }} />
                                <label class="inline-label " style="padding: 5px;">{{ __('notes.red') }}</label>
</div>
                            </span>
                        </div>
    	            </div>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required color-error"></span></div>

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('notes.update') }}</a>
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