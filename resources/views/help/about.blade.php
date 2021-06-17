{{-- @extends('layouts.app') --}}
    {{-- Font Awesome --}}
    {{-- <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css')}}"/> --}}

    {{-- additional styles for plugins --}}
    <!-- kendo UI -->
    {{-- <link rel="stylesheet" href="{{ asset('/bower_components/kendo-ui/styles/kendo.common-material.min.css')}}"/> --}}

    {{-- <link rel="stylesheet" href="{{ asset('/bower_components/kendo-ui/styles/kendo.material.min.css')}}" id="kendoCSS"/> --}}

    <!-- uikit -->
    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/uikit.almost-flat.css')}}" media="all"> --}}


    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/create_div.css')}}" media="all"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/edit_div.css')}}" media="all"> --}}
{{--  --}}
    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/ajax_create_div.css')}}" media="all"> --}}

    <!-- altair admin -->
    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/main.css')}}" media="all"> --}}

    {{-- @if (empty(Auth::user()->theme) || Auth::user()->theme == 'app_theme_default')
        <link rel="stylesheet" href="{{ asset('/assets/css/themes/my_theme.css')}}" media="all">
        <theme-default></theme-default>
    @endif --}}

<!-- themes -->
    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/themes/themes_combined.min.css')}}" media="all"> --}}


    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    
    {{-- <script   src="{{ asset('bower_components/jquery/dist/jquery.js') }}"></script> --}}

     {{-- <script   src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}"></script> --}}


{{-- <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}"> --}}

<!-- Aqui llegan los scrips css y js -->
@yield('css')

    <div style="padding: 16px;">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-1-1">
         
                <label>TaskControl: Version 20.02.001.001.001</label>
                <br>
                <a href="https://www.safecreative.org/user/1707122473970" ><img src="https://resources.safecreative.org/user/1707122473970/label/barcode-male-72" style="border:0;" alt="Safe Creative #1707122473970"/></a>
                <br><br>

                <label>Work Attribution</label>
                <br>
                <a href="https://www.safecreative.org/work/2004213726700-taskcontrol-v19-03-001-001-001" target="_blank">
                <span>TaskControl-V19.03.001.001.001</span> -
                <span>CC by-nc-nd 4.0</span> -
                <span>TaskControl</span>
                </a>
                <br><br>

                <label>U.S. Copyright Office Registration Service:</label>
                <br><br>
                <label>Jul 12, 2017          General Architecture  </label><br>
                <label>1707122935423 - General Architecture</label><br>
                <label>1707122935409 - TaskControl API</label><br>
                <label>1707122935393 - Admin & Users Screen Interfaces</label><br>
                <label>1707122935416 - TaskControl Logos & TradeMarks</label><br>
                <label>1707122935386 - TaskControl Database Design</label><br>
                <label>1707122935430 - TaskControl Source Code</label>

                <br><br><br>
                <label>TaskControl2017-2020 (R) All Products, Services and Code used are registered trademarks of their respective owners</label>
            </div>
        </div>
    </div>

<!-- common functions -->
{{-- <script src="{{ asset('/assets/js/common.js')}}"></script> --}}
<!-- uikit functions -->

{{-- <script src="{{ asset('/assets/js/uikit_custom.js')}}"></script> --}}
<!-- altair common functions/helpers -->
{{-- <script src="{{ asset('/assets/js/altair_admin_common.js')}}"></script> --}}

<!-- page specific plugins -->
<!-- kendo UI -->
{{-- <script src="{{ asset('/assets/js/kendoui_custom.js')}}"></script> --}}

<!--  kendoui functions -->
{{-- <script src="{{ asset('/assets/js/pages/kendoui.js')}}"></script> --}}



<!-- Scripts -->
{{-- <script src="{{ asset('js/table_actions.js') }}"></script>
<script src="{{ asset('js/favorites.js') }}"></script>
<script src="{{ asset('js/layout.js') }}"></script>
<script src="{{ asset('js/tcapp.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
 <script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('bower_components/parsleyjs/dist/parsley.js')}}"></script>
<script src="{{ asset('js/tableHTMLExport.js') }}"></script> --}}


