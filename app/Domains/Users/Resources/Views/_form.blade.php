@inject('roleRepository', 'App\Domains\Users\Repositories\RoleRepository')

<div class="row">
    <div class="col-md-12">
        <div class="card card-border-color card-border-color-{{ ($errors->any()) ? 'danger' : 'primary' }}">
            <div class="card-header card-header-divider">
                {{ $pageInfo['title'] }} <span class="icon mdi mdi-account"></span>
                <span class="card-subtitle">Utilize o formulário abaixo para manipular as informações do usuário</span>
            </div>

            <div class="card-body">

                @if ($pageInfo['HTTPVerb'] === 'POST')
                {!! Form::open(['route' => ['users.store'], 'id' => 'form-users-store', 'class' => 'form-border']) !!}
                @endif

                @if ($pageInfo['HTTPVerb'] === 'PUT')
                {!! Form::model($user, ['method' => 'PUT', 'route' => ['users.update', $user->getKey()], 'id' => 'form-users-update', 'class' => 'form-border']) !!}
                @endif

                    {!! Form::textForm('name', 'Nome', optional($user)->name ?? old('name'), ['autofocus', 'required']) !!}
                    {!! Form::emailForm('email', 'E-mail', optional($user)->email ?? old('email'), ['required']) !!}
                    {{-- {!! Form::selectForm(map_status(), 'status', 'Status', optional($user)->getOriginal('status') ?? old('status'), ['required']) !!} --}}

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="status"> Status </label>
                        <div class="pl-3">
                            <div class="switch-button switch-button-lg">
                                <input type="checkbox" name="status" id="status" @if(optional($user)->is_enabled ?? old('status')) checked @endif><span>
                                <label for="status"></label></span>
                            </div>
                        </div>
                    </div>

                    @can('roleIs', 'SuperAdmin')
                        {!! Form::selectForm(($roleRepository->mapRoles(['company']))->prepend('Selecione', ''), 'role', 'Permissão - Nível', optional($user)->role_id ?? old('role'), ['required']) !!}
                    @endcan

                    <hr>

                    {!! Form::passwordForm('password', 'Senha', ['placeholder' => 'Senha do usuário'], null, null, 'col-12 col-sm-3 col-form-label text-sm-right font-weight-bold') !!}
                    {!! Form::passwordForm('password_confirmation', 'Confirmar senha', ['placeholder' => 'Repetir senha do usuário']) !!}

                    {!! Form::buttonsForm(route('users.index'), 'Voltar') !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
