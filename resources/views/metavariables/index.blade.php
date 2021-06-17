@extends('layouts.app')

@section('scripts')
    @include('datatables.basic')
    <script>
    $(function() {
        var tableName = 'metavariables';
        var columns = [
                { data: 'id', name: 'id'},
                { data: 'metadocument_name', name: 'metadocument_name' },
                { data: 'metavariable_kind_name', name: 'metavariable_kind_name' },
                { data: 'name', name: 'name' },
                { data: 'caption', name: 'caption' },
                { data: 'dependencies', name: 'dependencies' },
                { data: 'metadocument_id', name: 'metadocument_id', visible: false },
                { data: 'width', name: 'width' },
                { data: 'actions', name: 'actions'}
            ];

        var actions = [
                        { pre: '<a title="{{__('general.edit')}}" href="/metavariables/', post: '/edit" class="table-actions edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>' },
                        { pre: '<a title="{{__('general.delete')}}" href="/metavariables/', post: '/destroy" class="table-actions delete-btn"><i class="fa fa-trash" aria-hidden="true"></i></a>' }
                    ];

        DtablesUtil(tableName, columns, actions);
    });
    </script>
@endsection

@section('section_title', __('metavariables.metavariables'))

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

                    <table id="metavariables-table" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th title="{{ __('metavariables_tooltip.id') }}">{{ __('metavariables.id') }}</th>
                                <th title="{{ __('metavariables_tooltip.metadocument_name') }}">{{ __('metavariables.metadocument_name') }}</th>
                                <th title="{{ __('metavariables_tooltip.metavariable_kind_name') }}">{{ __('metavariables.metavariable_kind_name') }}</th>
                                <th title="{{ __('metavariables_tooltip.name') }}">{{ __('metavariables.name') }}</th>
                                <th title="{{ __('metavariables_tooltip.caption') }}">{{ __('metavariables.caption') }}</th>
                                <th title="{{ __('metavariables_tooltip.dependencies') }}">{{ __('metavariables.dependencies') }}</th>
                                <th title="{{ __('metavariables_tooltip.metadocument_id') }}">{{ __('metavariables.metadocument_id') }}</th>
                                <th title="{{ __('metavariables_tooltip.width') }}">{{ __('metavariables.width') }}</th>
                                <th title="{{ __('general.actions') }}">{{ __('general.actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="uk-grid datatables-bottom">
                        <div class="uk-width-medium-1-3" id="datatables-length"></div>
                        <div class="uk-width-medium-1-3" id="datatables-pagination"></div>
                        <div class="uk-width-medium-1-3">
                            <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new" title="{{ __('metavariables.add_new') }}">{{ __('metavariables.add_new') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('create_div')
    @component('metavariables/create',['metadocuments' => $metadocuments, 'metavariable_kinds' => $metavariable_kinds])

    @endcomponent
@endsection