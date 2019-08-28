<style>

   .uk-width-1-3 a{ word-wrap: break-word; font-size: 14px!important; }
</style>

<div class="md-card-content">

    <form id="preferences-form" method="GET" action="catalog/form">
        {{ csrf_field() }}

        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1 uk-row-first">

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1 uk-row-first">
                            <div class="uk-input-group uk-width-medium-1">
                                {{--<span class="uk-input-group-addon">
                                    <i class="fa fa-building-o fa-15"></i>
                                </span>--}}
                                <select name="dataType" data-md-selectize>
                                    <option value="1" selected> Manual</option>
                                    <!--  <option disabled hidden> Automatic</option>-->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1 uk-row-first">
                            <div class="uk-input-group uk-width-medium-1">
                                {{--<span class="uk-input-group-addon">
                                    <i class="fa fa-building-o fa-15"></i>
                                </span>--}}
                                <select name="lenguage" id="lenguage" data-md-selectize>
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

                <!--<div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1 uk-row-first">
                            <div class="uk-input-group uk-width-medium-1">
                                <label for="extension">Descarga en </label>
                                <br>
                                <input type="radio" name="extension" value="doc"> DOC
                                <br>
                                <input type="radio" name="extension" value="docx"> DOCX
                                <br>
                                <!-- <input type="radio" name="extension" value="pdf"> PDF-->
                           <!-- </div>
                        </div>
                    </div>
                </div>-->

               <!-- <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1 uk-row-first">
                            <div class="md-input-wrapper">
                                <button type="submit" class="md-btn md-btn-primary">Descarga</button>
                               <button type="button" class="md-btn md-btn-primary" id="preview">Preview</button>
                            </div>
                        </div>
                    </div>
                </div>-->

            </div>
        </div>
    </form>
</div>

@section('scripts')
    <script src="{{ asset('js/catalog.js') }}"></script>
    <script type="text/javascript">

        Catalog.init('<?php echo e(env('API_PATH')); ?>', '<?php echo e(env('APP_URL')); ?>');
    </script>

@endsection
