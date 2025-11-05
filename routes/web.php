<?php

use App\Http\Controllers\BiopsiaArchivarController;
use App\Http\Controllers\BiopsiaController;
use App\Http\Controllers\BiopsiaMascotaController;
use App\Http\Controllers\BiopsiaPacienteController;
use App\Http\Controllers\CitolgiaController;
use App\Http\Controllers\CitolgiaPersonaController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ListaBiopsiaController;
use App\Http\Controllers\ListaCitologiaController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAdminController;
use App\Models\Biopsia;
use App\Http\Controllers\SobreController;
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
    Route::get('biopsias/exportar-pdf', [BiopsiaController::class, 'exportarPdf'])->name('biopsias.exportar-pdf');

    // BIOPSIAS PERSONAS
    Route::get('biopsias/personas/obtener-numero-correlativo', [BiopsiaPacienteController::class, 'obtenerNumeroCorrelativo'])->name('biopsias.personas.obtener-numero-correlativo');
    Route::get('biopsias/personas', [BiopsiaPacienteController::class, 'index'])->name('biopsias.personas.index');
    Route::get('biopsias/personas/exportar-pdf', [BiopsiaPacienteController::class, 'exportarPdf'])->name('biopsias.personas.exportar-pdf');
    Route::get('biopsias/personas/create', [BiopsiaPacienteController::class, 'create'])->name('biopsias.personas.create');
    Route::post('biopsias/personas', [BiopsiaPacienteController::class, 'store'])->name('biopsias.personas.store');
    Route::get('biopsias/personas/{nbiopsia}', [BiopsiaPacienteController::class, 'show'])->name('biopsias.personas.show');
    Route::get('biopsias/personas/{nbiopsia}/imprimir', [BiopsiaPacienteController::class, 'imprimir'])->name('biopsias.personas.imprimir'); // ← MOVER AQUÍ (fuera de admin)
    Route::get('biopsias/personas/{nbiopsia}/pdf', [BiopsiaPacienteController::class, 'descargarPdf'])->name('biopsias.personas.pdf');

    // BIOPSIAS MASCOTAS
    Route::get('biopsias/mascotas/obtener-numero-correlativo', [BiopsiaMascotaController::class, 'obtenerNumeroCorrelativo'])->name('biopsias.mascotas.obtener-numero-correlativo');
    Route::get('biopsias/mascotas', [BiopsiaMascotaController::class, 'index'])->name('biopsias.mascotas.index');
    Route::get('biopsias/mascotas/exportar-pdf', [BiopsiaMascotaController::class, 'exportarPdf'])->name('biopsias.mascotas.exportar-pdf');
    Route::get('biopsias/mascotas/create', [BiopsiaMascotaController::class, 'create'])->name('biopsias.mascotas.create');
    Route::post('biopsias/mascotas', [BiopsiaMascotaController::class, 'store'])->name('biopsias.mascotas.store');
    Route::get('biopsias/mascotas/{nbiopsia}', [BiopsiaMascotaController::class, 'show'])->name('biopsias.mascotas.show');
    Route::get('biopsias/mascotas/{nbiopsia}/imprimir', [BiopsiaMascotaController::class, 'imprimir'])->name('biopsias.mascotas.imprimir');
    Route::get('biopsias/mascotas/{nbiopsia}/pdf', [BiopsiaMascotaController::class, 'descargarPdf'])->name('biopsias.mascotas.pdf');

    // BUSCADOR DE LISTAS PARA MASCOTAS (AJAX)
    Route::get('/biopsias-mascotas/buscar-lista/{id}', [BiopsiaMascotaController::class, 'buscarLista'])
        ->name('biopsias.mascotas.buscar-lista');
    Route::get('/biopsias-mascotas/buscar-lista-codigo/{codigo}', [BiopsiaMascotaController::class, 'buscarListaPorCodigo'])
        ->name('biopsias.mascotas.buscar-lista-codigo');

    // BUSCAR MASCOTAS (AJAX)
    Route::get('/biopsias-mascotas/buscar-mascotas', [BiopsiaMascotaController::class, 'buscarMascotas'])
        ->name('biopsias.mascotas.buscar-mascotas');
    Route::get('/biopsias-mascotas/obtener-mascota/{id}', [BiopsiaMascotaController::class, 'obtenerMascota'])
        ->name('biopsias.mascotas.obtener-mascota');

    // Rutas para biopsias archivadas
    Route::get('biopsias/archivadas', [BiopsiaArchivarController::class, 'index'])->name('biopsias.archivadas.index');
    Route::post('biopsias/{nbiopsia}/archivar', [BiopsiaArchivarController::class, 'archivar'])->name('biopsias.archivar');
    Route::post('biopsias/{nbiopsia}/restaurar', [BiopsiaArchivarController::class, 'restaurar'])->name('biopsias.restaurar');
    Route::post('biopsias/archivar-antiguas', [BiopsiaArchivarController::class, 'archivarAntiguas'])->name('biopsias.archivar-antiguas');
    Route::delete('mascotas/{mascota}', [MascotaController::class, 'destroy'])->name('mascotas.destroy');


    // CITOLOGÍAS 
    Route::get('citologias', [CitolgiaController::class, 'index'])->name('citologias.index');
    Route::get('citologias/personas', [CitolgiaPersonaController::class, 'index'])->name('citologias.personas.index');
    Route::get('citologias/personas/create', [CitolgiaPersonaController::class, 'create'])->name('citologias.personas.create');
    Route::post('citologias/personas', [CitolgiaPersonaController::class, 'store'])->name('citologias.personas.store');
    Route::get('citologias/personas/obtener-numero-correlativo', [CitolgiaPersonaController::class, 'obtenerNumeroCorrelativo'])->name('citologias.personas.obtener-numero-correlativo');
    Route::get('citologias/personas/{ncitologia}', [CitolgiaPersonaController::class, 'show'])->name('citologias.personas.show');
    Route::get('citologias/personas/{ncitologia}/edit', [CitolgiaPersonaController::class, 'edit'])->name('citologias.personas.edit');
    Route::put('citologias/personas/{ncitologia}', [CitolgiaPersonaController::class, 'update'])->name('citologias.personas.update');
    Route::patch('citologias/personas/{ncitologia}/toggle-estado', [CitolgiaPersonaController::class, 'toggleEstado'])->name('citologias.personas.toggle-estado');
    Route::get('citologias/personas/{ncitologia}/imprimir', [CitolgiaPersonaController::class, 'imprimir'])->name('citologias.personas.imprimir');
    Route::get('citologias/personas/historial/{pacienteId}', [CitolgiaPersonaController::class, 'historialPaciente'])->name('citologias.personas.historial');
    Route::get('citologias/personas/estadisticas', [CitolgiaPersonaController::class, 'estadisticas'])->name('citologias.personas.estadisticas');
    Route::get('citologias/personas/buscar-pacientes', [CitolgiaPersonaController::class, 'buscarPacientes'])->name('citologias.personas.buscar-pacientes');
    Route::get('citologias/personas/obtener-paciente/{id}', [CitolgiaPersonaController::class, 'obtenerPaciente'])->name('citologias.personas.obtener-paciente');
    Route::get('citologias/personas/buscar-lista/{id}', [CitolgiaPersonaController::class, 'buscarLista'])->name('citologias.personas.buscar-lista');
    Route::get('citologias/personas/buscar-lista-codigo/{codigo}', [CitolgiaPersonaController::class, 'buscarListaPorCodigo'])->name('citologias.personas.buscar-lista-codigo');
    Route::get('citologias/personas/exportar-csv', [CitolgiaPersonaController::class, 'exportarCsv'])->name('citologias.personas.exportar-csv');
    Route::get('citologias/personas/reporte-paciente/{pacienteId}', [CitolgiaPersonaController::class, 'reportePaciente'])->name('citologias.personas.reporte-paciente');

    // LISTAS DE BIOPSIAS
    Route::get('listas/biopsias', [ListaBiopsiaController::class, 'index'])->name('listas.biopsias.index');
    Route::get('listas/biopsias/create', [ListaBiopsiaController::class, 'create'])->name('listas.biopsias.create');
    Route::post('listas/biopsias', [ListaBiopsiaController::class, 'store'])->name('listas.biopsias.store');




    // LISTAS DE CITOLOGÍAS
    Route::get('listas/citologias', [ListaCitologiaController::class, 'index'])->name('listas.citologias.index');
    Route::get('listas/citologias/create', [ListaCitologiaController::class, 'create'])->name('listas.citologias.create');
    Route::post('listas/citologias', [ListaCitologiaController::class, 'store'])->name('listas.citologias.store');
    Route::get('listas/citologias', [ListaCitologiaController::class, 'index'])->name('listas.citologias.index');
    Route::get('listas/citologias/create', [ListaCitologiaController::class, 'create'])->name('listas.citologias.create');
    Route::post('listas/citologias', [ListaCitologiaController::class, 'store'])->name('listas.citologias.store');
    Route::get('listas/citologias/{listaCitologia}/edit', [ListaCitologiaController::class, 'edit'])->name('listas.citologias.edit');
    Route::put('listas/citologias/{listaCitologia}', [ListaCitologiaController::class, 'update'])->name('listas.citologias.update');
    Route::delete('listas/citologias/{listaCitologia}', [ListaCitologiaController::class, 'destroy'])->name('listas.citologias.destroy');

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


        // LISTA DE CITOLOGIAS
        Route::get('listas/citologias/{listaCitologia}/edit', [ListaCitologiaController::class, 'edit'])->name('listas.citologias.edit');
        Route::put('listas/citologias/{listaCitologia}', [ListaCitologiaController::class, 'update'])->name('listas.citologias.update');
    });

    // Rutas para el módulo de impresión de sobres
    Route::middleware(['auth'])->group(function () {
        Route::get('/sobres', [SobreController::class, 'index'])->name('sobres.index');
        Route::post('/sobres/generar', [SobreController::class, 'generar'])->name('sobres.generar');
        Route::post('/sobres/generar-manual', [SobreController::class, 'generarManual'])->name('sobres.generar.manual');
    });

    // Rutas de administración de usuarios - solo para administradores
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', UserAdminController::class);
    });
});

require __DIR__ . '/auth.php';
