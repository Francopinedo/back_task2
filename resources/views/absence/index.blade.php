@extends('layouts.app', ['favoriteTitle' => __('absences.absences'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'absences';
		var urlParameters = '?project_id={{ session('project_id') }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'absence_type_title', name: 'absence_type_title' },
	            { data: 'country_name', name: 'country_name' },
	            { data: 'city_name', name: 'city_name' },
	            { data: 'comment', name: 'comment' },
	            { data: 'from', name: 'from' },
	            { data: 'to', name: 'to' },
	            { data: 'days', name: 'days' },
	            { data: 'user_name', name: 'user_name' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title={{__('general.edit')}} href="/absences/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
                        <?php if (Auth::user()->hasPermission('delete.users')) { ?>
	                       { pre: '<a title={{__('general.delete')}} href="/absences/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
                        <?php } ?>
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>

    <script>
	$(document).ready(function() {
	    $("#absence_type_id").selectize();
		/*$('#country_id').on('change', function(){
			var country_id = $(this).val();

			$.ajax({
		        url: '/absence_types/forAbsences/' + country_id,
		        type: 'GET',
		        dataType: 'json'
		    }).done(
		        function(data){
                    $('#absence_type_id').selectize()[0].selectize.destroy();
		        	$('#absence_type_id').html(data.view);
                    $("#absence_type_id").selectize();
		        }
		    );
		});*/
	});

	</script>
@endsection

@section('section_title', __('absences.absences'))

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

                	@if(!session()->has('project_id'))
                		<div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                	@endif

					@if(session()->has('project_id'))
                	<table id="absences-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('absences_tooltip.id')}}">{{ __('absences.id') }}</th>
                	        	<th title="{{ __('absences_tooltip.type')}}">{{ __('absences.type') }}</th>
                	        	<th title="{{ __('absences_tooltip.country')}}">{{ __('absences.country') }}</th>
                	        	<th title="{{ __('absences_tooltip.city')}}">{{ __('absences.city') }}</th>
                	        	<th title="{{ __('absences_tooltip.comment')}}">{{ __('absences.comment') }}</th>
                	        	<th title="{{ __('absences_tooltip.from')}}">{{ __('absences.from') }}</th>
                	        	<th title="{{ __('absences_tooltip.to')}}">{{ __('absences.to') }}</th>
                	        	<th title="{{ __('absences_tooltip.days')}}">{{ __('absences.days') }}</th>
                	        	<th title="{{ __('absences_tooltip.user')}}">{{ __('absences.user') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('absences_tooltip.add_new')}}">{{ __('absences.add_new') }}</a>
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('absence/create', ['countries' => $countries, 'users' => $users, 'company'=>$company, 'url'=>Request::path()])

	@endcomponent
@endsection