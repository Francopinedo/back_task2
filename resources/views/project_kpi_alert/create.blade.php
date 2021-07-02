<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    	<form role="form" method="POST" action="{{ url('project_kpi_alerts') }}" id="data-form" data-redirect-on-success="{{ url('project/rows/'.$project_id) }}">
    	    {{ csrf_field() }}
    	    <input type="hidden" name="project_id" value="{{ $project_id }}">
    		<div class="uk-width-medium-1-1 uk-row-first">

    			<div class="md-input-wrapper">
    				<select name="kpi_id" data-md-selectize>
    				    <option value="">{{ __('project_kpi_alerts.kpi') }}...</option>
    				    @foreach ($kpis as $kpi)
    				        <option value="{{ $kpi->id }}">{{ $kpi->description }}</option>
    				    @endforeach
    				</select>
    			</div>
    			<div class="parsley-errors-list filled"><span class="parsley-required kpi_id-error"></span></div>
<br><br><br><br><br><br>

                <div class="md-input-wrapper">
                	<label>{{ __('project_kpi_alerts.red_alert') }}</label>
                	<input type="text" class="md-input" name="red_alert" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required red_alert-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('project_kpi_alerts.yellow_alert') }}</label>
                	<input type="text" class="md-input" name="yellow_alert" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required yellow_alert-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('project_kpi_alerts.green_alert') }}</label>
                	<input type="text" class="md-input" name="green_alert" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required percent_green_alert-error"></span></div>


				<div class="md-input-wrapper">
                	<label>{{ __('project_kpi_alerts.percent_red_alert') }}</label>
                	<input type="text" class="md-input" name="percent_red_alert" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required percent_red_alert-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('project_kpi_alerts.percent_yellow_alert') }}</label>
                	<input type="text" class="md-input" name="percent_yellow_alert" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required percent_yellow_alert-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('project_kpi_alerts.percent_green_alert') }}</label>
                	<input type="text" class="md-input" name="percent_green_alert" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required percent_green_alert-error"></span></div>



				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('project_kpi_alerts.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

    	</form>
    </div>
</div>

