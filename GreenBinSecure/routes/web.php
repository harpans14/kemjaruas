<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('dashboard');
    Route::get('/setoran/create', [WargaController::class, 'createSetoran'])->name('setoran.create');
    Route::post('/setoran', [WargaController::class, 'storeSetoran'])->name('setoran.store');
    Route::get('/setoran', [WargaController::class, 'riwayatSetoran'])->name('setoran.index');
});

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/setoran', [PetugasController::class, 'indexSetoran'])->name('setoran.index');
    Route::post('/setoran/{setoran}/approve', [PetugasController::class, 'approve'])->name('setoran.approve');
    Route::post('/setoran/{setoran}/reject', [PetugasController::class, 'reject'])->name('setoran.reject');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
    Route::get('/setoran', [AdminController::class, 'setoranIndex'])->name('setoran.index');
    Route::get('/logs', [AdminController::class, 'logsIndex'])->name('logs.index');
});
