<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class CommonComponentComposer
{
    /**
     * The request implementation.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new composer contests module.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        /** @var array */
        $viewData = $view->getData();

        // Retorna o total de variáveis importadas para a tabela de símbolos na memória
        $totalVariablesImported = extract($viewData, EXTR_OVERWRITE);

        $errors = $errors ?? view()->shared('errors');

        // Existe o atributo {class} e o mesmo não está vazio?
        $existClassAttr = (array_key_exists('class', $attributes) && (! empty($attributes['class'])));

        $customClass = $existClassAttr ? $attributes['class'] : 'form-control';

        if ($errors->has($name))
            $customClass .= ' is-invalid';

        if (! is_null(old($name)))
            $customClass .= ' is-valid';

        // Caso a chave {class} exista no array {$attributes} então,
        // a mesma será SUBSTITUÍDA. Caso a chave não existe, será criada/adicionada.
        $options = array_merge($attributes, ['class' => $customClass]);

        $view->with(compact('options'));
    }
}
