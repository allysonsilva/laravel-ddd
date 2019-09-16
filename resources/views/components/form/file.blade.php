@component('components_form::_common', array_merge(['type' => 'file'], compact('name', 'textLabel', 'attributes', 'classCompAround', 'classComp', 'classLabel')))
    @if (array_key_exists('class', $attributes) && Str::contains($attributes['class'], 'inputfile'))
        <label class="btn-primary" for="{{ $name }}">
            <i class="mdi mdi-upload"></i><span>Selecionar arquivo...</span>
        </label>
    @endif
@endcomponent
