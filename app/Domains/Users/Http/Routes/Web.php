<?php

use App\Domains\Users\Models\User;

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

$this->router->name('users.')->prefix('users')->group(function () {
    // Other routes
});

// @see https://laravel.com/docs/controllers#resource-controllers
$this->router->group([], function ($router) {
    $router->model('douser', User::class);
    $router->resource('users', UserController::class)->parameters([
        'users' => 'douser'
    ]);
});
