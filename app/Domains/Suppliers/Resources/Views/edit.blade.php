@extends('layouts::master')

@section('pageTitle')
    @parent - Editar Fornecedor
@stop

@section('content')
    <div class="page-head">
        <h2 class="page-head-title">Gerenciamento de Fornecedores</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><span class="btn btn-secondary hover icon mdi mdi-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Fornecedores</a></li>
                <li class="breadcrumb-item active">Editar Fornecedor</li>
            </ol>
        </nav>
    </div>

    <div class="main-content container-fluid">
        @includeIf('suppliers::_form')
    </div>
@stop
