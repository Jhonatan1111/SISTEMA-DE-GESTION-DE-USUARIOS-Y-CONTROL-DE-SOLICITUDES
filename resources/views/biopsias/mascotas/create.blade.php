<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-6">
        <!-- Header simple -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nueva Biopsia - Mascota</h1>
                <p class="text-sm text-gray-500">Número: <span class="font-semibold text-green-600">{{ $numeroGenerado }}</span></p>
            </div>
            <a href="{{ route('biopsias.mascotas.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
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

        <form action="{{ route('biopsias.mascotas.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Datos Básicos (2 columnas) -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Datos Básicos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Fecha -->
                    <div>
                        <label for="fecha_recibida" class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha de Recepción <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="fecha_recibida" name="fecha_recibida"
                            value="{{ old('fecha_recibida', date('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                    </div>

                    <!-- Mascota -->
                    <div>
                        <label for="mascota_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Mascota <span class="text-red-500">*</span>
                        </label>
                        <select id="mascota_id" name="mascota_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Seleccionar...</option>
                            @foreach($mascotas as $mascota)
                            <option value="{{ $mascota->id }}" {{ old('mascota_id') == $mascota->id ? 'selected' : '' }}>
                                {{ $mascota->nombre }} - {{ $mascota->propietario }} ({{ $mascota->edad }} años)
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Doctor -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Doctor <span class="text-red-500">*</span>
                        </label>
                        <select id="doctor_id" name="doctor_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Seleccionar...</option>
                            @foreach($doctores as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Diagnóstico Clínico -->
                    <div class="md:col-span-2">
                        <label for="diagnostico_clinico" class="block text-sm font-medium text-gray-700 mb-1">
                            Diagnóstico Clínico <span class="text-red-500">*</span>
                        </label>
                        <textarea id="diagnostico_clinico" name="diagnostico_clinico" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                            placeholder="Describa el diagnóstico clínico..."
                            required>{{ old('diagnostico_clinico') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 2. Plantilla (opcional - colapsable) -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg overflow-hidden">
                <button type="button" onclick="togglePlantilla()" class="w-full px-6 py-4 flex justify-between items-center hover:bg-yellow-100">
                    <span class="font-medium text-gray-900">
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
                        <!-- Búsqueda por código -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Buscar por Código</label>
                            <div class="flex gap-2">
                                <input type="text" id="buscar_codigo"
                                    placeholder="Ej: L001"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md uppercase">
                                <button type="button" id="btn_buscar_codigo"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    Buscar
                                </button>
                            </div>
                        </div>

                        <!-- Selector -->
                        <div>
                            <label for="lista_id" class="block text-sm font-medium text-gray-700 mb-1">O selecciona</label>
                            <select id="lista_id" name="lista_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                <option value="">-- Sin plantilla --</option>
                                @foreach($listas as $lista)
                                <option value="{{ $lista->id }}">{{ $lista->codigo }} - {{ $lista->diagnostico }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Análisis Detallado (opcional - colapsable) -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg overflow-hidden">
                <button type="button" onclick="toggleAnalisis()" class="w-full px-6 py-4 flex justify-between items-center hover:bg-blue-100">
                    <span class="font-medium text-gray-900">
                        <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                        Análisis Detallado (Opcional)
                    </span>
                    <svg id="icon-analisis" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="analisis-content" class="hidden px-6 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="diagnostico" class="block text-sm font-medium text-gray-700 mb-1">Diagnóstico Final</label>
                            <textarea id="diagnostico" name="diagnostico" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                placeholder="Diagnóstico detallado...">{{ old('diagnostico') }}</textarea>
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción General</label>
                            <textarea id="descripcion" name="descripcion" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                placeholder="Descripción de la muestra...">{{ old('descripcion') }}</textarea>
                        </div>

                        <div>
                            <label for="macroscopico" class="block text-sm font-medium text-gray-700 mb-1">Análisis Macroscópico</label>
                            <textarea id="macroscopico" name="macroscopico" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                placeholder="Observación macroscópica...">{{ old('macroscopico') }}</textarea>
                        </div>

                        <div>
                            <label for="microscopico" class="block text-sm font-medium text-gray-700 mb-1">Análisis Microscópico</label>
                            <textarea id="microscopico" name="microscopico" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                placeholder="Observación microscópica...">{{ old('microscopico') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción (sticky bottom) -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg">
                <a href="{{ route('biopsias.mascotas.index') }}"
                    class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="reset"
                    class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Limpiar
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium">
                    Guardar Biopsia
                </button>
            </div>
        </form>
    </div>

    <script>
        // Toggle secciones colapsables
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

        // Búsqueda por código
        document.getElementById('btn_buscar_codigo').addEventListener('click', function() {
            const codigo = document.getElementById('buscar_codigo').value.trim().toUpperCase();
            if (!codigo) {
                alert('Ingresa un código');
                return;
            }

            this.disabled = true;
            this.textContent = 'Buscando...';

            fetch(`/biopsias-mascotas/buscar-lista-codigo/${codigo}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const data = result.data;
                        document.getElementById('diagnostico').value = data.diagnostico || '';
                        document.getElementById('descripcion').value = data.descripcion || '';
                        document.getElementById('microscopico').value = data.microscopico || '';
                        document.getElementById('macroscopico').value = data.macroscopico || '';
                        document.getElementById('lista_id').value = data.id;

                        // Auto-abrir análisis
                        if (document.getElementById('analisis-content').classList.contains('hidden')) {
                            toggleAnalisis();
                        }

                        alert(`Plantilla "${data.codigo}" cargada`);
                    } else {
                        alert(`Código "${codigo}" no encontrado`);
                    }
                })
                .catch(() => alert('Error al buscar'))
                .finally(() => {
                    this.disabled = false;
                    this.textContent = 'Buscar';
                });
        });

        // Enter en búsqueda
        document.getElementById('buscar_codigo').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('btn_buscar_codigo').click();
            }
        });

        // Auto-llenar desde dropdown
        document.getElementById('lista_id').addEventListener('change', function() {
            const listaId = this.value;
            if (!listaId) return;

            document.getElementById('buscar_codigo').value = '';

            fetch(`/biopsias-mascotas/buscar-lista/${listaId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('diagnostico').value = data.diagnostico || '';
                    document.getElementById('descripcion').value = data.descripcion || '';
                    document.getElementById('microscopico').value = data.microscopico || '';
                    document.getElementById('macroscopico').value = data.macroscopico || '';

                    if (document.getElementById('analisis-content').classList.contains('hidden')) {
                        toggleAnalisis();
                    }
                });
        });
    </script>
</x-app-layout>