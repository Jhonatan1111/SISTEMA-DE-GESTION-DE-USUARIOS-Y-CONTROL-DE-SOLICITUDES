<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Editar Citología de Persona</h1>
            <p class="text-gray-600 mt-1">Modificar información de la citología {{ $citologia->ncitologia }}</p>
        </div>

        <!-- Formulario -->
        <form action="{{ route('citologias.personas.update', $citologia->ncitologia) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información Básica -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">
                    📋 Información Básica
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Número de Citología -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Número de Citología
                        </label>
                        <input type="text"
                            value="{{ $citologia->ncitologia }}"
                            readonly
                            class="w-full px-4 py-2 bg-gray-100 border-2 border-gray-300 rounded-lg cursor-not-allowed text-gray-600 font-semibold">
                    </div>

                    <!-- Tipo de Citología -->
                    <div>
                        <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-1">
                            Tipo de Citología <span class="text-red-500">*</span>
                        </label>
                        <select id="tipo"
                            name="tipo"
                            required
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            <option value="normal" {{ old('tipo', $citologia->tipo) == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="liquida" {{ old('tipo', $citologia->tipo) == 'liquida' ? 'selected' : '' }}>Líquida</option>
                        </select>
                        @error('tipo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha Recibida -->
                    <div>
                        <label for="fecha_recibida" class="block text-sm font-semibold text-gray-700 mb-1">
                            Fecha Recibida <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                            id="fecha_recibida"
                            name="fecha_recibida"
                            value="{{ old('fecha_recibida', $citologia->fecha_recibida->format('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            required
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        @error('fecha_recibida')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Doctor <span class="text-red-500">*</span>
                        </label>
                        <select id="doctor_id"
                            name="doctor_id"
                            required
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            @foreach($doctores as $doctor)
                            <option value="{{ $doctor->id }}"
                                {{ old('doctor_id', $citologia->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->nombre }} {{ $doctor->apellido }}
                            </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Paciente -->
                    <div class="md:col-span-2">
                        <label for="paciente_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Paciente <span class="text-red-500">*</span>
                        </label>
                        <select id="paciente_id"
                            name="paciente_id"
                            required
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
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
                </div>
            </div>

            <!-- Diagnóstico Clínico -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">
                    🩺 Diagnóstico Clínico
                </h2>

                <div>
                    <label for="diagnostico_clinico" class="block text-sm font-semibold text-gray-700 mb-1">
                        Diagnóstico Clínico <span class="text-red-500">*</span>
                    </label>
                    <textarea id="diagnostico_clinico"
                        name="diagnostico_clinico"
                        rows="4"
                        required
                        class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500">{{ old('diagnostico_clinico', $citologia->diagnostico_clinico) }}</textarea>
                    @error('diagnostico_clinico')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Resultados (Opcional) -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-purple-700 mb-4 border-b-2 border-purple-200 pb-2">
                    📝 Resultados (Opcional)
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="diagnostico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Diagnóstico Final
                        </label>
                        <textarea id="diagnostico"
                            name="diagnostico"
                            rows="3"
                            class="w-full px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-400">{{ old('diagnostico', $citologia->diagnostico) }}</textarea>
                    </div>

                    <div>
                        <label for="macroscopico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Análisis Macroscópico
                        </label>
                        <textarea id="macroscopico"
                            name="macroscopico"
                            rows="3"
                            class="w-full px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-400">{{ old('macroscopico', $citologia->macroscopico) }}</textarea>
                    </div>

                    <div>
                        <label for="microscopico" class="block text-sm font-semibold text-gray-700 mb-1">
                            Análisis Microscópico
                        </label>
                        <textarea id="microscopico"
                            name="microscopico"
                            rows="3"
                            class="w-full px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-400">{{ old('microscopico', $citologia->microscopico) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('citologias.personas.index') }}"
                    class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                    Actualizar Citología
                </button>
            </div>
        </form>
    </div>
</x-app-layout>