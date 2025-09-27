@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-archive text-warning me-2"></i>
                Biopsias Archivadas
            </h1>
            <p class="text-muted mb-0">Gestión de biopsias archivadas del sistema</p>
        </div>
        <div class="btn-group" role="group">
            <a href="{{ route('biopsias.index') }}" class="btn btn-outline-info">
                <i class="fas fa-list me-1"></i> Vista General
            </a>
            <a href="{{ route('biopsias.personas.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-users me-1"></i> Solo Personas
            </a>
            <form method="POST" action="{{ route('biopsias.archivar-antiguas') }}" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-warning" 
                        onclick="return confirm('¿Está seguro de archivar todas las biopsias de más de 6 meses?')">
                    <i class="fas fa-archive me-1"></i> Archivar Antiguas
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>¡Éxito!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Archivadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Personas Archivadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['personas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Mascotas Archivadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['mascotas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paw fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="tipo" class="form-label">Tipo de Biopsia</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <option value="personas" {{ request('tipo') == 'personas' ? 'selected' : '' }}>
                            <i class="fas fa-users"></i> Personas
                        </option>
                        <option value="mascotas" {{ request('tipo') == 'mascotas' ? 'selected' : '' }}>
                            <i class="fas fa-paw"></i> Mascotas
                        </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="buscar" class="form-label">Búsqueda General</label>
                    <input type="text" name="buscar" id="buscar" class="form-control" 
                           placeholder="Buscar por número, diagnóstico, paciente o doctor..." 
                           value="{{ request('buscar') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Lista de Biopsias Archivadas
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                        Exportar Archivadas
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="return confirm('¿Restaurar todas las biopsias archivadas?')">
                        <i class="fas fa-undo fa-sm fa-fw mr-2 text-gray-400"></i>
                        Restaurar Todas
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>N° Biopsia</th>
                            <th><i class="fas fa-calendar me-1"></i>Fecha Recibida</th>
                            <th><i class="fas fa-tag me-1"></i>Tipo</th>
                            <th><i class="fas fa-user me-1"></i>Paciente/Mascota</th>
                            <th><i class="fas fa-user-md me-1"></i>Doctor</th>
                            <th><i class="fas fa-notes-medical me-1"></i>Diagnóstico</th>
                            <th><i class="fas fa-clock me-1"></i>Archivado</th>
                            <th><i class="fas fa-cogs me-1"></i>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($biopsias as $biopsia)
                        <tr class="table-row-hover">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-secondary rounded-circle">
                                            <i class="fas fa-microscope text-white"></i>
                                        </div>
                                    </div>
                                    <strong class="text-secondary">{{ $biopsia->nbiopsia }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $biopsia->fecha_recibida->format('d/m/Y') }}</span>
                                    <small class="text-muted">{{ $biopsia->fecha_recibida->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                @if($biopsia->paciente_id)
                                    <span class="badge bg-primary">
                                        <i class="fas fa-user me-1"></i>Persona
                                    </span>
                                @else
                                    <span class="badge bg-info">
                                        <i class="fas fa-paw me-1"></i>Mascota
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($biopsia->paciente_id)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title bg-primary rounded-circle">
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
                                @else
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title bg-info rounded-circle">
                                                <i class="fas fa-paw text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $biopsia->mascota->nombre }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>{{ $biopsia->mascota->propietario }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-paw me-1"></i>{{ $biopsia->mascota->especie }}
                                            </small>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title bg-success rounded-circle">
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
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-warning">{{ $biopsia->updated_at->format('d/m/Y') }}</span>
                                    <small class="text-muted">{{ $biopsia->updated_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('biopsias.show', $biopsia->nbiopsia) }}"
                                       class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form method="POST" action="{{ route('biopsias.restaurar', $biopsia->nbiopsia) }}"
                                          style="display: inline-block;"
                                          onsubmit="return confirm('¿Está seguro de restaurar esta biopsia?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" 
                                                data-bs-toggle="tooltip" title="Restaurar biopsia">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-archive fa-3x text-gray-300 mb-3"></i>
                                    <h5 class="text-gray-500">No hay biopsias archivadas</h5>
                                    <p class="text-muted">Las biopsias archivadas aparecerán aquí</p>
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
    .border-left-secondary {
        border-left: 0.25rem solid #6c757d !important;
    }
    .border-left-dark {
        border-left: 0.25rem solid #343a40 !important;
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
        background-color: rgba(108, 117, 125, 0.05);
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