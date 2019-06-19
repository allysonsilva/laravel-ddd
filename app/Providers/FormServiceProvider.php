<?php

namespace App\Providers;

use Collective\Html\FormBuilder;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\CommonComponentComposer;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @param  \Collective\Html\FormBuilder  $formBuilder
     * @return void
     */
    public function boot(FormBuilder $formBuilder)
    {
        $this->loadViewsFrom(resource_path('views/components/form'), 'componentsForm');

        View::composer(['componentsForm::_common',
                        'componentsForm::group'], CommonComponentComposer::class);

        $defaultArgs = [
            'name',
            'textLabel' => null,
            'value' => null,
            'attributes' => []
        ];

        // ======================================
        // Laravel Collective - Custom Components
        // ======================================

        $formBuilder->component('customText', 'componentsForm::text', $defaultArgs);
        $formBuilder->component('customFile', 'componentsForm::file',  collect($defaultArgs)->except(['value'])->toArray());
        $formBuilder->component('customEmail', 'componentsForm::email', $defaultArgs);
        $formBuilder->component('customNumber', 'componentsForm::number', $defaultArgs);
        $formBuilder->component('customTextarea', 'componentsForm::textarea', $defaultArgs);
        $formBuilder->component('customPassword', 'componentsForm::password', $defaultArgs);
        $formBuilder->component('customTextGroup', 'componentsForm::group', collect($defaultArgs)->prepend(null, 'icon')->toArray());
        $formBuilder->component('customSelect', 'componentsForm::select', collect($defaultArgs)->prepend([], 'list')->toArray());
        $formBuilder->component('customButtons', 'componentsForm::buttons', ['routeBack', 'textBack', 'hasSubmit' => true]);
    }
}
