<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/verify', [AuthController::class, 'verify'])->name('auth.verify');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

# route untuk register akun
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');

Route::group(['middleware' => 'auth:admin'], function () {
    # Route Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard.index');
    # Route Profile Admin
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    # Route Lecturers
    Route::get('/admin/lecturers', [AdminController::class, 'indexLecturers'])->name('admin.lecturers.index');

    # Route Program Studi
    Route::get('/admin/program-studi', [AdminController::class, 'programStudi'])->name('admin.programstudi');
    Route::post('/admin/program-studi', [AdminController::class, 'storeProgramStudi'])->name('admin.programstudi.store');
    Route::get('/admin/program-studi/create', [AdminController::class, 'createProgramStudi'])->name('admin.programstudi.create');
    Route::get('/admin/program-studi/{id}/edit', [AdminController::class, 'editProgramStudi'])->name('admin.programstudi.edit');
    Route::put('/admin/program-studi/{id}', [AdminController::class, 'updateProgramStudi'])->name('admin.programstudi.update');
    Route::delete('/admin/program-studi/{id}', [AdminController::class, 'destroyProgramStudi'])->name('admin.programstudi.destroy');
    
    # Route Mata Kuliah
    Route::get('/admin/matakuliah', [AdminController::class, 'mataKuliah'])->name('admin.matakuliah');
    Route::get('/admin/matakuliah/program-studi/{id}', [AdminController::class, 'mataKuliahByProgramStudi'])->name('admin.matakuliah.byProgramStudi');
    Route::get('/admin/matakuliah/create', [AdminController::class, 'createMataKuliah'])->name('admin.matakuliah.create');
    Route::post('/admin/matakuliah', [AdminController::class, 'storeMataKuliah'])->name('admin.matakuliah.store');
    Route::get('/admin/matakuliah/{id}/edit', [AdminController::class, 'editMataKuliah'])->name('admin.matakuliah.edit');
    Route::put('/admin/matakuliah/{id}', [AdminController::class, 'updateMataKuliah'])->name('admin.matakuliah.update');
    Route::delete('/admin/matakuliah/{id}', [AdminController::class, 'destroyMataKuliah'])->name('admin.matakuliah.destroy');

    # Route Ruangan
    Route::get('/ruangan', [AdminController::class, 'indexRuangan'])->name('admin.ruangan.index');
    Route::get('/ruangan/create', [AdminController::class, 'createRuangan'])->name('admin.ruangan.create');
    Route::post('/ruangan', [AdminController::class, 'storeRuangan'])->name('admin.ruangan.store');
    Route::get('/ruangan/{id}/edit', [AdminController::class, 'editRuangan'])->name('admin.ruangan.edit');
    Route::put('/ruangan/{id}', [AdminController::class, 'updateRuangan'])->name('admin.ruangan.update');
    Route::delete('/ruangan/{id}', [AdminController::class, 'destroyRuangan'])->name('admin.ruangan.destroy');

    # Route Jam Kuliah
    Route::get('/admin/jamkuliah', [AdminController::class, 'indexJamKuliah'])->name('admin.jamkuliah.index');
    Route::get('/admin/jamkuliah/create', [AdminController::class, 'createJamKuliah'])->name('admin.jamkuliah.create');
    Route::post('/admin/jamkuliah/store', [AdminController::class, 'storeJamKuliah'])->name('admin.jamkuliah.store');
    Route::get('/admin/jamkuliah/{id}/edit', [AdminController::class, 'editJamKuliah'])->name('admin.jamkuliah.edit');
    Route::put('/admin/jamkuliah/{id}', [AdminController::class, 'updateJamKuliah'])->name('admin.jamkuliah.update');
    Route::delete('/admin/jamkuliah/{id}', [AdminController::class, 'destroyJamKuliah'])->name('admin.jamkuliah.destroy');

});

Route::group(['middleware' => 'auth:user'], function () {
    Route::get('/user/dashboard', [DashboardController::class, ['user', 'showScheduleForm']])->name('user.dashboard.index');
    Route::get('/user/dashboard', [DashboardController::class, 'showScheduleForm'])->name('user.dashboard.index');
    // Route::get('/user/dashboard', [UserController::class, 'showScheduleForm'])->name('user.dashboard.index');
    Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
    Route::get('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');

    Route::post('/generate-schedule', [ScheduleController::class, 'generateSchedule'])->name('generate.schedule');

});

