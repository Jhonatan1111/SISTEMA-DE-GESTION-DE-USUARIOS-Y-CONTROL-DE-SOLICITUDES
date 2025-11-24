<x-app-layout>
    <!-- Modal de Selección de Tipo -->
    <div id="modal-tipo" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: flex;">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-xl w-full mx-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">¿Qué tipo de citología desea crear?</h2>
            <p class="text-gray-600 text-center mb-6">Seleccione el tipo para generar el número correlativo correspondiente</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- ciotologia normal -->
                <button type="button" onclick="seleccionarTipo('normal')" class="p-6 bg-gradient-to-br from-blue-100 to-blue-50 hover:from-blue-200 hover:to-blue-100 border-2 border-blue-300 hover:border-blue-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="text-center">
                        <span class="text-5xl mb-3 block">
                            <img src="/image/normal.png" alt="Bnormal" class="mx-auto w-12 h-12">
                        </span>
                        <h3 class="text-lg font-bold text-blue-900 mb-1">Normal</h3>
                        <p class="text-sm text-blue-600">CN2025XXXXX</p>
                    </div>
                </button>
                <!-- citologia liquida -->
                <button type="button" onclick="seleccionarTipo('liquida')" class="p-6 bg-gradient-to-br from-purple-100 to-purple-50 hover:from-purple-200 hover:to-purple-100 border-2 border-purple-300 hover:border-purple-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="text-center">
                        <span class="text-5xl mb-3 block">
                            <img src="/image/liquida.png" alt="Bliquida" class="mx-auto w-12 h-12">
                        </span>
                        <h3 class="text-lg font-bold text-purple-900 mb-1">Líquida</h3>
                        <p class="text-sm text-purple-600">CL2025XXXXX</p>
                    </div>
                </button>
                <!-- citologia especial -->
                <button type="button" onclick="seleccionarTipo('especial')" class="p-6 bg-gradient-to-br from-green-100 to-green-50 hover:from-green-200 hover:to-green-100 border-2 border-green-300 hover:border-green-400 rounded-lg transition-all transform hover:scale-105">
                    <div class="text-center">
                        <span class="text-5xl mb-3 block">
                            <img src="/image/especial.png" alt="Bespecial" class="mx-auto w-12 h-12">
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
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Número de Citología</label>
                            <div class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg bg-blue-50 flex items-center">
                                <span class="font-semibold text-green-600" id="numero_display_header"></span>
                            </div>
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
                        <div class="md:col-span-2">
                            <label for="diagnostico_clinico" class="block text-sm font-semibold text-gray-700 mb-1">Diagnóstico Clínico <span class="text-red-500">*</span></label>
                            <textarea id="diagnostico_clinico" name="diagnostico_clinico" rows="3"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                placeholder="Describa el diagnóstico clínico..." required>{{ old('diagnostico_clinico') }}</textarea>
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
                                        Celular del Remitente
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

                    <div id="plantilla-content" class="hidden px-6 pb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Buscar por Código -->
                            <div>
                                <label for="codigo_plantilla" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Buscar por Código
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" id="buscar_codigo" placeholder="Ej: LC001"
                                        class="flex-1 px-4 py-2 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 uppercase transition-all">
                                    <button type="button" id="btn_buscar_codigo"
                                        class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition-all hover:scale-105">
                                        Buscar
                                    </button>
                                </div>
                            </div>

                            <!-- Selector de Plantilla con botones -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">O selecciona plantilla</label>
                                <input type="hidden" id="lista_id" name="lista_id" value="{{ old('lista_id') }}">
                                <div class="flex gap-2">
                                    <input type="text" id="selected_template" readonly class="flex-1 px-4 py-2 border-2 border-yellow-300 rounded-lg bg-gray-50 text-gray-700" placeholder="-- Sin plantilla seleccionada --">
                                    <button type="button" onclick="openTemplateModal()" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-all" title="Buscar plantilla">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" onclick="clearTemplate()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all" title="Limpiar selección">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN: Descripción de la Muestra -->
                <div class="bg-gradient-to-r from-green-50 via-white to-green-50 p-6 rounded-2xl shadow-xl border border-green-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                    <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">Descripción de la Muestra</h2>
                    <div class="space-y-4">
                        <!-- Descripción General -->
                        <div>
                            <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">
                                Descripción <span class="text-red-500">*</span>
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="4"
                                class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                                placeholder="Descripción general de la muestra..." required>{{ old('descripcion') }}</textarea>
                        </div>

                        <!-- Diagnóstico -->
                        <div>
                            <label for="diagnostico" class="block text-sm font-semibold text-gray-700 mb-1">
                                Diagnóstico <span class="text-red-500">*</span>
                            </label>
                            <textarea id="diagnostico" name="diagnostico" rows="4"
                                class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                                placeholder="Diagnóstico de la muestra..." required>{{ old('diagnostico') }}</textarea>
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

    <!-- Modal de búsqueda de plantillas -->
    <div id="template-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 h-[70vh] overflow-hidden flex flex-col">
            <!-- Header del Modal -->
            <div class="flex justify-between items-center p-4 border-b bg-gradient-to-r from-yellow-50 to-orange-50">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Buscar y Seleccionar Plantilla</h3>
                    <p class="text-xs text-gray-600 mt-1">Usa el buscador o navega por las plantillas disponibles</p>
                </div>
                <button type="button" onclick="closeTemplateModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-4 flex-1 overflow-y-auto">
                <!-- Buscador -->
                <div class="mb-4 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 rounded-lg border border-blue-200">
                    <div class="flex items-center mb-2">
                        <h4 class="font-semibold text-blue-800 text-sm">Buscador</h4>
                    </div>
                    <input type="text" id="template-search" placeholder="Buscar por código, descripción o macro..."
                        class="w-full px-3 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-base shadow-sm"
                        oninput="filterTemplates()">

                </div>

                <!-- Separador -->
                <div class="flex items-center mb-3">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-xs text-gray-500 bg-white">Plantillas Disponibles</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Lista de Plantillas -->
                <div id="template-list" class="space-y-2 max-h-96 overflow-y-auto border border-gray-200 rounded-lg bg-gray-50 p-2" style="min-height: 350;">
                    <!-- Mensaje cuando no hay resultados -->
                    <div id="no-results-message" class="text-center py-8 text-gray-500" style="display: none;">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 6.75A3.75 3.75 0 0011.25 3a3.75 3.75 0 00-3.75 3.75 0 003.75 3.75A3.75 3.75 0 0015 6.75z"></path>
                        </svg>
                        <p class="text-lg font-medium">No se encontraron plantillas</p>
                        <p class="text-sm">Intenta con otras palabras como 'anatomía', 'huesos', 'carne'</p>
                    </div>

                    @foreach($listas as $lista)
                    <div class="template-item bg-white border border-gray-200 rounded-lg p-2 mb-2 hover:bg-yellow-50 hover:border-yellow-300 hover:shadow-md cursor-pointer transition-all duración-200"
                        data-codigo="{{ $lista->codigo }}"
                        data-descripcion="{{ $lista->descripcion }}"
                        data-diagnostico="{{ $lista->diagnostico }}"
                        onclick="selectTemplate('{{ $lista->id }}', '{{ $lista->codigo }}', '{{ addslashes($lista->descripcion) }}', '{{ addslashes($lista->diagnostico) }}')">

                        <h4 class="font-semibold text-gray-900 mb-1 text-xs">{{ $lista->descripcion }}</h4>

                        <div class="text-xs text-gray-600 bg-gray-50 p-2 rounded-lg">
                            <strong class="text-gray-700 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Diagnóstico:
                            </strong>
                            <p class="mt-1 leading-relaxed">{{ Str::limit($lista->diagnostico, 100) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- script modal plantilla -->
    <script>
        // Función para seleccionar tipo y obtener número
        async function seleccionarTipo(tipo) {
            try {
                const response = await fetch(`/citologias/personas/obtener-numero-correlativo?tipo=${tipo}`);
                const data = await response.json();

                if (data.success) {
                    // Guardar tipo
                    document.getElementById('tipo_seleccionado').value = tipo;

                    // Mostrar número en Datos Básicos
                    document.getElementById('numero_display_header').textContent = data.numero;

                    // Ocultar modal y mostrar formulario
                    document.getElementById('modal-tipo').style.display = 'none';
                    document.getElementById('formulario-container').style.display = 'block';

                    const campoDoctor = document.getElementById('campo-doctor');
                    const campoRemitente = document.getElementById('campo-remitente');
                    const doctorSelect = document.getElementById('doctor_id');
                    const remitenteInput = document.getElementById('remitente_especial');
                    const celularInput = document.getElementById('celular_remitente_especial');

                    if (tipo === 'especial') {
                        if (campoDoctor) campoDoctor.style.display = 'none';
                        if (doctorSelect) {
                            doctorSelect.removeAttribute('required');
                            doctorSelect.value = '';
                        }
                        if (campoRemitente) campoRemitente.style.display = '';
                        if (remitenteInput) remitenteInput.setAttribute('required', 'required');
                        if (celularInput) celularInput.removeAttribute('required');
                    } else {
                        if (campoDoctor) campoDoctor.style.display = '';
                        if (doctorSelect) doctorSelect.setAttribute('required', 'required');
                        if (campoRemitente) campoRemitente.style.display = 'none';
                        if (remitenteInput) {
                            remitenteInput.removeAttribute('required');
                            remitenteInput.value = '';
                        }
                        if (celularInput) {
                            celularInput.removeAttribute('required');
                            celularInput.value = '';
                        }
                    }
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

        // Buscar por codigo
        document.getElementById('btn_buscar_codigo')?.addEventListener('click', function() {
            const codigo = document.getElementById('buscar_codigo').value.trim().toUpperCase();
            if (!codigo) {
                alert('Por favor ingrese un código');
                return;
            }

            fetch(`{{ url('/citologias/personas/buscar-lista-codigo') }}/${encodeURIComponent(codigo)}`)
                .then(async (response) => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(text || `HTTP ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('lista_id').value = data.data.id;
                        document.getElementById('selected_template').value = data.data.codigo + ' - ' + data.data.descripcion;
                        const descField = document.getElementById('descripcion');
                        const diagField = document.getElementById('diagnostico');
                        const diagClinicoField = document.getElementById('diagnostico_clinico');
                        if (descField) descField.value = data.data.descripcion || '';
                        if (diagField) diagField.value = data.data.diagnostico || '';
                        if (diagClinicoField && !diagClinicoField.value) diagClinicoField.value = data.data.diagnostico || '';

                        if (document.getElementById('analisis-content').classList.contains('hidden')) {
                            toggleAnalisis();
                        }
                    } else {
                        alert('Código no encontrado');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Código no encontrado');
                });
        });

        // Modal de plantillas
        function openTemplateModal() {
            document.getElementById('template-modal').style.display = 'flex';
        }

        function closeTemplateModal() {
            const modals = document.querySelectorAll('#template-modal');
            modals.forEach(m => m.style.display = 'none');
        }

        function selectTemplate(id, codigo, descripcion, diagnostico) {
            document.getElementById('lista_id').value = id;
            document.getElementById('selected_template').value = codigo + ' - ' + descripcion;
            const descField = document.getElementById('descripcion');
            const diagField = document.getElementById('diagnostico');
            const diagClinicoField = document.getElementById('diagnostico_clinico');
            if (descField) descField.value = (descripcion || '').trim();
            if (diagField) diagField.value = (diagnostico || '').trim();
            if (diagClinicoField && !diagClinicoField.value) diagClinicoField.value = (diagnostico || '').trim();

            const plantillaContent = document.getElementById('plantilla-content');
            const iconPlantilla = document.getElementById('icon-plantilla');
            if (plantillaContent && plantillaContent.classList.contains('hidden')) {
                plantillaContent.classList.remove('hidden');
                if (iconPlantilla) iconPlantilla.classList.add('rotate-180');
            }

            closeTemplateModal();
            const analisis = document.getElementById('analisis-content');
            if (analisis && analisis.classList.contains('hidden')) toggleAnalisis();
        }

        function clearTemplate() {
            document.getElementById('lista_id').value = '';
            document.getElementById('selected_template').value = '';
        }



        function filterTemplates() {
            const searchTerm = document.getElementById('template-search').value.toLowerCase().trim();
            const templateItems = document.querySelectorAll('.template-item');
            let visibleCount = 0;

            templateItems.forEach(item => {
                const codigo = (item.dataset.codigo || '').toLowerCase();
                const descripcion = (item.dataset.descripcion || '').toLowerCase();
                const diagnostico = (item.dataset.diagnostico || '').toLowerCase();

                // Solo mostrar resultados si hay texto de búsqueda
                let matches = false;

                if (searchTerm !== '') {
                    // Búsqueda más intuitiva - busca palabras individuales
                    const searchWords = searchTerm.split(' ').filter(word => word.length > 0);

                    // Buscar cada palabra en cualquier campo
                    matches = searchWords.every(word =>
                        codigo.includes(word) ||
                        descripcion.includes(word) ||
                        diagnostico.includes(word)
                    );
                }

                if (matches) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Mostrar mensaje apropiado
            const noResultsMsg = document.getElementById('no-results-message');
            if (searchTerm === '') {
                // Si no hay búsqueda, mostrar mensaje de instrucción
                noResultsMsg.innerHTML = `
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <p class="text-lg font-medium">Escribe para buscar plantillas</p>
                    <p class="text-sm">Usa el buscador arriba para encontrar plantillas por código, diagnóstico o descripción</p>
                `;
                noResultsMsg.style.display = 'block';
            } else if (visibleCount === 0) {
                // Si hay búsqueda pero no resultados
                noResultsMsg.innerHTML = `
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 6.75A3.75 3.75 0 0011.25 3a3.75 3.75 0 00-3.75 3.75 0 003.75 3.75A3.75 3.75 0 0015 6.75z"></path>
                    </svg>
                    <p class="text-lg font-medium">No se encontraron plantillas</p>
                    <p class="text-sm">Intenta con otras palabras como 'anatomía', 'huesos', 'carne'</p>
                `;
                noResultsMsg.style.display = 'block';
            } else {
                noResultsMsg.style.display = 'none';
            }
        }
        // Validación de fecha
        function validarFecha(input) {
            if (!input.value) return true;

            const fechaSeleccionada = new Date(input.value + 'T00:00:00');
            const fechaHoy = new Date();
            fechaHoy.setHours(0, 0, 0, 0);

            if (fechaSeleccionada > fechaHoy) {
                alert('⚠️ La fecha de recepción no puede ser futura.\n\nPor favor selecciona una fecha válida (hoy o anterior).');
                input.style.borderColor = '#ef4444';
                input.focus();
                input.select();
                return false;
            }

            input.style.borderColor = '';
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const fechaInput = document.getElementById('fecha_recibida');

            if (form && fechaInput) {
                form.addEventListener('submit', function(e) {
                    if (!validarFecha(fechaInput)) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                });

                fechaInput.addEventListener('change', function() {
                    validarFecha(this);
                });
            }
        });
    </script>
    <!-- Modal de búsqueda de plantillas -->
    <div id="template-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 h-[70vh] overflow-hidden flex flex-col">
            <div class="flex justify-between items-center p-4 border-b bg-gradient-to-r from-yellow-50 to-orange-50">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Buscar y Seleccionar Plantilla</h3>
                    <p class="text-xs text-gray-600 mt-1">Usa el buscador o navega por las plantillas disponibles</p>
                </div>
                <button type="button" onclick="closeTemplateModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-4 flex-1 overflow-y-auto">
                <div class="mb-4 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 rounded-lg border border-blue-200">
                    <div class="flex items-center mb-2">
                        <h4 class="font-semibold text-blue-800 text-sm">Buscador</h4>
                    </div>
                    <input type="text" id="template-search" placeholder="Buscar por código, descripción o macro..."
                        class="w-full px-3 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-base shadow-sm"
                        oninput="filterTemplates()">
                </div>

                <div class="flex items-center mb-3">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-xs text-gray-500 bg-white">Plantillas Disponibles</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <div id="template-list" class="space-y-2 max-h-96 overflow-y-auto border border-gray-200 rounded-lg bg-gray-50 p-2">
                    <div id="no-results-message" class="text-center py-8 text-gray-500" style="display: none;">
                        <p class="text-lg font-medium">No se encontraron plantillas</p>
                    </div>

                    @foreach($listas as $lista)
                    <div class="template-item bg-white border border-gray-200 rounded-lg p-2 mb-2 hover:bg-yellow-50 hover:border-yellow-300 hover:shadow-md cursor-pointer transition-all duración-200"
                        data-codigo="{{ $lista->codigo }}"
                        data-descripcion="{{ $lista->descripcion }}"
                        data-diagnostico="{{ $lista->diagnostico }}"
                        onclick="selectTemplate('{{ $lista->id }}', '{{ $lista->codigo }}', '{{ addslashes($lista->descripcion) }}', '{{ addslashes($lista->diagnostico) }}')">

                        <h4 class="font-semibold text-gray-900 mb-1 text-xs">{{ $lista->descripcion }}</h4>

                        <div class="text-xs text-gray-600 bg-gray-50 p-2 rounded-lg">
                            <strong class="text-gray-700 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Diagnóstico:
                            </strong>
                            <p class="mt-1 leading-relaxed">{{ Str::limit($lista->diagnostico, 100) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


</x-app-layout>