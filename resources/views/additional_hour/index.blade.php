@extends('layouts.app', ['favoriteTitle' => __('additional_hours.additional_hours'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
    @include('datatables.basic')
    <script src="{{ asset('js/contracts.js') }}"></script>
    <script>
        $(function () {


            $('#additional_hours-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: API_PATH+'/additional_hours/datatables',
                dom: '<"top">rt<"bottom"lp><"clear">',
                data:{project_id:{{ session('project_id') }}},
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'project_role_title', name: 'project_role_title'},
                    {data: 'seniority_title', name: 'seniority_title'},
                    {data: 'currency_title', name: 'currency_title'},
                    {data: 'office_name', name: 'office_name'},
                    {data: 'country_name', name: 'country_name'},
                    {data: 'city_name', name: 'city_name'},
                    {data: 'comments', name: 'comments'},
                    {data: 'date', name: 'date'},
                    {data: 'hours', name: 'hours'},
                    {data: 'rate', name: 'rate'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a title={{__('general.edit')}} href="/additional_hours/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            <?php if (Auth::user()->hasPermission('delete.users')) { ?>
                                '<a title={{__('general.delete')}} href="/additional_hours/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            <?php } ?>
                    }
                }],

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();

                    var i = 0;
                    api.columns().every(function () {
                        if (i == 10 || i == 11) {
                            var sum = this
                                .data()
                                .reduce(function (a, b) {
                                    var x = parseFloat(a) || 0;
                                    if (isNaN(x)) {
                                        x = 0;
                                    }
                                    if (b != null) {
                                        var y = parseFloat(b) || 0;
                                        if (isNaN(y)) {
                                            y = 0;
                                        }
                                        return parseFloat(x) + parseFloat(y);
                                    }
                                }, 0);


                            if (sum != undefined) {

                                $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                            }

                        }
                        i++;
                    });


                },
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }


            });

            $(document).ready(function () {
                tableActions.initAjaxCreate();
                tableActions.initDelete('{{ __('general.confirm') }}');
            });
        });
    </script>
@endsection

@section('section_title', __('additional_hours.additional_hours'))

@section('content')

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
                        <table id="additional_hours-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th title="{{__('additional_hours_tooltip.id')}}">{{ __('additional_hours.id') }}</th>
                                <th title="{{__('additional_hours_tooltip.user')}}">{{ __('additional_hours.user') }}</th>
                                <th title="{{__('additional_hours_tooltip.project_role')}}">{{ __('additional_hours.project_role') }}</th>
                                <th title="{{__('additional_hours_tooltip.seniority')}}">{{ __('additional_hours.seniority') }}</th>
                                <th title="{{__('additional_hours_tooltip.currency')}}">{{ __('additional_hours.currency') }}</th>
                                <th title="{{__('additional_hours_tooltip.office')}}">{{ __('additional_hours.office') }}</th>
                                <th title="{{__('additional_hours_tooltip.country')}}">{{ __('additional_hours.country') }}</th>
                                <th title="{{__('additional_hours_tooltip.city')}}">{{ __('additional_hours.city') }}</th>
                                <th title="{{__('additional_hours_tooltip.comments')}}">{{ __('additional_hours.comments') }}</th>
                                <th title="{{__('additional_hours_tooltip.date')}}">{{ __('additional_hours.date') }}</th>
                                <th title="{{__('additional_hours_tooltip.hours')}}">{{ __('additional_hours.hours') }}</th>
                                <th title="{{__('additional_hours_tooltip.rate')}}">{{ __('additional_hours.rate') }}</th>
                                <th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>
                                </th>
                                <th>{{ __('invoices.total') }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="noprint"></th>

                            </tr>
                            </tfoot>
                        </table>
                        <div class="uk-grid datatables-bottom">
                            <div class="uk-width-medium-1-3" id="datatables-length"></div>
                            <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                            <div class="uk-width-medium-1-3">
                                <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                                   href="#" id="add-new" title="{{__('additional_hours.add_new')}}">{{ __('additional_hours.add_new') }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
    @component('additional_hour/create', [
        'users' => $users,
        'projectRoles'  => $projectRoles,
        'seniorities'   => $seniorities,
        'countries'     => $countries,
        'company'       => $company,
        'currencies'    => $currencies,
        'cities'        => $cities,
        'offices'       => $offices,
        'url'           => Request::path()
    ])

    @endcomponent
@endsection