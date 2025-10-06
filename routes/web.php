<?php

use App\Http\Controllers\BiopsiaArchivarController;
use App\Http\Controllers\BiopsiaController;
use App\Http\Controllers\BiopsiaMascotaController;
use App\Http\Controllers\BiopsiaPacienteController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ListaBiopsiaController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // PERFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // DOCTORES
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

    // BIOPSIAS
    Route::get('biopsias', [BiopsiaController::class, 'index'])->name('biopsias.index');
    Route::get('biopsias/create', [BiopsiaController::class, 'create'])->name('biopsias.create');
    Route::post('biopsias', [BiopsiaController::class, 'store'])->name('biopsias.store');

    // BIOPSIAS PERSONAS
    Route::get('biopsias/personas', [BiopsiaPacienteController::class, 'index'])->name('biopsias.personas.index');
    Route::get('biopsias/personas/create', [BiopsiaPacienteController::class, 'create'])->name('biopsias.personas.create');
    Route::post('biopsias/personas', [BiopsiaPacienteController::class, 'store'])->name('biopsias.personas.store');
    Route::get('biopsias/personas/{nbiopsia}/imprimir', [BiopsiaPacienteController::class, 'imprimir'])->name('biopsias.personas.imprimir'); // ← MOVER AQUÍ (fuera de admin)

    //BIOPSIAS MASCOTAS
    Route::get('biopsias/mascotas', [BiopsiaMascotaController::class, 'index'])->name('biopsias.mascotas.index');
    Route::get('biopsias/mascotas/create', [BiopsiaMascotaController::class, 'create'])->name('biopsias.mascotas.create');
    Route::post('biopsias/mascotas', [BiopsiaMascotaController::class, 'store'])->name('biopsias.mascotas.store');

    // BUSCADOR DE LISTAS PARA MASCOTAS
    Route::get('/biopsias-mascotas/buscar-lista/{id}', [BiopsiaMascotaController::class, 'buscarLista'])
        ->name('biopsias.mascotas.buscar-lista');
    Route::get('/biopsias-mascotas/buscar-lista-codigo/{codigo}', [BiopsiaMascotaController::class, 'buscarListaPorCodigo'])
        ->name('biopsias.mascotas.buscar-lista-codigo');

    // Rutas para biopsias archivadas
    Route::get('biopsias/archivadas', [BiopsiaArchivarController::class, 'index'])->name('biopsias.archivadas.index');
    Route::post('biopsias/{nbiopsia}/archivar', [BiopsiaArchivarController::class, 'archivar'])->name('biopsias.archivar');
    Route::post('biopsias/{nbiopsia}/restaurar', [BiopsiaArchivarController::class, 'restaurar'])->name('biopsias.restaurar');
    Route::post('biopsias/archivar-antiguas', [BiopsiaArchivarController::class, 'archivarAntiguas'])->name('biopsias.archivar-antiguas');
    Route::delete('mascotas/{mascota}', [MascotaController::class, 'destroy'])->name('mascotas.destroy');
    // Ruta resultados
    Route::get('resultados', [ResultadoController::class, 'index'])->name('resultados.index');

    // LISTAS DE BIOPSIAS
    Route::get('listas/biopsias', [ListaBiopsiaController::class, 'index'])->name('listas.biopsias.index');
    Route::get('listas/biopsias/create', [ListaBiopsiaController::class, 'create'])->name('listas.biopsias.create');
    Route::post('listas/biopsias', [ListaBiopsiaController::class, 'store'])->name('listas.biopsias.store');

    // BUSCADOR DE LISTAS PARA PACIENTE
    Route::get('/biopsias-personas/buscar-lista/{id}', [BiopsiaPacienteController::class, 'buscarLista'])
        ->name('biopsias.personas.buscar-lista');
    Route::get('/biopsias-personas/buscar-lista-codigo/{codigo}', [BiopsiaPacienteController::class, 'buscarListaPorCodigo'])
        ->name('biopsias.personas.buscar-lista-codigo');
    Route::get('biopsias/{nbiopsia}', [BiopsiaController::class, 'show'])->name('biopsias.show'); // ← AGREGAR ESTA LÍNEA

    // RUTA PARA ACCESO DE ADMINISTRADORES
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

        // BIOPSIAS
        Route::get('biopsias/{nbiopsia}/edit', [BiopsiaController::class, 'edit'])->name('biopsias.edit');
        Route::put('biopsias/{nbiopsia}', [BiopsiaController::class, 'update'])->name('biopsias.update');
        Route::delete('biopsias/{nbiopsia}', [BiopsiaController::class, 'destroy'])->name('biopsias.destroy');
        // BIOPSIAS PERSONAS 
        Route::get('biopsias/personas/{nbiopsia}/edit', [BiopsiaPacienteController::class, 'edit'])->name('biopsias.personas.edit');
        Route::put('biopsias/personas/{nbiopsia}', [BiopsiaPacienteController::class, 'update'])->name('biopsias.personas.update');
        Route::patch('biopsias/personas/{nbiopsia}/toggle-estado', [BiopsiaPacienteController::class, 'toggleEstado'])->name('biopsias.personas.toggle-estado');

        // BIOPSIAS MASCOTAS
        Route::get('biopsias/mascotas/{nbiopsia}/edit', [BiopsiaMascotaController::class, 'edit'])->name('biopsias.mascotas.edit');
        Route::put('biopsias/mascotas/{nbiopsia}', [BiopsiaMascotaController::class, 'update'])->name('biopsias.mascotas.update');
        Route::patch('biopsias/mascotas/{nbiopsia}/toggle-estado', [BiopsiaMascotaController::class, 'toggleEstado'])->name('biopsias.mascotas.toggle-estado');
        Route::get('biopsias/mascotas/{nbiopsia}/imprimir', [BiopsiaMascotaController::class, 'imprimir'])->name('biopsias.mascotas.imprimir');

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
