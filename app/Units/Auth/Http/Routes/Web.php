<?php

use App\Units\Auth\Http\Controllers\Web\LoginController;

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

$router->namespace('Web')->group(function () {

    // Authentication Routes...
    $this->router->get('login', [LoginController::class, 'showLoginForm'])->name('show-form-login');
    $this->router->post('login', [LoginController::class, 'login'])->name('login');
    $this->router->delete('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration Routes...
    $this->router->get('register', 'RegisterController@showRegistrationForm')->name('show-form-register');
    $this->router->post('register', 'RegisterController@register')->name('register');

    // Password Reset Routes...
    $this->router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->router->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    $this->router->post('password/reset', 'ResetPasswordController@reset')->name('password.update');

    // Email Verification Routes...
    $this->router->get('email/verify', 'VerificationController@show')->name('verification.notice');
    $this->router->get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    $this->router->post('email/resend', 'VerificationController@resend')->name('verification.resend');

});
