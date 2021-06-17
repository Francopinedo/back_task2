@extends('layouts.app', ['favoriteTitle' => __('contacts.contacts'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'contacts';
		var urlParameters = '?project_id={{ session('project_id')==null?'': session('project_id') }}&user_id={{ Auth::id() }}';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'name', name: 'name' },
	            { data: 'project_name',name: 'project_name',
			  render: function ( data, type, row ) {
     			    return data===''?'General Contact':data;
     			 },defaultContent:'General Contact'},
	            { data: 'company', name: 'company' },
	            { data: 'department', name: 'department' },
	            { data: 'country_name', name: 'country_name' },
	            { data: 'city_name', name: 'city_name' },
	            { data: 'industry_name', name: 'industry_name' },
	            { data: 'email', name: 'email' },
	            { data: 'phone', name: 'phone' },
	            { data: 'comments', name: 'comments' },
	            { data: 'actions', name: 'actions'}
	        ];


        var extra_buttons = [{
            text: 'IMPORT',
            action: function (e, dt, node, config) {

                var self = this;

                // inicializo acciones del boton editar
                var $switcher_ajax_create = $('#ajax_create_div'),
                    $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
                    $ajax_create_url = 'contacts/import';


                e.preventDefault();

                $switcher_ajax_create_toggle.show();
                $('#ajax_create_div').addClass('switcher_active');
                $('#ajax_create_div').css('position', 'absolute');
                $.ajax({
                    url: $ajax_create_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function(data){
                        $('.ajax_create_div').html(data.view);
                    }
                );


                $switcher_ajax_create_toggle.click(function (e) {
                    e.preventDefault();
                    $switcher_ajax_create.toggleClass('switcher_active');
                    //  $('#ajax_create_div').css('position','relative');
                });

            }
        }];

		var actions = [
			            { pre: '<a title="{{__('general.edit')}}" href="/contacts/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
                        <?php if (Auth::user()->hasPermission('delete.users')) { ?>
			            { pre: '<a title="{{__('general.delete')}}" href="/contacts/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
                        <?php } ?>
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters, extra_buttons);
	});
	</script>
@endsection

@section('section_title', __('contacts.contacts'))

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

                	{{-- @if(!session()->has('project_id'))
                		<div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                	@endif --}}

					{{-- @if(session()->has('project_id')) --}}
                	<table id="contacts-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{__('contacts_tooltip.id')}}">{{ __('contacts.id') }}</th>
                	        	<th title="{{__('contacts_tooltip.name')}}">{{ __('contacts.name') }}</th>
                	        	<th title="{{__('contacts_tooltip.project')}}">{{ __('contacts.project') }}</th>
                	        	<th title="{{__('contacts_tooltip.company')}}">{{ __('contacts.company') }}</th>
                	        	<th title="{{__('contacts_tooltip.department')}}">{{ __('contacts.department') }}</th>
                	        	<th title="{{__('contacts_tooltip.country')}}">{{ __('contacts.country') }}</th>
                	        	<th title="{{__('contacts_tooltip.city')}}">{{ __('contacts.city') }}</th>
                	        	<th title="{{__('contacts_tooltip.industry')}}">{{ __('contacts.industry') }}</th>
                	        	<th title="{{__('contacts_tooltip.email')}}">{{ __('contacts.email') }}</th>
                	        	<th title="{{__('contacts_tooltip.phone')}}">{{ __('contacts.phone') }}</th>
                	        	<th title="{{__('contacts_tooltip.comments')}}">{{ __('contacts.comments') }}</th>
                	        	<th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('contacts.add_new') }}">{{ __('contacts.add_new') }}</a>
                		</div>
                	</div>
                	{{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
	@component('contact/create', ['company' => $company, 'projects' => $projects, 'countries' => $countries, 'cities' => $cities, 'industries' => $industries])

	@endcomponent
@endsection
