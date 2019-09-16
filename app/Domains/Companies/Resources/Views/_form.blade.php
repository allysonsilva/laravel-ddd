<div class="row">
    <div class="col-md-12">
        <div class="card card-border-color card-border-color-{{ ($errors->any()) ? 'danger' : 'primary' }}">
            <div class="card-header card-header-divider">
                {{ $pageInfo['title'] }} <span class="icon mdi mdi-office-building"></span>
                <span class="card-subtitle">Utilize o formulário abaixo para manipular as informações da empresa</span>
            </div>

            <div class="card-body">

                @if ($pageInfo['HTTPVerb'] === 'POST')
                {!! Form::open(['route' => ['companies.store'], 'id' => 'form-companies-store', 'class' => 'form-border']) !!}
                @endif

                @if ($pageInfo['HTTPVerb'] === 'PUT')
                {!! Form::model($company, ['method' => 'PUT', 'route' => ['companies.update', $company->getKey()], 'id' => 'form-companies-update', 'class' => 'form-border']) !!}
                @endif

                    @if ($pageInfo['HTTPVerb'] === 'POST')
                        {!! Form::textForm('user[name]', 'Nome do usuário', old('user.name'), ['autofocus', 'autocomplete' => 'user[name]', 'required']) !!}
                        {!! Form::emailForm('user[email]', 'E-mail do usuário', old('user.email'), ['autocomplete' => 'name', 'required']) !!}

                        {!! Form::passwordForm('user[password]', 'Senha', ['placeholder' => 'Senha do usuário', 'required']) !!}
                        {!! Form::passwordForm('user[password_confirmation]', 'Confirmar senha', ['placeholder' => 'Repetir senha do usuário', 'required']) !!}
                        <hr>
                    @endif

                    {!! Form::textForm('cnpj', 'CNPJ', optional($company)->cnpj ?? old('cnpj'), ['placeholder' => __('CNPJ da Empresa'), 'required']) !!}
                    {!! Form::textForm('social_name', __('Razão Social'), optional($company)->social_name ?? old('social_name'), ['required']) !!}
                    {!! Form::textForm('fantasy_name', __('Nome Fantasia'), optional($company)->fantasy_name ?? old('fantasy_name'), ['required']) !!}
                    {!! Form::textForm('phone', __('Número de Telefone'), optional($company)->phone ?? old('phone'), ['required']) !!}
                    {!! Form::textForm('address', __('Endereço Completo'), optional($company)->address ?? old('address'), ['required']) !!}
                    {!! Form::textForm('postal_code', __('CEP'), optional($company)->postal_code ?? old('postal_code'), ['required']) !!}

                    {!! Form::buttonsForm(route('users.index'), 'Voltar') !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
