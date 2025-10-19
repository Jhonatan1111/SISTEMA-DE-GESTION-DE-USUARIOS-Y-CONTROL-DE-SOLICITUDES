<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Nueva Citología de Persona</h1>
            <p class="text-gray-600 mt-1">Registrar una nueva citología para paciente</p>
        </div>

        <!-- Formulario (Inicialmente oculto hasta seleccionar tipo) -->
        <div id="formulario-container" style="display: none;">
            <form action="{{ route('citologias.personas.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo oculto para tipo -->
                <input type="hidden" name="tipo" id="tipo_seleccionado">

                <!-- Información Básica -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">
                        📋 Información Básica
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Número de Citología (se mostrará después de seleccionar tipo) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Número de Citología
                            </label>
                            <input type="text"
                                id="numero_citologia_display"
                                readonly
                                class="w-full px-4 py-2 bg-gray-100 border-2 border-gray-300 rounded-lg cursor-not-allowed text-gray-600 font-semibold">
                            <p class="mt-1 text-xs text-gray-500">
                                <span id="prefijo_info"></span>
                            </p>
                        </div>

                        <!-- Tipo seleccionado (mostrar) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Tipo de Citología
                            </label>
                            <div id="tipo_badge" class="py-2"></div>
                            <button type="button"
                                onclick="cambiarTipo()"
                                class="mt-2 text-sm text-blue-600 hover:text-blue-800 underline">
                                Cambiar tipo
                            </button>
                        </div>

                        <!-- Fecha Recibida -->
                        <div>
                            <label for="fecha_recibida" class="block text-sm font-semibold text-gray-700 mb-1">
                                Fecha Recibida <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                id="fecha_recibida"
                                name="fecha_recibida"
                                value="{{ old('fecha_recibida', date('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                required
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            @error('fecha_recibida')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Doctor -->
                        <div>
                            <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                Doctor <span class="text-red-500">*</span>
                            </label>
                            <select id="doctor_id"
                                name="doctor_id"
                                required
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                                <option value="">Seleccione doctor...</option>
                                @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->nombre }} {{ $doctor->apellido }}
                                </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Paciente -->
                        <div class="md:col-span-2">
                            <label for="paciente_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                Paciente <span class="text-red-500">*</span>
                            </label>
                            <select id="paciente_id"
                                name="paciente_id"
                                required
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                                <option value="">Seleccione paciente...</option>
                                @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->DUI }}
                                </option>
                                @endforeach
                            </select>
                            @error('paciente_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Diagnóstico Clínico -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">
                        🩺 Diagnóstico Clínico
                    </h2>

                    <div>
                        <label for="diagnostico_clinico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Diagnóstico Clínico <span class="text-red-500">*</span>
                        </label>
                        <textarea id="diagnostico_clinico"
                            name="diagnostico_clinico"
                            rows="4"
                            required
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500"
                            placeholder="Ingrese el diagnóstico clínico...">{{ old('diagnostico_clinico') }}</textarea>
                        @error('diagnostico_clinico')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lista de Citologías (Opcional) -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-purple-700 mb-4 border-b-2 border-purple-200 pb-2">
                        📝 Lista Predefinida (Opcional)
                    </h2>

                    <div>
                        <label for="lista_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Seleccionar Lista
                        </label>
                        <select id="lista_id"
                            name="lista_id"
                            class="w-full px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:border-purple-500">
                            <option value="">Sin lista predefinida</option>
                            @foreach($listas as $lista)
                            <option value="{{ $lista->id }}" {{ old('lista_id') == $lista->id ? 'selected' : '' }}>
                                {{ $lista->codigo }} - {{ $lista->diagnostico }}
                            </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Si selecciona una lista, se copiarán los datos automáticamente</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('citologias.personas.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                        Guardar Citología
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Selección de Tipo -->
    <div id="modal-tipo" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-md w-full mx-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">
                ¿Qué tipo de citología desea crear?
            </h2>
            <p class="text-gray-600 mb-6 text-center">
                Seleccione el tipo para generar el número correlativo correspondiente
            </p>

            <div class="space-y-4">
                <!-- Opción Normal -->
                <button type="button"
                    onclick="seleccionarTipo('normal')"
                    class="w-full p-6 bg-gradient-to-r from-gray-100 to-gray-50 hover:from-gray-200 hover:to-gray-100 border-2 border-gray-300 hover:border-gray-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="text-4xl">📄</span>
                            <div class="text-left">
                                <h3 class="text-xl font-bold text-gray-900">Citología Normal</h3>
                                <p class="text-sm text-gray-600">Correlativo: C202510XXX</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </button>

                <!-- Opción Líquida -->
                <button type="button"
                    onclick="seleccionarTipo('liquida')"
                    class="w-full p-6 bg-gradient-to-r from-purple-100 to-purple-50 hover:from-purple-200 hover:to-purple-100 border-2 border-purple-300 hover:border-purple-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="text-4xl">💧</span>
                            <div class="text-left">
                                <h3 class="text-xl font-bold text-purple-900">Citología Líquida</h3>
                                <p class="text-sm text-purple-600">Correlativo: L202510XXX</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </button>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('citologias.personas.index') }}"
                    class="text-gray-500 hover:text-gray-700 text-sm underline">
                    Cancelar y volver
                </a>
            </div>
        </div>
    </div>

    <script>
        // Función para seleccionar tipo y obtener número correlativo
        async function seleccionarTipo(tipo) {
            try {
                // Obtener número correlativo del servidor
                const response = await fetch(`/citologias/personas/obtener-numero-correlativo?tipo=${tipo}`);
                const data = await response.json();

                if (data.success) {
                    // Guardar tipo seleccionado
                    document.getElementById('tipo_seleccionado').value = tipo;

                    // Mostrar número generado
                    document.getElementById('numero_citologia_display').value = data.numero;

                    // Mostrar badge del tipo
                    const tipoBadge = document.getElementById('tipo_badge');
                    if (tipo === 'liquida') {
                        tipoBadge.innerHTML = '<span class="inline-flex items-center bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-semibold">💧 Citología Líquida</span>';
                        document.getElementById('prefijo_info').textContent = 'Prefijo L = Líquida';
                    } else {
                        tipoBadge.innerHTML = '<span class="inline-flex items-center bg-gray-100 text-gray-800 px-4 py-2 rounded-full text-sm font-semibold">📄 Citología Normal</span>';
                        document.getElementById('prefijo_info').textContent = 'Prefijo C = Normal';
                    }

                    // Ocultar modal y mostrar formulario
                    document.getElementById('modal-tipo').style.display = 'none';
                    document.getElementById('formulario-container').style.display = 'block';
                }
            } catch (error) {
                console.error('Error al obtener número correlativo:', error);
                alert('Error al generar el número. Por favor, intente de nuevo.');
            }
        }

        // Función para cambiar tipo (volver a mostrar modal)
        function cambiarTipo() {
            if (confirm('¿Está seguro que desea cambiar el tipo de citología? Se generará un nuevo número correlativo.')) {
                document.getElementById('modal-tipo').style.display = 'flex';
                document.getElementById('formulario-container').style.display = 'none';
            }
        }

        // Mostrar modal al cargar la página
        window.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal-tipo').style.display = 'flex';
        });
    </script>
</x-app-layout>