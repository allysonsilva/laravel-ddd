@extends('layouts::master')

@section('pageTitle')
    @parent - {{ __('Login') }}
@stop

@section('bodyClass', 'app-splash-screen')

@section('navigation', false)
@section('left-sidebar', false)

@push('styles')
    <style nonce="2726c7f26c">
        .row.login-tools{padding:15px 0 0;margin-bottom:16px}.login-forgot-password{line-height:2.1;text-align:right}.login-submit,.row.login-submit{padding:19px 0 0;margin-bottom:1.3842rem}.login-submit .btn,.row.login-submit .btn{width:100%}.login-submit>div:first-child,.row.login-submit>div:first-child{padding-right:10px}.login-submit>div:last-child,.row.login-submit>div:last-child{padding-left:10px}
    </style>
@endpush

@section('content')
    <div class="main-content container-fluid">
        <div class="splash-container">
            <div class="card card-border-color card-border-color-primary">
                <div class="card-header">
                    <img class="logo-img" src="{{ asset('images/logo-xx.png') }}" alt="logo" width="102" height="27">
                    <span class="splash-description">Please enter your user information.</span>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf

                        <div class="login-form">
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row login-tools">
                                <div class="col-6 login-remember">
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label custom-control-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                @if (Route::has('auth.password.request'))
                                    <div class="col-6 login-forgot-password">
                                        <a href="{{ route('auth.password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group row login-submit">
                                <div class="col-6">
                                    <a class="btn btn-secondary btn-xl" href="{{ route('auth.show-form-register') }}">Register</a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-xl"> {{ __('Login') }} </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
