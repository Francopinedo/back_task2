<div class="info_div_header">
	<div>
		{{ $customer->name }}<br>
		<span class="sub-heading"><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;&nbsp;{{ $customer->industry->data->name or '' }}</span>
	</div>
</div>
<div class="uk-grid uk-grid-divider uk-grid-medium info_div_content">
    <div class="uk-width-large-1-2">
        <h2 class="heading_c uk-margin-small-bottom">{{ __('companies.info') }}</h2>
        <ul class="md-list md-list-addon">
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-address-card-o fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->address }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.address') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-globe fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->country->data->name }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('customers.country') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->city->data->name }} ({{ $customer->city->data->location_name }})</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.city') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->email }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.email') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-phone fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->phone }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.phone') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->billing_name }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.billing_name') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->billing_address }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.billing_address') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->tax_number1 }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.tax_number') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->bank_name }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.bank_name') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->account_number }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.account_number') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->swiftcode }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.swiftcode') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->aba }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.aba') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-usd fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $customer->currency->data->code }} ({{ $customer->currency->data->name }})</span>
                    <span class="uk-text-small uk-text-muted">{{ __('companies.currency') }}</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="uk-width-large-1-2">
    	<h2 class="heading_c uk-margin-small-bottom">{{__('users.detail')}}</h2>
        <ul class="md-list md-list-addon">
            <li>
                <div class="md-list-addon-element">
                    <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt="">
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">Bianka Turner</span>
                    <span class="uk-text-small uk-text-muted">{{__('users.assigned')}}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="md-list-addon-icon material-icons"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">14 Jun 2015</span>
                    <span class="uk-text-small uk-text-muted">{{__('users.created')}}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="md-list-addon-icon material-icons"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">18 Jun 2015</span>
                    <span class="uk-text-small uk-text-muted">{{__('users.updated')}}</span>
                </div>
</li>
            <li>
<div class="md-list-addon-element">
                    <i class="md-list-addon-icon material-icons"></i>
                </div>
                    <span class="md-list-heading">Logo</span>
			<div class="md-list-content thumbnail">

                                        @if (empty($customer->logo_path) || $customer->logo_path=='')
                                            <img alt="logo" id="logo_path"
                                                 src="{{ URL::to('/') }}/assets/img/avatardefault.png">

                                        @else
                                            <img src="{{ URL::to('/') .'/assets/img/customers/'. $customer->id .'/'. $customer->logo_path }}"
                                                 alt="" >
                                        @endif
                                    </div>
            </li>
        </ul>
    </div>
</div>
