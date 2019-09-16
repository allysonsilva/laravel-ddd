<?php

namespace App\Support\View\Building;

use Collective\Html\FormBuilder;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Support\View\Composers\FormValidationClassComposer;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param \Collective\Html\FormBuilder $formBuilder
     *
     * @return void
     */
    public function boot(FormBuilder $formBuilder)
    {
        $this->loadViewsFrom(resource_path('views/components/form'), 'components_form');

        View::composer([
            'components_form::_common',
            'components_form::group'
        ], FormValidationClassComposer::class);

        $this->bladeAliasingIncludes();
        $this->collectiveCustomComponents($formBuilder);
    }

    private function bladeAliasingIncludes()
    {
        Blade::include('components.filters', 'filters');

        Blade::include('components_form::text', 'text');
        Blade::include('components_form::file', 'file');
        Blade::include('components_form::email', 'email');
        Blade::include('components_form::number', 'number');
        Blade::include('components_form::textarea', 'textarea');
        Blade::include('components_form::password', 'password');
        Blade::include('components_form::group', 'group');
        Blade::include('components_form::select', 'select');
        Blade::include('components_form::buttons', 'buttons');
    }

    private function collectiveCustomComponents(FormBuilder $formBuilder)
    {
        $defaultArgs = [
            'name',
            'textLabel' => null,
            'value' => null,
            'attributes' => [],
            'classCompAround' => null,
            'classComp' => null,
            'classLabel' => null,
        ];

        $formBuilder->component('textForm', 'components_form::text', $defaultArgs);
        $formBuilder->component('fileForm', 'components_form::file',  collect($defaultArgs)->except(['value'])->toArray());
        $formBuilder->component('emailForm', 'components_form::email', $defaultArgs);
        $formBuilder->component('numberForm', 'components_form::number', $defaultArgs);
        $formBuilder->component('textareaForm', 'components_form::textarea', $defaultArgs);
        $formBuilder->component('passwordForm', 'components_form::password', collect($defaultArgs)->forget('value')->toArray());
        $formBuilder->component('groupForm', 'components_form::group', collect($defaultArgs)->prepend(null, 'icon')->toArray());
        $formBuilder->component('selectForm', 'components_form::select', collect($defaultArgs)->prepend([], 'list')->toArray());
        $formBuilder->component('buttonsForm', 'components_form::buttons', ['routeBack', 'textBack', 'hasSubmit' => true]);
    }
}
