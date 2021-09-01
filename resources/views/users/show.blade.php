<div class="info_div_header">
	<div>
		{{ $user->name }}
	</div>
</div>
<div class="uk-grid uk-grid-divider uk-grid-medium info_div_content">
    <div class="uk-width-large-1-2">
        <h2 class="heading_c uk-margin-small-bottom">{{ __('users.contact_info') }}</h2>
        <ul class="md-list md-list-addon">
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $user->email }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('users.email') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-address-card-o fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $user->address }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('users.address') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-phone fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $user->office_phone }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('users.office_phone') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-phone fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $user->home_phone }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('users.home_phone') }}</span>
                </div>
            </li>
            <li>
                <div class="md-list-addon-element">
                    <i class="fa fa-mobile fa-2x" aria-hidden="true"></i>
                </div>
                <div class="md-list-content">
                    <span class="md-list-heading">{{ $user->cell_phone }}</span>
                    <span class="uk-text-small uk-text-muted">{{ __('users.cell_phone') }}</span>
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
                    <span class="md-list-heading">{{$user->name}}</span>
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
        </ul>
    </div>
</div>
