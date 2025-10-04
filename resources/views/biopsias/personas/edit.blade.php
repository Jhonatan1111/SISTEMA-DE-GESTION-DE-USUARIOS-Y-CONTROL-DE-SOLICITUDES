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
                    class="px-4 py-2 text-sm font-medium bg-white text-gray-900 rounded-md shadow-sm">
                    Personas
                </a>
                <a href="{{ route('mascotas.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-white rounded-md transition-colors">
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
            <form action="{{ route('biopsias.personas.update', $biopsia->nbiopsia) }}" method="POST">
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

                    <!-- Paciente -->
                    <div>
                        <label for="paciente_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Paciente <span class="text-red-500">*</span>
                        </label>
                        <select id="paciente_id" name="paciente_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Seleccione un paciente</option>
                            @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}"
                                {{ old('paciente_id', $biopsia->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->dui }}
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

                <!-- Diagnóstico -->
                <div class="mt-6">
                    <label for="diagnostico_clinico" class="block text-sm font-medium text-gray-700 mb-2">
                        Diagnóstico Clínico <span class="text-red-500">*</span>
                    </label>
                    <textarea id="diagnostico_clinico" name="diagnostico_clinico" rows="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>{{ old('diagnostico_clinico', $biopsia->diagnostico_clinico) }}</textarea>
                </div>

                <!-- Botones -->
                <div class="flex justify-between mt-8 pt-6 border-t">
                    <a href="{{ route('biopsias.personas.index') }}"
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
</x-app-layout>