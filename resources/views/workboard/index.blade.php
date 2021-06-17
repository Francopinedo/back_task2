@extends('layouts.app', ['favoriteTitle' => __('workboard.workboard'), 'favoriteUrl' => url(Request::path())])
<style>

    td, th{    word-wrap: break-word; }
    .dataTables_wrapper .uk-overflow-container th, .dataTables_wrapper .uk-overflow-container td {
        white-space: initial !important;
    }
</style>
@section('scripts')
    <script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- datatables custom integration -->
    <script src="{{ asset('assets/js/custom/datatables/datatables.uikit.min.js') }}"></script>

    <script>

	$(document).ready(function() {
		var data;
		/**
		 * Seleccionar el ticket a editar
		 */

        tableActions.initEdit();
        $('.uk-table').DataTable({});
		/**
		 * Actualizar el ticket
		 */
		$('#update-btn').on('click', function(){
			var data = $('#workboard-form-edit').serialize();
			var id = $('#workboard-form-edit #id').val();

			$.ajax({
			    url : 'tickets/update',
			    type : 'POST',
			    data : data,
			    dataType: 'json',
    	        success : function ( json )
    	        {
    	            // Do something like redirect them to the dashboard...
    	            window.location.replace($('#workboard-form-edit').data('redirect-on-success'));
    	        },
    	        error: function( json )
    	        {
    	            if(json.status === 422) {
    	                var errors = json.responseJSON;
    	                $.each(json.responseJSON, function (key, value) {
    	                    $('#'+key+'-error').html(value);
    	                });
    	            } else {
    	                // Error
    	            }
    	        }
			});
		});
	});

	</script>
@endsection


@section('section_title', __('workboard.workboard'))

@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                <div class="uk-width-1-1">

                	@if(session()->has('message'))
                		<div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                	@endif

                	@if(!session()->has('project_id'))
                		<div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                	@endif

                    @if(count($tickets) == 0)
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('workboard.you_need_tickets') }}
                        </div>
                    @endif

					@if(session()->has('project_id') && count($tickets) > 0)
						<H2>{{ __('workboard.tickets_by_phase') }}</H2>
						@foreach ($phases as $phase)
							<h2 class="uk-alert uk-alert-info" data-uk-alert>{{ $phase->phase }}</h2>
							@if (count($tickets[$phase->phase]) == 0)
								<div class="uk-alert uk-alert-alert" data-uk-alert>
		                            {{ __('workboard.no_tickets') }}
		                        </div>
		                    @else
								<table class="uk-table" cellspacing="0" width="100%" style=" table-layout: fixed;">
								    <thead>
								        <tr>

											<th title="{{ __('tickets_tooltip.id') }}">{{ __('tickets.id') }}</th>
								        	<th title="{{ __('workboard_tooltip.task_description') }}">{{ __('workboard.task_description') }}</th>
								        	<th title="{{ __('workboard_tooltip.workgroup') }}">{{ __('workboard.workgroup') }}</th>
								        	<th title="{{ __('workboard_tooltip.ticket_description') }}">{{ __('workboard.ticket_description') }}</th>
								        	<th title="{{ __('tickets_tooltip.type') }}">{{ __('tickets.type') }}</th>
								        	<th title="{{ __('workboard_tooltip.owner') }}">{{ __('workboard.owner') }}</th>

								        	<th title="{{ __('tickets_tooltip.status') }}">{{ __('tickets.status') }}</th>
								        	<th title="{{ __('tickets_tooltip.group') }}">{{ __('tickets.group') }}</th>
								        	<th title="{{ __('tickets_tooltip.sprint') }}">{{ __('tickets.sprint') }}</th>
								        	<th title="{{ __('tickets_tooltip.due_date') }}">{{ __('tickets.due_date') }}</th>
								        	<th title="{{ __('tickets_tooltip.requester') }}">{{ __('tickets.requester') }}</th>
								        	<th title="{{ __('tickets_tooltip.priority') }}">{{ __('tickets.priority') }}</th>
								        	<th title="{{ __('tickets_tooltip.version') }}">{{ __('tickets.version') }}</th>
								        	<th title="{{ __('tickets_tooltip.release') }}">{{ __('tickets.release') }}</th>
								        	<th title="{{ __('tickets_tooltip.label') }}">{{ __('tickets.label') }}</th>
								        	<th title="{{ __('tickets_tooltip.comment') }}">{{ __('tickets.comment') }}</th>
								        	<th title="{{ __('tickets_tooltip.estimated_hours') }}">{{ __('tickets.estimated_hours') }}</th>
								        	<th title="{{ __('tickets_tooltip.burned_hours') }}">{{ __('tickets.burned_hours') }}</th>
								        	<th title="{{ __('general.actions') }}">{{ __('general.actions') }}</th>
								        </tr>
								    </thead>
								    <tbody>
								    	@foreach ($tickets[$phase->phase] as $ticket)
								    		<tr>
												<td>{{ $ticket->customer_id }}{{ $ticket->project_id }}{{ $ticket->id }}</td>
								    			<td>{{ $ticket->task_description }}</td>
								    			<td>{{ $ticket->workgroup_title }}</td>
								    			<td>{{ $ticket->description }}</td>
								    			<td>{{ __('tickets.type_'.$ticket->type) }}</td>
								    			<td>{{ $ticket->owner_name }}</td>

								    			<td>{{ __('tickets.status_'.$ticket->status) }}</td>
								    			<td>{{ __('tickets.group_'.$ticket->group) }}</td>
								    			<td>{{ $ticket->sprint }}</td>
								    			<td>{{ $ticket->due_date ? date('d-m-Y', strtotime($ticket->due_date)) : '' }}</td>
								    			<td>{{ $ticket->requester_name }}</td>
								    			<td> <p style="display: none">{{$ticket->priority}}</p> <label class="label <?php if($ticket->priority==1) echo 'label-success';
                                                    if($ticket->priority==2) echo 'label-warning';
                                                    if($ticket->priority==3) echo 'label-danger'?>">{{ __('tickets.priority_'.$ticket->priority) }}</label></td>
								    			<td>{{$ticket->version }}</td>
								    			<td>{{$ticket->release }}</td>
								    			<td>{{$ticket->label }}</td>
								    			<td>{{$ticket->comment }}</td>
								    			<td>{{ $ticket->estimated_hours }}</td>
								    			<td>{{ $ticket->burned_hours }}</td>
								    			<td>
		@if (Auth::id() == $ticket->owner_id or Auth::user()->workgroup_id == $ticket->workgroup_id or \App\Role::find(\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id)->slug>=3)
		    					            			<a title="{{__('general.edit')}}" href="/workboard/{{$ticket->id}}/edit" data-id="{{ $ticket->id }}" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
		    					            			@endif
								    			</td>
								    		</tr>
								    	@endforeach
								    </tbody>
								</table>
							@endif
						@endforeach
                	@endif
                </div>


            </div>
        </div>
    </div>
@endsection

