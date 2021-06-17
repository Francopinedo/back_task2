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

<script>
	var Dtables = (function() {
		'use strict';

		var Dtables = {
			/*============================
			=            INIT            =
			============================*/
			init: function(tableName, columns, actions, urlParameters){
				urlParameters = urlParameters || '';

			    var datatable = $('#' + tableName + '-table').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
			        processing: true,
			        serverSide: true,
			        ajax:  '{{ env('API_PATH') }}' + tableName + '/datatables' + urlParameters,
			        dom: '<"top">Brt<"bottom"lp><"clear">',
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
				        { extend: 'pdfHtml5',orientation:'landscape',exportOptions: { columns: ':visible:not(:last-child)' } },
			        ],
			        columns: columns,
			        columnDefs: [ {
			            targets: -1,
			            data: null,
			            render: function (data, type, row) {
			            	var result = '';

			            	$.each(actions, function (index, value) {
							  	result += value.pre + row.id + value.post;
							});

		                    return result;
		                }
			        } ],
			        initComplete: function(settings, json) {
					    tableActions.initEdit();
					    tableActions.initDelete('{{ __('general.confirm') }}');
					    tableActions.initInfo();
					}
			    });

			    $(document).ready(function() {
					$("#datatables-length").append($(".dataTables_length"));
					$("#datatables-pagination").append($(".simple_numbers"));
				});
			}
			/*=====  End of INIT  ======*/
		};

		return Dtables;
	}());

	$(document).ready(function() {
		$("#datatables-length").append($(".dataTables_length"));
		$("#datatables-pagination").append($(".simple_numbers"));
	});

</script>