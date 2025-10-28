<x-app-layout>
    <!-- Modal de Selección de Tipo -->
    <div id="modal-tipo" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: flex;">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-xl w-full mx-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">
                ¿Qué tipo de biopsia desea crear?
            </h2>
            <p class="text-gray-600 text-center mb-6">
                Seleccione el tipo para generar el número correlativo correspondiente
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Biopsia Normal -->
                <button type="button"
                    onclick="seleccionarTipo('normal')"
                    class="p-6 bg-gradient-to-br from-blue-100 to-blue-50 hover:from-blue-200 hover:to-blue-100 border-2 border-blue-300 hover:border-blue-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="text-center">
                        <span class="text-5xl mb-3 block">
                            <img src="/image/bnormal.png" alt="Bnormal" class="mx-auto w-12 h-12">
                        </span>
                        <h3 class="text-lg font-bold text-blue-900 mb-1">Normal</h3>
                        <p class="text-sm text-blue-600">BPN2025XXXX</p>
                    </div>
                </button>

                <!-- Biopsia Líquida -->
                <button type="button"
                    onclick="seleccionarTipo('liquida')"
                    class="p-6 bg-gradient-to-br from-purple-100 to-purple-50 hover:from-purple-200 hover:to-purple-100 border-2 border-purple-300 hover:border-purple-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="text-center">
                        <span class="text-5xl mb-3 block">
                            <img src="/image/lavado.png" alt="Lavado" class="mx-auto w-12 h-12">
                        </span>
                        <h3 class="text-lg font-bold text-purple-900 mb-1">Lavado</h3>
                        <p class="text-sm text-purple-600">BPL2025XXXX</p>
                    </div>
                </button>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('biopsias.personas.index') }}"
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
                    <h1 class="text-3xl font-extrabold text-blue-700">Nueva Biopsia - Persona</h1>
                    <p class="text-sm text-gray-500 mt-1">Número: <span class="font-semibold text-green-600" id="numero_display_header"></span></p>
                </div>
                <a href="{{ route('biopsias.personas.index') }}" class="text-gray-600 hover:text-gray-900">
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
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
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

            <form action="{{ route('biopsias.personas.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo oculto para tipo -->
                <input type="hidden" name="tipo" id="tipo_seleccionado">

                <!-- Datos Básicos -->
                <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                    <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">Datos Básicos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                    {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->dui }} ({{ $paciente->edad }} años)
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-1">Doctor <span class="text-red-500">*</span></label>
                            <select id="doctor_id" name="doctor_id"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                required>
                                <option value="">Seleccionar...</option>
                                @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="diagnostico_clinico" class="block text-sm font-semibold text-gray-700 mb-1">Diagnóstico Clínico <span class="text-red-500">*</span></label>
                            <textarea id="diagnostico_clinico" name="diagnostico_clinico" rows="3"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                placeholder="Describa el diagnóstico clínico..." required>{{ old('diagnostico_clinico') }}</textarea>
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Buscar por Código</label>
                                <div class="flex gap-2">
                                    <input type="text" id="buscar_codigo" placeholder="Ej: L001"
                                        class="flex-1 px-4 py-2 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 uppercase transition-all">
                                    <button type="button" id="btn_buscar_codigo"
                                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                                        Buscar
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="lista_id" class="block text-sm font-semibold text-gray-700 mb-1">O selecciona</label>
                                <select id="lista_id" name="lista_id"
                                    class="w-full px-4 py-2 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all">
                                    <option value="">-- Sin plantilla --</option>
                                    @foreach($listas as $lista)
                                    <option value="{{ $lista->id }}" {{ old('lista_id') == $lista->id ? 'selected' : '' }}>
                                        {{ $lista->codigo }} - {{ $lista->diagnostico }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Análisis Detallado -->
                <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 border border-blue-200 rounded-2xl shadow-lg overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-2xl">
                    <button type="button" onclick="toggleAnalisis()" class="w-full px-6 py-4 flex justify-between items-center hover:bg-blue-100 transition-colors">
                        <span class="font-medium text-blue-700">
                            Análisis Detallado (Opcional)
                        </span>
                        <svg id="icon-analisis" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="analisis-content" class="hidden px-6 pb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="diagnostico" class="block text-sm font-semibold text-gray-700 mb-1">Diagnóstico Final</label>
                                <textarea id="diagnostico" name="diagnostico" rows="3"
                                    class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">{{ old('diagnostico') }}</textarea>
                            </div>
                            <div>
                                <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">Descripción General</label>
                                <textarea id="descripcion" name="descripcion" rows="3"
                                    class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">{{ old('descripcion') }}</textarea>
                            </div>
                            <div>
                                <label for="macroscopico" class="block text-sm font-semibold text-gray-700 mb-1">Análisis Macroscópico</label>
                                <textarea id="macroscopico" name="macroscopico" rows="3"
                                    class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">{{ old('macroscopico') }}</textarea>
                            </div>
                            <div>
                                <label for="microscopico" class="block text-sm font-semibold text-gray-700 mb-1">Análisis Microscópico</label>
                                <textarea id="microscopico" name="microscopico" rows="3"
                                    class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">{{ old('microscopico') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg">
                    <a href="{{ route('biopsias.personas.index') }}"
                        class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                        Guardar Biopsia
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para seleccionar tipo y obtener número
        async function seleccionarTipo(tipo) {
            try {
                const response = await fetch(`/biopsias/personas/obtener-numero-correlativo?tipo=${tipo}`);
                const data = await response.json();

                if (data.success) {
                    // Guardar tipo
                    document.getElementById('tipo_seleccionado').value = tipo;

                    // Mostrar número en header
                    document.getElementById('numero_display_header').textContent = data.numero;

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

        // Funciones de toggle (igual que edit)
        function togglePlantilla() {
            const content = document.getElementById('plantilla-content');
            const icon = document.getElementById('icon-plantilla');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        function toggleAnalisis() {
            const content = document.getElementById('analisis-content');
            const icon = document.getElementById('icon-analisis');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Buscar por código (igual que edit)
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('btn_buscar_codigo').addEventListener('click', function() {
                const codigo = document.getElementById('buscar_codigo').value.trim().toUpperCase();
                if (!codigo) {
                    alert('Ingresa un código');
                    return;
                }

                fetch(`/biopsias-personas/buscar-lista-codigo/${codigo}`)
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            const data = result.data;
                            // Solo extraer macroscopico de las listas
                            document.getElementById('macroscopico').value = data.macroscopico || '';
                            document.getElementById('lista_id').value = data.id;
                            // Los campos diagnostico y microscopico se escriben manualmente
                            if (document.getElementById('analisis-content').classList.contains('hidden')) toggleAnalisis();
                        } else {
                            alert(`Código "${codigo}" no encontrado`);
                        }
                    });
            });

            // Mostrar modal al cargar
            document.getElementById('modal-tipo').style.display = 'flex';
        });
    </script>
</x-app-layout>