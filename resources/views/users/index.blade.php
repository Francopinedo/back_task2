@extends('layouts.app', ['favoriteTitle' => __('users.users'), 'favoriteUrl' => 'users'])

@section('scripts')
    @include('datatables.basic')
    <script>
        $(function () {
            var tableName = 'users';
            var urlParameters = '?company_id={{ isset($company)?$company->id:'' }}' + '&user_id={{ (!Auth::user()->hasRole("admin"))?"true":"false" }}';
            var columns = [
                {data: 'id', name: 'id', visible: false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'home_phone', name: 'home_phone'},
                {data: 'cell_phone', name: 'cell_phone'},
                {data: 'city_name', name: 'city_name'},
                {data: 'office_name', name: 'office_name'},
                {data: 'role_name', name: 'role_name'},
                {data: 'project_role_name', name: 'project_role_name'},
                {data: 'seniority', name: 'seniority'},
                {data: 'workplace', name: 'workplace'},
                {data: 'workgroup_title', name: 'workgroup_title'},
                {data: 'hours_by_day', name: 'hours_by_day'},
                {data: 'actions', name: 'actions'}
            ];
            var extra_buttons = [{
                text: 'IMPORT',
                action: function (e, dt, node, config) {

                    var self = this;

                    // inicializo acciones del boton editar
                    var $switcher_ajax_create = $('#ajax_create_div'),
                        $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
                        $ajax_create_url = 'users/import';


                    e.preventDefault();

                    $switcher_ajax_create_toggle.show();
                    $('#ajax_create_div').addClass('switcher_active');
                    $('#ajax_create_div').css('position', 'absolute');
                    $.ajax({
                        url: $ajax_create_url,
                        type: 'GET',
                        dataType: 'json'
                    }).done(
                        function(data){
                            $('.ajax_create_div').html(data.view);
                        }
                    );


                    $switcher_ajax_create_toggle.click(function (e) {
                        e.preventDefault();
                        $switcher_ajax_create.toggleClass('switcher_active');
                        //  $('#ajax_create_div').css('position','relative');
                    });

                }
            }];
            var actions = [
                {
                    pre: '<a href="/users/',
                    post: '/show" class="table-actions info-btn" data-uk-modal="{target:\'#modal_info\'}"><i class="fa fa-info-circle" aria-hidden="true"></i></a>'
                },
                {
                    pre: '<a href="/users/',
                    post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
                },

                {
                    pre: '<a href="/users/',
                    post: '/password" class="table-actions edit-btn"><i class="fa fa-key" aria-hidden="true"></i></a>'
                },
                {
                    pre: '<a href="/users/',
                    post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                }
            ];
            var confirm = '{{__('general.confirm')}}';
            var API_PATH = '<?php echo e(env('API_PATH')); ?>';
            DtablesUtil(tableName, columns, actions, urlParameters, extra_buttons);
        });
    </script>
@endsection

@section('section_title', __('users.users'))

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

                    @if((!isset($workgroups) || empty($workgroups) || count($workgroups) < 1) && !Auth::user()->hasRole('admin'))
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('users.you_need_to_add_workgroups') }}
                        </div>
                    @endif


                    <table id="users-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ __('users.id') }}</th>
                            <th>{{ __('users.name') }}</th>
                            <th>{{ __('users.email') }}</th>
                            <th>{{ __('users.address') }}</th>
                            <th>{{ __('users.home_phone') }}</th>
                            <th>{{ __('users.cell_phone') }}</th>
                            <th>{{ __('users.city') }}</th>
                            <th>{{ __('users.office') }}</th>
                            <th>{{ __('users.permission_role') }}</th>
                            <th>{{ __('users.project_role') }}</th>
                            <th>{{ __('users.seniority') }}</th>
                            <th>{{ __('users.workplace') }}</th>
                            <th>{{ __('users.workgroup') }}</th>
                            <th>{{ __('users.hours_by_day') }}</th>
                            <th>{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="uk-grid datatables-bottom">
                        <div class="uk-width-medium-1-3" id="datatables-length"></div>
                        <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                        <div class="uk-width-medium-1-3">
                            @if(!Auth::user()->hasRole('admin'))  <a
                                    class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                                    href="#" id="add-new">{{ __('users.add_new') }}</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
    @php

        if (!empty($cities)){
            $data['cities'] = $cities;
          }

            if (!empty($company_id))
            {
                $data['company_id'] = $company_id;
            }


                $data['companyRoles'] = $companyRoles;
                $data['projectRoles'] = $projectRoles;

            if (!empty($seniorities))
            {
                $data['seniorities'] = $seniorities;
            }

            if (!empty($offices))
            {
                $data['offices'] = $offices;
            }

            if (isset($workgroups) && !empty($workgroups) && count($workgroups) > 0)
            {
                $data['workgroups'] = $workgroups;
            }
    @endphp
    @component('users/create', $data)

    @endcomponent
@endsection


<script src="{{ asset('js/projects.js') }}"></script>
<script type="text/javascript">

    Projects.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
</script>