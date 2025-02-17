@extends('layouts.app')

@section('scripts')
    @include('datatables.basic')
    <script>
        $(function () {
            var tableName = 'offices';
            var urlParameters = '?company_id={{ $company->id }}';
            var columns = [
                {data: 'id', name: 'id', visible: false},
                {data: 'title', name: 'title'},
                {data: 'city_name', name: 'city_name'},
                {data: 'workinghours_from', name: 'workinghours_from'},
                {data: 'workinghours_to', name: 'workinghours_to'},
                {data: 'hours_by_day', name: 'hours_by_day'},
                {data: 'effective_workinghours', name: 'effective_workinghours'},
                {data: 'actions', name: 'actions'}
            ];

            var actions = [
                {
                    pre: '<a title="{{__('general.edit')}}" href="/offices/',
                    post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
                },
                {
                    pre: '<a title="{{__('general.delete')}}" href="/offices/',
                    post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                }
            ];

            var extra_buttons = [{
                text: 'IMPORT',
                action: function (e, dt, node, config) {

                    var self = this;

                    // inicializo acciones del boton editar
                    var $switcher_ajax_create = $('#ajax_create_div'),
                        $switcher_ajax_create_toggle = $('#ajax_create_div_toggle'),
                        $ajax_create_url = 'offices/import';


                    e.preventDefault();

                    $switcher_ajax_create_toggle.show();
                    $('#ajax_create_div').addClass('switcher_active');
                    $('#ajax_create_div').css('position', 'absolute');
                    $.ajax({
                        url: $ajax_create_url,
                        type: 'GET',
                        dataType: 'json'
                    }).done(
                        function(data){
                            $('.ajax_create_div').html(data.view);
                        }
                    );


                    $switcher_ajax_create_toggle.click(function (e) {
                        e.preventDefault();
                        $switcher_ajax_create.toggleClass('switcher_active');
                        //  $('#ajax_create_div').css('position','relative');
                    });

                }
            }];
            DtablesUtil(tableName, columns, actions, urlParameters, extra_buttons);
        });
    </script>
@endsection

@section('section_title', __('offices.offices'))

@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1">

                    @if(session()->has('message'))
                        <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                    @endif

                    <table id="offices-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th title="{{ __('offices_tooltip.id')}}">{{ __('offices.id') }}</th>
                            <th title="{{ __('offices_tooltip.title')}}">{{ __('offices.title') }}</th>
                            <th title="{{ __('offices_tooltip.city')}}">{{ __('offices.city') }}</th>
                            <th title="{{ __('offices_tooltip.workinghours_from')}}">{{ __('offices.workinghours_from') }}</th>
                            <th title="{{ __('offices_tooltip.workinghours_to')}}">{{ __('offices.workinghours_to') }}</th>
                            <th title="{{ __('offices_tooltip.hours_by_day')}}">{{ __('offices.hours_by_day') }}</th>
                            <th title="{{ __('offices_tooltip.effective_workinghours')}}">{{ __('offices.effective_workinghours') }}</th>
                            <th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="uk-grid datatables-bottom">
                        <div class="uk-width-medium-1-3" id="datatables-length"></div>
                        <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                        <div class="uk-width-medium-1-3">
                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                               href="#" id="add-new" title="{{ __('offices_tooltip.add_new')}}">{{ __('offices.add_new') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
    @component('office/create', ['company' => $company, 'cities' => $cities])

    @endcomponent
@endsection
