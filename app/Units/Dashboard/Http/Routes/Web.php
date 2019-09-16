<?php

use App\Units\Dashboard\Http\Controllers\Web\DashboardController;

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

$router->middleware('auth:web', 'role:_all')->group(function () {
    $this->router->get('/', [DashboardController::class, 'index'])->name('index');
});
