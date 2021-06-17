$(document).ready(function () {

    tableActions.initAdd();
    favorite.init();
    layout.init();


});


function DtablesUtil(tableName, columns, actions, urlParameters, extra_buttons) {
    urlParameters = urlParameters || '';


    confirm = 'Are you sure?';

    //API_PATH = 'http://api.taskcontrol.co/';
    API_PATH = $("#API_PATH").val();

    var buttons = new Array();
    buttons = [
        {extend: 'copyHtml5', exportOptions: {columns: ':visible:not(:last-child)'}},
        {extend: 'excelHtml5', exportOptions: {columns: ':visible:not(:last-child)'}},
        {extend: 'csvHtml5', exportOptions: {columns: ':visible:not(:last-child)'}},
        {extend: 'pdfHtml5', orientation:'landscape',exportOptions: {columns: ':visible:not(:last-child)'}}

    ];


    if (extra_buttons != undefined) {
        for (var i = 0; i < extra_buttons.length; i++) {

            buttons.push( extra_buttons[i])
        }
    }

    var datatable = $('#' + tableName + '-table').DataTable({


        ajax: API_PATH + tableName + '/datatables' + urlParameters,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        processing: true,
        serverSide: true,
        searching: true,
        "searching": true,
        dom: '<"top" "<"pull-right"f >>Brt<"bottom"lp><"clear">',
        language: {
            paginate: {
                previous: "<<",
                next: ">>"
            }
        },
        buttons: buttons,
        columns: columns,
        columnDefs: [{
            targets: -1,
            data: null,
            orderable: false,
            render: function (data, type, row) {
                var result = '';

                $.each(actions, function (index, value) {

                    if (value != '') {
                        result += value.pre + row.id + value.post;
                    }

                });

                return result;
            }
        }],
        drawCallback: function (settings) {
            tableActions.initEdit();
            tableActions.initDelete(confirm);
            tableActions.initInfo();
        },
        initComplete: function (settings, json) {



            /*  this.api().columns().every( function () {
             var column = this;
             //  console.log(column.data());
             var select = $('<select class="form-control"><option value=""></option></select>')
             .appendTo( $(column.header()) )
             .on( 'change', function () {
             var val = $.fn.dataTable.util.escapeRegex(
             $(this).val()
             );

             column
             .search( val ? '^'+val+'$' : '', true, false )
             .draw();
             } );

             column.data().unique().sort().each( function ( d, j ) {
             select.append( '<option value="'+d+'">'+d+'</option>' )
             } );
             } );*/
        }
    });

    $(document).ready(function () {
        $("#datatables-length").append($(".dataTables_length"));
        $("#datatables-pagination").append($(".simple_numbers"));
    });
}