@extends('layouts.app')

@section('section_title', __('profile.profile'))

@section('scripts')
	<script src="{{ asset('js/profile.js') }}"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			profile.init();
		});

	</script>
@endsection

@section('content')
    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
        <div class="uk-width-large-10-10">
            <div class="md-card">
                <div class="user_heading">
                    <div class="user_heading_avatar">
                        <div class="thumbnail">
                        	@if (empty(Auth::user()->profile_image_path))
								<img class="md-user-image"
									 src="{{ URL::to('/') }}/assets/img/avatardefault.png">
                           	@else
                            	<img src="{{ URL::to('/') }}/assets/img/users/profile/{{ '.Auth::user()->id }}/{{ '.Auth::user()->profile_image_path }}" alt="user avatar"/>
                        	@endif
                        </div>
                    </div>
                    <div class="user_heading_content">
                        <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate">{{ Auth::user()->name }}</span></h2>
                    </div>
                    <a class="md-fab md-fab-small md-fab-accent hidden-print" href="{{ url('profile/edit') }}" title="{{ __('profile.edit') }}">
                        <i class="fa fa-pencil fa-15"></i>
                    </a>
                </div>
                <div class="user_content">
                    <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
                        <li class="uk-active"><a href="#">{{ __('profile.about') }}</a></li>
                        <li><a href="#">{{ __('profile.preferences') }}</a></li>
                    </ul>
                    <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                    	<!--=====================================================
                    	=            Pestaña de informacion personal            =
                    	======================================================-->
                        <li>
                            <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                                <div class="uk-width-large-1-2">
                                    <h4 class="heading_c uk-margin-small-bottom">{{ __('profile.contact_info') }}</h4>
                                    <ul class="md-list md-list-addon">
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="fa fa-envelope fa-15"></i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">{{ Auth::user()->email }}</span>
                                                <span class="uk-text-small uk-text-muted">{{ __('profile.email') }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="fa fa-address-card-o fa-15"></i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">{{ Auth::user()->address }}</span>
                                                <span class="uk-text-small uk-text-muted">{{ __('profile.address') }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="fa fa-phone fa-15"></i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">{{ Auth::user()->office_phone }}</span>
                                                <span class="uk-text-small uk-text-muted">{{ __('profile.office_phone') }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="fa fa-phone-square fa-15"></i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">{{ Auth::user()->home_phone }}</span>
                                                <span class="uk-text-small uk-text-muted">{{ __('profile.home_phone') }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-addon-element">
                                                <i class="fa fa-mobile fa-15"></i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">{{ Auth::user()->cell_phone }}</span>
                                                <span class="uk-text-small uk-text-muted">{{ __('profile.cell_phone') }}</span>
                                            </div>
										</li>
										<li>
                                            <div class="md-list-addon-element">
                                                <i class="fa fa-mobile fa-15"></i>
                                            </div>
                                            <div class="md-list-content">
                                                <span class="md-list-heading">{{ Auth::user()->language_id }}</span>
                                                <span class="uk-text-small uk-text-muted">{{ __('profile.language_id') }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
           <!--                      <div class="uk-width-large-1-2">
                                    <h4 class="heading_c uk-margin-small-bottom">{{ __('profile.my_projects') }}</h4>
                                    <ul class="md-list">
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Project 1</a></span>
                                                <span class="uk-text-small uk-text-muted">206 tasks</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Project 2</a></span>
                                                <span class="uk-text-small uk-text-muted">82 tasks</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Project 5</a></span>
                                                <span class="uk-text-small uk-text-muted">152 tasks</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Project X</a></span>
                                                <span class="uk-text-small uk-text-muted">284 tasks</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                        </li>
                        <!--=============================================
                        =            Pestaña de Preferencias            =
                        ==============================================-->
                        <li>
						    <div class="md-card">
						        <div class="md-card-content">
						        	<div class="uk-grid uk-grid-divider" data-uk-grid-margin="">
	        	                        <div class="uk-width-medium-1-4 uk-row-first">
	        	                            <h3 class="heading_a">{{ __('profile.sidebar') }}</h3>
											<br>
											<div>
												<label class="inline-label">
												    <input
												    	type="radio"
												    	class="ios-switch-cb"
												    	name="sidebar"
												    	value="sidebar_mini" {{ Auth::user()->sidebar == 'sidebar_mini' || empty(Auth::user()->sidebar) ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.sidebar_mini') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input
												    	type="radio"
												    	class="ios-switch-cb"
												    	name="sidebar"
												    	value="sidebar_main_open" {{ Auth::user()->sidebar == 'sidebar_main_open' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.sidebar_normal') }}
												</label>
											</div>
	        	                        </div>
	        	                        
	        	                         <div class="uk-width-medium-1-4 uk-row-first">
	        	                            <h3 class="heading_a">{{ __('profile.tooltip') }}</h3>
											<br>
											<div>
													<label class="inline-label">
												    <input
												    	type="radio"
												    	class="ios-switch-cb"
												    	name="tooltip"
												    	value={{ (Auth::user()->tooltip == '0' || empty(Auth::user()->tooltip)) ? '' : 'checked' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.tooltip') }}
												</label>
											</div>
											
	        	                        </div>



	        	                        <div class="uk-width-medium-1-4">
	        	                            <h3 class="heading_a">{{ __('profile.theme') }}</h3>
											<br>
											<div>
												<label class="inline-label">
												    <input
												    	type="radio"
												    	class="ios-switch-cb"
												    	name="theme"
												    	value="theme_default" {{ (Auth::user()->theme == 'app_theme_default' || empty(Auth::user()->theme)) ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_default') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input
												    	type="radio" class="ios-switch-cb" name="theme" value="app_theme_a" {{ Auth::user()->theme == 'app_theme_a' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_a') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_b" {{ Auth::user()->theme == 'app_theme_b' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_b') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_c" {{ Auth::user()->theme == 'app_theme_c' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_c') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_d" {{ Auth::user()->theme == 'app_theme_d' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_d') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_e" {{ Auth::user()->theme == 'app_theme_e' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_e') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_f" {{ Auth::user()->theme == 'app_theme_f' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_f') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_g" {{ Auth::user()->theme == 'app_theme_g' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_g') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_h" {{ Auth::user()->theme == 'app_theme_h' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_h') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_i" {{ Auth::user()->theme == 'app_theme_i' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_i') }}
												</label>
											</div>
											<div>
												<label class="inline-label">
												    <input type="radio" class="ios-switch-cb" name="theme" value="app_theme_dark" {{ Auth::user()->theme == 'app_theme_dark' ? 'checked' : '' }} disabled>
												    <span class="switchery"></span>
												    {{ __('profile.theme_dark') }}
												</label>
											</div>
	        	                        </div>
	        	                        <div class="uk-width-medium-1-4">
	        	                         
	        	                        </div>
	        	                        <div class="uk-width-medium-1-4">
	        	                       
	        	                        </div>
	        	                    </div>



						            </div>
						        </div>
						    </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
