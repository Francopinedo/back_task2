@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/emails_page.js') }}"></script>
    <script src="{{ asset('js/table_actions.js') }}"></script>
    <script src="/assets/js/pages/page_mailbox.min.js"></script>

    <script type="text/javascript">
        var new_category = '{{ __('emails.new_category') }}';
        var company_id = '{{ is_object($company)?$company->id:'' }}';
        var confirm_text = '{{__('holidays.are_you_sure')}}';
        $(document).ready(function () {
            emails.init();
            tableActions.initEdit();
        })

    </script>
@endsection

@section('content')
    <div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-2 uk-grid-width-large-1-3 uk-margin-large-bottom hierarchical_show"
         data-uk-grid="{gutter: 20}">
        @foreach ($emailCategories as $emailCategory)
            <div>
                <h4 class="heading_c uk-margin-bottom">
                    {{ ($emailCategory->title) }}


                    @if (Auth::user()->hasPermission('manage.emails') || Auth::user()->hasRole('user'))
                        <a href="/emails/{{ $emailCategory->id }}/edit_category" class="edit-btn"><i
                                    class="fa fa-pencil md-icon" aria-hidden="true"></i></a>
                        <a href="/emails/{{ $emailCategory->id }}/delete_category" class="delete-btn"><i
                                    class="fa fa-trash md-icon" aria-hidden="true"></i></a>

                    @endif
                    <div>
                        <ul class="uk-nestable" id="nestable">
                            @foreach ($emailCategory->emails->data as $email)
                                <li data-id="1" class="uk-nestable-item">
                                    <div class="uk-nestable-panel">
                                        <div class="md-card-list-item-menu email-icons">
                                            <a
                                                    href="#mailbox_new_message"
                                                    class="md-icon material-icons email-composer-link"
                                                    data-uk-modal="{center:true}"
                                                    data-id="{{ $email->id }}"
                                                    title="{{ __('emails.compose') }}"
                                            >
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </a>
                                            @if (Auth::user()->hasPermission('manage.emails') || Auth::user()->hasRole('user') )
                                                <a
                                                        href="/emails/{{ $email->id }}/edit"
                                                        class="md-icon material-icons edit-btn"
                                                        data-id="{{ $email->id }}">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a
                                                        href="/emails/{{ $email->id }}/delete"
                                                        class="md-icon material-icons delete-btn"
                                                        data-id="{{ $email->id }}">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                        {{ $email->title }} <br/>
                                    </div>

                                </li>
                            @endforeach
                        </ul>
                    </div>
            </div>
        @endforeach
    </div>

    {{-- SECCTION DE EMAIL COMPOSER --}}

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
            <form id="email-form"  enctype="multipart/form-data">
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
@endsection


@section('create_div')
    @component('email/create', ['email_categories' => $emailCategories])

    @endcomponent
@endsection