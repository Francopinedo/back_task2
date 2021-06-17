@extends('layouts.app')

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

  <script>
    $(function() {
      $('#wiki-table').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        processing: true,
        serverSide: true,
        ajax:  '{{ env('API_PATH') }}wiki/datatables?company_id={{ $company->id }}',
        serverSide: true,
        searching: true,
        "searching": true,
        dom: '<"top" "<"pull-right"f>>Brt<"bottom"lp><"clear">',
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
          { extend: 'pdfHtml5', orientation:'landscape',exportOptions: { columns: ':visible:not(:last-child)' } },
        ],
        columns: [
          { data: 'id', name: 'id', visible: false },
          { data: 'customer_name', name: 'customer_name' },
          { data: 'project_name', name: 'project_name' },
          { data: 'process_group_code', name: 'process_group_code' },
          { data: 'knowledge_code', name: 'knowledge_code' },
          { data: 'swot_code', name: 'swot_code' },
          { data: 'explanation', name: 'explanation', render: function(data) {
            return data.substr( 0, 50 )+'...';
          }},
          { data: 'action_taken', name: 'action_taken', render: function(data) {
            return data.substr(0, 50)+'...';
          }},
          { data: 'additionals_comments', name: 'additionals_comments', render: function(data) {
            return data.substr(0, 50)+'...';
          }},
          { data: 'attached_file', name: 'attached_file', 
            render: function ( data, type, row, meta ) {
              if(row['attached_file']!= "")
                return '<img style="width:50px;" src="{{URL::to('/') .'/assets/img/wiki/'}}'+ row['id'] +'/'+ row['attached_file'] + '" />';
              else
                return '<span>No Imagen</span>';
              }
          },
          { data: 'actions', name: 'actions'}
        ],
        columnDefs: [{
          targets: -1,
          data: null,
          render: function (data, type, row) {
           if(row.user_id == {{ Auth::user()->id }})
              return '' +
              '<a title="{{__('wiki_tooltip.show')}}" href="/wiki/'+ row.id + '" class="table-actions info-btn" data-uk-modal='+ "{target:'#modal_info'}" +' ><i class="fa fa-list" aria-hidden="true"></i></a>'+
              '<a title="{{__('general.edit')}}" href="/wiki/' + row.id + '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
              '<a title="{{__('general.delete')}}" href="/wiki/' + row.id + '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            else
              return '<a title="{{__('wiki_tooltip.show')}}" href="/wiki/'+ row.id + '" class="table-actions info-btn" data-uk-modal='+ "{target:'#modal_info'}" +' ><i class="fa fa-list" aria-hidden="true"></i></a>';
          }
        }],
        initComplete: function(settings, json) {
          tableActions.initEdit();
          tableActions.initDelete('{{ __('general.confirm') }}');
          tableActions.initInfo();

          //Insertar buscador select de la columna Process Group
          this.api().columns([3]).every( function () {
            var process_group = ["Initiating", "Planning", "Executing", "Monitoring y Control", "Closing"];
            var column = this;
            var select = $('<select class="search"><option style="display: none" disabled selected>Process Group</option><option class="selectize-dropdown" value=""> All </option></select>')
              .appendTo( '#wiki-table_filter' )
              .on( 'change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );
                column
                  .search( val ? '^'+val+'$' : '', true, false )
                  .draw();
              });
            // column.data().unique().sort().each( function ( d, j ) {
            //   select.append( '<option class="selectize-dropdown" value="'+d+'">'+d+'</option>' )
            // });
            for (var i = 0; i < process_group.length; i++) {
              select.append( '<option class="selectize-dropdown" value="'+process_group[i]+'">'+process_group[i]+'</option>' )
              
            }
          });
           //Insertar buscador select de la columna Knowledge Area
          this.api().columns([4]).every( function () {
            var knowledge_area = ["Integration Management", "Scope Management", "Time Management", "Cost Management", "Quality Management", "Team Management", "Communication Management", "Risk Management", "Stakeholder Management", "Procurement Management"];
            var column = this;
            var select = $('<select class="search"><option style="display: none" disabled selected>Knowledge Area</option><option class="selectize-dropdown" value=""> All </option></select>')
              .appendTo( '#wiki-table_filter' )
              .on( 'change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );
                column
                  .search( val ? '^'+val+'$' : '', true, false )
                  .draw();
              });
            // column.data().unique().sort().each( function ( d, j ) {
            //   select.append( '<option class="selectize-dropdown" value="'+d+'">'+d+'</option>' )
            // });
            for (var i = 0; i < knowledge_area.length; i++) {
              select.append( '<option class="selectize-dropdown" value="'+knowledge_area[i]+'">'+knowledge_area[i]+'</option>' )
              
            }
          });
          //Insertar buscador select de la columna Swot
          this.api().columns([5]).every( function () {
            var swot = ["Strenghts", "Weaknesses", "Opportunities", "Threats"];
            var column = this;
            var select = $('<select class="search"><option style="display: none" disabled selected>Swot</option><option class="selectize-dropdown" value=""> All </option></select>')
              .appendTo( '#wiki-table_filter' )
              .on( 'change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );
                column
                  .search( val ? '^'+val+'$' : '', true, false )
                  .draw();
              });
            // column.data().unique().sort().each( function ( d, j ) {
            //   select.append( '<option class="selectize-dropdown" value="'+d+'">'+d+'</option>' )
            // });
            for (var i = 0; i < swot.length; i++) {
              select.append( '<option class="selectize-dropdown" value="'+swot[i]+'">'+swot[i]+'</option>' )
              
            }
          });
        }
      });
    });

    $(document).ready(function() {
      $("#datatables-length").append($(".dataTables_length"));
      $("#datatables-pagination").append($(".simple_numbers"));
    });
  </script>

@endsection

@section('section_title', __('wiki.wiki'))

<style>

  .pull-right {
    width: 60%;
  }

  div#wiki-table_filter {
    display: flex !important;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
  }

  #wiki-table_filter .md-input-wrapper {
    width: 25% !important;
  }

  #wiki-table_filter select {
    padding: 6px 4px;
    margin-left: 10px;
    margin-top: 5px;
    cursor: pointer;
    text-shadow: none;
    width: 25%;
    border-bottom: 1px solid rgb(130, 130, 130);
  }
  select.search {
    background-image: url('assets/img/arrow-down.png');
    background-repeat: no-repeat !important;
    background-position: right !important;
  }

</style>

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

        	<table id="wiki-table" class="uk-table" cellspacing="0" width="100%">
      	    <thead>
    	        <tr>
    	        	<th title="{{__('wiki_tooltip.id')}}">{{ __('wiki.id') }}</th>
    	        	<th title="{{__('wiki_tooltip.customer_code')}}">{{ __('wiki.customer_code') }}</th>
    	        	<th title="{{__('wiki_tooltip.project_code')}}">{{ __('wiki.project_code') }}</th>
    	        	<th title="{{__('wiki_tooltip.process_group')}}">{{ __('wiki.process_group_code') }}</th>
    	        	<th title="{{__('wiki_tooltip.knowledge_area')}}">{{ __('wiki.knowledge_code') }}</th>
    	        	<th title="{{__('wiki_tooltip.swot')}}">{{ __('wiki.swot_code') }}</th>
    	        	<th title="{{__('wiki_tooltip.explanation')}}">{{ __('wiki.explanation') }}</th>
    	        	<th title="{{__('wiki_tooltip.action_taken')}}">{{ __('wiki.action_taken') }}</th>
    	        	<th title="{{__('wiki_tooltip.additionals_comments')}}">{{ __('wiki.additionals_comments') }}</th>
    	        	<th title="{{__('wiki_tooltip.attached_file')}}">{{ __('wiki.attached_file') }}</th>
    	        	<th>{{ __('general.actions') }}</th>
    	        </tr>
      	    </thead>
        	</table>
        	<div class="uk-grid datatables-bottom">
        		<div class="uk-width-medium-1-3" id="datatables-length"></div>
        		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
        		<div class="uk-width-medium-1-3">
        			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('contacts.add_new') }}</a>
        		</div>
        	</div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('create_div')
	@component('wiki/create', ['wiki'=>$wiki, 'projects'=>$projects, 'customers'=>$customers, 'company'=>$company])
	@endcomponent
@endsection