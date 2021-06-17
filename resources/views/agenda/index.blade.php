@extends('layouts.app', ['favoriteTitle' => __('agendas.agendas'), 'favoriteUrl' => url(Request::path())])

@section('scripts')
    @include('datatables.basic')
    <script>
        $(function () {
            var tableName = 'agendas';
            var urlParameters = '?company_id={{ $company->id }}';
            var columns = [
                {data: 'id', name: 'id', visible: false},
                {data: 'project_name', name: 'project_name'},
                {data: 'knowledge_area', name: 'knowledge_area'},
                {data: 'item_number', name: 'item_number'},
                {data: 'description', name: 'description'},
                {data: 'start', name: 'start'},
                {data: 'status', name: 'status'},
                {data: 'due', name: 'due'},
                {data: 'owner_name', name: 'owner_name'},
                {data: 'detail', name: 'detail'},
                {data: 'actions', name: 'actions'}
            ];

            var actions = [
                {
                    pre: '<a title="{{__('agendas.items')}}" href="/agenda/rows/',
                    post: '" class="table-actions"><i class="fa fa-list" aria-hidden="true"></i></a>'
                },
                {
                    pre: '<a title="{{__('general.edit')}}" href="/agendas/',
                    post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
                },
                <?php if (Auth::user()->hasPermission('delete.users')) { ?>
                    { pre: '<a title="{{__('general.delete')}}" href="/agendas/', post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
                <?php } ?>
            ];

            DtablesUtil(tableName, columns, actions, urlParameters);
        });
    </script>
    <script>
        window.clientKey = "{{ $clientKey ??'' }}";
        window.secretKey = "{{ $secretKey ??'' }}";
        window.hostKey = "{{ $hostKey ??'' }}";
    </script>
@endsection

@section('section_title', __('agendas.agendas'))

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

                    {{-- @if(!session()->has('project_id'))
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                    @endif --}}

                    {{-- @if(session()->has('project_id')) --}}
                    <table id="agendas-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th title="{{__('agendas_tooltip.id')}}">{{ __('agendas.id') }}</th>
                            <th title="{{__('agendas_tooltip.project')}}">{{ __('agendas.project') }}</th>
                            <th title="{{__('agendas_tooltip.knowledge_area')}}">{{ __('agendas.knowledge_area') }}</th>
                            <th title="{{__('agendas_tooltip.item_number')}}">{{ __('agendas.item_number') }}</th>
                            <th title="{{__('agendas_tooltip.description')}}">{{ __('agendas.description') }}</th>
                            <th title="{{__('agendas_tooltip.start')}}">{{ __('agendas.start') }}</th>
                            <th title="{{__('agendas_tooltip.status')}}">{{ __('agendas.status') }}</th>
                            <th title="{{__('agendas_tooltip.due')}}">{{ __('agendas.due') }}</th>
                            <th title="{{__('agendas_tooltip.owner')}}">{{ __('agendas.owner') }}</th>
                            <th title="{{__('agendas_tooltip.detail')}}">{{ __('agendas.detail') }}</th>
                            <th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="uk-grid datatables-bottom">
                        <div class="uk-width-medium-1-3" id="datatables-length"></div>
                        <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                        <div class="uk-width-medium-1-3">
                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                               href="#" id="add-new" title="{{ __('agendas.add_new') }}">{{ __('agendas.add_new') }}</a>
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>

    <div id="app">
        <v-app>
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
            <agenda-calendar v-bind:contacts="{{  json_encode($toSend) }}"></agenda-calendar>
        </v-app>
    </div>

@endsection

@section('create_div')
    @component('agenda/create', ['company' => $company, 'projects' => $projects, 'users' => $users])

    @endcomponent
@endsection