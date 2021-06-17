<style>

    .uk-datepicker {
        min-width: initial !important;
        width: 215px !important;
    }

    #create_div.switcher_active {
        width: 50%;
    }

</style>



    	<form role="form" method="POST" action="{{ url('sprints') }}" id="data-form" data-redirect-on-success="{{ url('sprints') }}">
    	

<div class="uk-grid" data-uk-grid-margin>
   
   <li class="uk-width-medium-1-1 uk-row-first">
        <div class="uk-alert uk-alert-danger hide_when_empty status_code-error" data-uk-alert=""></div>
            </li>
		{{ csrf_field() }}

    	    <input type="hidden" name="project_id" value="{{ $project->id }}">
    		<li class="uk-width-medium-1-2 uk-row-first">



 		

 		<div class="md-input-wrapper md-input-select">
               		<label>{{ __('sprints.customer_name') }}</label>
<br/>
                	<select name="customer_id" data-md-selectize>
                	    <option value="">{{ __('sprints.customer_name') }}...</option>
                	    @foreach ($customers as $customer)
                	        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required customer_id-error"></span></div>


                <div class="md-input-wrapper">
                	<label>{{ __('sprints.short_name') }}</label>
<br/>
                	<input type="text" class="md-input" name="short_name" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required short_name-error"></span></div>

                <div class="md-input-wrapper">
                	<label>{{ __('sprints.long_name') }}</label>
<br/>
                	<input type="text" class="md-input" name="long_name"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required long_name-error"></span></div>

               	
                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('sprints.start_date') }}</label>
<br/>
                    <input class="md-input" type="text" id="uk_dp_1" name="start_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required start_date-error"></span></div>

                <div class="md-input-wrapper">
                    <label for="uk_dp_1">{{ __('sprints.finish_date') }}</label>
<br/>
                    <input class="md-input" type="text" id="uk_dp_1" name="finish_date" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required finish_date-error"></span></div>
		

			 <div class="md-input-wrapper">
                	<label>{{ __('sprints.Duration') }}</label>
<br/>
                	<input type="text" class="md-input" name="Duration"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required Duration-error"></span></div>

			 <div class="md-input-wrapper">
                	<label>{{ __('sprints.version') }}</label>
<br/>
                	<input type="text" class="md-input" name="version"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required version-error"></span></div>
	</li>
	            <li class="uk-width-medium-1-2 uk-row-first">

			 <div class="md-input-wrapper">
                	<label>{{ __('sprints.release') }}</label>
<br/>
                	<input type="text" class="md-input" name="release"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required release-error"></span></div>


			 <div class="md-input-wrapper">
                	<label>{{ __('sprints.milestone') }}</label>
<br/>
                	<input type="text" class="md-input" name="milestone"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required milestone-error"></span></div>

 		<div class="md-input-wrapper">
                	<label>{{ __('sprints.NumberOfChangesRequired') }}</label>
<br/>
                	<input type="text" class="md-input" name="NumberOfChangesRequired"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required NumberOfChangesRequired-error"></span></div>


			 <div class="md-input-wrapper">
                	<label>{{ __('sprints.NumberOfChangesResolved') }}</label>
<br/>
                	<input type="text" class="md-input" name="NumberOfChangesResolved"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required NumberOfChangesResolved-error"></span></div>

			
<div class="md-input-wrapper md-input-select">
               		<label>{{ __('sprints.time_status') }}</label>
<br/>
                	<select name="time_status" data-md-selectize>
                	    <option value="">{{ __('sprints.time_status') }}...</option>
                	    @foreach ($time_statuss as $time_status)
                	        <option value="{{ $time_status }}">{{ $time_status}}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required time_status-error"></span></div>


<div class="md-input-wrapper md-input-select">
               		<label>{{ __('sprints.task_status') }}</label>
<br/>
                	<select name="task_status" data-md-selectize>
                	    <option value="">{{ __('sprints.task_status') }}...</option>
                	    @foreach ($task_statuss as $task_status)
                	        <option value="{{ $task_status }}">{{ $task_status }}</option>
                	    @endforeach
                	</select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required task_status-error"></span></div>


		<div class="md-input-wrapper md-input-filled">
                	<label>{{ __('sprints.active') }}</label>
			<br/>
                    <input type="checkbox" checked class="md-input" name="active" ><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required active-error"></span></div>


	</li>
	            <li class="uk-width-medium-1-1 uk-row-first">

				<div class="uk-margin-medium-top">
                    <a class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light" href="#" id="add-btn">{{ __('sprints.add_new') }}</a>
                    <a class="md-btn md-btn-flat md-btn-wave md-btn-block waves-effect waves-button" href="#" id="cancel-btn">{{ __('general.cancel') }}</a>
                </div>

            </li>
</div>
    	</form>
  

