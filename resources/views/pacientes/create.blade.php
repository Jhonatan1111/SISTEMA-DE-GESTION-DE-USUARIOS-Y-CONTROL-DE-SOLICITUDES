<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">Crear Nuevo Paciente</h1>
                <p class="text-sm text-gray-500 mt-1">Complete los datos del nuevo paciente</p>
            </div>
            <a href="{{ route('pacientes.index') }}" class="text-gray-600 hover:text-gray-900">
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

        <form action="{{ route('pacientes.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Información Personal Obligatoria -->
            <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">
                    Información Personal
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" maxlength="255" placeholder="Nombre del paciente"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all" required>
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-1">Apellido <span class="text-red-500">*</span></label>
                        <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" maxlength="255" placeholder="Apellido del paciente"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all" required>
                    </div>

                    <div>
                        <label for="dui" class="block text-sm font-semibold text-gray-700 mb-1">DUI </label>
                        <input type="text" id="dui" name="dui" value="{{ old('dui') }}" placeholder="DUI" class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                    </div>

                 

                    <div>
                        <label for="sexo" class="block text-sm font-semibold text-gray-700 mb-1">Sexo <span class="text-red-500">*</span></label>
                        <select id="sexo" name="sexo" class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all" required>
                            <option value="">Seleccione sexo</option>
                            <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>

                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="estado_civil" class="block text-sm font-semibold text-gray-700 mb-1">Estado Civil</label>
                        <input type="text" id="estado_civil" name="estado_civil" value="{{ old('estado_civil') }}" placeholder="Estado Civil" class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="ocupacion" class="block text-sm font-semibold text-gray-700 mb-1">Ocupación</label>
                        <input type="text" id="ocupacion" name="ocupacion" value="{{ old('ocupacion') }}" placeholder="Ocupación" class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="celular" class="block text-sm font-semibold text-gray-700 mb-1">Celular </label>
                        <input type="text" id="celular" name="celular" value="{{ old('celular') }}" placeholder="Ej: 78901234" maxlength="8" class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all" >
                    </div>
                </div>
            </div>

            <!-- Información Opcional -->
            <div class="bg-gradient-to-r from-green-50 via-white to-green-50 p-6 rounded-2xl shadow-xl border border-green-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">
                    Información Opcional
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="correo" class="block text-sm font-semibold text-gray-700 mb-1">Correo</label>
                        <input type="email" id="correo" name="correo" value="{{ old('correo') }}" placeholder="Ej: paciente@ejemplo.com" class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
                        <textarea id="direccion" name="direccion" rows="3" maxlength="500" placeholder="Dirección completa del paciente..." class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all">{{ old('direccion') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg rounded-lg">
                <a href="{{ route('pacientes.index') }}" class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                    Guardar Paciente
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
