<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">Editar Citología - Persona</h1>
                <p class="text-sm text-gray-500 mt-1">Número: <span class="font-semibold text-green-600">{{ $citologia->ncitologia }}</span></p>
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

        <form action="{{ route('citologias.personas.update', $citologia->ncitologia) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Datos Básicos -->
            <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">Datos Básicos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo de Citología -->
                    <div>
                        <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Citología <span class="text-red-500">*</span></label>
                        <select id="tipo" name="tipo"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            required>
                            <option value="normal" {{ old('tipo', $citologia->tipo) == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="liquida" {{ old('tipo', $citologia->tipo) == 'liquida' ? 'selected' : '' }}>Líquida</option>
                            <option value="especial" {{ old('tipo', $citologia->tipo) == 'especial' ? 'selected' : '' }}>Especial</option>
                        </select>
                        @error('tipo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fecha_recibida" class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Recepción <span class="text-red-500">*</span></label>
                        <input type="date" id="fecha_recibida" name="fecha_recibida"
                            value="{{ old('fecha_recibida', $citologia->fecha_recibida->format('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            required>
                        @error('fecha_recibida')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="paciente_id" class="block text-sm font-semibold text-gray-700 mb-1">Paciente <span class="text-red-500">*</span></label>
                        <select id="paciente_id" name="paciente_id"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            required>
                            @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}"
                                {{ old('paciente_id', $citologia->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->DUI }}
                            </option>
                            @endforeach
                        </select>
                        @error('paciente_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor (oculto si es especial) -->
                    <div id="campo-doctor">
                        <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-1">Doctor <span class="text-red-500">*</span></label>
                        <select id="doctor_id" name="doctor_id"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                            <option value="">Seleccionar...</option>
                            @foreach($doctores as $doctor)
                            <option value="{{ $doctor->id }}"
                                {{ old('doctor_id', $citologia->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}
                            </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remitente Especial (solo visible si tipo es especial) -->
                    <div id="campo-remitente" class="md:col-span-2" style="display: none;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="remitente_especial" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Remitente Especial <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="remitente_especial" name="remitente_especial"
                                    value="{{ old('remitente_especial', $citologia->remitente_especial) }}"
                                    placeholder="Nombre del remitente..."
                                    class="w-full px-4 py-2 border-2 border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-500 transition-all">
                                @error('remitente_especial')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="celular_remitente_especial" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Celular del Remitente <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="celular_remitente_especial" name="celular_remitente_especial"
                                    value="{{ old('celular_remitente_especial', $citologia->celular_remitente_especial) }}"
                                    placeholder="12345678"
                                    pattern="[0-9]{8}"
                                    maxlength="8"
                                    class="w-full px-4 py-2 border-2 border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-500 transition-all">
                                @error('celular_remitente_especial')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
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
                            <label for="lista_id" class="block text-sm font-semibold text-gray-700 mb-1">O selecciona de la lista</label>
                            <select id="lista_id" name="lista_id"
                                class="w-full px-4 py-2 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all">
                                <option value="">-- Sin plantilla --</option>
                                @foreach($listas as $lista)
                                <option value="{{ $lista->id }}" {{ old('lista_id', $citologia->lista_id) == $lista->id ? 'selected' : '' }}>
                                    {{ $lista->codigo }} - {{ $lista->diagnostico }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descripción de la Muestra -->
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
                            placeholder="Descripción general de la muestra..." required>{{ old('descripcion', $citologia->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Diagnóstico Clínico -->
                    <div>
                        <label for="diagnostico_clinico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Diagnóstico Clínico <span class="text-red-500">*</span>
                        </label>
                        <textarea id="diagnostico_clinico" name="diagnostico_clinico" rows="3"
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                            placeholder="Diagnóstico clínico de la muestra..." required>{{ old('diagnostico_clinico', $citologia->diagnostico_clinico) }}</textarea>
                        @error('diagnostico_clinico')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                        Actualizar Citología
                    </button>
                </div>
        </form>
    </div>

    <script>
        // Función para mostrar campo doctor y ocultar remitente
        function mostrarCampoDoctor() {
            document.getElementById('campo-doctor').style.display = 'block';
            document.getElementById('campo-remitente').style.display = 'none';
            document.getElementById('doctor_id').required = true;
            document.getElementById('remitente_especial').required = false;
            document.getElementById('celular_remitente_especial').required = false;
        }

        // Función para mostrar campo remitente y ocultar doctor
        function mostrarCampoRemitente() {
            document.getElementById('campo-doctor').style.display = 'none';
            document.getElementById('campo-remitente').style.display = 'block';
            document.getElementById('doctor_id').required = false;
            document.getElementById('remitente_especial').required = true;
            document.getElementById('celular_remitente_especial').required = true;
        }

        // Función de toggle para plantilla
        function togglePlantilla() {
            const content = document.getElementById('plantilla-content');
            const icon = document.getElementById('icon-plantilla');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Event listeners al cargar el documento
        document.addEventListener('DOMContentLoaded', function() {
            const tipoSelect = document.getElementById('tipo');

            // Función para manejar el cambio de tipo
            function manejarCambioTipo() {
                const tipo = tipoSelect.value;

                if (tipo === 'especial') {
                    mostrarCampoRemitente();
                } else {
                    mostrarCampoDoctor();
                }
            }

            // Ejecutar al cargar para mostrar el estado correcto
            manejarCambioTipo();

            // Ejecutar cuando cambie el tipo
            tipoSelect.addEventListener('change', manejarCambioTipo);

            // Buscar por código
            document.getElementById('btn_buscar_codigo').addEventListener('click', function() {
                const codigo = document.getElementById('buscar_codigo').value.trim().toUpperCase();
                if (!codigo) {
                    alert('Ingresa un código');
                    return;
                }

                fetch(`/citologias/personas/buscar-lista-codigo/${codigo}`)
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            const data = result.data;

                            // Llenar todos los campos
                            document.getElementById('descripcion').value = data.descripcion || '';
                            document.getElementById('diagnostico_clinico').value = data.diagnostico || '';

                            document.getElementById('lista_id').value = data.id;

                            // Mostrar vista previa
                            document.getElementById('plantilla-descripcion').textContent = data.descripcion || 'N/A';
                            document.getElementById('plantilla-diagnostico').textContent = data.diagnostico || 'N/A';
                            document.getElementById('plantilla-datos').classList.remove('hidden');

                            alert('Plantilla cargada exitosamente');
                        } else {
                            alert(`Código "${codigo}" no encontrado`);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al buscar la plantilla');
                    });
            });

            // Auto-cargar datos al seleccionar de la lista
            document.getElementById('lista_id').addEventListener('change', function() {
                const listaId = this.value;
                const plantillaDatos = document.getElementById('plantilla-datos');

                if (!listaId) {
                    plantillaDatos.classList.add('hidden');
                    return;
                }

                fetch(`/citologias/personas/buscar-lista-id/${listaId}`)
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            const data = result.data;

                            // Llenar los campos
                            if (data.descripcion) {
                                document.getElementById('descripcion').value = data.descripcion;
                            }
                            if (data.diagnostico) {
                                document.getElementById('diagnostico_clinico').value = data.diagnostico;
                            }
                          

                            // Mostrar vista previa
                            document.getElementById('plantilla-descripcion').textContent = data.descripcion || 'N/A';
                            document.getElementById('plantilla-diagnostico').textContent = data.diagnostico || 'N/A';
                           plantillaDatos.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al cargar la plantilla');
                    });
            });
        });
    </script>
</x-app-layout>