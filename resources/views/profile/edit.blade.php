@extends('layouts.app')

@section('section_title', __('profile.profile'))

@section('scripts')

    <script src="{{ asset('js/profile.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            profile.init();
        });

    </script>
@endsection

@section('content')

    <div class="md-card">
        <div class="md-card-content">


            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-large-10-10">
                    <div class="md-card">
                        <form action="{{ URL::to('/') }}/profile/update" data-redirect-on-success="{{ url('profile') }}"
                              method="post" class=" uk-form-stacked" id="user_edit_form" >
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{Auth::id()}}">
                            <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
                                <div class="user_heading_avatar">
                                    <div class="thumbnail">
                                        @if (empty(Auth::user()->profile_image_path))
                                            <img alt="user avatar" id="profile_photo"
                                                 src="{{ URL::to('/') }}/assets/img/avatardefault.png">

                                        @else
                                            <img src="{{ URL::to('/') .'/assets/img/users/profile/'.Auth::user()->id.'/'.Auth::user()->profile_image_path }}"
                                                 alt="user avatar" id="profile_photo">
                                        @endif
                                    </div>
                                </div>
                                <div style="float: left;display: inline-block;margin-right: 50px;height: 100px;padding-top:30px;">

                                    <a class="uk-form-file md-btn" id="upload_widget_opener">Upload image
                                        <input type="file"
                                               id="profile_image" name="profile_image_path" accept="image/*"
                                               >
                                    </a>
                                </div>

                                <div class="user_heading_content">
                                    <h2 class="heading_b"><span class="uk-text-truncate" id="user_edit_uname">
                                    	<input type="text" class="md-input" name="name" value="{{ $user->name }}"
                                               required>
                                    </span></h2>
                                </div>
                                <a class="md-fab md-fab-small md-fab-accent hidden-print" href="#"
                                   title="{{ __('profile.save') }}" id="save-profile-btn" type="submit">
                                    <i class="fa fa-floppy-o fa-15"></i>
                                </a>
                            </div>
                            <div class="user_content">
                                <ul id="user_edit_tabs" class="uk-tab"
                                    data-uk-tab="{connect:'#user_edit_tabs_content'}">
                                    <li class="uk-active"><a href="#">{{ __('profile.basic') }}</a></li>
                                    <li><a href="#">{{ __('profile.preferences') }}</a></li>
                                </ul>
                                <ul id="user_edit_tabs_content" class="uk-switcher uk-margin">
                                    <!--==============================================
                                    =            Pestaña de datos basicos            =
                                    ===============================================-->
                                    <li>
                                        <div class="uk-margin-top">
                                            <h3 class="full_width_in_card heading_c">
                                                {{ __('profile.contact_info') }}
                                            </h3>
                                            <div class="uk-grid">
                                                <div class="uk-width-1-1">
                                                    <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-1"
                                                         data-uk-grid-margin>
                                                        <div>
                                                            <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="fa fa-envelope fa-15"></i>
                                                                </span>
                                                                <label>{{ __('profile.email') }}</label>
                                                                <input type="email" class="md-input" name="email"
                                                                       value="{{ $user->email }}" required>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="fa fa-address-card-o fa-15"></i>
                                                                </span>
                                                                <label>{{ __('profile.address') }}</label>
                                                                <input type="text" class="md-input" name="address"
                                                                       value="{{ $user->address }}"/>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="fa fa-phone fa-15"></i>
                                                                </span>
                                                                <label>{{ __('profile.office_phone') }}</label>
                                                                <input type="text" class="md-input" name="office_phone"
                                                                       value="{{ $user->office_phone }}"/>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="fa fa-phone-square fa-15"></i>
                                                                </span>
                                                                <label>{{ __('profile.home_phone') }}</label>
                                                                <input type="text" class="md-input" name="home_phone"
                                                                       value="{{ $user->home_phone }}">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="fa fa-mobile fa-15"></i>
                                                                </span>
                                                                <label>{{ __('profile.cell_phone') }}</label>
                                                                <input type="text" class="md-input" name="cell_phone"
                                                                       value="{{ $user->cell_phone }}"/>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="fa fa-language fa-15"></i>
                                                                </span>
                                                                <label>{{ __('profile.language') }}</label>
                                                                <select name="language_id"  data-md-selectize>
                                                                    <option value="">{{ __('profile.language') }}...</option>
                                                                    @foreach ($languages as $language)
                                                                    <option value="{{ $language->id }}" {{ ($language->id == $user->language_id) ? 'selected' : '' }}>{{ $language->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>


                                                   
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!--=============================================
                                    =            Pestaña de Preferencias            =
                                    ==============================================-->
                                    <li>
                                        <div class="uk-grid uk-grid-divider" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-4 uk-row-first">
                                                <h3 class="heading_a">{{ __('profile.sidebar') }}</h3>
                                                <br>
                                                <div>
                                                    <label class="inline-label">
                                                        <input
                                                                type="radio"
                                                                class="ios-switch-cb"
                                                                name="sidebar"
                                                                value="sidebar_mini" {{ Auth::user()->sidebar == 'sidebar_mini' || empty(Auth::user()->sidebar) ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.sidebar_mini') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input
                                                                type="radio"
                                                                class="ios-switch-cb"
                                                                name="sidebar"
                                                                value="sidebar_main_open" {{ Auth::user()->sidebar == 'sidebar_main_open' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.sidebar_normal') }}
                                                    </label>
                                                </div>
                                            </div>

                                              <div class="uk-width-medium-1-4 uk-row-first">
                                            <h3 class="heading_a">{{ __('profile.tooltip') }}</h3>
                                            <br>
                                            <div>
                                                    <label class="inline-label">
                                                    <input
                                                        type="checkbox"
                                                        class="ios-switch-cb"
                                                        name="tooltip" 
                                                        id="tooltip"
                                                        value="{{ Auth::user()->tooltip}}"  {{ Auth::user()->tooltip == '0'?'':'checked'}}>
                                                    <span class="switchery"></span>
                                                    {{ __('profile.tooltip') }}
                                                </label>
                                            </div>
                                            
                                        </div>
                                            <div class="uk-width-medium-1-4">
                                                <h3 class="heading_a">{{ __('profile.theme') }}</h3>
                                                <br>
                                                <div>
                                                    <label class="inline-label">
                                                        <input
                                                                type="radio"
                                                                class="ios-switch-cb"
                                                                name="theme"
                                                                value="app_theme_default" {{ (Auth::user()->theme == 'app_theme_default' || empty(Auth::user()->theme)) ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_default') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input
                                                                type="radio" class="ios-switch-cb" name="theme"
                                                                value="app_theme_a" {{ Auth::user()->theme == 'app_theme_a' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_a') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_b" {{ Auth::user()->theme == 'app_theme_b' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_b') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_c" {{ Auth::user()->theme == 'app_theme_c' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_c') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_d" {{ Auth::user()->theme == 'app_theme_d' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_d') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_e" {{ Auth::user()->theme == 'app_theme_e' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_e') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_f" {{ Auth::user()->theme == 'app_theme_f' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_f') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_g" {{ Auth::user()->theme == 'app_theme_g' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_g') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_h" {{ Auth::user()->theme == 'app_theme_h' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_h') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_i" {{ Auth::user()->theme == 'app_theme_i' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_i') }}
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="inline-label">
                                                        <input type="radio" class="ios-switch-cb" name="theme"
                                                               value="app_theme_dark" {{ Auth::user()->theme == 'app_theme_dark' ? 'checked' : '' }}>
                                                        <span class="switchery"></span>
                                                        {{ __('profile.theme_dark') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                               
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                
                                            </div>
                                        </div>


                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script>
  
// var changeCheckbox = document.querySelector('#tooltip')

// changeCheckbox.onchange = function() {
// changeCheckbox.checked;
// };

    </script>
@endsection
