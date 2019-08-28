@extends('layouts.app', ['favoriteTitle' => __('contracts.contracts'), 'favoriteUrl' => 'contracts'])

@section('scripts')
    @include('datatables.basic')
    <script>
        $(function () {
            var tableName = 'contracts';
            var urlParameters = '?company_id={{ $company->id }}';
            var columns = [
                {data: 'id', name: 'id', visible: false},
                {data: 'customer_name', name: 'customer_name'},
                {data: 'project_name', name: 'project_name'},
                {data: 'sow_number', name: 'sow_number'},
                {data: 'start_date', name: 'start_date'},
                {data: 'finish_date', name: 'finish_date'},
                {data: 'actions', name: 'actions'}
            ];

            var actions = [
                {
                    pre: '<a href="/contract/rows/',
                    post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>'
                },
                {
                    pre: '<a href="/contracts/',
                    post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
                },
                {
                    pre: '<a href="/contracts/',
                    post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                },

                {
                    pre: '<a href="/contracts/pdf/',
                    post: '/" class="table-actions"><i class="fa fa-file" aria-hidden="true"></i></a>'
                }
            ];

            DtablesUtil(tableName, columns, actions, urlParameters);
        });
    </script>

@endsection

@section('section_title', __('contracts.contracts'))

@section('content')



    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    @if(empty($customers))
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            {{ __('contracts.add_a_customer') }}
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                    @endif

                    @if(!empty($customers))
                        <table id="contracts-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('contracts.id') }}</th>
                                <th>{{ __('contracts.customer') }}</th>
                                <th>{{ __('contracts.project') }}</th>
                                <th>{{ __('contracts.sow_number') }}</th>
                                <th>{{ __('contracts.start_date') }}</th>
                                <th>{{ __('contracts.finish_date') }}</th>
                                <th>{{ __('general.actions') }}</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="uk-grid datatables-bottom">
                            <div class="uk-width-medium-1-3" id="datatables-length"></div>
                            <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                            <div class="uk-width-medium-1-3">
                                <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                                   href="#" id="add-new">{{ __('contracts.add_new') }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
    @component('contract/create', ['customers' => $customers, 'company' => $company, 'engagements' => $engagements, 'currencies'=>$currencies])

    @endcomponent
@endsection