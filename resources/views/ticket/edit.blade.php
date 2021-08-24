<style>


    #edit_div.switcher_active {
        width: 70%;
    }
   
</style>  
 <form role="form" method="POST" action="{{ url('tickets/update') }}" id="data-form-edit" data-redirect-on-success="{{isset($redirect)?$redirect: url('tasks/'.$ticket->task_id.'/tickets') }}">
    <li class="uk-width-medium-1-1 uk-row-first">
        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
    </li>
    <div class="uk-grid" data-uk-grid-margin>
    

       

     
            {{ csrf_field() }}
            <input type="hidden" name="task_id" value="{{ $ticket->task_id }}">
            <input type="hidden" name="id" value="{{ $ticket->id }}">
            <input type="hidden" name="last_updater_id" value="{{ Auth::id() }}">
            <li class="uk-width-medium-1-3 uk-row-first">

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.description') }}</label>
                    <input type="text" class="md-input" name="description" value="{{ $ticket->description }}"
                           required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>
                <label>{{ __('tickets.type') }}</label>
                <div class="md-input-wrapper md-input-filled">
                    <select name="type" id="type2" data-md-selectize>
                        <option value="1" {{ ($ticket->type == 1) ? 'selected' : '' }}>{{ __('tickets.type_1') }}</option>
                        <option value="2" {{ ($ticket->type == 2) ? 'selected' : '' }}>{{ __('tickets.type_2') }}</option>
                        <option value="3" {{ ($ticket->type == 3) ? 'selected' : '' }}>{{ __('tickets.type_3') }}</option>
                        <option value="4" {{ ($ticket->type == 4) ? 'selected' : '' }}>{{ __('tickets.type_4') }}</option>
                        <option value="5" {{ ($ticket->type == 5) ? 'selected' : '' }}>{{ __('tickets.type_5') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required type-error"></span></div>
                <label>{{ __('tickets.assignee') }}</label>
                <div class="md-input-wrapper md-input-filled">
                    <select name="assignee_id" data-md-selectize>
                        <option value="">{{ __('tickets.assignee') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ ($user->id == $ticket->assignee_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required assignee_id-error"></span></div>

                <label>{{ __('tickets.status') }}</label>
                <div class="md-input-wrapper md-input-filled">
                    <select name="status" data-md-selectize>
                        <option value="1" {{ ($ticket->status == 1) ? 'selected' : '' }}>{{ __('tickets.status_1') }}</option>
                        <option value="2" {{ ($ticket->status == 2) ? 'selected' : '' }}>{{ __('tickets.status_2') }}</option>
                        <option value="3" {{ ($ticket->status == 3) ? 'selected' : '' }}>{{ __('tickets.status_3') }}</option>
                        <option value="4" {{ ($ticket->status == 4) ? 'selected' : '' }}>{{ __('tickets.status_4') }}</option>
                        <option value="5" {{ ($ticket->status == 5) ? 'selected' : '' }}>{{ __('tickets.status_5') }}</option>
                        <option value="6" {{ ($ticket->status == 6) ? 'selected' : '' }}>{{ __('tickets.status_6') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>
                <label>{{ __('tickets.group') }}</label>
                <div class="md-input-wrapper md-input-filled">
                    <select name="group" id="group2" data-md-selectize>
                        <option value="1" {{ ($ticket->group == 1) ? 'selected' : '' }}>{{ __('tickets.group_1') }}</option>
                        <option value="2" {{ ($ticket->group == 2) ? 'selected' : '' }}>{{ __('tickets.group_2') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required group-error"></span></div>

                <label id="sprint_label2" style="display: none;">{{ __('tickets.sprint') }}</label>
                <div id="sprint2" style="display:none;" class="md-input-wrapper">
                    <label>{{ __('tickets.sprint') }}</label>
                    <select name="sprint_id" id="sprint_id2" data-md-selectize>
                        @foreach ($sprints as $sprint)
                            <option value="{{ ($sprint->id) }}" {{ ($sprint->id == $ticket->sprint_id)?'selected':'' }} >{{ $sprint->short_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sprint_id-error"></span></div>

                {{-- <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.sprint') }}</label>
                    <input type="text" class="md-input" name="sprint" value="{{ $ticket->sprint }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sprint-error"></span></div> --}}

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tasks.due_date') }}</label>
                    <input class="md-input" type="text" id="due_date" name="due_date"
                           value="{{ $ticket->due_date==='0000-00-00'?'':$ticket->due_date }}"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>
                <label>{{ __('tickets.requester') }}</label>
                <div class="md-input-wrapper md-input-filled md-input">

                    <select name="requester_name" data-md-selectize>
                        <option value="">{{ __('tickets.requester') }}</option>

                        @foreach ($users2 as $user)
                            <option value="{{ $user->name }}" {{ ($user->name == $ticket->requester_name) ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required requester_name-error"></span>
                </div>

                <input type="hidden" name="requester_email" value="">
                <input type="hidden" name="requester_type" value="team">
                <label>{{ __('tickets.priority') }}</label>
                <div class="md-input-wrapper md-input-filled">

                    <select name="priority" id="priority2" data-md-selectize>
                        <option value="1" {{ ($ticket->priority == 1) ? 'selected' : '' }}>{{ __('tickets.priority_1') }}</option>
                        <option value="2" {{ ($ticket->priority == 2) ? 'selected' : '' }}>{{ __('tickets.priority_2') }}</option>
                        <option value="3" {{ ($ticket->priority == 3) ? 'selected' : '' }}>{{ __('tickets.priority_3') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required priority-error"></span></div>
				
			</li>
            <li class="uk-width-medium-1-3 uk-row-first">
			
                <label>{{ __('tickets.severity') }}</label>
                <div class="md-input-wrapper md-input-filled">

                    <select name="severity" id="severity2">
                        <option value="0" {{ ($ticket->severity == 0) ? 'selected' : '' }}>{{ __('tickets.severity_0') }}</option>
                        <option value="1" {{ ($ticket->severity == 1) ? 'selected' : '' }}>{{ __('tickets.severity_1') }}</option>
                        <option value="2" {{ ($ticket->severity == 2) ? 'selected' : '' }}>{{ __('tickets.severity_2') }}</option>
                        <option value="3" {{ ($ticket->severity == 3) ? 'selected' : '' }}>{{ __('tickets.severity_3') }}</option>
                        <option value="4" {{ ($ticket->severity == 4) ? 'selected' : '' }}>{{ __('tickets.severity_4') }}</option>
                        <option value="5" {{ ($ticket->severity == 5) ? 'selected' : '' }}>{{ __('tickets.severity_5') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required seveiryt-error"></span></div>


                <label>{{ __('tickets.probability') }}</label>
                <div class="md-input-wrapper md-input-filled">

                    <select name="probability" id="probability2" >
                        <option value="0" {{ ($ticket->probability == 0) ? 'selected' : '' }}>{{ __('tickets.probability_0') }}</option>
                        <option value="1" {{ ($ticket->probability == 1) ? 'selected' : '' }}>{{ __('tickets.probability_1') }}</option>
                        <option value="2" {{ ($ticket->probability == 2) ? 'selected' : '' }}>{{ __('tickets.probability_2') }}</option>
                        <option value="3" {{ ($ticket->probability == 3) ? 'selected' : '' }}>{{ __('tickets.probability_3') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required probability-error"></span></div>

   

                <label>{{ __('tickets.impact') }}</label>
                <div class="md-input-wrapper md-input-filled">

                    <select name="impact" id="impact2">
                        <option value="0" {{ ($ticket->impact == 0) ? 'selected' : '' }}>{{ __('tickets.impact_0') }}</option>
                        <option value="1" {{ ($ticket->impact == 1) ? 'selected' : '' }}>{{ __('tickets.impact_1') }}</option>
                        <option value="2" {{ ($ticket->impact == 2) ? 'selected' : '' }}>{{ __('tickets.impact_2') }}</option>
                        <option value="3" {{ ($ticket->impact == 3) ? 'selected' : '' }}>{{ __('tickets.impact_3') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required impact-error"></span></div>

                {{-- <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.version') }}</label>
                    <input type="text" class="md-input" name="version" value="{{ $ticket->version }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required version-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.release') }}</label>
                    <input type="text" class="md-input" name="release" value="{{ $ticket->release }}" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required release-error"></span></div> --}}

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.estimated_hours') }}</label>
                    <input type="number" class="md-input" name="estimated_hours" value="{{ $ticket->estimated_hours }}"
                           required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_hours-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.burned_hours') }}</label>
                    <input type="number" class="md-input" name="burned_hours" value="{{ $ticket->burned_hours }}"
                           required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required burned_hours-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.story_points') }}</label>
                    <input type="number" class="md-input" name="story_points" value="{{ $ticket->story_points }}"
                           required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required story_points-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tasks.approval_date') }}</label>
                    <input class="md-input" type="text" id="approval_date" name="approval_date"
                           value="{{ $ticket->approval_date==='0000-00-00'?'':$ticket->approval_date }}"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required approval_date-error"></span></div>
		</li>
            <li class="uk-width-medium-1-3 uk-row-first">
                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.approver_name') }}</label>

                    <select name="" id="approver_name_selet2" data-md-selectize>
                        <option value="">{{ __('tickets.approver_name') }}</option>
                        @foreach ($contacts as $contact)
                            <option value="{{ $contact->name }}" {{ ($contact->name == $ticket->approver_name) ? 'selected' : '' }}>{{ $contact->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="md-input" name="approver_name" id="approver_name2"
                           value="{{ $ticket->approver_name }}" required><span class="md-input-bar"></span>

                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required approver_name-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.acceptance_criteria') }}</label>
                    <textarea class="md-input" name="acceptance_criteria"
						    required>{{ $ticket->acceptance_criteria }}</textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required acceptance_criteria-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.testing_criteria') }}</label>
                    <textarea class="md-input" name="testing_criteria"
                           required>{{ $ticket->testing_criteria }}</textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required testing_criteria-error"></span>
                </div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.done_criteria') }}</label>
                    <textarea class="md-input" name="done_criteria"
                           required>{{ $ticket->done_criteria }}</textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required done_criteria-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.label') }}</label>
                    <textarea class="md-input" name="label"  required>{{ $ticket->label }}</textarea><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required label-error"></span></div>

                <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.comment') }}</label>
                    <textarea class="md-input" name="comment"  required>{{ $ticket->comment }}</textarea><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>

                <label>{{ __('tickets.owner') }}</label>
                <div class="md-input-wrapper md-input-filled">
                    <select name="owner_id" data-md-selectize>
                        <option value="">{{ __('tickets.owner') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ ($user->id == $ticket->owner_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required owner_id-error"></span></div>
<br>
 			 <div class="md-input-wrapper md-input-filled">
                    <label>{{ __('tickets.contingency_plan') }}</label>
<textarea placeholder="just fill in Risk Type Tickets" class="md-input" name="contingency_plan">{{ $ticket->contingency_plan }}</textarea><span class="md-input-bar"></span>                    
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required contingency_plan-error"></span></div>

            </li>
          

		  <li class="uk-width-medium-1-1 uk-pading-left">
                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="update-btn">{{ __('requirements.update') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button cancel-edit-btn"
                       href="#">{{ __('general.cancel') }}</a>
                </div>

            </li>


       
   
</div>
 </form>
    <script src="{{ asset('js/ticket.js') }}"></script>
    <script type="text/javascript">
        $('.cancel-edit-btn').on('click', function (e) {
            e.preventDefault();
            $('#edit_div_toggle').hide();
            $('#edit_div').removeClass('switcher_active');
        });

        $(document).ready(function () {
            console.log($('#sprint_id2').val());
            if($('#group2').val() === "2"){
                
                $('#sprint2').show();
                $('#sprint_label2').show();
                
            }

            Ticket.init();


            $('#group2').selectize();
            $('#group2').on('change', function(){
                
                if($(this).val() == "2"){
                    $('#sprint2').show();
                    $('#sprint_label2').show();

                    $.ajax({
                        url: API_PATH + '/sprints',
                        type: 'GET',
                        data: {project_id: {{ session('project_id') }} },
                        dataType: 'json',
                    }).done(
                        function (data) {
                            var html = '<option value="">{{ __('tickets.select_sprint') }}</option>';

                            $('#sprint_id2').selectize()[0].selectize.destroy();

                            $.each(data.data, function (i, value) {
                                html += '<option value="' + value.id + '">' + value.long_name + '</option>';
                            });

                            $('#sprint_id2').html(html);
                            $('#sprint_id2').selectize();
                        }
                    );

                }else{
                    $('#sprint2').hide();
                    $('#sprint_label2').hide();
                }

            });

        });

        tableActions.initEditForm();
    </script>
