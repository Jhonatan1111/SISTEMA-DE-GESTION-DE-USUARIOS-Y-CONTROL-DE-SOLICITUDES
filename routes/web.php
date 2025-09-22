<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('doctores', [DoctorController::class, 'index'])->name('doctores.index');

    // Rutas de administración de usuarios - solo para administradores
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', UserAdminController::class);
        Route::get('doctores/create', [DoctorController::class, 'create'])->name('doctores.create');
        Route::post('doctores', [DoctorController::class, 'store'])->name('doctores.store');
        Route::get('doctores/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctores.edit');
        Route::put('doctores/{doctor}', [DoctorController::class, 'update'])->name('doctores.update');
        Route::delete('doctores/{doctor}', [DoctorController::class, 'destroy'])->name('doctores.destroy');
        Route::patch('doctores/{doctor}/toggle-estado', [DoctorController::class, 'toggleEstado'])->name('doctores.toggle-estado');
    });
    // Ruta adicional para cambiar estado del doctor
});

require __DIR__ . '/auth.php';
