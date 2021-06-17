@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/emails_page.js') }}"></script>
    <script src="{{ asset('js/table_actions.js') }}"></script>
    <script src="{{ asset('assets/js/pages/page_mailbox.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <script type="text/javascript">
        var new_category = '{{ __('emails.new_category') }}';
        var company_id = '{{ is_object($company)?$company->id:'' }}';
        var confirm_text = '{{__('holidays.are_you_sure')}}';
        $(document).ready(function () {
            emails.init();
            tableActions.initEdit();
        })

    </script>
    <script>
        window.clientKey = "{{ $clientKey ??'' }}";
        window.secretKey = "{{ $secretKey ??'' }}";
        window.hostKey = "{{ $hostKey ??'' }}";
        window.tcApiHostKey = "{{ $tcApiHost ??'' }}";
        window.userIdKey = "{{ $userIdKey ??'' }}";
    </script>
@endsection

@section('content')


    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-1-1">
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
                        <v-container fluid fill-height>
{{--                            <search-bar></search-bar>--}}
                            <navbar v-bind:selectedtheme="{{ json_encode($selectedtheme) }}"></navbar>
                            <mails :key="$route.path"></mails>
                            <compose-button v-bind:contacts="{{  json_encode($toSend) }}"></compose-button>
                        </v-container>
                    </v-app>
                                     </div>
            </div>
        </div>
    </div>

    {{--        @endsection--}}

 {{--   --}}{{-- SECCTION DE EMAIL COMPOSER --}}{{--

    <div class="md-fab-wrapper md-fab-in-card">
        <div class="md-fab md-fab-accent md-fab-sheet">
            <i class="fa fa-plus" aria-hidden="true"></i>
            <div class="md-fab-sheet-actions">
                <a href="#" class="md-color-white" data-uk-modal="{center:true}" id="add-email-category"><i
                            class="fa fa-list-alt">&#xE2C7;</i> {{ __('emails.new_category') }}</a>
                <a href="#" class="md-color-white" id="add-new" style="float: none;"><i
                            class="fa fa-envelope-o"></i> {{ __('emails.new_email_template') }}</a>
                <a href="#" class="md-color-white" id="reload_emails" style="float: none;"><i
                            class="fa fa-reload"></i> {{ __('emails.reload_emails') }}</a>
            <!--<a href="#" class="md-color-white" id="reload_cat" style="float: none;"><i class="fa fa-reload"></i> {{ __('emails.reload_cat') }}</a>-->
            </div>
        </div>
    </div>


    <div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
            <div class="loading-email">
                <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">{{ __('general.loading') }}...</span>
            </div>
            <button class="uk-modal-close uk-close" type="button"></button>
            <form id="email-form"  enctype="multipart/form-data" >
                {{ csrf_field() }}
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">{{ __('emails.compose') }}</h3>
                </div>
                <div class="uk-margin-medium-bottom md-input-wrapper md-input-filled">
                    <label for="mail_new_to">{{ __('emails.to') }}</label>
                    <select name="to" data-md-selectize class="mail_new_to">
                        <option value="">{{ __('emails.to') }}...</option>
                        <optgroup label="Contacts">

                            @foreach ($contacts as $contact)
                                <option value="{{ $contact->email }}">{{ $contact->name }}
                                </option>
                            @endforeach
                        </optgroup>

                        <optgroup label="Providers">

                            @foreach ($providers as $contact)
                                <option value="{{ $contact->email_1 }}">{{ $contact->name }}
                                </option>
                            @endforeach
                        </optgroup>

                        <optgroup label="Customers">

                            @foreach ($customers as $contact)
                                <option value="{{ $contact->email}}">{{ $contact->name }}
                                </option>
                            @endforeach
                        </optgroup>


                        <optgroup label="Users">

                            @foreach ($users as $contact)
                                <option value="{{ $contact->email}}">{{ $contact->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>

                </div>
                <div class="uk-margin-medium-bottom md-input-wrapper md-input-filled">
                    <label for="mail_new_to">{{ __('emails.subject') }}</label>
                    <input type="text" class="md-input" name="subject" id="mail_new_subject">
                </div>
                <div class="uk-margin-large-bottom md-input-wrapper md-input-filled">
                    <label for="mail_new_message">{{ __('emails.message') }}</label>
                    <textarea name="message" id="mail_new_message" cols="30" rows="6" class="md-input"></textarea>
                </div>
                <div id="mail_upload-drop" class="uk-file-upload">
                    <p class="uk-text">{{ __('emails.drop_file') }}</p>
                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                    <a class="uk-form-file md-btn">{{ __('emails.choose_file') }}<input class="mail_upload-select"
                                                                                        type="file"></a>
                </div>
                <div id="mail_progressbar" class="uk-progress uk-hidden">
                    <div class="uk-progress-bar" style="width:0">0%</div>
                </div>
                <div class="uk-modal-footer">
                    <a href="#" class="md-icon-btn"><i class="md-icon material-icons">&#xE226;</i></a>
                    <button type="button" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary"
                            id="sendEmail">{{ __('emails.send') }}</button>
                </div>
            </form>
        </div>
    </div>
--}}
@endsection


@section('create_div')
    @component('email/create', ['email_categories' => $emailCategories])

    @endcomponent
@endsection
