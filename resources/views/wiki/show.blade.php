<div class="info_div_header">
  <div class="uk-grid uk-grid-divider uk-grid-medium info_div_content" style="margin: auto; padding-left: 64px;">
    <div  class="uk-width-large-1-1">
      <h3>{{ __('wiki.wiki_data') }}</h3>
    </div>
  </div>
</div>

<div style="margin: auto" class="uk-grid uk-grid-divider uk-grid-medium info_div_content">

  <div class="uk-width-large-1-2">
    <ul style="margin-right: 64px" class="md-list md-list-addon">
      <li>
        <div class="md-list-content">
          <span class="uk-text-small uk-text-muted">{{__('wiki.customer_code')}}</span>
          <span class="md-list-heading">{{ $customer->name }}</span>
        </div>
      </li>
      <li>
        <div class="md-list-content">
          <span class="uk-text-small uk-text-muted">{{ __('wiki.project_code') }}</span>
          <span class="md-list-heading">{{ $project->name }}</span>
        </div>
      </li>
      <li>
        <div class="md-list-content">
          <span class="uk-text-small uk-text-muted">{{ __('wiki.project_manager') }}</span>
          <span class="md-list-heading">{{ $project_manager->name }}</span>
        </div>
      </li>
      <li>
        <div class="md-list-content">
          <span class="uk-text-small uk-text-muted">{{ __('wiki.project_mail') }}</span>
          <span class="md-list-heading">{{ $project_manager->email }}</span>
        </div>
      </li>
      <li>
        <div class="md-list-content">
          <span class="uk-text-small uk-text-muted">{{ __('wiki.office_phone') }}</span>
          <span class="md-list-heading">{{ $project_manager->office_phone }}</span>
        </div>
      </li>

      <li>
        <div class="md-list-content">
          <span class="uk-text-small uk-text-muted">{{ __('wiki.process_group_code') }}</span>
          <span class="md-list-heading">{{ $wiki->process_group_code }}</span>
        </div>
      </li>
      <li>
        <div class="md-list-content">
          <span class="uk-text-small uk-text-muted">{{ __('wiki.knowledge_code') }}</span>
          <span class="md-list-heading">{{ $wiki->knowledge_code }}</span>
        </div>
      </li>
      <li>
        <div class="md-list-content">
          <span class="uk-text-small uk-text-muted">{{ __('wiki.swot_code') }}</span>
          <span class="md-list-heading">{{ $wiki->swot_code }}</span>
        </div>
      </li>
    </ul>
  </div>
  
  <div class="uk-width-large-1-2">
    <ul style="margin-right: 64px" class="md-list md-list-addon">
      <li>
        <div class="md-list-addon-element">
          <i class="md-list-addon-icon material-icons"></i>
        </div>
        <h4 style="padding-bottom: 5px" class="md-list-heading">Screenshot</h4>
        <div class="md-list-content thumbnail">
          @if (empty($wiki->attached_file) || $wiki->attached_file=='')
            <img alt="logo" id="attached_file" src="{{ URL::to('/') }}/assets/img/avatardefault.png">
          @else
            <img src="{{ URL::to('/') .'/assets/img/wiki/'. $wiki->id .'/'. $wiki->attached_file }}" alt="" >
          @endif
        </div>
      </li>
    </ul>
  </div>
</div>

<div style="display: block; margin: auto;" class="uk-grid uk-grid-divider uk-grid-medium info_div_content">
  <div class="uk-width-large-1-1">
    <ul style="margin-right: 64px" class="md-list md-list-addon">

      <li><hr>
        <h4>{{ __('wiki.explanation') }}</h4>
        <p>{{ $wiki->explanation }}</p>
      </li>
      <li>
        <h4>{{ __('wiki.action_taken') }}</h4>
        <p>{{ $wiki->action_taken }}</p>
      </li>
      <li>
        <h4>{{ __('wiki.additionals_comments') }}</h4>
        <p>{{ $wiki->additionals_comments }}</p>
      </li>
    </ul>
  </div>
</div>

<div class="uk-flex uk-flex-center">
  <a style="background: #102672; color: white" class="uk-margin-medium-top uk-margin-medium-bottom uk-button uk-button-default uk-button-large uk-width-large-1-5" href="/wiki/pdf/{{$wiki->id}}" target="_blank">Download</a>
</div>