@extends('layouts.app', ['favoriteTitle' => __('capacity_planning.capacity_planning'), 'favoriteUrl' => url(Request::path())])
<style>
    .uk-width-1-2 {
        float: left
    }

    .uk-table caption, .uk-table tfoot {
        font-size: 17px !important;

    }

    .uk-table caption, .uk-table tfoot {
        font-style: normal !important;
        font-weight: 400 !important;

    }

    .uk-table caption {
        text-align: left;
        font-weight: 400 !important;
        font-family: Raleway, sans-serif !important;
        font-size: 15px !important;
        line-height: 1.6 !important;

    }

    .app_theme_dark .uk-table caption {
        color: white !important;
    }

    .uk-table th, .uk-table td {
        padding: 8px 8px;
        border-bottom: 1px solid #ddd;
        font-size: 13px;
    }
</style>
@section('scripts')
    @include('datatables.basic')


    <script src="{{ asset('js/capacity_planning.js') }}"></script>
    <script>  CapacityPlanning.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');

     </script>
@endsection

@section('section_title', __('capacity_planning.capacity_planning'))

@section('content')
    @if(!session()->has('project_id'))
        <div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
    @endif

    @if(session()->has('project_id'))
        <div class="md-card">
            <div class="md-card-content">
                <form role="form" id="data-form-edit" >
                    <div class="uk-grid" data-uk-grid-margin>

                        <input type="hidden" name="company" id="company" value="{{ $company->id }}">
                        <input type="hidden" name="customer" id="customer" value="{{ $project->customer_id}}">
                        <input type="hidden" name="project" id="project" value="{{ session('project_id')}}">


                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <label>
                                    {{ __('capacity_planning.workgroup') }}</label>


                            </div>
                        </div>
                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <select name="workgroup" id="workgroup" class="md-input" >
                                    <option value="ALL">{{ __('capacity_planning.all') }}</option>
                                    @foreach ($workgroups as $workgroup)
                                        <option value="{{ $workgroup->id }}"> {{ $workgroup->title }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="uk-width-1-6">

                            <div class="md-input-wrapper">
                                <label>{{ __('capacity_planning.period_from') }}</label>

                            </div>
                        </div>
                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <input class="md-input" required type="text"  id="period_from" name="start"
                                       placeholder="{{ __('capacity_planning.period_from') }}"
                                       value="{{ $contracts[0]->start_date}}"
                                       data-uk-datepicker="{format:'YYYY-MM-DD'}"><!--{{ $contracts[0]->start_date}}-->
                            </div>
                        </div>

                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <label>
                                    {{ __('capacity_planning.period_to') }}</label>
                            </div>
                        </div>

                        <div class="uk-width-1-6"><!--{{ $contracts[0]->finish_date}}-->
                            <div class="md-input-wrapper">
                                <input class="md-input" required placeholder="{{ __('capacity_planning.period_to') }} "
                                       type="text" 
                                        name="end" id="period_to" value="{{ $contracts[0]->finish_date}}"
                                       data-uk-datepicker="{format:'YYYY-MM-DD'}">
                            </div>
                        </div>


<div class="uk-width-1-6">

                            <div class="md-input-wrapper">
                                <label>{{ __('capacity_planning.sprint_from') }}</label>

                            </div>
                        </div>
                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <input class="md-input"  type="text"  id="sprint_from" name="sprint_from"
                                       placeholder="{{ __('capacity_planning.sprint_from') }}"
                                       value="{{ $project->start}}"
                                       data-uk-datepicker="{format:'YYYY-MM-DD'}">
                            </div>
                        </div>

                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <label>
                                    {{ __('capacity_planning.sprint_to') }}</label>
                            </div>
                        </div>

                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <input class="md-input"  placeholder="{{ __('capacity_planning.sprint_to') }} "
                                       type="text"
                                        name="end" id="period_to" value="{{ $contracts[0]->finish_date}}"
                                       data-uk-datepicker="{format:'YYYY-MM-DD'}">
                            </div>
                        </div>


<div class="uk-width-1-6">

                            <div class="md-input-wrapper">
                                <label>{{ __('capacity_planning.sprint_from') }}</label>

                            </div>
                        </div>
                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <input class="md-input"  type="text"  id="sprint_from" name="sprint_from"
                                       placeholder="{{ __('capacity_planning.sprint_from') }}"
                                       value="{{ $project->start}}"
                                       data-uk-datepicker="{format:'YYYY-MM-DD'}">
                            </div>
                        </div>

                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <label>
                                    {{ __('capacity_planning.sprint_to') }}</label>
                            </div>
                        </div>

                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <input class="md-input"  placeholder="{{ __('capacity_planning.sprint_to') }} "
                                       type="text"
                                        name="sprint_to" id="sprint_to" value="{{$project->finish}}"
                                       data-uk-datepicker="{format:'YYYY-MM-DD'}">
                            </div>
                        </div>



                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <label>  {{ __('capacity_planning.contract_working_hours') }}</label>

                            </div>
                        </div>
                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <label id="contract_working_hours">
                                    {{$hours}}  {{__('capacity_planning.hours')}}  {{ $contracts[0]->workinghours_from }}
                                    - {{ $contracts[0]->workinghours_to}}
                                </label>

                            </div>
                        </div>


                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <label>{{ __('capacity_planning.report_label') }}</label>

                            </div>
                        </div>
                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <input class="md-input"  type="text" required
                                       name="report_label" id="report_label" value="">

                            </div>
                        </div>


                        <div class="uk-width-1-6 float-right">
                            <button class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                                    onclick=" CapacityPlanning.generateReport();return false;">
                                {{ __('capacity_planning.regenerate') }}
                            </button>


                        </div>
                    </div>


                </form>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-1-1">


                        @if(session()->has('message'))
                            <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                                <a href="#" class="uk-alert-close uk-close"></a>
                                {{ session('message') }}
                            </div>
                        @endif

                        @if(!empty($users))
                            <table id="capacity_planning-table" class="uk-table" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th title="{{__('users.id')}}">{{ __('users.id') }}</th>
                                    <th title="{{__('capacity_planning_tooltip.customer_name')}}">{{ __('users.name') }}</th>
                                    <th title="{{__('capacity_planning_tooltip.working_hours')}}">{{ __('capacity_planning.working_hours') }}</th>
                                    <th title="{{__('capacity_planning_tooltip.absents')}}">{{ __('capacity_planning.absents') }}</th>
                                    <th title="{{__('capacity_planning_tooltip.replacements_hours')}}">{{ __('capacity_planning.replacements_hours') }}</th>
                                    <th title="{{__('capacity_planning_tooltip.holidays')}}">{{ __('capacity_planning.holidays') }}</th>
                                    <th title="{{__('capacity_planning_tooltip.hours_available')}}">{{ __('capacity_planning.hours_available') }}</th>
                                    <th title="{{__('capacity_planning_tooltip.hours_asigned')}}">{{ __('capacity_planning.hours_asigned') }}</th>
                                    <th title="{{__('capacity_planning_tooltip.efective_capacity')}}">{{ __('capacity_planning.efective_capacity') }}</th>


                                </tr>
                                </thead>
                            </table>
                            <div class="uk-grid datatables-bottom">
                                <div class="uk-width-medium-1-3" id="datatables-length"></div>
                                <div class="uk-width-medium-1-3" id="datatables-pagination"></div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

