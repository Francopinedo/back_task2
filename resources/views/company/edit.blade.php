@extends('layouts.app')

@section('scripts')
	<script src="{{ asset('js/company_preference.js') }}"></script>
	<!-- handlebars.js -->
    <script src="/bower_components/handlebars/handlebars.min.js"></script>
    <script src="/assets/js/custom/handlebars_helpers.min.js"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			companyPreference.init();
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
	                    	<span class="sub-heading">
	                    		<i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;&nbsp;{{ $company->industry->data->name or '' }}
	                    		<div class="uk-alert uk-alert-danger hide_when_empty" data-uk-alert="" id="status_code-error"></div>
	                    	</span>

	                    </h2>
	                </div>
	                <a title="{{__('general.save')}}" class="md-fab md-fab-small md-fab-accent hidden-print" href="#" id="save-preferences">
	                    <i class="fa fa-floppy-o fa15"></i>
	                </a>
	            </div>
	            <div class="user_content tabs_inside">
	            	<form role="form" method="POST" action="{{ url('companies/update') }}" id="preferences-form" data-redirect-on-success="{{ url('companies') }}" enctype="multipart/form-data">
	            		{!! method_field('patch') !!}
    	    			{{ csrf_field() }}
    	    			<input type="hidden" name="company[id]" value="{{ $company->id }}">
		                <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
		                    <li class="uk-active"><a href="#">{{ __('companies.basic') }}</a></li>
		                </ul>
		                <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
	                		<!--==============================================
	                		=            Pestaña de datos basicos            =
	                		===============================================-->
	                	    <li>
                	            <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom">
                	                <div class="uk-width-large-1-2">
                	                	<h4 class="heading_c uk-margin-small-bottom">{{ __('companies.main_info') }}</h4>
                	                    <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-1" data-uk-grid-margin>
                	                    	<div>
                	                            <div class="uk-input-group">
                	                                <span class="uk-input-group-addon">
                	                                    <i class="fa fa-building fa-15"></i>
                	                                </span>
                	                                <label>{{ __('companies.name') }}</label>
                	                                <input type="text" class="md-input" name="company[name]" value="{{ $company->name }}">
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                                <span class="uk-input-group-addon">
                	                                    <i class="fa fa-building-o fa-15"></i>
                	                                </span>
                	                                <select name="company[industry_id]" data-md-selectize>
                	                                    <option value="">{{ __('companies.industry') }}...</option>
                	                                    @foreach ($industries as $industry)
                	                                        <option value="{{ $industry->id }}" {{ ($industry->id == $company->industry_id) ? 'selected' : '' }}>{{ $industry->name }}</option>
                	                                    @endforeach
                	                                </select>
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                                <span class="uk-input-group-addon">
                	                                    <i class="fa fa-address-card-o fa-15"></i>
                	                                </span>
                	                                <label>{{ __('companies.address') }}</label>
                	                                <input type="text" class="md-input" name="company[address]" value="{{ $company->address }}">
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                                <span class="uk-input-group-addon">
                	                                    <i class="fa fa-map-marker fa-15"></i>
                	                                </span>
                	                                <select name="company[city_id]" data-md-selectize>
                	                                    <option value="">{{ __('companies.city') }}...</option>
                	                                    @foreach ($cities as $city)
                	                                        <option value="{{ $city->id }}" {{ ($city->id == $company->city_id) ? 'selected' : '' }}>{{ $city->name }}</option>
                	                                    @endforeach
                	                                </select>
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                                <span class="uk-input-group-addon">
                	                                    <i class="fa fa-envelope fa-15"></i>
                	                                </span>
                	                                <label>{{ __('companies.email') }}</label>
                	                                <input type="email" class="md-input" name="company[email]" value="{{ $company->email }}" />
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                                <span class="uk-input-group-addon">
                	                                    <i class="fa fa-phone fa-15"></i>
                	                                </span>
                	                                <label>{{ __('companies.phone') }}</label>
                	                                <input type="text" class="md-input" name="company[phone]" value="{{ $company->phone }}" >
                	                            </div>
                	                        </div>

							<div>
  						 <div class="uk-input-group">
                	                                <span class="uk-input-group-addon">
                	                                <label>{{ __('companies.logo_path') }}</label>
					<div class="thumbnail">
                                        @if (empty($company->logo_path) || $company->logo_path=='')
                                            <img alt="logo" id="logo_path_img2"
                                                 src="{{ URL::to('/') }}/assets/img/avatardefault.png">

                                        @else
                                            <img src="{{ URL::to('/') .'/logos/companies/'. $company->id .'/'. $company->logo_path }}"
                                                 alt="" id="logo_path_img2">
                                        @endif
                                    </div>
  <a class="uk-form-file md-btn" id="upload_widget_opener">Upload image
                                        <input type="file" name="company[logo_path]" accept="image/*" onchange="document.getElementById('logo_path_img2').src = window.URL.createObjectURL(this.files[0])" />
                                    </a>

                                    </div>


</div>
                	                    </div>
                	                </div>
                	                <div class="uk-width-large-1-2">
                	                	<h4 class="heading_c uk-margin-small-bottom">{{ __('companies.main_info') }}</h4>
                	                    <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-1" data-uk-grid-margin>
                	                        <div>
                	                            <div class="uk-input-group">
                	                            	<span class="uk-input-group-addon">

                	                                </span>
                	                                <label>{{ __('companies.billing_name') }}</label>
                	                                <input type="text" class="md-input" name="company[billing_name]" value="{{ $company->billing_name }}">
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                            	<span class="uk-input-group-addon">

                	                                </span>
                	                                <label>{{ __('companies.billing_address') }}</label>
                	                                <input type="text" class="md-input" name="company[billing_address]" value="{{ $company->billing_address }}" />
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                            	<span class="uk-input-group-addon">

                	                                </span>
                	                                <label>{{ __('companies.tax_number') }}</label>
                	                                <input type="text" class="md-input" name="company[tax_number1]" value="{{ $company->tax_number1 }}" />
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                            	<span class="uk-input-group-addon">

                	                                </span>
                	                                <label>{{ __('companies.bank_name') }}</label>
                	                                <input type="text" class="md-input" name="company[bank_name]" value="{{ $company->bank_name }}" >
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                            	<span class="uk-input-group-addon">

                	                                </span>
                	                                <label>{{ __('companies.account_number') }}</label>
                	                                <input type="text" class="md-input" name="company[account_number]" value="{{ $company->account_number }}" >
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                            	<span class="uk-input-group-addon">

                	                                </span>
                	                                <label>{{ __('companies.swiftcode') }}</label>
                	                                <input type="text" class="md-input" name="company[swiftcode]" value="{{ $company->swiftcode }}" >
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                            	<span class="uk-input-group-addon">

                	                                </span>
                	                                <label>{{ __('companies.aba') }}</label>
                	                                <input type="text" class="md-input" name="company[aba]" value="{{ $company->aba }}" >
                	                            </div>
                	                        </div>
                	                        <div>
                	                            <div class="uk-input-group">
                	                            	<span class="uk-input-group-addon">

                	                                </span>
                	                                <select name="company[currency_id]" data-md-selectize>
                	                                    <option value="">{{ __('companies.currency') }}...</option>
                	                                    @foreach ($currencies as $currency)
                	                                        <option value="{{ $currency->id }}" {{ ($currency->id == $company->currency_id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                	                                    @endforeach
                	                                </select>
                	                            </div>
                	                        </div>
                	                    </div>
                	                </div>
                	            </div>
	                	    </li>
		                </ul>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>
@endsection
