@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/permissions.js') }}"></script>
    <script>
        $(document).ready(function () {
            permission.init();
        });
    </script>
@endsection

@section('section_title', __('permissions.permissions'))

<style>
    .uk-width-medium-1-4, .uk-width-medium-3-4, .uk-width-medium-1-2, .uk-width-medium-1-3, inline-label {
        float: left;
    }

    .ml-10 {
        margin-left: 20px;
    }

    .uk-width-medium-3-4 {
        border-left: 1px solid white;
        padding-left: 10px
    }
</style>
@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid uk-grid-divider" data-uk-grid-margin="">
                @foreach ($companyRoles as $companyRole)
                    <div class="uk-width-large-1-4 uk-width-medium-1-1 uk-row-first">
                        <div class="md-list-content">
                            <span class="md-list-heading">
                            	<a href="#r{{ $companyRole->id }}">{{ $companyRole->title }}</a>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                @foreach ($companyRoles as $companyRole)

                    <div class="uk-width-medium-1-1">
                        <h5 id="r{{ $companyRole->id }}" class="heading_c uk-margin-bottom uk-margin-top">
                            <strong>{{ $companyRole->title }}</strong></h5>
                        <div class="uk-width-medium-1-4">
                            <h5>{{__('permissions.system_permisions')}}</h5>
                            @foreach ($permissions as $permission)
                                <div class="uk-width-medium-1-1">
                                    <label class="inline-label">
            						<span class="spinner_checkbox" style="display: none;"
                                          data-permission_id="{{ $permission->id }}"
                                          data-role_id="{{ $companyRole->role->data->id }}">
            							<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
            							<span class="sr-only">Loading...</span>
            						</span>
                                        <input
                                                type="checkbox"
                                                class="ios-switch-cb permission-checkbox"
                                                {{ (!empty($activePermissionsIds[$companyRole->id]) && in_array($permission->id, $activePermissionsIds[$companyRole->id])) ? 'checked' : ''  }}
                                                data-permission_id="{{ $permission->id }}"
                                                data-role_id="{{ $companyRole->role->data->id }}"
                                                data-state="{{ (!empty($activePermissionsIds[$companyRole->id]) && in_array($permission->id, $activePermissionsIds[$companyRole->id])) ? 'checked' : '' }}"
                                        >
                                        <span class="switchery"></span>
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        {{-- @foreach ($companyRole->role->data->permissionRoles->data as $permissionRole)
                            <div class="uk-width-medium-1-3">
                                <input type="checkbox" data-switchery checked id="switch_demo_1" />
                                <label for="switch_demo_1" class="inline-label">Service offline</label>
                                <span class="uk-form-help-block">Checked</span>
                            </div>
                        @endforeach --}}


                        <div class="uk-width-medium-3-4">
                            <h5>{{__('permissions.repository_permisions')}}</h5>
                            @foreach ($directories as $directory)
                                <div class="uk-width-medium-1-2">
                                    <label class="inline-label">

                                        <h3 style="text-decoration: underline">{{ $directory['nombre'] }}</h3>
                                        <br>
                                        {{__('permissions.read')}}

                                        <input
                                                type="checkbox"
                                                class="directory-checkbox"
                                                {{ (!empty($activeDirectoriesIdsRead[$companyRole->id]) && in_array($directory['id'], $activeDirectoriesIdsRead[$companyRole->id])) ? 'checked' : ''  }}
                                                data-directory_id="{{ $directory['id'] }}"
                                                data-role_id="{{ $companyRole->role->data->id }}"
                                                data-type="read">

                                        {{__('permissions.write')}}

                                        <input
                                                type="checkbox"
                                                class="directory-checkbox"
                                                {{ (!empty($activeDirectoriesIdsWrite[$companyRole->id]) && in_array($directory['id'], $activeDirectoriesIdsWrite[$companyRole->id])) ? 'checked' : ''  }}
                                                data-directory_id="{{ $directory['id'] }}"
                                                data-role_id="{{ $companyRole->role->data->id }}"
                                                data-type="write">


                                    </label>
                                    <br>


                                    @foreach ($directory['folders'] as $folder)

                                        <div class="uk-width-medium-1-2 ml-10">
                                            <label class="inline-label">
                                                <h4>  {{ $folder['nombre'] }}</h4>

                                                {{__('permissions.read')}}

                                                <input
                                                        type="checkbox"
                                                        class="directory-checkbox"
                                                        {{ (!empty($activeDirectoriesIdsRead[$companyRole->id]) && in_array($folder['id'], $activeDirectoriesIdsRead[$companyRole->id])) ? 'checked' : ''  }}
                                                        data-directory_id="{{ $folder['id']}}"
                                                        data-role_id="{{ $companyRole->role->data->id }}"
                                                        data-type="read"
                                                >

                                                {{__('permissions.write')}}

                                                <input
                                                        type="checkbox"
                                                        class="directory-checkbox"
                                                        {{ (!empty($activeDirectoriesIdsWrite[$companyRole->id]) && in_array($folder['id'], $activeDirectoriesIdsWrite[$companyRole->id])) ? 'checked' : ''  }}
                                                        data-directory_id="{{ $folder['id']}}"
                                                        data-role_id="{{ $companyRole->role->data->id }}"
                                                        data-type="write"
                                                >


                                            </label>

                                        <br>
                                        @foreach ($folder['subfolders'] as $subfolder)

                                            <div class="uk-width-medium-1-2 ml-10">
                                                <label class="inline-label">

                                                    {{ $subfolder['nombre'] }}

                                                    <br>
                                                    {{__('permissions.read')}}
                                                    <input
                                                            type="checkbox"
                                                            class="directory-checkbox"
                                                            {{ (!empty($activeDirectoriesIdsRead[$companyRole->id]) && in_array($subfolder['id'], $activeDirectoriesIdsRead[$companyRole->id])) ? 'checked' : ''  }}
                                                            data-directory_id="{{ $subfolder['id']}}"
                                                            data-role_id="{{ $companyRole->role->data->id }}"
                                                            data-type="read"
                                                    >
                                                    {{__('permissions.write')}}
                                                    <input
                                                            type="checkbox"
                                                            class="directory-checkbox"
                                                            {{ (!empty($activeDirectoriesIdsWrite[$companyRole->id]) && in_array($subfolder['id'], $activeDirectoriesIdsWrite[$companyRole->id])) ? 'checked' : ''  }}
                                                            data-directory_id="{{ $subfolder['id']}}"
                                                            data-role_id="{{ $companyRole->role->data->id }}"
                                                            data-type="write"
                                                    >


                                                </label>
                                            </div>
                                        @endforeach
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection