<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/verify', [AuthController::class, 'verify'])->name('auth.verify');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard.index');
});

Route::group(['middleware' => 'auth:user'], function () {
    Route::get('/user/dashboard', [DashboardController::class, 'user'])->name('user.dashboard.index');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');