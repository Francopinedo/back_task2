@extends('layouts.app')

@section('scripts')
	<script src="{{ asset('js/company_preference.js') }}"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			companyPreference.initDelete();
		});

	</script>
@endsection

@section('section_title', __('companies.preferences'))

@section('content')

	<div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
	    <div class="uk-width-large-10-10">
	        <div class="md-card">
	            <div class="user_heading">
	                <div class="user_heading_content">
	                    <h2 class="heading_b uk-margin-bottom">
	                    	<span class="uk-text-truncate">{{ $company->name }}</span>
	                    	<span class="sub-heading"><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;&nbsp;{{ $company->industry->data->name or '' }}</span>
	                    </h2>
	                </div>
	                <a class="md-fab md-fab-small md-fab-accent hidden-print" href="{{ url('companies/edit') }}">
	                    <i class="fa fa-pencil fa15"></i>
	                </a>
	            </div>
	            <div class="user_content tabs_inside">
	                <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
	                    <li class="uk-active"><a href="#">{{ __('companies.basic') }}</a></li>
	                </ul>
	                <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
	                	<!--=========================================================
	                	=            Pestaña de datos basicos de Empresa            =
	                	==========================================================-->
	                	<li>
							<div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
							    <div class="uk-width-large-1-2">
							        <h4 class="heading_c uk-margin-small-bottom">{{ __('companies.main_info') }}</h4>
							        <ul class="md-list md-list-addon">
							        	<li>
							        	    <div class="md-list-addon-element">
							        	        <i class="fa fa-address-card-o fa-15"></i>
							        	    </div>
							        	    <div class="md-list-content">
							        	        <span class="md-list-heading">{{ $company->address }}</span>
							        	        <span class="uk-text-small uk-text-muted">{{ __('companies.address') }}</span>
							        	    </div>
							        	</li>
							        	<li>
							        	    <div class="md-list-addon-element">
							        	        <i class="fa fa-map-marker fa-15"></i>
							        	    </div>
							        	    <div class="md-list-content">
							        	        <span class="md-list-heading">{{ $company->city->data->name }}</span>
							        	        <span class="uk-text-small uk-text-muted">{{ __('companies.city') }}</span>
							        	    </div>
							        	</li>
							            <li>
							                <div class="md-list-addon-element">
							                    <i class="fa fa-envelope fa-15"></i>
							                </div>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->email }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.email') }}</span>
							                </div>
							            </li>
							            <li>
							                <div class="md-list-addon-element">
							                    <i class="fa fa-phone fa-15"></i>
							                </div>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->phone }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.phone') }}</span>
							                </div>
							            </li>
							        </ul>
							    </div>
							    <div class="uk-width-large-1-2">
							        <h4 class="heading_c uk-margin-small-bottom">{{ __('companies.billing_info') }}</h4>
							        <ul class="md-list">
							            <li>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->billing_name }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.billing_name') }}</span>
							                </div>
							            </li>
							            <li>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->billing_address }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.billing_address') }}</span>
							                </div>
							            </li>
							            <li>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->tax_number1 }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.tax_number') }}</span>
							                </div>
							            </li>
							            <li>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->bank_name }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.bank_name') }}</span>
							                </div>
							            </li>
							            <li>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->account_number }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.account_number') }}</span>
							                </div>
							            </li>
							            <li>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->swiftcode }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.swiftcode') }}</span>
							                </div>
							            </li>
							            <li>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->aba }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.aba') }}</span>
							                </div>
							            </li>
							            <li>
							                <div class="md-list-content">
							                    <span class="md-list-heading">{{ $company->currency->data->name }}</span>
							                    <span class="uk-text-small uk-text-muted">{{ __('companies.currency') }}</span>
							                </div>
							            </li>
							        </ul>
							    </div>
							</div>
	                	</li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>
@endsection