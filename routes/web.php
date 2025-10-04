<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ListaBiopsiaController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\PacienteController;
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
    // PERFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('doctores', [DoctorController::class, 'index'])->name('doctores.index');

    // PACIENTES
    Route::get('pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::get('pacientes/create', [PacienteController::class, 'create'])->name('pacientes.create');
    Route::post('pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
    Route::get('pacientes/{paciente}/edit', [PacienteController::class, 'edit'])->name('pacientes.edit');
    Route::put('pacientes/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');

    // MASCOTAS
    Route::get('mascotas', [MascotaController::class, 'index'])->name('mascotas.index');
    Route::get('mascotas/create', [MascotaController::class, 'create'])->name('mascotas.create');
    Route::post('mascotas', [MascotaController::class, 'store'])->name('mascotas.store');
    Route::get('mascotas/{mascota}/edit', [MascotaController::class, 'edit'])->name('mascotas.edit');
    Route::put('mascotas/{mascota}', [MascotaController::class, 'update'])->name('mascotas.update');
    Route::delete('mascotas/{mascota}', [MascotaController::class, 'destroy'])->name('mascotas.destroy');
    // Ruta resultados
    Route::get('resultados', [ResultadoController::class, 'index'])->name('resultados.index');
    // Rutas de doctores que requieren permisos de admin
    // LISTAS DE BIOPSIAS
    Route::get('listas/biopsias', [ListaBiopsiaController::class, 'index'])->name('listas.biopsias.index');
    Route::get('listas/biopsias/create', [ListaBiopsiaController::class, 'create'])->name('listas.biopsias.create');
    Route::post('listas/biopsias', [ListaBiopsiaController::class, 'store'])->name('listas.biopsias.store');
    // PERMISOS DE ADMINISTRADOR
    Route::middleware(['role:admin'])->group(function () {

        // DOCTORES
        Route::get('doctores/create', [DoctorController::class, 'create'])->name('doctores.create');
        Route::post('doctores', [DoctorController::class, 'store'])->name('doctores.store');
        Route::get('doctores/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctores.edit');
        Route::put('doctores/{doctor}', [DoctorController::class, 'update'])->name('doctores.update');
        Route::delete('doctores/{doctor}', [DoctorController::class, 'destroy'])->name('doctores.destroy');
        Route::patch('doctores/{doctor}/toggle-estado', [DoctorController::class, 'toggleEstado'])->name('doctores.toggle-estado');

        //PACIENTES
        Route::delete('pacientes/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');

        //MASCOTAS
        Route::delete('mascotas/{mascota}', [MascotaController::class, 'destroy'])->name('mascotas.destroy');

        // LISTAS DE BIOPSIAS
        Route::get('listas/biopsias/{listaBiopsia}/edit', [ListaBiopsiaController::class, 'edit'])->name('listas.biopsias.edit');
        Route::put('listas/biopsias/{listaBiopsia}', [ListaBiopsiaController::class, 'update'])->name('listas.biopsias.update');
        Route::delete('listas/biopsias/{listaBiopsia}', [ListaBiopsiaController::class, 'destroy'])->name('listas.biopsias.destroy');
    });

    // Rutas de administración de usuarios - solo para administradores
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', UserAdminController::class);
    });
});

require __DIR__ . '/auth.php';
