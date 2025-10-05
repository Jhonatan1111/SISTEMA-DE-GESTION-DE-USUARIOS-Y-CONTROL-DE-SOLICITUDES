<x-app-layout>
    <div class="container-fluid">
        <!-- Navegación -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('biopsias.personas.index') }}">Biopsias - Personas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalles de Biopsia</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-microscope me-2"></i>Detalles de Biopsia - {{ $biopsia->nbiopsia }}
            </h1>
            <div>
                <a href="{{ route('biopsias.personas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('biopsias.personas.edit', $biopsia->nbiopsia) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                @endif
            </div>
        </div>

        <!-- Información de la Biopsia -->
        <div class="row">
            <!-- Información Principal -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Información de la Biopsia</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Número de Biopsia:</label>
                                    <p class="form-control-plaintext">{{ $biopsia->nbiopsia }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Fecha Recibida:</label>
                                    <p class="form-control-plaintext">
                                        {{ \Carbon\Carbon::parse($biopsia->fecha_recibida)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Estado:</label>
                                    <p class="form-control-plaintext">
                                        @if($biopsia->estado)
                                        <span class="badge badge-success">Activa</span>
                                        @else
                                        <span class="badge badge-warning">Inactiva</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Fecha de Registro:</label>
                                    <p class="form-control-plaintext">
                                        {{ $biopsia->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Última Actualización:</label>
                                    <p class="form-control-plaintext">
                                        {{ $biopsia->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Diagnóstico Clínico:</label>
                            <div class="border rounded p-3 bg-light">
                                {{ $biopsia->diagnostico_clinico ?? 'Sin diagnóstico registrado' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Paciente y Doctor -->
            <div class="col-lg-4">
                <!-- Información del Paciente -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Información del Paciente</h6>
                    </div>
                    <div class="card-body">
                        @if($biopsia->paciente)
                        <div class="text-center mb-3">
                            <i class="fas fa-user-circle fa-3x text-gray-300"></i>
                        </div>
                        <div class="mb-2">
                            <strong>Nombre:</strong><br>
                            {{ $biopsia->paciente->nombre }} {{ $biopsia->paciente->apellido }}
                        </div>
                        <div class="mb-2">
                            <strong>RUT:</strong><br>
                            {{ $biopsia->paciente->rut ?? $biopsia->paciente->dui }}
                        </div>
                        <div class="mb-2">
                            <strong>Edad:</strong><br>
                            {{ $biopsia->paciente->edad }} años
                        </div>
                        <div class="mb-2">
                            <strong>Sexo:</strong><br>
                            {{ $biopsia->paciente->sexo === 'M' ? 'Masculino' : 'Femenino' }}
                        </div>
                        @if($biopsia->paciente->correo)
                        <div class="mb-2">
                            <strong>Correo:</strong><br>
                            <a href="mailto:{{ $biopsia->paciente->correo }}">{{ $biopsia->paciente->correo }}</a>
                        </div>
                        @endif
                        @if($biopsia->paciente->celular)
                        <div class="mb-2">
                            <strong>Teléfono:</strong><br>
                            {{ $biopsia->paciente->celular }}
                        </div>
                        @endif
                        @else
                        <p class="text-muted text-center">Sin paciente asignado</p>
                        @endif
                    </div>
                </div>

                <!-- Información del Doctor -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Información del Doctor</h6>
                    </div>
                    <div class="card-body">
                        @if($biopsia->doctor)
                        <div class="text-center mb-3">
                            <i class="fas fa-user-md fa-3x text-gray-300"></i>
                        </div>
                        <div class="mb-2">
                            <strong>Nombre:</strong><br>
                            Dr. {{ $biopsia->doctor->nombre }} {{ $biopsia->doctor->apellido }}
                        </div>
                        <div class="mb-2">
                            <strong>Especialidad:</strong><br>
                            {{ $biopsia->doctor->especialidad }}
                        </div>
                        @if($biopsia->doctor->correo)
                        <div class="mb-2">
                            <strong>Correo:</strong><br>
                            <a href="mailto:{{ $biopsia->doctor->correo }}">{{ $biopsia->doctor->correo }}</a>
                        </div>
                        @endif
                        @if($biopsia->doctor->celular)
                        <div class="mb-2">
                            <strong>Teléfono:</strong><br>
                            {{ $biopsia->doctor->celular }}
                        </div>
                        @endif
                        @else
                        <p class="text-muted text-center">Sin doctor asignado</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Adicionales -->
        @if(auth()->user()->role === 'admin')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Acciones</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('biopsias.personas.toggle-estado', $biopsia->nbiopsia) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $biopsia->estado ? 'secondary' : 'success' }} btn-block"
                                onclick="return confirm('¿Está seguro de cambiar el estado de esta biopsia?')">
                                <i class="fas fa-{{ $biopsia->estado ? 'pause' : 'play' }} me-2"></i>
                                {{ $biopsia->estado ? 'Desactivar' : 'Activar' }} Biopsia
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('biopsias.personas.edit', $biopsia->nbiopsia) }}" class="btn btn-warning btn-block">
                            <i class="fas fa-edit me-2"></i>Editar Biopsia
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('styles')
    <style>
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }
        
        .form-control-plaintext {
            padding-left: 0;
            margin-bottom: 0;
        }
        
        .badge {
            font-size: 0.875rem;
        }
    </style>
    @endpush
</x-app-layout>