@extends('layouts.app', ['favoriteTitle' => __('tasks.quotations'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'quotation';
		var urlParameters = '?project_id={{ session('project_id') }}';
		var columns = [
	            { data: 'id', name: 'id', visible: true },
	            { data: 'number', name: 'number' },
			    { data: 'concept', name: 'concept' },
	            { data: 'from', name: 'from' },
	            { data: 'to', name: 'to' },
	            { data: 'contact_name', name: 'contact_name' },
	            { data: 'currency_name', name: 'currency_name' },
	            { data: 'due_date', name: 'due_date' },
	            { data: 'total', name: 'total' },
	            { data: 'bill_to', name: 'bill_to' },
	            { data: 'remit_to', name: 'remit_to' },
	            { data: 'comments', name: 'comments' },
	            { data: 'actions', name: 'actions'}
	        ];

		var actions = [
			            { pre: '<a title="{{__('invoices.items')}}" href="/quotation/rows/', post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>' },
			            { pre: '<a title="{{__('general.edit')}}" href="/quotation/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
                        <?php if (Auth::user()->hasPermission('delete.users')) { ?>
                            { pre: '<a title="{{__('general.delete')}}" href="/quotation/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
                        <?php } ?>
			        ];

		DtablesUtil(tableName, columns, actions, urlParameters);
	});
	</script>
@endsection

@section('section_title', __('tasks.quotations'))

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
                	<table id="quotation-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                	        	<th title="{{ __('quotations_tooltip.id')}}">{{ __('quotations.id') }}</th>
                	        	<th title="{{ __('quotations_tooltip.number')}}">{{ __('quotations.number') }}</th>

                	        	<th title="{{ __('quotations_tooltip.concept')}}">{{ __('quotations.concept') }}</th>
                	        	<th title="{{ __('quotations_tooltip.from')}}">{{ __('quotations.from') }}</th>
                	        	<th title="{{ __('quotations_tooltip.to')}}">{{ __('quotations.to') }}</th>
                	        	<th title="{{ __('quotations_tooltip.contact')}}">{{ __('quotations.contact') }}</th>
                	        	<th title="{{ __('quotations_tooltip.currency')}}">{{ __('quotations.currency') }}</th>
                	        	<th title="{{ __('quotations_tooltip.due_date')}}">{{ __('quotations.due_date') }}</th>
                	        	<th title="{{ __('quotations_tooltip.total')}}">{{ __('quotations.total') }}</th>
                	        	<th title="{{ __('quotations_tooltip.bill_to')}}">{{ __('quotations.bill_to') }}</th>
                	        	<th title="{{ __('quotations_tooltip.remit_to')}}">{{ __('quotations.remit_to') }}</th>
                	        	<th title="{{ __('quotations_tooltip.comments')}}">{{ __('quotations.comments') }}</th>
                	        	<th>{{ __('general.actions') }}</th>
                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                		<!--	<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('invoices_tooltip.add_new')}}">{{ __('invoices.add_new') }}</a>-->
                		</div>
                	</div>
                	@endif
                </div>
            </div>
        </div>
    </div>
@endsection

@if(session()->has('project_id'))
@section('create_div')
	@component('quotation/create', ['currencies' => $currencies, 'contacts' => $contacts, 'project' => $project, 'company' => $company])

	@endcomponent
@endsection
@endif