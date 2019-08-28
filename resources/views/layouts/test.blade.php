<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="{{ config('app.locale') }}"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="/image/png" href="/assets/img/favicon_16.png" sizes="16x16">
    <link rel="icon" type="/image/png" href="/assets/img/favicon_32.png" sizes="32x32">

    <title>{{ config('app.name', 'Laravel') }}</title>

	{{-- Font Awesome --}}
	<link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css"/>

	<!-- additional styles for plugins -->
    <!-- kendo UI -->
    <link rel="stylesheet" href="/bower_components/kendo-ui/styles/kendo.common-material.min.css"/>
    <link rel="stylesheet" href="/bower_components/kendo-ui/styles/kendo.material.min.css" id="kendoCSS"/>

    <!-- uikit -->
    <link rel="stylesheet" href="/assets/css/uikit.almost-flat.css" media="all">

    <link rel="stylesheet" href="/assets/css/create_div.css" media="all">
    <link rel="stylesheet" href="/assets/css/edit_div.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="/assets/css/main.css" media="all">

	@if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_default')
		<link rel="stylesheet" href="/assets/css/themes/my_theme.css" media="all">
	@endif

    <!-- themes -->
    <link rel="stylesheet" href="/assets/css/themes/themes_combined.min.css" media="all">



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        var API_PATH = '{{ env('API_PATH') }}';
        var CLOUDINARY_PATH = '{{ env('CLOUDINARY_PATH') }}';
        var user_id = {{ Auth::id() }};
    </script>

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
        <link rel="stylesheet" href="assets/css/ie.css" media="all">
    <![endif]-->
</head>
<body class=" sidebar_main_open sidebar_main_swipe {{ (Auth::user()->sidebar == 'sidebar_mini' || empty(Auth::user()->sidebar)) ? 'sidebar_mini' : 'sidebar_main_open' }} {{ Auth::user()->theme }} header_full">

	<!-- main header -->
	<header id="header_main">
	    <div class="header_main_content">
	        <nav class="uk-navbar">
				<div class="main_logo_top">
                    <a href="/">
						@if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_default')
							<img src={{ URL::to('/') }}/assets/img/logo.png" alt=""
								 height="15" width="71">
						@else
							<img src="{{ URL::to('/') }}/assets/img/logo_b.png"
								 alt="" height="15" width="71">
						@endif
                    </a>
                </div>

	            <div class="uk-navbar-flip">
	                <ul class="uk-navbar-nav user_actions">
	                    <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="fa fa-15 fa-window-maximize" aria-hidden="true"></i></a></li>
	                    <li><a href="#" id="main_search_btn" class="user_action_icon"><i class="fa fa-15 fa-search" aria-hidden="true"></i></a></li>
	                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
	                        <a href="#" class="user_action_icon"><i class="fa fa-15 fa-bell" aria-hidden="true"></i><span class="uk-badge">16</span></a>
	                        <div class="uk-dropdown uk-dropdown-xlarge">
	                            <div class="md-card-content">
	                                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
	                                    <li class="uk-width-1-2 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Messages (12)</a></li>
	                                    <li class="uk-width-1-2"><a href="#" class="js-uk-prevent uk-text-small">Alerts (4)</a></li>
	                                </ul>
	                                <ul id="header_alerts" class="uk-switcher uk-margin">
	                                    <li>
	                                        <ul class="md-list md-list-addon">
	                                            <li>
	                                                <div class="md-list-addon-element">
	                                                    <span class="md-user-letters md-bg-cyan">fu</span>
	                                                </div>
	                                                <div class="md-list-content">
	                                                    <span class="md-list-heading"><a href="page_mailbox.html">Nihil esse atque.</a></span>
	                                                    <span class="uk-text-small uk-text-muted">Quia ut officia commodi modi ex qui est voluptatem et occaecati.</span>
	                                                </div>
	                                            </li>
	                                        </ul>
	                                        <div class="uk-text-center uk-margin-top uk-margin-small-bottom">
	                                            <a href="page_mailbox.html" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Show All</a>
	                                        </div>
	                                    </li>
	                                    <li>
	                                        <ul class="md-list md-list-addon">
	                                            <li>
	                                                <div class="md-list-addon-element">
	                                                    <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>
	                                                </div>
	                                                <div class="md-list-content">
	                                                    <span class="md-list-heading">Et voluptate non.</span>
	                                                    <span class="uk-text-small uk-text-muted uk-text-truncate">Eum et sit dolorem vel.</span>
	                                                </div>
	                                            </li>
	                                        </ul>
	                                    </li>
	                                </ul>
	                            </div>
	                        </div>
	                    </li>
	                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
	                        <a href="#" class="user_action_image">
								@if (empty(Auth::user()->profile_image_path))
									<img class="md-user-image"
										 src="{{ URL::to('/') }}/assets/img/avatardefault.png">
								@else
									<img class="md-user-image"
										 src="{{ URL::to('/') }}/storage/users/profile/{{Auth::id()}}/{{Auth::user()->profile_image_path}}">


								@endif
	                        </a>
	                        <div class="uk-dropdown uk-dropdown-small">
	                            <ul class="uk-nav js-uk-prevent">
	                                <li><a href="{{ url('profile') }}">{{ __('header.profile') }}</a></li>
	                                <li><a href="page_settings.html">Settings</a></li>
	                                <li>
	                                    <a href="{{ route('logout') }}"
	                                        onclick="event.preventDefault();
	                                                 document.getElementById('logout-form').submit();">
	                                        {{ __('login.logout') }}
	                                    </a>

	                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                        {{ csrf_field() }}
	                                    </form>
	                                </li>
	                            </ul>
	                        </div>
	                    </li>
	                </ul>

	                <div id="menu_top_dropdown" class="uk-float-right uk-hidden-small">
	                    <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
	                        <a href="#" class="top_menu_toggle"><i class="fa fa-2x fa-bars" aria-hidden="true"></i></a>
	                        <div class="uk-dropdown uk-dropdown-width-3">
	                            <div class="uk-grid uk-dropdown-grid">
	                                <div class="uk-width-2-3">
	                                    <div class="uk-grid uk-grid-width-medium-1-3 uk-margin-bottom uk-text-center">
	                                        <a href="page_mailbox.html" class="uk-margin-top">
	                                            <i class="material-icons md-36 md-color-light-green-600">&#xE158;</i>
	                                            <span class="uk-text-muted uk-display-block">Mailbox</span>
	                                        </a>
	                                    </div>
	                                </div>
	                                <div class="uk-width-1-3">
	                                    <ul class="uk-nav uk-nav-dropdown uk-panel">
	                                        <li class="uk-nav-header">Components</li>
	                                    </ul>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>

	            <div class="section_title">
                	@yield('section_title')
                	@if (!empty($favoriteTitle))
                		<a href="#" id="favoriteLink" data-favorite-title={{ $favoriteTitle }} data-favorite-url={{ $favoriteUrl }}>
                			<i class="fa fa-star-o" aria-hidden="true"></i>
                		</a>
                	@endif
                </div>
	        </nav>
	    </div>
	</header><!-- main header end -->

	<!-- main sidebar -->
    <aside id="sidebar_main">

        <div class="menu_section_alternative">
        	<ul id="kUI_menu">
        		@role('user')
        	    <li title="Process By Group">
        	        <i class="fa fa-bars fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">{{ __('sidebar.process_by_group') }}</span>
        	        <ul class="second_level">
        	            <li>Initiating
        	                <ul>
        	                    <li>Leisure Trainers</li>
        	                    <li>Running Shoes</li>
        	                    <li>Outdoor Footwear</li>
        	                    <li>Sandals/Flip Flops</li>
        	                    <li>Footwear Accessories</li>

        	                </ul>
        	            </li>
        	            <li>Planning
        	                <ul>
        	                    <li>T-Shirts</li>
        	                    <li>Hoodies &amp; Sweatshirts</li>
        	                    <li>Jackets</li>
        	                    <li>Pants</li>
        	                    <li>Shorts</li>
        	                </ul>
        	            </li>
        	            <li>Executing
        	                <ul>
        	                    <li>Football</li>
        	                    <li>Basketball</li>
        	                    <li>Golf</li>
        	                    <li>Tennis</li>
        	                    <li>Swimwear</li>
        	                </ul>
        	            </li>
        	            <li>Monitoring & Control
        	                <ul>
        	                    <li>Football</li>
        	                    <li>Basketball</li>
        	                    <li>Golf</li>
        	                    <li>Tennis</li>
        	                    <li>Swimwear</li>
        	                </ul>
        	            </li>
        	            <li>Closing
        	                <ul>
        	                    <li>Football</li>
        	                    <li>Basketball</li>
        	                    <li>Golf</li>
        	                    <li>Tennis</li>
        	                    <li>Swimwear</li>
        	                </ul>
        	            </li>
        	        </ul>
        	    </li>
        	    <li title="Process By KnowledgeArea">
        	        <i class="fa fa-bars fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">{{ __('sidebar.process_by_knowledgearea') }}</span>
        	        <ul class="second_level">
        	            <li>Integration
        	                <ul>
        	                    <li>Leisure Trainers</li>
        	                    <li>Running Shoes</li>
        	                    <li>Outdoor Footwear</li>
        	                    <li>Sandals/Flip Flops</li>
        	                    <li>Footwear Accessories</li>

        	                </ul>
        	            </li>
        	            <li>Scope Management
        	                <ul>
        	                    <li>T-Shirts</li>
        	                    <li>Jackets</li>
        	                </ul>
        	            </li>
        	            <li>Time Management
        	                <ul>
        	                    <li>Basketball</li>
        	                    <li>Golf</li>
        	                    <li>Tennis</li>
        	                    <li>Swimwear</li>
        	                </ul>
        	            </li>
        	            <li>Cost Management
        	                <ul>
        	                    <li>T-Shirts</li>
        	                    <li>Jackets</li>
        	                </ul>
        	            </li>
        	            <li>Human Resources
        	                <ul>
        	                    <li>T-Shirts</li>
        	                    <li>Jackets</li>
        	                </ul>
        	            </li>
        	            <li>Comunication
        	                <ul>
        	                    <li>T-Shirts</li>
        	                    <li>Jackets</li>
        	                </ul>
        	            </li>
        	            <li>Stakeholders
        	                <ul>
        	                    <li>T-Shirts</li>
        	                    <li>Jackets</li>
        	                </ul>
        	            </li>
        	            <li>Risk Management
        	                <ul>
        	                    <li>T-Shirts</li>
        	                    <li>Jackets</li>
        	                </ul>
        	            </li>
        	            <li>Procurement
        	                <ul>
        	                    <li>T-Shirts</li>
        	                    <li>Jackets</li>
        	                </ul>
        	            </li>
        	        </ul>
        	    </li>
        	    <li title="{{ __('sidebar.favorites') }}">
					<i class="fa fa-star fa-15" aria-hidden="true"></i>
					<span class="menu_title">{{ __('sidebar.favorites') }}</span>
        	    	<ul class="second_level">
        	            <li>Favorito 1</li>
        	            <li>Favorito 2</li>
        	            <li>Favorito 3</li>
        	            <li>Favorito 4</li>
        	        </ul>
        	    </li>
        	    @endrole
        		<li title="Notes">
        	        <i class="fa fa-sticky-note-o fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">Notes</span>
        	    </li>
        	    <li title="Contacts">
        	        <i class="fa fa-address-book fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">Contacts</span>
        	    </li>
        	    <li title="Calendar">
        	        <i class="fa fa-calendar fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">Calendar</span>
        	    </li>
        	    <li title="Timeline">
        	        <i class="fa fa-tasks fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">Timeline</span>
        	    </li>
        	    <li title="Workboard">
        	        <i class="fa fa-pie-chart fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">Workboard</span>
        	    </li>
        	    <li title="Minutes">
        	        <i class="fa fa-window-maximize fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">Minutes</span>
        	    </li>
        	    <li title="Reports">
        	        <i class="fa fa-balance-scale fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">Reports</span>
        	    </li>
        	    <li title="Repository">
        	        <i class="fa fa-dropbox fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">Repository</span>
        	    </li>

        	    @php
					$class = (Request::is('companies') || Request::is('customers') ) ? 'current_section' : '';
				@endphp
        	    <li title="{{ __('sidebar.systemsettings') }}" class="{{ $class }}">
        	        <i class="fa fa-cogs fa-15" aria-hidden="true"></i>
        	        <span class="menu_title">{{ __('sidebar.systemsettings') }}</span>
        	        <ul class="second_level">
        	            <li class="{{{ (Request::is('companies') ? 'act_item' : '') }}}">
        	            	@role('admin')
								<a href="{{ url('admin_companies') }}">{{ __('sidebar.companies') }}</a>
							@else
								<a href="{{ url('companies') }}">{{ __('sidebar.my_company') }}</a>
							@endrole
        	            </li>
        	            <li class="{{{ (Request::is('customers') ? 'act_item' : '') }}}">
							<a href="{{ url('customers') }}">{{ __('sidebar.customers') }}</a>
        	            </li>
        	        </ul>
        	    </li>

                @role('admin')
                <li title="{{ __('sidebar.users') }}" class="{{{ (Request::is('users') ? 'current_section' : '') }}}">
                    <a href="{{ url('users') }}">
                        <i class="fa fa-user fa-15" aria-hidden="true"></i>
                    </a>
                </li>

                <li title="{{ __('sidebar.languages') }}" class="{{{ (Request::is('languages') ? 'current_section' : '') }}}">
                    <a href="{{ url('languages') }}">
                        <i class="fa fa-language fa-15" aria-hidden="true"></i>
                    </a>
                </li>

                <li title="{{ __('sidebar.currencies') }}" class="{{{ (Request::is('currencies') ? 'current_section' : '') }}}">
                    <a href="{{ url('currencies') }}">
                        <i class="fa fa-usd fa-15" aria-hidden="true"></i>
                    </a>
                </li>

                <li title="{{ __('sidebar.countries') }}" class="{{{ (Request::is('countries') ? 'current_section' : '') }}}">
                    <a href="{{ url('countries') }}">
                        <i class="fa fa-globe fa-15" aria-hidden="true"></i>
                    </a>
                </li>

                <li title="{{ __('sidebar.cities') }}" class="{{{ (Request::is('cities') ? 'current_section' : '') }}}">
                    <a href="{{ url('cities') }}">
                        <i class="fa fa-map-marker fa-15" aria-hidden="true"></i>
                    </a>
                </li>

                <li title="{{ __('sidebar.industries') }}" class="{{{ (Request::is('industries') ? 'current_section' : '') }}}">
                    <a href="{{ url('industries') }}">
                        <i class="fa fa-industry fa-15" aria-hidden="true"></i>
                    </a>
                </li>

				@php
					$class = (Request::is('studio_templates') || Request::is('seniority_templates') || Request::is('project_role_templates') ) ? 'current_section' : '';
				@endphp
                <li title="{{ __('sidebar.templates') }}" class="{{ $class }}">
                    <i class="fa fa-list-ul fa-15" aria-hidden="true"></i>
                    <ul class="second_level">
                        <li class="{{{ (Request::is('studio_templates') ? 'act_item' : '') }}}">
                        	<a href="{{ url('studio_templates') }}">{{ __('sidebar.studio_templates') }}</a>
                        </li>
                        <li class="{{{ (Request::is('seniority_templates') ? 'act_item' : '') }}}">
                        	<a href="{{ url('seniority_templates') }}">{{ __('sidebar.seniority_templates') }}</a>
                        </li>
                        <li class="{{{ (Request::is('project_role_templates') ? 'act_item' : '') }}}">
                        	<a href="{{ url('project_role_templates') }}">{{ __('sidebar.project_role_templates') }}</a>
                        </li>
                        <li class="{{{ (Request::is('company_role_templates') ? 'act_item' : '') }}}">
                        	<a href="{{ url('company_role_templates') }}">{{ __('sidebar.company_role_templates') }}</a>
                        </li>
                        <li class="{{{ (Request::is('absence_types') ? 'act_item' : '') }}}">
                        	<a href="{{ url('absence_types') }}">{{ __('sidebar.absence_types') }}</a>
                        </li>
                    </ul>
                </li>

                @endrole
            </ul>
        </div>
    </aside><!-- main sidebar end -->

    <div id="page_content">
        <div id="page_content_inner">

        	@yield('content')

        </div>
    </div>

    <!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="/assets/js/common.js"></script>
    <!-- uikit functions -->
    <script src="/assets/js/uikit_custom.js"></script>
    <!-- altair common functions/helpers -->
    <script src="/assets/js/altair_admin_common.js"></script>

    <!-- page specific plugins -->
    <!-- kendo UI -->
    <script src="/assets/js/kendoui_custom.js"></script>

    <!--  kendoui functions -->
    <script src="/assets/js/pages/kendoui.js"></script>

    <script>
        $(function() {
            if(isHighDensity()) {
                $.getScript( "bower_components/dense/src/dense.js", function() {
                    // enable hires images
                    altair_helpers.retina_images();
                })
            }
            if(Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
    </script>

    @yield('scripts')


	<!--==================================
	=            CREATE DIV            =
	===================================-->

	<div id="create_div">
        <div id="create_div_toggle" style="display: none;"><i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i></div>
        <div class="">
            @yield('create_div')
        </div>
    </div>

	<!--====  End of CREATE DIV  ====-->

	<!--==================================
	=            EDIT DIV            =
	===================================-->

	<div id="edit_div">
        <div id="edit_div_toggle" style="display: none;"><i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i></div>
        <div class="edit_div">

        </div>
    </div>

	<!--====  End of EDIT DIV  ====-->

	<!--================================
	=            INFO MODAL            =
	=================================-->


        <div class="uk-modal" id="modal_info">
            <div class="uk-modal-dialog uk-modal-dialog-large">
                <button type="button" class="uk-modal-close uk-close"></button>
                <div id="loading_info_div" style="text-align: center;">
                	<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
					<span class="sr-only">Loading...</span>
                </div>
                <div id="info_div"></div>
            </div>
        </div>


	<!--====  End of INFO MODAL  ====-->


    <!-- Scripts -->
    <script src="{{ asset('js/table_actions.js') }}"></script>
    <script src="{{ asset('js/favorites.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
