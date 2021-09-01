@extends('layouts.app')

@section('section_title', __('settings.settings'))

@section('content')

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
          @role('admin')
  				  <div class="md-input-wrapper">                   
              <span ><label >{{ __('settings.mail_server_enable') }}</label></span>
              <input type="checkbox"  <?php if($settings->mail_server_enable == '1') echo 'checked'; ?> class="md-input" name="mail_server_enable" >     	
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required mail_server_enable-error"></span></div>
          @endrole
          <br/>

          @role('admin')
            <div class="md-input-wrapper md-input-filled md-input-select">
            	<label>{{ __('settings.mail_server_protocol') }}</label>
            	<select name="mail_server_protocol" data-md-selectize>
                <option value="">{{ __('settings.mail_server_protocol') }}...</option>
                <option value="POP3" <?php if($settings->mail_server_protocol == "POP3") echo 'selected';?> >POP3</option>
                <option value="IMAP" <?php if($settings->mail_server_protocol == "IMAP") echo 'selected';?>>IMAP</option>
                <option value="SMTP" <?php if($settings->mail_server_protocol == "SMTP") echo 'selected';?>>SMTP</option>
            	</select>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required mail_server_protocol-error"></span></div>
          @endrole
          
          @role('admin')
            <div class="md-input-wrapper md-input-filled md-input-select">
            	<label>{{ __('settings.mail_server_encryption') }}</label>
            	<select name="mail_server_encryption" data-md-selectize>
          	    <option value="">{{ __('settings.mail_server_encryption') }}...</option>
      	        <option value="NONE"<?php if($settings->mail_server_encryption == "NONE") echo 'selected';?>>NONE</option>
      	        <option value="SSL" <?php if($settings->mail_server_encryption == "SSL") echo 'selected';?>>SSL</option>
      	        <option value="TLS" <?php if($settings->mail_server_encryption == "TLS") echo 'selected';?>>TLS</option>
            	</select>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required mail_server_encryption-error"></span></div>
          @endrole

          @role('admin')
            <div class="md-input-wrapper md-input-filled">
            	<label>{{ __('settings.mail_server_hosts') }}</label>
            	<input type="text" class="md-input" name="mail_server_hosts" value="{{ $settings->mail_server_hosts }}" ><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required mail_server_hosts-error"></span></div>
          @endrole

          @role('admin')
  				  <div class="md-input-wrapper md-input-filled">
            	<label>{{ __('settings.mail_server_port') }}</label>
            	<input type="text" class="md-input" name="mail_server_port" value="{{ $settings->mail_server_port }}" ><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required mail_server_port-error"></span></div>
          @endrole

          @role('admin')
  				  <div class="md-input-wrapper md-input-filled">
            	<label>{{ __('settings.mail_server_user') }}</label>
            	<input type="text" class="md-input" name="mail_server_user" value="{{ $settings->mail_server_user }}" ><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-mail_server_user name-error"></span></div>
          @endrole

          @role('admin')
  				  <div class="md-input-wrapper md-input-filled">
            	<label>{{ __('settings.mail_server_pass') }}</label>
            	<input type="text" class="md-input" name="mail_server_pass" value="{{ $settings->mail_server_pass }}" ><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required mail_server_pass-error"></span></div>
          @endrole

          @role('admin')
  				  <div class="md-input-wrapper md-input-filled">
            	<label>{{ __('settings.mail_server_from_email') }}</label>
            	<input type="text" class="md-input" name="mail_server_from_email" value="{{ $settings->mail_server_from_email }}" ><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required mail_server_from_email-error"></span></div>
          @endrole
          <br>
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


    		<li class="uk-width-medium-1-2 uk-row-first">

          <br/>
          <!-- Chat Server -->
          @role('admin')
  				  <div class="md-input-wrapper">    	
              <span ><label >{{ __('settings.chat_server_enable') }}</label></span>
              <input type="checkbox"  <?php if($settings->chat_server_enable == '1') echo 'checked'; ?> class="md-input" name="chat_server_enable" ></div>
            <div class="parsley-errors-list filled"><span class="parsley-required chat_server_enable-error"></span></div>
          @endrole
          <br/>
          @role('admin')
  					<div class="md-input-wrapper md-input-filled">
            	<label>{{ __('settings.chat_server_url') }}</label>
            	<input type="text" class="md-input" name="chat_server_url" value="{{ $settings->chat_server_url }}" ><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required chat_server_url-error"></span></div>
          @endrole
          <br>
          <!-- Pasarelas de pago -->
          @role('admin')
            <div class="md-input-wrapper">
              <span><label >{{ __('settings.payments_enabled') }}</label></span>   
              <input type="checkbox"  <?php if($settings->payments_enabled == '1') echo 'checked'; ?> class="md-input" name="payments_enabled" >
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required payments_enabled-error"></span></div>
          @endrole

          @role('admin')
            <div class="md-input-wrapper">
              <span ><label >{{ __('settings.payment_integration') }}</label></span>
              <input type="checkbox"  <?php if($settings->payment_integration == '1') echo 'checked'; ?> class="md-input" name="payment_integration" >
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required payment_integration-error"></span></div>
          @endrole
          <br>
          @role('admin')
            <div class="md-input-wrapper md-input-filled">
              <label>{{ __('settings.payment_gateway') }}</label>
              <select name="payment_gateway" data-md-selectize>
                <option value="">{{ __('settings.payment_gateway') }}...</option>
                <option value="Paypal" <?php if($settings->payment_gateway == "Paypal") echo 'selected';?> >Paypal</option>
                <option value="Payoneer" <?php if($settings->payment_gateway == "Payoneer") echo 'selected';?>>Payoneer</option>
                <option value="Skrill" <?php if($settings->payment_gateway == "Skrill") echo 'selected';?>>Skrill</option>
              </select>         
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required payment_gateway-error"></span></div>
          @endrole

          <br/>
          <!-- Almacenamiento en la nube -->
          @role('admin')
            <div class="md-input-wrapper">  
              <br/>
              <span><label >{{ __('settings.cloud_storage') }}</label></span>
                <input type="checkbox"  <?php if($settings->cloud_storage == '1') echo 'checked'; ?> class="md-input" name="cloud_storage" >
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required cloud_storage-error"></span></div>
          @endrole
          <br>
          @role('admin')
            <div class="md-input-wrapper md-input-filled">
              <label>{{ __('settings.cloud_storage_provider') }}</label>
              <select name="cloud_storage_provider" data-md-selectize>
                <option value="">{{ __('settings.cloud_storage_provider') }}...</option>
                <option value="Google Drive" <?php if($settings->cloud_storage_provider == "Google Drive") echo 'selected';?> >Google Drive</option>
                <option value="Azure" <?php if($settings->cloud_storage_provider == "Azure") echo 'selected';?>>Azure</option>
                <option value="DropBox" <?php if($settings->cloud_storage_provider == "DropBox") echo 'selected';?>>DropBox</option>
                <option value="AWS" <?php if($settings->cloud_storage_provider == "AWS") echo 'selected';?>>AWS</option>
              </select>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required cloud_storage_provider-error"></span></div>
          @endrole
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

          @role('admin')
            <div class=" md-input-wrapper">         
              <br/>
              <span><label >{{ __('settings.fields_add_feature') }}</label></span>
              <input type="checkbox"  <?php if($settings->fields_add_feature == '1') echo 'checked'; ?> class="md-input" name="fields_add_feature" >
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required fields_add_feature-error"></span></div>
          @endrole

          @role('admin')
            <div class="md-input-wrapper">             
              <br/>
              <span><label >{{ __('settings.alfred_active') }}</label></span>
              <input type="checkbox"  <?php if($settings->alfred_active == '1') echo 'checked'; ?> class="md-input" name="alfred_active" >
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required alfred_active-error"></span></div>
          @endrole

          @role('admin')
            <div class="md-input-wrapper">
              <br/>
              <span ><label >{{ __('settings.plugins_enabled') }}</label></span>
              <input type="checkbox"  <?php if($settings->plugins_enabled == '1') echo 'checked'; ?> class="md-input" name="plugins_enabled" >
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required plugins_enabled-error"></span></div>
          @endrole

          @role('admin')
            <div class="md-input-wrapper">      	
              <br/>
              <span ><label >{{ __('settings.digital_signature') }}</label></span>
              <input type="checkbox"  <?php if($settings->digital_signature == '1') echo 'checked'; ?> class="md-input" name="digital_signature" >
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required digital_signature-error"></span></div>
          @endrole

          @role('admin')
            <br/>
            <div class="md-input-wrapper md-input-filled">
              <span><label>{{ __('settings.max_users') }}</label></span>
              <input type="text" class="md-input" name="max_users" value="{{ $settings->max_users }}" ><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required max_users-error"></span></div>
          @endrole
        </li>

      	<li class="uk-width-medium-1-2 uk-row-first">

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

          @role('admin')
            <div class="md-input-wrapper">
              <br/>
              <span><label>{{ __('settings.version') }}</label></span > 
              <input type="text" class="md-input" name="version" value="{{ $settings->version }}" ><span class="md-input-bar"></span>
            </div>
            <div class="parsley-errors-list filled"><span class="parsley-required version-error"></span></div>
          @endrole
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

@endsection

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

