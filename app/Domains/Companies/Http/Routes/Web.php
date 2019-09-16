<?php

use App\Domains\Companies\Models\Company;

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

$this->router->name('companies.')->prefix('companies')->group(function () {
    // Other routes
});

// @see https://laravel.com/docs/controllers#resource-controllers
$this->router->group([], function ($router) {
    $router->model('docompany', Company::class);
    $router->resource('companies', CompanyController::class)->parameters([
        'companies' => 'docompany'
    ]);
});
