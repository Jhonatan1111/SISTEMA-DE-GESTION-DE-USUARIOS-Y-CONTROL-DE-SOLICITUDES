<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Nueva Biopsia de Persona</h1>
            <p class="text-gray-600 mt-1">Registrar una nueva biopsia para paciente</p>
        </div>

        <!-- Formulario (Inicialmente oculto hasta seleccionar tipo) -->
        <div id="formulario-container" style="display: none;">
            <form action="{{ route('biopsias.personas.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo oculto para tipo -->
                <input type="hidden" name="tipo" id="tipo_seleccionado">

                <!-- Información Básica -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">
                        📋 Información Básica
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Número de Biopsia -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Número de Biopsia
                            </label>
                            <input type="text"
                                id="numero_biopsia_display"
                                readonly
                                class="w-full px-4 py-2 bg-gray-100 border-2 border-gray-300 rounded-lg cursor-not-allowed text-gray-600 font-semibold">
                            <p class="mt-1 text-xs text-gray-500">
                                <span id="prefijo_info"></span>
                            </p>
                        </div>

                        <!-- Tipo seleccionado -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Tipo de Biopsia
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
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Paciente -->
                        <div>
                            <label for="paciente_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                Paciente <span class="text-red-500">*</span>
                            </label>
                            <select id="paciente_id"
                                name="paciente_id"
                                required
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                                <option value="">Seleccione un paciente</option>
                                @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->DUI ?? 'Sin DUI' }}
                                </option>
                                @endforeach
                            </select>
                            @error('paciente_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información del Doctor -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">
                        👨‍⚕️ Información del Doctor
                    </h2>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-1">
                                Doctor Remitente <span class="text-red-500">*</span>
                            </label>
                            <select id="doctor_id"
                                name="doctor_id"
                                required
                                class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500">
                                <option value="">Seleccione un doctor</option>
                                @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->nombre }} {{ $doctor->apellido }} - JVPM: {{ $doctor->jvpm }}
                                </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Diagnóstico Clínico -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-purple-700 mb-4 border-b-2 border-purple-200 pb-2">
                        🔬 Diagnóstico Clínico
                    </h2>

                    <div>
                        <label for="diagnostico_clinico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Diagnóstico Clínico <span class="text-red-500">*</span>
                        </label>
                        <textarea id="diagnostico_clinico"
                            name="diagnostico_clinico"
                            rows="4"
                            required
                            class="w-full px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:border-purple-500"
                            placeholder="Ingrese el diagnóstico clínico...">{{ old('diagnostico_clinico') }}</textarea>
                        @error('diagnostico_clinico')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lista de Biopsias (Opcional) -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-orange-700 mb-4 border-b-2 border-orange-200 pb-2">
                        📝 Resultados (Opcional)
                    </h2>

                    <div>
                        <label for="lista_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Seleccionar de Lista de Biopsias
                        </label>
                        <select id="lista_id"
                            name="lista_id"
                            class="w-full px-4 py-2 border-2 border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-500">
                            <option value="">-- Sin lista (manual) --</option>
                            @foreach($listas as $lista)
                            <option value="{{ $lista->id }}" {{ old('lista_id') == $lista->id ? 'selected' : '' }}>
                                {{ $lista->diagnostico }}
                            </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Si selecciona una lista, se copiarán los datos automáticamente</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('biopsias.personas.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                        Guardar Biopsia
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Selección de Tipo (Solo 2 opciones para Personas) -->
    <div id="modal-tipo" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-xl w-full mx-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">
                ¿Qué tipo de biopsia desea crear?
            </h2>
            <p class="text-gray-600 text-center mb-6">
                Seleccione el tipo para generar el número correlativo correspondiente
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Biopsia Persona Normal -->
                <button type="button"
                    onclick="seleccionarTipo('persona-normal')"
                    class="p-6 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
                    <div class="text-4xl mb-2 text-center">📄</div>
                    <h3 class="text-lg font-bold text-gray-900 text-center">Biopsia Normal</h3>
                    <p class="text-xs text-blue-600 font-mono text-center mt-2">BPN2025-0001</p>
                </button>

                <!-- Biopsia Persona Líquida -->
                <button type="button"
                    onclick="seleccionarTipo('persona-liquida')"
                    class="p-6 border-2 border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all">
                    <div class="text-4xl mb-2 text-center">💧</div>
                    <h3 class="text-lg font-bold text-gray-900 text-center">Biopsia Líquida</h3>
                    <p class="text-xs text-purple-600 font-mono text-center mt-2">BPL2025-0001</p>
                </button>
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('biopsias.personas.index') }}"
                    class="text-gray-500 hover:text-gray-700 text-sm underline">
                    Cancelar y volver
                </a>
            </div>
        </div>
    </div>

    <script>
        async function seleccionarTipo(tipo) {
            try {
                // Obtener número correlativo del backend
                const response = await fetch(`/api/biopsias/obtener-numero/${tipo}`);
                const data = await response.json();

                if (data.success) {
                    // Guardar tipo en campo oculto (solo normal o liquida)
                    const tipoBase = tipo.includes('liquida') ? 'liquida' : 'normal';
                    document.getElementById('tipo_seleccionado').value = tipoBase;

                    // Mostrar número generado
                    document.getElementById('numero_biopsia_display').value = data.numero;

                    // Actualizar badge y prefijo info según tipo
                    const tipoBadge = document.getElementById('tipo_badge');
                    if (tipo === 'persona-liquida') {
                        tipoBadge.innerHTML = '<span class="inline-flex items-center bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-semibold">💧 Biopsia Líquida</span>';
                        document.getElementById('prefijo_info').textContent = 'Prefijo BPL = Biopsia Persona Líquida';
                    } else {
                        tipoBadge.innerHTML = '<span class="inline-flex items-center bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">📄 Biopsia Normal</span>';
                        document.getElementById('prefijo_info').textContent = 'Prefijo BPN = Biopsia Persona Normal';
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
            if (confirm('¿Está seguro que desea cambiar el tipo de biopsia? Se generará un nuevo número correlativo.')) {
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