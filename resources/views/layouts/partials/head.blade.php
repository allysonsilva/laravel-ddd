<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('images/logo-fav.png') }}" type="image/png">

    <title>@section('pageTitle') {{ config('app.name') }} @show</title>

    <link href="https://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700,800|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ mix('css/base.css') }}">
    <link rel="stylesheet" href="{{ mix('css/components.css') }}">
    <link rel="stylesheet" href="{{ mix('css/libs.css') }}">
    <link rel="stylesheet" href="{{ mix('css/custom.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" href="{{ mix('fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ mix('fonts/material-icons.css') }}">

    @stack('styles')
</head>
