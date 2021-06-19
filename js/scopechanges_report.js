/**
 * Created by Giuseppe on 21/02/2018.
 */




var ScopeChangesReport = (function () {
    'use strict';

    var ScopeChangesReport = {
        /**
         * init
         */
        APP_URL: '',
 	APP_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            ScopeChangesReport.APP_URL = APP_URL;
            ScopeChangesReport.API_PATH = API_PATH;


            $("#data-form-edit").on('submit', function (e) {
                e.preventDefault();
                ScopeChangesReport.generateReport();
            });

        },

        table: '',

        urlparams: '',
        generateReport: function () {


            if (ScopeChangesReport.table != '') {
                ScopeChangesReport.table.destroy();
            }
            var tableName = 'tickets';


            var customer = $("#customer").val();
            var project = $("#project").val();
            var period_from = $("#period_from").val();
            var period_to = $("#period_to").val();
	     

            ScopeChangesReport.urlParameters = '?project_id=' + project + '&type=5&due_date_to=' + period_from
                + '&due_date_to=' + period_to;


          
            var columns = [
   		
                   {data: 'id', name: 'id', visible: false},
                    {data: 'ticket_id', name: 'ticket_id'},
                    {data: 'description', name: 'description'},
                    {data: 'type', name: 'type'},
                    {data: 'assignee_name', name: 'assignee_name'},
                    {data: 'status', name: 'status'},
                    {data: 'group', name: 'group'},
                    {data: 'sprint', name: 'sprint'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'requester_name', name: 'requester_name'},
                    {data: 'priority', name: 'priority'},
                    {data: 'severity', name: 'severity'},
                    {data: 'impact', name: 'impact'},
                    {data: 'probability', name: 'probability'},

                    {data: 'owner_name', name: 'owner_name'},
                    {data: 'estimated_hours', name: 'estimated_hours'},
                    {data: 'burned_hours', name: 'burned_hours'},
               ];

            var actions = [];
            console.log('generating...', tableName);
            ScopeChangesReport.table = ScopeChangesReport.Dtables2.init(tableName, columns, actions, ScopeChangesReport.urlParameters);

        },

        events: function (API_PATH) {
            $('#customer').on('change', function () {
                $.ajax({
                    url: ScopeChangesReport.API_PATH + '/projects',
                    type: 'GET',
                    data: {customer_id: $(this).val()},
                    dataType: 'json'
                }).done(
                    function (data) {

                        $('#project').selectize()[0].selectize.destroy();

                        var html = '<option value="">Projects</option>';
                        $.each(data.data, function (i, value) {
                          //  console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });
                        $('#project').html(html);
                        $('#project').selectize();
                    }
                );
            });

            $('#project').on('change', function () {
                $.ajax({
                    url: ScopeChangesReport.API_PATH + '/projects/' + $(this).val(),
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {
                        data = data.data;
                        $("#period_from").val(data.start);
                        $("#period_to").val(data.finish);

                        $.ajax({
                            url: ScopeChangesReport.API_PATH + '/contracts?project_id=' + $('#project').val(),
                            type: 'GET',
                            data: {project_id: $('#project').val()},
                            dataType: 'json'
                        }).done(
                            function (data2) {
  
                            }
                        );


                    }
                );
            });
        },


        Dtables2: {


            /*============================
             =            INIT            =
             ============================*/

             init: function (tableName, columns, actions, urlParameters) {

             
                urlParameters = urlParameters || '';


                var datatable = $('#' + tableName + '-table').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    processing: true,
                    serverSide: true,
                    ajax: ScopeChangesReport.API_PATH + tableName + '/datatables' + urlParameters,
                    dom: '<"top">Brt<"bottom"lp><"clear">',
                    retrieve: true,
                    destroy: true,
			
                    language: {
                        paginate: {
                            previous: "<<",
                            next: ">>"
                        }
                    },
                  
                    buttons: [
                        { extend: 'copyHtml5', exportOptions: { columns: ':visible:not(:last-child)' } },
                        { extend: 'excelHtml5', exportOptions: { columns: ':visible:not(:last-child)' } },
                        { extend: 'csvHtml5', exportOptions: { columns: ':visible:not(:last-child)' } },
                        { extend: 'pdfHtml5',orientation:'landscape', exportOptions: { columns: ':visible:not(:last-child)' } },
                    ],
                    columns: columns,
                    columnDefs: [
                        {
                            targets: 3,
                            data: null,
                            render: function (data, type, row) {

                           
                            if (data == 5)
                                return 'Risk';
                            }
                        },
                        {
                            targets: 5,
                            data: null,
                            render: function (data, type, row) {
                                
                                if (data == 1)
                                    return 'To Do';
                                if (data == 2)
                                    return 'Waiting';
                                if (data == 3)
                                    return 'In Progress';
                                if (data == 4)
                                    return 'Cancelled';
                                if (data == 5)
                                    return 'Rescheduled';
                                if (data == 6)
                                    return 'Resolved';
                            }
                        },
                        {
                            targets: 6,
                            data: null,
                            render: function (data, type, row) {

                                if (data == 1)
                                    return 'Sprint';
                                if (data == 2)
                                    return 'Backlog';

                            }
                        },
                        {
                            targets: 10,
                            data: null,
                            render: function (data, type, row) {

                                if (data == 1)
                                    return 'Low';
                                if (data == 2)
                                    return 'Medium';
                                if (data == 3)
                                    return 'High';
                                if (data == 4)
                                    return 'High';

                            }
                        },
                        {
                            targets: 11,
                            data: null,
                            render: function (data, type, row) {
                                if (data == 0)
                                    return 'Default';
                                if (data == 1)
                                    return 'Blocker';
                                if (data == 2)
                                    return 'Major';
                                if (data == 3)
                                    return 'Medium';
                                if (data == 4)
                                    return 'Minor';
                                if (data == 5)
                                    return 'Trivial';

                            }
                        },
                        {
                            targets: 12,
                            data: null,
                            render: function (data, type, row) {
                                if (data == 0)
                                    return 'Default';
                                if (data == 1)
                                    return 'High';
                                if (data == 2)
                                    return 'Medium';
                                if (data == 3)
                                    return 'Low';


                            }
                        }, {
                            targets: 13,
                            data: null,
                            render: function (data, type, row) {
                                if (data == 0)
                                    return 'Default';
                                  if (data == 1)
                                    return 'High';
                                if (data == 2)
                                    return 'Medium';
                                if (data == 3)
                                    return 'Low';



                            }
                        }
                    ],

                });

                console.log(datatable);
                $(document).ready(function () {
                    //$("#datatables-length").append($(".dataTables_length"));
                    //$("#datatables-pagination").append($(".simple_numbers"));
                });

                return datatable;
            }
            /*=====  End of INIT  ======*/
        }


    }
    return ScopeChangesReport;
}());
