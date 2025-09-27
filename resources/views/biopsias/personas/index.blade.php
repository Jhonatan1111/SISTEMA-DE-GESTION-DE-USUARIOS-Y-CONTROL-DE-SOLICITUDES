@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Navegación separada -->
    <div class="mb-6">
        <nav class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
            <a href="{{ route('mascotas.index') }}" 
               class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                Mascotas
            </a>
            <a href="{{ route('biopsias.index') }}" 
               class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                Biopsias
            </a>
            <a href="{{ route('biopsias.personas.index') }}" 
               class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                Biopsias Personas
            </a>
        </nav>
    </div>

    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Biopsias - Personas
            </h1>
            <p class="text-gray-600 mt-1">Gestión de biopsias para pacientes humanos</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('biopsias.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Ver Todas
            </a>
            <a href="{{ route('biopsias.personas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Nueva Biopsia
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Biopsias Personas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $biopsias->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Biopsias Activas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $biopsias->where('estado', 1)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Biopsias Inactivas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $biopsias->where('estado', 0)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Este Mes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $biopsias->where('fecha_recibida', '>=', now()->startOfMonth())->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Lista de Biopsias de Personas
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="{{ route('biopsias.personas.create') }}">
                        <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                        Nueva Biopsia
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                        Exportar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>¡Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>N° Biopsia</th>
                            <th><i class="fas fa-calendar me-1"></i>Fecha Recibida</th>
                            <th><i class="fas fa-user me-1"></i>Paciente</th>
                            <th><i class="fas fa-user-md me-1"></i>Doctor</th>
                            <th><i class="fas fa-notes-medical me-1"></i>Diagnóstico</th>
                            <th><i class="fas fa-toggle-on me-1"></i>Estado</th>
                            <th><i class="fas fa-cogs me-1"></i>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($biopsias as $biopsia)
                        <tr class="table-row-hover">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-primary rounded-circle">
                                            <i class="fas fa-microscope text-white"></i>
                                        </div>
                                    </div>
                                    <strong class="text-primary">{{ $biopsia->nbiopsia }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $biopsia->fecha_recibida->format('d/m/Y') }}</span>
                                    <small class="text-muted">{{ $biopsia->fecha_recibida->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-success rounded-circle">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $biopsia->paciente->nombre }} {{ $biopsia->paciente->apellido }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-id-card me-1"></i>DUI: {{ $biopsia->paciente->DUI ?? 'N/A' }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-birthday-cake me-1"></i>{{ $biopsia->paciente->edad }} años
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-info rounded-circle">
                                            <i class="fas fa-user-md text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}</div>
                                        @if(isset($biopsia->doctor->especialidad))
                                            <small class="text-muted">{{ $biopsia->doctor->especialidad }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="diagnosis-preview" data-bs-toggle="tooltip" 
                                     title="{{ $biopsia->diagnostico_clinico }}">
                                    {{ Str::limit($biopsia->diagnostico_clinico, 50) }}
                                </div>
                            </td>
                            <td>
                                @if($biopsia->estado)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Activa
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Inactiva
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('biopsias.show', $biopsia->nbiopsia) }}"
                                       class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('biopsias.personas.edit', $biopsia->nbiopsia) }}"
                                       class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('biopsias.personas.toggle-estado', $biopsia->nbiopsia) }}"
                                          style="display: inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-sm {{ $biopsia->estado ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                data-bs-toggle="tooltip" 
                                                title="{{ $biopsia->estado ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas {{ $biopsia->estado ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                    <h5 class="text-gray-500">No hay biopsias de personas registradas</h5>
                                    <p class="text-muted">Comienza creando tu primera biopsia de persona</p>
                                    <a href="{{ route('biopsias.personas.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Crear Primera Biopsia
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($biopsias->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $biopsias->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    
    .avatar-sm {
        width: 2rem;
        height: 2rem;
    }
    
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-size: 0.875rem;
    }
    
    .table-row-hover:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    
    .diagnosis-preview {
        cursor: help;
        max-width: 200px;
    }
    
    .empty-state {
        padding: 2rem;
    }
    
    .btn-group .btn {
        margin-right: 0.25rem;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endsection