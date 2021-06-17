@extends('layouts.app', ['favoriteTitle' => __('catalog.repository_backup'), 'favoriteUrl' => url(Request::path())])

@section('section_title', __('catalog.repository_backup'))

@section('content')



    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1-1 uk-row-first">

                <form id="data-form-ajax_create" action="{{ url('repository_backup/download') }}"
                      method="post">
                    {{ csrf_field() }}
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1 uk-row-first">
                                <div class="uk-input-group uk-width-medium-1">
                                    <label>{{ __('catalog.customer') }}</label>
                                    <select name="customer" id="customer" data-md-selectize>
                                        <option value="">{{ __('catalog.customer') }}...</option>
                                        @foreach($customers as $customer)

                                            <option value="{{ $customer->id }}"
                                            >{{ $customer->name }}</option>

                                        @endforeach
                                    </select>
                                    <div class="parsley-errors-list filled"><span
                                                class="parsley-required customer-error"></span></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1 uk-row-first">
                                <div class="uk-input-group uk-width-medium-1">
                                    <label>{{ __('catalog.project') }}</label>
                                    <select name="project" id="project" data-md-selectize>
                                        <option value="">{{ __('catalog.project') }}...</option>

                                    </select>
                                    <div class="parsley-errors-list filled"><span
                                                class="parsley-required project-error"></span></div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1 uk-row-first">
                                <div class="uk-input-group uk-width-medium-1">
                                    <button class="md-btn md-btn-primary md-btn-wave-light md-btn-block waves-effect waves-button waves-light"
                                            type="button" id="ajax_create-btn">
                                        DOWNLOAD
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@section('scripts')


    <script>

        $(document).ready(function () {

            var form = $('#data-form-ajax_create');

            $('#ajax_create-btn').click(function () {


                if ($("#customer").val() == '') {
                    $('.customer-error').html('The customer field is required.');
                }else  if ($("#project").val() == '') {
                    $('.project-error').html('The project field is required.');
                }else{
                    $.ajax({
                        url:"/repository_backup/validate_download",
                        data:{
                            customer:$("#customer").val(),
                            project:$("#project").val(),
                            _token:$("input[name=_token]").val()
                        },
                        dataType:'json',
                        type:'post',
                        success:function (data) {
                            if(data.error!=undefined){
                                alert(data.error);
                            }else{
                                form.submit();
                            }
                        },
                        error:function () {
                            alert('error');
                        }
                    })

                }

            });


            $("#customer").on('change', function () {
                $.ajax({
                    url: API_PATH + '/projects?customer_id=' + $("#customer").val(),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {

                        var html = '<option value="">Project...</option>';


                        $('#project').selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });


                        $('#project').html(html);
                        $('#project').selectize();
                    },
                    error: function () {
                        alert('Error');
                    }
                })
            });


        })
    </script>
@endsection