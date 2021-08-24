
<style>
          font-family: Helvetica;
        font-size: 11px;
    }

    @page {
        margin: 30px 30px 30px 30px;
    }

    header {
        font-size: 12px;
        left: 0px;
        top: -0px;
        right: 0px;

    }

    .page:after {
        content: counter(page);
    }

    .main {
        position: relative;
        margin-bottom: 50px;
    }

    .upper {
        text-transform: uppercase;
    }

    .detail_table thead tr:first-child th {
        border-bottom: 1px solid black;
        border-top: 1px solid black;
    }

    .detail_table tfoot {
        border: 0px solid black;
    }

    .detail_table tbody {
        border-bottom: 1px solid black;
        border-top: 1px solid black;
    }

    .right {
        float: right;
        text-align: right
    }
    .right {
        float: left;
        text-align: left
    }
    .red {
        color: red;
    }

    span.page-break {
        page-break-inside: auto;
    }

    .bordered, .bordered th {
        border-bottom: 1px solid #000000;
    }

    h3, h4 {
        padding: 0px;
        line-height: 1px;
    }

    /* class works for table */
    /* table.page-break{
         page-break-before:always
     }*/
    /*tr.page-break  { display: block; page-break-before: auto; }*/
        .progress{
        background-color: transparent;
        box-shadow: none;
    }
    .progress-bar{
        height: 1.3em;
    }
    .nope{
        display: none; 
    }
    button.parent {
        color: black;
        font-size: 16px;
    }
    header {clear: both;}
</style>
<div class="md-card">
    <div class="md-card-content">

        <header>
            <table width="100%">
                <tr>
                    <td width="60%">
                       @if(!empty($company->logo_path) || $company->logo_path!='' ) 
                        <img height="150" src="{{  base_path() .'/assets/img/companies/'. $company->id .'/'. $company->logo_path }}">
                        @endif
                        <h3 class="upper">{{$company->name}}</h3>
                        <h4>{{$company->address}}</h4><br>
                     
                    </td>
                    <td>
                        <h1>TASK REPORT</h1> <br>
                        @if(!empty($customer->logo_path) || $customer->logo_path!='' ) 
                        <img height="100" src="{{  base_path() .'/assets/img/customers/'. $customer->id .'/'. $customer->logo_path }}">
                        @endif
                        <br>

                        <b> {{$customer->address}}</b><br>
                     
                       <h3 class="upper"> {{$project->name}}</h3><br>
                    </td>
                </tr>
            </table>
        </header>
        <div class="main">
            <table width="100%" class="detail_table">

				@if(session()->has('project_id'))

        	    <thead>
        	        <tr>
        	        	<th style="width: 5%;"></th>
        	        	<th>{{ __('tasks.project') }}</th>
                        <th>{{ __('tasks.phase') }}</th>
        	        	<th style="width: 25%;">{{ __('tasks.description') }}</th>
        	        	<th style="width: 10%;">{{ __('tasks.start_date') }}</th>
        	        	<th style="width: 10%;">{{ __('tasks.due_date') }}</th>
        	        	<th>{{ __('tasks.duration') }}</th>
                        <th>{{ __('tasks.burned_hours') }}</th>
                        <th>{{ __('tasks.estimated_hours') }}</th>
                        <th data-class-name="progress">{{ __('tasks.progress') }}</th>
        	        	<th data-class-name="progress">{{ __('tasks.estimated_progress') }}</th>
        	        	<th>{{ __('tasks.actions') }}</th>
        	        </tr>
        	    </thead>
                <tbody>
                    @foreach($response->tasks as $index => $task)
                    @php( ($task->end_is_milestone == 1) ? $last = $index : '')
                        <tr>
                            <td ></td>
                            <td >{{$response->project->name}}</td>
                            <td  >{{$task->phase}}</td>
                            <td style="padding-left: {{$task->level}}5px">{{$task->description}}</td>
                            <td>{{$task->start_date}}</td>
                            <td>{{$task->due_date}}</td>
                            <td>{{$task->duration}} {{__('tasks.days')}}</td>
                            <td>{{$task->burned_hours}}</td>
                            <td>{{$task->estimated_hours}}</td>
                            <td class="progress">
                                <div>{{ $task->progress }}</div><div class="progress-bar" style="width:{{$task->progress}}%; background-color:{{$task->color}};" role="progressbar" aria-valuenow="{{$task->progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </td>
                            <td class="progress">
                                <div> {{round($task->estimated_progress, 2)}} </div><div class=" progress-bar" style="width:{{round($task->estimated_progress, 2)}}%; background-color: {{$task->color}} ;" role="progressbar" aria-valuenow="{{round($task->estimated_progress, 2)}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </td>
                            <td>
                                @if($task->end_is_milestone != 1) <a href="/reports/{{$task->id}}/tickets" class="table-actions"><i class="fa fa-list-ul" aria-hidden="true"></i></a> @endif
                            </td>
                        </tr>

                    @endforeach
                </tbody>
                <span class="page-break"></span>
        	</table>
        	@endif
        </div>
    </div>
</div>
