@extends('layouts.app', ['favoriteTitle' => __('tasks.report_tasks'), 'favoriteUrl' => 'reports/tasks'])
{{-- {{dd($response)}}  --}}

@section('section_title', __('tasks.report_tasks'))

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
                	<table id="tasks-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th></th>
                	        	<th>{{ __('tasks.project') }}</th>
                                <th>{{ __('tasks.phase') }}</th>
                	        	<th>{{ __('tasks.description') }}</th>
                	        	<th>{{ __('tasks.start_date') }}</th>
                	        	<th>{{ __('tasks.due_date') }}</th>
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
                                <tr @if($task->end_is_milestone != 1 and $index > 0) class="childof{{$last}} nope" @endif>
                                    <td>@if($task->end_is_milestone == 1) <button class="parent" data-parent="{{$index}}">+</button> @endif</td>
                                    <td>{{$response->project->name}}</td>
                                    <td>{{$task->phase}}</td>
                                    <td>{{$task->description}}</td>
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
                	</table>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $('.parent').click(function(ev){
        let index = $(this).attr('data-parent');
        let stuff = $('.childof'+index).toggleClass('nope');
        console.log(stuff);
    });
</script>
@endsection