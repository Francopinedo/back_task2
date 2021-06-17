<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{{ csrf_token() }}}">
    <!--Styles-->
    <link href="{{ asset("css/app.css") }}">

    <script>
        window.clientKey = "{{ $clientKey ??'' }}";
        window.secretKey = "{{ $secretKey ??'' }}";
        window.hostKey = "{{ $hostKey ??'' }}";
        window.tcApiHostKey = "{{ $tcApiHost ??'' }}";
        window.userIdKey = "{{ $userIdKey ??'' }}";
    </script>

    <title>taskcontrolmail</title>

</head>
<body>


<v-container fluid fill-height>
    <search-bar></search-bar>
    <navbar v-bind:selectedtheme="{{ json_encode($selectedtheme) }}"></navbar>
    <mails :key="$route.path"></mails>
    <compose-button v-bind:contacts="{{  json_encode($contacts) }}"></compose-button>
</v-container>


<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
