@extends('layouts.app', ['favoriteTitle' => __('team_users.team_users'), 'favoriteUrl' => url(Request::path())])
{{-- @if(session()->has('project_id') || Auth::user()->hasRole('user')) --}}
@section('scripts')
    @include('datatables.basic')
    <script>
        $(function () {
            var tableName = 'team_users'; //&project_id={{session('project_id')}}
            var urlParameters = '?company_id={{ $company->id }}';
            var columns = [
                {data: 'id', name: 'id', visible: false},
                {data: 'project_name', name: 'project_name'},
                {data: 'user_name', name: 'user_name'},
                {data: 'hours', name: 'hours'},
                {data: 'date_from', name: 'date_from'},
                {data: 'date_to', name: 'date_to'},
                {data: 'country_name', name: 'country_name', defaultContent:''},
                {data: 'city_name', name: 'city_name', defaultContent:''},
                {data: 'company_role', name: 'company_role', defaultContent:''},
                {data: 'project_role', name: 'project_role', defaultContent:''},
                {data: 'seniority', name: 'seniority', defaultContent:''},
                {data: 'workplace', name: 'workplace', defaultContent:''},
                {data: 'rate', name: 'rate', defaultContent:''},
                 {data: 'load', name: 'load', defaultContent:''},
                {data: 'actions', name: 'actions'}
            ];

            var actions = [
                {
                    pre: '<a title="{{__('general.edit')}}" href="/team_users/',
                    post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
                },
                <?php if (Auth::user()->hasPermission('delete.users')) { ?>
                    {
                        pre: '<a title="{{__('general.delete')}}" href="/team_users/',
                        post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                    }
                <?php } ?>
            ];

            var confirm = '{{__('general.confirm')}}';
            var  API_PATH = '<?php echo e(env('API_PATH')); ?>';
            DtablesUtil(tableName, columns, actions, urlParameters);
        });




    </script>
@endsection
{{-- @endif --}}
@section('section_title', __('team_users.team_users'))

@section('content')
    {{-- @if(!session()->has('project_id') && !Auth::user()->hasRole('user'))
        <div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
    @endif --}}
    {{-- @if(session()->has('project_id') || Auth::user()->hasRole('user')) --}}
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

                    <table id="team_users-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th title="{{ __('team_users_tooltip.id')}}">{{ __('team_users.id') }}</th>
                            <th title="{{ __('team_users_tooltip.project')}}">{{ __('team_users.project') }}</th>
                            <th title="{{ __('team_users_tooltip.user')}}">{{ __('team_users.user') }}</th>
                            <th title="{{ __('team_users_tooltip.working_hours')}}">{{ __('team_users.working_hours') }}</th>

                            <th title="{{ __('team_users_tooltip.from')}}">{{ __('team_users.from') }}</th>
                            <th title="{{ __('team_users_tooltip.to')}}">{{ __('team_users.to') }}</th>
                            <th title="{{ __('team_users_tooltip.country')}}">{{ __('team_users.country') }}</th>
                            <th title="{{ __('team_users_tooltip.city')}}">{{ __('team_users.city') }}</th>
                            <th title="{{ __('team_users_tooltip.permission_role')}}">{{ __('team_users.permission_role') }}</th>
                            <th title="{{ __('team_users_tooltip.project_role')}}">{{ __('team_users.project_role') }}</th>
                            <th title="{{ __('team_users_tooltip.seniority')}}">{{ __('team_users.seniority') }}</th>
                            <th title="{{ __('team_users_tooltip.workplace')}}">{{ __('team_users.workplace') }}</th>
                            <th title="{{ __('team_users_tooltip.rate')}}">{{ __('team_users.rate') }}</th>
                              <th title="{{ __('team_users_tooltip.load')}}">{{ __('team_users.load') }}</th>
                            <th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="uk-grid datatables-bottom">
                        <div class="uk-width-medium-1-3" id="datatables-length"></div>
                        <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                        <div class="uk-width-medium-1-3">
                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                               href="#" id="add-new" title="{{ __('team_users_tooltip.add_new')}}">{{ __('team_users.add_new') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @endif --}}
@endsection

@section('create_div')
    @component('team_user/create', ['projects' => $projects, 'users' => $users, 'offices'=> $offices, 'countries'=>$countries,
    'cities'=>$cities,'company'=>$company, 'companyRoles' =>$companyRoles, 'projectRoles' =>$projectRoles, 'seniorities'=>$seniorities, 'url'=>Request::path()])

    @endcomponent
@endsection