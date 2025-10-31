<x-app-layout>
    <div class="container mx-auto px-4 py-6">

          <!-- Navegación separada -->
        <div class="mb-6">
            <nav class="flex space-x-1 bg-blue-300 p-1 rounded-lg">
                <a href="{{ route('listas.biopsias.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Biopsias
                </a>
                <a href="{{ route('listas.citologias.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
                    Citologías
                </a>
                <a href="{{ route('sobres.index') }}"
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Imprimir Sobres
                </a>
            </nav>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Impresión de Sobres</h1>
                <p class="text-gray-600 mt-1">Selecciona un doctor o institución y opcionalmente un paciente para generar e imprimir el sobre.</p>
            </div>
        </div>

        <!-- Contenedor del formulario -->
        <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl mb-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Doctor y Paciente
            </h2>

            <form id="sobreForm" action="{{ route('sobres.generar') }}" method="POST" target="_blank">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <!-- Doctor -->
                    <div>
                        <label for="doctor_nombre" class="block text-sm font-semibold text-gray-700 mb-1">Doctor <span class="text-red-500">*</span></label>
                        <input type="text" name="doctor_nombre" id="doctor_nombre" 
                               class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all" 
                               placeholder="Ej: Dr. Juan Pérez" required>
                    </div>

                    <!-- Paciente -->
                    <div>
                        <label for="paciente_nombre" class="block text-sm font-semibold text-gray-700 mb-1">Paciente <span class="text-gray-400 text-xs">(Opcional)</span></label>
                        <input type="text" name="paciente_nombre" id="paciente_nombre" 
                               class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all" 
                               placeholder="Ej: María López">
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="limpiarFormulario()"
                       class="px-5 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                        Limpiar
                    </button>

                    <button type="button" onclick="validarYEnviar()"
                            class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                        Generar e Imprimir
                    </button>
                </div>
            </form>
        </div>

        <!-- Sección de entrada manual -->
        <div class="bg-gradient-to-r from-yellow-50 via-white to-yellow-50 p-6 rounded-2xl shadow-xl border border-purple-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
            <h2 class="text-2xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Instituciones
            </h2>

            <form id="sobreManualForm" action="{{ route('sobres.generar.manual') }}" method="POST" target="_blank">
                @csrf

                <div class="mb-5">
                    <label for="institucion_nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre de la Institución <span class="text-red-500">*</span></label>
                    <input type="text" name="institucion_nombre" id="institucion_nombre" 
                           class="w-full px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:border-purple-500 transition-all" 
                           placeholder="Ej: Hospital Nacional, Clínica Santa María, etc." required>
                </div>

                <!-- Botones -->
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="limpiarFormularioManual()"
                            class="px-5 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                        Limpiar
                    </button>

                    <button type="button" onclick="validarYEnviarManual()"
                            class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                        Generar e Imprimir
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        function validarYEnviar() {
            const doctorNombre = document.getElementById('doctor_nombre').value.trim();
            
            if (!doctorNombre) {
                alert('Por favor, ingrese el nombre del doctor.');
                return;
            }

            // Si la validación pasa, enviar el formulario
            document.getElementById('sobreForm').submit();
        }

        function limpiarFormulario() {
            document.getElementById('doctor_nombre').value = '';
            document.getElementById('paciente_nombre').value = '';
        }

        function validarYEnviarManual() {
            const institucion = document.getElementById('institucion_nombre').value.trim();
            
            if (!institucion) {
                alert('Por favor, ingrese el nombre de la institución.');
                return;
            }

            // Si la validación pasa, enviar el formulario
            document.getElementById('sobreManualForm').submit();
        }

        function limpiarFormularioManual() {
            document.getElementById('institucion_nombre').value = '';
        }

        function mostrarVistaPrevia() {
            const doctorSelect = document.getElementById('doctor_id');
            const pacienteSelect = document.getElementById('paciente_id');
            const previewContainer = document.getElementById('previewContainer');
            const previewDoctor = document.getElementById('previewDoctor');
            const previewPaciente = document.getElementById('previewPaciente');

            if (!doctorSelect.value) {
                alert('Por favor, seleccione un doctor.');
                return;
            }

            const doctorText = doctorSelect.options[doctorSelect.selectedIndex].text;
            previewDoctor.textContent = 'Dr. ' + doctorText;

            // Si hay paciente seleccionado, mostrarlo
            if (pacienteSelect.value) {
                const pacienteText = pacienteSelect.options[pacienteSelect.selectedIndex].text;
                previewPaciente.textContent = 'Paciente: ' + pacienteText;
                previewPaciente.style.display = 'block';
            } else {
                previewPaciente.style.display = 'none';
            }

            previewContainer.classList.remove('hidden');
            setTimeout(() => {
                previewContainer.classList.remove('opacity-0', 'translate-y-4');
            }, 50);
            previewContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function ocultarVistaPrevia() {
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => previewContainer.classList.add('hidden'), 300);
        }

        document.getElementById('doctor_id').addEventListener('change', ocultarVistaPrevia);
        document.getElementById('paciente_id').addEventListener('change', ocultarVistaPrevia);
    </script>
</x-app-layout>