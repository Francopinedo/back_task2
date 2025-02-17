<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>

<form role="form" method="POST" action="{{ url('project_kpi_alerts/update') }}" id="data-form-edit" data-redirect-on-success="{{ url('project/rows/'.$projectKpiAlert->project_id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="id" value="{{ $projectKpiAlert->id }}">
              <input type="hidden" name="project_id" value="{{ $projectKpiAlert->project_id }}">

    		<div class="uk-width-medium-1-1 uk-row-first">
  <div class="md-input-wrapper md-input-filled">
                      <label>{{ $kpis->description }}  </label>
                      <br><br><br>
        <input type="hidden" name="kpi_id" value="{{ $projectKpiAlert->kpi_id }}">

                </div>

                <div class="md-input-wrapper md-input-filled">
                <label>{{ __('project_kpi_alerts.red_alert') }}</label>
                	<input type="text" class="md-input" name="red_alert" value="{{ $projectKpiAlert->red_alert }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required red_alert-error"></span></div>

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('project_kpi_alerts.yellow_alert') }}</label>
                	<input type="text" class="md-input" name="yellow_alert" value="{{ $projectKpiAlert->yellow_alert }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required yellow_alert-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('project_kpi_alerts.green_alert') }}</label>
                	<input type="text" class="md-input" name="green_alert" value="{{ $projectKpiAlert->green_alert }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required green_alert-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                <label>{{ __('project_kpi_alerts.percent_red_alert') }}</label>
                	<input type="text" class="md-input" name="percent_red_alert" value="{{ $projectKpiAlert->percent_red_alert }}" ><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required percent_red_alert-error"></span></div>

    			<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('project_kpi_alerts.percent_yellow_alert') }}</label>
                	<input type="text" class="md-input" name="percent_yellow_alert" value="{{ $projectKpiAlert->percent_yellow_alert }}" ><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required percent_yellow_alert-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                	<label>{{ __('project_kpi_alerts.percent_green_alert') }}</label>
                	<input type="text" class="md-input" name="percent_green_alert" value="{{ $projectKpiAlert->percent_green_alert }}" ><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required percent_green_alert-error"></span></div>



				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="update-btn">{{ __('project_kpi_alerts.update') }}</a>
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