<?php

namespace App\Domains\Suppliers\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Domains\Suppliers\Models\Supplier;
use App\Support\Http\Controller as BaseController;
use App\Domains\Companies\Services\CompanyService;
use App\Domains\Suppliers\Services\SupplierService;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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
     * Recupera o total das mensalidades dos fornecedores da empresa logado no sistema!
     *
     * @param \App\Domains\Companies\Services\CompanyService $companyService
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function amountSuppliersMonthlyPaymentByCompany(CompanyService $companyService, Request $request): JsonResponse
    {
        /** @var float|null */
        $amount = $companyService->amountSuppliersMonthlyPayment(auth('api')->payload()->get('company_key'));

        return response()->json([
            'amount' => $amount,
            'amount_currency' => to_money_PTBR($amount),
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domains\Suppliers\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domains\Suppliers\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
