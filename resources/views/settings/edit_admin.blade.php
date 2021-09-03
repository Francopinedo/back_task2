
<form role="form" method="POST" action="{{ url('settings/update') }}/{{$settings->id}}" id="data-form-edit" data-redirect-on-success="{{ url('settings') }}">
  <div class="md-card">
    <div class="md-card-content">

      <div class="uk-grid" data-uk-grid-margin>
        <li class="uk-width-1-1">

        	@if(session()->has('message'))
        		<div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
              <a href="#" class="uk-alert-close uk-close"></a>
              {{ session('message') }}
            </div>
        	@endif

					<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

    	    {{ csrf_field() }}
				</li>

        <input type="hidden" name="id" id="" value="{{$settings->id}}">
    		<li class="uk-width-medium-1-2 uk-row-first">
          <!-- Log Level -->
          <label for="log_level">{{ __('settings.log_level') }}</label>
          <div class="md-input-wrapper md-input-filled">
            @if(!empty($settings->log_level))
              <select name="log_level[]" id="log_level" multiple data-md-selectize>
                <option value="N" {{ in_array('N', $settings->log_level) ? 'selected' : '' }}>{{ __('settings.none') }}</option>
                <option value="delete" {{ in_array('delete', $settings->log_level) ? 'selected' : '' }}>Delete</option>
                <option value="store" {{ in_array('store', $settings->log_level) ? 'selected' : '' }}>Store</option>
                <option value="update" {{ in_array('update', $settings->log_level) ? 'selected' : '' }}>Update</option>
                <option value="do_import" {{ in_array('do_import', $settings->log_level) ? 'selected' : '' }}>Importar</option>
                <option value="password" {{ in_array('password', $settings->log_level) ? 'selected' : '' }}>Password</option>
                <option value="show" {{ in_array('show', $settings->log_level) ? 'selected' : '' }}>Show</option>
                <option value="edit" {{ in_array('edit', $settings->log_level) ? 'selected' : '' }}>Edit</option>
                <option value="index" {{ in_array('index', $settings->log_level) ? 'selected' : '' }}>Index</option>
                <option value="update_password" {{ in_array('update_password', $settings->log_level) ? 'selected' : '' }}>Update Password</option>
              </select>
            @endif
          </div>
          <div class="parsley-errors-list filled"><span class="parsley-required log_level-error"></span></div>
        </li>
      </div>
    </div>
  </div>

  <div class="md-card">
    <div class="md-card-content">
      <div class="uk-grid" data-uk-grid-margin>
      	<li class="uk-width-medium-1-2 uk-row-first">

          <div class=" md-input-wrapper">        
            <span><label >{{ __('settings.task_creation_email') }}</label></span>
              <input type="checkbox"  <?php if($settings->task_creation_email == '1') echo 'checked'; ?> class="md-input" name="task_creation_email" >
          </div>
          <div class="parsley-errors-list filled"><span class="parsley-required task_creation_email-error"></span></div>

          <div class="md-input-wrapper">
          <span><label>{{ __('settings.field_captions') }}</label></span>
            <input type="checkbox"  <?php if($settings->field_captions == '1') echo 'checked'; ?> class="md-input" name="field_captions" >
          </div>
          <div class="parsley-errors-list filled"><span class="parsley-required field_captions-error"></span></div>

          <div class="md-input-wrapper">        
            <br/>
            <span><label >{{ __('settings.knowledge_areas_active') }}</label></span>
              <input type="checkbox"  <?php if($settings->knowledge_areas_active == '1') echo 'checked'; ?> class="md-input" name="knowledge_areas_active" >
          </div>
          <div class="parsley-errors-list filled"><span class="parsley-required knowledge_areas_active-error"></span></div>

          <div class="md-input-wrapper">          
            <br/>
            <span><label>{{ __('settings.process_group_active') }}</label></span>
            <input type="checkbox"  <?php if($settings->process_group_active == '1') echo 'checked'; ?> class="md-input" name="process_group_active" >
          </div>
          <div class="parsley-errors-list filled"><span class="parsley-required process_group_active-error"></span></div>

          <div class="md-input-wrapper">
            <br/>
            <span><label >{{ __('settings.wiki_enabled') }}</label></span>
            <input type="checkbox"  <?php if($settings->wiki_enabled == '1') echo 'checked'; ?> class="md-input" name="wiki_enabled" >
          </div>
          <div class="parsley-errors-list filled"><span class="parsley-required wiki_enabled-error"></span></div>
        </li>

      	<li class="uk-width-medium-1-1 uk-row-first">
          <div class="uk-margin-medium-top">

            <br/>
            <br/>

            <button type="submit" class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">
              {{ __('countries.update') }}
            </button>
            <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
          </div>
        </li>
      </div>
    </div>
  </div>
</form>

@section('scripts')
  <script>
    $('#log_level').on('change', function(){
      console.log($('#log_level').val());
      for (var i = $('#log_level').val().length - 1; i >= 0; i--) {
        $('#log_level').val()[i]
      }
    });
  </script>
@endsection

