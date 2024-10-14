@extends('layouts.app', ['favoriteTitle' => __('customers.customers'), 'favoriteUrl' => 'customers'])

@section('scripts')
    <script src="/js/customers_page.js"></script>
    <script src="/js/table_actions.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            customers_page.init();
            tableActions.initEdit();
            tableActions.initDelete('{{ __('general.confirm') }}');
            tableActions.initInfo();
        });
    </script>
@endsection

@section('section_title', __('customers.customers'))

@section('content')

    <!--<div class="md-card uk-margin-medium-bottom">
	    <div class="md-card-content">
	        <div class="uk-grid" data-uk-grid-margin>
	            <div class="uk-width-medium-1-2">
	                <div class="uk-vertical-align">
	                    <div class="uk-vertical-align-middle">
	                        <ul id="customers_list_filter" class="uk-subnav uk-subnav-pill uk-margin-remove">
	                            <li class="uk-active" data-uk-filter=""><a href="#">All</a></li>
	                            <li data-uk-filter="goodwin-nienow"><a href="#">Goodwin-Nienow</a></li>
	                            <li data-uk-filter="strosin groupa"><a href="#">Strosin Groupa</a></li>
	                            <li data-uk-filter="schamberger plc"><a href="#">Schamberger PLC </a></li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	            <div class="uk-width-medium-1-2">
	                <label for="customers_list_search">Search... (min 3 char.)</label>
	                <input class="md-input" type="text" id="customers_list_search"/>
	            </div>
	        </div>
	    </div>
	</div>

	<h3 class="heading_b uk-text-center grid_no_results" style="display:none">No results found</h3>-->
    @if(session()->has('message'))
        <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
            <a href="#" class="uk-alert-close uk-close"></a>
            {{ session('message') }}
        </div>
    @endif
    <a href="#" ontype="button" class="btn btn-default add-new" onclick="load_mport();">Import</a>
    <div class="uk-grid-width-medium-1-2 uk-grid-width-large-1-3 hierarchical_show" id="customers_list">

        @foreach ($customers as $customer)
            <div data-uk-filter="sin,asd">
                <div class="md-card md-card-hover md-card-horizontal">
                    <div class="md-card-head">
                        <div class="md-card-head-menu" data-uk-dropdown="{pos:'bottom-left'}">
                            <i class="fa fa-ellipsis-v fa-2x" aria-hidden="true"></i>
                            <div class="uk-dropdown uk-dropdown-small">
                                <ul class="uk-nav">
                                    <li><a href="/customers/{{ $customer->id }}/edit"
                                           class="table-actions edit-btn">{{ __('general.edit') }}</a></li>
                                    @if(Auth::user()->hasPermission('delete.users'))
                                        <li><a href="/customers/{{ $customer->id }}/delete" class="delete-btn">{{ __('general.delete') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="v-center">
                            <h3 class="md-card-head-text uk-text-center">
                                {{ $customer->name }}
                                @if ($customer->industry->data->name)
                                    <span class="sub-heading"><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;&nbsp;{{ $customer->industry->data->name }}</span>
                                @endif
                            </h3>
 <div class="md-card-head-text uk-text-center">
  				@if (empty($customer->logo_path) || $customer->logo_path=='')
                                          

                                        @else
                                            <img style="width:100px" src="{{ URL::to('/') .'/logos/customers/'. $customer->id .'/'. $customer->logo_path }}"
                                                 alt="logo" id="logo_path" >
                                        @endif
                        </div>
 </div>
                    </div>
                    <div class="md-card-content">
                        <ul class="md-list">
                            <li>
                                <div class="md-list-content">
                                    <span class="md-list-heading">{{ $customer->city->data->name }}</span>
                                    <span class="uk-text-small uk-text-muted uk-text-truncate">{{ __('customers.city') }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-content">
                                    <span class="md-list-heading">X</span>
                                    <span class="uk-text-small uk-text-muted uk-text-truncate">Otro dato de empresa</span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-content">
                                    <span class="md-list-heading">Y</span>
                                    <span class="uk-text-small uk-text-muted uk-text-truncate">Otro dato de empresa</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="md-card-footer">
                        <a href="/customers/{{ $customer->id }}" title="{{ __('customers.show') }}" class="info-btn"
                           data-uk-modal="{target:'#modal_info'}"><i class="fa fa-info-circle fa-2x"
                                                                     aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
       function load_mport() {
            $.ajax({
                url: 'customers/import',
                type: 'GET',
                dataType: 'json'
            }).done(
                function (data) {
                    var $switcher_ajax_create = $('#ajax_create_div'),
                        $switcher_ajax_create_toggle = $('#ajax_create_div_toggle');

                    $('#ajax_create_div').addClass('switcher_active');
                    $('#ajax_create_div').css('position', 'absolute');
                    $('.ajax_create_div').html(data.view);
                }
            );
        }

    </script>
    @if (!Auth::user()->hasRole('admin'))
        <div class="md-fab-wrapper">
            {{-- <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="#" id="add-new">{{ __('customers.add_new') }}</a> --}}
            <a class="md-fab md-fab-accent" href="#" id="add-new" title="{{ __('customers.add_new') }}">
                <i class="fa fa-plus fa15"></i>
            </a>
        </div>
    @endif
@endsection



<div id="ajax_create_div">
    <div id="ajax_create_div_toggle" style="display: none;"><i class="fa fa-angle-double-right fa-2x"
                                                               aria-hidden="true"></i></div>
    <div class="ajax_create_div">

    </div>
</div>




@if (!Auth::user()->hasRole('admin'))
@section('create_div')
    @component('customer/create', ['cities' => $cities,'countries' => $countries,  'currencies' => $currencies, 'industries' => $industries, 'company' => $company])

    @endcomponent
@endsection
{{-- expr --}}
@endif
