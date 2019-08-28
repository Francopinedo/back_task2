@extends('layouts.login')

@section('content')

<div class="md-card">
    <div class="md-card-content large-padding">
    	<div class="login_heading">
            <img src="{{URL::asset('/assets/img/logo_mono.png')}}" alt="TaskControl" class="logo_login">
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

			<div class="uk-form-row">
                <label for="name">{{ __('register.name') }}</label>
                <input class="md-input" type="text" id="name" name="name" value="{{ old('name') }}" required autofocus />

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="uk-form-row">
                <label for="email">{{ __('register.email') }}</label>
                <input class="md-input" type="email" id="email" name="email" value="{{ old('email') }}" required />

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="uk-form-row">
                <label for="password">{{ __('register.password') }}</label>
                <input class="md-input" type="password" id="password" name="password" value="{{ old('password') }}" required />

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="uk-form-row">
                <label for="password-confirm">{{ __('register.password-confirm') }}</label>
                <input class="md-input" type="password" id="password-confirm" name="password_confirmation" value="{{ old('password-confirm') }}" required />

                @if ($errors->has('password-confirm'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password-confirm') }}</strong>
                    </span>
                @endif
            </div>

            <div class="uk-margin-medium-top">
                <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">{{ __('register.register') }}</button>
            </div>
        </form>

    </div>
</div>
@endsection
