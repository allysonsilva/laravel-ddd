@extends('layouts::master')

@section('pageTitle')
    @parent - Blank Page
@stop

@section('content')
    <div class="page-head">
        <h2 class="page-head-title">Blank Page</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active">Blank Page Header</li>
            </ol>
        </nav>
    </div>

    <div class="main-content container-fluid">
        <h3 class="text-center">Content goes here!</h3>
    </div>
@endsection
