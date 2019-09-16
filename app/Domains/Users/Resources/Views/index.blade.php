@extends('layouts::master')

@section('pageTitle')
    @parent - Usuários
@stop

@section('content')
    <div class="page-head">
        <h2 class="page-head-title">Gerenciamento de Usuários</h2>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb page-head-nav">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><span class="btn btn-secondary hover icon mdi mdi-home"></span></a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
                <li class="breadcrumb-item active">Listagem</li>
            </ol>
        </nav>
    </div>

    <div class="main-content container-fluid">
        @if ($users->isNotEmpty())
            <div class="row">
                <div class="col-sm-12">
                    <div class="app-table card card-table card-border card-contrast card-border-color card-border-color-primary">
                        @include('users::_header')

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="checkall">
                                                            <label class="custom-control-label custom-control-color" for="checkall"></label>
                                                        </div>
                                                    </th>
                                                    <th scope="col"> Nome / E-mail </th>
                                                    <th class="text-center" scope="col"> Nível </th>
                                                    <th class="text-center" scope="col"> Status </th>
                                                    <th scope="col"> Último Login </th>
                                                    <th scope="col"> Criação </th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @includeIf('users::_filter')
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="check-user-{{ $user->getKey() }}" value="{{ $user->getKey() }}" name="user[{{ $user->getKey() }}]">
                                                                <label class="custom-control-label" for="check-user-{{ $user->getKey() }}"></label>
                                                            </div>
                                                        </th>
                                                        <td class="cell-detail">
                                                            <span>{{ $user->name }}</span>
                                                            <span class="cell-detail-description">{{ $user->email }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-secondary font-weight-bold">{{ $user->role->name }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <h4> {!! $user->html_is_enabled !!} </h4>
                                                        </td>
                                                        <td class="cell-detail">
                                                            <span>{{ optional($user->last_login_at)->formatLocalized('%A %d de %B, %Y') }}</span>
                                                            <span class="cell-detail-description">{{ optional($user->last_login_at)->formatLocalized('%H:%M') }}</span>
                                                        </td>
                                                        <td class="cell-detail">
                                                            <span>{{ $user->created_at->formatLocalized('%A %d de %B, %Y') }}</span>
                                                            <span class="cell-detail-description">{{ $user->created_at->formatLocalized('%H:%M') }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('users.edit', [$user->getKey()]) }}" class="btn btn-space btn-outline-primary" title="Editar usuário">
                                                                <i class="icon icon-left mdi mdi-pencil"></i> Editar
                                                            </a>

                                                            <br>

                                                            @can('roleIs', 'SuperAdmin')
                                                                <script nonce="3VrLCT9ctX">
                                                                    document.addEventListener('DOMContentLoaded', function () {
                                                                        document.getElementById("btn-remove-register-{{$user->getKey()}}").addEventListener("click", function(event) {
                                                                            event.preventDefault();
                                                                            document.getElementById("form-delete-{{$user->getKey()}}").submit();
                                                                        });
                                                                    });
                                                                </script>

                                                                <button class="btn btn-space btn-outline-danger" type="button" id="btn-remove-register-{{$user->getKey()}}" title="Remover usuário - {{ $user->name }}">
                                                                    <i class="icon icon-left mdi mdi-delete"></i> Remover
                                                                </button>

                                                                {!! Form::open(['class' => 'inline', 'method' => 'DELETE', 'route' => ['users.destroy', $user->getKey()], 'id' => "form-delete-{$user->getKey()}" ]) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
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
                                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}
                                    @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    of {{ $users->total() }} entries
                                    @endif
                                </div>
                                <div class="col-sm-7">
                                    {!! $users->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h3 class="text-center"> Nenhum usuário pôde ser encontrado <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg btn-space btn-3d" target="_blank" title="Criar novo usuário">
                <i class="fa fa-plus"></i> Criar novo usuário </a>
            </h3>
        @endif
    </div>
@stop
