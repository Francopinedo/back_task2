@extends('layouts.app')
@if(session()->has('project_id') || Auth::user()->hasRole('user'))
@section('scripts')
    @include('datatables.basic')
    <script>
        $(function () {
            var tableName = 'team_users';
            var urlParameters = '?company_id={{ $company->id }}&project_id={{session('project_id')}}';
            var columns = [
                {data: 'id', name: 'id', visible: false},
                {data: 'project_name', name: 'project_name'},
                {data: 'user_name', name: 'user_name'},
                {data: 'hours', name: 'hours'},
                {data: 'load', name: 'load'},
                {data: 'date_from', name: 'date_from'},
                {data: 'date_to', name: 'date_to'},
                {data: 'country_name', name: 'country_name'},
                {data: 'city_name', name: 'city_name'},
                {data: 'company_role', name: 'company_role'},
                {data: 'project_role', name: 'project_role'},
                {data: 'seniority', name: 'seniority'},
                {data: 'workplace', name: 'workplace'},
                {data: 'rate', name: 'rate'},
                {data: 'actions', name: 'actions'}
            ];

            var actions = [
                {
                    pre: '<a href="/team_users/',
                    post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
                },
                {
                    pre: '<a href="/team_users/',
                    post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                }
            ];

            var confirm = '{{__('general.confirm')}}';
            var  API_PATH = '<?php echo e(env('API_PATH')); ?>';
            DtablesUtil(tableName, columns, actions, urlParameters);
        });
    </script>
@endsection
@endif
@section('section_title', __('team_users.team_users'))

@section('content')
    @if(!session()->has('project_id') && !Auth::user()->hasRole('user'))
        <div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
    @endif
    @if(session()->has('project_id') || Auth::user()->hasRole('user'))
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
                            <th>{{ __('team_users.id') }}</th>
                            <th>{{ __('team_users.project') }}</th>
                            <th>{{ __('team_users.user') }}</th>
                            <th>{{ __('team_users.working_hours') }}</th>
                            <th>{{ __('team_users.load') }}</th>
                            <th>{{ __('team_users.from') }}</th>
                            <th>{{ __('team_users.to') }}</th>
                            <th>{{ __('users.country') }}</th>
                            <th>{{ __('users.city') }}</th>
                            <th>{{ __('users.permission_role') }}</th>
                            <th>{{ __('users.project_role') }}</th>
                            <th>{{ __('users.seniority') }}</th>
                            <th>{{ __('users.workplace') }}</th>
                            <th>{{ __('users.rate') }}</th>
                            <th>{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="uk-grid datatables-bottom">
                        <div class="uk-width-medium-1-3" id="datatables-length"></div>
                        <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                        <div class="uk-width-medium-1-3">
                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                               href="#" id="add-new">{{ __('team_users.add_new') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('create_div')
    @component('team_user/create', ['projects' => $projects, 'users' => $users, 'office'=> $office, 'countries'=>$countries,
    'cities'=>$cities,'company'=>$company, 'companyRoles' =>$companyRoles, 'projectRoles' =>$projectRoles, 'seniorities'=>$seniorities])

    @endcomponent
@endsection