@extends('layouts.app', ['favoriteTitle' => __('risk_report.risk_report'), 'favoriteUrl' => url(Request::path())])
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


    <script src="{{ asset('js/risk_report.js') }}"></script>
    <script>  RiskReport.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>'); </script>
@endsection

@section('section_title', __('risk_report.risk_report'))

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
                                <label>{{ __('risk_report.period_from') }}</label>

                            </div>
                        </div>
                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <input class="md-input" required type="text"  id="period_from" name="start"
                                       placeholder="{{ __('risk_report.period_from') }}"
                                       value="{{ $contracts[0]->start_date}}"
                                       data-uk-datepicker="{format:'YYYY-MM-DD'}"><!--{{ $contracts[0]->start_date}}-->
                            </div>
                        </div>

                        <div class="uk-width-1-6">
                            <div class="md-input-wrapper">
                                <label>
                                    {{ __('risk_report.period_to') }}</label>
                            </div>
                        </div>

                        <div class="uk-width-1-6"><!--{{ $contracts[0]->finish_date}}-->
                            <div class="md-input-wrapper">
                                <input class="md-input" required placeholder="{{ __('risk_report.period_to') }} "
                                       type="text" 
                                        name="end" id="period_to" value="{{ $contracts[0]->finish_date}}"
                                       data-uk-datepicker="{format:'YYYY-MM-DD'}">
                            </div>
                        </div>






 

                        <div class="uk-width-1-6 float-right">
                            <button class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                                    onclick="RiskReport.generateReport();">
                                {{ __('tickets.update') }}
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

                    @if(!session()->has('project_id'))
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                    @endif

                    @if(session()->has('project_id'))
                        <table id="tickets-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th title="{{ __('tickets_tooltip.id') }}">{{ __('tickets.id') }}</th>
                                <th title="{{ __('tickets_tooltip.ticket_id') }}">{{ __('tickets.ticket_id') }}</th>
                                <th title="{{ __('tickets_tooltip.description') }}">{{ __('tickets.description') }}</th>
                                <th title="{{ __('tickets_tooltip.type') }}">{{ __('tickets.type') }}</th>
                                <th title="{{ __('tickets_tooltip.assignee') }}">{{ __('tickets.assignee') }}</th>
                                <th title="{{ __('tickets_tooltip.status') }}">{{ __('tickets.status') }}</th>
                                <th title="{{ __('tickets_tooltip.group') }}">{{ __('tickets.group') }}</th>
                                <th title="{{ __('tickets_tooltip.sprint') }}">{{ __('tickets.sprint') }}</th>
                                <th title="{{ __('tickets_tooltip.due_date') }}">{{ __('tickets.due_date') }}</th>
                                <th title="{{ __('tickets_tooltip.requester') }}">{{ __('tickets.requester') }}</th>

                                <th title="{{ __('tickets_tooltip.priority') }}">{{ __('tickets.priority') }}</th>
                                <th title="{{ __('tickets_tooltip.severity') }}">{{ __('tickets.severity') }}</th>
                                <th title="{{ __('tickets_tooltip.impact') }}">{{ __('tickets.impact') }}</th>
                                <th title="{{ __('tickets_tooltip.probability') }}">{{ __('tickets.probability') }}</th>
                                <th title="{{ __('tickets_tooltip.owner') }}">{{ __('tickets.owner') }}</th>
                                <th title="{{ __('tickets_tooltip.estimated_hours') }}">{{ __('tickets.estimated_hours') }}</th>
                                <th title="{{ __('tickets_tooltip.burned_hours') }}">{{ __('tickets.burned_hours') }}</th>
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

