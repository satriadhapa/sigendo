<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/verify', [AuthController::class, 'verify'])->name('auth.verify');

Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
