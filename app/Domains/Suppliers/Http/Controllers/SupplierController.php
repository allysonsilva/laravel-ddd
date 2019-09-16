<?php

namespace App\Domains\Suppliers\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Domains\Suppliers\Models\Supplier;
use App\Support\Http\Controller as BaseController;
use App\Domains\Suppliers\Services\SupplierService;
use App\Domains\Suppliers\Http\Requests\SupplierFormRequest;
use App\Domains\Suppliers\Repositories\Filterable\SupplierBuilderFilter;

class SupplierController extends BaseController
{
    private $service;

    /**
     * Create a new controller instance.
     *
     * @param \App\Domains\Suppliers\Services\SupplierService $service
     *
     * @return void
     */
    public function __construct(SupplierService $service)
    {
        $this->middleware('role:company');

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        [$suppliers, $perPage] = $this->service->paginate(app(SupplierBuilderFilter::class), 'simplePaginate');

        return view('suppliers::index')->with(compact('suppliers', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('roleIs', ['Company']);

        $pageInfo = [
            'title' => 'Criar Novo Fornecedor',
            'HTTPVerb' => 'POST',
        ];

        return view('suppliers::create', compact('pageInfo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierFormRequest $request)
    {
        $this->authorize('roleIs', ['Company']);

        DB::beginTransaction();

        try {

            if (! $this->service->store($request->all()))
                return back()->withErrors(['Não foi possível criar um novo fornecedor'])->withInput();

            DB::commit();

            return redirect()->route('suppliers.create')->with('success', 'Fornecedor criado com sucesso!');

        } catch(Throwable $e) {
            DB::rollback();

            error($e, __CLASS__, __FUNCTION__);

            return back()->with('error', 'Erro ao criar fornecedor: '.PHP_EOL. $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Domains\Suppliers\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Domains\Suppliers\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $pageInfo = [
            'title' => 'Editar Fornecedor',
            'HTTPVerb' => 'PUT',
        ];

        return view('suppliers::edit', compact('pageInfo', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domains\Suppliers\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierFormRequest $request, Supplier $supplier)
    {
        DB::beginTransaction();

        try {

            if (! $this->service->update($request->all(), $supplier)) {
                return back()->withErrors(["Não foi possível atualizar o fornecedor."])->withInput();
            }

            DB::commit();

            return redirect()->route('suppliers.edit', $supplier)->with('success', 'Fornecedor atualizado com sucesso!');

        } catch(Throwable $e) {
            DB::rollback();

            error($e, __CLASS__, __FUNCTION__);

            return back()->with('error', 'Erro ao atualizar fornecedor: '.PHP_EOL. $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domains\Suppliers\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        try {
            if (! $this->service->delete($supplier)) {
                return redirect()->route('suppliers.index')->withErrors(['Não foi possível remover este registro, tente novamente.']);
            }

            return redirect()->route('suppliers.index')->with('success', 'Fornecedor removido com sucesso!');
        } catch(Throwable $e) {
            error($e, __CLASS__, __FUNCTION__);

            return redirect()->route('suppliers.index')->withErrors(['Não foi possível remover este fornecedor, tente novamente.'.PHP_EOL.' '.$e->getMessage()]);
        }
    }
}
