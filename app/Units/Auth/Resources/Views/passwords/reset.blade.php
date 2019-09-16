@extends('layouts::master')

@section('pageTitle')
    @parent - {{ __('Reset Password') }}
@stop

@section('bodyClass', 'app-splash-screen')

@section('navigation', false)
@section('left-sidebar', false)

@push('styles')
    <style nonce="2726c7f26c">
        .splash-container.forgot-password .card .card-header{margin-bottom:5px}
    </style>
@endpush

@section('content')
    <div class="main-content container-fluid">

        <div class="splash-container forgot-password">
            <div class="card card-border-color card-border-color-primary">
                <div class="card-header">
                    <img class="logo-img" src="{{ asset('images/logo-xx.png') }}" alt="logo" width="102" height="27">
                    <span class="splash-description">Please enter your new password.</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('auth.password.update') }}" method="POST">
                        @csrf
                        <span class="splash-title pb-4">{{ __('Reset Password') }}</span>

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="{{ __('Password') }}">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="{{ __('Confirm Password') }}">
                        </div>

                        <div class="form-group pt-2">
                            <button class="btn btn-block btn-primary btn-xl" type="submit">{{ __('Reset Password') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
