<div class="card-header card-header-divider card-header-contrast d-flex justify-content-between flex-row-reverse align-items-center">
    <div class="tools mt-2">
        @can('role', 'company')
            <a href="{{ route('companies.create') }}" class="d-none d-md-block btn btn-primary btn-lg btn-space btn-3d" target="_blank" title="Criar nova empresa">
                <i class="fa fa-plus"></i> Nova
            </a>
        @endcan
    </div>

    {!! Form::open(['method' => 'GET', 'role' => 'form']) !!}
        <div class="form-row align-items-center">
            <div class="col-auto">
                {!! Form::numberForm('limit', 'Empresas por página', input('limit') ?? $perPage, ['required'], 'without', null, 'font-weight-bold') !!}
            </div>
            <div class="col-auto">
                {!! Form::selectForm([
                    '' => 'Selecione ...',
                    'cnpj' => 'CNPJ',
                    'social_name' => 'Razão social',
                    'fantasy_name' => 'Nome fantasia',
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
