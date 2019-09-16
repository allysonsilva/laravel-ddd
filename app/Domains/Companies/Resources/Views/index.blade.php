@extends('layouts::master')

@section('pageTitle')
    @parent - Empresas
@stop

@section('content')
    <div class="page-head">
        <h2 class="page-head-title">Gerenciamento de Empresas</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><span class="btn btn-secondary hover icon mdi mdi-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Empresas</a></li>
                <li class="breadcrumb-item active">Listagem</li>
            </ol>
        </nav>
    </div>

    <div class="main-content container-fluid">
        @if ($companies->isNotEmpty())
            <div class="row">
                <div class="col-sm-12">
                    <div class="app-table card card-table card-border card-contrast card-border-color card-border-color-primary">
                        @include('companies::_header')

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col"> Usuário </th>
                                                    <th scope="col"> CNPJ </th>
                                                    <th scope="col"> Razão + Fantasia </th>
                                                    <th scope="col"> Contato </th>
                                                    <th scope="col"> Endereço </th>
                                                    <th class="text-center" scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @includeIf('companies::_filter')
                                                @foreach ($companies as $company)
                                                    <tr>
                                                        <td class="cell-detail">
                                                            <span>{{ optional($company)->user_name }}</span>
                                                            <span class="cell-detail-description">{{ optional($company)->user_email }}</span>
                                                        </td>
                                                        <td> {{ $company->cnpj }} </td>
                                                        <td class="cell-detail">
                                                            <span>{{ $company->social_name }}</span>
                                                            <span class="cell-detail-description">{{ $company->fantasy_name }}</span>
                                                        </td>
                                                        <td> {{ $company->phone }} </td>
                                                        <td class="cell-detail">
                                                            <span>{{ $company->address }}</span>
                                                            <span class="cell-detail-description">{{ $company->postal_code }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('companies.edit', [$company->getKey()]) }}" class="btn btn-space btn-outline-primary" title="Editar empresa">
                                                                <span class="icon mdi mdi-pencil"></span>
                                                            </a>

                                                            <script nonce="3VrLCT9ctX">
                                                                document.addEventListener('DOMContentLoaded', function () {
                                                                    document.getElementById("btn-remove-register-{{ $company->getKey() }}").addEventListener("click", function(event) {
                                                                        event.preventDefault();
                                                                        document.getElementById("form-delete-{{ $company->getKey() }}").submit();
                                                                    });
                                                                });
                                                            </script>

                                                            <button class="btn btn-space btn-outline-danger" type="button" id="btn-remove-register-{{ $company->getKey() }}" title="Remover empresa - {{ $company->fantasy_name }}">
                                                                <i class="icon mdi mdi-delete"></i>
                                                            </button>

                                                            {!! Form::open(['class' => 'inline', 'method' => 'DELETE', 'route' => ['companies.destroy', $company->getKey()], 'id' => 'form-delete-' . $company->getKey() ]) !!}
                                                            {!! Form::close() !!}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row app-table-footer">
                                <div class="col-sm-5 table-footer-info d-flex align-items-center">
                                    Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }}
                                    @if ($companies instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    of {{ $companies->total() }} entries
                                    @endif
                                </div>
                                <div class="col-sm-7">
                                    {!! $companies->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h3 class="text-center"> Nenhuma empresa pôde ser encontrado <a href="{{ route('companies.create') }}" class="btn btn-primary btn-lg btn-space btn-3d" target="_blank" title="Criar nova empresa">
                <i class="fa fa-plus"></i> Criar nova empresa </a>
            </h3>
        @endif
    </div>
@stop
