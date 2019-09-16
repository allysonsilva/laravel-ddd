<div class="app-left-sidebar">
    <div class="left-sidebar-wrapper">
        <a class="left-sidebar-toggle" href="#">Painel administrativo</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        <li class="divider">Menu</li>
                        <li class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.index') }}">
                                <i class="icon mdi mdi-view-dashboard"></i><span>Dashboard</span>
                            </a>
                        </li>

                        @can('role', 'admin')
                            <li class="{{ request()->is('*users*') ? 'parent active open' : 'parent' }}">
                                <a href="#">
                                    <i class="icon mdi mdi-account-multiple"></i>
                                    <span>Usuários</span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                                        <a href="{{ route('users.index') }}"><i class="icon mdi mdi-account-supervisor-circle"></i> &nbsp; Gerenciar</a>
                                    </li>
                                    @can('roleIs', 'super-admin')
                                        <li class="{{ request()->routeIs('users.create') ? 'active' : '' }}">
                                            <a href="{{ route('users.create') }}"><i class="icon mdi mdi-account-multiple-plus"></i> &nbsp; Criar novo</a>
                                        </li>
                                    @endcan
                                    @if (request()->routeIs('users.show'))
                                        <li class="active">
                                            <a><i class="icon mdi mdi-eye"></i> &nbsp; Visualizar usuário</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endcan

                        @can('role', 'admin')
                            <li class="{{ request()->routeIs('companies.*') ? 'active' : '' }}">
                                <a href="{{ route('companies.index') }}">
                                    <i class="icon fas fa-building"></i><span>Empresas</span>
                                </a>
                            </li>
                        @endcan

                        @can('role', 'company')
                            <li class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                                <a href="{{ route('suppliers.index') }}">
                                    <i class="icon mdi mdi-truck"></i><span>Fornecedores</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
