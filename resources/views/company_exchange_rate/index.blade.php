@extends('layouts.app')

@section('scripts')
	<script src="{{ asset('js/exchange_rates.js') }}"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			exchangeRates.init();
		});

	</script>

	<!-- datatables -->
	<script src="/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<!-- datatables buttons-->
	<script src="/bower_components/datatables-buttons/js/dataTables.buttons.js"></script>
	<script src="/assets/js/custom/datatables/buttons.uikit.js"></script>
	<script src="/bower_components/jszip/dist/jszip.min.js"></script>
	<script src="/bower_components/pdfmake/build/pdfmake.min.js"></script>
	<script src="/bower_components/pdfmake/build/vfs_fonts.js"></script>
	<script src="/bower_components/datatables-buttons/js/buttons.html5.js"></script>
	<script src="/bower_components/datatables-buttons/js/buttons.print.js"></script>

	<!-- datatables custom integration -->
    <script src="/assets/js/custom/datatables/datatables.uikit.min.js"></script>

    <script>
	$(function() {
	    $('#exchange_rates-table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax:  '{{ env('API_PATH') }}exchange_rates/datatables',
	        dom: '<"top">rt<"bottom"lp><"clear">',
	        language: {
			    paginate: {
			      	previous: "<<",
			      	next: ">>"
			    }
			},
	        columns: [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'value', name: 'value' },
	            { data: 'actions', name: 'actions'}
	        ],
	        columnDefs: [ {
	            targets: -1,
	            data: null,
	            render: function (data, type, row) {
                    return '' +
	            		'<a href="/companies/' + {{ $company->id }} + '/exchange_rates/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
	            		'<a href="/companies/' + {{ $company->id }} + '/exchange_rates/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
	        } ],
	        initComplete: function(settings, json) {
			    tableActions.initEdit();
			    tableActions.initDelete('{{ __('general.confirm') }}');
			}
	    });
	});

	$(document).ready(function() {
		$("#datatables-length").append($(".dataTables_length"));
		$("#datatables-pagination").append($(".simple_numbers"));
	});

	</script>
@endsection

@section('section_title', __('exchange_rates.exchange_rates').' ('.$company->name.')')

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

                	<table id="exchange_rates-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th>{{ __('exchange_rates.id') }}</th>
                	        	<th>{{ __('exchange_rates.currency') }}</th>
                	        	<th>{{ __('exchange_rates.value') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('exchange_rates.add_new') }}</a>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('company_exchange_rate/create', ['currencies' => $currencies, 'company_id' => $company->id])

	@endcomponent
@endsection