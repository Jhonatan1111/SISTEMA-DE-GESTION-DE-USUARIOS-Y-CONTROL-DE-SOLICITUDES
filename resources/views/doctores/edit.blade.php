<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-700">Editar Doctor</h1>
                <p class="text-sm text-gray-500 mt-1">Doctor: <span class="font-semibold text-green-600">Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}</span></p>
            </div>
            <a href="{{ route('doctores.index') }}" class="text-gray-600 hover:text-gray-900">
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

        <form action="{{ route('doctores.update', $doctor->id) }}" method="POST" id="formDoctor" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información Profesional -->
            <div class="bg-gradient-to-r from-blue-50 via-white to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-blue-700 mb-4 border-b-2 border-blue-200 pb-2">
                   
                    Información Profesional
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="jvpm" class="block text-sm font-semibold text-gray-700 mb-1">JVPM <span class="text-red-500">*</span></label>
                        <input type="text" id="jvpm" name="jvpm" value="{{ old('jvpm', $doctor->jvpm) }}" maxlength="10"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="Número de JVPM" required autofocus>
                    </div>


                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $doctor->nombre) }}" maxlength="100"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="Nombre del doctor" required>
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-1">Apellido <span class="text-red-500">*</span></label>
                        <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $doctor->apellido) }}" maxlength="100"
                            class="w-full px-4 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all"
                            placeholder="Apellido del doctor" required>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="bg-gradient-to-r from-green-50 via-white to-green-50 p-6 rounded-2xl shadow-xl border border-green-200 transition-transform hover:-translate-y-1 hover:shadow-2xl">
                <h2 class="text-xl font-bold text-green-700 mb-4 border-b-2 border-green-200 pb-2">
                   
                    Información de Contacto (Opcional)
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="celular" class="block text-sm font-semibold text-gray-700 mb-1">Celular</label>
                        <input type="text" id="celular" name="celular" value="{{ old('celular', $doctor->celular) }}" maxlength="8"
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                            placeholder="Ej: 78901234">
                    </div>

                    <div>
                        <label for="correo" class="block text-sm font-semibold text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" value="{{ old('correo', $doctor->correo) }}" maxlength="100"
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                            placeholder="Ej: doctor@ejemplo.com">
                    </div>
                    <div>
                        <label for="fax" class="block text-sm font-semibold text-gray-700 mb-1">Fax</label>
                        <input type="text" id="fax" name="fax" value="{{ old('fax', $doctor->fax) }}" maxlength="11"
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                            placeholder="Número de fax">
                    </div>

                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
                        <textarea id="direccion" name="direccion" rows="3" maxlength="500"
                            class="w-full px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition-all"
                            placeholder="Dirección completa del consultorio o clínica...">{{ old('direccion', $doctor->direccion) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end gap-3 shadow-lg rounded-lg">
                <a href="{{ route('doctores.index') }}"
                    class="px-6 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-transform hover:scale-105">
                    Actualizar Doctor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>