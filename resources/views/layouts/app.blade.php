<!DOCTYPE html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="{{ app()->getLocale() }}"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"> --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>
    

    <link rel="icon" type="/image/png" href="{{ asset('/assets/img/favicon_16.png') }}" sizes="16x16">
    <link rel="icon" type="/image/png" href="{{ asset('/assets/img/favicon_32.png') }}" sizes="32x32">

    <title>@yield('section_title') - TaskControl</title>
    <!-- kendo UI -->
    <link rel="stylesheet" href="{{ asset('/bower_components/kendo-ui/styles/kendo.common-material.min.css')}}"/>
    <!-- additional styles for plugins -->
    <link rel="stylesheet" href="{{ asset('/bower_components/kendo-ui/styles/kendo.material.min.css')}}" id="kendoCSS"/>
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- uikit -->
    <link rel="stylesheet" href="{{ asset('/assets/css/uikit.almost-flat.css')}}" media="all">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css')}}"/>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('/assets/css/create_div.css')}}" media="all">

    <link rel="stylesheet" href="{{ asset('/assets/css/edit_div.css')}}" media="all">

    <link rel="stylesheet" href="{{ asset('/assets/css/ajax_create_div.css')}}" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="{{ asset('/assets/css/main.css')}}" media="all">

    @if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_default')
        <link rel="stylesheet" href="{{ asset('/assets/css/themes/my_theme.css')}}" media="all">
        <theme-default></theme-default>
    @endif

    <!-- color en placeholder de input -->
    @if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_dark')
        <style>
            ::-webkit-input-placeholder { color: #D7D6D6; } 

            :-moz-placeholder { /* Firefox 18- */ color: #D7D6D6; } 

            ::-moz-placeholder { /* Firefox 19+ */ color: #D7D6D6; } 

            :-ms-input-placeholder { color: #D7D6D6; }
        </style>
    @endif

    <!-- themes -->
    <link rel="stylesheet" href="{{ asset('/assets/css/themes/themes_combined.min.css')}}" media="all">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')

    <!-- Scripts -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}"></script>

    <script>
        if (window.location.href.includes('catalog'))
        {
            var meta = document.createElement('meta');
            meta.httpEquiv = "cache-control";
            meta.content = "no-cache";
            document.getElementsByTagName('head')[0].appendChild(meta);
            var meta2 = document.createElement('meta');
            meta2.httpEquiv = "expires";
            meta2.content = "0";
            document.getElementsByTagName('head')[0].appendChild(meta2);
            var meta3 = document.createElement('meta');
            meta3.httpEquiv = "pragma";
            meta3.content = "no-cache";
            document.getElementsByTagName('head')[0].appendChild(meta3);
        }
    </script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        var API_PATH = '{{ env('API_PATH') }}';
          var APP_PATH = '{{ env('APP_URL') }}';

        var user_id = {{ Auth::id() }};

		var customer_id = {{ session('customer_id',0) }};
        var customer_name = '{{ session('customer_name','') }}';
        var role_id='{{ @\App\RoleUser::where('user_id',Auth::id())->first()->role_id }}';
    </script>

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
    <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
    <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <link rel="stylesheet" href="assets/css/ie.css" media="all">
    <![endif]-->
</head>
<body class="sidebar_main_open sidebar_main_swipe {{ empty(Auth::user()) ? 'sidebar_mini'  : (Auth::user()->sidebar == 'sidebar_mini' || empty(Auth::user()->sidebar)) ? 'sidebar_mini' : 'sidebar_main_open' }} {{ empty(Auth::user())? 'app_theme_dark' : Auth::user()->theme }} header_full">
<!-- main header -->
<header id="header_main">


    <div class="header_main_content">
        <nav class="uk-navbar">
            <div class="main_logo_top">
                <a href="/dashboard">
                    @if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_default')
                        <img src="{{ URL::to('/') }}/assets/img/logo.png" alt="" height="15" width="71">
                    @else
                        <img src="{{ URL::to('/') }}/assets/img/logo_b.png" alt="" height="15" width="71">
                    @endif
                </a>
            </div>

            <div class="uk-navbar-flip">
                <div class="uk-modal" id="modal_customer_selection">
                    <div class="uk-modal-dialog">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <select id="optionsCustomerSelection" class="md-input" data-csrf="{{ csrf_token() }}">
                            <option value="-1" disabled selected hidden>{{ __('header.select_a_customer') }}...</option>

                        </select>
                        <div id="customerForSelection">


                        </div>
                    </div>
                </div>

                <div class="uk-modal" id="modal_project_selection">
                    <div class="uk-modal-dialog">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <select id="optionsProjectSelection" class="md-input" data-csrf="{{ csrf_token() }}">
                            <option value="-1" disabled selected hidden>{{ __('header.select_a_project') }}...</option>

                        </select>
                        <div id="customerForSelection">


                        </div>
                    </div>
                </div>

                <div class="uk-modal" id="modal_project_selection">
                    <div class="uk-modal-dialog">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <select id="optionsProjectSelection" class="md-input" data-csrf="{{ csrf_token() }}">
                            <option value="-1" disabled selected hidden>{{ __('header.select_a_project') }}...</option>
                        </select>
                        <div id="projectsForSelection"></div>
                    </div>
                </div>


                {{-- <div id="modal_about" class="uk-modal">
                    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">{{__('header.about') }}</h2>
                        </div>
                        <div class="uk-modal-body">
                            <iframe src="{{url('/about')}}"  width="100%" frameborder="0"  uk-responsive></iframe>
                        </div>
                        <div class="uk-modal-footer uk-text-right">
                            <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>

                        </div>

                    </div>
                </div>

                <div id="modal_credit" class="uk-modal">
                    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">{{__('header.credit') }}</h2>
                        </div>
                        <div class="uk-modal-body">
                            <iframe src="{{url('/credit')}}"  frameborder="0"  uk-responsive></iframe>
                        </div>
                        <div class="uk-modal-footer uk-text-right">
                            <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>
                        </div>

                    </div>
                </div> --}}
                <!-- Modal de Guia de Task Control Getting Started -->
                <div id="modal_started" class="uk-modal">
                    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">{{__('header.option') }}</h2>
                        </div>
                        <div class="uk-modal-footer uk-text-right">
                            <a style="color: black" type="button" class="uk-button uk-button-default" href="{{url('/started')}}">{{__('header.see')}}</a>
                            @if(app()->getLocale() == 'en')
                                <a style="color: black" class="uk-button uk-button-default" href="{{url('/download/English/GETTING-STARTED-GUIDE.pdf')}}">{{__('header.download')}}</a>
                            @else
                                <a style="color: black" class="uk-button uk-button-default" href="{{url('/download/Spanish/TASKCONTROL-GETTING-STARTED.pdf')}}">{{__('header.download')}}</a>
                            @endif
                        </div>

                    </div>
                </div>
                <!-- Modal de Guia de Task Control Guia de Kpis -->
                <div id="modal_kpis" class="uk-modal">
                    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">{{__('header.option') }}</h2>
                        </div>
                        <div class="uk-modal-footer uk-text-right">
                            <a style="color: black" type="button" class="uk-button uk-button-default" href="{{url('/help-kpis')}}">{{__('header.see')}}</a>
                            @if(app()->getLocale() == 'en')
                                <a style="color: black" type="button" class="uk-button uk-button-default" href="{{url('/download/English/TASKCONTROL-BASIC-KPIs-GUIDE.pdf')}}">{{__('header.download')}}</a>
                            @else
                                <a style="color: black" type="button" class="uk-button uk-button-default" href="{{url('/download/Spanish/TASKCONTROL-GUIA-DE-KPIs.pdf')}}">{{__('header.download')}}</a>
                            @endif
                        </div>

                    </div>
                </div>
                <!-- Modal de Guia de Task Control del Admin -->
                <div id="modal_admin" class="uk-modal">
                    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">{{__('header.option') }}</h2>
                        </div>
                        <div class="uk-modal-footer uk-text-right">
                            <a style="color: black" class="uk-button uk-button-default" href="{{url('/admin')}}">{{__('header.see')}}</a>
                            @if(app()->getLocale() == 'en')
                                <a style="color: black" class="uk-button uk-button-default" href="{{url('download/English/TASKCONTROL-ADMIN-GUIDE.pdf')}}">{{__('header.download')}}</a>
                            @else
                                <a style="color: black" class="uk-button uk-button-default" href="{{url('download/Spanish/TASKCONTROL-GUIA-DEL-ADMIN.pdf')}}">{{__('header.download')}}</a>
                            @endif
                        </div>

                    </div>
                </div>
                <!-- Modal de Guia de Task Control Del Usuario -->
                <div id="modal_users" class="uk-modal">
                    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">{{__('header.option') }}</h2>
                        </div>
                        <div class="uk-modal-footer uk-text-right">
                            <a style="color: black" class="uk-button uk-button-default" href="{{url('/guie-users')}}">{{__('header.see')}}</a>
                            @if(app()->getLocale() == 'en')
                                <a style="color: black" class="uk-button uk-button-default" href="{{url('/download/English/TASKCONTROL-USER-GUIDE.pdf')}}">{{__('header.download')}}</a>
                            @else
                                <a style="color: black" class="uk-button uk-button-default" href="{{url('/download/Spanish/TASKCONTROL-GUIA-DEL-USUARIO.pdf')}}">{{__('header.download')}}</a>
                            @endif
                        </div>

                    </div>
                </div>



                <ul class="uk-navbar-nav user_actions">

                    @if (@\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id==1)

                        <li id="name">

                            SUPERUSER: <strong>{{ Auth::user()->email }}</strong>

                        </li>
                    @endif
                    @if (\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id==2)
                        <li id="name">

                            ADMIN: <strong>{{ strtoupper(Auth::user()->email) }}</strong>

                        </li>
                       {{-- <li id="name">

                            CUSTOMER: <strong>ALL</strong>

                        </li>--}}
                    @endif
                    @if (\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id>2)
                        <li id="name">
                            USER: <strong>{{ strtoupper(Auth::user()->email)  }} </strong>
                        </li>

                        <li id="name">
                            ROLE:
                            <strong>{{ strtoupper(\App\Role::find(\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id)->name) }}</strong>
                        </li>
                        {{-- <li id="name">

                            CUSTOMER: <strong>{{ strtoupper(session('customer_id')!='' ? \App\Customer::find(session('customer_id'))->name : __('sidebar.all_project')) }}</strong>

                        </li> --}}
                    @endif
                    @if (\App\Role::find(\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id)->name!='Admin')
                        <li id="customer_selection">
                            <a href="#" data-uk-modal="{target:'#modal_customer_selection'}">CUSTOMER:
                                <strong> {{ strtoupper(session('customer_name', __('sidebar.no_customer_selected')))  }}</strong>
                            </a>
                        </li>
                    @endif
                    @if (\App\Role::find(\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id)->name!='Admin')

                        <li id="project_selection">
                            <a href="#" data-uk-modal="{target:'#modal_project_selection'}">PROJECT:
                                <strong> {{ strtoupper(session('project_name', __('sidebar.no_project_selected')))  }}</strong>
                            </a>
                        </li>
                    @endif


                    <li title="{{__('general.profile')}}" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <a href="#" class="user_action_image">
                            @if (empty(Auth::user()->profile_image_path))
                                <img class="md-user-image"
                                     src="{{ URL::to('/') }}/assets/img/avatardefault.png">
                            @else
                                <img class="md-user-image"
                                     src="{{ URL::to('/') .'/assets/img/users/profile/'.Auth::user()->id.'/'.Auth::user()->profile_image_path }}">


                            @endif
                        </a>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav js-uk-prevent">
                                <li><a href="{{ url('profile') }}">{{ __('header.profile') }}</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
	                                                 document.getElementById('logout-form').submit();">
                                        {{ __('login.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li title="{{__('general.help')}}"  data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <a href="#" class=""><i class="fa fa-question-circle fa-3x" aria-hidden="true"></i></a>

                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav js-uk-prevent">
                                {{-- <li><a href="{{ url('/help') }}">{{ __('header.help') }}</a></li> --}}
                                {{-- <li><a class="info-modal" href="{{ url('/credit') }}" data-uk-modal="{target:'#modal_info'}">{{ __('header.credit') }}</a></li> --}}
                                <!-- Archivos para ver o descargar -->
                                <li><a href="#" data-uk-modal="{target:'#modal_started'}">{{ __('header.getting_started_guide') }}</a></li>
                                <li><a href="#" data-uk-modal="{target:'#modal_admin'}">{{ __('header.guia_admin') }}</a></li>
                                <li><a href="#" data-uk-modal="{target:'#modal_users'}">{{ __('header.guia_users') }}</a></li>
                                <li><a href="#" data-uk-modal="{target:'#modal_kpis'}">{{ __('header.guia_kpis') }}</a></li>
                                <li><a class="info-modal" href="{{ url('/about') }}" data-uk-modal="{target:'#modal_info'}">{{ __('header.about') }}</a></li>
                            </ul>
                        </div>
                    </li>
                    <li title="{{__('general.languages')}}"  data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <a href="#" class=""><i class="fa fa-language fa-3x" aria-hidden="true"></i></a>

                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav js-uk-prevent">
                               <li><a href="{{ url('locale/en') }}" >{{__('general.english')}}</a></li>

                                <li><a href="{{ url('locale/es') }}" >{{__('general.spanish')}}</a></li>   
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="section_title">
                @yield('section_title')
                @if (!empty($favoriteTitle))
                    <a href="#" id="favoriteLink" data-favorite-title="{{ $favoriteTitle }}" data-favorite-url="{{ $favoriteUrl }}">
                       @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('1'))
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                        @endif
                    </a>
                @endif
            </div>
        </nav>
    </div>
</header><!-- main header end -->

<!-- main sidebar -->
<aside id="sidebar_main">
{{-- {{dump(request()->routeIs('contacts'))}} --}}
    <div class="menu_section_alternative">
        <ul id="kUI_menu" class="k-widget k-reset k-header k-menu k-menu-vertical">

            @php
                $class = (
                            Request::is('companies') || Request::is('offices') ||
                            Request::is('departments') || Request::is('project_roles') ||
                            Request::is('seniorities') || Request::is('workgroups') ||
                            Request::is('holidays') || Request::is('absence_types') ||
                            Request::is('cities') || 
                            // Request::is('customers') || Request::is('projects') ||
                            Request::is('company_roles') ||
                            Request::is('permissions')
                        ) ? 'current_section' : '';
            @endphp
            <!-- Item Organization -->
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('1'))
                <li class="{{$class}} k-item k-state-default k-first">
                    
                    <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.organization') }}" data-uk-tooltip="{pos:'top-left'}">
                        <i class="fa fa-sitemap fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.organization') }}</span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>

                    <ul class="second_level list-organization k-group k-menu-group">
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.my_company') }}" class="{{ (Request::is('companies') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('companies') }}">{{ __('sidebar.my_company') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.offices') }}" class="{{ (Request::is('offices') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('offices') }}">{{ __('sidebar.offices') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.departments') }}" class="{{ (Request::is('departments') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('departments') }}">{{ __('sidebar.departments') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.project_roles') }}" class="{{ (Request::is('project_roles') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('project_roles') }}">{{ __('sidebar.project_roles') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.seniorities') }}" class="{{ (Request::is('seniorities') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('seniorities') }}">{{ __('sidebar.seniorities') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.workgroups') }}" class="{{ (Request::is('workgroups') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('workgroups') }}">{{ __('sidebar.workgroups') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.holidays') }}" class="{{ (Request::is('holidays') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('holidays') }}">{{ __('sidebar.holidays') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.absence_types') }}" class="{{ (Request::is('absence_types')? 'select_active' : '') }} title-organization">
                            <a href="{{ url('absence_types') }}">{{ __('sidebar.absence_types') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.cities') }}" class="{{ (Request::is('cities') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('cities') }}">{{ __('sidebar.cities') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.company_roles') }}" class="{{ (Request::is('company_roles') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('company_roles') }}">{{ __('sidebar.company_roles') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.permissions') }}" class="{{ (Request::is('permissions') ? 'select_active' : '') }} title-organization">
                            <a href="{{ url('permissions') }}">{{ __('sidebar.permissions') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @php
                $class = (
                            Request::is('exchange_rates') ||
                            Request::is('rates') ||
                            Request::is('costs') ||
                            Request::is('expenses') ||
                            Request::is('debit_credit') ||
                            Request::is('discounts') ||
                            Request::is('taxes')
                        ) ? 'current_section' : '';
            @endphp
            <!-- Item Finacial -->
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('1'))
                <li class="{{$class}} k-item k-state-default">

                    <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.financial') }}" data-uk-tooltip="{pos:'top-left'}">
                        <i class="fa fa-money fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.financial') }}</span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>

                    <ul class="second_level list-financial k-group k-menu-group">
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.exchange_rates') }}" class="{{ (Request::is('exchange_rates') ? 'select_active' : '') }} title-financial">
                            <a href="{{ url('exchange_rates') }}">{{ __('sidebar.exchange_rates') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.rates') }}" class="{{ (Request::is('rates') ? 'select_active' : '') }} title-financial">
                            <a href="{{ url('rates') }}">{{ __('sidebar.rates') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.costs') }}" class="{{ (Request::is('costs') ? 'select_active' : '') }} title-financial">
                            <a href="{{ url('costs') }}">{{ __('sidebar.costs') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.expenses') }}" class="{{ (Request::is('expenses') ? 'select_active' : '') }} title-financial">
                            <a href="{{ url('expenses') }}">{{ __('sidebar.expenses') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.debit_credit') }}" class="{{ (Request::is('debit_credit') ? 'select_active' : '') }} title-financial">
                            <a href="{{ url('debit_credit') }}">{{ __('sidebar.debit_credit') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.discounts') }}" class="{{ (Request::is('discounts') ? 'select_active' : '') }} title-financial">
                            <a href="{{ url('discounts') }}">{{ __('sidebar.discounts') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.taxes') }}" class="{{ (Request::is('taxes') ? 'select_active' : '') }} title-financial">
                            <a href="{{ url('taxes') }}">{{ __('sidebar.taxes') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @php
                $class = (
                            Request::is('providers') ||
                            Request::is('users') ||
                            Request::is('team_users') ||
                            Request::is('customers')
                        ) ? 'current_section' : '';
            @endphp
            <!-- Item Resources -->
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('1'))
                <li class="{{$class}} k-item k-state-default">

                    <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.resources') }}" data-uk-tooltip="{pos:'top-left'}">
                        <i class="fa fa-users fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.resources') }}</span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>

                    <ul class="second_level list-resources k-group k-menu-group">
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.providers') }}" class="{{ (Request::is('providers') ? 'select_active' : '') }} title-resources">
                            <a href="{{ url('providers') }}">{{ __('sidebar.providers') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.users') }}" class="{{ (Request::is('users') ? 'select_active' : '') }} title-resources">
                            <a href="{{ url('users') }}">{{ __('sidebar.users') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.members') }}" class="{{ (Request::is('team_users') ? 'select_active' : '') }} title-resources">
                            <a href="{{ url('team_users') }}">{{ __('sidebar.members') }}</a>
                        </li>

                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.customers') }}" class="{{ (Request::is('customers') ? 'select_active' : '') }} title-resources"
                            title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar.customers') }}">
                            <a href="{{ url('customers') }}">
                                {{ __('sidebar.customers') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <!-- Item Servies -->
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('1'))
                <li class="{{ Active::check('services', true) }} data-title title-tooltip k-item k-state-default" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.services') }}">
                    <a href="{{ url('services') }}" class="k-link">
                        <i class="fa fa-list-ol fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.services') }}</span>
                    </a>
                </li>
            @endif
            <!-- Item Materials -->
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('1'))
                <li class="{{ Active::check('materials', true) }} data-title title-tooltip k-item k-state-default" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.materials') }}">
                    <a href="{{ url('materials') }}" class="k-link">
                        <i class="fa fa-list-ul fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.materials') }}</span>
                    </a>
                </li>
            @endif

            @php
                $class = (
                            Request::is('catalog') ||
                            Request::is('emails') ||
                            Request::is('kpis_category') ||
                            Request::is('kpis') ||
                            Request::is('projects')
                        ) ? 'current_section' : '';
            @endphp
            <!-- Item Projects -->
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('1'))
                <li class="{{$class}} k-item k-state-default">

                    <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.projects') }}" data-uk-tooltip="{pos:'top-left'}">
                        <i class="fa fa-suitcase fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.projects') }}</span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>

                    <ul class="second_level list-projects k-group k-menu-group">
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.catalog') }}" class="{{ (Request::is('catalog') ? 'select_active' : '') }} title-projects">
                            <a href="{{ url('catalog') }}">{{ __('sidebar.catalog') }}</a>
                        </li>
                        @if (Auth::user()->hasPermission('view.emails') || Auth::user()->hasPermission('edit.articles') || Auth::user()->hasRole('user'))
                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.emails') }}" class="{{ (Request::is('emails') ? 'select_active' : '') }} title-projects">
                                <a href="{{ url('emails') }}">{{ __('sidebar.emails') }}</a>
                            </li>
                        @endif

                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.kpis_category') }}" class="{{ (Request::is('kpis_category') ? 'select_active' : '') }} title-projects">
                            <a href="{{ url('kpis_category') }}">{{ __('sidebar.kpis_category') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.kpis') }}" class="{{ (Request::is('kpis') ? 'select_active' : '') }} title-projects">
                            <a href="{{ url('kpis') }}">{{ __('sidebar.kpis') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.projects') }}" class="{{ (Request::is('projects') ? 'select_active' : '') }} title-projects">
                            <a href="{{ url('projects') }}">{{ __('sidebar.projects') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @php
                $class = (
                            Request::is('repository_backup') ||
                            Request::is('audit_log')
                        ) ? 'current_section' : '';
            @endphp
            <!-- Item System Settings -->
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('1'))
                <li class="{{$class}} k-item k-state-default k-last">

                    <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.systemsettings') }}" data-uk-tooltip="{pos:'top-left'}">
                        <i class="fa fa-cog fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.systemsettings') }}</span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>

                    <ul class="second_level list-settings k-group k-menu-group">
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.repository_backup') }}" class="{{ (Request::is('repository_backup') ? 'select_active' : '') }} title-settings">
                            <a href="{{ url('repository_backup') }}">{{ __('sidebar.repository_backup') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.audit_log') }}" class="{{ (Request::is('audit_log') ? 'select_active' : '') }} title-settings">
                            <a href="{{ url('audit_log') }}">{{ __('sidebar.audit_log') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            <!-- ============================================================== -->
           
            <!-- Item Favorito -->
            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1'))
                <li class="k-item k-state-default k-first">
                    <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.favorites') }}" data-uk-tooltip="{pos:'top-left'}">
                        <i class="fa fa-star fa-15" aria-hidden="true"></i>
                        <span class="menu_title"><a>{{ __('sidebar.favorites') }}</a></span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>

                    <ul class="second_level list-favorite k-group k-menu-group">
                        <li>
                            {{ __('sidebar.favorites') }}
                        </li>
                        @if (!empty($favorites))
                            @foreach ($favorites as $favorite)
                                <li class="title-favorite" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : $favorite['title'] }}">
                                    <a href="{{ $favorite['url'] }}">{{ $favorite['title'] }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            @endif
            <!-- Item Notes -->
            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1'))
                <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' : __('sidebar.notes') }}" class="{{ Active::check('notes', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('notes') }}" class="k-link">
                        <i class="fa fa-sticky-note-o fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.notes') }}</span>
                    </a>
                </li>
            @endif
            <!-- Item Contacts -->
            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1'))
                <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' : __('sidebar.contacts') }}" class="{{ Active::check('contacts', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('contacts') }}" class="k-link">
                        <i class="fa fa-address-book-o fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.contacts') }}</span>
                    </a>
                </li>
            @endif
            <!-- Item Agenda -->
            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1') && Auth::user()->hasPermission('view.agenda'))
                <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' : __('sidebar.agenda') }}" class="{{ Active::check('agendas', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('agendas') }}" class="k-link">
                        <i class="fa fa-calendar fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.agenda') }}</span>
                    </a>
                </li>
            @endif
            <!-- Item Emails -->
            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1'))
                <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' : __('sidebar.emails') }}" class="{{ Active::check('emails', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('emails') }}" class="k-link">
                        <i class="fa fa-envelope-open fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.emails') }}</span>
                    </a>
                </li>
            @endif
            <!-- Item Gantt -->
            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1') && Auth::user()->hasPermission('view.gantt'))
                @php
                    $class = (
                        Request::is('tasks') ||
                        Request::is('whatif')
                    ) ? 'current_section' : '';
                @endphp
                <li class="{{$class}} k-item k-state-default">
                    <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.tasks') }}" data-uk-tooltip="{pos:'top-left'}">
                        <i class="fa fa-tasks fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.tasks') }}</span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>

                    <ul class="second_level list-gantt k-group k-menu-group">
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.tasks') }}" class="{{ (Request::is('tasks') ? 'select_active' : '') }} title-gantt">
                            <a href="{{ url('tasks') }}">{{ __('sidebar.tasks') }}</a>
                        </li>
                        <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.whatif')}}" class="{{ (Request::is('whatif') ? 'select_active' : '') }} title-gantt">
                            <a href="{{ url('whatif') }}">{{ __('sidebar.whatif') }}</a>
                        </li>
                    </ul>
                </li>
                
                @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1'))
                    <li class="{{ Active::check('workboard', true) }} title-tooltip k-item k-state-default" data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' : __('sidebar.workboard') }}">
                        <a href="{{ url('workboard') }}" class="k-link">
                            <i class="fa fa-list fa-15" aria-hidden="true"></i>
                            <span class="menu_title">{{ __('sidebar.workboard') }}</span>
                        </a>
                    </li>   
                @endif
            
                @if (Auth::user()->hasPermission('view.catalog'))
                    <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' : __('sidebar.catalog') }}" class="{{ (Route::is('catalog') ? 'active' : '') }} title-tooltip k-item k-state-default">
                        <a href="{{ url('catalog') }}" class="k-link">
                            <i class="fa fa-list-alt fa-15" aria-hidden="true"></i>
                            <span class="menu_title">{{ __('sidebar.catalog') }}</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasPermission('view.repository'))
                    <li class="{{ Request::is('repository') ? 'active' : '' }} title-tooltip k-item k-state-default" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}">
                        <a href="{{ url('repository') }}" class="k-link">
                            <i class="fa fa-cloud fa-15" aria-hidden="true"></i>
                            <span class="menu_title">{{ __('sidebar.repository') }}</span>
                        </a>
                    </li>
                @endif
            @endif
            <!--Knowledge Areas-->
            @if(\App\Settings::find(1)->knowledge_areas_active=='1')

                @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1'))
                    @php
                            
                    @endphp

                    <li class="knowledge_area k-item k-state-default">
                        
                        <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Knowledge_Areas') }}" data-uk-tooltip="{pos:'top-left'}">
                            <i class="fa fa-object-group fa-15" aria-hidden="true"></i>
                            <span class="menu_title">{{ __('sidebar.knowledge_areas') }}</span>
                            <span class="k-icon k-i-arrow-e"></span>
                        </span>

                        <ul class="second_level list-knowledge-area k-group k-menu-group">
                            <!-- Integration Management -->
                            <li class="integration_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Integration_Management') }}">
                                    {{__('sidebar.Integration_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">

                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}"  title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Document_Generation_IM') }}" class="title-knowledge {{ (Request::is('catalog/integration_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.initial')) ? 'select_active' : '') }}">
                                            <a href="{{ url('catalog') }}/integration_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.initial')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}"  title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="title-knowledge {{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.initial').'/'.__('sidebar.integration_management').'/'.__('sidebar.others')) ? 'select_active' : '') }}">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.initial')}}/{{__('sidebar.integration_management')}}/{{__('sidebar.others')}}">{{ __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.quotations'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Quotations_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/integration_management/quotation') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/integration_management/quotation') }}">{{ __('sidebar.quotations') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.contracts'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Contracts_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/integration_management/contracts') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/integration_management/contracts') }}">{{ __('sidebar.contracts') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.projects'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Projects_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/integration_management/projects') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/integration_management/projects') }}">{{ __('sidebar.projects') }}</a>
                                        </li>
                                    @endif

                                    <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_backup_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/repository_backup') ? 'select_active' : '') }}">
                                        <a href="{{ url('main-menu/knowledge_area/repository_backup') }}">{{ __('sidebar.repository_backup') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Scope Management -->
                            <li class="scope_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Scope_Management') }}">
                                    {{__('sidebar.Scope_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}"  title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Document_Generation_SM') }}" class="title-knowledge {{ (Request::is('catalog/scope_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }}">
                                            <a href="{{ url('catalog') }}/scope_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif
                                    
                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}"  title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="title-knowledge {{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.initial').'/'.__('sidebar.scope_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }}">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.initial')}}/{{__('sidebar.scope_management')}}/{{__('sidebar.urgent')}}">{{ __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.requirements'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Requirements_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/scope_management/requirements') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/scope_management/requirements') }}">{{ __('sidebar.requirements') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.contracts'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Contracts_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/scope_management/contracts') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/scope_management/contracts') }}">{{ __('sidebar.contracts') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.kpis'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Scope_Report_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/scope_management/scopechanges_report') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/scope_management/scopechanges_report') }}">{{ __('sidebar.scope_change_request_report') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Time Management -->
                            <li class="time_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Time_Management') }}">
                                    {{__('sidebar.Time_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}"  title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Document_Generation_TM') }}" class="title-knowledge {{ (Request::is('catalog/time_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }}">
                                            <a href="{{ url('catalog') }}/time_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="title-knowledge {{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.Monitoring_Control').'/'.__('sidebar.time_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }}">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.Monitoring_Control')}}/{{__('sidebar.time_management')}}/{{__('sidebar.urgent')}}">{{ __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if(session('project_id'))
                                       @if (Auth::user()->hasPermission('view.projects'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Sprints_ka') }}" class="title-knowledge {{ (Request::is('sprints/'.session('project_id').'/time_management') ? 'select_active' : '') }}">
                                                <a href="{{ url('sprints')}}/{{session('project_id')}}/time_management">{{ __('sidebar.sprints') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        @if (Auth::user()->hasPermission('view.projects'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Projects_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/time_management/projects') ? 'select_active' : '') }}">
                                                <a href="{{ url('main-menu/knowledge_area/time_management/projects') }}">{{ __('sidebar.projects') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.capacityplanning'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Team_Capacity_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/time_management/capacity_planning') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/time_management/capacity_planning') }}">{{ __('sidebar.team_capacity') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.taskstatusreport'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.task_status_report') }}"  class="title-knowledge {{ (Request::is('main-menu/knowledge_area/reports/tasks') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/reports/tasks') }}">{{ __('sidebar.task_status_report') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.kpis'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.KPIS_Report_Time_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/time_management/kpis_functions') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/time_management/kpis_functions') }}">{{ __('sidebar.KPIS_Report_Time') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Cost Management -->
                            <li class="cost_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Cost_Management') }}">
                                    {{__('sidebar.Cost_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Document_Generation_CM') }}" class="{{ (Request::is('catalog/cost_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('catalog') }}/cost_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="{{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.planning').'/'.__('sidebar.cost_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }} title-knowledge">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.planning')}}/{{__('sidebar.cost_management')}}/{{__('sidebar.urgent')}}">{{ __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.forecast'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Forecast_Report_pg') }}" class="{{ (Request::is('main-menu/knowledge_area/forecast') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/forecast') }}">{{ __('sidebar.forecast') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.profitandloss'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Profit_&_Loss_pg') }}"  class="{{ (Request::is('main-menu/knowledge_area/profit_and_loss') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/profit_and_loss') }}">{{ __('sidebar.profit_and_loss') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.workinghours'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Working_Hours_pg') }}" class="{{ (Request::is('main-menu/knowledge_are/cost_management/working_hours') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_are/cost_management/working_hours') }}">{{ __('sidebar.working_hours') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.profitandloss'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Project_board_ka') }}" class="{{ (Request::is('main-menu/knowledge_area/project_board/project_rows') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/project_board/project_rows') }}">{{ __('sidebar.project_board') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.invoices'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Invoices_pg') }}" class="{{ (Request::is('main-menu/knowledge_area/invoices') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/invoices') }}">{{ __('sidebar.invoices') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.kpis'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.KPIS_Report_Time_ka') }}" class="{{ (Request::is('main-menu/knowledge_area/cost_management/kpis_functions') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/cost_management/kpis_functions') }}">{{ __('sidebar.kpis') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Quality Management -->
                            <li class="quality_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Quality_Management') }}">
                                    {{__('sidebar.Quality_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}"  title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Document_Generation_QM') }}" class="{{ (Request::is('catalog/quality_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('catalog') }}/quality_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="{{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.planning').'/'.__('sidebar.quality_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }} title-knowledge">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.planning')}}/{{__('sidebar.quality_management')}}/{{__('sidebar.urgent')}}">{{ __('sidebar.repository')}}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.kpis'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.KPIS_Report_QM') }}" class="{{ (Request::is('main-menu/knowledge_area/quality_management/kpis_functions') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/quality_management/kpis_functions') }}">{{ __('sidebar.kpis') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Team Management -->
                            <li class="team_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Team_Management') }}">
                                    {{__('sidebar.Team_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Document_Generation_RM') }}" class="{{ (Request::is('catalog/team_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('catalog') }}/team_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="{{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.planning').'/'.__('sidebar.team_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }} title-knowledge">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.planning')}}/{{__('sidebar.team_management')}}/{{__('sidebar.urgent')}}">{{ __('sidebar.repository')}}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.capacityplanning'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Team_Capacity_pg') }}" class="{{ (Request::is('main-menu/knowledge_area/team_management/capacity_planning') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/team_management/capacity_planning') }}">{{ __('sidebar.team_capacity') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.members'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Members_ka') }}" class="{{ (Request::is('main-menu/knowledge_area/team_management/team_users') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/team_management/team_users') }}">{{ __('sidebar.members') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.absences'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Absences_ka') }}" class="{{ (Request::is('main-menu/knowledge_area/absences') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/absences') }}">{{ __('sidebar.absences') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.replacements'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Replacements_ka') }}" class="{{ (Request::is('main-menu/knowledge_area/replacements') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/replacements') }}">{{ __('sidebar.replacements') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.additionalhours'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Additionals_Hours_ka') }}" class="{{ (Request::is('main-menu/knowledge_area/additional_hours') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/additional_hours') }}">{{ __('sidebar.additional_hours') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.kpis'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.KPIS_Report_RM') }}" class="{{ (Request::is('main-menu/knowledge_area/team_management/kpis_functions') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/team_management/kpis_functions') }}">{{ __('sidebar.kpis') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.users'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Users_ka_wf') }}" class="{{ (Request::is('main-menu/knowledge_area/team_management/users') ? 'select_active' : '') }} title-knowledge">
                                            <a href="{{ url('main-menu/knowledge_area/team_management/users') }}">{{ __('sidebar.users') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Communication Management -->
                            <li class="communication_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Communication_Management') }}">
                                    {{__('sidebar.Communication_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Document_Generation_CM') }}" class="title-knowledge {{ (Request::is('catalog/communication_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }}">
                                            <a href="{{ url('catalog') }}/communication_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="title-knowledge {{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.planning').'/'.__('sidebar.communication_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }}">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.planning')}}/{{__('sidebar.communication_management')}}/{{__('sidebar.urgent')}}">{{  __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </li>
                            <!-- Risk Management -->
                            <li class="risk_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Risk_Management') }}">
                                    {{__('sidebar.Risk_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :  __('sidebar_tooltip.Document_Generation_RIM') }}" class="title-knowledge {{ (Request::is('catalog/risk_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }}">
                                            <a href="{{ url('catalog') }}/risk_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}"  title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="title-knowledge {{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.planning').'/'.__('sidebar.risk_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }}">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.planning')}}/{{__('sidebar.risk_management')}}/{{__('sidebar.urgent')}}">{{ __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.projectriskreport'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Risk_Report_ka') }}" class="title-knowledge {{ (Request::is('risk_report') ? 'select_active' : '') }}">
                                            <a href="{{ url('risk_report') }}">{{ __('sidebar.project_risk_report') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.kpis'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.KPIS_Report_RIM') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/risk_management/kpis_functions') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/risk_management/kpis_functions') }}">{{ __('sidebar.kpis') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Stakeholder Management -->
                            <li class="stakeholder_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Stakeholder_Management') }}">
                                    {{__('sidebar.Stakeholder_Management')}}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Document_Generation_SM') }}" class="title-knowledge {{ (Request::is('catalog/stakeholder_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }}">
                                            <a href="{{ url('catalog') }}/stakeholder_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="title-knowledge {{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.planning').'/'.__('sidebar.stakeholder_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }}">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.planning')}}/{{__('sidebar.stakeholder_management')}}/{{__('sidebar.urgent')}}">{{  __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.stakeholders'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.StakeHolders_ka_wf') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/stakeholder_management/stakeholders') ? 'select_active' : '') }}">
                                            <a href="{{ url('main-menu/knowledge_area/stakeholder_management/stakeholders') }}">{{ __('sidebar.stakeholders') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.contacts'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Contacts_ka') }}" class="title-knowledge {{ (Request::is('contacts') ? 'select_active' : '') }}">
                                            <a href="{{ url('contacts') }}">{{ __('sidebar.contacts') }}</a>
                                        </li>
                                    @endif

                                    <li class="title-knowledge {{ (Request::is('customers') ? 'select_active' : '') }}" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.customers') }}">
                                        <a href="{{ url('customers') }}">
                                            {{ __('sidebar.customers') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Procurement Management -->
                            <li class="procurement_management">
                                <span class="k-link title-knowledge-area" data-uk-tooltip="{pos:'top-left'}" title="{{  Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Procurement_Management') }}">
                                    {{ __('sidebar.Procurement_Management') }}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-knowledge-area-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Document_Generation_PM') }}" class="title-knowledge {{ (Request::is('catalog/procurement_management/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }}">
                                            <a href="{{ url('catalog') }}/procurement_management/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title ="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="title-knowledge {{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.planning').'/'.__('sidebar.procurement_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }}">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.planning')}}/{{__('sidebar.procurement_management')}}/{{__('sidebar.urgent')}}">{{  __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Procurements_ka') }}" class="title-knowledge {{ (Request::is('main-menu/knowledge_area/procurements') ? 'select_active' : '') }}">
                                        <a href="{{ url('main-menu/knowledge_area/procurements') }}">{{ __('sidebar.procurements') }}</a>
                                    </li>

                                    <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Providers_ka') }}" class="{{ (Request::is('providers') ? 'select_active' : '') }} title-knowledge">
                                        <a href="{{ url('providers') }}">{{ __('sidebar.providers') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                @endif
            @endif

            <!-- Process Group-->
            @if(\App\Settings::find(1)->process_group_active=='1')

                @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !Auth::user()->hasRole('1'))
                    @php
                        
                    @endphp
                    <li class="process_group k-item k-state-default">
                        
                        <span class="k-link title-tooltip" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.process_by_group') }}" data-uk-tooltip="{pos:'top-left'}">
                            <i class="fa fa-object-group fa-15" aria-hidden="true"></i>
                            <span class="menu_title">{{ __('sidebar.process_by_group') }}</span>
                            <span class="k-icon k-i-arrow-e"></span>
                        </span>

                        <ul class="second_level list-process-group k-group k-menu-group">
                            <!-- Initiating -->
                            <li class="Initiating">
                                <span class="k-link title-process-group" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Initiating') }}">
                                    {{ __('sidebar.Initiating') }}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-process-group-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}"  title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Document_Generation_I') }}" class="{{ (Request::is('catalog/initiating/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.initial')) ? 'select_active' : '') }} data-title">
                                           <a href="{{ url('catalog') }}/initiating/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.initial')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ?  '' :__('sidebar_tooltip.Repository_ka') }}" class="{{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.initial').'/'.__('sidebar.integration_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.initial')}}/{{__('sidebar.integration_management')}}/{{__('sidebar.urgent')}}">{{  __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.contracts'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Contracts_pg') }}" class="{{ (Request::is('main-menu/process_group/initiating/contracts') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/initiating/contracts') }}">{{ __('sidebar.contracts') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.requirements'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Requirements_pg') }}" class="{{ (Request::is('main-menu/process_group/initiating/requirements') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/initiating/requirements') }}">{{ __('sidebar.requirements') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.stakeholders'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.StakeHolders_ka') }}" class="{{ (Request::is('main-menu/process_group/initiating/stakeholders') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/initiating/stakeholders') }}">{{ __('sidebar.stakeholders') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.projects'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Project_pg') }}" class="{{ (Request::is('main-menu/process_group/initiating/projects') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/initiating/projects') }}">{{ __('sidebar.projects') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.members'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Members_pg') }}" class="{{ (Request::is('main-menu/process_group/initiating/team_users') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/initiating/team_users') }}">{{ __('sidebar.members') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.quotations'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Quotations_pg')}}" class="{{ (Request::is('main-menu/process_group/initiating/quotation') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/initiating/quotation') }}">{{ __('sidebar.quotations') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Planning -->
                            <li class="Planning">
                                <span class="k-link title-process-group" title="{{ Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Planning') }}" data-uk-tooltip="{pos:'top-left'}">
                                    {{ __('sidebar.Planning') }}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-process-group-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Document_Generation_P') }}" class="{{ (Request::is('catalog/planning/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.planning')) ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('catalog') }}/planning/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.planning')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="{{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.planning').'/'.__('sidebar.integration_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.planning')}}/{{__('sidebar.integration_management')}}/{{__('sidebar.urgent')}}">{{  __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if(session('project_id'))
                                        @if (Auth::user()->hasPermission('view.projects'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Sprints_pg') }}" class="{{ (Request::is('sprints/'.session('project_id').'/planning') ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('sprints')}}/{{session('project_id')}}/planning">{{ __('sidebar.sprints') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        @if (Auth::user()->hasPermission('view.projects'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Project_pg') }}" class="{{ (Request::is('main-menu/process_group/planning/projects') ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('main-menu/process_group/planning/projects') }}">{{ __('sidebar.projects') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.forecast'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Forecast_Report_pg') }}" class="{{ (Request::is('main-menu/process_group/forecast') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/forecast') }}">{{ __('sidebar.forecast') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.users'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Users_pg') }}" class="{{ (Request::is('main-menu/process_group/planning/users') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/planning/users') }}">{{ __('sidebar.users') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Executing -->
                            <li class="Executing">
                                <span class="k-link title-process-group" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Executing') }}" data-uk-tooltip="{pos:'top-left'}">
                                    {{ __('sidebar.Executing') }}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-process-group-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Document_Generation_E') }}" class="{{ (Request::is('catalog/executing/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.executing')) ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('catalog') }}/executing/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.executing')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="{{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.executing').'/'.__('sidebar.integration_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.executing')}}/{{__('sidebar.integration_management')}}/{{__('sidebar.urgent')}}">{{  __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.members'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Members_pg') }}" class="{{ (Request::is('main-menu/process_group/executing/team_users') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/executing/team_users') }}">{{ __('sidebar.members') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.absences'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Absences_pg') }}" class="{{ (Request::is('main-menu/process_group/absences') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/absences') }}">{{ __('sidebar.absences') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.replacements'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Replacements_pg') }}" class="{{ (Request::is('main-menu/process_group/replacements') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/replacements') }}">{{ __('sidebar.replacements') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.additionalhours'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Additionals_Hours_pg') }}" class="{{ (Request::is('main-menu/process_group/additional_hours') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/additional_hours') }}">{{ __('sidebar.additional_hours') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.workinghours'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Working_Hours_pg') }}" class="{{ (Request::is('main-menu/process_group/executing/working_hours') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/executing/working_hours') }}">{{ __('sidebar.working_hours') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.profitandloss'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Profit_&_Loss_pg') }}"  class="{{ (Request::is('main-menu/process_group/profit_and_loss') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/profit_and_loss') }}">{{ __('sidebar.profit_and_loss') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.profitandloss'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Project_board_ka') }}" class="{{ (Request::is('main-menu/process_group/project_board/project_rows') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/project_board/project_rows') }}">{{ __('sidebar.project_board') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.invoices'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Invoices_pg') }}" class="{{ (Request::is('main-menu/process_group/invoices') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/invoices') }}">{{ __('sidebar.invoices') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- Monitoring y Control -->
                            <li class="Monitoring">
                                <span class="k-link title-process-group" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Monitoring_&_Control') }}">
                                    {{ __('sidebar.Monitoring_&_Control') }}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-process-group-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title ="{{Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Document_Generation_MC') }}" class="{{ (Request::is('catalog/monitoring_control/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.Monitoring_Control')) ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('catalog') }}/monitoring_control/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.Monitoring_Control')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title ="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="{{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.Monitoring_Control').'/'.__('sidebar.integration_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.Monitoring_Control')}}/{{__('sidebar.integration_management')}}/{{__('sidebar.urgent')}}">{{  __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.contracts'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title ="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Contracts_pg') }}" class="{{ (Request::is('main-menu/process_group/monitoring_control/contracts') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/monitoring_control/contracts') }}">{{ __('sidebar.contracts') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.capacityplanning'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title ="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Team_Capacity_pg') }}" class="{{ (Request::is('main-menu/process_group/monitoring_control/capacity_planning') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/monitoring_control/capacity_planning') }}">{{ __('sidebar.team_capacity') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.taskstatusreport'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title ="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.task_status_report') }}"  class="{{ (Request::is('main-menu/process_group/reports/tasks') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/reports/tasks/') }}">{{ __('sidebar.task_status_report') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.workinghours'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Working_Hours_pg') }}" class="{{ (Request::is('main-menu/process_group/monitoring_control/working_hours') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/monitoring_control/working_hours') }}">{{ __('sidebar.working_hours') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.kpis'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title ="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.KPIS_Report_pg') }}" class="{{ (Request::is('main-menu/process_group/monitoring_control/kpis_functions') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/monitoring_control/kpis_functions') }}">{{ __('sidebar.kpis') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.stakeholders'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.StakeHolders_ka') }}" class="{{ (Request::is('main-menu/process_group/monitorin_control/stakeholders') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/monitorin_control/stakeholders') }}">{{ __('sidebar.stakeholders') }}</a>
                                        </li>
                                    @endif

                                    <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Procurements_ka') }}" class="{{ (Request::is('main-menu/process_group/procurements') ? 'select_active' : '') }} data-title">
                                        <a href="{{ url('main-menu/process_group/procurements') }}">{{ __('sidebar.procurements') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Closing -->
                            <li class="Closing"> 
                                <span class="k-link title-process-group" data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Closing')}}">
                                    {{ __('sidebar.Closing') }}
                                    <span class="k-icon k-i-arrow-e"></span>
                                </span>
                                <ul class="list-process-group-menu">
                                    @if (Auth::user()->hasPermission('view.catalog'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' : __('sidebar_tooltip.Document_Generation_C') }}" class="{{ (Request::is('catalog/closing/view/'.strtoupper(app()->getLocale()).'/1/'.__('sidebar.closing')) ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('catalog') }}/closing/view/{{strtoupper(app()->getLocale())}}/1/{{__('sidebar.closing')}}">{{ __('sidebar.document_generation') }}</a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('view.repository'))
                                        @if(session('project_id'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_ka') }}" class="{{ (Request::is('repository/view/'.session('customer_name').'/'.session('project_name').'/'.strtoupper(app()->getLocale()).'/'.__('sidebar.closing').'/'.__('sidebar.integration_management').'/'.__('sidebar.urgent')) ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('repository') }}/view/{{session('customer_name')}}/{{session('project_name')}}/{{strtoupper(app()->getLocale())}}/{{__('sidebar.closing')}}/{{__('sidebar.integration_management')}}/{{__('sidebar.urgent')}}">{{  __('sidebar.repository') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('view.users'))
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Users_pg') }}" class="{{ (Request::is('main-menu/process_group/closing/users') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('main-menu/process_group/closing/users') }}">{{ __('sidebar.users') }}</a>
                                        </li>
                                    @endif

                                    @if(session('project_id'))
                                       @if (Auth::user()->hasPermission('view.projects'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Sprints_pg') }}" class="{{ (Request::is('sprints/'.session('project_id').'/closing') ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('sprints')}}/{{session('project_id')}}/closing">{{ __('sidebar.sprints') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        @if (Auth::user()->hasPermission('view.projects'))
                                            <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Project_pg') }}" class="{{ (Request::is('main-menu/process_group/closing/projects') ? 'select_active' : '') }} data-title">
                                                <a href="{{ url('main-menu/process_group/closing/projects') }}">{{ __('sidebar.projects') }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar_tooltip.Repository_backup_ka') }}" class="{{ (Request::is('main-menu/process_group/repository_backup') ? 'select_active' : '') }} data-title">
                                        <a href="{{ url('main-menu/process_group/repository_backup') }}">{{ __('sidebar.repository_backup') }}</a>
                                    </li>
                                    
                                    @if(\App\Settings::find(1)->set=='1')
                                        <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('wiki_tooltip.wiki') }}" class="{{ (Request::is('wiki') ? 'select_active' : '') }} data-title">
                                            <a href="{{ url('wiki') }}">{{ __('sidebar.wiki') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' :__('sidebar.languages') }}" class="{{ Active::check('languages', true) }} title-tooltip k-item k-state-default k-first">
                    <a href="{{ url('languages') }}" class="k-link">
                        <i class="fa fa-language fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.languages') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{Auth::user()->tooltip==0 ? '' :__('sidebar.currencies') }}" class="{{ Active::check('currencies', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('currencies') }}" class="k-link">
                        <i class="fa fa-usd fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.currencies') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.countries') }}" class="{{ (Request::is('countries') ? 'current_section' : '') }} title-tooltip k-item k-state-default">
                    <a href="{{ url('countries') }}" class="k-link">
                        <i class="fa fa-globe fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.countries') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.cities') }}" class="{{ (Request::is('cities_template') ? 'current_section' : '') }} title-tooltip k-item k-state-default">
                    <a href="{{ url('cities_template') }}" class="k-link">
                        <i class="fa fa-map-marker fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.cities') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.holidays') }}" class="{{ (Request::is('holidays_templates') ? 'current_section' : '') }} title-tooltip k-item k-state-default">
                    <a href="{{ url('holidays_templates') }}" class="k-link">
                        <i class="fa fa-calendar-times-o fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.holidays') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.absence_types') }}" class="{{ Active::check('absence_types_template', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('absence_types_template') }}" class="k-link">
                        <i class="fa fa-calendar-minus-o fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.absence_types') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.industries') }}" class="{{ Active::check('industries', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('industries') }}" class="k-link">
                        <i class="fa fa-industry fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.industries') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.companies') }}" class="{{ Active::check('admin_companies', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('admin_companies') }}" class="k-link">
                        <i class="fa fa-building fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.companies') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.users') }}" class="{{ Active::check('users', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('users') }}" class="k-link">
                        <i class="fa fa-user fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.users') }}</span>
                    </a>
                </li>
            @endrole

            @role('admin')
                @php
                    $class = (
                            Request::is('email_category_templates') ||
                            Request::is('email_templates')
                        ) ? 'current_section' : '';
                @endphp
                <li class="{{ $class }} k-item k-state-default">

                    <span data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.templates') }}" class="title-tooltip k-link">
                        <i class="fa fa-list-ul fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.templates') }}</span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>

                    <ul class="second_level k-group k-menu-group">
                        <li class="{{ (Request::is('email_category_templates') ? 'select_active' : '') }}">
                            <a href="{{ url('email_category_templates') }}">{{ __('sidebar.email_category_templates') }}</a>
                        </li>
                        <li class="{{ (Request::is('email_templates') ? 'select_active' : '') }}">
                            <a href="{{ url('email_templates') }}">{{ __('sidebar.email_templates') }}</a>
                        </li>
                    </ul>
                </li>
            @endrole

            @role('admin')
                @php
                    $class = (
                                Request::is('metadocuments') ||
                                Request::is('metavariables') ||
                                Request::is('metagrids')
                            ) ? 'current_section' : '';
                @endphp
                <li class="{{ $class }} k-item k-state-default k-last">
                    <span data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.document_generation') }}" class="title-tooltip k-link">
                        <i class="fa fa-file fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.document_generation') }}</span>
                        <span class="k-icon k-i-arrow-e"></span>
                    </span>
                    <ul class="second_level k-group k-menu-group">
                        <li class="{{ (Request::is('metadocuments') ? 'select_active' : '') }}">
                            <a href="{{ url('metadocuments') }}">{{ __('sidebar.metadocuments') }}</a>
                        </li>
                        <li class="{{ (Request::is('metavariables') ? 'select_active' : '') }}">
                            <a href="{{ url('metavariables') }}">{{ __('sidebar.metavariables') }}</a>
                        </li>
                          <li class="{{ (Request::is('metagrids') ? 'select_active' : '') }}">
                            <a href="{{ url('metagrids') }}">{{ __('sidebar.metagrids') }}</a>
                        </li>
                    </ul>
                </li>

                <li data-uk-tooltip="{pos:'top-left'}" title="{{ Auth::user()->tooltip==0 ? '' :__('sidebar.su_settings') }}" class="{{ Active::check('settings', true) }} title-tooltip k-item k-state-default">
                    <a href="{{ url('settings') }}" class="k-link">
                        <i class="fa fa-cogs fa-15" aria-hidden="true"></i><span class="menu_title">{{ __('sidebar.su_settings') }}</span>
                    </a>
                </li>

            @endrole
        </ul>
    </div>
</aside>
<!-- main sidebar end -->

<div id="page_content">
    <input type="hidden" id="API_PATH" value="<?php echo e(env('API_PATH')); ?>">
    <div id="page_content_inner">

        @yield('content')

        <div id="app">
                <v-app>
                    @if (Auth::user()->hasPermission('view.users'))
                        <chat-bar-admin
                                v-bind:apipath="{{  json_encode(env('API_PATH')) }}"
                                v-bind:rcapipath="{{  json_encode(env('IREDMAIL_API_HOST')) }}"
                                v-bind:userid="{{  json_encode(\Illuminate\Support\Facades\Auth::id()) }}"
                        ></chat-bar-admin>
                    @else
                        <chat-bar
                                v-bind:apipath="{{  json_encode(env('API_PATH')) }}"
                                v-bind:rcapipath="{{  json_encode(env('IREDMAIL_API_HOST')) }}"
                                v-bind:userid="{{  json_encode(\Illuminate\Support\Facades\Auth::id()) }}"
                        ></chat-bar>
                    @endif





                    @if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_default')
                        <theme-default></theme-default>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_dark')
                        <theme-dark></theme-dark>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_b')
                        <theme-purple></theme-purple>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_c')
                        <theme-brown></theme-brown>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_d')
                        <theme-default></theme-default>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_e')
                        <theme-gray></theme-gray>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_f')
                        <theme-gray></theme-gray>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_g')
                        <theme-purple></theme-purple>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_h')
                        <theme-red></theme-red>
                    @endif
                    @if (Auth::user()->theme == 'app_theme_i')
                        <theme-yellow></theme-yellow>
                    @endif
                </v-app>
        </div>

    </div>
</div>

<!--==================================
	=            CREATE DIV            =
	===================================-->

<div id="create_div">
    <div id="create_div_toggle" style="display: none;"><i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
    </div>
    <div class="">
        @yield('create_div')
    </div>
</div>

<!--====  End of CREATE DIV  ====-->

<!--==================================
=            EDIT DIV            =
===================================-->

<div id="edit_div">
    <div id="edit_div_toggle" style="display: none;"><i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
    </div>
    <div class="edit_div">

    </div>
</div>

<!--====  End of EDIT DIV  ====-->

<!--==================================
=            AJAX CREATE DIV         =
===================================-->

<div id="ajax_create_div">
    <div id="ajax_create_div_toggle" style="display: none;"><i class="fa fa-angle-double-right fa-2x"
                                                               aria-hidden="true"></i></div>
    <div class="ajax_create_div">

    </div>
</div>

<!--====  End of AJAX CREATE DIV ==-->

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

<!-- common functions -->
<script src="{{ asset('/assets/js/common.js')}}"></script>
<!--  kendoui functions -->
<script src="{{ asset('/assets/js/pages/kendoui.js')}}"></script>
<!-- kendo UI -->
<script src="{{ asset('/assets/js/kendoui_custom.js')}}"></script>
<!-- uikit functions -->

<script src="{{ asset('/assets/js/uikit_custom.js')}}"></script>
<!-- altair common functions/helpers -->
<script src="{{ asset('/assets/js/altair_admin_common.js')}}"></script>

<!-- page specific plugins -->


<script>
    $(function () {
        if (isHighDensity()) {
            $.getScript("bower_components/dense/src/dense.js", function () {
                // enable hires images
                altair_helpers.retina_images();
            })
        }
        if (Modernizr.touch) {
            // fastClick (touch devices)
            FastClick.attach(document.body);
        }
        //Activar modal de About y Credit
        $('.info-modal').on('click', function(e){

            $('#loading_info_div').show();

            e.preventDefault();
            var $info_url = $(this).attr('href');

            $.ajax({
                url: $info_url,
                type: 'GET',
                dataType: 'json'
            }).done(
                function(data){
                    $('#loading_info_div').hide();
                    $('#info_div').html(data.view);
                }
            );
        });
        altair_helpers.ie_fix();

        // Marcado en submenu de knowledge area y process group

    });
    
    // $window.load(function () {
        // ie fixes
        
    // });
    // $('[data-toggle="tooltip"]').tooltip();
</script>

@yield('scripts')

<!-- Scripts -->
<script src="{{ asset('js/tooltips.js') }}"></script> <!--Solo Control de Tooltips -->
<script src="{{ asset('js/table_actions.js') }}"></script>
<script src="{{ asset('js/favorites.js') }}"></script>
<script src="{{ asset('js/layout.js') }}"></script>
<script src="{{ asset('js/tcapp.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
 <script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('bower_components/parsleyjs/dist/parsley.js')}}"></script>
<script src="{{ asset('js/tableHTMLExport.js') }}"></script>



{{--<script type="text/javascript" src="{{ asset('js/tableExport.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.base64.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jspdf/libs/sprintf.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jspdf/jspdf.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jspdf/libs/base64.js') }}"></script>
--}}

{{-- @stack('scripts') --}}

</body>
</html>