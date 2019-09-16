<?php

namespace App\Domains\Companies\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Domains\Companies\Models\Company;
use App\Domains\Companies\Services\CompanyService;
use App\Support\Http\Controller as BaseController;
use App\Domains\Companies\Http\Requests\CompanyFormRequest;
use App\Domains\Companies\Repositories\Filterable\CompanyBuilderFilter;

class CompanyController extends BaseController
{
    private $service;

    /**
     * Create a new controller instance.
     *
     * @param \App\Domains\Companies\Services\CompanyService $repository
     *
     * @return void
     */
    public function __construct(CompanyService $service)
    {
        $this->middleware('role:admin');

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        [$companies, $perPage] = $this->service->listAllCompanies();

        return view('companies::index')->with(compact('companies', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageInfo = [
            'title' => 'Criar Nova Empresa',
            'HTTPVerb' => 'POST',
        ];

        return view('companies::create', compact('pageInfo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyFormRequest $request)
    {
        DB::beginTransaction();

        try {

            if (! $this->service->store($request->all()))
                return back()->withErrors(['Não foi possível criar uma nova empresa!'])->withInput();

            DB::commit();

            return redirect()->route('companies.create')->with('success', 'Empresa criada com sucesso!');

        } catch(Throwable $e) {
            DB::rollback();

            error($e, __CLASS__, __FUNCTION__);

            return back()->with('error', 'Erro ao salvar empresa: '.PHP_EOL. $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $pageInfo = [
            'title' => 'Editar Empresa',
            'HTTPVerb' => 'PUT',
        ];

        return view('companies::edit', compact('pageInfo', 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyFormRequest $request, Company $company)
    {
        DB::beginTransaction();

        try {

            if (! $this->service->update($request->all(), $company)) {
                return back()->withErrors(["Não foi possível atualizar a empresa"])->withInput();
            }

            DB::commit();

            return redirect()->route('companies.edit', $company)->with('success', 'Empresa atualizada com sucesso!');

        } catch(Throwable $e) {
            DB::rollback();

            error($e, __CLASS__, __FUNCTION__);

            return back()->with('error', 'Erro ao atualizar empresa: '.PHP_EOL. $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domains\Companies\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        DB::beginTransaction();

        try {

            if (! $this->service->delete($company)) {
                return redirect()->route('companies.index')->withErrors(['Não foi possível remover este registro, tente novamente.']);
            }

            DB::commit();

            return redirect()->route('companies.index')->with('success', 'Empresa removida com sucesso!');

        } catch(Throwable $e) {
            DB::rollback();

            error($e, __CLASS__, __FUNCTION__);

            return redirect()->route('companies.index')->withErrors(['Não foi possível remover esta empresa, tente novamente.'.PHP_EOL.' '.$e->getMessage()]);
        }
    }
}
