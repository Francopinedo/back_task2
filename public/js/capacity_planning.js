/**
 * Created by Giuseppe on 21/02/2018.
 */




var CapacityPlanning = (function () {
    'use strict';

    var CapacityPlanning = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            this.events(API_PATH, APP_URL);
            CapacityPlanning.APP_URL = APP_URL;
            CapacityPlanning.API_PATH = API_PATH;


            $("#data-form-edit").on('submit', function (e) {
                e.preventDefault();
                CapacityPlanning.generateReport();
            });


            var totals_availabe_text = 'Total Hs Available';
            var totals_asigned_text = 'Total Hs Asigned';
            var totals_effective_capacity_text = 'Effective Capacity';

            var final_back = 'transparent';

            var reporttotals = totals_availabe_text + ':<label id="totals_availabe_text">' + 0 + '</label>' +
                '<br>&#013;' + totals_asigned_text + ':<label id="totals_asigned_text">' + 0 +
                '</label><br>&#013;' + totals_effective_capacity_text + ':<label  style="background: '
                + final_back + '" id="totals_effective_capacity_text">' + 0 + '</label>';

            // reporttotals= 'testsdfsdfdf';
            $('#capacity_planning-table').append('<caption style="caption-side: bottom">' + reporttotals + '</caption>');

        },

        table: '',

        urlparams: '',
        generateReport: function () {


            if (CapacityPlanning.table != '') {
                CapacityPlanning.table.destroy();
            }
            var tableName = 'capacity_planning';


            var customer = $("#customer").val();
            var project = $("#project").val();
            var period_from = $("#period_from").val();
            var period_to = $("#period_to").val();
            var workgroup = $("#workgroup").val();

            var company = $("#company").val();
            var report_label = $("#report_label").val();


            CapacityPlanning.urlParameters = '?customer=' + customer + '&project=' + project + '&period_from=' + period_from
                + '&period_to=' + period_to + '&company=' + company + '&report_label=' + report_label;


            if (workgroup != 'ALL' && workgroup != '') {

                CapacityPlanning.urlParameter = CapacityPlanning.urlParameter + '&workgroup=' + workgroup;
            }
            var columns = [

                {data: 'id', name: 'id', visible:false},
                {data: 'name', name: 'name'},
                {data: 'working_hours', name: 'working_hours'},
                {data: 'absents_hours', name: 'absents_hours'},
                {data: 'replacements_hours', name: 'replacements_hours'},
                {data: 'holidays_hours', name: 'holidays_hours'},
                {data: 'hours_available', name: 'hours_available'},
                {data: 'hours_asigned', name: 'hours_asigned'},
                {data: 'efective_capacity', name: 'efective_capacity'},
            ];

            var actions = [];
            console.log('generating...', tableName);
            CapacityPlanning.table = CapacityPlanning.Dtables2.init(tableName, columns, actions, CapacityPlanning.urlParameters);

        },

        events: function (API_PATH) {
            $('#customer').on('change', function () {
                $.ajax({
                    url: CapacityPlanning.API_PATH + '/projects',
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
                    url: CapacityPlanning.API_PATH + '/projects/' + $(this).val(),
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {
                        data = data.data;
                        $("#period_from").val(data.start);
                        $("#period_to").val(data.finish);

                        $.ajax({
                            url: CapacityPlanning.API_PATH + '/contracts?project_id=' + $('#project').val(),
                            type: 'GET',
                            data: {project_id: $('#project').val()},
                            dataType: 'json'
                        }).done(
                            function (data2) {
                                data = data2.data;
                                console.log(data[0]);
                                var s = data[0].workinghours_from.split(':');
                                var e = data[0].workinghours_to.split(':');
                                var hours = e[0]-s[0];
                                $("#contract_working_hours").html(hours+' Hours: '+data[0].workinghours_from + " - " + data[0].workinghours_to);

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

            totals_availabe: 0,
            totals_assigned: 0,
            init: function (tableName, columns, actions, urlParameters) {

                CapacityPlanning.Dtables2.totals_availabe =0;
                CapacityPlanning.Dtables2.totals_assigned=0;
                CapacityPlanning.Dtables2.totals_effective_capacity=0;
                urlParameters = urlParameters || '';


                var datatable = $('#' + tableName + '-table').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    processing: true,
                    serverSide: true,
                    ajax: CapacityPlanning.API_PATH + tableName + '/datatables' + urlParameters,
                    dom: '<"top">Brt<"bottom"lp><"clear">',
                    retrieve: true,
                    destroy: true,


                    'createdRow': function (row, data, dataIndex) {



                        CapacityPlanning.Dtables2.totals_availabe = CapacityPlanning.Dtables2.totals_availabe + parseInt(data.hours_available);
                        CapacityPlanning.Dtables2.totals_assigned = CapacityPlanning.Dtables2.totals_assigned + parseInt(data.hours_asigned);

                        var total = parseInt(CapacityPlanning.Dtables2.totals_availabe) - parseInt(CapacityPlanning.Dtables2.totals_assigned);
                        console.log(total);
                        CapacityPlanning.Dtables2.totals_effective_capacity = total;


                        if (isNaN(CapacityPlanning.Dtables2.totals_effective_capacity))
                            CapacityPlanning.Dtables2.totals_effective_capacity = 0;
                        if (isNaN(CapacityPlanning.Dtables2.totals_availabe))
                            CapacityPlanning.Dtables2.totals_availabe = 0;
                        if (isNaN(CapacityPlanning.Dtables2.totals_availabe))
                            CapacityPlanning.Dtables2.totals_availabe = 0;


                        if (CapacityPlanning.Dtables2.totals_effective_capacity < 0)
                            $("#totals_effective_capacity_text").css('background', 'red');
                        if (CapacityPlanning.Dtables2.totals_effective_capacity == 0)
                            $("#totals_effective_capacity_text").css('background', 'yellow');
                        if (CapacityPlanning.Dtables2.totals_effective_capacity > 0)
                            $("#totals_effective_capacity_text").css('background', 'green');

                        $("#totals_availabe_text").text(CapacityPlanning.Dtables2.totals_availabe);
                        $("#totals_asigned_text").text(CapacityPlanning.Dtables2.totals_assigned);
                        $("#totals_effective_capacity_text").text(CapacityPlanning.Dtables2.totals_effective_capacity);

                    },
                    language: {
                        paginate: {
                            previous: "<<",
                            next: ">>"
                        }
                    },
                    buttons: [
                        {
                            text: 'EXCEL',
                            action: function (e, dt, node, config) {

                                window.location.href = CapacityPlanning.APP_URL + '/capacity_planning/excel' + CapacityPlanning.urlParameters;

                            }
                        },

                        {
                            text: 'PDF',
                            action: function (e, dt, node, config) {

                                window.location.href = CapacityPlanning.APP_URL + '/capacity_planning/pdf' + CapacityPlanning.urlParameters;

                            }
                        },


                        /* {
                         extend: 'pdfHtml5',
                         messageTop:'holaaa',
                         filename: $("#report_label").val(),
                         title: $("#report_label").val(),
                         footer: true
                         },*/
                    ],
                    columns: columns,
                    columnDefs: [

                        {

                            targets: 8,
                            "width": "5%",
                            "createdCell": function (td, cellData, rowData, row, col) {

                                if (parseInt(cellData) < 0) {
                                    $(td).css('background-color', 'red')
                                }
                                if (parseInt(cellData) == 0) {
                                    $(td).css('background-color', 'yellow')
                                }
                                if (parseInt(cellData) > 0) {
                                    $(td).css('background-color', 'green')
                                }
                            }

                        }],

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
    return CapacityPlanning;
}());
