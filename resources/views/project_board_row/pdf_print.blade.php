@extends('layouts.app', ['favoriteTitle' => __('projects.board'), 'favoriteUrl' => 'rows'])
@if(session()->has('project_id'))

@section('scripts')
    {{-- <script src="{{ asset('assets/js/CSVExport.js') }}"></script> --}}
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
    <script src="{{ asset('js/project_board.js') }}"></script>
    <script src="{{ asset('js/contracts.js') }}"></script>

    <script>
        $(function () {
            var subtotal = 0;


            $('#project_resources-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}project_resources/datatables?project_id={{ session('project_id') }}&contract_id={{$contracts[0]->id}}',
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
                    {data: 'user_name', name: 'user_name'},
                    {data: 'hours', name: 'hours'},
                    {data: 'rate', name: 'rate'},
                    {data: 'type', name: 'type'},
                    {data: 'amount', name: 'amount'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'rate_exchage', name: 'rate_exchage'},
                    {data: 'load', name: 'load'},
                    {data: 'workplace', name: 'workplace'},
                    {data: 'country_name', name: 'country_name'},
                    {data: 'city_name', name: 'city_name'},
                    {data: 'office_name', name: 'office_name'},
                    {data: 'comments', name: 'comments'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        if (row.type == 'ordinary') {
                            return '' +
                                '<a href="/project_resources/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                '<a href="/project_resources/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                        } else {
                            return '';
                        }

                    }
                },
                    {
                        targets: 4,
                        data: null,
                        render: function (data, type, row) {
                            if (data < 0) {
                                return 0;
                            } else {
                                return data;
                            }
                        }
                    },

                    {
                        targets: 9,
                        data: null,
                        render: function (data, type, row) {
                            if (data < 0) {
                                return 0;
                            } else {
                                return data;
                            }
                        }
                    }
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();
                    console.log(data);
                    var i = 0;
                    api.columns().every(function () {
                        if (i == 9 || i ==4) {
                            console.log(this
                                .data());
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
                                if (i == 9) {
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
                    // projectBoard.data.resources = json.data;
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });

            $('#project_expenses-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}project_expenses/datatables?project_id={{ session('project_id') }}&contract_id={{$contracts[0]->id}}',
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
                    {data: 'reimbursable', name: 'detail'},
                    {data: 'cost', name: 'cost'},
                    {data: 'cost_exchage', name: 'cost_exchage'},
                    {data: 'amount', name: 'amount'},
                    {data: 'rate_exchage', name: 'rate_exchage'},
                    {data: 'frequency', name: 'frequency'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a href="/project_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/project_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                }],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();
                    var i = 0;
                    api.columns().every(function () {
                        if (i == 4 || i == 6) {
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
                                if (i == 6) {
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
                    // projectBoard.data.expenses = json.data;
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });

            $('#project_services-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}project_services/datatables?project_id={{ session('project_id') }}&contract_id={{$contracts[0]->id}}',
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
                    {data: 'reimbursable', name: 'detail'},
                    {data: 'cost', name: 'cost'},
                    {data: 'cost_exchage', name: 'cost_exchage'},
                    {data: 'amount', name: 'amount'},
                    {data: 'rate_exchage', name: 'rate_exchage'},
                    {data: 'frequency', name: 'frequency'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        console.log(row);
                        return '' +
                            '<a href="/project_services/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/project_services/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                }],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();

                    var i = 0;
                    api.columns().every(function () {
                        if (i == 4 || i == 6) {
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
                                if (i == 4) {
                                    subtotal = parseFloat(sum) + parseFloat(subtotal);
                                    $("#subtotal").text(subtotal);
                                }
                                $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                            }

                        }
                        i++;
                    });


                },
                initComplete: function (settings, json) {
                    // projectBoard.data.services = json.data;
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });

            $('#project_materials-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}project_materials/datatables?project_id={{ session('project_id') }}&contract_id={{$contracts[0]->id}}',
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
                    {data: 'cost', name: 'cost'},
                    {data: 'cost_exchage', name: 'cost_exchage'},
                    {data: 'amount', name: 'amount'},
                    {data: 'rate_exchage', name: 'rate_exchage'},
                    {data: 'frequency', name: 'frequency'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '' +
                            '<a href="/project_materials/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                            '<a href="/project_materials/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }
                }],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();

                    var i = 0;
                    api.columns().every(function () {
                        if (i == 4 || i == 6) {
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
                                if (i == 4) {
                                    subtotal = parseFloat(sum) + parseFloat(subtotal);
                                    $("#subtotal").text(subtotal);
                                }
                                $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                            }

                        }
                        i++;
                    });


                },
                initComplete: function (settings, json) {
                    // projectBoard.data.materials = json.data;
                    tableActions.initEdit();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                }
            });
        });

        $(document).ready(function () {
            tableActions.initAjaxCreate();
            tableActions.initDelete('{{ __('general.confirm') }}');

            projectBoard.init('{{ __('projects.confirm_update') }}');

        });

    </script>
@endsection
@endif
<style>
    .uk-table caption, .uk-table tfoot {
        background: #546e7a;
    }

</style>
    <style>
        body {
            font-family: Helvetica;
            font-size: 11px;
        }

        @page {
            margin: 30px 30px 30px 30px;
        }

        header {
            font-size: 12px;
            position: fixed;
            left: 0px;

            height: 150px;
            top: -0px;
            right: 0px;

        }

        footer {
            font-size: 12px;
            position: fixed;
            left: 0px;
            bottom: -20px;
            right: 0px;
            border: 1px solid black;
            height: 160px;

        }

        .page:after {
            content: counter(page);
        }

        .main {
            position: relative;
            top: 300px;

            margin-bottom: 50px;

        }

        footer {
            width: 60%;
        }

        footer p {
            text-align: right;
        }

        footer .izq {
            text-align: left;
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

    </style>
@section('section_title', __('projects.board'))

@section('content')
    @if(!session()->has('project_id'))
        <div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
    @endif

    @if(session()->has('project_id'))

        @if (empty($contracts))
            <div class="uk-alert uk-alert-warning" data-uk-alert>
                <a href="#" class="uk-alert-close uk-close"></a>
                {{ __('projects.you_need_a_related_contract') }}
            </div>
        @else
            @if ($countRows->rows == 0)
                <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                   id="update_from_contracts" data-project_id="{{ session('project_id') }}"
                   href="javascript:void(0)">{{ __('projects.create_from_contracts') }}</a>
            @endif
        @endif

        <a class="md-btn md-btn-primary md-btn-wave-light  waves-effect waves-button waves-light" tabindex="0"
           id="add-new" href="">
            <span>{{ __('projects.generate_billing') }}</span>
        </a>
        <br><br>
<table width="100%">

        <tr>
            <td width="60%">
               @if(!empty($company->logo_path) || $company->logo_path!='' ) 
                <img style="height:100px" src="{{base_path()  .'/assets/img/companies/'. $company->id .'/'. $company->logo_path}}">
                @endif
                <h3 class="upper red">{{$company->name}}</h3>
                <h4>{{$company->address}}</h4><br>
          
            </td>
            <td>
                @if(!empty($customer->logo_path) || $customer->logo_path!='' ) 
                <img style="height:100px" src="{{ base_path()  .'/assets/img/customers/'. $customer->id .'/'. $customer->logo_path }}">
                @endif
                <br>

                <b> {{$customer->address}}</b><br>
               

                {{$project->name}}<br>


            </td>
        </tr>


        <tr>
            <td colspan="2">
                <br/> <br/>
               <br>



            </td>
        </tr>
    </table>
        <div class="md-card noprint">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <div class="dt-buttons btn-group"> <!--{{url('/')}}/project_board/pdf-->
                            <a class="md-btn" tabindex="0" id="project_board_pdf" href="#">
                                <span>PDF</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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


                        <h4 class="heading_a uk-margin-bottom">{{ __('projects.resources') }}</h4>
                        <table id="project_resources-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('projects.id') }}</th>
                                <th>{{ __('projects.project_role') }}</th>
                                <th>{{ __('projects.seniority') }}</th>
                                <th>{{ __('projects.user') }}</th>
                                <th>{{ __('projects.working_hours') }}</th>
                                <th>{{ __('projects.rate') }}</th>
                                <th>{{ __('projects.type') }}</th>
                                <th>{{ __('invoices.total') }}</th>
                                <th>{{ __('projects.currency') }}</th>
                                <th>{{ __('projects.exchanged') }}</th>
                                <th>{{ __('projects.load') }}</th>
                                <th>{{ __('projects.workplace') }}</th>
                                <th>{{ __('projects.country') }}</th>
                                <th>{{ __('projects.city') }}</th>
                                <th>{{ __('projects.office') }}</th>
                                <th>{{ __('projects.comments') }}</th>
                                <th class="noprint">{{ __('general.actions') }}</th>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">

                        <h4 class="heading_a uk-margin-bottom">{{ __('projects.expenses') }}</h4>
                        <table id="project_expenses-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('project.id') }}</th>
                                <th>{{ __('projects.detail') }}</th>
                                <th>{{ __('projects.reimbursable') }}</th>
                                <th>{{ __('projects.cost') }}</th>
                                <th>{{ __('projects.cost_exchanged') }}</th>
                                <th>{{ __('projects.amount') }}</th>
                                <th>{{ __('projects.amount_exchanged') }}</th>
                                <th>{{ __('projects.frequency') }}</th>
                                <th>{{ __('projects.currency') }}</th>
                                <th class="noprint">{{ __('general.actions') }}</th>
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

                        <h4 class="heading_a uk-margin-bottom">{{ __('projects.services') }}</h4>
                        <table id="project_services-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('project.id') }}</th>
                                <th>{{ __('projects.detail') }}</th>
                                <th>{{ __('projects.reimbursable') }}</th>
                                <th>{{ __('projects.cost') }}</th>
                                <th>{{ __('projects.cost_exchanged') }}</th>
                                <th>{{ __('projects.amount') }}</th>
                                <th>{{ __('projects.amount_exchanged') }}</th>
                                <th>{{ __('projects.frequency') }}</th>
                                <th>{{ __('projects.currency') }}</th>
                                <th class="noprint">{{ __('general.actions') }}</th>
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

                        <h4 class="heading_a uk-margin-bottom">{{ __('projects.materials') }}</h4>
                        <table id="project_materials-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('project.id') }}</th>
                                <th>{{ __('projects.detail') }}</th>
                                <th>{{ __('projects.reimbursable') }}</th>
                                <th>{{ __('projects.cost') }}</th>
                                <th>{{ __('projects.cost_exchanged') }}</th>
                                <th>{{ __('projects.amount') }}</th>
                                <th>{{ __('projects.amount_exchanged') }}</th>
                                <th>{{ __('projects.frequency') }}</th>
                                <th>{{ __('projects.currency') }}</th>
                                <th class="noprint">{{ __('general.actions') }}</th>
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
                    <a href="{{ url('project_resources/'.session('project_id').'/create') }}"
                       class="md-color-white ajax_create-btn"><i
                                class="fa fa-list-ul">&#xE2C7;</i> {{ __('projects.new_resource') }}</a>
                    <a href="{{ url('project_expenses/'.session('project_id').'/create') }}"
                       class="md-color-white ajax_create-btn"><i
                                class="fa fa-list-ul"></i> {{ __('projects.new_expense') }}</a>
                    <a href="{{ url('project_services/'.session('project_id').'/create') }}"
                       class="md-color-white ajax_create-btn"><i
                                class="fa fa-list-ul"></i> {{ __('projects.new_service') }}</a>
                    <a href="{{ url('project_materials/'.session('project_id').'/create') }}"
                       class="md-color-white ajax_create-btn"><i
                                class="fa fa-list-ul"></i> {{ __('projects.new_material') }}</a>
                </div>
            </div>
        </div>

    @endif
@endsection



