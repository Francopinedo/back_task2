@extends('layouts.app')

@section('scripts')
    @include('datatables.basic')
    <script>
        $(function () {
            var tableName = 'kpis';
            var urlParameters = '?company_id={{ $company->id }}';
            var columns = [
                {data: 'id', name: 'id', visible: false},
                {data: 'kpi', name: 'kpi'},
                {data: 'category_name', name: 'category_name'},

                {data: 'nombre', name: 'nombre'},

                {data: 'description', name: 'description'},
                {data: 'showkpi', name: 'show',
		 render: function (data, type, row) {
                        if (row.showkpi == '1') {
			return 'YES';
			}else{
			return 'NO';}
			}

			},
               // {data: 'type_of_result', name: 'type_of_result'},
               // {data: 'graphic_type', name: 'graphic_type'},
               // {data: 'query', name: 'query'},
                {data: 'actions', name: 'actions'}
            ];

            var actions = [
                {
                    pre: '<a title={{__('general.edit')}} href="/kpis/',
                    post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
                }
                /* {
                 pre: '<a href="/kpis/',
                 post: '/delete" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                 }*/
            ];

            DtablesUtil(tableName, columns, actions, urlParameters);
        });
    </script>
@endsection

@section('section_title', __('kpis.kpis'))

@section('content')

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <!--<div class="uk-width-1-1">
                    <div class="alert alert-info">
                        INDICADORES:<BR>
                        <strong>$PCW</strong> => Percentage of the completed work<br>
                        <strong>$PB</strong> => Project Budget<br>
                        <strong>$AV</strong> => Real Cost<br>
                        <strong>$PF</strong> => Profit<br>
                    </div>
                </div>-->
                <div class="uk-width-1-1">

                    @if(session()->has('message'))
                        <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                    @endif

                    {{-- @if(!session()->has('project_id'))
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                    @endif --}}

                    {{-- @if(session()->has('project_id')) --}}
                    <table id="kpis-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th title="{{__('kpis_tooltip.id')}}">{{ __('kpis.id') }}</th>
                            <th title="{{__('kpis_tooltip.kpi')}}">{{ __('kpis.kpi') }}</th>
                            <th title="{{__('kpis_tooltip.category')}}">{{ __('kpis.category') }}</th>
                            <th title="{{__('kpis_tooltip.nombre')}}">{{ __('kpis.nombre') }}</th>

                            <th title="{{__('kpis_tooltip.description')}}">{{ __('kpis.description') }}</th>
                        <!--   <th title="{{__('kpis_tooltip.type_of_result')}}">{{ __('kpis.type_of_result') }}</th>
                            <th title="{{__('kpis_tooltip.graphic_type')}}">{{ __('kpis.graphic_type') }}</th>
                            <th title="{{__('kpis_tooltip.query')}}">{{ __('kpis.query') }}</th>-->
                            <th title="{{__('kpis_tooltip.show')}}">{{ __('kpis.show') }}</th>
                            <th title="{{__('general.actions')}}">{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="uk-grid datatables-bottom">
                        <div class="uk-width-medium-1-3" id="datatables-length"></div>
                        <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                        <div class="uk-width-medium-1-3">
                           <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"
                               href="#" id="add-new" title="{{ __('kpis.add_new') }}">{{ __('kpis.add_new') }}</a>
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
    @component('kpi/create', ['company' => $company, 'categories'=>$categories])

    @endcomponent
@endsection
