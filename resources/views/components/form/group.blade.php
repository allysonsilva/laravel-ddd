<div class="form-group row">
    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="{{ $name }}"> {{ $textLabel }} </label>
    <div class="col-12 col-sm-8 col-lg-6">
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="{{ $icon ?? 'fa fa-question' }}"></i></span>
            </div>

            {!! Form::text($name, $value, $options) !!}
            @if ($errors->has($name)) <div class="invalid-feedback">{{ $errors->first($name) }}</div> @endif

        </div>
    </div>
</div>
