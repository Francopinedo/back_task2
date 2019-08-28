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
    <script src="{{ asset('js/invoices.js') }}"></script>
    <script src="{{ asset('js/contracts.js') }}"></script>

    <script>


        var subtotal = 0;
        var totaltaxes = 0;
        var totaltaxesporcentaje = 0;
        var totaldescuento = 0;
        var totaldescuentoporcentaje = 0;

        $(function () {
            $('#invoice_resources-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}invoice_resources/datatables?invoice_id={{ $invoice_id }}',
                dom: '<"top">rt<"bottom"lp><"clear">',
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
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'workplace', name: 'workplace'},
                    {data: 'load', name: 'load'},
                    {data: 'rate', name: 'rate'},
                    {data: 'hours', name: 'hours'},
                    {data: 'total', name: 'total'},
                    {data: 'type', name: 'type'},
                    {data: 'comments', name: 'comments'},
                    {data: 'actions', name: 'actions'}
                ],
                columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        if (row.emited == '0') {
                            return '' +
                                '<a href="/invoice_resources/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                '<a href="/invoice_resources/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        } else {
                            return '';
                        }
                    }
                }],
                initComplete: function (settings, json) {
                    tableActions.initEdit();
                    expenses();
                    // tableActions.initAjaxCreate();
                    // tableActions.initDelete('{{ __('general.confirm') }}');
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();


                    var i = 0;
                    api.columns().every(function () {
                        if (i > 7 && i < 10) {
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
                                        //  console.log(y);


                                        return parseFloat(x) + parseFloat(y);
                                    }
                                }, 0);


                            if (sum != undefined) {

                                if(i==9){
                                    subtotal=subtotal+sum;
                                }
                                $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                            }

                        }
                        i++;
                    });


                }

            });
        });

        function expenses() {
            $(function () {
                $('#invoice_expenses-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bPaginate: false,
                    ajax: '{{ env('API_PATH') }}invoice_expenses/datatables?invoice_id={{ $invoice_id }}',
                    dom: '<"top">rt<"bottom"lp><"clear">',
                    language: {
                        paginate: {
                            previous: "<<",
                            next: ">>"
                        }
                    },
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();

                        var i = 0;
                        api.columns().every(function () {
                            if (i == 2) {
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
                                    if(i==2) {
                                        subtotal = sum + subtotal;
                                    }
                                    $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }

                            }
                            i++;
                        });


                    },

                    columns: [
                        {data: 'id', name: 'id', visible: false},
                        {data: 'detail', name: 'detail'},
                        {data: 'amount', name: 'amount'},
                        {data: 'currency_name', name: 'currency_name'},
                        {data: 'actions', name: 'actions'}
                    ],
                    columnDefs: [{
                        targets: -1,
                        data: null,
                        render: function (data, type, row) {
                            if (row.emited == '0') {
                                return '' +
                                    '<a href="/invoice_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                    '<a href="/invoice_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            } else {
                                return '';
                            }
                        }
                    }],
                    initComplete: function (settings, json) {
                        tableActions.initEdit();
                        services();
                        // tableActions.initAjaxCreate();
                        // tableActions.initDelete('{{ __('general.confirm') }}');
                    }
                });
            });
        }

        function services() {
            $(function () {
                $('#invoice_services-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bPaginate: false,
                    ajax: '{{ env('API_PATH') }}invoice_services/datatables?invoice_id={{ $invoice_id }}',
                    dom: '<"top">rt<"bottom"lp><"clear">',
                    language: {
                        paginate: {
                            previous: "<<",
                            next: ">>"
                        }
                    },
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();

                        var i = 0;
                        api.columns().every(function () {
                            if (i == 2) {
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
                                            //  console.log(y);


                                            return parseFloat(x) + parseFloat(y);
                                        }
                                    }, 0);


                                if (sum != undefined) {
                                    if(i==2) {
                                        subtotal = sum + subtotal;
                                    }
                                    $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }

                            }
                            i++;
                        });


                    },

                    columns: [
                        {data: 'id', name: 'id', visible: false},
                        {data: 'detail', name: 'detail'},
                        {data: 'amount', name: 'amount'},
                        {data: 'currency_name', name: 'currency_name'},
                        {data: 'actions', name: 'actions'}
                    ],
                    columnDefs: [{
                        targets: -1,
                        data: null,
                        render: function (data, type, row) {
                            if (row.emited == '0') {
                                return '' +
                                    '<a href="/invoice_services/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                    '<a href="/invoice_services/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            } else {
                                return '';
                            }
                        }
                    }],
                    initComplete: function (settings, json) {
                        tableActions.initEdit();
                        materials();
                        // tableActions.initAjaxCreate();
                        // tableActions.initDelete('{{ __('general.confirm') }}');
                    }
                });
            });
        }



        function materials(){
            $(function () {
                $('#invoice_materials-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bPaginate: false,
                    ajax: '{{ env('API_PATH') }}invoice_materials/datatables?invoice_id={{ $invoice_id }}',
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
                        {data: 'amount', name: 'amount'},
                        {data: 'currency_name', name: 'currency_name'},
                        {data: 'actions', name: 'actions'}
                    ],
                    columnDefs: [{
                        targets: -1,
                        data: null,
                        render: function (data, type, row) {
                            if (row.emited == '0') {
                                return '' +
                                    '<a href="/invoice_materials/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                    '<a href="/invoice_materials/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            } else {
                                return '';
                            }
                        }
                    }],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();

                        var i = 0;
                        api.columns().every(function () {
                            if (i == 2) {
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
                                            //  console.log(y);


                                            return parseFloat(x) + parseFloat(y);
                                        }
                                    }, 0);


                                if (sum != undefined) {
                                    if(i==2) {
                                        subtotal = sum + subtotal;
                                    }
                                    $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }

                            }
                            i++;
                        });


                    },

                    initComplete: function (settings, json) {
                        tableActions.initEdit();
                        discounts();
                        // tableActions.initAjaxCreate();
                        // tableActions.initDelete('{{ __('general.confirm') }}');
                    }
                });
            });
        }




        function discounts() {
            $(function () {
                $('#invoice_discounts-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bPaginate: false,
                    ajax: '{{ env('API_PATH') }}invoice_discounts/datatables?invoice_id={{ $invoice_id }}',
                    dom: '<"top">rt<"bottom"lp><"clear">',
                    language: {
                        paginate: {
                            previous: "<<",
                            next: ">>"
                        }
                    },
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();

                        var i = 0;
                        api.columns().every(function () {
                            if (i > 1 && i < 4) {
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
                                            //  console.log(y);


                                            return parseFloat(x) + parseFloat(y);
                                        }
                                    }, 0);


                                if (sum != undefined) {

                                    if(i==2){
                                        totaldescuento=totaldescuento+sum;
                                    }
                                    if(i==3){
                                        totaldescuentoporcentaje=totaldescuentoporcentaje+sum;
                                    }
                                    // $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }

                            }



                            if(i==3){
                                if(totaldescuentoporcentaje>0){
                                    totaldescuento = totaldescuento+ ((subtotal*totaldescuentoporcentaje)/100);


                                }

                                subtotal = subtotal -totaldescuento;
                                $(this.footer()).html(totaldescuento.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                            }
                            i++;
                        });




                    },

                    columns: [
                        {data: 'id', name: 'id', visible: false},
                        {data: 'name', name: 'name'},
                        {data: 'amount', name: 'amount'},
                        {data: 'percentage', name: 'percentage'},
                        {data: 'currency_name', name: 'currency_name'},
                        {data: 'actions', name: 'actions'}
                    ],
                    columnDefs: [{
                        targets: -1,
                        data: null,
                        render: function (data, type, row) {
                            if (row.emited == '0') {
                                return '' +
                                    '<a href="/invoice_discounts/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                    '<a href="/invoice_discounts/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            } else {
                                return '';
                            }
                        }
                    }],
                    initComplete: function (settings, json) {
                        tableActions.initEdit();
                        taxes();
                        // tableActions.initAjaxCreate();
                        // tableActions.initDelete('{{ __('general.confirm') }}');
                    }
                });
            });

        }
        function taxes() {
            $(function () {
                $('#invoice_taxes-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bPaginate: false,
                    ajax: '{{ env('API_PATH') }}invoice_taxes/datatables?invoice_id={{ $invoice_id }}',
                    dom: '<"top">rt<"bottom"lp><"clear">',
                    language: {
                        paginate: {
                            previous: "<<",
                            next: ">>"
                        }
                    },
                    columns: [
                        {data: 'id', name: 'id', visible: false},
                        {data: 'name', name: 'name'},
                        {data: 'amount', name: 'amount'},
                        {data: 'percentage', name: 'percentage'},
                        {data: 'currency_name', name: 'currency_name'},
                        {data: 'actions', name: 'actions'}
                    ],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();

                        var i = 0;
                        api.columns().every(function (dato) {
                            console.log(dato);
                            if (i > 1 && i < 4) {
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
                                            //  console.log(y);


                                            return parseFloat(x) + parseFloat(y);
                                        }
                                    }, 0);


                                if (sum != undefined) {

                                    if(i==2){
                                        totaltaxes=totaltaxes+sum;
                                    }
                                    if(i==3){
                                        totaltaxesporcentaje=totaltaxesporcentaje+sum;
                                    }



                                    //$(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }


                            }

                            if(i==3){
                                if(totaltaxesporcentaje>0){
                                    totaltaxes = totaltaxes+ ((subtotal*totaltaxesporcentaje)/100);

                                }

                                subtotal = subtotal + totaltaxes;

                                $(this.footer()).html(totaltaxes.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                            }


                            i++;
                        });


                    },


                    columnDefs: [{
                        targets: -1,
                        data: null,
                        render: function (data, type, row) {
                            if (row.emited == '0') {
                                return '' +
                                    '<a href="/invoice_taxes/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                    '<a href="/invoice_taxes/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            } else {
                                return '';
                            }
                        }
                    }],
                    initComplete: function (settings, json) {
                        tableActions.initEdit();
                        // tableActions.initAjaxCreate();
                        // tableActions.initDelete('{{ __('general.confirm') }}');
                    }
                });
            });
        }


        $(document).ready(function () {
            tableActions.initAjaxCreate();
            tableActions.initDelete('{{ __('general.confirm') }}');

            invoice.init('{{ __('projects.confirm_update') }}');
        });

    </script>
@endsection

@section('section_title', __('invoices.items'))

@section('content')
    @if(!session()->has('project_id'))
        <div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
    @endif

    @if ($countRows->rows == 0 && $invoice->emited==false)
        <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
           id="update_from_project_board" data-invoice_id="{{ $invoice_id }}"
           href="javascript:void(0)">{{ __('invoices.create_from_project_board') }}</a>
    @endif


    @if(session()->has('project_id') && $invoice->emited==0)
        <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" id="confirm"
           onclick="$('#update_from_project_board').css('display', 'none')"
           data-invoice_id="{{ $invoice_id }}"
           href="../../invoices/pdf/{{ $invoice_id }}">{{ __('invoices.confirm') }}</a>

        <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light table-actions delete-btn"
           data-invoice_id="{{ $invoice_id }}"
           href="../../invoices/{{ $invoice_id }}/delete">{{ __('invoices.cancel') }}</a>



        <!--  <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" id="refacture" onclick="$('#update_from_project_board').css('display', 'none')"
       data-invoice_id="{{ $invoice_id }}" href="../../invoices/pdf/{{ $invoice_id }}">{{ __('invoices.refacture') }}</a>-->
    @endif

    @if(session()->has('project_id') && $invoice->emited==1)
        <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" id="confirm"
           data-invoice_id="{{ $invoice_id }}" href="../../invoices/pdf/{{ $invoice_id }}">{{ __('invoices.pdf') }}</a>
    @endif



    <br><br>

    @if(session()->has('project_id'))
        <!--<div class="md-card noprint">
    	<div class="md-card-content">
    		<div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">
                	<div class="dt-buttons btn-group">
                		<a class="md-btn" tabindex="0" id="invoice_pdf" href="#">
                			<span>PDF</span>
                		</a>
                	</div>
                </div>
           	</div>
    	</div>
    </div>-->

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

                        <h4 class="heading_a uk-margin-bottom">{{ __('invoices.resources') }}</h4>
                        <table id="invoice_resources-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('invoices.id') }}</th>
                                <th>{{ __('invoices.user') }}</th>
                                <th>{{ __('invoices.project_role') }}</th>
                                <th>{{ __('invoices.seniority') }}</th>
                                <th>{{ __('invoices.currency') }}</th>
                                <th>{{ __('invoices.workplace') }}</th>
                                <th>{{ __('invoices.load') }}</th>
                                <th>{{ __('invoices.rate') }}</th>
                                <th>{{ __('invoices.hours') }}</th>
                                <th>{{ __('invoices.total') }}</th>
                                <th>{{ __('invoices.type') }}</th>
                                <th>{{ __('invoices.comments') }}</th>
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
                                <th>{{ $currency->name }}</th>
                                <th></th>

                                <th></th>

                                <th></th>
                                <th>{{ __('invoices.hours') }}</th>
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

                        <h4 class="heading_a uk-margin-bottom">{{ __('invoices.expenses') }}</h4>
                        <table id="invoice_expenses-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('invoice.id') }}</th>
                                <th>{{ __('invoices.detail') }}</th>
                                <th>{{ __('invoices.amount') }}</th>
                                <th> {{ __('invoices.currency') }}</th>
                                <th class="noprint">{{ __('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>

                                </th>
                                <th>{{ __('invoices.total') }}</th>
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

                        <h4 class="heading_a uk-margin-bottom">{{ __('invoices.services') }}</h4>
                        <table id="invoice_services-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('invoice.id') }}</th>
                                <th>{{ __('invoices.detail') }}</th>
                                <th>{{ __('invoices.amount') }}</th>
                                <th>{{ __('invoices.currency') }}</th>
                                <th class="noprint">{{ __('general.actions') }}</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>

                                </th>
                                <th>{{ __('invoices.total') }}</th>
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

                        <h4 class="heading_a uk-margin-bottom">{{ __('invoices.materials') }}</h4>
                        <table id="invoice_materials-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('invoice.id') }}</th>
                                <th>{{ __('invoices.detail') }}</th>
                                <th>{{ __('invoices.amount') }}</th>
                                <th>{{ __('invoices.currency') }}</th>
                                <th class="noprint">{{ __('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>

                                </th>
                                <th>{{ __('invoices.total') }}</th>
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

                        <h4 class="heading_a uk-margin-bottom">{{ __('invoices.discounts') }}</h4>
                        <table id="invoice_discounts-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('invoice.id') }}</th>
                                <th>{{ __('invoices.name') }}</th>
                                <th>{{ __('invoices.amount') }}</th>
                                <th>{{ __('invoices.percentage') }}</th>
                                <th>{{ __('invoices.currency') }}</th>
                                <th>{{ __('general.actions') }}</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>

                                </th>
                                <th>{{ __('invoices.total') }}</th>
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

                        <h4 class="heading_a uk-margin-bottom">{{ __('invoices.taxes') }}</h4>
                        <table id="invoice_taxes-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('invoice.id') }}</th>
                                <th>{{ __('invoices.name') }}</th>
                                <th>{{ __('invoices.amount') }}</th>
                                <th>{{ __('invoices.percentage') }}</th>
                                <th>{{ __('invoices.currency') }}</th>
                                <th>{{ __('general.actions') }}</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>

                                </th>
                                <th>{{ __('invoices.total') }}</th>
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
                                <th><h3>{{ __('invoices.total_invoice') }}</h3></th>
                                <th>
                                    <h3>{{number_format($invoice->total,2,',','.')}}</h3>
                                </th>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if(!$invoice->emited)
            <div class="md-fab-wrapper md-fab-in-card" style="position: fixed;">
                <div class="md-fab md-fab-accent md-fab-sheet">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <div class="md-fab-sheet-actions">
                        <a href="{{ url('invoice_resources/'.$invoice_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul">&#xE2C7;</i> {{ __('invoices.new_resource') }}</a>
                        <a href="{{ url('invoice_expenses/'.$invoice_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul"></i> {{ __('invoices.new_expense') }}</a>
                        <a href="{{ url('invoice_services/'.$invoice_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul"></i> {{ __('invoices.new_service') }}</a>
                        <a href="{{ url('invoice_materials/'.$invoice_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul"></i> {{ __('invoices.new_material') }}</a>
                        <a href="{{ url('invoice_discounts/'.$invoice_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul"></i> {{ __('invoices.new_discount') }}</a>
                        <a href="{{ url('invoice_taxes/'.$invoice_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul"></i> {{ __('invoices.new_tax') }}
                        </a>
                    </div>
                </div>
                @endif
            </div>
        @endif
@endsection

{{-- @section('create_div')
	@component('invoice/create', [])

	@endcomponent
@endsection --}}