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

    <link rel="icon" type="/image/png" href="{{ asset('/assets/img/favicon_16.png') }}" sizes="16x16">
    <link rel="icon" type="/image/png" href="{{ asset('/assets/img/favicon_32.png') }}" sizes="32x32">

    <title>@yield('section_title') - TaskControl</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css')}}"/>

    <!-- additional styles for plugins -->
    <!-- kendo UI -->
    <link rel="stylesheet" href="{{ asset('/bower_components/kendo-ui/styles/kendo.common-material.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('/bower_components/kendo-ui/styles/kendo.material.min.css')}}" id="kendoCSS"/>

    <!-- uikit -->
    <link rel="stylesheet" href="{{ asset('/assets/css/uikit.almost-flat.css')}}" media="all">


    <link rel="stylesheet" href="{{ asset('/assets/css/create_div.css')}}" media="all">
    <link rel="stylesheet" href="{{ asset('/assets/css/edit_div.css')}}" media="all">
    <link rel="stylesheet" href="{{ asset('/assets/css/ajax_create_div.css')}}" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="{{ asset('/assets/css/main.css')}}" media="all">

    @if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_default')
        <link rel="stylesheet" href="{{ asset('/assets/css/themes/my_theme.css')}}" media="all">
        <theme-default></theme-default>
    @endif

<!-- themes -->
    <link rel="stylesheet" href="{{ asset('/assets/css/themes/themes_combined.min.css')}}" media="all">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script   src="{{ asset('bower_components/jquery/dist/jquery.js') }}"></script>

     <script   src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}"></script>


<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@yield('css')

<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        var API_PATH = '{{ env('API_PATH') }}';

        var user_id = {{ Auth::id() }};

		var customer_id = {{ session('customer_id',0) }};
        var customer_name = '{{ session('customer_name','') }}';
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
                <a href="/dashboard">
                    @if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_default')
                        <img src="{{ URL::to('/') }}/assets/img/logo.png" alt="" height="15" width="71">
                    @else
                        <img src="{{ URL::to('/') }}/assets/img/logo_b.png"
                             alt="" height="15" width="71">
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
                        <div id="projectsForSelection"></div>
                    </div>
                </div>

            <div id="modal_help" class="uk-modal">
                <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <div class="uk-modal-header">
                        <h2 class="uk-modal-title">{{__('header.help') }}</h2>
                    </div>
                    <div class="uk-modal-body">
                          
                    </div>
                    <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>
                    </div>  

                </div>
            </div>

        <div id="modal_about" class="uk-modal">
                <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <div class="uk-modal-header">
                        <h2 class="uk-modal-title">{{__('header.about') }}</h2>
                    </div>
                    <div class="uk-modal-body">
                                <iframe src="{{ url('about') }}"  width="100%" frameborder="0"  uk-responsive></iframe>
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
                                <iframe src="{{ url('credit') }}"  frameborder="0"  uk-responsive></iframe>
                    </div>
                    <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>
                    </div>  

                </div>
            </div>



                <ul class="uk-navbar-nav user_actions">


                    @if (\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id==1)

                        <li id="name">

                            SUPERUSER: <strong>{{ Auth::user()->email }}</strong>

                        </li>
                    @endif
                    @if (\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id==2)
                        <li id="name">

                            ADMIN: <strong>{{ strtoupper(Auth::user()->email) }}</strong>

                        </li>
                        <li id="name">

                            CUSTOMER: <strong>ALL</strong>

                        </li>
                    @endif
                    @if (\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id>2)
                        <li id="name">

                            USER: <strong>{{ strtoupper(Auth::user()->email)  }} </strong>

                        </li>

                        <li id="name">

                            ROLE:
                            <strong>{{ strtoupper(\App\Role::find(\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id)->name) }}</strong>

                        </li>
                    <!--<li id="name">
                           
                               CUSTOMER: <strong>{{ strtoupper(session('customer_id')!='' ? \App\Customer::find(session('customer_id'))->name : __('sidebar.all_project')) }}</strong>
                         
                        </li>
				-->
                        <li id="customer_selection">
                            <a href="#" data-uk-modal="{target:'#modal_customer_selection'}">CUSTOMER:
                                <strong> {{ strtoupper(session('customer_name', __('sidebar.no_customer_selected')))  }}</strong>
                            </a>
                        </li>
                    @endif
                    @if (\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id>2)

                        <li id="project_selection">
                            <a href="#" data-uk-modal="{target:'#modal_project_selection'}">PROJECT:
                                <strong> {{ strtoupper(session('project_name', __('sidebar.no_project_selected')))  }}</strong>
                            </a>
                        </li>
                    @endif
                    @if (\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id==2)
                        <li id="project_selection">
                            <a>PROJECT:
                                <strong>ALL</strong>
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

                   <li title="Help"  data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                 <a href="#" class=""><i class="fa fa-question-circle fa-3x" aria-hidden="true"></i>
                    </a>

                     <!---->
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav js-uk-prevent">
                                <li><a href="#" data-uk-modal="{target:'#modal_help'}">{{ __('header.help') }}</a></li>
                                 <li><a href="#" data-uk-modal="{target:'#modal_about'}">{{ __('header.about') }}</a></li>
                                  <li><a href="#" data-uk-modal="{target:'#modal_credit'}">{{ __('header.credit') }}</a></li>
                                <li>
                                   
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



<div id="page_content">
    <input type="hidden" id="API_PATH" value="<?php echo e(env('API_PATH')); ?>">
    <div id="page_content_inner">
    
                @yield('content')
    </div>
</div>


 
<!-- common functions -->
<script src="{{ asset('/assets/js/common.js')}}"></script>
<!-- uikit functions -->

<script src="{{ asset('/assets/js/uikit_custom.js')}}"></script>
<!-- altair common functions/helpers -->
<script src="{{ asset('/assets/js/altair_admin_common.js')}}"></script>

<!-- page specific plugins -->
<!-- kendo UI -->
<script src="{{ asset('/assets/js/kendoui_custom.js')}}"></script>

<!--  kendoui functions -->
<script src="{{ asset('/assets/js/pages/kendoui.js')}}"></script>



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
   //  $('[data-toggle="tooltip"]').tooltip();
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
