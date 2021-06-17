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

	 <!-- <script   src="{{ asset('bower_components/uikit/dist/js/uikit.js') }}"></script>
	<script  src="{{ asset('bower_components/uikit/dist/js/uikit-icons.js') }}"></script>
   <link rel="stylesheet" href="{{ asset('bower_components/uikit/dist/css/uikit.css') }}" media="all">-->

    <script>


        var subtotal = 0;
        var totaltaxes = 0;
        var totaltaxesporcentaje = 0;
        var totaldescuento = 0;
        var totaldescuentoporcentaje = 0;
        var total_resources_dt = 0;
        var total_expenses_dt = 0;
        var total_materials_dt = 0;
        var total_services_dt = 0;

        $(function () {
            $('#quotation_resources-table').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                ajax: '{{ env('API_PATH') }}quotation_resources/datatables?quotation_id={{ $quotation_id }}',
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
                                '<a title{{__('general.edit')}} href="/quotation_resources/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                '<a title{{__('general.delete')}} href="/quotation_resources/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                                    total_resources_dt=sum;
                                      totalquotationcalc();
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
                $('#quotation_expenses-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bPaginate: false,
                    ajax: '{{ env('API_PATH') }}quotation_expenses/datatables?quotation_id={{ $quotation_id }}',
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
                                        total_expenses_dt=sum;
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
                                    '<a title="{{__('general.edit')}}" href="/quotation_expenses/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                    '<a title="{{__('general.delete')}}" href="/quotation_expenses/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                $('#quotation_services-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bPaginate: false,
                    ajax: '{{ env('API_PATH') }}quotation_services/datatables?quotation_id={{ $quotation_id }}',
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
                                         total_services_dt=sum;
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
                                    '<a title={{__('general.edit')}} href="/quotation_services/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                    '<a title={{__('general.delete')}} href="/quotation_services/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                $('#quotation_materials-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bPaginate: false,
                    ajax: '{{ env('API_PATH') }}quotation_materials/datatables?quotation_id={{ $quotation_id }}',
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
                                    '<a title="{{__('general.edit')}}" href="/quotation_materials/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                                    '<a title="{{__('general.delete')}}" href="/quotation_materials/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                                        total_materials_dt=sum;
                                    }
                                    $(this.footer()).html(sum.toLocaleString('de-DE', {maximumFractionDigits: 2}));
                                }

                            }
                            i++;
                        });


                    },

                    initComplete: function (settings, json) {
                        tableActions.initEdit();
                      //  discounts();
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

<script>
      $(".resources_a").on("click", function()
    {
if( document.getElementById("resources_select").value == "1"){
      document.getElementById("resources_select").value = "0";
}else{
document.getElementById("resources_select").value = "1";
}
totalquotationcalc();
    });
  $(".expenses_a").on("click", function()
    {
if( document.getElementById("expenses_select").value == "1")
{      document.getElementById("expenses_select").value = "0";
}else{
document.getElementById("expenses_select").value = "1";
}
totalquotationcalc();
    });
    $(".services_a").on("click", function()
    {
if( document.getElementById("services_select").value == "1")
{      document.getElementById("services_select").value = "0";
}else{
document.getElementById("services_select").value = "1";
}
totalquotationcalc();
    });

 $(".materials_a").on("click", function()
    {
    if( document.getElementById("materials_select").value == "1")
  {         document.getElementById("materials_select").value = "0";
   } else{
    document.getElementById("materials_select").value = "1";
}

totalquotationcalc();
    });

function  totalquotationcalc()
{
materials_select=document.getElementById("materials_select").value;
services_select=document.getElementById("services_select").value;
expenses_select=document.getElementById("expenses_select").value;
resources_select=document.getElementById("resources_select").value;

var totalquotationcalc = 0;

ss=services_select=="1"? total_services_dt:0;
ms=materials_select=="1"?total_materials_dt:0;
es=expenses_select=="1"?total_expenses_dt:0;
rs=resources_select=="1"?total_resources_dt:0;
totalquotationcalc= ss+ms+es+rs;

document.getElementById("total_quotation").innerText=totalquotationcalc;
}

$("#confirm").on("click", function()
    {

materials_select=document.getElementById("materials_select").value;
services_select=document.getElementById("services_select").value;
expenses_select=document.getElementById("expenses_select").value;
resources_select=document.getElementById("resources_select").value;


   window.open("../../quotation/pdf/{{ $quotation_id }}/"+resources_select+"/"+expenses_select+"/"+services_select+"/"+materials_select );


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

    @if ($countRows->rows == 0 && $quotation->emited==false)
      <!--  <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
           id="update_from_project_board" data-quotation_id="{{ $quotation_id }}"
           href="javascript:void(0)">{{ __('invoices.create_from_project_board') }}</a>--->
    @endif


    @if(session()->has('project_id') && $quotation->emited==0)
        <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" id="confirm"
           onclick="$('#update_from_project_board').css('display', 'none')"
           data-quotation_id="{{ $quotation_id }}"
           >{{ __('invoices.confirm') }}</a>

        <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light table-actions delete-btn"
           data-quotation_id="{{ $quotation_id }}"
           href="../../quotation/{{ $quotation_id }}/delete">{{ __('invoices.cancel') }}</a>



        <!--  <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" id="refacture" onclick="$('#update_from_project_board').css('display', 'none')"
       data-quotation_id="{{ $quotation_id }}" href="../../invoices/pdf/{{ $quotation_id }}">{{ __('invoices.refacture') }}</a>-->
    @endif

    @if(session()->has('project_id') && $quotation->emited==1)
        <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" id="confirm"
           data-quotation_id="{{ $quotation_id }}" >{{ __('invoices.pdf') }}</a>
    @endif



    <br><br>

    @if(session()->has('project_id'))
        <!--<div class="md-card noprint">
    	<div class="md-card-content">
    		<div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">
                	<div class="dt-buttons btn-group">
                		<a class="md-btn" tabindex="0" id="quotation_pdf" href="#">
                			<span>PDF</span>
                		</a>
                	</div>
                </div>
           	</div>
    	</div>
    </div>-->
   <input type="hidden" name="resources_select" id="resources_select" value="1">
   <input type="hidden" name="expenses_select" id="expenses_select" value="0">
   <input type="hidden" name="services_select" id="services_select" value="0">
   <input type="hidden" name="materials_select" id="materials_select" value="0">

<ul class="panel-group" id="accordion">
    <li>
        <a id="resources_a" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
            <div class="uk-accordion-title resources_a">
            <h4 class="heading_a uk-margin-bottom">{{ __('invoices.resources') }}</h4>
                </div>
        </a>
        <div id="collapse1" class="md-card panel-collapse collapse in">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">

                        @if(session()->has('message'))
                            <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                                <a href="#" class="uk-alert-close uk-close"></a>
                                {{ session('message') }}
                            </div>
                        @endif

                        <!--<h4 class="heading_a uk-margin-bottom">{{ __('invoices.resources') }}</h4>-->
                        <table id="quotation_resources-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th title="{{__('quotations_tooltip.id')}}">{{ __('quotations.id') }}</th>
                                <th title="{{__('quotations_tooltip.user')}}">{{ __('quotations.user') }}</th>
                                <th title="{{__('quotations_tooltip.project_role')}}">{{ __('quotations.project_role') }}</th>
                                <th title="{{__('quotations_tooltip.seniority')}}">{{ __('quotations.seniority') }}</th>
                                <th title="{{__('quotations_tooltip.currency')}}">{{ __('quotations.currency') }}</th>
                                <th title="{{__('quotations_tooltip.workplace')}}">{{ __('quotations.workplace') }}</th>
                                <th title="{{__('quotations_tooltip.load')}}">{{ __('quotations.load') }}</th>
                                <th title="{{__('quotations_tooltip.rate')}}">{{ __('quotations.rate') }}</th>
                                <th title="{{__('quotations_tooltip.hours')}}">{{ __('quotations.hours') }}</th>
                                <th title="{{__('quotations_tooltip.total')}}">{{ __('quotations.total') }}</th>
                                <th title="{{__('quotations_tooltip.type')}}">{{ __('quotations.type') }}</th>
                                <th title="{{__('quotations_tooltip.comments')}}">{{ __('quotations.comments') }}</th>
                                <th title="{{__('general.actions')}}" class="noprint">{{ __('general.actions') }}</th>
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
</li>
<li>


        <a id="expenses_a" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
            <div class="uk-accordion-title expenses_a">
          <h4 class="heading_a uk-margin-bottom">{{ __('invoices.expenses') }}</h4>
                </div>
        </a>
          <div id="collapse2" class="md-card panel-collapse collapse ">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">

                        <!--<h4 class="heading_a uk-margin-bottom">{{ __('invoices.expenses') }}</h4>-->
                        <table id="quotation_expenses-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th title="{{__('quotations_tooltip.id')}}">{{ __('quotations.id') }}</th>
                                <th title="{{__('quotations_tooltip.detail')}}">{{ __('quotations.detail') }}</th>
                                <th title="{{__('quotations_tooltip.amount')}}">{{ __('quotations.amount') }}</th>
                                <th title="{{__('quotations_tooltip.currency')}}"> {{ __('quotations.currency') }}</th>
                                <th title="{{__('general.actions')}}" class="noprint">{{ __('general.actions') }}</th>
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
</li>
<li>
     <a id="services_a" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
            <div class="uk-accordion-title services_a">
        <h4 class="heading_a uk-margin-bottom">{{ __('invoices.services') }}</h4>
         </div>
        </a>
          <div id="collapse3" class="md-card panel-collapse collapse ">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">

                        <!--<h4 class="heading_a uk-margin-bottom">{{ __('invoices.services') }}</h4>-->
                        <table id="quotation_services-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th title="{{__('quotations_tooltip.id')}}">{{ __('quotations.id') }}</th>
                                <th title="{{__('quotations_tooltip.detail')}}">{{ __('quotations.detail') }}</th>
                                <th title="{{__('quotations_tooltip.amount')}}">{{ __('quotations.amount') }}</th>
                                <th title="{{__('quotations_tooltip.currency')}}">{{ __('quotations.currency') }}</th>
                                <th title="{{__('general.actions')}}" class="noprint">{{ __('general.actions') }}</th>
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
</li>
<li>



     <a id="materials_a" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
            <div class="uk-accordion-title materials_a">
<h4 class="heading_a uk-margin-bottom">{{ __('invoices.materials') }}</h4>
        </div>
        </a>
          <div id="collapse4" class="md-card panel-collapse collapse ">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">

                        <!--<h4 class="heading_a uk-margin-bottom">{{ __('invoices.materials') }}</h4>-->
                        <table id="quotation_materials-table" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th title="{{__('quotations_tooltip.id')}}">{{ __('quotations.id') }}</th>
                                <th title="{{__('quotations_tooltip.detail')}}">{{ __('quotations.detail') }}</th>
                                <th title="{{__('quotations_tooltip.amount')}}">{{ __('quotations.amount') }}</th>
                                <th title="{{__('quotations_tooltip.currency')}}">{{ __('quotations.currency') }}</th>
                                <th title="{{__('general.actions')}}" class="noprint">{{ __('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th></th>
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

</li>
<li>

     <a id="total_quotation_a" data-toggle="collapse" data-parent="#accordion" href="#collapse5">
        </a>
          <div id="collapse5" class="md-card panel-collapse collapse in">
            <div class="md-card-content">

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">

                        <table id="" class="uk-table" cellspacing="0" width="100%">
                            <tbody>
                            <tr>
                                <th><!--<h3>{{ __('quotations.total_quotation') }}</h3>--></th>
                                <th>
                                    <h3 id="total_quotation">{{ number_format($quotation->total,2,',','.')}}</h3>
                                </th>
                                 <th>
                                    <h3 id="">{{ $currency->name}}</h3>
                                </th>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
</ul>
        @if(!$quotation->emited)
            <div class="md-fab-wrapper md-fab-in-card" style="position: fixed;">
                <div class="md-fab md-fab-accent md-fab-sheet">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <div class="md-fab-sheet-actions">
                        <a href="{{ url('quotation_resources/'.$quotation_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul">&#xE2C7;</i> {{ __('invoices.new_resource') }}</a>
                        <a href="{{ url('quotation_expenses/'.$quotation_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul"></i> {{ __('invoices.new_expense') }}</a>
                        <a href="{{ url('quotation_services/'.$quotation_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul"></i> {{ __('invoices.new_service') }}</a>
                        <a href="{{ url('quotation_materials/'.$quotation_id.'/create') }}"
                           class="md-color-white ajax_create-btn"><i
                                    class="fa fa-list-ul"></i> {{ __('invoices.new_material') }}</a>

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
