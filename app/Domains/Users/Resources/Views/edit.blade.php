@extends('layouts::master')

@section('pageTitle')
    @parent - Editar Usuário
@stop

@section('content')
    <div class="page-head">
        <h2 class="page-head-title">Gerenciamento de Usuários</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><span class="btn btn-secondary hover icon mdi mdi-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
                <li class="breadcrumb-item active">Editar Usuário</li>
            </ol>
        </nav>
    </div>

    <div class="main-content container-fluid">
        @includeIf('users::_form')
    </div>
@stop
