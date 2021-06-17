<style>

    #create_div.switcher_active {
        width: 70%;
    }

   
</style>
 <form role="form" method="POST" action="{{ url('tickets') }}" id="data-form"
              data-redirect-on-success="{{ url('tasks/'.$task->id.'/tickets') }}">
<div class="uk-grid" data-uk-grid-margin>
  

        <div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>

    
            {{ csrf_field() }}
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <li class="uk-width-medium-1-3 uk-row-first">

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.description') }}</label>
                    <input type="text" class="md-input" name="description" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required description-error"></span></div>
                <label>{{ __('tickets.type') }}</label>
                <div class="md-input-wrapper">
                    <select name="type" id="type" data-md-selectize>
                        <option value="1">{{ __('tickets.type_1') }}</option>
                        <option value="2">{{ __('tickets.type_2') }}</option>
                        <option value="3">{{ __('tickets.type_3') }}</option>
                        <option value="4">{{ __('tickets.type_4') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required type-error"></span></div>
                <label>{{ __('tickets.assignee') }}</label>
                <div class="md-input-wrapper">
                    <select name="assignee_id" data-md-selectize>
                        <option value="">{{ __('tickets.assignee') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required assignee_id-error"></span></div>
                <label>{{ __('tickets.status') }}</label>
                <div class="md-input-wrapper">
                    <select name="status" data-md-selectize>
                        <option value="1">{{ __('tickets.status_1') }}</option>
                        <option value="2">{{ __('tickets.status_2') }}</option>
                        <option value="3">{{ __('tickets.status_3') }}</option>
                        <option value="4">{{ __('tickets.status_4') }}</option>
                        <option value="5">{{ __('tickets.status_5') }}</option>
                        <option value="6">{{ __('tickets.status_6') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required status-error"></span></div>

                <label>{{ __('tickets.group') }}</label>
                <div class="md-input-wrapper">
                    <select name="group" data-md-selectize>
                        <option value="1">{{ __('tickets.group_1') }}</option>
                        <option value="2">{{ __('tickets.group_2') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required group-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.sprint') }}</label>
                    <input type="text" class="md-input" name="sprint" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required sprint-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tasks.due_date') }}</label>
                    <input class="md-input" type="text" id="due_date" name="due_date" value="{{isset($task->due_date)?$task->due_date:''}}"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required due_date-error"></span></div>
                <label>{{ __('tickets.requester') }}</label>
				          
						  <div class="md-input-wrapper">

                    <select name="requester_name" data-md-selectize>
                        <option value="">{{ __('tickets.requester') }}</option>
                        @foreach ($users2 as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required requester_name-error"></span>
                </div>


                <input type="hidden" name="requester_email" value="">
                <input type="hidden" name="requester_type" value="team">
                <label>{{ __('tickets.priority') }}</label>
                <div class="md-input-wrapper">

                    <select name="priority" id="priority" data-md-selectize>
                        <option value="1">{{ __('tickets.priority_1') }}</option>
                        <option value="2">{{ __('tickets.priority_2') }}</option>
                        <option value="3">{{ __('tickets.priority_3') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required priority-error"></span></div>
                
				   </li>

            <li class="uk-width-medium-1-3 uk-row-first">


   
				<label>{{ __('tickets.severity') }}</label>
                <div class="md-input-wrapper">

                    <select name="severity" id="severity">

                        <option value="1">{{ __('tickets.severity_1') }}</option>
                        <option value="2">{{ __('tickets.severity_2') }}</option>
                        <option value="3">{{ __('tickets.severity_3') }}</option>
                        <option value="4">{{ __('tickets.severity_4') }}</option>
                        <option value="5">{{ __('tickets.severity_5') }}</option>
                        <option value="0">{{ __('tickets.severity_0') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required severity-error"></span></div>

                <label>{{ __('tickets.probability') }}</label>
                <div class="md-input-wrapper">

                    <select name="probability" id="probability">

                        <option value="1">{{ __('tickets.probability_1') }}</option>
                        <option value="2">{{ __('tickets.probability_2') }}</option>
                        <option value="3">{{ __('tickets.probability_3') }}</option>
                        <option value="0">{{ __('tickets.probability_0') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required probability-error"></span></div>
        

                <label>{{ __('tickets.impact') }}</label>
                <div class="md-input-wrapper">

                    <select name="impact" id="impact">

                        <option value="1">{{ __('tickets.impact_1') }}</option>
                        <option value="2">{{ __('tickets.impact_2') }}</option>
                        <option value="3">{{ __('tickets.impact_3') }}</option>
                        <option value="0">{{ __('tickets.impact_0') }}</option>
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required impact-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.version') }}</label>
                    <input type="text" class="md-input" name="version" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required version-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.release') }}</label>
                    <input type="text" class="md-input" name="release" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required release-error"></span></div>
				<div class="md-input-wrapper">
                    <label>{{ __('tickets.estimated_hours') }}</label>
                    <input type="number" class="md-input" name="estimated_hours"  value="{{isset($task->estimated_hours)?$task->estimated_hours:''}}"  required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required estimated_hours-error"></span>
                </div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.burned_hours') }}</label>
                    <input type="number" class="md-input" name="burned_hours" value="{{isset($task->burned_hours)?$task->burned_hours:''}}"  required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required burned_hours-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.story_points') }}</label>
                    <input type="number" class="md-input" name="story_points" required><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required story_points-error"></span></div>

			</li>

            <li class="uk-width-medium-1-3 uk-row-first">


              
                <div class="md-input-wrapper">
                    <label>{{ __('tasks.approval_date') }}</label>
                    <input class="md-input" type="text" id="approval_date" name="approval_date"
                           data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required approval_date-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.approver_name') }}</label>

                    <select name="" id="approver_name_selet" data-md-selectize>
                        <option value="">{{ __('tickets.approver_name') }}</option>
                        @foreach ($contacts as $contact)
                            <option value="{{ $contact->name }}">{{ $contact->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="md-input" name="approver_name" id="approver_name" value="" required><span class="md-input-bar"></span>

                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required approver_name-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.acceptance_criteria') }}</label>
                    <textarea class="md-input" name="acceptance_criteria" required></textarea><span
                            class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required acceptance_criteria-error"></span>
                </div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.testing_name') }}</label>
                    <textarea class="md-input" name="testing_name" required></textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required testing_name-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.done_name') }}</label>
                    <textarea class="md-input" name="done_name" required></textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required done_name-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.label') }}</label>
                    <textarea class="md-input" name="label" required></textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required label-error"></span></div>

                <div class="md-input-wrapper">
                    <label>{{ __('tickets.comment') }}</label>
					<textarea  class="md-input" name="comment" required></textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required comment-error"></span></div>
              
				
				  <label>{{ __('tickets.owner') }}</label>
                <div class="md-input-wrapper">
                    <select name="owner_id" data-md-selectize>
                        <option value="">{{ __('tickets.owner') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required owner_id-error"></span></div>

   		<div class="md-input-wrapper">
                    <label>{{ __('tickets.contingency_plan') }}</label>
                    <textarea laceholder="just fill in Risk Type Tickets" class="md-input" name="contingency_plan" ></textarea><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required contingency_plan-error"></span></div>
              
            </li>
			
			
			
            <li class="uk-width-medium-1-1 uk-pading-left">
                <div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                       href="#" id="add-btn">{{ __('cities.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#"
                       id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>
            </li>


       
  
</div>
 </form>
    <script src="{{ asset('js/ticket.js') }}"></script>
    <script>
        $(document).ready(function () {
            Ticket.init();

        })
    </script>
