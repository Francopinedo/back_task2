<style>

  #create_div.switcher_active {
      width: 50%;
  }
</style>

<form role="form" method="POST" action="{{ url('wiki') }}" id="data-form-create" data-redirect-on-success="{{ url('wiki') }}" enctype="multipart/form-data" files="true">
    
  <div class="uk-grid" data-uk-grid-margin>
    <li class="uk-width-medium-1-1 uk-row-first">
      <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>
    </li>
    {{ csrf_field() }}
    <input type="hidden" name="company_id" value="{{ $company->id }}">
    <li class="uk-width-medium-1-2 uk-row-first">

      <div class="md-input-wrapper md-input-filled md-input-select">
        <label>{{ __('wiki.customer_code') }}</label>
        <select name="customer_id" data-md-selectize>
          <option value="">{{ __('wiki.customer_code') }}...</option>
          @foreach ($customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="parsley-errors-list filled"><span class="parsley-required customer_code-error"></span></div>

      <div class="md-input-wrapper md-input-filled md-input-select">
        <label>{{ __('wiki.project_code') }}</label>
        <select name="project_id" data-md-selectize>
          <option value="">{{ __('agendas.project') }}...</option>
          @foreach ($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="parsley-errors-list filled"><span class="parsley-required project_code-error"></span></div>

      <div class="md-input-wrapper md-input-select">
        <label>{{ __('wiki.process_group_code') }}</label>
        <select name="process_group_code" data-md-selectize>
          <option value="">{{ __('wiki.process_group') }}...</option>
          <option value="{{ __('wiki.initiating') }}">{{ __('wiki.initiating') }}</option>
          <option value="{{ __('wiki.planning') }}">{{ __('wiki.planning') }}</option>
          <option value="{{ __('wiki.executing') }}">{{ __('wiki.executing') }}</option>
          <option value="{{ __('wiki.monitoring') }}">{{ __('wiki.monitoring') }}</option>
          <option value="{{ __('wiki.closing') }}">{{ __('wiki.closing') }}</option>
        </select>
      </div>
      <div class="parsley-errors-list filled"><span class="parsley-required process_group_code-error"></span></div>

      <div class="md-input-wrapper md-input-select">
        <label>{{ __('wiki.knowledge_code') }}</label>
        <select name="knowledge_code" data-md-selectize>
          <option value="">{{ __('wiki.knowledge_area') }}...</option>
          <option value="{{ __('wiki.integration_management') }}">{{__('wiki.integration_management')}}</option>
          <option value="{{__('wiki.scope_management')}}">{{__('wiki.scope_management')}}</option>
          <option value="{{__('wiki.time_management')}}">{{__('wiki.time_management')}}</option>
          <option value="{{__('wiki.cost_management')}}">{{__('wiki.cost_management')}}</option>
          <option value="{{__('wiki.quality_management')}}">{{__('wiki.quality_management')}}</option>
          <option value="{{__('wiki.team_management')}}">{{__('wiki.team_management')}}</option>
          <option value="{{__('wiki.communication_management')}}">{{__('wiki.communication_management')}}</option>
          <option value="{{__('wiki.risk_management')}}">{{__('wiki.risk_management')}}</option>
          <option value="{{__('wiki.stakeholder_management')}}">{{__('wiki.stakeholder_management')}}t</option>
          <option value="{{__('wiki.procurement_management')}}">{{__('wiki.procurement_management')}}</option>
        </select>
      </div>
      <div class="parsley-errors-list filled"><span class="parsley-required knowledge_code-error"></span></div>


      <div class="md-input-wrapper md-input-select">
        <label>{{ __('wiki.swot_code') }}</label>
        <select name="swot_code" data-md-selectize>
          <option value="">{{ __('wiki.swot_code') }}...</option>
          <option value="{{ __('wiki.trength') }}">{{__('wiki.trength')}}</option>
          <option value="{{__('wiki.weaknesses')}}">{{__('wiki.weaknesses')}}</option>
          <option value="{{__('wiki.opportunities')}}">{{__('wiki.opportunities')}}</option>
          <option value="{{__('wiki.threats')}}">{{__('wiki.threats')}}</option>
        </select>
      <div class="parsley-errors-list filled"><span class="parsley-required swot_code-error"></span></div>
    </li>

    <li class="uk-width-medium-1-2 uk-row-first">
      <div class="md-input-wrapper md-input-filled">
        <label>{{ __('wiki.explanation') }}</label>
        <input type="text" class="md-input" name="explanation" max="700" maxlength="700"><span class="md-input-bar"></span>
      </div>
      <div class="parsley-errors-list filled"><span class="parsley-required explanation-error"></span></div>

      <div class="md-input-wrapper md-input-filled">
        <label>{{ __('wiki.action_taken') }}</label>
        <input type="text" class="md-input" name="action_taken" max="700" maxlength="700"><span class="md-input-bar"></span>
      </div>
      <div class="parsley-errors-list filled"><span class="parsley-required action_taken-error"></span></div>

      <div class="md-input-wrapper md-input-filled">
        <label>{{ __('wiki.additionals_comments') }}</label>
        <input type="text" class="md-input" name="additionals_comments" max="475" maxlength="475"><span class="md-input-bar"></span>
      </div>
      <div class="parsley-errors-list filled"><span class="parsley-required additionals_comments-error"></span></div>

      <div class="md-input-wrapper md-input-select">
        <label>{{ __('wiki.attached_file') }}</label>   
        <br/>
        <div class="thumbnail">
          <img alt="logo" id="attached_file_img" src="{{ URL::to('/') }}/assets/img/avatardefault.png">
        </div>  

        <a class="uk-form-file md-btn" id="upload_widget_opener">Upload image
          <input  type="file" id="attached_file" name="attached_file" accept="image/*" onchange="document.getElementById('attached_file_img').src =window.URL.createObjectURL(this.files[0])">
        </a>
      </div>
      <div class="parsley-errors-list filled"><span class="parsley-required attached_file-error"></span></div>     
    </li>

    <li class="uk-width-medium-1-1 uk-row-first">
      <div class="uk-margin-medium-top">
        <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('contracts.add_new') }}</a>
        <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
      </div>

    </li>

  </div>

</form>

<script>
  var form = $('#data-form-create');
  $('#add-btn').on('click', function (e) {
    form.submit();
  });

  $(form).submit(function (e) {
    var formdata = new FormData(form.get(0));
    e.preventDefault();
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: formdata,
      dataType: 'json',
      processData: false, //For posting uploaded files we add this
      contentType: false, //For posting uploaded files we add this
      success: function (json) {
        window.location.replace(form.data('redirect-on-success'));
      },
      error: function (json) {
        if (json.status === 422) {
          var errors = json.responseJSON;
          $.each(json.responseJSON, function (key, value) {
            $('#' + key + '-error').html(value);
          });
        } else {
          // Error
        }
      }
    });
  });
</script>


