<div class="app-left-sidebar">
    <div class="left-sidebar-wrapper">
        <a class="left-sidebar-toggle" href="#">Painel administrativo</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        <li class="divider">Menu</li>
                        <li class="{{ request()->is('*dashboard*') ? 'active' : '' }}">
                            <a href="#">
                                <i class="icon mdi mdi-home"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('*users*') ? 'parent active open' : 'parent' }}">
                            <a href="#">
                                <i class="icon mdi mdi-accounts"></i>
                                <span>Usuários</span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ (Route::currentRouteName() === 'users.index') ? 'active' : '' }}">
                                    <a href="#"><i class="icon mdi mdi-accounts-list-alt"></i> &nbsp; Gerenciar</a>
                                </li>
                                <li class="{{ (Route::currentRouteName() === 'users.create') ? 'active' : '' }}">
                                    <a href="#"><i class="icon mdi mdi-account-add"></i> &nbsp; Criar novo</a>
                                </li>
                                @if (Route::currentRouteName() === 'users.show')
                                    <li class="active">
                                        <a><i class="icon mdi mdi-eye"></i> &nbsp; Visualizar usuário</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
