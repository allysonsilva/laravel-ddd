<?php

namespace App\Domains\Users\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Domains\Users\Models\User;
use Illuminate\Support\Facades\DB;
use App\Domains\Users\Services\UserService;
use App\Support\Http\Controller as BaseController;
use App\Domains\Users\Http\Requests\UserFormRequest;

class UserController extends BaseController
{
    private $service;

    /**
     * Create a new controller instance.
     *
     * @param \App\Domains\Users\Services\UserService $service
     *
     * @return void
     */
    public function __construct(UserService $service)
    {
        $methods = ['create', 'store', 'destroy'];

        $this->middleware('role:super-admin')->only($methods);
        $this->middleware('role:admin')->except($methods);

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        [$users, $perPage] = $this->service->listAllFilteredUsers();

        return view('users::index')->with(compact('users', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageInfo = [
            'title' => 'Criar Novo Usuário',
            'HTTPVerb' => 'POST',
        ];

        return view('users::create', compact('pageInfo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        DB::beginTransaction();

        try {

            if (! $this->service->store($request->all()))
                return back()->withErrors(['Não foi possível criar um novo usuário'])->withInput();

            DB::commit();

            return redirect()->route('users.create')->with('success', 'Usuário criado com sucesso!');

        } catch(Throwable $e) {
            DB::rollback();

            error($e, __CLASS__, __FUNCTION__);

            return back()->with('error', 'Erro ao salvar usuário: '.PHP_EOL. $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Domains\Users\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Domains\Users\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $pageInfo = [
            'title' => 'Editar Usuário',
            'HTTPVerb' => 'PUT',
        ];

        return view('users::edit', compact('pageInfo', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domains\Users\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user)
    {
        DB::beginTransaction();

        try {

            if (! $this->service->update($request->all(), $user)) {
                return back()->withErrors(["Não foi possível atualizar o usuário"])->withInput();
            }

            DB::commit();

            return redirect()->route('users.edit', $user)->with('success', 'Usuário atualizado com sucesso!');

        } catch(Throwable $e) {
            DB::rollback();

            error($e, __CLASS__, __FUNCTION__);

            return back()->with('error', 'Erro ao atualizar usuário: '.PHP_EOL. $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domains\Users\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {

            if (! $this->service->delete($user)) {
                return redirect()->route('users.index')->withErrors(['Não foi possível remover este registro, tente novamente.']);
            }

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso!');

        } catch(Throwable $e) {
            DB::rollback();

            error($e, __CLASS__, __FUNCTION__);

            return redirect()->route('users.index')->withErrors(['Não foi possível remover este usuário, tente novamente.'.PHP_EOL.' '.$e->getMessage()]);
        }
    }
}
