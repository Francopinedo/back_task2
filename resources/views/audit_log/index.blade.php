@extends('layouts.app')

@section('scripts')
	@include('datatables.basic')
	<script>
	$(function() {
		var tableName = 'audit_log';
		var columns = [
	            { data: 'id', name: 'id', visible: false },
	            { data: 'date_action', name: 'date_action' },
	            { data: 'process_name', name: 'process_name' },
	            { data: 'action_name', name: 'action_name' },
	            { data: 'project_name', name: 'project_name' },
			 { data: 'customer_name', name: 'customer_name' },
			 { data: 'user_name', name: 'user_name' },
			 { data: 'role', name: 'role' },
 				{ data: 'reason', name: 'reason' },
			 { data: 'user_comment', name: 'user_comment' },


	        ];




		DtablesUtil(tableName, columns);
	});



	</script>
@endsection

@section('section_title', __('audit_log.audit_log'))

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

                	<table id="audit_log-table" class="uk-table" cellspacing="0" width="100%">
                	    <thead>
                	        <tr>
                                <th title="{{__('audit_log_tooltip.id')}}">{{ __('audit_log.id') }}</th>
                                <th title="{{__('audit_log_tooltip.date_action')}}">{{ __('audit_log.date_action') }}</th>
                                <th title="{{__('audit_log_tooltip.process_name')}}">{{ __('audit_log.process_name') }}</th>
                                <th title="{{__('audit_log_tooltip.action_name')}}">{{ __('audit_log.action_name') }}</th>
                                <th title="{{__('audit_log_tooltip.project_name')}}">{{ __('audit_log.project_name') }}</th>
                                <th title="{{__('audit_log_tooltip.customer_name')}}">{{ __('audit_log.customer_name') }}</th>
                                <th title="{{__('audit_log_tooltip.user_name')}}">{{ __('audit_log.user_name') }}</th>


                                <th title="{{__('audit_log_tooltip.role')}}">{{ __('audit_log.role') }}</th>
                                <th title="{{__('audit_log_tooltip.reason')}}">{{ __('audit_log.reason') }}</th>
                                <th title="{{__('audit_log_tooltip.user_comment')}}">{{ __('audit_log.user_comment') }}</th>


                	        </tr>
                	    </thead>
                	</table>
                	<div class="uk-grid datatables-bottom">
                		<div class="uk-width-medium-1-3" id="datatables-length"></div>
                		<div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                		<div class="uk-width-medium-1-3">
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
@endsection


