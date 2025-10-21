<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">Nueva Biopsia - Mascota</h1>
                <p class="text-sm text-gray-500 mt-1">Número: <span id="numero_biopsia_header" class="font-semibold text-green-600">—</span></p>
                <div id="tipo_badge" class="mt-2"></div>
            </div>
            <a href="{{ route('biopsias.mascotas.index') }}" class="text-gray-600 hover:text-gray-900">
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

        <!-- Formulario (oculto hasta seleccionar tipo) -->
        <div id="formulario-container" style="display: none;">
            <form action="{{ route('biopsias.mascotas.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo oculto para tipo -->
                <input type="hidden" name="tipo" id="tipo_seleccionado">

                <!-- Datos Básicos -->
                <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                    <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">Datos Básicos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Número de Biopsia (solo visual) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Número de Biopsia</label>
                            <input type="text" id="numero_biopsia_display" readonly
                                class="w-full px-4 py-2 bg-gray-100 border-2 border-gray-300 rounded-lg cursor-not-allowed text-gray-600 font-semibold">
                            <p class="mt-1 text-xs text-gray-500"><span id="prefijo_info"></span></p>
                            <button type="button" onclick="cambiarTipo()" class="mt-2 text-sm text-blue-600 hover:text-blue-800 underline">Cambiar tipo</button>
                        </div>

                        <!-- Fecha Recibida -->
                        <div>
                            <label for="fecha_recibida" class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Recepción <span class="text-red-500">*</span></label>
                            <input type="date" id="fecha_recibida" name="fecha_recibida"
                                value="{{ old('fecha_recibida', date('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                required>
                        </div>

                        <!-- Mascota -->
                        <div>
                            <label for="mascota_id" class="block text-sm font-semibold text-gray-700 mb-1">Mascota <span class="text-red-500">*</span></label>
                            <select id="mascota_id" name="mascota_id"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
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
                            <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-1">Doctor <span class="text-red-500">*</span></label>
                            <select id="doctor_id" name="doctor_id"
                                class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                required>
                                <option value="">Seleccionar...</option>
                                @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->nombre }} {{ $doctor->apellido }} - JVPM: {{ $doctor->jvpm }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Diagnóstico Clínico -->
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
                                <label for="diagnostico" class="block text-sm font-semibold text-gray-700 mb-1">Diagnóstico Final</label>
                                <textarea id="diagnostico" name="diagnostico" rows="3"
                                    class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                    placeholder="Diagnóstico detallado...">{{ old('diagnostico') }}</textarea>
                            </div>

                            <div>
                                <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">Descripción General</label>
                                <textarea id="descripcion" name="descripcion" rows="3"
                                    class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                    placeholder="Descripción de la muestra...">{{ old('descripcion') }}</textarea>
                            </div>

                            <div>
                                <label for="macroscopico" class="block text-sm font-semibold text-gray-700 mb-1">Análisis Macroscópico</label>
                                <textarea id="macroscopico" name="macroscopico" rows="3"
                                    class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                    placeholder="Observación macroscópica...">{{ old('macroscopico') }}</textarea>
                            </div>

                            <div>
                                <label for="microscopico" class="block text-sm font-semibold text-gray-700 mb-1">Análisis Microscópico</label>
                                <textarea id="microscopico" name="microscopico" rows="3"
                                    class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                                    placeholder="Observación microscópica...">{{ old('microscopico') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg">
                    <a href="{{ route('biopsias.mascotas.index') }}"
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

    <!-- Modal de Selección de Tipo (solo 2 opciones para Mascotas) -->
    <div id="modal-tipo" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-xl w-full mx-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">¿Qué tipo de biopsia desea crear?</h2>
            <p class="text-gray-600 text-center mb-6">Seleccione el tipo para generar el número correlativo correspondiente</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Biopsia Mascota Normal -->
                <button type="button" onclick="seleccionarTipo('mascota-normal')"
                    class="p-6 border-2 border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all">
                    <div class="text-4xl mb-2 text-center">🐾</div>
                    <h3 class="text-lg font-bold text-gray-900 text-center">Biopsia Normal</h3>
                    <p class="text-xs text-green-600 font-mono text-center mt-2">BMN2025-0001</p>
                </button>

                <!-- Biopsia Mascota Líquida -->
                <button type="button" onclick="seleccionarTipo('mascota-liquida')"
                    class="p-6 border-2 border-gray-300 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition-all">
                    <div class="text-4xl mb-2 text-center">💧🐾</div>
                    <h3 class="text-lg font-bold text-gray-900 text-center">Biopsia Líquida</h3>
                    <p class="text-xs text-orange-600 font-mono text-center mt-2">BML2025-0001</p>
                </button>
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('biopsias.mascotas.index') }}" class="text-gray-500 hover:text-gray-700 text-sm underline">Cancelar y volver</a>
            </div>
        </div>
    </div>

    <script>
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

        // Buscar plantilla por código
        document.getElementById('btn_buscar_codigo').addEventListener('click', function() {
            const codigo = document.getElementById('buscar_codigo').value.trim().toUpperCase();
            if (!codigo) { alert('Ingresa un código'); return; }

            this.disabled = true;
            this.textContent = 'Buscando...';

            fetch(`/biopsias-mascotas/buscar-lista-codigo/${codigo}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        const data = result.data;
                        document.getElementById('diagnostico').value = data.diagnostico || '';
                        document.getElementById('descripcion').value = data.descripcion || '';
                        document.getElementById('microscopico').value = data.microscopico || '';
                        document.getElementById('macroscopico').value = data.macroscopico || '';
                        document.getElementById('lista_id').value = data.id;
                        if (document.getElementById('analisis-content').classList.contains('hidden')) toggleAnalisis();
                        alert(`Plantilla "${data.codigo}" cargada`);
                    } else { alert(`Código "${codigo}" no encontrado`); }
                })
                .catch(() => alert('Error al buscar'))
                .finally(() => { this.disabled = false; this.textContent = 'Buscar'; });
        });

        // Enter para buscar por código
        document.getElementById('buscar_codigo').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); document.getElementById('btn_buscar_codigo').click(); }
        });

        // Cargar plantilla al seleccionar de la lista
        document.getElementById('lista_id').addEventListener('change', function() {
            const listaId = this.value;
            if (!listaId) return;
            document.getElementById('buscar_codigo').value = '';
            fetch(`/biopsias-mascotas/buscar-lista/${listaId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('diagnostico').value = data.diagnostico || '';
                    document.getElementById('descripcion').value = data.descripcion || '';
                    document.getElementById('microscopico').value = data.microscopico || '';
                    document.getElementById('macroscopico').value = data.macroscopico || '';
                    if (document.getElementById('analisis-content').classList.contains('hidden')) toggleAnalisis();
                });
        });

        // Seleccionar tipo de biopsia y obtener número correlativo
        async function seleccionarTipo(tipo) {
            try {
                const response = await fetch(`/api/biopsias/obtener-numero/${tipo}`);
                const data = await response.json();

                if (data.success) {
                    const tipoBase = tipo.includes('liquida') ? 'liquida' : 'normal';
                    document.getElementById('tipo_seleccionado').value = tipoBase;

                    // Mostrar número generado
                    document.getElementById('numero_biopsia_display').value = data.numero;
                    document.getElementById('numero_biopsia_header').textContent = data.numero;

                    // Actualizar badge y prefijo
                    const tipoBadge = document.getElementById('tipo_badge');
                    if (tipo === 'mascota-liquida') {
                        tipoBadge.innerHTML = '<span class="inline-flex items-center bg-orange-100 text-orange-800 px-4 py-2 rounded-full text-sm font-semibold">💧🐾 Biopsia Líquida</span>';
                        document.getElementById('prefijo_info').textContent = 'Prefijo BML = Biopsia Mascota Líquida';
                    } else {
                        tipoBadge.innerHTML = '<span class="inline-flex items-center bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">🐾 Biopsia Normal</span>';
                        document.getElementById('prefijo_info').textContent = 'Prefijo BMN = Biopsia Mascota Normal';
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

        function cambiarTipo() {
            if (confirm('¿Está seguro que desea cambiar el tipo de biopsia? Se generará un nuevo número correlativo.')) {
                document.getElementById('modal-tipo').style.display = 'flex';
                document.getElementById('formulario-container').style.display = 'none';
                document.getElementById('numero_biopsia_header').textContent = '—';
                document.getElementById('tipo_badge').innerHTML = '';
                document.getElementById('numero_biopsia_display').value = '';
                document.getElementById('prefijo_info').textContent = '';
            }
        }

        // Mostrar modal al cargar la página
        window.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal-tipo').style.display = 'flex';
        });
    </script>
</x-app-layout>