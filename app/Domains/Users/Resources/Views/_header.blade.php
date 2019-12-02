<div class="card-header card-header-divider card-header-contrast d-flex justify-content-between flex-row-reverse align-items-center">
    <div class="tools mt-2">
        @can('permission', 'super-admin')
            <a href="{{ route('users.create') }}" class="d-none d-md-block btn btn-primary btn-lg btn-space btn-3d" target="_blank" title="Criar novo usuário">
                <i class="fa fa-plus"></i> Novo
            </a>
        @endcan
    </div>

    {!! Form::open(['method' => 'GET', 'role' => 'form']) !!}
        <div class="form-row align-items-center">
            <div class="col-auto">
                {!! Form::numberForm('limit', 'Usuários por página', input('limit') ?? $perPage, ['required'], 'without', null, 'font-weight-bold') !!}
            </div>
            <div class="col-auto">
                {!! Form::selectForm([
                    '' => 'Selecione ...',
                    'name' => 'Nome',
                    'email' => 'E-mail',
                    'status' => 'Status',
                    'role' => 'Nível',
                    'last_login_at' => 'Último login',
                ], 'sort_by', 'Coluna ordenação', input('sort_by'), ['required'], 'without', null, 'font-weight-bold') !!}
            </div>
            <div class="col-auto">
                {!! Form::selectForm([
                    'asc' => 'Crescente',
                    'desc' => 'Decrescente',
                ], 'sort_order', 'Direção ordenação', input('sort_order'), ['required'], 'without', null, 'font-weight-bold') !!}
            </div>
            <div class="col-auto">
                {!! Form::button('<i class="fa fa-list"></i> Listar', ['type' => 'submit', 'class' => 'btn btn-secondary btn-lg mt-2']) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>