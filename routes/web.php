<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'account'], function () {

    // Guest middleware (for users who are not authenticated)
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [LoginController::class, 'index'])->name('account.login');
        Route::get('/register', [LoginController::class, 'register'])->name('account.register');
        Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
        Route::post('/processRegister', [LoginController::class, 'processRegister'])->name('account.processRegister');
    });

    // Auth middleware (for authenticated users)
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('account.logout');
    });
});
