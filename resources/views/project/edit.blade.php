<style>

    .uk-datepicker {
        min-width: initial !important;
        width: 215px !important;
    }

    #edit_div.switcher_active {
        width: 50%;
    }
</style>

      <form role="form" method="POST" action="{{ url('projects/update') }}" id="data-form-edit"
              data-redirect-on-success="{{ url('projects') }}">
 
<div class="uk-grid" data-uk-grid-margin>
            <li class="uk-width-medium-1-1 uk-row-first">
        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
            </li>

             {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $project->id }}">
            <li class="uk-width-medium-1-3 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.name') }}</label>
                    <input type="text" class="md-input" name="name" value="{{ $project->name }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.customer') }}</label>
                    <select name="customer_id" data-md-selectize>
                        <option value="">{{ __('projects.customer') }}...</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ ($customer->id == $project->customer_id) ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.customer_name') }}</label>
                    <input type="text" class="md-input" name="customer_name" value="{{ $project->customer_name }}"
                           required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('projects.start') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="start" value="{{ $project->start }}"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label for="uk_dp_1">{{ __('projects.finish') }}</label>
                    <input class="md-input" type="text" id="uk_dp_1" name="finish" value="{{ $project->finish }}"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required finish-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.project_manager') }}</label>
                    <select name="project_manager_id" data-md-selectize>
                        <option value="">{{ __('projects.project_manager') }}...</option>
                        @foreach ($project_managers as $pm)
                            <option value="{{ $pm->id }}" {{ ($pm->id == $project->project_manager_id) ? 'selected' : '' }}>{{ $pm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required project_manager_id-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.technical_director') }}</label>
                    <select name="technical_director_id" data-md-selectize>
                        <option value="">{{ __('projects.technical_director') }}...</option>
                        @foreach ($technical_directors as $pm)
                            <option value="{{ $pm->id }}" {{ ($pm->id == $project->technical_director_id) ? 'selected' : '' }}>{{ $pm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required technical_director_id-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.delivery_manager') }}</label>
                    <select name="delivery_manager_id" data-md-selectize>
                        <option value="">{{ __('projects.delivery_manager') }}...</option>
                        @foreach ($delivery_managers as $pm)
                            <option value="{{ $pm->id }}" {{ ($pm->id == $project->delivery_manager_id) ? 'selected' : '' }}>{{ $pm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required delivery_manager_id-error"></span>
                </div>
</li>
	            <li class="uk-width-medium-1-3 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.sow_number') }}</label>
                    <input type="text" class="md-input" name="sow_number" value="{{ $project->sow_number }}"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sow_number-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.identificator') }}</label>
                    <input type="text" class="md-input" name="identificator" value="{{ $project->identificator }}"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required identificator-error"></span></div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.status') }}</label>
                    <select name="status" data-md-selectize>
                        <option value="">{{ __('projects.status') }}...</option>
                        <option value="{{ __('projects.initiating') }}" {{ ($project->status == __('projects.initiating')) ? 'selected' : '' }}>{{ ucfirst(__('projects.initiating')) }}
                            
                        </option>
                        <option value="{{ __('projects.planning') }}" {{ ($project->status == __('projects.planning')) ? 'selected' : '' }}>{{ ucfirst(__('projects.planning')) }}
                            
                        </option>
                        <option value="{{ __('projects.executing') }}" {{ ($project->status == __('projects.executing')) ? 'selected' : '' }}>{{ ucfirst(__('projects.executing')) }}
                            
                        </option>
                        <option value="{{ __('projects.closing') }}" {{ ($project->status == __('projects.closing')) ? 'selected' : '' }}>{{ ucfirst(__('projects.closing')) }}
                            
                        </option>
                        <option value="{{ __('projects.waiting') }}" {{ ($project->status == __('projects.waiting')) ? 'selected' : '' }}>{{ ucfirst(__('projects.waiting')) }}
                            
                        </option>
                        <option value="{{ __('projects.completed') }}" {{ ($project->status == __('projects.completed')) ? 'selected' : '' }}>{{ ucfirst(__('projects.completed')) }}
                            
                        </option>

                        <option value="{{ __('projects.cancelled') }}" {{ ($project->status == __('projects.cancelled')) ? 'selected' : '' }}>{{ ucfirst(__('projects.cancelled')) }}
                            
                        </option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.presales_responsable') }}</label>
                    <input type="text" class="md-input" name="presales_responsable"
                           value="{{ $project->presales_responsable }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required presales_responsable-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.technical_estimator') }}</label>
                    <input type="text" class="md-input" name="technical_estimator"
                           value="{{ $project->technical_estimator }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required technical_estimator-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.engagement') }}</label>
                    <select name="engagement" data-md-selectize>
                        <option value="">{{ __('projects.engagement') }}...</option>
                        @foreach ($engagements as $engagement)
                            <option value="{{ $engagement->name }}" {{ ($engagement->name == $project->engagement) ? 'selected' : '' }}>{{ $engagement->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required engagement-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.estimated_revenue') }}</label>
                    <input type="text" class="md-input" name="estimated_revenue"
                           value="{{ $project->estimated_revenue }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_revenue-error"></span>
                </div>





 		<label>{{ __('projects.name_convention') }}</label>
                <div class="md-input-wrapper md-input-filled ">
                @if(!empty($project->name_convention))

              <select name="name_convention[]" multiple data-md-selectize>
                 <option value="CustomerName" {{in_array('CustomerName', $project->name_convention)?'selected':''}}>CustomerName</option>
                 <option value="ProjectName" {{in_array('ProjectName', $project->name_convention)?'selected':''}}>ProjectName</option>
                 <option value="ArtifactName" {{in_array('ArtifactName', $project->name_convention)?'selected':''}}>ArtifactName</option>
                 <option value="YYYYMMDDHHMMSS" {{in_array('YYYYMMDDHHMMSS', $project->name_convention)?'selected':''}}>YYYYMMDDHHMMSS</option>
                  <option value="VersionNumber" {{in_array('VersionNumber', $project->name_convention)?'selected':''}}>VersionNumber</option>
              </select>

                       @else
                         <select name="name_convention[]" multiple data-md-selectize>
                        <option value="CustomerName">CustomerName</option>
                        <option value="ProjectName">ProjectName</option>
                        <option value="ArtifactName">ArtifactName</option>
                        <option value="YYYYMMDDHHMMSS">YYYYMMDDHHMMSS</option>
                        <option value="VersionNumber">VersionNumber</option>
                      
                    </select>

                        @endif



                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name_convention-error"></span></div>





</li>
	            <li class="uk-width-medium-1-3 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.estimated_cost') }}</label>
                    <input type="text" class="md-input" name="estimated_cost"
                           value="{{ $project->estimated_cost }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_cost-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.estimated_margin') }}</label>
                    <input type="text" class="md-input" name="estimated_margin"
                           value="{{ $project->estimated_margin }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_margin-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.estimated_department_margin') }}</label>
                    <input type="text" class="md-input" name="estimated_department_margin"
                           value="{{ $project->estimated_department_margin }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required estimated_department_margin-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.target_margin') }}</label>
                    <input type="text" class="md-input" name="target_margin" value="{{ $project->target_margin }}"><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required target_margin-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.financial_deviation_threshold') }}</label>
                    <input type="text" class="md-input" name="financial_deviation_threshold"
                           value="{{ $project->financial_deviation_threshold }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required financial_deviation_threshold-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.time_deviation_threshold') }}</label>
                    <input type="text" class="md-input" name="time_deviation_threshold"
                           value="{{ $project->time_deviation_threshold }}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required time_deviation_threshold-error"></span></div>


                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('projects.hours_by_day') }}</label>
                    <input type="text" required class="md-input hours_by_day" name="hours_by_day"
                           value="{{ $project->hours_by_day }}"><span class="md-input-bar"></span>
                </div>


                <div class="parsley-errors-list filled"><span class="parsley-required hours_by_day-error"></span></div>


                <label>{{ __('projects.week_holy_days') }}</label>
                <div class="md-input-wrapper md-input-filled ">
                    @if(!empty($project->holy_days))
                    <select name="holy_days[]" multiple data-md-selectize>
                        <option value="0" {{in_array(0, $project->holy_days)?'selected':''}}>Sunday</option>
                        <option value="1" {{in_array(1, $project->holy_days)?'selected':''}}>Monday</option>
                        <option value="2" {{in_array(2, $project->holy_days)?'selected':''}}>Tuesday</option>
                        <option value="3" {{in_array(3, $project->holy_days)?'selected':''}}>Wednesday</option>
                        <option value="4" {{in_array(4, $project->holy_days)?'selected':''}}>Thursday</option>
                        <option value="5" {{in_array(5, $project->holy_days)?'selected':''}}>Friday</option>
                        <option value="6" {{in_array(6, $project->holy_days)?'selected':''}}>Saturday</option>

                    </select>
                    @else
                     <select name="holy_days[]" multiple data-md-selectize>
                        <option value="0">Sunday</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>

                    </select>
                    @endif

                </div>
                <div class="parsley-errors-list filled"><span
                            class="parsley-required holy_days-error"></span></div>


                <div class="md-input-wrapper md-input-filled md-input-select">
                    <label>{{ __('projects.department') }}</label>
                    <select name="department_id" data-md-selectize>
                        <option value="">{{ __('projects.department') }}...</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ ($department->id == $project->department_id) ? 'selected' : '' }}>{{ $department->title }}
                                ({{ $department->office->data->title }})
                            </option>
                        @endforeach
                    </select>
                </div>
 



                <div class="parsley-errors-list filled"><span class="parsley-required department_id-error"></span></div>


		</li>
	            <li class="uk-width-medium-1-1 uk-row-first">

                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="update-btn">{{ __('projects.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>

            </div>

       
</div>
 </form>
<script type="text/javascript">
    $('.cancel-edit-btn').on('click', function (e) {
        e.preventDefault();
        $('#edit_div_toggle').hide();
        $('#edit_div').removeClass('switcher_active');
    });

    tableActions.initEditForm();
</script>
