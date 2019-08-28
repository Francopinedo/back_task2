@extends('layouts.app')

@section('scripts')

    <script src="{{ asset('js/profit_and_loss.js') }}"></script>
    <script>  ProfitAndLoss.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>'); </script>
@endsection

<style>

    .hidden {
        display: none
    }

    .red {
        background: red !important;
        -webkit-print-color-adjust: exact;
    }

    .green {
        background: green !important;
        -webkit-print-color-adjust: exact;
    }

    .pink {
        background: #ff5722;
    }

    .darkpink {
        background: #ff6fb3;
    }

    .bluelight {
        background: #4e88fb !important;
    }

    .bluedark {
        background: #473cfb !important;
    }

    @media print {
        .hidden {
            display: block !important;
        }

        table td:last-child {
            display: block !important
        }

        @page {
            size: landscape
        }
    }


</style>

@section('section_title', __('profit_and_loss.profit_and_loss'))

@section('content')
    @if(!session()->has('project_id'))
        <div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
    @endif
    @if(session()->has('project_id'))
        <div class="md-card ">

            <form role="form" id="data-form-edit" method="POST" id="data-form-edit">
                <div class="uk-grid noprint" data-uk-grid-margin>

                    <input type="hidden" name="company" id="company" value="{{ $company->id }}">
                    <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="customer_id" id="customer_id" value="{{ $project->customer_id }}">

                    <div class="uk-width-1-6">
                        <div class="md-input-wrapper">
                            <label>{{ __('capacity_planning.period_from') }}</label>

                        </div>
                        <br>
                        <div class="md-input-wrapper">
                            <input class="md-input" required type="text" readonly id="period_from" name="start"
                                   placeholder="{{ __('capacity_planning.period_from') }}"
                                   data-uk-datepicker="{format:'YYYY-MM-DD'}"
                                   value="{{$contracts[0]->start_date}}">
                        </div>
                    </div>


                    <div class="uk-width-1-6">

                        <div class="md-input-wrapper">
                            <label>
                                {{ __('capacity_planning.period_to') }}</label>
                        </div>
                        <br>
                        <div class="md-input-wrapper">
                            <input class="md-input" required placeholder="{{ __('capacity_planning.period_to') }} "
                                   type="text"
                                   readonly name="end" id="period_to" value="{{$contracts[0]->finish_date}}"
                                   data-uk-datepicker="{format:'YYYY-MM-DD'}">
                        </div>
                    </div>


                    <div class="uk-width-1-6">

                        <div class="md-input-wrapper">
                            <label>{{ __('projects.currency') }}</label>
                        </div>
                        <br>
                        <div class="md-input-wrapper md-input-select">

                            <select name="currency_id" id="currency_id" required data-md-selectize>
                                <option value="">{{ __('projects.currency') }}...</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                      id="currency_id-error"></span>

                        </div>
                    </div>

                    <div class="uk-width-1-6">


                        <div class="md-input-wrapper">
                            <label>{{ __('profit_and_loss.contracts') }}</label>
                        </div>

                        <br>
                        <div class="md-input-wrapper md-input-select">

                            <select name="contract_id[]" id="contract_id" multiple required data-md-selectize>
                                <option value="">{{ __('profit_and_loss.contracts') }}...</option>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}">{{ $contract->sow_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="parsley-errors-list filled"><span class="parsley-required"
                                                                      id="currency_id-error"></span>

                        </div>
                    </div>


                    <div class="uk-width-1-6 ">

                        <br>
                        <br>
                        <button class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                                type="submit">
                            {{ __('capacity_planning.regenerate') }}
                        </button>


                    </div>

                    <div class="uk-width-1-6 ">

                        <br>
                        <br>
                        <a id="profit_and_loss_pdf" onclick="ProfitAndLoss.pdf();"
                           class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                        >
                            {{ __('profit_and_loss.pdf') }}
                        </a>


                    </div>
                </div>


            </form>

            <input type="hidden" id="project_name" value="{{$project->name}}">


            <div class="md-card-content" style="overflow: auto">
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-1-1">
                        <h2 class="hidden">{{__('profit_and_loss.profit_and_loss')}}</h2>
                    </div>
                    <div class="uk-width-1-1">{{__('invoices.all_amounts')}}: <span id="currency_name"></span><br></div>
                    <div class="uk-width-1-1">


                        <table width="100%" border="1" id="table-profit_and_loss">

                            <tbody>
                            <tr>

                            </tr>
                            <tr>
                            </tr>
                            <tr>
                            </tr>
                            </tbody>

                        </table>


                        <table id="total" cellspacing="12" >
                            <tr>
                                <td class="bluedark">TOTAL REVENUE REAL: </td>
                                <td id="toalrevenuereal" class=""></td>
                                <td class="bluedark">TOTAL REVENUE PLANED: </td>
                                <td id="toalrevenueplaned" class=""></td>


                            </tr>
                            <tr>
                                <td class="bluedark">TOTAL COST REAL: </td>
                                <td id="toalcostreal" class=""></td>
                                <td class="bluedark">TOTAL COST PLANED: </td>
                                <td id="toalcostplaned" class=""></td>


                            </tr>

                            <tr>
                                <td class="bluedark">TOTAL PROFIT: </td>
                                <td id="totalprofit" class=""></td>
                                <td class="bluedark"> </td>
                                <td id="" class=""></td>
                            </tr>
                            <tr>
                                <td class="bluedark">TOTAL MARGIN %: </td>
                                <td id="totalmargin" class=""></td>
                                <td class="bluedark"></td>
                                <td id="" class=""></td>
                            </tr>

                        </table>


                        <span class="page-break"></span>
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection

@section('scripts')
    <script src="{{ asset('js/profit_and_loss.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            ProfitAndLoss.init('<?php echo e(env('API_PATH')); ?>');
        })

    </script>
@endsection