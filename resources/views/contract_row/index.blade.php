@extends('layouts.app')
<style>
    .uk-table caption, .uk-table tfoot {
        background: #546e7a;
    }

</style>
@section('scripts')
    <!-- datatables -->
    <script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- datatables buttons-->
    <script src="{{ asset('bower_components/datatables-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('assets/js/custom/datatables/buttons.uikit.js') }}"></script>
    <script src="{{ asset('bower_components/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('bower_components/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('bower_components/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.print.js') }}"></script>

    <!-- datatables custom integration -->
    <script src="{{ asset('assets/js/custom/datatables/datatables.uikit.min.js') }}"></script>

    <!--  datatables functions -->
    {{-- <script src="assets/js/pages/plugins_datatables.min.js"></script> --}}

    <!--  forms advanced functions -->
    {{-- <script src="assets/js/pages/forms_advanced.min.js"></script> --}}
    <script src="{{ asset('js/contracts.js') }}"></script>

    <script>
        $(function () {

            var subtotal = 0;

            $('#contract_resources-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}contract_resources/datatables?contract_id={{ $contract->id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'project_role_title', name: 'project_role_title'},
                    {data: 'seniority_title', name: 'seniority_title'},
                    {data: 'qty', name: 'qty'},
                    {data: 'hours', name: 'hours'},
                    {data: 'rate', name: 'rate'},
                    {data: 'amount', name: 'amount'},
                    {data: 'office_name', name: 'office_name'},
                    {data: 'load', name: 'load'},
                    {data: 'workplace', name: 'workplace'},
                    {data: 'country_name', name: 'country_name'},
                    {data: 'city_name', name: 'city_name'},
                    {data: 'comments', name: 'comments'},
                    {data: 'rate_exchage', name: 'rate_exchage'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a title="{{__('general.edit')}}" href="/contract_resources/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' 
                            <?php if (Auth::user()->hasPermission('delete.users')) { ?> +
                                '<a title="{{__('general.delete')}}" href="/contract_resources/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                            <?php } ?>;

                    }
                }],

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();


                    console.log(data);
                    var i = 0;
                    api.columns().every(function () {
                        if (i == 13) {
                            console.log(this
                                .data());
                            var sum = this
                                .data()
                                .reduce(function (a, b) {


                                    console.log(a);
                                    console.log(b);

                                    var x = parseFloat(a) || 0;

                                    if (isNaN(x)) {
                                        x = 0;
                                    }


                                    //   console.log(x);
                                    // console.log(b);
                                    if (b != null) {

                                        var y = parseFloat(b) || 0;

                                        if (isNaN(y)) {
                                            y = 0;
                                        }
                                        //  console.log(y);


                                        return parseFloat(x) + parseFloat(y);
                                    }
                                }, 0);


                            if (sum != undefined) {


                                if (i == 13) {

                                    subtotal = parseFloat(sum) + parseFloat(subtotal);
                                    $("#subtotal").text(subtotal.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }

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

            $('#contract_expenses-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}contract_expenses/datatables?contract_id={{ $contract->id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'detail', name: 'detail'},
                    {data: 'reimbursable', name: 'reimbursable'},
                    {data: 'frequency', name: 'frequency'},
                    {data: 'cost', name: 'cost'},
                    {data: 'cost_exchage', name: 'cost_exchage'},
                    {data: 'amount', name: 'amount'},
                    {data: 'rate_exchage', name: 'v'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a title="{{__('general.edit')}}" href="/contract_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' 
                            <?php if (Auth::user()->hasPermission('delete.users')) { ?>+
                                '<a title="{{__('general.delete')}}" href="/contract_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                            <?php } ?>;
                    }
                }],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();

                    var i = 0;
                    api.columns().every(function () {
                        if (i == 5 || i == 7) {
                            var sum = this
                                .data()
                                .reduce(function (a, b) {


                                    var x = parseFloat(a) || 0;

                                    if (isNaN(x)) {
                                        x = 0;
                                    }
                                    //   console.log(x);
                                    // console.log(b);
                                    if (b != null) {

                                        var y = parseFloat(b) || 0;
                                        if (isNaN(y)) {
                                            y = 0;
                                        }

                                        return parseFloat(x) + parseFloat(y);
                                    }
                                }, 0);


                            if (sum != undefined) {
                                if (i == 7) {
                                    subtotal = parseFloat(sum) + parseFloat(subtotal);
                                    $("#subtotal").text(subtotal.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }
                                $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                            }

                        }
                        i++;
                    });


                },
            });

            $('#contract_services-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}contract_services/datatables?contract_id={{ $contract->id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'detail', name: 'detail'},
                    {data: 'reimbursable', name: 'reimbursable'},
                    {data: 'frequency', name: 'frequency'},
                    {data: 'cost', name: 'cost'},
                    {data: 'cost_exchage', name: 'cost_exchage'},
                    {data: 'amount', name: 'amount'},
                    {data: 'rate_exchage', name: 'rate_exchage'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a title="{{__('general.edit')}}" href="/contract_services/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' 
                            <?php if (Auth::user()->hasPermission('delete.users')) { ?> +
                                '<a title="{{__('general.delete')}}" href="/contract_services/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                            <?php } ?>;
                    }
                }],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();

                    var i = 0;
                    api.columns().every(function () {
                        if (i == 5 || i == 7) {
                            var sum = this
                                .data()
                                .reduce(function (a, b) {


                                    var x = parseFloat(a) || 0;

                                    if (isNaN(x)) {
                                        x = 0;
                                    }
                                    //   console.log(x);
                                    // console.log(b);
                                    if (b != null) {

                                        // console.log(b);


                                        var y = parseFloat(b) || 0;


                                        if (isNaN(y)) {
                                            y = 0;
                                        }
                                        //  console.log(y);


                                        return parseFloat(x) + parseFloat(y);
                                    }
                                }, 0);


                            if (sum != undefined) {
                                if (i == 7) {
                                    subtotal = parseFloat(sum) + parseFloat(subtotal);
                                    $("#subtotal").text(subtotal.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }
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

            $('#contract_materials-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}contract_materials/datatables?contract_id={{ $contract->id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'detail', name: 'detail'},
                    {data: 'reimbursable', name: 'reimbursable'},
                    {data: 'frequency', name: 'frequency'},
                    {data: 'cost', name: 'cost'},
                    {data: 'cost_exchage', name: 'cost_exchage'},
                    {data: 'amount', name: 'amount'},
                    {data: 'rate_exchage', name: 'rate_exchage'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a title="{{__('general.edit')}}" href="/contract_materials/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' 
                            <?php if (Auth::user()->hasPermission('delete.users')) { ?> +
                                '<a title="{{__('general.delete')}}" href="/contract_materials/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                            <?php } ?>;
                    }
                }],

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();

                    var i = 0;
                    api.columns().every(function () {
                        if (i == 5|| i == 7) {
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
                                if (i == 7) {
                                    subtotal = parseFloat(sum) + parseFloat(subtotal);
                                    $("#subtotal").text(subtotal.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }
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
        });

        $(document).ready(function () {
            tableActions.initAjaxCreate();
            tableActions.initDelete('{{ __('general.confirm') }}');
        });

    </script>
@endsection

@section('section_title', __('contracts.items'))

@section('content')
    <a title="{{__('general.return')}}" href="/contracts"> <i class="fa fa-arrow-circle-left fa-3x"></i></a>

    <br>
    <br>
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

                    <h4 class="heading_a uk-margin-bottom">{{ __('contracts.resources') }}</h4>
                    <table id="contract_resources-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th title="{{__('contracts_resources.id.')}}">{{ __('contract_resources.id') }}</th>
                            <th title="{{__('contracts_tooltip.project_role')}}">{{ __('contracts.project_role') }}</th>
                            <th title="{{__('contracts_tooltip.seniority')}}">{{ __('contracts.seniority') }}</th>
                            <th title="{{__('contracts_tooltip.qty')}}">{{ __('contracts.qty') }}</th>
                            <th title="{{__('contracts_tooltip.workinghours')}}">{{ __('contracts.workinghours') }}</th>
                            <th title="{{__('contracts_tooltip.rate')}}">{{ __('contracts.rate') }}</th>
                            <th title="{{__('contracts_tooltip.total')}}">{{ __('contracts.total') }}</th>
                            <th title="{{__('contracts_tooltip.office')}}">{{ __('contracts.office') }}</th>
                            <th title="{{__('contracts_tooltip.load')}}">{{ __('contracts.load') }}</th>
                            <th title="{{__('contracts_tooltip.workplace')}}">{{ __('contracts.workplace') }}</th>
                            <th title="{{__('contracts_tooltip.country')}}">{{ __('contracts.country') }}</th>
                            <th title="{{__('contracts_tooltip.city')}}">{{ __('contracts.city') }}</th>
                            <th title="{{__('contracts_tooltip.comments')}}">{{ __('contracts.comments') }}</th>
                            <th title="{{__('contracts_tooltip.total_exchanged')}}">{{ __('contracts.total_exchanged') }}</th>
                            <th title="{{__('contracts_tooltip.currency')}}">{{ __('contracts.currency') }}</th>
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
                            <th></th>
                            <th></th>
                            <th>{{ $currency->name }}</th>

                            <th class="noprint"></th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <h4 class="heading_a uk-margin-bottom">{{ __('contracts.expenses') }}</h4>
                    <table id="contract_expenses-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th title="{{__('contracts_tooltip.id')}}">{{ __('contracts.id') }}</th>
                            <th title="{{__('contracts_tooltip.detail')}}">{{ __('contracts.detail') }}</th>
                            <th title="{{__('contracts_tooltip.reimbursable')}}">{{ __('contracts.reimbursable') }}</th>
                            <th title="{{__('contracts_tooltip.frequency')}}">{{ __('contracts.frequency') }}</th>
                            <th title="{{__('contracts_tooltip.cost')}}">{{ __('contracts.cost') }}</th>
                            <th title="{{__('contracts_tooltip.cost_exchanged')}}">{{ __('contracts.cost_exchanged') }}</th>
                            <th title="{{__('contracts_tooltip.amount')}}">{{ __('contracts.amount') }}</th>
                            <th title="{{__('contracts_tooltip.amount_exchanged')}}">{{ __('contracts.amount_exchanged') }}</th>
                            <th title="{{__('contracts_tooltip.currency')}}">{{ __('contracts.currency') }}</th>
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
                            <th>{{ $currency->name }}</th>

                            <th class="noprint"></th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <h4 class="heading_a uk-margin-bottom">{{ __('contracts.services') }}</h4>
                    <table id="contract_services-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th title="{{__('contracts_tooltip.id')}}">{{ __('contracts.id') }}</th>
                            <th title="{{__('contracts_tooltip.detail')}}">{{ __('contracts.detail') }}</th>
                            <th title="{{__('contracts_tooltip.reimbursable')}}">{{ __('contracts.reimbursable') }}</th>
                            <th title="{{__('contracts_tooltip.frequency')}}">{{ __('contracts.frequency') }}</th>
                            <th title="{{__('contracts_tooltip.cost')}}">{{ __('contracts.cost') }}</th>
                            <th title="{{__('contracts_tooltip.cost_exchanged')}}">{{ __('contracts.cost_exchanged') }}</th>
                            <th title="{{__('contracts_tooltip.amount')}}">{{ __('contracts.amount') }}</th>
                            <th title="{{__('contracts_tooltip.amount_exchanged')}}">{{ __('contracts.amount_exchanged') }}</th>
                            <th title="{{__('contracts_tooltip.currency')}}">{{ __('contracts.currency') }}</th>
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
                            <th>{{ $currency->name }}</th>

                            <th class="noprint"></th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    <h4 class="heading_a uk-margin-bottom">{{ __('contracts.materials') }}</h4>
                    <table id="contract_materials-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th title="{{__('contracts_tooltip.id')}}">{{ __('contracts.id') }}</th>
                            <th title="{{__('contracts_tooltip.detail')}}">{{ __('contracts.detail') }}</th>
                            <th title="{{__('contracts_tooltip.reimbursable')}}">{{ __('contracts.reimbursable') }}</th>
                            <th title="{{__('contracts_tooltip.frequency')}}">{{ __('contracts.frequency') }}</th>
                            <th title="{{__('contracts_tooltip.cost')}}">{{ __('contracts.cost') }}</th>
                            <th title="{{__('contracts_tooltip.cost_exchanged')}}">{{ __('contracts.cost_exchanged') }}</th>
                            <th title="{{__('contracts_tooltip.amount')}}">{{ __('contracts.amount') }}</th>
                            <th title="{{__('contracts_tooltip.amount_exchanged')}}">{{ __('contracts.amount_exchanged') }}</th>
                            <th title="{{__('contracts_tooltip.currency')}}">{{ __('contracts.currency') }}</th>
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
                            <th>{{ $currency->name }}</th>

                            <th class="noprint"></th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">


                    <table id="" class="uk-table" cellspacing="0" width="100%">
                        <tbody>
                        <tr>
                            <th><h3>{{ __('invoices.total') }}</h3></th>
                            <th>
                                <h3 id="subtotal"></h3>
                            </th>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="md-fab-wrapper md-fab-in-card" style="position: fixed;">
        <div class="md-fab md-fab-accent md-fab-sheet">
            <i class="fa fa-plus" aria-hidden="true"></i>
            <div class="md-fab-sheet-actions">
                <a href="{{ url('contract_resources/'.$contract->id.'/create') }}"
                   class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul">&#xE2C7;</i> {{ __('contracts.new_resource') }}</a>
                <a href="{{ url('contract_expenses/'.$contract->id.'/create') }}"
                   class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('contracts.new_expense') }}</a>
                <a href="{{ url('contract_services/'.$contract->id.'/create') }}"
                   class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('contracts.new_service') }}</a>
                <a href="{{ url('contract_materials/'.$contract->id.'/create') }}"
                   class="md-color-white ajax_create-btn"><i
                            class="fa fa-list-ul"></i> {{ __('contracts.new_material') }}</a>
            </div>
        </div>
    </div>
@endsection

{{-- @section('create_div')
	@component('contract/create', [])

	@endcomponent
@endsection --}}