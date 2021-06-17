@extends('layouts.app', ['favoriteTitle' => __('tasks.report_tasks'), 'favoriteUrl' => url(Request::path())])
{{-- {{dd($response)}}  --}}

@section('section_title', __('tasks.report_tasks'))

@section('scripts')

@section('content')
    <style>
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
    </style>
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                	@if(session()->has('message'))
                		<div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                	@endif

                	@if(!session()->has('project_id'))
                		<div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                	@endif

					@if(session()->has('project_id'))

                    <div class="dt-buttons btn-group">
                        <!--<a class="md-btn buttons-copy buttons-html5" tabindex="0" aria-controls="tickets-table" href="#"><span>Copy</span></a>-->
                        <a class="md-btn buttons-excel buttons-html5" tabindex="0" aria-controls="tickets-table" id="excel" href="#"><span>Excel</span></a>
                        <a class="md-btn buttons-csv buttons-html5" tabindex="0" aria-controls="tickets-table" id="csv" href="#"><span>CSV</span></a>
                        <a class="md-btn buttons-pdf buttons-html5" tabindex="0" aria-controls="tickets-table" id="pdf" href="#"><span>PDF</span></a>
                    </div>

                	<table id="tasks-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th style="width: 5%;"></th>
                	        	<th title="{{__('tasks_tooltip.project')}}">{{ __('tasks.project') }}</th>
                                <th title="{{__('tasks_tooltip.phase')}}">{{ __('tasks.phase') }}</th>
                	        	<th title="{{__('tasks_tooltip.description')}}" style="width: 25%;">{{ __('tasks.description') }}</th>
                	        	<th title="{{__('tasks_tooltip.start_date')}}">{{ __('tasks.start_date') }}</th>
                	        	<th title="{{__('tasks_tooltip.due_date')}}">{{ __('tasks.due_date') }}</th>
                	        	<th title="{{__('tasks_tooltip.duration')}}">{{ __('tasks.duration') }}</th>
                                <th title="{{__('tasks_tooltip.burned_hours')}}">{{ __('tasks.burned_hours') }}</th>
                                <th title="{{__('tasks_tooltip.estimated_hours')}}">{{ __('tasks.estimated_hours') }}</th>
                                <th title="{{__('tasks_tooltip.progress')}}" data-class-name="progress">{{ __('tasks.progress') }}</th>
                	        	<th title="{{__('tasks_tooltip.estimated_progress')}}" data-class-name="progress">{{ __('tasks.estimated_progress') }}</th>
                	        	<th title="{{__('tasks.actions')}}">{{ __('tasks.actions') }}</th>
                	        </tr>
                	    </thead>
                        <tbody>
                            @foreach($response->tasks as $index => $task)
                            @php( ($task->end_is_milestone == 1) ? $last = $index : '')
                                <tr @if($task->end_is_milestone != 1 and $index > 0) class="childof{{$last}} nope" @endif>
                                    <td >@if($task->end_is_milestone == 1) <button title="{{__('general.mas')}}" class="parent" data-parent="{{$index}}">+</button> @endif</td>
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
                                        @if($task->end_is_milestone != 1) <a title="{{__('general.ticket')}}" href="/reports/{{$task->id}}/tickets" class="table-actions"><i class="fa fa-list-ul" aria-hidden="true"></i></a> @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </div>
                	</table>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    $('.parent').click(function(ev){
        let index = $(this).attr('data-parent');
        let stuff = $('.childof'+index).toggleClass('nope');
        console.log(stuff);
    });



  $('#excel').on('click',function(){
    $("#tasks-table").tableExport({type:'excel', ignoreColumn: [0],

escape:'true',
htmlContent:'false'});
  })
  $('#csv').on('click',function(){
    $("#tasks-table").tableExport({type:'csv',ignoreColumn: [0],

escape:'true',
htmlContent:'false'});
  })
  $('#pdf').on('click',function(){
  window.location.href = '/reports/tasks/pdf';

  })

</script>
@endsection