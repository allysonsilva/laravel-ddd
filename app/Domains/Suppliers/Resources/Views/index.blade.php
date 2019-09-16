@extends('layouts::master')

@section('pageTitle')
    @parent - Fornecedores
@stop

@section('content')
    <div class="page-head">
        <h2 class="page-head-title">Gerenciamento de Fornecedores</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><span class="btn btn-secondary hover icon mdi mdi-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Fornecedores</a></li>
                <li class="breadcrumb-item active">Listagem</li>
            </ol>
        </nav>
    </div>

    <div class="main-content container-fluid">
        @if ($suppliers->isNotEmpty())
            <div class="row">
                <div class="col-sm-12">
                    <div class="app-table card card-table card-border card-contrast card-border-color card-border-color-primary">
                        @include('suppliers::_header')

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col"> Nome </th>
                                                    <th scope="col"> E-mail </th>
                                                    <th class="text-center" scope="col"> Mensalidade </th>
                                                    <th class="text-center" scope="col"> Status </th>
                                                    <th scope="col"> Criação </th>
                                                    <th class="text-center" scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @includeIf('suppliers::_filter')
                                                @foreach ($suppliers as $supplier)
                                                    <tr>
                                                        <td> {{ $supplier->name }} </td>
                                                        <td> {{ $supplier->email }} </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-secondary font-weight-bold">{{ to_money_PTBR($supplier->monthly_payment) }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <h4> {!! html_status($supplier->is_activated) !!} </h4>
                                                        </td>
                                                        <td> {{ optional($supplier->created_at)->format('d/m/Y H:i') }} </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('suppliers.edit', [$supplier->getKey()]) }}" class="btn btn-space btn-outline-primary" title="Editar fornecedor">
                                                                <span class="icon mdi mdi-pencil"></span>
                                                            </a>

                                                            <script nonce="3VrLCT9ctX">
                                                                document.addEventListener('DOMContentLoaded', function () {
                                                                    document.getElementById("btn-remove-register-{{ $supplier->getKey() }}").addEventListener("click", function(event) {
                                                                        event.preventDefault();
                                                                        document.getElementById("form-delete-{{ $supplier->getKey() }}").submit();
                                                                    });
                                                                });
                                                            </script>

                                                            <button class="btn btn-space btn-outline-danger" type="button" id="btn-remove-register-{{ $supplier->getKey() }}" title="Remover fornecedor - {{ $supplier->name }}">
                                                                <i class="icon mdi mdi-delete"></i>
                                                            </button>

                                                            {!! Form::open(['class' => 'inline', 'method' => 'DELETE', 'route' => ['suppliers.destroy', $supplier->getKey()], 'id' => 'form-delete-' . $supplier->getKey() ]) !!}
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
                                    Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }}
                                    @if ($suppliers instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    of {{ $suppliers->total() }} entries
                                    @endif
                                </div>
                                <div class="col-sm-7">
                                    {!! $suppliers->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h3 class="text-center"> Nenhum fornecedor pôde ser encontrado <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-lg btn-space btn-3d" target="_blank" title="Criar novo fornecedor">
                <i class="fa fa-plus"></i> Criar novo fornecedor </a>
            </h3>
        @endif
    </div>
@stop
