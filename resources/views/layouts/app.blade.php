<!doctype html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="{{ config('app.locale') }}"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="/image/png" href="/assets/img/favicon_16.png" sizes="16x16">
    <link rel="icon" type="/image/png" href="/assets/img/favicon_32.png" sizes="32x32">

    <title>@yield('section_title') - TaskControl</title>

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
    <link rel="stylesheet" href="/assets/css/ajax_create_div.css" media="all">

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

@yield('css')

<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        var API_PATH = '{{ env('API_PATH') }}';

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
                        <img src="{{ URL::to('/') }}/assets/img/logo.png" alt="" height="15" width="71">
                    @else
                        <img src="{{ URL::to('/') }}/assets/img/logo_b.png"
                             alt="" height="15" width="71">
                    @endif
                </a>
            </div>

            <div class="uk-navbar-flip">
                <div class="uk-modal" id="modal_project_selection">
                    <div class="uk-modal-dialog">
                        <button type="button" class="uk-modal-close uk-close"></button>
                        <select id="optionsProjectSelection" class="md-input">
                            <option value="-1" disabled selected hidden>{{ __('header.select_a_customer') }}...</option>
                        </select>
                        <div id="projectsForSelection"></div>
                    </div>
                </div>
                <ul class="uk-navbar-nav user_actions">
                    @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user'))
                        <li id="project_selection">
                            <a href="#" data-uk-modal="{target:'#modal_project_selection'}">
                                {{ session('project_name', __('sidebar.no_project_selected'))  }}
                            </a>
                        </li>
                    @endif
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
                </ul>
            </div>

            <div class="section_title">
                @yield('section_title')
                @if (!empty($favoriteTitle))
                    <a href="#" id="favoriteLink"
                       data-favorite-title={{ $favoriteTitle }} data-favorite-url={{ $favoriteUrl }}>
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

            @php
                $class = (
                            Request::is('companies') || Request::is('offices') ||
                            Request::is('departments') || Request::is('project_roles') ||
                            Request::is('seniorities') || Request::is('workgroups') ||
                            Request::is('customers') || Request::is('projects') ||
                            Request::is('company_roles') ||
                            Request::is('permissions')
                        ) ? 'current_section' : '';
            @endphp
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.organization') }}" class="{{ $class }}">
                    <i class="fa fa-sitemap fa-15" aria-hidden="true"></i>
                    <span class="menu_title">{{ __('sidebar.organization') }}</span>
                    <ul class="second_level">
                        <li class="{{{ (Request::is('companies') ? 'act_item' : '') }}}">
                            <a href="{{ url('companies') }}">{{ __('sidebar.my_company') }}</a>
                        </li>
                        <li class="{{{ (Request::is('offices') ? 'act_item' : '') }}}">
                            <a href="{{ url('offices') }}">{{ __('sidebar.offices') }}</a>
                        </li>
                        <li class="{{{ (Request::is('departments') ? 'act_item' : '') }}}">
                            <a href="{{ url('departments') }}">{{ __('sidebar.departments') }}</a>
                        </li>
                        <li class="{{{ (Request::is('project_roles') ? 'act_item' : '') }}}">
                            <a href="{{ url('project_roles') }}">{{ __('sidebar.project_roles') }}</a>
                        </li>
                        <li class="{{{ (Request::is('seniorities') ? 'act_item' : '') }}}">
                            <a href="{{ url('seniorities') }}">{{ __('sidebar.seniorities') }}</a>
                        </li>
                        <li class="{{{ (Request::is('workgroups') ? 'act_item' : '') }}}">
                            <a href="{{ url('workgroups') }}">{{ __('sidebar.workgroups') }}</a>
                        </li>
                        <li class="{{{ (Request::is('holidays') ? 'act_item' : '') }}}">
                            <a href="{{ url('holidays') }}">{{ __('sidebar.holidays') }}</a>
                        </li>
                        <li class="{{ Active::check('absence_types', true) }}">
                            <a href="{{ url('absence_types') }}">{{ __('sidebar.absence_types') }}</a>
                        </li>
                        <li class="{{{ (Request::is('cities') ? 'act_item' : '') }}}">
                            <a href="{{ url('cities') }}">{{ __('sidebar.cities') }}</a>
                        </li>
                        <li class="{{{ (Request::is('company_roles') ? 'act_item' : '') }}}">
                            <a href="{{ url('company_roles') }}">{{ __('sidebar.company_roles') }}</a>
                        </li>
                        <li class="{{{ (Request::is('permissions') ? 'act_item' : '') }}}">
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
                            Request::is('discounts') ||
                            Request::is('taxes')
                        ) ? 'current_section' : '';
            @endphp
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.financial') }}" class="{{ $class }}">
                    <i class="fa fa-money fa-15" aria-hidden="true"></i>
                    <span class="menu_title">{{ __('sidebar.financial') }}</span>
                    <ul class="second_level">
                        <li class="{{{ (Request::is('exchange_rates') ? 'act_item' : '') }}}">
                            <a href="{{ url('exchange_rates') }}">{{ __('sidebar.exchange_rates') }}</a>
                        </li>
                        <li class="{{{ (Request::is('rates') ? 'act_item' : '') }}}">
                            <a href="{{ url('rates') }}">{{ __('sidebar.rates') }}</a>
                        </li>
                        <li class="{{{ (Request::is('costs') ? 'act_item' : '') }}}">
                            <a href="{{ url('costs') }}">{{ __('sidebar.costs') }}</a>
                        </li>
                        <li class="{{{ (Request::is('expenses') ? 'act_item' : '') }}}">
                            <a href="{{ url('expenses') }}">{{ __('sidebar.expenses') }}</a>
                        </li>
                        <li class="{{{ (Request::is('discounts') ? 'act_item' : '') }}}">
                            <a href="{{ url('discounts') }}">{{ __('sidebar.discounts') }}</a>
                        </li>
                        <li class="{{{ (Request::is('taxes') ? 'act_item' : '') }}}">
                            <a href="{{ url('taxes') }}">{{ __('sidebar.taxes') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @php
                $class = (
                            Request::is('providers') ||
                            Request::is('users') ||
                            Request::is('teams') ||
                            Request::is('members')
                        ) ? 'current_section' : '';
            @endphp
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.resources') }}" class="{{ $class }}">
                    <i class="fa fa-users fa-15" aria-hidden="true"></i>
                    <span class="menu_title">{{ __('sidebar.resources') }}</span>
                    <ul class="second_level">
                        <li class="{{{ (Request::is('providers') ? 'act_item' : '') }}}">
                            <a href="{{ url('providers') }}">{{ __('sidebar.providers') }}</a>
                        </li>
                        <li class="{{{ (Request::is('users') ? 'act_item' : '') }}}">
                            <a href="{{ url('users') }}">{{ __('sidebar.users') }}</a>
                        </li>
                        <li class="{{{ (Request::is('members') ? 'act_item' : '') }}}">
                            <a href="{{ url('team_users') }}">{{ __('sidebar.members') }}</a>
                        </li>

                        <li class="{{{ (Request::is('customers') ? 'act_item' : '') }}}"
                            title="{{ __('sidebar.customers') }}">
                            <a href="{{ url('customers') }}">

                                {{ __('sidebar.customers') }}
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.services') }}">
                    <a href="{{ url('services') }}">
                        <i class="fa fa-list-ol fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.services') }}</span>
                    </a>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.materials') }}">
                    <a href="{{ url('materials') }}">
                        <i class="fa fa-list-ul fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.materials') }}</span>
                    </a>
                </li>
            @endif

            @php
                $class = (
                            Request::is('catalog') ||
                            Request::is('emails') ||
                            Request::is('kpis')
                        ) ? 'current_section' : '';
            @endphp
            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.projects') }}" class="{{ $class }}">
                    <i class="fa fa-suitcase fa-15" aria-hidden="true"></i>
                    <span class="menu_title">{{ __('sidebar.projects') }}</span>
                    <ul class="second_level">
                        <li class="{{{ (Request::is('catalog') ? 'act_item' : '') }}}">
                            <a href="{{ url('catalog') }}">{{ __('sidebar.catalog') }}</a>
                        </li>
                        @if (Auth::user()->hasPermission('view.emails') || Auth::user()->hasPermission('edit.articles') || Auth::user()->hasRole('user'))
                            <li class="{{{ (Request::is('emails') ? 'act_item' : '') }}}">
                                <a href="{{ url('emails') }}">{{ __('sidebar.emails') }}</a>
                            </li>
                        @endif
                        <li class="{{{ (Request::is('kpis') ? 'act_item' : '') }}}">
                            <a href="{{ url('kpis') }}">{{ __('sidebar.kpis') }}</a>
                        </li>
                        <li class="{{{ (Request::is('kpis_category') ? 'act_item' : '') }}}">
                            <a href="{{ url('kpis_category') }}">{{ __('sidebar.kpis_category') }}</a>
                        </li>
                        <li class="{{{ (Request::is('projects') ? 'act_item' : '') }}}">
                            <a href="{{ url('projects') }}">{{ __('sidebar.projects') }}</a>
                        </li>


                    </ul>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && Auth::user()->hasRole('user'))

                <li title="{{ __('sidebar.systemsettings') }}" class="{{ $class }}">
                    <i class="fa fa-cog fa-15" aria-hidden="true"></i>
                    <span class="menu_title">{{ __('sidebar.systemsettings') }}</span>
                    <ul class="second_level">
                        <li class="{{{ (Request::is('repository_backup') ? 'act_item' : '') }}}">
                            <a href="{{ url('repository_backup') }}">{{ __('sidebar.repository_backup') }}</a>
                        </li>


                    </ul>
                </li>

            @endif



            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.favorites') }}">
                    <i class="fa fa-star fa-15" aria-hidden="true"></i>
                    <span class="menu_title"><a>{{ __('sidebar.favorites') }}</a></span>
                    <ul class="second_level">
                        <li>
                            {{ __('sidebar.favorites') }}
                        </li>
                        @if (!empty($favorites))
                            @foreach ($favorites as $favorite)
                                <li>
                                    <a href="{{ $favorite['url'] }}">{{ $favorite['title'] }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.notes') }}" class="{{ Active::check('notes', true) }}">
                    <a href="{{ url('notes') }}">
                        <i class="fa fa-sticky-note-o fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.notes') }}</span>
                    </a>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.contacts') }}" class="{{ Active::check('contacts', true) }}">
                    <a href="{{ url('contacts') }}">
                        <i class="fa fa-address-book-o fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.contacts') }}</span>
                    </a>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && Auth::user()->hasPermission('view.agenda'))
                <li title="{{ __('sidebar.agenda') }}" class="{{ Active::check('agendas', true) }}">
                    <a href="{{ url('agendas') }}">
                        <i class="fa fa-calendar fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.agenda') }}</span>
                    </a>
                </li>
            @endif
            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.emails') }}" class="{{ Active::check('emails', true) }}">
                    <a href="{{ url('emails') }}">
                        <i class="fa fa-envelope-open fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.emails') }}</span>
                    </a>
                </li>
            @endif
            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && Auth::user()->hasPermission('view.gantt'))
                <li title="{{ __('sidebar.tasks') }}" class="{{ Active::check('tasks', true) }}">
                    <a href="{{ url('tasks') }}">
                        <i class="fa fa-tasks fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.tasks') }}</span>
                    </a>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.workboard') }}">
                    <a href="{{ url('workboard') }}">
                        <i class="fa fa-list fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.workboard') }}</span>
                    </a>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user'))
                <li title="{{ __('sidebar.repository') }}">
                    <a href="{{ url('repository') }}">
                        <i class="fa fa-cloud fa-15" aria-hidden="true"></i>
                        <span class="menu_title">{{ __('sidebar.repository') }}</span>
                    </a>
                </li>
            @endif

            @if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user'))
                @php
                    $class = (
                                Request::is('stakeholders') ||
                                Request::is('contacts') ||
                                Request::is('contracts')
                            ) ? 'current_section' : '';
                @endphp

                <li title="Process Group" class="{{ $class }}">
                    <i class="fa fa-object-group fa-15" aria-hidden="true"></i>
                    <span class="menu_title">{{ __('sidebar.process_by_group') }}</span>
                    <ul class="second_level">

                        <li>Planning
                            <ul>

                                @if (Auth::user()->hasPermission('view.projects'))
                                    <li class="{{{ (Request::is('projects') ? 'act_item' : '') }}}">
                                        <a href="{{ url('projects') }}">{{ __('sidebar.projects') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.requirements'))
                                    <li class="{{{ (Request::is('requirements') ? 'act_item' : '') }}}">
                                        <a href="{{ url('requirements') }}">{{ __('sidebar.requirements') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.providers'))
                                    <li class="{{{ (Request::is('providers') ? 'act_item' : '') }}}">
                                        <a href="{{ url('providers') }}">{{ __('sidebar.providers') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.stakeholders'))
                                    <li class="{{{ (Request::is('stakeholders') ? 'act_item' : '') }}}">
                                        <a href="{{ url('stakeholders') }}">{{ __('sidebar.stakeholders') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.contracts'))
                                    <li class="{{{ (Request::is('contracts') ? 'act_item' : '') }}}">
                                        <a href="{{ url('contracts') }}">{{ __('sidebar.contracts') }}</a>
                                    </li>
                                @endif

                                @if (Auth::user()->hasPermission('view.quotations'))
                                    <li class="{{{ (Request::is('quotation') ? 'act_item' : '') }}}">
                                        <a href="{{ url('quotation') }}">{{ __('sidebar.quotations') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li>Team
                            <ul>
                                @if (Auth::user()->hasPermission('view.users'))
                                    <li class="{{{ (Request::is('users') ? 'act_item' : '') }}}">
                                        <a href="{{ url('users') }}">{{ __('sidebar.users') }}</a>
                                    </li>
                                @endif

                                @if (Auth::user()->hasPermission('view.members'))
                                    <li class="{{{ (Request::is('members') ? 'act_item' : '') }}}">
                                        <a href="{{ url('team_users') }}">{{ __('sidebar.members') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.capacityplanning'))
                                    <li class="{{{ (Request::is('capacity_planning') ? 'act_item' : '') }}}">
                                        <a href="{{ url('capacity_planning') }}">{{ __('sidebar.team_capacity') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.workinghours'))
                                    <li class="{{{ (Request::is('working_hours') ? 'act_item' : '') }}}">
                                        <a href="{{ url('working_hours') }}">{{ __('sidebar.working_hours') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.absences'))
                                    <li class="{{{ (Request::is('absences') ? 'act_item' : '') }}}">
                                        <a href="{{ url('absences') }}">{{ __('sidebar.absences') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.replacements'))
                                    <li class="{{{ (Request::is('replacements') ? 'act_item' : '') }}}">
                                        <a href="{{ url('replacements') }}">{{ __('sidebar.replacements') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.additionalhours'))
                                    <li class="{{{ (Request::is('additional_hours') ? 'act_item' : '') }}}">
                                        <a href="{{ url('additional_hours') }}">{{ __('sidebar.additional_hours') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li>Monitoring
                            <ul>
                                @if (Auth::user()->hasPermission('view.taskstatusreport'))
                                    <li class="{{{ (Request::is('task_status_report') ? 'act_item' : '') }}}">
                                        <a href="{{ url('reports/tasks/') }}">{{ __('sidebar.task_status_report') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.projectriskreport'))
                                    <li class="{{{ (Request::is('project_risk_report') ? 'act_item' : '') }}}">
                                        <a href="{{ url('soon') }}">{{ __('sidebar.project_risk_report') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.kpis'))
                                    <li class="{{{ (Request::is('kpis_functions') ? 'act_item' : '') }}}">
                                        <a href="{{ url('kpis_functions') }}">{{ __('sidebar.kpis') }}</a>
                                    </li>
                                @endif


                            </ul>
                        </li>


                        <li> Financial
                            <ul>
                                @if (Auth::user()->hasPermission('view.forecast'))
                                    <li class="{{{ (Request::is('forecast') ? 'act_item' : '') }}}">
                                        <a href="{{ url('soon') }}">{{ __('sidebar.forecast') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.profitandloss'))
                                    <li class="{{{ (Request::is('profit_and_loss') ? 'act_item' : '') }}}">
                                        <a href="{{ url('profit_and_loss') }}">{{ __('sidebar.profit_and_loss') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li>Billing
                            <ul>
                                @if (Auth::user()->hasPermission('view.profitandloss'))
                                    <li class="{{{ (Request::is('project_board') ? 'act_item' : '') }}}">
                                        <a href="{{ url('project_board/rows') }}">{{ __('sidebar.project_board') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission('view.invoices'))
                                    <li class="{{{ (Request::is('invoices') ? 'act_item' : '') }}}">
                                        <a href="{{ url('invoices') }}">{{ __('sidebar.invoices') }}</a>
                                    </li>
                                @endif

                            </ul>
                        </li>


                        @endrole

                        @role('admin')
                        <li title="{{ __('sidebar.languages') }}" class="{{ Active::check('languages', true) }}">
                            <a href="{{ url('languages') }}">
                                <i class="fa fa-language fa-15" aria-hidden="true"></i>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li title="{{ __('sidebar.currencies') }}" class="{{ Active::check('currencies', true) }}">
                            <a href="{{ url('currencies') }}">
                                <i class="fa fa-usd fa-15" aria-hidden="true"></i>
                            </a>
                        </li>
                        @endrole


                        @role('admin')
                        <li title="{{ __('sidebar.countries') }}"
                            class="{{{ (Request::is('countries') ? 'current_section' : '') }}}">
                            <a href="{{ url('countries') }}">
                                <i class="fa fa-globe fa-15" aria-hidden="true"></i>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li title="{{ __('sidebar.cities') }}"
                            class="{{{ (Request::is('cities') ? 'current_section' : '') }}}">
                            <a href="{{ url('cities_template') }}">
                                <i class="fa fa-map-marker fa-15" aria-hidden="true"></i>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li title="{{ __('sidebar.holidays') }}"
                            class="{{{ (Request::is('holidays_templates') ? 'current_section' : '') }}}">
                            <a href="{{ url('holidays_templates') }}">
                                <i class="fa fa-calendar-times-o fa-15" aria-hidden="true"></i>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li title="{{ __('sidebar.absence_types') }}"
                            class="{{ Active::check('absence_types', true) }}">
                            <a href="{{ url('absence_types_template') }}">
                                <i class="fa fa-calendar-minus-o fa-15" aria-hidden="true"></i>
                            </a>
                        </li>
                        @endrole


                        @role('admin')
                        <li title="{{ __('sidebar.industries') }}" class="{{ Active::check('industries', true) }}">
                            <a href="{{ url('industries') }}">
                                <i class="fa fa-industry fa-15" aria-hidden="true"></i>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li title="{{ __('sidebar.companies') }}" class="{{ Active::check('admin_companies', true) }}">
                            <a href="{{ url('admin_companies') }}">
                                <i class="fa fa-building fa-15" aria-hidden="true"></i>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li title="{{ __('sidebar.users') }}" class="{{ Active::check('users', true) }}">
                            <a href="{{ url('users') }}">
                                <i class="fa fa-user fa-15" aria-hidden="true"></i>
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
                        <li title="{{ __('sidebar.templates') }}" class="{{ $class }}">
                            <i class="fa fa-list-ul fa-15" aria-hidden="true"></i>
                            <ul class="second_level">
                                <li class="{{{ (Request::is('email_category_templates') ? 'act_item' : '') }}}">
                                    <a href="{{ url('email_category_templates') }}">{{ __('sidebar.email_category_templates') }}</a>
                                </li>
                                <li class="{{{ (Request::is('email_templates') ? 'act_item' : '') }}}">
                                    <a href="{{ url('email_templates') }}">{{ __('sidebar.email_templates') }}</a>
                                </li>
                            </ul>
                        </li>

                        @endrole


                    </ul>
    </div>
</aside><!-- main sidebar end -->

<div id="page_content">
    <input type="hidden" id="API_PATH" value="<?php echo e(env('API_PATH')); ?>">
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
    (function () {
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
    });
    $window.load(function () {
        // ie fixes
        altair_helpers.ie_fix();
    });
</script>

@yield('scripts')


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


<!-- Scripts -->
<script src="{{ asset('js/table_actions.js') }}"></script>
<script src="{{ asset('js/favorites.js') }}"></script>
<script src="{{ asset('js/layout.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
{{-- @stack('scripts') --}}
</body>
</html>
