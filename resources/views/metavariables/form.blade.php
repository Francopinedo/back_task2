{{ csrf_field() }}
            <input type="hidden" name="added_by" value="form">
            <div class="uk-width-medium-1-1 uk-row-first">

                 <div class="md-input-wrapper {{isset($metavariable) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metavariables.name') }}</label>
                    <input type="text" class="md-input" name="name" value="{{isset($metavariable) ? $metavariable->name : ''}}" required><span class="md-input-bar"></span>
                </div>

                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('metavariables.metadocument_name') }}</label>
                    <select name="metadocument_id" data-md-selectize>
                        <option value="">{{ __('metavariables.metadocument_name') }}...</option>
                        @foreach ($metadocuments as $m)
                            <option value="{{ $m->id }}" {{ (isset($metavariable) && $m->id == $metavariable->metadocument_id) ? 'selected' : '' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required metadocument_id-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                    <label>{{ __('metavariables.metavariable_kind_name') }}</label>
                    <select name="metavariable_kind_id" data-md-selectize>
                        <option value="">{{ __('metavariables.metavariable_kind_name') }}...</option>
                        @foreach ($metavariable_kinds as $ma)
                            <option value="{{ $ma->id }}" {{ (isset($metavariable) && $ma->id == $metavariable->metavariable_kind_id) ? 'selected' : '' }}>{{ $ma->name_en }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required metavariable_kind_id-error"></span></div>


                <div class="md-input-wrapper {{isset($metavariable) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metavariables.caption') }}</label>
                    <input type="text" class="md-input" name="caption" value="{{isset($metavariable) ? $metavariable->caption : ''}}"><span class="md-input-bar"></span>
                </div>

                <div class="md-input-wrapper {{isset($metavariable) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metavariables.dependencies') }}</label>
                    <input type="text" class="md-input" name="dependencies" value="{{isset($metavariable) ? $metavariable->dependencies : ''}}"><span class="md-input-bar"></span>
                </div>

                <div class="md-input-wrapper {{isset($metavariable) ? 'md-input-filled' : ''}}">
                    <label>{{ __('metavariables.width') }}</label>
                    <input type="number" max="100" min="0" class="md-input" name="width" value="{{isset($metavariable) ? $metavariable->width : ''}}"><span class="md-input-bar"></span>
                </div>

                <div class="parsley-errors-list filled"><span class="parsley-required width-error"></span></div>
                
            </div>