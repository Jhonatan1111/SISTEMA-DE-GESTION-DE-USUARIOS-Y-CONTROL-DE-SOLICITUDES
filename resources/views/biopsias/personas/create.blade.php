<x-app-layout>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-plus-circle text-success me-2"></i>
                    Nueva Biopsia - Persona
                </h1>
                <p class="text-muted mb-0">Registrar una nueva biopsia para un paciente humano</p>
            </div>
            <div>
                <a href="{{ route('biopsias.personas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver a la Lista
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-gradient-primary text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-user-plus me-2"></i>Información de la Biopsia
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>¡Atención!</strong> Por favor corrige los siguientes errores:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form action="{{ route('biopsias.personas.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="row">
                                <!-- Información Básica -->
                                <div class="col-md-6">
                                    <div class="card border-left-primary mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="m-0 text-primary">
                                                <i class="fas fa-info-circle me-2"></i>Información Básica
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="nbiopsia" class="form-label">
                                                    <i class="fas fa-hashtag text-primary me-1"></i>
                                                    Número de Biopsia <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('nbiopsia') is-invalid @enderror"
                                                    id="nbiopsia"
                                                    name="nbiopsia"
                                                    value="{{ old('nbiopsia') }}"
                                                    placeholder="Ej: BIO-2024-001"
                                                    required>
                                                @error('nbiopsia')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Formato sugerido: BIO-YYYY-XXX
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="fecha_recibida" class="form-label">
                                                    <i class="fas fa-calendar-alt text-success me-1"></i>
                                                    Fecha de Recepción <span class="text-danger">*</span>
                                                </label>
                                                <input type="date"
                                                    class="form-control @error('fecha_recibida') is-invalid @enderror"
                                                    id="fecha_recibida"
                                                    name="fecha_recibida"
                                                    value="{{ old('fecha_recibida', date('Y-m-d')) }}"
                                                    required>
                                                @error('fecha_recibida')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información del Paciente y Doctor -->
                                <div class="col-md-6">
                                    <div class="card border-left-success mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="m-0 text-success">
                                                <i class="fas fa-users me-2"></i>Paciente y Doctor
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="paciente_id" class="form-label">
                                                    <i class="fas fa-user text-success me-1"></i>
                                                    Paciente <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select @error('paciente_id') is-invalid @enderror"
                                                    id="paciente_id"
                                                    name="paciente_id"
                                                    required>
                                                    <option value="">Seleccionar paciente...</option>
                                                    @foreach($pacientes as $paciente)
                                                    <option value="{{ $paciente->id }}"
                                                        {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                                        {{ $paciente->nombre }} {{ $paciente->apellido }}
                                                        @if($paciente->DUI)
                                                        - DUI: {{ $paciente->DUI }}
                                                        @endif
                                                        ({{ $paciente->edad }} años)
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('paciente_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="doctor_id" class="form-label">
                                                    <i class="fas fa-user-md text-primary me-1"></i>
                                                    Doctor Responsable <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select @error('doctor_id') is-invalid @enderror"
                                                    id="doctor_id"
                                                    name="doctor_id"
                                                    required>
                                                    <option value="">Seleccionar doctor...</option>
                                                    @foreach($doctores as $doctor)
                                                    <option value="{{ $doctor->id }}"
                                                        {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                        Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}
                                                        @if($doctor->especialidad)
                                                        - {{ $doctor->especialidad }}
                                                        @endif
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('doctor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Diagnóstico Clínico -->
                            <div class="card border-left-info mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 text-info">
                                        <i class="fas fa-notes-medical me-2"></i>Diagnóstico Clínico
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="diagnostico_clinico" class="form-label">
                                            <i class="fas fa-stethoscope text-info me-1"></i>
                                            Descripción del Diagnóstico <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('diagnostico_clinico') is-invalid @enderror"
                                            id="diagnostico_clinico"
                                            name="diagnostico_clinico"
                                            rows="4"
                                            placeholder="Describa el diagnóstico clínico detalladamente..."
                                            required>{{ old('diagnostico_clinico') }}</textarea>
                                        @error('diagnostico_clinico')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="fas fa-lightbulb me-1"></i>
                                            Incluya síntomas, observaciones clínicas y cualquier información relevante
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Los campos marcados con <span class="text-danger">*</span> son obligatorios
                                        </div>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('biopsias.personas.index') }}"
                                                class="btn btn-outline-secondary">
                                                <i class="fas fa-times me-1"></i> Cancelar
                                            </a>
                                            <button type="reset" class="btn btn-outline-warning">
                                                <i class="fas fa-undo me-1"></i> Limpiar
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save me-1"></i> Guardar Biopsia
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(87deg, #4e73df 0, #224abe 100%) !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-group .btn {
            margin-left: 0.25rem;
        }

        .btn-group .btn:first-child {
            margin-left: 0;
        }
    </style>

    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</x-app-layout>