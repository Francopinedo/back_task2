<style>
   .uk-width-1-3 a{ word-wrap: break-word; font-size: 14px!important; }
</style>
<style>
    .uk-width-1-2 a {
        word-wrap: break-word;
        font-size: 14px !important;
    }
    .uk-width-2-3 a {
        word-wrap: break-word;
        float: left;
        font-size: 14px !important;
    }
    .template-upload {
        background: transparent !important;
    .template-download {
        background: transparent !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

     <script   src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>

<script src="bower_components/parsleyjs/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<div class="md-card-content">

        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1 uk-row-first">

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1 uk-row-first">
                            <div class="uk-input-group uk-width-medium-1">
                                {{--<span class="uk-input-group-addon">
                                    <i class="fa fa-building-o fa-15"></i>
                                </span>--}}
                                <select name="language" id="language" data-md-selectize>
                                    <option value="">{{ __('catalog.language') }}...</option>
                                    @foreach($idiomas as $idioma)
                                        @if($idioma->code == 'EN' or $idioma->code == 'ES')
                                            <option value="{{ $idioma->code }}"
                                                    >{{ $idioma->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1 uk-row-first">
                            <div class="uk-input-group uk-width-medium-1">
                                <select name="directory" id="directory" data-md-selectize>
                                    <option value="">{{ __('catalog.directory') }}...</option>
                                    @if(isset($directories))
                                        @foreach($directories as $directory)
                                            <option value="{{ $directory->path }}">{{ $directory->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1 uk-row-first">
                            <div class="uk-input-group uk-width-medium-1 uk-grid" data-uk-grid-margin  id="documents">

                            </div>
                        </div>
                    </div>
                </div>


                {{-- @foreachc($metavariables as $key => $metavariable )
                     @if($metavariable->variable_type == 'T')
                         <div class="uk-form-row">
                             <div class="uk-grid" data-uk-grid-margin="">
                                 <div class="uk-width-medium-1 uk-row-first">
                                     <div class="md-input-wrapper">
                                         <label>{{$metavariable->variable_name}}</label>
                                         <input type="text" class="md-input" name="{{$metavariable->variable_name}}" title="{{$metavariable->caption}}">
                                         <span class="md-input-bar "></span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     @endif
                     @if($metavariable->variable_type == 'N')
                         <div class="uk-form-row">
                             <div class="uk-grid" data-uk-grid-margin="">
                                 <div class="uk-width-medium-1 uk-row-first">
                                     <div class="md-input-wrapper">
                                         <label>{{$metavariable->variable_name}}</label>
                                         <input type="number"  class="md-input" name="{{$metavariable->variable_name}}" title="{{$metavariable->caption}}">
                                         <span class="md-input-bar "></span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     @endif
                     @if($metavariable->variable_type == 'D')
                         <div class="uk-form-row">
                             <div class="uk-grid">
                                 <div class="uk-width-large-2-3 uk-width-1-1">
                                     <div class="uk-input-group">
                                         <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                         <div class="md-input-wrapper">
                                             <label for="uk_dp_{{$key}}">{{$metavariable->variable_name}}</label>
                                             <input class="md-input" name="{{$metavariable->variable_name}}" type="text" id="uk_dp_{{$key}}" data-uk-datepicker="{format:'DD.MM.YYYY'}">
                                             <span class="md-input-bar "></span>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     @endif
                     @if($metavariable->variable_type == 'TA')
                         <div class="uk-form-row">
                             <div class="md-input-wrapper md-input-filled">
                                 <label>{{$metavariable->variable_name}}</label>--}}{{--selecize_init--}}{{--
                                 <textarea cols="30" rows="4" name="{{$metavariable->variable_name}}" class="md-input autosized" style="overflow-x: hidden; word-wrap: break-word; height: 180px;" title="{{$metavariable->caption}}"></textarea>
                                 <span class="md-input-bar "></span>
                             </div>
                         </div>
                     @endif
                 @endforeach--}}

        <div class="uk-form-row hidden" id="upload_file_div2">
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1 uk-row-first">

                <label>{{ __('metadocuments.document') }}</label>
            

                </div>
            </div>
        </div>

            </div>
        </div>
</div>