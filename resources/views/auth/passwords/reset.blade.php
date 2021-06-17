@extends('layouts.login')

@section('content')

    <div class="md-card">
        <div class="md-card-content large-padding">
            <div class="login_heading">
                <img src="{{URL::asset('/assets/img/logo_mono.png')}}" alt="TaskControl" class="logo_login">
            </div>
            <div class="login_heading">
                <h2>Reset Password</h2>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">

                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="uk-form-row">
                    <label for="email">E-Mail Address</label>
                    <input class="md-input" type="email" id="email" name="email" value="{{ $email or old('email') }}" required autofocus />

                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="uk-form-row">
                    <label for="password">Password</label>
                    <input class="md-input" type="password" id="password" name="password" required />

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="uk-form-row">
                    <label for="password-confirm">Confirm Password</label>
                    <input class="md-input" id="password-confirm" type="password" name="password_confirmation" required />

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="uk-margin-medium-top">
                    <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Reset Password</button>
                </div>

            </form>
        </div>
    </div>
@endsection
