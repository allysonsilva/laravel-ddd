<?php

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

$router->namespace('Api')->group(function () {

    $this->router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->router->put('password/reset', 'ResetPasswordController@reset')->name('password.reset');

    // User login Api [Authentication]
    $this->router->post('login', 'AuthController@login')->name('login');

    // Refresh Token
    $this->router->put('refresh', 'AuthController@refresh')->name('refresh');

    // Register user and login
    $this->router->post('register', 'RegisterController@register')->name('register');

    $this->router->name('logged.')->middleware(['auth.api'])->group(function () {
        // Add Token to Blacklist
        $this->router->delete('logout', 'AuthController@logout')->name('logout');

        /* Profile Current User Authenticate */
        $this->router->get('profile', 'MeController@profile')->name('me.profile');
        $this->router->put('profile', 'MeController@update')->name('me.profile.update');
    });

});
