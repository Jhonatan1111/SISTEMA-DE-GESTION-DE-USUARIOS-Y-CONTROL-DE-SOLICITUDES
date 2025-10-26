<x-app-layout>
    <!-- Modal de Selección de Tipo (SIN CAMBIOS) -->
    <div id="modal-tipo" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-2xl w-full mx-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">
                ¿Qué tipo de citología desea crear?
            </h2>
            <p class="text-gray-600 mb-6 text-center">
                Seleccione el tipo para generar el número correlativo correspondiente
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Opción Normal -->
                <button type="button"
                    onclick="seleccionarTipo('normal')"
                    class="p-6 bg-gradient-to-br from-blue-100 to-blue-50 hover:from-blue-200 hover:to-blue-100 border-2 border-blue-300 hover:border-blue-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="text-center">
                        <span class="text-5xl mb-3 block">
                            <img src="/image/normal.png" alt="Normal" class="mx-auto w-12 h-12">
                        </span>
                        <h3 class="text-lg font-bold text-blue-900 mb-1">Normal</h3>
                        <p class="text-sm text-blue-600">CN2025XXXXX</p>
                    </div>
                </button>

                <!-- Opción Líquida -->
                <button type="button"
                    onclick="seleccionarTipo('liquida')"
                    class="p-6 bg-gradient-to-br from-purple-100 to-purple-50 hover:from-purple-200 hover:to-purple-100 border-2 border-purple-300 hover:border-purple-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="text-center">
                        <span class="text-5xl mb-3 block">
                            <img src="/image/liquida.png" alt="Líquida" class="mx-auto w-12 h-12">
                        </span>
                        <h3 class="text-lg font-bold text-purple-900 mb-1">Líquida</h3>
                        <p class="text-sm text-purple-600">CL2025XXXXX</p>
                    </div>
                </button>

                <!-- Opción Especial -->
                <button type="button"
                    onclick="seleccionarTipo('especial')"
                    class="p-6 bg-gradient-to-br from-green-100 to-green-50 hover:from-green-200 hover:to-green-100 border-2 border-green-300 hover:border-green-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="text-center">
                        <span class="text-5xl mb-3 block">
                            <img src="/image/especial.png" alt="Especial" class="mx-auto w-12 h-12">
                        </span>
                        <h3 class="text-lg font-bold text-green-900 mb-1">Especial</h3>
                        <p class="text-sm text-green-600">CE2025XXXXX</p>
                    </div>
                </button>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('citologias.personas.index') }}"
                    class="text-1xl text-blue-700 hover:text-blue-800 font-semibold">
                    ← Cancelar y volver
                </a>
            </div>
        </div>
    </div>

    <!-- Formulario (inicialmente oculto) -->
    <div id="formulario-container" style="display: none;">
        <div class="max-w-5xl mx-auto px-4 py-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-blue-700">Nueva Citología - Persona</h1>
                    <p class="text-sm text-gray-500 mt-1">Número: <span class="font-semibold text-green-600" id="numero_display_header"></span></p>
                </div>
                <a href="{{ route('citologias.personas.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>

            <!-- Errores -->
            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Corrige los siguientes errores:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('citologias.personas.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo oculto para tipo -->
                <input type="hidden" name="tipo" id="tipo_seleccionado">

                <!-- Datos Básicos -->
                <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                    <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">Datos Básicos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tipo seleccionado -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Citología</label>
                            <div id="tipo_badge"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                            </div>
                            <button type="button"
                                onclick="cambiarTipo()"
                                class="mt-2 text-sm text-blue-600 hover:underline">
                                Cambiar tipo
                            </button>
                        </div>

                        <div>
                            <label for="fecha_recibida" class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Recepción <span class="text-red-500">*</span></label>
                            <input type="date" id="fecha_recibida" name="fecha_recibida"
                                value="{{ old('fecha_recibida', date('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                required>
                        </div>

                        <div>
                            <label for="paciente_id" class="block text-sm font-semibold text-gray-700 mb-1">Paciente <span class="text-red-500">*</span></label>
                            <select id="paciente_id" name="paciente_id"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                required>
                                <option value="">Seleccionar...</option>
                                @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->DUI }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Doctor (oculto si es especial) -->
                        <div id="campo-doctor">
                            <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-1">Doctor <span class="text-red-500">*</span></label>
                            <select id="doctor_id" name="doctor_id"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                                <option value="">Seleccionar...</option>
                                @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="campo-remitente" class="md:col-span-2" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="remitente_especial" class="block text-sm font-semibold text-gray-700 mb-1">
                                        Remitente Especial <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="remitente_especial" name="remitente_especial"
                                        value="{{ old('remitente_especial') }}"
                                        placeholder="Nombre del remitente..."
                                        class="w-full px-4 py-2 border-2 border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-500 transition-all">
                                </div>

                                <div>
                                    <label for="celular_remitente_especial" class="block text-sm font-semibold text-gray-700 mb-1">
                                        Celular del Remitente <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="celular_remitente_especial" name="celular_remitente_especial"
                                        value="{{ old('celular_remitente_especial') }}"
                                        placeholder="12345678"
                                        pattern="[0-9]{8}"
                                        maxlength="8"
                                        class="w-full px-4 py-2 border-2 border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-500 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plantilla (Opcional) -->
                <div class="bg-gradient-to-r from-yellow-50 via-white to-yellow-50 border border-yellow-200 rounded-2xl shadow-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-2xl">
                    <button type="button" onclick="togglePlantilla()" class="w-full px-6 py-4 flex justify-between items-center hover:bg-yellow-100 transition-colors">
                        <span class="font-medium text-yellow-800">
                            <svg class="w-5 h-5 inline mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                            Usar Plantilla (Opcional)
                        </span>
                        <svg id="icon-plantilla" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="plantilla-content" class="hidden px-6 pb-4">
                        <div>
                            <label for="lista_id" class="block text-sm font-semibold text-gray-700 mb-1">Seleccionar Lista</label>
                            <select id="lista_id" name="lista_id"
                                class="w-full px-4 py-2 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all">
                                <option value="">-- Sin plantilla --</option>
                                @foreach($listas as $lista)
                                <option value="{{ $lista->id }}" {{ old('lista_id') == $lista->id ? 'selected' : '' }}>
                                    {{ $lista->codigo }} - {{ $lista->diagnostico }}
                                </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Si selecciona una lista, se copiarán los datos automáticamente</p>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN NUEVA: Descripción Macroscópica y Microscópica -->
                <div class="bg-gradient-to-r from-green-50 via-white to-green-50 p-6 rounded-2xl shadow-xl border border-green-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                    <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">Descripción de la Muestra</h2>
                    <div class="space-y-4">
                        <!-- Descripción General -->
                        <div>
                            <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">
                                Descripción General <span class="text-red-500">*</span>
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="3"
                                class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                                placeholder="Descripción general de la muestra..." required>{{ old('descripcion') }}</textarea>
                        </div>

                        <!-- Diagnóstico Clínico -->
                        <div>
                            <label for="diagnostico_clinico" class="block text-sm font-semibold text-gray-700 mb-1">
                                Diagnóstico Clínico <span class="text-red-500">*</span>
                            </label>
                            <textarea id="diagnostico_clinico" name="diagnostico_clinico" rows="3"
                                class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                                placeholder="Diagnóstico clínico de la muestra..." required>{{ old('diagnostico_clinico') }}</textarea>
                        </div>

                        <!-- Macroscópico -->
                        <div>
                            <label for="macroscopico" class="block text-sm font-semibold text-gray-700 mb-1">
                                Descripción Macroscópica <span class="text-red-500">*</span>
                            </label>
                            <textarea id="macroscopico" name="macroscopico" rows="4"
                                class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                                placeholder="Describa las características macroscópicas de la muestra..." required>{{ old('macroscopico') }}</textarea>
                        </div>

                        <!-- Microscópico -->
                        <div>
                            <label for="microscopico" class="block text-sm font-semibold text-gray-700 mb-1">
                                Descripción Microscópica <span class="text-red-500">*</span>
                            </label>
                            <textarea id="microscopico" name="microscopico" rows="4"
                                class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                                placeholder="Describa las características microscópicas de la muestra..." required>{{ old('microscopico') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg">
                    <a href="{{ route('citologias.personas.index') }}"
                        class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                        Guardar Citología
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para seleccionar tipo y obtener número
        async function seleccionarTipo(tipo) {
            try {
                const response = await fetch(`/citologias/personas/obtener-numero-correlativo?tipo=${tipo}`);
                const data = await response.json();

                if (data.success) {
                    // Guardar tipo
                    document.getElementById('tipo_seleccionado').value = tipo;

                    // Mostrar número en header
                    document.getElementById('numero_display_header').textContent = data.numero;

                    // Mostrar badge del tipo
                    const tipoBadge = document.getElementById('tipo_badge');
                    if (tipo === 'liquida') {
                        tipoBadge.innerHTML = '<class="inline-flex text-gray-700 px-4 py-2 text-sm">Citología Líquida';
                        mostrarCampoDoctor();
                    } else if (tipo === 'especial') {
                        tipoBadge.innerHTML = '<class="inline-flex text-gray-700 px-4 py-2 text-sm">Citología Especial';
                        mostrarCampoRemitente();
                    } else {
                        tipoBadge.innerHTML = '<class="inline-flex text-gray-700 px-4 py-2 text-sm">Citología Normal';
                        mostrarCampoDoctor();
                    }

                    // Ocultar modal y mostrar formulario
                    document.getElementById('modal-tipo').style.display = 'none';
                    document.getElementById('formulario-container').style.display = 'block';
                } else {
                    alert('Error al generar número: ' + (data.message || 'Error desconocido'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al conectar con el servidor.');
            }
        }

        // Función para mostrar campo doctor y ocultar remitente
        function mostrarCampoDoctor() {
            document.getElementById('campo-doctor').style.display = 'block';
            document.getElementById('campo-remitente').style.display = 'none';
            document.getElementById('doctor_id').required = true;
            document.getElementById('remitente_especial').required = false;
            document.getElementById('celular_remitente_especial').required = false;
        }

        // Función para mostrar remitente y ocultar doctor
        function mostrarCampoRemitente() {
            document.getElementById('campo-doctor').style.display = 'none';
            document.getElementById('campo-remitente').style.display = 'block';
            document.getElementById('doctor_id').required = false;
            document.getElementById('remitente_especial').required = true;
            document.getElementById('celular_remitente_especial').required = true;
        }

        // Función para cambiar tipo
        function cambiarTipo() {
            if (confirm('¿Está seguro que desea cambiar el tipo de citología? Se generará un nuevo número correlativo.')) {
                document.getElementById('modal-tipo').style.display = 'flex';
                document.getElementById('formulario-container').style.display = 'none';
            }
        }

        // Función de toggle para plantilla
        function togglePlantilla() {
            const content = document.getElementById('plantilla-content');
            const icon = document.getElementById('icon-plantilla');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Script para aplicar plantilla - CORREGIDO
        const listas = @json($listas);

        document.getElementById('lista_id').addEventListener('change', function() {
            const selectedId = this.value;
            const plantillaDatos = document.getElementById('plantilla-datos');

            if (selectedId) {
                const plantilla = listas.find(p => p.id == selectedId);

                if (plantilla) {
                    // Copiar datos de plantilla a campos correspondientes
                    // La plantilla tiene: descripcion, diagnostico, macroscopico, microscopico
                    // Llenamos:
                    // - descripcion (primera sección) con plantilla.descripcion
                    // - diagnostico_clinico (segunda sección) con plantilla.diagnostico
                    // - macroscopico con plantilla.macroscopico
                    // - microscopico con plantilla.microscopico

                    document.getElementById('descripcion').value = plantilla.descripcion || '';
                    document.getElementById('diagnostico_clinico').value = plantilla.diagnostico || '';
                    document.getElementById('macroscopico').value = plantilla.macroscopico || '';
                    document.getElementById('microscopico').value = plantilla.microscopico || '';

                    // Mostrar vista previa
                    document.getElementById('plantilla-descripcion').textContent = plantilla.descripcion || 'N/A';
                    document.getElementById('plantilla-diagnostico').textContent = plantilla.diagnostico || 'N/A';
                    document.getElementById('plantilla-macroscopico').textContent = plantilla.macroscopico || 'N/A';
                    document.getElementById('plantilla-microscopico').textContent = plantilla.microscopico || 'N/A';
                    plantillaDatos.classList.remove('hidden');
                }
            } else {
                // Si no seleccionó ninguna plantilla, limpiar
                document.getElementById('descripcion').value = '';
                document.getElementById('diagnostico_clinico').value = '';
                document.getElementById('macroscopico').value = '';
                document.getElementById('microscopico').value = '';
                plantillaDatos.classList.add('hidden');
            }
        });

        // Mostrar modal al cargar la vista
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal-tipo').style.display = 'flex';
        });
    </script>
</x-app-layout>