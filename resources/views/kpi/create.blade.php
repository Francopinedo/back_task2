<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">

        <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

        <form role="form" method="POST" action="{{ url('kpis') }}" id="data-form"
              data-redirect-on-success="{{ url('kpis') }}">
            {{ csrf_field() }}
            <input type="hidden" name="company_id" value="{{ $company->id }}">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('kpis.kpi') }}</label>
                    <select name="kpi" data-md-selectize>
                        <option value="EV or BCWP">EV or BCWP</option>
                        <option value="AC or ACWP">AC or ACWP</option>
                        <option value="PV or BCWS">PV or BCWS</option>
                        <option value="CPI">CPI</option>
                        <option value="SPI">SPI</option>
                        <option value="EAC">EAC</option>
                        <option value="VAC">VAC</option>
                        <option value="SV">SV</option>
                        <option value="CV">CV</option>
                        <option value="MFN">MFN</option>
                        <option value="FNSL">FNSL</option>
                        <option value="ROI">ROI</option>
                        <option value="RRR">RRR</option>
                        <option value="Activities">Activities</option>
                        <option value="Milestones">Milestones</option>
                        <option value="Reviews">Reviews</option>
                        <option value="Commitments">Commitments</option>
                        <option value="Overdue Tasks">Overdue Tasks</option>
                        <option value="Task Completed">Task Completed</option>
                        <option value="Planned Hours">Planned Hours</option>
                        <option value="Completed Projects">Completed Projects</option>
                        <option value="Cancelled Projects">Cancelled Projects</option>
                        <option value="ScopeChange Requested">ScopeChange Requested</option>
                        <option value="ScopeChanges">ScopeChanges</option>
                        <option value="Response Times">Response Times</option>
                        <option value="Capacity/Load">Capacity/Load</option>
                        <option value="Training Hours">Training Hours</option>
                        <option value="Forecast/Actual Usage">Forecast/Actual Usage</option>
                        <option value="Resource Utilization">Resource Utilization</option>
                        <option value="Schedule">Schedule</option>
                        <option value="Resource">Resource</option>
                        <option value="Cost">Cost</option>
                        <option value="Deliverables">Deliverables</option>
                        <option value="Issue">Issue</option>
                        <option value="Defect or Bugs">Defect or Bugs</option>
                        <option value="Rework">Rework</option>
                        <option value="User Satisfaction">User Satisfaction</option>
                        <option value="Risk Matrix">Risk Matrix</option>
                        <option value="Velocity Chart">Velocity Chart</option>
                        <option value="Scope Changes">Scope Changes</option>
                        <option value="Burndown Chart">Burndown Chart</option>
                        <option value="Defect or Bugs">Defect or Bugs</option>
                        <option value="Review Coverage">Review Coverage</option>
                        <option value="Version Report">Version Report</option>
                    </select><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required kpi-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('kpis.nombre') }}</label>
                    <input type="text" class="md-input" name="nombre" value="" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required nombre-error"></span></div>



                <div class="md-input-wrapper">
                    <label>{{ __('kpis.description') }}</label>
                    <input type="text" class="md-input" name="description" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>

                <label>{{ __('kpis.category') }}</label>
                <div class="md-input-wrapper">

                    <select class="md-input" name="category" required data-md-selectize>
                        <option value="">Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <span class="md-input-bar"></span>

                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required category-error"></span></div>

            <!-- <label>{{ __('kpis.type_of_result') }}</label>

                <div class="md-input-wrapper">

                    <select  class="md-input" name="type_of_result" required data-md-selectize>
                        <option  value="NUMERIC">Numeric</option>
                        <option  value="PERCENT">Percent</option>
                        <option  value="GRAPHIC">Graphic Chart</option>
                    </select>
                    <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required graphic_type-error"></span></div>


                <label>{{ __('kpis.graphic_type') }}</label>

                <div class="md-input-wrapper">


                    <select  class="md-input" name="graphic_type" required data-md-selectize>
                        <option  value="">{{ __('kpis.graphic_type') }}</option>
                        <option  value="VELOCIMETRO">Velocímetro</option>
                        <option  value="BAR">Bar</option>
                        <option  value="DONUT">Donut</option>
                        <option  value="LINES">Lines</option>
                    </select>
                    <span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required graphic_type-error"></span></div>



                <div class="md-input-wrapper">
                    <label>{{ __('kpis.query') }}</label>
                    <input type="text" class="md-input" name="query" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required query-error"></span></div>


                -->
                <label>{{ __('kpis.show') }}</label>
                <div class="md-input-wrapper">

                    <input type="checkbox" checked class="md-input" name="show" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required query-error"></span></div>

                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="add-btn">{{ __('kpis.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                       id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </div>

        </form>
    </div>
</div>

