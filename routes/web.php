<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/verify', [AuthController::class, 'verify'])->name('auth.verify');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard.index');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    Route::get('/admin/program-studi', [AdminController::class, 'programStudi'])->name('admin.programstudi');
    Route::post('/admin/program-studi', [AdminController::class, 'storeProgramStudi'])->name('admin.programstudi.store');
    Route::get('/admin/program-studi/create', [AdminController::class, 'createProgramStudi'])->name('admin.programstudi.create');
    Route::get('/admin/program-studi/{id}/edit', [AdminController::class, 'editProgramStudi'])->name('admin.programstudi.edit');
    Route::put('/admin/program-studi/{id}', [AdminController::class, 'updateProgramStudi'])->name('admin.programstudi.update');
    Route::delete('/admin/program-studi/{id}', [AdminController::class, 'destroyProgramStudi'])->name('admin.programstudi.destroy');
});

Route::group(['middleware' => 'auth:user'], function () {
    Route::get('/user/dashboard', [DashboardController::class, 'user'])->name('user.dashboard.index');
});

# route untuk register akun
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');