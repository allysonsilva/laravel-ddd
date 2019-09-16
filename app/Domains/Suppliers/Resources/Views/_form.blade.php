<div class="row">
    <div class="col-md-12">
        <div class="card card-border-color card-border-color-{{ ($errors->any()) ? 'danger' : 'primary' }}">
            <div class="card-header card-header-divider">
                {{ $pageInfo['title'] }} <span class="icon mdi mdi-truck"></span>
                <span class="card-subtitle">Utilize o formulário abaixo para manipular as informações do fornecedor</span>
            </div>

            <div class="card-body">

                @if ($pageInfo['HTTPVerb'] === 'POST')
                {!! Form::open(['route' => ['suppliers.store'], 'id' => 'form-suppliers-store', 'class' => 'form-border']) !!}
                @endif

                @if ($pageInfo['HTTPVerb'] === 'PUT')
                {!! Form::model($supplier, ['method' => 'PUT', 'route' => ['suppliers.update', $supplier->getKey()], 'id' => 'form-suppliers-update', 'class' => 'form-border']) !!}
                @endif

                    {!! Form::textForm('name', 'Nome', optional($supplier)->name ?? old('name'), ['required']) !!}
                    {!! Form::emailForm('email', 'E-mail', optional($supplier)->email ?? old('email'), ['required']) !!}
                    {!! Form::textForm('monthly_payment', 'Valor mensalidade', to_money_PTBR(optional($supplier)->monthly_payment) ?? old('monthly_payment'), ['required']) !!}

                    {{-- <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="status"> Status </label>
                        <div class="pl-3">
                            <div class="switch-button switch-button-lg">
                                <input type="checkbox" name="status" id="status" @if(optional($supplier)->is_activated ?? old('status')) checked @endif><span>
                                <label for="status"></label></span>
                            </div>
                        </div>
                    </div> --}}

                    {!! Form::buttonsForm(route('suppliers.index'), 'Voltar') !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
