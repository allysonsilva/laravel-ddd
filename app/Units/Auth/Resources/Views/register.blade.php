@extends('layouts::master')

@section('pageTitle')
    @parent - {{ __('Register') }}
@stop

@section('bodyClass', 'app-splash-screen')

@section('navigation', false)
@section('left-sidebar', false)

@push('styles')
    <style nonce="2726c7f26c">
        .splash-container.sign-up{max-width:433px;margin:10px auto}.splash-container.sign-up .card .card-header{margin-bottom:0}.signup-password.row{padding:0;margin-bottom:1.3842rem}.signup-password .btn{width:100%}.signup-password>div:first-child{padding-right:10px}.signup-password>div:last-child{padding-left:10px}.splash-container.forgot-password .card .card-header{margin-bottom:5px}
    </style>
@endpush

@section('content')
    <div class="main-content container-fluid">

        <div class="splash-container sign-up">
            <div class="card card-border-color card-border-color-primary">

                <div class="card-header">
                    <img class="logo-img" src="{{ asset('images/logo-xx.png') }}" alt="logo" width="102" height="27">
                    <span class="splash-description">Please enter your user information.</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('auth.register') }}" method="POST">
                        @csrf
                        <span class="splash-title pb-4">Sign Up</span>

                        <div class="form-group">
                            <input id="name" type="text" class="form-control @error('user.name') is-invalid @enderror" name="user[name]" value="{{ old('user.name') }}" required autocomplete="name" placeholder="{{ __('Nome') }}" autofocus>
                            @error('user.name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('user.email') is-invalid @enderror" name="user[email]" value="{{ old('user.email') }}" required autocomplete="email" placeholder="{{ __('E-Mail') }}">

                            @error('user.email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row signup-password">
                            <div class="col-6">
                                <input id="password" type="password" class="form-control @error('user.password') is-invalid @enderror" name="user[password]" required placeholder="{{ __('Password') }}">
                                @error('user.password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <input id="password-confirm" type="password" class="form-control" name="user[password_confirmation]" required placeholder="{{ __('Confirmar Password') }}">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <input id="cnpj" type="text" class="form-control @error('company.cnpj') is-invalid @enderror" name="company[cnpj]" value="{{ old('company.cnpj') }}" required autocomplete="cnpj" placeholder="{{ __('CNPJ') }}">
                            @error('company.cnpj')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <sub class="text text-warning">{{ __('* Deve conter apenas números') }}</sub>
                        </div>

                        <div class="form-group">
                            <input id="social-name" type="text" class="form-control @error('company.social_name') is-invalid @enderror" name="company[social_name]" value="{{ old('company.social_name') }}" required autocomplete="social_name" placeholder="{{ __('Razão Social') }}">
                            @error('company.social_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="fantasy-name" type="text" class="form-control @error('company.fantasy_name') is-invalid @enderror" name="company[fantasy_name]" value="{{ old('company.fantasy_name') }}" autocomplete="fantasy_name" placeholder="{{ __('Nome Fantasia') }}">
                            @error('company.fantasy_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="phone" type="text" class="form-control @error('company.phone') is-invalid @enderror" name="company[phone]" value="{{ old('company.phone') }}" autocomplete="phone" placeholder="{{ __('Número de Telefone') }}">
                            @error('company.phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <sub class="text text-warning">{{ __('* Deve conter apenas números') }}</sub>
                        </div>

                        <div class="form-group">
                            <input id="address" type="text" class="form-control @error('company.address') is-invalid @enderror" name="company[address]" value="{{ old('company.address') }}" autocomplete="address" placeholder="{{ __('Endereço Completo') }}">
                            @error('company.address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="postal-code" type="text" class="form-control @error('company.postal_code') is-invalid @enderror" name="company[postal_code]" value="{{ old('company.postal_code') }}" autocomplete="postal_code" placeholder="{{ __('CEP') }}">
                            @error('company.postal_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <sub class="text text-warning">{{ __('* Deve conter apenas números') }}</sub>
                        </div>

                        <div class="form-group pt-2">
                            <button class="btn btn-block btn-primary btn-xl" type="submit">{{ __('Register') }}</button>
                        </div>

                        <div class="title"><span class="splash-title pb-3">Or</span></div>

                        <div class="form-group row social-signup pt-0">
                            <div class="col-6">
                                <button class="btn btn-lg btn-block btn-social btn-facebook btn-color" type="button"><i class="mdi mdi-facebook icon icon-left"></i>Facebook</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-lg btn-block btn-social btn-google-plus btn-color" type="button"><i class="mdi mdi-google-plus icon icon-left"></i>Google Plus</button>
                            </div>
                        </div>

                        <div class="form-group pt-3 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="check1">
                                <label class="custom-control-label" for="check1">By creating an account, you agree the <a href="#">terms and conditions</a>.</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="splash-footer">© {{ date('Y') }} Your Company</div>
        </div>

    </div>
@endsection
