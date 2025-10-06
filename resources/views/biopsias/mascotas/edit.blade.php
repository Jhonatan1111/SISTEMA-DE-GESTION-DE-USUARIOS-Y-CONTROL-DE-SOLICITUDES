<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Navegación -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                <a href="{{ route('biopsias.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Biopsias
                </a>
                <a href="{{ route('biopsias.personas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Personas
                </a>
                <a href="{{ route('biopsias.mascotas.index') }}"
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Mascotas
                </a>
            </nav>
        </div>

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Editar Biopsia</h1>
            <p class="text-gray-600 mt-1">Biopsia N° {{ $biopsia->nbiopsia }}</p>
        </div>

        <!-- Errores -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <div class="font-bold mb-2">Corrige los siguientes errores:</div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Formulario -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('biopsias.mascotas.update', $biopsia->nbiopsia) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Número (disabled) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Número de Biopsia
                        </label>
                        <input type="text" value="{{ $biopsia->nbiopsia }}" disabled
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                    </div>

                    <!-- Fecha -->
                    <div>
                        <label for="fecha_recibida" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha Recibida <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="fecha_recibida" name="fecha_recibida"
                            value="{{ old('fecha_recibida', $biopsia->fecha_recibida->format('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <!-- Mascota -->
                    <div>
                        <label for="mascota_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Mascota <span class="text-red-500">*</span>
                        </label>
                        <select id="mascota_id" name="mascota_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Seleccione una mascota</option>
                            @foreach($mascotas as $mascota)
                            <option value="{{ $mascota->id }}"
                                {{ old('mascota_id', $biopsia->mascota_id) == $mascota->id ? 'selected' : '' }}>
                                {{ $mascota->nombre }} - {{ $mascota->propietario }} ({{ $mascota->edad }} años)
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Doctor -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Doctor <span class="text-red-500">*</span>
                        </label>
                        <select id="doctor_id" name="doctor_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Seleccione un doctor</option>
                            @foreach($doctores as $doctor)
                            <option value="{{ $doctor->id }}"
                                {{ old('doctor_id', $biopsia->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Diagnóstico Clínico -->
                <div class="mt-6">
                    <label for="diagnostico_clinico" class="block text-sm font-medium text-gray-700 mb-2">
                        Diagnóstico Clínico <span class="text-red-500">*</span>
                    </label>
                    <textarea id="diagnostico_clinico" name="diagnostico_clinico" rows="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>{{ old('diagnostico_clinico', $biopsia->diagnostico_clinico) }}</textarea>
                </div>

                <!-- Plantilla de Lista -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-3">
                        <i class="fas fa-clipboard-list mr-2"></i>Plantilla de Lista (Opcional)
                    </h3>
                    <p class="text-sm text-yellow-700 mb-4">
                        Busca por código o selecciona una plantilla para actualizar los campos de análisis.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Búsqueda por código -->
                        <div>
                            <label for="buscar_codigo" class="block text-sm font-medium text-gray-700 mb-2">
                                Buscar por Código
                            </label>
                            <div class="flex gap-2">
                                <input type="text"
                                    id="buscar_codigo"
                                    placeholder="Ej: L001..."
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg uppercase"
                                    style="text-transform: uppercase;">
                                <button type="button" id="btn_buscar_codigo"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>

                        <!-- Selector dropdown -->
                        <div>
                            <label for="lista_id" class="block text-sm font-medium text-gray-700 mb-2">
                                O selecciona de la lista
                            </label>
                            <select id="lista_id" name="lista_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">-- Sin plantilla --</option>
                                @foreach($listas as $lista)
                                <option value="{{ $lista->id }}"
                                    {{ old('lista_id', $biopsia->lista_id) == $lista->id ? 'selected' : '' }}>
                                    {{ $lista->codigo }} - {{ $lista->diagnostico }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Campos de Análisis Detallado -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">
                        <i class="fas fa-microscope mr-2"></i>Análisis Detallado
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Diagnóstico Final -->
                        <div>
                            <label for="diagnostico" class="block text-sm font-medium text-gray-700 mb-2">
                                Diagnóstico Final
                            </label>
                            <textarea id="diagnostico" name="diagnostico" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                placeholder="Diagnóstico detallado...">{{ old('diagnostico', $biopsia->diagnostico) }}</textarea>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción General
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                placeholder="Descripción de la muestra...">{{ old('descripcion', $biopsia->descripcion) }}</textarea>
                        </div>

                        <!-- Macroscópico -->
                        <div>
                            <label for="macroscopico" class="block text-sm font-medium text-gray-700 mb-2">
                                Análisis Macroscópico
                            </label>
                            <textarea id="macroscopico" name="macroscopico" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                placeholder="Observación macroscópica...">{{ old('macroscopico', $biopsia->macroscopico) }}</textarea>
                        </div>

                        <!-- Microscópico -->
                        <div>
                            <label for="microscopico" class="block text-sm font-medium text-gray-700 mb-2">
                                Análisis Microscópico
                            </label>
                            <textarea id="microscopico" name="microscopico" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                placeholder="Observación microscópica...">{{ old('microscopico', $biopsia->microscopico) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-between mt-8 pt-6 border-t">
                    <a href="{{ route('biopsias.mascotas.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Buscar lista por dropdown
        document.getElementById('lista_id').addEventListener('change', function() {
            const listaId = this.value;
            if (listaId) {
                cargarLista(`/biopsias-mascotas/buscar-lista/${listaId}`);
                document.getElementById('buscar_codigo').value = '';
            }
        });

        // Buscar por código
        document.getElementById('btn_buscar_codigo').addEventListener('click', function() {
            const codigo = document.getElementById('buscar_codigo').value.trim().toUpperCase();
            if (codigo) {
                cargarListaPorCodigo(codigo);
            } else {
                alert('Por favor ingresa un código');
            }
        });

        // Enter en campo de búsqueda
        document.getElementById('buscar_codigo').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('btn_buscar_codigo').click();
            }
        });

        function cargarListaPorCodigo(codigo) {
            const btn = document.getElementById('btn_buscar_codigo');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

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
                        mostrarNotificacion(`Plantilla "${data.codigo}" cargada`, 'success');
                    } else {
                        mostrarNotificacion(`Código "${codigo}" no encontrado`, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al buscar', 'error');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-search"></i> Buscar';
                });
        }

        function cargarLista(url) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('diagnostico').value = data.diagnostico || '';
                    document.getElementById('descripcion').value = data.descripcion || '';
                    document.getElementById('microscopico').value = data.microscopico || '';
                    document.getElementById('macroscopico').value = data.macroscopico || '';
                    mostrarNotificacion(`Plantilla "${data.codigo}" cargada`, 'success');
                })
                .catch(error => console.error('Error:', error));
        }

        function mostrarNotificacion(mensaje, tipo) {
            const color = tipo === 'success' ? 'green' : 'red';
            const alert = document.createElement('div');
            alert.className = `bg-${color}-100 border border-${color}-400 text-${color}-700 px-4 py-3 rounded mb-4`;
            alert.textContent = mensaje;
            document.querySelector('form').insertAdjacentElement('beforebegin', alert);
            setTimeout(() => alert.remove(), 3000);
        }
    </script>
</x-app-layout>