@extends('layouts.app', ['favoriteTitle' => __('catalog.repository'), 'favoriteUrl' => url(Request::path())])

@section('section_title', __('catalog.repository'))

@section('content')
    
    <!-- Alerta que hay que seleccionar un cliente / proyecto-->
    @if( !session()->has('project_id') )
        <div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ __('projects.you_need_a_project') }}
        </div>
    @endif

    @if(session()->has('project_id'))
        @include('repository.form')
    @endif
    
@endsection

@section('scripts')
{{--    <script src="/bower_components/parsleyjs/dist/parsley.min.js"></script>--}}
    <!--<script src="{{ asset('js/word_preference.js') }}"></script>-->
    <script>

        $.fn.serializeObject = function () {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };

        $.ajaxTransport("+binary", function(options, originalOptions, jqXHR){
            // check for conditions and support for blob / arraybuffer response type
            if (window.FormData && ((options.dataType && (options.dataType == 'binary')) || (options.data && ((window.ArrayBuffer && options.data instanceof ArrayBuffer) || (window.Blob && options.data instanceof Blob)))))
            {
                return {
                    // create new XMLHttpRequest
                    send: function(_, callback){
                        // setup all variables
                        var xhr = new XMLHttpRequest(),
                            url = options.url,
                            type = options.type,
                            // blob or arraybuffer. Default is blob
                            dataType = options.responseType || "blob",
                            data = options.data || null;

                        xhr.addEventListener('load', function(){
                            var data = {};
                            data[options.dataType] = xhr.response;
                            // make callback and send data
                            callback(xhr.status, xhr.statusText, data, xhr.getAllResponseHeaders());
                        });

                        xhr.open(type, url, true);
                        xhr.responseType = dataType;
                        xhr.send(data);
                    },
                    abort: function(){
                        jqXHR.abort();
                    }
                };
            }
        });

    </script>
   {{-- <script src="/assets/js/custom/wizard_steps.min.js"></script>
    <script src="/bower_components/handlebars/handlebars.min.js"></script>
    <script src="/assets/js/custom/handlebars_helpers.min.js"></script>
    <script src="/assets/js/pages/forms_wizard.min.js"></script>
    <script>
        $(document).ready(function () {
            wordPreference.init();
        });
    </script>--}}
    <!-- handlebars.js -->
@endsection

