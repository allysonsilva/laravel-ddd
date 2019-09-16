@extends('layouts::master')

@section('content')
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card text-center card-border-color card-border-color-primary">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                    <span class="mdi mdi-close" aria-hidden="true"></span>
                                </button>
                                <div class="icon"><span class="mdi mdi-check"></span></div>
                                <div class="message"><strong>Good!</strong> {{ __('A fresh verification link has been sent to your email address.') }}</div>
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},

                        <form class="d-inline" method="POST" action="{{ route('auth.verification.resend') }}">
                            @csrf

                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline font-weight-bold">
                                {{ __('click here to request another') }}
                            </button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
