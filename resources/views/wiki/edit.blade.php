
<style>

  #edit_div.switcher_active {
      width: 50%;
  }

</style>
    
<form role="form" enctype="multipart/form-data" method="POST" id="data-form-edit" action="{{ url('wiki/update') }}"   data-redirect-on-success="{{ url('wiki') }}">
  <div class="uk-grid" data-uk-grid-margin>
  <li class="uk-width-medium-1-1 uk-row-first">
    <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
  </li>
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $wiki->id }}">

  <li class="uk-width-medium-1-2 uk-row-first">
    <div class="md-input-wrapper md-input-filled md-input-select">
      <label>{{ __('wiki.customer_code') }}</label>
      <select name="customer_id" data-md-selectize>
        <option value="">{{ __('wiki.customer_code') }}...</option>
        @foreach ($customers as $customer)
          <option value="{{ $customer->id }}" {{ ($customer->id == $wiki->customer_id) ? 'selected' : '' }}>{{ $customer->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required customer_code-error"></span></div>

    <div class="md-input-wrapper md-input-filled md-input-select">
      <label>{{ __('wiki.project_code') }}</label>
      <select name="project_id" data-md-selectize>
        <option value="">{{ __('agendas.project') }}...</option>
        @foreach ($projects as $project)
          <option value="{{ $project->id }}" {{ ($project->id == $wiki->project_id) ? 'selected' : '' }}>{{ $project->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required project_code-error"></span></div>

    <div class="md-input-wrapper md-input-select">
      <label>{{ __('wiki.process_group_code') }}</label>
      <select name="process_group_code" data-md-selectize>
        <option value="">{{ __('wiki.process_group') }}...</option>
        <option value="{{ __('wiki.initiating') }}" {{ ($wiki->process_group_code == 'Initiating') ? 'selected' : '' }}>{{ __('wiki.initiating') }}</option>
        <option value="{{ __('wiki.planning') }}" {{ ($wiki->process_group_code == 'Planning') ? 'selected' : '' }}>{{ __('wiki.planning') }}</option>
        <option value="{{ __('wiki.executing') }}" {{ ($wiki->process_group_code == 'Executing') ? 'selected' : '' }}>{{ __('wiki.executing') }}</option>
        <option value="{{ __('wiki.monitoring') }}" {{ ($wiki->process_group_code == 'Monitoring & Control') ? 'selected' : '' }}>{{ __('wiki.monitoring') }}</option>
        <option value="{{ __('wiki.closing') }}" {{ ($wiki->process_group_code == 'Closing') ? 'selected' : '' }}>{{ __('wiki.closing') }}</option>
      </select>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required process_group_code-error"></span></div>

    <div class="md-input-wrapper md-input-select">
      <label>{{ __('wiki.knowledge_code') }}</label>
      <select name="knowledge_code" data-md-selectize>
        <option value="">{{ __('wiki.knowledge_area') }}...</option>
        <option value="{{ __('wiki.integration_management') }}" {{ ($wiki->knowledge_code == 'Integration Management') ? 'selected' : '' }}>{{__('wiki.integration_management')}}</option>
        <option value="{{__('wiki.scope_management')}}" {{ ($wiki->knowledge_code == 'Scope Management') ? 'selected' : '' }}>{{__('wiki.scope_management')}}</option>
        <option value="{{__('wiki.time_management')}}" {{ ($wiki->knowledge_code == 'Time Management') ? 'selected' : '' }}>{{__('wiki.time_management')}}</option>
        <option value="{{__('wiki.cost_management')}}" {{ ($wiki->knowledge_code == 'Cost Management') ? 'selected' : '' }}>{{__('wiki.cost_management')}}</option>
        <option value="{{__('wiki.quality_management')}}" {{ ($wiki->knowledge_code == 'Quality Management') ? 'selected' : '' }}>{{__('wiki.quality_management')}}</option>
        <option value="{{__('wiki.team_management')}}" {{ ($wiki->knowledge_code == 'Team Management') ? 'selected' : '' }}>{{__('wiki.team_management')}}</option>
        <option value="{{__('wiki.communication_management')}}" {{ ($wiki->knowledge_code == 'Communication Management') ? 'selected' : '' }}>{{__('wiki.communication_management')}}</option>
        <option value="{{__('wiki.risk_management')}}" {{ ($wiki->knowledge_code == 'Risk Management') ? 'selected' : '' }}>{{__('wiki.risk_management')}}</option>
        <option value="{{__('wiki.stakeholder_management')}}" {{ ($wiki->knowledge_code == 'Stakeholder Management') ? 'selected' : '' }}>{{__('wiki.stakeholder_management')}}t</option>
        <option value="{{__('wiki.procurement_management')}}" {{ ($wiki->knowledge_code == 'Procurement Management') ? 'selected' : '' }}>{{__('wiki.procurement_management')}}</option>
      </select>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required knowledge_code-error"></span></div>


    <div class="md-input-wrapper md-input-select">
      <label>{{ __('wiki.swot_code') }}</label>
      <select name="swot_code" data-md-selectize>
        <option value="">{{ __('wiki.swot_code') }}...</option>
        <option value="{{ __('wiki.trength') }}" {{ ($wiki->swot_code == 'Strenghts') ? 'selected' : '' }}>{{__('wiki.trength')}}</option>
        <option value="{{__('wiki.weaknesses')}}" {{ ($wiki->swot_code == 'Weaknesses') ? 'selected' : '' }}>{{__('wiki.weaknesses')}}</option>
        <option value="{{__('wiki.opportunities')}}" {{ ($wiki->swot_code == 'Opportunities') ? 'selected' : '' }}>{{__('wiki.opportunities')}}</option>
        <option value="{{__('wiki.threats')}}" {{ ($wiki->swot_code == 'Threats') ? 'selected' : '' }}>{{__('wiki.threats')}}</option>
      </select>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required swot_code-error"></span></div>
  </li>

  <li class="uk-width-medium-1-2 uk-row-first">
    <div class="md-input-wrapper md-input-filled">
      <label>{{ __('wiki.explanation') }}</label>
      <input type="text" class="md-input" name="explanation" max="700" maxlength="700" value="{{ $wiki->explanation }}"><span class="md-input-bar"></span>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required explanation-error"></span></div>

    <div class="md-input-wrapper md-input-filled">
      <label>{{ __('wiki.action_taken') }}</label>
      <input type="text" class="md-input" name="action_taken" max="700" maxlength="700" value="{{ $wiki->action_taken }}"><span class="md-input-bar"></span>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required action_taken-error"></span></div>

    <div class="md-input-wrapper md-input-filled">
      <label>{{ __('wiki.additionals_comments') }}</label>
      <input type="text" class="md-input" name="additionals_comments" max="475" maxlength="475" value="{{ $wiki->additionals_comments }}"><span class="md-input-bar"></span>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required additionals_comments-error"></span></div>

     <div class="md-input-wrapper md-input-select">
      <label>{{ __('wiki.attached_file') }}</label>
      <br/>
      <div class="thumbnail">
        @if (empty($wiki->attached_file) || $wiki->attached_file=='')
          <img alt="screen" id="attached_file_img2" src="{{ URL::to('/') }}/assets/img/avatardefault.png">
        @else
          <img src="{{ URL::to('/') .'/assets/img/wiki/'. $wiki->id .'/'. $wiki->attached_file }}" id="attached_file_img2" alt="screen" >
        @endif
      </div>  

      <a class="uk-form-file md-btn" id="upload_widget_opener">Upload image
        <input  type="file" id="attached_file" name="attached_file" accept="image/*" onchange="document.getElementById('attached_file_img2').src =window.URL.createObjectURL(this.files[0])">
      </a>
    </div>
    <div class="parsley-errors-list filled"><span class="parsley-required attached_file-error"></span></div> 
  </li>

  <li class="uk-width-medium-1-1 uk-row-first">
    <div class="uk-margin-medium-top">
      <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('providers.update') }}</a>
      <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn" href="#">{{ __('general.cancel') }}</a>
    </div>
  </li>

</div>
</form>

<script type="text/javascript">
  $('.cancel-edit-btn').on('click', function(e){
    e.preventDefault();
    $('#edit_div_toggle').hide();
    $('#edit_div').removeClass('switcher_active');
  });

  // tableActions.initEditForm();

  var form = $('#data-form-edit');
  $('#update-btn').on('click', function (e) {
      form.submit();
  });

  $(form).submit(function (event) {
    var formdata = new FormData(form.get(0));
    event.preventDefault();
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
