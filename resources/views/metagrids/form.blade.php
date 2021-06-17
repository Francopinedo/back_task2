{{ csrf_field() }}
            <input type="hidden" name="added_by" value="form">
            <div class="uk-width-medium-1-1 uk-row-first">

                 <div class="md-input-wrapper {{isset($metagrid) ? 'md-input-filled' : ''}}">
                  <label>{{ __('metavariables.name') }}</label>
                  <input type="text" class="md-input" name="name" value="{{isset($metagrid) ? $metagrid->name : ''}}" required><span class="md-input-bar"></span>
                </div>

                <div class="parsley-errors-list filled"><span class="parsley-required name-error"></span></div>

                <div class="md-input-wrapper md-input-select">
                  <label>{{ __('metavariables.metadocument_name') }}</label>
                  <select name="metadocument_id" data-md-selectize>
                      <option value="">{{ __('metavariables.metadocument_name') }}...</option>
                      @foreach ($metadocuments as $m)
                          <option value="{{ $m->id }}" {{ (isset($metagrid) && $m->id == $metagrid->metadocument_id) ? 'selected' : '' }}>{{ $m->name }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="parsley-errors-list filled"><span class="parsley-required metadocument_id-error"></span></div>
                
                <div class="md-input-wrapper {{isset($metagrid) ? 'md-input-filled' : ''}}">
                  <label>{{ __('metavariables.caption') }}</label>
                  <input type="text" class="md-input" name="caption" value="{{isset($metagrid) ? $metagrid->caption : ''}}"><span class="md-input-bar"></span>
                </div>

            </div>