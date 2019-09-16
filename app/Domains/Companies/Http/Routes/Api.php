<?php

use App\Domains\Companies\Models\Company;

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

    $this->router->name('companies.')->prefix('companies')->group(function ($router) {
        // Other routes
    });

    // {do} is short for domain
    Route::model('docompany', Company::class);
    Route::apiResource('companies', CompanyController::class)->parameters([
        'companies' => 'docompany'
    ]);
});
