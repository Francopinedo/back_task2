{{ csrf_field() }}
            <input type="hidden" name="added_by" value="form">
            <div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-input-wrapper {{isset($metadocument) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metadocuments.name') }}</label>
                    <input type="text" class="md-input" name="name" value="{{isset($metadocument) ? $metadocument->name : ''}}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('metadocuments.lang') }}</label>
                    <select name="language_id" data-md-selectize>
                        <option value="">{{ __('metadocuments.lang') }}...</option>
                        @foreach ($languages as $l)
                            <option value="{{ $l->id }}" {{ (isset($metadocument) && $l->id == $metadocument->language_id) ? 'selected' : '' }}>{{ $l->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required languaje-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('metadocuments.activity') }}</label>
                    <select name="activity_id" data-md-selectize>
                        <option value="">{{ __('metadocuments.activity') }}...</option>
                        @foreach ($activities as $a)
                            <option value="{{ $a->id }}" {{ (isset($metadocument) && $a->id == $metadocument->activity_id) ? 'selected' : '' }}>{{ $a->activity_desc }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required activity-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('metadocuments.docType') }}</label>
                    <select name="doctype_id" data-md-selectize>
                        <option value="">{{ __('metadocuments.docType') }}...</option>
                        @foreach ($docTypes as $d)
                            <option value="{{ $d->id }}" {{ (isset($metadocument) && $d->id == $metadocument->doctype_id) ? 'selected' : '' }}>{{ $d->type_desc }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required document_type-error"></span></div>

                <div class="md-input-wrapper {{isset($metadocument) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metadocuments.version') }}</label>
                    <input type="number" max="99" min="1" class="md-input" name="version" value="{{isset($metadocument) ? $metadocument->version : ''}}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required version-error"></span></div>

                <div class="md-input-wrapper {{isset($metadocument) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metadocuments.link_logo_left') }}</label>
                    <input type="text" class="md-input" name="link_logo_left" value="{{isset($metadocument) ? $metadocument->link_logo_left : ''}}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required link_logo_left-error"></span></div>

                <div class="md-input-wrapper {{isset($metadocument) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metadocuments.link_logo_right') }}</label>
                    <input type="text" class="md-input" name="link_logo_right" value="{{isset($metadocument) ? $metadocument->link_logo_right : ''}}"><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required link_logo_right-error"></span></div>

                <div class="md-input-wrapper {{isset($metadocument) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metadocuments.path_ref') }}</label>
                    <input type="text" class="md-input" name="path_ref" value="{{isset($metadocument) ? $metadocument->path_ref : ''}}" required><span class="md-input-bar"></span>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required path_ref-error"></span></div>

            </div>