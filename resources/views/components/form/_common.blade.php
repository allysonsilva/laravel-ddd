<div class="form-group row">
    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="{{ $name }}"> {{ $textLabel }} </label>
    <div class="col-12 col-sm-8 col-lg-6">

        {{-- Inputs que não contêm argumentos de {$value} --}}
        @if (in_array($type, ['password', 'file']))
            {!! Form::{$type}($name, $options) !!}

        @elseif ($type === 'select')
            {!! Form::select($name, $list, $value, $options) !!}

        {{-- Quando não existir conteúdo no componente - representado por {$slot->toHtml()} --}}
        @elseif (empty($slot->toHtml()))
            {!! Form::{$type}($name, $value, $options) !!}

        @endif

        {{ $slot }}

        @if ($errors->has($name)) <div class="invalid-feedback">{{ $errors->first($name) }}</div> @endif
    </div>
</div>
