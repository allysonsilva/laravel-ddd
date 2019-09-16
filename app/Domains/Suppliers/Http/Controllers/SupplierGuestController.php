<?php

namespace App\Domains\Suppliers\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Http\Controller as BaseController;
use App\Domains\Suppliers\Services\SupplierService;

class SupplierGuestController extends BaseController
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
        $this->service = $service;

        $this->middleware('guest');
    }

    public function activation(int $supplierKey, Request $request)
    {
        $this->service->activation($supplierKey);

        return 'SUCCESS';
    }
}
