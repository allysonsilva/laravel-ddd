<?php

use App\Domains\Suppliers\Models\Supplier;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$this->router->name('suppliers.')->prefix('suppliers')->group(function () {
    $this->router->get('/{supplierKey}/activation', 'SupplierGuestController@activation')->name('activation')->middleware('signed');
});
