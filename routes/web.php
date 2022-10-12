<?php

use App\Http\Controllers\AdminAuth\ForgotPasswordController;
use App\Http\Controllers\AdminAuth\LoginController;
use App\Http\Controllers\AdminAuth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false, 'login' => false]);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/home',  [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('login',  'showLoginForm')->name('admin.login');
        Route::post('login',   'login');
        Route::get('logout',  'logout')->name('admin.logout');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::post('/password/email', 'sendResetLinkEmail')->name('admin.password.request');
        Route::get('/password/reset',  'showLinkRequestForm')->name('admin.password.reset');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::post('/password/reset', 'reset')->name('admin.password.email');
        Route::get('/password/reset/{token}/{email?}', 'showResetForm');
    });
});
