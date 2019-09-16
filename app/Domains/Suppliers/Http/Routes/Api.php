<?php

use App\Domains\Suppliers\Models\Supplier;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$this->router->namespace('Api')->group(function ($router) {

    $this->router->name('suppliers.')->prefix('suppliers')->group(function ($router) {
        // Other routes
        $this->router->get('/company/amount-monthly-payment', 'SupplierController@amountSuppliersMonthlyPaymentByCompany')->name('company.amount-monthly-payment');
    });

    // {do} is short for domain
    Route::model('dosupplier', Supplier::class);
    Route::apiResource('suppliers', SupplierController::class)->parameters([
        'suppliers' => 'dosupplier'
    ]);
});
