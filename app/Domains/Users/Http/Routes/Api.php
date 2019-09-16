<?php

use App\Domains\Users\Models\User;

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

    $this->router->name('users.')->prefix('users')->group(function ($router) {
        // Other routes
    });

    Route::model('douser', User::class);
    Route::apiResource('users', UserController::class)->parameters([
        'users' => 'douser'
    ]);

});
