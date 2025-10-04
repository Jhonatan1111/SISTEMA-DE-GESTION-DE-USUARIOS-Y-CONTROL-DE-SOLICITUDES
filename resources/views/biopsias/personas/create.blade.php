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
                                            <!-- NÚMERO AUTOMÁTICO - SOLO LECTURA -->
                                            <div class="mb-3">
                                                <label for="numero_generado" class="form-label">
                                                    <i class="fas fa-hashtag text-success me-1"></i>
                                                    Número de Biopsia (Auto-generado)
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success text-white">
                                                        <i class="fas fa-robot"></i>
                                                    </span>
                                                    <input type="text"
                                                        class="form-control bg-light"
                                                        id="numero_generado"
                                                        value="{{ $numeroGenerado }}"
                                                        readonly>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock text-muted"></i>
                                                    </span>
                                                </div>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Este número se genera automáticamente y no se puede modificar
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
                                                        - JVPM: {{ $doctor->jvpm }}
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
                            <!-- Plantilla de Lista (OPCIONAL) -->
                            <!-- Plantilla de Lista (OPCIONAL) -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-left-warning mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="m-0 text-warning">
                                                <i class="fas fa-clipboard-list me-2"></i>Plantilla de Lista (Opcional)
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Selecciona una plantilla o busca por código para auto-llenar los campos de análisis.
                                            </div>

                                            <div class="row">
                                                <!-- Búsqueda por código -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="buscar_codigo" class="form-label">
                                                        <i class="fas fa-search text-warning me-1"></i>
                                                        Buscar por Código
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control"
                                                            id="buscar_codigo"
                                                            placeholder="Ej: BIO-001, PIEL-01..."
                                                            style="text-transform: uppercase;">
                                                        <button class="btn btn-warning" type="button" id="btn_buscar_codigo">
                                                            <i class="fas fa-search"></i> Buscar
                                                        </button>
                                                    </div>
                                                    <small class="text-muted">Escribe el código y presiona Buscar</small>
                                                </div>

                                                <!-- Selector dropdown -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="lista_id" class="form-label">
                                                        <i class="fas fa-list-alt text-warning me-1"></i>
                                                        O selecciona de la lista
                                                    </label>
                                                    <select class="form-select" id="lista_id" name="lista_id">
                                                        <option value="">-- Sin plantilla --</option>
                                                        @foreach($listas as $lista)
                                                        <option value="{{ $lista->id }}">
                                                            {{ $lista->codigo }} - {{ $lista->diagnostico }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos de Análisis Detallado -->
                            <div class="card border-left-info mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 text-info">
                                        <i class="fas fa-microscope me-2"></i>Análisis Detallado (Opcional)
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="diagnostico" class="form-label">
                                                <i class="fas fa-notes-medical text-info me-1"></i>
                                                Diagnóstico Final
                                            </label>
                                            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="4"
                                                placeholder="Diagnóstico detallado...">{{ old('diagnostico') }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="descripcion" class="form-label">
                                                <i class="fas fa-align-left text-info me-1"></i>
                                                Descripción General
                                            </label>
                                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4"
                                                placeholder="Descripción de la muestra...">{{ old('descripcion') }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="macroscopico" class="form-label">
                                                <i class="fas fa-eye text-info me-1"></i>
                                                Análisis Macroscópico
                                            </label>
                                            <textarea class="form-control" id="macroscopico" name="macroscopico" rows="4"
                                                placeholder="Observación macroscópica...">{{ old('macroscopico') }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="microscopico" class="form-label">
                                                <i class="fas fa-microscope text-info me-1"></i>
                                                Análisis Microscópico
                                            </label>
                                            <textarea class="form-control" id="microscopico" name="microscopico" rows="4"
                                                placeholder="Observación microscópica...">{{ old('microscopico') }}</textarea>
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
                                            El número de biopsia <strong>{{ $numeroGenerado }}</strong> se asignará automáticamente
                                        </div>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('biopsias.index') }}"
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
    <script>
        // Auto-llenar campos cuando se selecciona una lista del dropdown
        document.getElementById('lista_id').addEventListener('change', function() {
            const listaId = this.value;

            if (listaId) {
                cargarLista(`/biopsias-personas/buscar-lista/${listaId}`);
                // Limpiar el campo de búsqueda por código
                document.getElementById('buscar_codigo').value = '';
            } else {
                limpiarCampos();
            }
        });

        // Buscar por código al presionar el botón
        document.getElementById('btn_buscar_codigo').addEventListener('click', function() {
            const codigo = document.getElementById('buscar_codigo').value.trim().toUpperCase();

            if (codigo) {
                cargarListaPorCodigo(codigo);
            } else {
                alert('Por favor ingresa un código');
            }
        });

        // Buscar también al presionar Enter en el campo
        document.getElementById('buscar_codigo').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('btn_buscar_codigo').click();
            }
        });

        // Función para cargar lista por código
        function cargarListaPorCodigo(codigo) {
            const btn = document.getElementById('btn_buscar_codigo');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Buscando...';

            fetch(`/biopsias-personas/buscar-lista-codigo/${codigo}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const data = result.data;

                        // Llenar campos
                        document.getElementById('diagnostico').value = data.diagnostico || '';
                        document.getElementById('descripcion').value = data.descripcion || '';
                        document.getElementById('microscopico').value = data.microscopico || '';
                        document.getElementById('macroscopico').value = data.macroscopico || '';

                        // Seleccionar en el dropdown
                        document.getElementById('lista_id').value = data.id;

                        mostrarNotificacion(`Plantilla "${data.codigo}" cargada exitosamente`, 'success');
                    } else {
                        mostrarNotificacion(`Código "${codigo}" no encontrado`, 'danger');
                        limpiarCampos();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al buscar el código', 'danger');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        }

        // Función genérica para cargar lista
        function cargarLista(url) {
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Error al cargar');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('diagnostico').value = data.diagnostico || '';
                    document.getElementById('descripcion').value = data.descripcion || '';
                    document.getElementById('microscopico').value = data.microscopico || '';
                    document.getElementById('macroscopico').value = data.macroscopico || '';

                    mostrarNotificacion(`Campos llenados desde la plantilla "${data.codigo}"`, 'success');
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al cargar la plantilla', 'danger');
                });
        }

        // Función para limpiar campos
        function limpiarCampos() {
            document.getElementById('diagnostico').value = '';
            document.getElementById('descripcion').value = '';
            document.getElementById('microscopico').value = '';
            document.getElementById('macroscopico').value = '';
        }

        // Función para mostrar notificaciones
        function mostrarNotificacion(mensaje, tipo) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${tipo} alert-dismissible fade show`;
            alert.innerHTML = `
        <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

            const firstCard = document.querySelector('.card');
            firstCard.parentNode.insertBefore(alert, firstCard);

            setTimeout(() => alert.remove(), 5000);
        }
    </script>
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

        /* Estilo especial para campo readonly */
        .form-control[readonly] {
            background-color: #f8f9fc !important;
            border: 2px solid #1cc88a;
            font-weight: bold;
            color: #1cc88a;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
    </style>
</x-app-layout>