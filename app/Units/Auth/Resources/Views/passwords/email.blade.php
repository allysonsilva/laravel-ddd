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
                    <span class="splash-description">{{ __('Forgot Your Password?') }}</span>
                </div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success alert-icon alert-icon-border alert-dismissible" role="alert">
                            <div class="icon"><span class="mdi mdi-check"></span></div>
                            <div class="message">
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                                <strong>{{ session('status') }}</strong>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.password.email') }}">
                        @csrf

                        <p>Don't worry, we'll send you an email to reset your password.</p>

                        <div class="form-group pt-4">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Your Email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <p class="pt-1 pb-4">Don't remember your email? <a href="#">Contact Support</a>.</p>
                        <div class="form-group pt-1">
                            <button type="submit" class="btn btn-block btn-primary btn-xl">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="splash-footer">© {{ date('Y') }} Your Company</div>
        </div>
    </div>
@endsection
