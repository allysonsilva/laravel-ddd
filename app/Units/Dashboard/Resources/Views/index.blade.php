@extends('layouts::master')

@section('pageTitle', 'Dashboard')

@section('content')
    @can('roleIs', 'SuperAdmin')
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content dashboard-card">
                            <div class="card-body">
                                <div class="media d-flex justify-content-between align-items-center">
                                    <div class="media-body data-info text-left">
                                        <h3 class="green value display-4">{{ $totals->total_active_suppliers }}</h3>
                                        <span class="lead desc text-capitalize">Fornecedores <strong>Ativos</strong></span>
                                    </div>
                                    <div class="align-self-center icon">
                                        <i class="fas fa-truck fa-6x green float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content dashboard-card">
                            <div class="card-body">
                                <div class="media d-flex justify-content-between align-items-center">
                                    <div class="media-body data-info text-left">
                                        <h3 class="purple value display-4">{{ $totals->total_companies }}</h3>
                                        <span class="lead desc text-capitalize">Empresas</span>
                                    </div>
                                    <div class="align-self-center icon">
                                        <i class="fas fa-building fa-6x purple float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content dashboard-card">
                            <div class="card-body">
                                <div class="media d-flex justify-content-between align-items-center">
                                    <div class="media-body data-info text-left">
                                        <h3 class="blue value display-4">{{ $totals->total_enabled }}</h3>
                                        <span class="lead desc text-capitalize">Usuários <strong>Ativos</strong></span>
                                    </div>
                                    <div class="align-self-center icon">
                                        <i class="fas fa-user-check fa-6x blue float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content dashboard-card">
                            <div class="card-body">
                                <div class="media d-flex justify-content-between align-items-center">
                                    <div class="media-body data-info text-left">
                                        <h3 class="red value display-4">{{ $totals->total_daily_logins }}</h3>
                                        <span class="lead desc text-capitalize">Logins Diário</span>
                                    </div>
                                    <div class="align-self-center icon">
                                        <i class="fas fa-sign-in-alt fa-6x red float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
