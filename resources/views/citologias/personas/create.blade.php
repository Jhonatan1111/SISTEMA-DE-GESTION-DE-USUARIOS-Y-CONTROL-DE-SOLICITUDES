<x-app-layout>
    <!-- Modal de Selección de Tipo -->
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

    <!-- Modal de Búsqueda de Plantillas  -->
    <div id="modal-plantillas" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 h-[70vh] overflow-hidden flex flex-col">
            <!-- Header del Modal -->
            <div class="flex justify-between items-center p-4 border-b bg-gradient-to-r from-yellow-50 to-orange-50">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Buscar y Seleccionar Plantilla</h3>
                    <p class="text-xs text-gray-600 mt-1">Usa el buscador o navega por las plantillas disponibles</p>
                </div>
                <button type="button" onclick="cerrarModalPlantillas()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-4 flex-1 overflow-y-auto">
                <!-- Buscador -->
                <div class="mb-4 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 rounded-lg border border-blue-200">
                    <div class="flex items-center mb-2">
                        <h4 class="font-semibold text-blue-800 text-sm">Buscador</h4>
                    </div>
                    <input type="text" 
                        id="buscar_plantilla_modal" 
                        placeholder="Buscar por código o diagnóstico..."
                        class="w-full px-3 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-base shadow-sm transition-all"
                        oninput="filtrarPlantillas()">
                </div>

                <!-- Separador -->
                <div class="flex items-center mb-3">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-xs text-gray-500 bg-white">Plantillas Disponibles</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Lista de Plantillas -->
                <div id="lista-plantillas-modal" class="space-y-2 max-h-96 overflow-y-auto border border-gray-200 rounded-lg bg-gray-50 p-2" style="min-height: 350px;">
                    <!-- Se llenará dinámicamente -->
                </div>

                <!-- Mensaje sin resultados -->
                <div id="no-resultados" class="hidden text-center py-8 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 6.75A3.75 3.75 0 0011.25 3a3.75 3.75 0 00-3.75 3.75 0 003.75 3.75A3.75 3.75 0 0015 6.75z"></path>
                    </svg>
                    <p class="text-lg font-medium">No se encontraron plantillas</p>
                    <p class="text-sm">Intenta con otras palabras</p>
                </div>
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
                <input type="hidden" name="lista_id" id="lista_id_hidden">

                <!-- Datos Básicos -->
                <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                    <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">Datos Básicos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tipo seleccionado -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Citología</label>
                            <div id="tipo_badge"
                                 class="w-full px-4 py-1 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
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

                    <div id="plantilla-content" class="hidden px-6 pb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Buscar por Código -->
                            <div>
                                <label for="codigo_plantilla" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Buscar por Código
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" 
                                           id="codigo_plantilla" 
                                           placeholder="EJ: L001"
                                           class="flex-1 px-4 py-2 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all">
                                    <button type="button" 
                                            onclick="buscarPorCodigo()"
                                            class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition-all hover:scale-105">
                                        Buscar
                                    </button>
                                </div>
                            </div>

                            <!-- Selector de Plantilla con botones -->
                            <div>
                                <label for="lista_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    O selecciona plantilla
                                </label>
                                <div class="flex gap-2">
                                    <select id="lista_id" name="lista_id"
                                            class="flex-1 px-4 py-2 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 transition-all">
                                        <option value="">-- Sin plantilla seleccionada --</option>
                                        @foreach($listas as $lista)
                                            <option value="{{ $lista->id }}" 
                                                    data-codigo="{{ $lista->codigo }}"
                                                    {{ old('lista_id') == $lista->id ? 'selected' : '' }}>
                                                {{ $lista->codigo }} - {{ $lista->diagnostico }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" 
                                            onclick="abrirModalPlantillas()"
                                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-all hover:scale-105"
                                            title="Buscar plantilla">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            onclick="limpiarPlantillaSeleccionada()"
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all hover:scale-105"
                                            title="Limpiar selección">
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
                            <label for="diagnostico_clinico" class="block text-sm font-semibold text-gray-700 mb-1">
                                Diagnóstico <span class="text-red-500">*</span>
                            </label>
                            <textarea id="diagnostico_clinico" name="diagnostico_clinico" rows="4"
                                      class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                                      placeholder="Diagnóstico de la muestra..." required>{{ old('diagnostico_clinico') }}</textarea>
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
        const listas = @json($listas);
        let plantillasFiltradas = [...listas];

        // Función para seleccionar tipo y obtener número
        async function seleccionarTipo(tipo) {
            try {
                const response = await fetch(`/citologias/personas/obtener-numero-correlativo?tipo=${tipo}`);
                const data = await response.json();

                if (data.success) {
                    document.getElementById('tipo_seleccionado').value = tipo;
                    document.getElementById('numero_display_header').textContent = data.numero;

                    const tipoBadge = document.getElementById('tipo_badge');
                    if (tipo === 'liquida') {
                        tipoBadge.innerHTML = '<span class="inline-flex text-gray-700 px-4 py-2 text-sm">Citología Líquida</span>';
                        mostrarCampoDoctor();
                    } else if (tipo === 'especial') {
                        tipoBadge.innerHTML = '<span class="inline-flex text-gray-700 px-4 py-2 text-sm">Citología Especial</span>';
                        mostrarCampoRemitente();
                    } else {
                        tipoBadge.innerHTML = '<span class="inline-flex text-gray-700 px-4 py-2 text-sm">Citología Normal</span>';
                        mostrarCampoDoctor();
                    }

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

        function mostrarCampoDoctor() {
            document.getElementById('campo-doctor').style.display = 'block';
            document.getElementById('campo-remitente').style.display = 'none';
            document.getElementById('doctor_id').required = true;
            document.getElementById('remitente_especial').required = false;
            document.getElementById('celular_remitente_especial').required = false;
        }

        function mostrarCampoRemitente() {
            document.getElementById('campo-doctor').style.display = 'none';
            document.getElementById('campo-remitente').style.display = 'block';
            document.getElementById('doctor_id').required = false;
            document.getElementById('remitente_especial').required = true;
            document.getElementById('celular_remitente_especial').required = true;
        }

        function cambiarTipo() {
            if (confirm('¿Está seguro que desea cambiar el tipo de citología? Se generará un nuevo número correlativo.')) {
                document.getElementById('modal-tipo').style.display = 'flex';
                document.getElementById('formulario-container').style.display = 'none';
            }
        }

        function togglePlantilla() {
            const content = document.getElementById('plantilla-content');
            const icon = document.getElementById('icon-plantilla');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // ============ FUNCIONES DEL MODAL DE PLANTILLAS ============
        function abrirModalPlantillas() {
            document.getElementById('modal-plantillas').classList.remove('hidden');
            document.getElementById('buscar_plantilla_modal').value = '';
            plantillasFiltradas = [...listas];
            renderizarPlantillas();
        }

        function cerrarModalPlantillas() {
            document.getElementById('modal-plantillas').classList.add('hidden');
        }

        function buscarPorCodigo() {
            const codigo = document.getElementById('codigo_plantilla').value.trim().toUpperCase();
            
            if (!codigo) {
                alert('Por favor ingrese un código');
                return;
            }
            
            const plantilla = listas.find(p => p.codigo.toUpperCase() === codigo);
            
            if (plantilla) {
                document.getElementById('lista_id').value = plantilla.id;
                document.getElementById('lista_id').dispatchEvent(new Event('change'));
            } else {
                alert('No se encontró plantilla con código: ' + codigo);
            }
        }

        function renderizarPlantillas() {
            const container = document.getElementById('lista-plantillas-modal');
            const noResultados = document.getElementById('no-resultados');
            
            if (plantillasFiltradas.length === 0) {
                container.innerHTML = '';
                noResultados.classList.remove('hidden');
                return;
            }

            noResultados.classList.add('hidden');
            container.innerHTML = plantillasFiltradas.map(plantilla => `
                <div class="p-4 border-2 border-gray-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 cursor-pointer transition-all"
                     onclick="seleccionarPlantilla(${plantilla.id}); cerrarModalPlantillas();">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 mb-1">${plantilla.codigo}</p>
                            <p class="text-sm text-gray-600"><strong>Descripción Macroscópica:</strong> ${plantilla.descripcion || 'N/A'}</p>
                            <p class="text-sm text-gray-600 mt-1"><strong>Diagnóstico:</strong> ${plantilla.diagnostico || 'N/A'}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filtrarPlantillas() {
            const termino = document.getElementById('buscar_plantilla_modal').value.toLowerCase();
            
            plantillasFiltradas = listas.filter(plantilla => {
                return plantilla.codigo.toLowerCase().includes(termino) ||
                       (plantilla.diagnostico && plantilla.diagnostico.toLowerCase().includes(termino)) ||
                       (plantilla.descripcion && plantilla.descripcion.toLowerCase().includes(termino));
            });
            
            renderizarPlantillas();
        }

        function seleccionarPlantilla(id) {
            const plantilla = listas.find(p => p.id == id);
            
            if (plantilla) {
                // Seleccionar en el dropdown
                document.getElementById('lista_id').value = plantilla.id;
                
                // Guardar ID en campo oculto
                document.getElementById('lista_id_hidden').value = plantilla.id;
                
                // Llenar campos del formulario
                document.getElementById('descripcion').value = plantilla.descripcion || '';
                document.getElementById('diagnostico_clinico').value = plantilla.diagnostico || '';
                document.getElementById('macroscopico').value = plantilla.macroscopico || '';
                document.getElementById('microscopico').value = plantilla.microscopico || '';
                
                // Actualizar campo de código
                document.getElementById('codigo_plantilla').value = plantilla.codigo;
                
                // Mostrar plantilla seleccionada
                document.getElementById('plantilla-codigo-sel').textContent = plantilla.codigo;
                document.getElementById('plantilla-diag-sel').textContent = plantilla.diagnostico || 'N/A';
                document.getElementById('plantilla-seleccionada').classList.remove('hidden');
                
                // Cerrar modal
                cerrarModalPlantillas();
                
                // Notificación
                mostrarNotificacion('✓ Plantilla aplicada: ' + plantilla.codigo, 'success');
            }
        }

        function limpiarPlantillaSeleccionada() {
            document.getElementById('lista_id').value = '';
            document.getElementById('lista_id_hidden').value = '';
            document.getElementById('codigo_plantilla').value = '';
            document.getElementById('plantilla-seleccionada').classList.add('hidden');
            
            // Opcional: limpiar los campos si deseas
            if (confirm('¿Desea también limpiar los campos de descripción?')) {
                document.getElementById('descripcion').value = '';
                document.getElementById('diagnostico_clinico').value = '';
            }
            
            mostrarNotificacion('Plantilla removida', 'info');
        }

        // Aplicar plantilla al cambiar el select
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal-tipo').style.display = 'flex';
            
            
            // Al cambiar el select, aplicar plantilla
            document.getElementById('lista_id').addEventListener('change', function() {
                const selectedId = this.value;
                
                if (selectedId) {
                    const plantilla = listas.find(p => p.id == selectedId);
                    if (plantilla) {
                        // Guardar ID
                        document.getElementById('lista_id_hidden').value = plantilla.id;
                        
                        // Llenar campos
                        document.getElementById('descripcion').value = plantilla.descripcion || '';
                        document.getElementById('diagnostico_clinico').value = plantilla.diagnostico || '';
                        
                        // Actualizar código
                        document.getElementById('codigo_plantilla').value = plantilla.codigo;
                        
                        // Mostrar banner
                        document.getElementById('plantilla-codigo-sel').textContent = plantilla.codigo;
                        document.getElementById('plantilla-diag-sel').textContent = plantilla.diagnostico || 'N/A';
                        document.getElementById('plantilla-seleccionada').classList.remove('hidden');
                        
                        mostrarNotificacion('✓ Plantilla aplicada', 'success');
                    }
                } else {
                    document.getElementById('plantilla-seleccionada').classList.add('hidden');
                }
            });
            
            // Buscar por código
            document.getElementById('codigo_plantilla').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const codigo = this.value.trim().toUpperCase();
                    
                    if (!codigo) {
                        alert('Por favor ingrese un código');
                        return;
                    }
                    
                    const plantilla = listas.find(p => p.codigo.toUpperCase() === codigo);
                    
                    if (plantilla) {
                        document.getElementById('lista_id').value = plantilla.id;
                        document.getElementById('lista_id').dispatchEvent(new Event('change'));
                    } else {
                        alert('No se encontró plantilla con código: ' + codigo);
                    }
                }
            });
        });

        // Función para mostrar notificaciones
        function mostrarNotificacion(mensaje, tipo = 'info') {
            const colores = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500'
            };

            const notif = document.createElement('div');
            notif.className = `fixed top-4 right-4 ${colores[tipo]} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in`;
            notif.textContent = mensaje;
            document.body.appendChild(notif);

            setTimeout(() => {
                notif.remove();
            }, 3000);
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modal-plantillas').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalPlantillas();
            }
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</x-app-layout>